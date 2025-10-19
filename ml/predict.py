# ml/predict.py

import os
import sys
import joblib
import string
import nltk
from nltk.corpus import stopwords

nltk.download('stopwords', quiet=True)

def preprocess_text(text):
    if not text:
        return ""
    text = text.lower()
    text = text.translate(str.maketrans('', '', string.punctuation))
    stop_words = set(stopwords.words('indonesian'))  # or 'malay'
    tokens = [word for word in text.split() if word not in stop_words]
    return " ".join(tokens)

# Load model, vectorizer, and label encoder
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
tfidf = joblib.load(os.path.join(BASE_DIR, "tfidf_vectorizerLatest.pkl"))
svm_model = joblib.load(os.path.join(BASE_DIR, "svm_modelLatest.pkl"))
label_encoder = joblib.load(os.path.join(BASE_DIR, "label_encoder.pkl"))

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("Error: No input text provided")
        sys.exit(1)

    input_text = sys.argv[1]
    clean_text = preprocess_text(input_text)
    X = tfidf.transform([clean_text])

    try:
        y_pred = svm_model.predict(X)
        # Convert numeric label back to string using label encoder
        pred_label = label_encoder.inverse_transform(y_pred)[0]
    except Exception as e:
        pred_label = "Prediction failed"

    # Print only **one line** for Laravel
    print(pred_label)