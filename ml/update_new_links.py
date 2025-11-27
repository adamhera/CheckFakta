import pandas as pd
import requests
from bs4 import BeautifulSoup
from datetime import datetime, timedelta
import os
from concurrent.futures import ThreadPoolExecutor, as_completed
import time

# -----------------------
# Paths
# -----------------------
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
labeled_path = os.path.join(BASE_DIR, "sebenarnya_labeledLatest.csv")
links_path = os.path.join(BASE_DIR, "sebenarnya_with_links_new.csv")

# -----------------------
# Helper to normalize URLs safely
# -----------------------
def normalize_url(url):
    if pd.isna(url) or not url:  # skip NaN or empty values
        return ""
    return str(url).strip().rstrip('/')

# -----------------------
# Load existing datasets
# -----------------------
df_labeled = pd.read_csv(labeled_path) if os.path.exists(labeled_path) else pd.DataFrame(columns=["title", "date", "link"])
df_links = pd.read_csv(links_path) if os.path.exists(links_path) else pd.DataFrame(columns=["title", "date", "fact_link"])

existing_urls = set(u for u in (normalize_url(u) for u in df_labeled['link']) if u) | \
                set(u for u in (normalize_url(u) for u in df_links['fact_link']) if u)

# -----------------------
# Auto Date Range
# -----------------------
if not df_labeled.empty and 'date' in df_labeled.columns:
    try:
        #last_date = pd.to_datetime(df_labeled['date'], errors='coerce').max().date()
        #start_date = last_date - timedelta(days=1)  # recheck 1 day overlap to be safe
        dates = pd.to_datetime(df_labeled['date'], errors='coerce')
        valid_dates = dates[~dates.isna() & (dates <= datetime.now())]
        if not valid_dates.empty:
                last_date = valid_dates.max().date()
                start_date = last_date - timedelta(days=1)
        else:
                start_date = datetime.now().date() - timedelta(days=7)

    except Exception:
        start_date = datetime.now().date() - timedelta(days=7)
else:
    start_date = datetime.now().date() - timedelta(days=7)

end_date = datetime.now().date()

print(f"📅 Date range: {start_date} → {end_date}")

# -----------------------
# XML sitemap URL
# -----------------------
sitemap_url = "https://sebenarnya.my/wp-sitemap-posts-post-2.xml"
sitemap_xml = requests.get(sitemap_url).text
soup = BeautifulSoup(sitemap_xml, "xml")
urls = [tag.text.strip() for tag in soup.find_all("loc")]

# -----------------------
# Filter only new URLs
# -----------------------
urls_to_fetch = [url for url in urls if normalize_url(url) not in existing_urls]
print(f"🔹 {len(urls_to_fetch)} new URLs to check...")

# -----------------------
# Fetch function
# -----------------------
def fetch_url(url, retries=3):
    for attempt in range(retries):
        try:
            r = requests.get(url, timeout=15)
            if r.status_code != 200:
                return None

            page = BeautifulSoup(r.text, "html.parser")
            title_tag = page.find("h1", class_="entry-title")
            title = title_tag.text.strip() if title_tag else None

            date_tag = page.find("time", class_="entry-date")
            date_str = date_tag['datetime'] if date_tag else None
            if not date_str:
                return None

            date_obj = datetime.fromisoformat(date_str.split("T")[0])
            if not (start_date <= date_obj.date() <= end_date):
                return None

            return {
                "title": title,
                "date": date_obj.strftime("%Y-%m-%d"),
                "link": url
            }

        except requests.exceptions.RequestException:
            print(f"⚠️ Timeout or error for {url}, retrying {attempt + 1}/{retries}...")
            time.sleep(2)

    print(f"❌ Failed to fetch {url} after {retries} attempts")
    return None

# -----------------------
# Fetch URLs concurrently
# -----------------------
new_entries = []
with ThreadPoolExecutor(max_workers=5) as executor:
    futures = [executor.submit(fetch_url, url) for url in urls_to_fetch]
    for future in as_completed(futures):
        result = future.result()
        if result:
            new_entries.append(result)

# -----------------------
# Update sebenarnya_labeledLatest.csv
# -----------------------
if new_entries:
    df_new = pd.DataFrame(new_entries)[["title", "date", "link"]]
    df_labeled = pd.concat([df_labeled, df_new], ignore_index=True)
    df_labeled.to_csv(labeled_path, index=False, encoding="utf-8-sig")
    print(f"💾 Updated sebenarnya_labeledLatest.csv with {len(df_new)} new entries")
else:
    print("✅ No new entries for sebenarnya_labeledLatest.csv")

# -----------------------
# Update sebenarnya_with_links_new.csv
# -----------------------
if new_entries:
    df_new_links = pd.DataFrame(new_entries)[["title", "date", "link"]]
    df_new_links = df_new_links.rename(columns={"link": "fact_link"})
    df_links = pd.concat([df_links, df_new_links], ignore_index=True)
    df_links.to_csv(links_path, index=False, encoding="utf-8-sig")
    print(f"💾 Updated sebenarnya_with_links_new.csv with {len(df_new_links)} new entries")
else:
    print("✅ No new entries for sebenarnya_with_links_new.csv")

print("🏁 Update process complete.")
