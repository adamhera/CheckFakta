# CheckFakta

**CheckFakta** is a machine learning-based fact-checking system that focuses specifically on **Malay news**. It uses NLP techniques and semantic similarity to analyze claims and classify them as **Benar (Real)**, **Palsu (Fake)**, or **Tidak Jelas (Unclear)**. The system also includes an **SVM model** for additional classification.

---

## Features

- Fact-checking tailored for **Malay news**
- Semantic similarity analysis using fine-tuned embeddings
- SVM-based claim classification
- Dataset updated **daily** to include the latest news
- Web interface for submitting and checking claims
- User must register and log in
- User can see detection history
- There are also news link that will be redirected to the trusted source
  
---

## Project Structure

/ml/ # ML models and scripts
/resources/views/ # Front-end templates (Blade)
/public/images/ # Images used in the website
/database/migrations/ # Database schema changes

---

## Installation

1. Clone the repository:

git clone https://github.com/yourusername/CheckFakta.git
cd CheckFakta

2. Install Python dependencies (for ML):

pip install -r requirements.txt

3. Run the web app (Laravel example):

php artisan serve

---

Usage

Enter a claim in the web interface to check its credibility

System predicts if the claim is Benar, Palsu, or Tidak Jelas

ML developers can:

Update embeddings

Fine-tune models under /ml/

Use the SVM classifier for additional analysis

---

Dataset

The dataset is continuously updated daily

Contains labeled Malay news for training and evaluation

Stored in /ml/ as CSV files for preprocessing and modeling
