import requests
from bs4 import BeautifulSoup

# URL della pagina da cui estrarre le notizie
url = "https://primalodi.it/notizie-locali/basso-lodigiano/"

# Ottieni il contenuto della pagina
response = requests.get(url)
soup = BeautifulSoup(response.content, "html.parser")

# Trova le notizie (modifica a seconda della struttura HTML)
news_items = soup.find_all("article")  # Supponiamo che ogni notizia sia in un <article>

# Estrai i dati (titolo, link, data, ecc.)
news_list = []
for item in news_items:
    title = item.find("h2").text.strip()  # Titolo
    link = item.find("a")["href"]  # Link
    description = item.find("p").text.strip()  # Descrizione (se presente)

    news_list.append({
        "title": title,
        "link": link,
        "description": description
    })

# Stampa o salva i risultati
for news in news_list:
    print(news["title"])
    print(news["link"])
    print(news["description"])
    print("-" * 80)
