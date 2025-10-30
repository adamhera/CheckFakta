# ml/predict.py

import os
import sys
import joblib
import string
import nltk
import pandas as pd
from nltk.corpus import stopwords
from sentence_transformers import SentenceTransformer, util
import json

nltk.download('stopwords', quiet=True)

def preprocess_text(text):
    """Lowercase, remove punctuation, and stopwords"""
    if not text:
        return ""
    text = text.lower()
    text = text.translate(str.maketrans('', '', string.punctuation))
    stop_words = set(stopwords.words('indonesian'))  # or 'malay'
    tokens = [word for word in text.split() if word not in stop_words]
    return " ".join(tokens)

# === Load model and vectorizer ===
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
tfidf = joblib.load(os.path.join(BASE_DIR, "tfidf_vectorizerLatest.pkl"))
svm_model = joblib.load(os.path.join(BASE_DIR, "svm_modelLatest.pkl"))
label_encoder = joblib.load(os.path.join(BASE_DIR, "label_encoder.pkl"))

# === Load main dataset for fact comparison ===
fact_data_main = pd.read_csv(os.path.join(BASE_DIR, "sebenarnya_labeledLatest.csv"))
fact_data_main['title'] = fact_data_main['title'].fillna('').apply(preprocess_text)

# === Load new links dataset (use only fact_link) ===
links_data = pd.read_csv(os.path.join(BASE_DIR, "sebenarnya_with_links_new.csv"))
links_data['fact_link'] = links_data.get('fact_link', pd.Series(["https://sebenarnya.my"]*len(links_data)))

# Merge fact_link into main dataset (assumes same row order)
fact_data_main['fact_link'] = links_data['fact_link']
fact_data = fact_data_main  # final dataframe used

# === Load or initialize SentenceTransformer ===
model = SentenceTransformer('paraphrase-multilingual-MiniLM-L12-v2')

# === Hybrid keyword lists ===
fake_keywords = ["palsu", "tidak benar", "fitnah", "maklumat tidak sahih", "tular tidak benar", "tidak sahih"]
real_keywords = ["makluman", "menurut kenyataan", "sahih", "waspada", "berjaga-jaga", "benar", "betul", "penjelasan"]

def hybrid_predict(input_text):
    """Return label and confidence using keywords first, then SVM fallback"""
    text_lower = str(input_text).lower()
    
    # 1️⃣ Keyword-based prediction
    if any(word in text_lower for word in fake_keywords):
        return "Fake", 1.0
    if any(word in text_lower for word in real_keywords):
        return "Real", 1.0
    
    # 2️⃣ Fallback to original SVM prediction
    clean_text = preprocess_text(input_text)
    X = tfidf.transform([clean_text])
    
    # Predict label
    y_pred = svm_model.predict(X)
    label = label_encoder.inverse_transform(y_pred)[0]

    # Predict probability (confidence) if available
    if hasattr(svm_model, "predict_proba"):
        probs = svm_model.predict_proba(X)[0]
        class_index = list(svm_model.classes_).index(y_pred[0])
        confidence = float(probs[class_index])
    else:
        confidence = None

    return label, confidence

# === Cache embeddings for faster similarity ===
embeddings_path = os.path.join(BASE_DIR, "fact_embeddings.pkl")
if os.path.exists(embeddings_path):
    fact_embeddings = joblib.load(embeddings_path)
else:
    fact_embeddings = model.encode(fact_data['title'].tolist(), convert_to_tensor=True)
    joblib.dump(fact_embeddings, embeddings_path)

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("Error: No input text provided")
        sys.exit(1)

    input_text = sys.argv[1]

    # === Use hybrid prediction here ===
    pred_label, confidence = hybrid_predict(input_text)

    # === Semantic Similarity Check ===
    input_embedding = model.encode(preprocess_text(input_text), convert_to_tensor=True)
    cosine_scores = util.cos_sim(input_embedding, fact_embeddings)[0]

    top_results = cosine_scores.argsort(descending=True)[:3]

    similar_facts = []
    for idx in top_results:
        idx = idx.item()
        fact_row = fact_data.iloc[idx]
        fact_link = str(fact_row.get('fact_link', '')).strip()
        if not fact_link or fact_link.lower() == 'nan':
            fact_link = "https://sebenarnya.my"

        similar_facts.append({
            "fact_title": fact_row['title'],
            "fact_label": str(fact_row['label']),
            "similarity": float(cosine_scores[idx]),
            "fact_link": fact_link
        })

    # === Output JSON ===
    output = {
        "svm_result": pred_label,
        "svm_confidence": confidence if confidence is not None else "N/A",
        "semantic_similarity": similar_facts
    }

    print(json.dumps(output, ensure_ascii=False, indent=2))
