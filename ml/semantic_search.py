import os
import pandas as pd
import torch
from sentence_transformers import SentenceTransformer, util
import joblib

# === Paths & base directory ===
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
MODEL_PATH = os.path.join(BASE_DIR, "fine_tuned_similarity_model")
DATA_PATH = os.path.join(BASE_DIR, "sebenarnya_with_links_new.csv")
EMBEDDINGS_PATH = os.path.join(BASE_DIR, "fact_embeddings_updated.pkl")

# === Load fine-tuned model and embeddings ===
model = SentenceTransformer(MODEL_PATH)
fact_embeddings = joblib.load(EMBEDDINGS_PATH)

# === Load dataset ===
df_facts = pd.read_csv(DATA_PATH)
df_facts['title'] = df_facts['title'].fillna('')

def find_similar_facts(user_text, top_k=3, filter_label=None):
    """
    Returns the top_k most similar facts to the user_text.
    
    Parameters:
    - user_text (str): User input text
    - top_k (int): Number of results to return
    - filter_label (str or None): If set (e.g., 'Real'), only consider facts with this label
    
    Returns:
    - List of dicts: [{title, label, similarity}, ...]
    """
    # Optional label filtering
    if filter_label is not None:
        mask = df_facts['label'] == filter_label
        filtered_embeddings = fact_embeddings[mask.values]
        filtered_facts = df_facts[mask].reset_index(drop=True)
    else:
        filtered_embeddings = fact_embeddings
        filtered_facts = df_facts.reset_index(drop=True)

    # Encode user input
    query_embedding = model.encode(user_text, convert_to_tensor=True)

    # Compute cosine similarity
    cosine_scores = util.cos_sim(query_embedding, filtered_embeddings)[0]

    # Get top-k results
    top_results = torch.topk(cosine_scores, k=min(top_k, len(filtered_embeddings)))

    # Prepare output
    similar_facts = []
    for idx, score in zip(top_results.indices, top_results.values):
        similar_facts.append({
            "title": filtered_facts.iloc[idx.item()]['title'],
            "label": filtered_facts.iloc[idx.item()]['label'],
            "similarity": round(float(score), 3)
        })

    return similar_facts
