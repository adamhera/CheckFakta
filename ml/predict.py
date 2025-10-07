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

# Load model
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
tfidf = joblib.load(os.path.join(BASE_DIR, "tfidf_vectorizer.pkl"))
svm_model = joblib.load(os.path.join(BASE_DIR, "svm_model.pkl"))

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("Error: No input text provided")
        sys.exit(1)

    input_text = sys.argv[1]
    clean_text = preprocess_text(input_text)
    X = tfidf.transform([clean_text])

    prediction = int(svm_model.predict(X)[0])  # Ensure integer

    label_map = {
        0: "Fake",
        1: "Precaution",
        2: "Real",
        3: "Unclear"
    }

    # Print only **one line** for Laravel
    print(label_map.get(prediction, "Unclear"))
