import os
import string
import nltk
import pandas as pd
import joblib
from sentence_transformers import SentenceTransformer, util
import torch
from rank_bm25 import BM25Okapi
from fastapi import FastAPI
from pydantic import BaseModel
import json

nltk.download('stopwords', quiet=True)

# === Preprocessing ===
def preprocess_text(text):
    if not text:
        return ""
    text = text.lower()
    text = text.translate(str.maketrans('', '', string.punctuation))
    stop_words = set(nltk.corpus.stopwords.words('indonesian'))  # or 'malay'
    tokens = [word for word in text.split() if word not in stop_words]
    return " ".join(tokens)

# === Paths ===
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
TFIDF_PATH = os.path.join(BASE_DIR, "tfidf_vectorizerLatest.pkl")
SVM_MODEL_PATH = os.path.join(BASE_DIR, "svm_modelLatest.pkl")
LABEL_ENCODER_PATH = os.path.join(BASE_DIR, "label_encoder.pkl")
FACT_DATA_PATH = os.path.join(BASE_DIR, "sebenarnya_with_links_new.csv")
EMBEDDINGS_PATH = os.path.join(BASE_DIR, "fact_embeddings_pretrained.pkl")
MODEL_NAME = "paraphrase-multilingual-MiniLM-L12-v2"

# === Load models once ===
tfidf = joblib.load(TFIDF_PATH)
svm_model = joblib.load(SVM_MODEL_PATH)
label_encoder = joblib.load(LABEL_ENCODER_PATH)

fact_data = pd.read_csv(FACT_DATA_PATH)
fact_data['title'] = fact_data['title'].fillna('')
fact_data['fact_link'] = fact_data.get('fact_link', pd.Series(["https://sebenarnya.my"]*len(fact_data)))
fact_data['fact_link'] = fact_data['fact_link'].fillna("https://sebenarnya.my")
tokenized_titles = [preprocess_text(t).split() for t in fact_data['title']]

model = SentenceTransformer(MODEL_NAME)
if os.path.exists(EMBEDDINGS_PATH):
    fact_embeddings = joblib.load(EMBEDDINGS_PATH)
else:
    fact_embeddings = model.encode(fact_data['title'].tolist(), convert_to_tensor=True)
    joblib.dump(fact_embeddings, EMBEDDINGS_PATH)

# === Labels & keywords ===
LABEL_MAPPING = {"Real":"Benar","Fake":"Palsu","Unclear":"Tidak Jelas"}
fake_keywords = ["palsu","tidak benar","fitnah","maklumat tidak sahih","tular tidak benar","tidak sahih"]
real_keywords = ["makluman","menurut kenyataan","sahih","waspada","berjaga-jaga","benar","betul","penjelasan"]

# === FastAPI setup ===
app = FastAPI()

class TextInput(BaseModel):
    text: str

# === Prediction function ===
def hybrid_predict(input_text):
    text_lower = str(input_text).lower()
    if any(word in text_lower for word in fake_keywords):
        return "Fake", 1.0
    if any(word in text_lower for word in real_keywords):
        return "Real", 1.0
    clean_text = preprocess_text(input_text)
    X = tfidf.transform([clean_text])
    y_pred = svm_model.predict(X)
    label = label_encoder.inverse_transform(y_pred)[0]
    if hasattr(svm_model, "predict_proba"):
        probs = svm_model.predict_proba(X)[0]
        class_index = list(svm_model.classes_).index(y_pred[0])
        confidence = float(probs[class_index])
    else:
        confidence = None
    return label, confidence

def semantic_search(input_text, top_k=3, predicted_label=None):
    query_clean = preprocess_text(input_text)
    query_tokens = query_clean.split()
    bm25_scores_raw = BM25Okapi(tokenized_titles).get_scores(query_tokens)
    max_bm25 = max(bm25_scores_raw) if max(bm25_scores_raw) > 0 else 1
    bm25_scores = [s / max_bm25 for s in bm25_scores_raw]
    top_sparse_idx = sorted(range(len(bm25_scores)), key=lambda i: bm25_scores[i], reverse=True)[:50]
    top_embeddings = fact_embeddings[top_sparse_idx]
    query_embedding = model.encode(input_text, convert_to_tensor=True)
    dense_scores = util.cos_sim(query_embedding, top_embeddings)[0]
    combined_scores = torch.tensor([0.5 * bm25_scores[i] + 0.5 * dense_scores[j].item() for j,i in enumerate(top_sparse_idx)])
    for j,i in enumerate(top_sparse_idx):
        if input_text.lower() in fact_data.iloc[i]['title'].lower():
            combined_scores[j] = 1.0
    if predicted_label:
        for j,i in enumerate(top_sparse_idx):
            if fact_data.iloc[i]['label'] == predicted_label:
                combined_scores[j] = min(1.0, combined_scores[j]*1.1)
    top_results_idx = torch.topk(combined_scores, k=min(top_k,len(combined_scores)))
    results = []
    for rank, score in zip(top_results_idx.indices, top_results_idx.values):
        idx = top_sparse_idx[rank.item()]
        fact_row = fact_data.iloc[idx]
        fact_link = fact_row.get('fact_link', "https://sebenarnya.my")
        if not fact_link or str(fact_link).lower()=='nan':
            fact_link = "https://sebenarnya.my"
        results.append({
            "fact_title": fact_row['title'],
            "fact_label": LABEL_MAPPING.get(fact_row['label'], fact_row['label']),
            "similarity": round(float(score),3),
            "fact_link": fact_link
        })
    return results

# === FastAPI route ===
@app.post("/predict")
def predict(input: TextInput):
    pred_label, confidence = hybrid_predict(input.text)
    similar_facts = semantic_search(input.text, top_k=3, predicted_label=pred_label)
    output = {
        "svm_result": LABEL_MAPPING.get(pred_label, pred_label),
        "svm_confidence": confidence if confidence is not None else "N/A",
        "semantic_similarity": similar_facts
    }
    return output
