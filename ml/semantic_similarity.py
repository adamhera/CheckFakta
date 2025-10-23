from sentence_transformers import SentenceTransformer, util
import torch
import pandas as pd

# Load pre-trained model
model = SentenceTransformer('paraphrase-MiniLM-L6-v2')

# Load your fact bank dataset
df_facts = pd.read_csv("sebenarnya_labeledLatest.csv")

# Prepare embeddings for all verified facts
fact_texts = df_facts['title'].fillna('').tolist()
fact_embeddings = model.encode(fact_texts, convert_to_tensor=True)

def find_similar_facts(news_text, top_k=3):
    """
    Compare input news text to verified facts and return the most similar ones.
    """
    query_embedding = model.encode(news_text, convert_to_tensor=True)
    cosine_scores = util.cos_sim(query_embedding, fact_embeddings)[0]
    top_results = torch.topk(cosine_scores, k=top_k)
    
    similar_facts = []
    for idx, score in zip(top_results.indices, top_results.values):
        similar_facts.append({
            "title": df_facts.iloc[idx.item()]['title'],
            "label": df_facts.iloc[idx.item()]['label'],
            "similarity": round(float(score), 3)
        })
    return similar_facts
