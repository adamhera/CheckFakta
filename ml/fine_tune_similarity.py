from sentence_transformers import SentenceTransformer, InputExample, losses
from torch.utils.data import DataLoader
import pandas as pd

# 1. Load pre-trained model
model = SentenceTransformer('paraphrase-MiniLM-L6-v2')

# 2. Load your pairs dataset
df = pd.read_csv("pairs_similarity.csv")

train_examples = [
    InputExample(
        texts=[row['sentence1'], row['sentence2']], 
        label=float(row['score'])
    )
    for _, row in df.iterrows()
]

# 3. DataLoader
train_dataloader = DataLoader(train_examples, shuffle=True, batch_size=16)

# 4. Loss function for semantic similarity
train_loss = losses.CosineSimilarityLoss(model)

# 5. Fine-tune model
model.fit(
    train_objectives=[(train_dataloader, train_loss)],
    epochs=4,
    warmup_steps=100,
    output_path='fine_tuned_similarity_model'
)

print("Training complete. Model saved to fine_tuned_similarity_model/")
