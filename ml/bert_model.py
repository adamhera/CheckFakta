import torch
from transformers import BertTokenizer, BertForSequenceClassification

# Load pretrained model & tokenizer
MODEL_NAME = "bert-base-multilingual-cased"  # supports Malay
tokenizer = BertTokenizer.from_pretrained(MODEL_NAME)
model = BertForSequenceClassification.from_pretrained(MODEL_NAME, num_labels=3)  # Real, Fake, Unclear

# If you have a fine-tuned model saved locally, load that instead:
# model.load_state_dict(torch.load("bert_finetuned_model.pt", map_location="cpu"))

def bert_predict(text):
    model.eval()
    inputs = tokenizer(text, return_tensors="pt", truncation=True, padding=True, max_length=128)
    with torch.no_grad():
        outputs = model(**inputs)
        logits = outputs.logits
        probabilities = torch.nn.functional.softmax(logits, dim=-1)
        confidence, predicted_class = torch.max(probabilities, dim=1)
    
    label_map = {0: "Fake", 1: "Real", 2: "Unclear"}
    return {
        "bert_result": label_map[predicted_class.item()],
        "bert_confidence": round(confidence.item(), 4)
    }
