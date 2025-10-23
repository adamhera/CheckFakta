# ml/predict.py

import os
import sys
import joblib
import string
import nltk
import pandas as pd
from nltk.corpus import stopwords
from sentence_transformers import SentenceTransformer, util

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

# === Load dataset for fact comparison ===
fact_data = pd.read_csv(os.path.join(BASE_DIR, "sebenarnya_labeledLatest.csv"))
fact_data['title'] = fact_data['title'].fillna('').apply(preprocess_text)

# === Load or initialize SentenceTransformer ===
model = SentenceTransformer('paraphrase-MiniLM-L6-v2')

# Optionally cache embeddings
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
    clean_text = preprocess_text(input_text)

    # === SVM Prediction ===
    try:
        X = tfidf.transform([clean_text])
        y_pred = svm_model.predict(X)
        pred_label = label_encoder.inverse_transform(y_pred)[0]
    except Exception:
        pred_label = "Prediction failed"

    # === Semantic Similarity Check ===
    input_embedding = model.encode(clean_text, convert_to_tensor=True)
    cosine_scores = util.cos_sim(input_embedding, fact_embeddings)[0]

    # Get top 3 most similar news from fact bank
    top_results = cosine_scores.argsort(descending=True)[:3]

    similar_facts = []
    for idx in top_results:
        idx = idx.item()  # convert tensor -> int
        similar_facts.append({
            "fact_title": fact_data.iloc[idx]['title'],
            "fact_label": str(fact_data.iloc[idx]['label']),
            "similarity": float(cosine_scores[idx])
        })

    # === Output as JSON (so Laravel can parse easily) ===
    import json
    output = {
        "svm_result": pred_label,
        "semantic_similarity": similar_facts
    }

    print(json.dumps(output, ensure_ascii=False))
