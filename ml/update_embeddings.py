import os
import joblib
import pandas as pd
from sentence_transformers import SentenceTransformer
import torch

BASE_DIR = os.path.dirname(os.path.abspath(__file__))
model = SentenceTransformer('paraphrase-multilingual-MiniLM-L12-v2')

# === Load the latest dataset ===
fact_data = pd.read_csv(os.path.join(BASE_DIR, "sebenarnya_with_links_new.csv"))
fact_data['title'] = fact_data['title'].fillna('')

# === Paths ===
embeddings_path = os.path.join(BASE_DIR, "fact_embeddings.pkl")
updated_embeddings_path = os.path.join(BASE_DIR, "fact_embeddings_updated.pkl")

# === Load existing embeddings if available ===
if os.path.exists(embeddings_path):
    old_embeddings = joblib.load(embeddings_path)
    print(f"✅ Loaded existing embeddings: {old_embeddings.shape[0]} rows")
else:
    old_embeddings = torch.tensor([])
    print("⚠️ No existing embeddings found, starting fresh")

# === Detect new rows ===
old_count = old_embeddings.shape[0] if old_embeddings.numel() > 0 else 0
new_rows = fact_data.iloc[old_count:]

if new_rows.empty:
    print("✅ No new rows found. Nothing to update.")
else:
    print(f"🆕 Found {len(new_rows)} new rows. Generating embeddings...")

    new_titles = new_rows['title'].tolist()
    new_embeddings = model.encode(new_titles, convert_to_tensor=True)

    # === Combine old + new ===
    if old_embeddings.numel() > 0:
        combined_embeddings = torch.cat((old_embeddings, new_embeddings), dim=0)
    else:
        combined_embeddings = new_embeddings

    # === Save updated embeddings ===
    joblib.dump(combined_embeddings, updated_embeddings_path)
    print(f"💾 Updated embeddings saved to: {updated_embeddings_path}")
    print(f"🔹 Total embeddings: {combined_embeddings.shape[0]}")

# import os
# import joblib
# import pandas as pd
# from sentence_transformers import SentenceTransformer
# import torch

# # === Paths & base directory ===
# BASE_DIR = os.path.dirname(os.path.abspath(__file__))
# MODEL_PATH = os.path.join(BASE_DIR, "fine_tuned_similarity_model")  # <- use your fine-tuned model
# DATA_PATH = os.path.join(BASE_DIR, "sebenarnya_with_links_new.csv")
# EMBEDDINGS_PATH = os.path.join(BASE_DIR, "fact_embeddings.pkl")
# UPDATED_EMBEDDINGS_PATH = os.path.join(BASE_DIR, "fact_embeddings_updated.pkl")

# # === Load fine-tuned model ===
# model = SentenceTransformer(MODEL_PATH)

# # === Load dataset ===
# fact_data = pd.read_csv(DATA_PATH)
# fact_data['title'] = fact_data['title'].fillna('')

# # === Load existing embeddings if available ===
# if os.path.exists(EMBEDDINGS_PATH):
#     old_embeddings = joblib.load(EMBEDDINGS_PATH)
#     print(f"✅ Loaded existing embeddings: {old_embeddings.shape[0]} rows")
# else:
#     old_embeddings = torch.tensor([])
#     print("⚠️ No existing embeddings found, starting fresh")

# # === Detect new rows ===
# old_count = old_embeddings.shape[0] if old_embeddings.numel() > 0 else 0
# new_rows = fact_data.iloc[old_count:]

# if new_rows.empty:
#     print("✅ No new rows found. Nothing to update.")
#     combined_embeddings = old_embeddings
# else:
#     print(f"🆕 Found {len(new_rows)} new rows. Generating embeddings...")
#     new_titles = new_rows['title'].tolist()
#     new_embeddings = model.encode(new_titles, convert_to_tensor=True)

#     # === Combine old + new ===
#     if old_embeddings.numel() > 0:
#         combined_embeddings = torch.cat((old_embeddings, new_embeddings), dim=0)
#     else:
#         combined_embeddings = new_embeddings

#     # === Save updated embeddings ===
#     joblib.dump(combined_embeddings, UPDATED_EMBEDDINGS_PATH)
#     print(f"💾 Updated embeddings saved to: {UPDATED_EMBEDDINGS_PATH}")

# print(f"🔹 Total embeddings: {combined_embeddings.shape[0]}")

# # Optional: overwrite EMBEDDINGS_PATH so next update uses updated embeddings
# joblib.dump(combined_embeddings, EMBEDDINGS_PATH)
