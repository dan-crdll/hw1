const search_form = document.forms["search_form"];
search_form.addEventListener("submit", onSearch);

var hourglass = document.querySelector('#hourglass img');

fetch("/hw1/assets/search_articles/most_popular.php")
  .then((res) => {
    return res.json();
  })
  .then(onPopular)
  .then(() => {
    hourglass.classList.remove('hidden');
    fetch("/hw1/assets/get_tweets.php")
      .then((res) => {
        return res.json();
      })
      .then(onTweets);
  });

function onSearch(event) {
  event.preventDefault();

  let q = search_form["search_bar"].value;
  let place = q;
  q = q.replace(" ", "");

  if (q !== "") {
    document.querySelector("#section-subtitle").innerHTML =
      'Ultimi tweet di viaggi con l\'hashtag <span class="hashtag">#' +
      q +
      "</span> e articoli di altri globetrotters se disponibili";
    document.querySelector("#section-title").innerHTML = place;

    fetch("/hw1/assets/search_articles/search_alike.php?q=" + q)
      .then((res) => {
        return res.json();
      })
      .then(onAlike)
      .then(() => {
        hourglass.classList.remove('hidden');
        fetch("/hw1/assets/get_tweets.php?q=" + q)
          .then((res) => {
            return res.json();
          })
          .then(onTweets);
      });
  } else {
    document.querySelector("#section-subtitle").innerHTML =
      'Ultimi tweet dell\'account <span class="hashtag">Trip Advisor</span> e articoli più popolari';
    document.querySelector("#section-title").innerHTML = "Lasciati ispirare";

    fetch("/hw1/assets/search_articles/most_popular.php")
      .then((res) => {
        return res.json();
      })
      .then(onPopular)
      .then(() => {
        hourglass.classList.remove('hidden');
        fetch("/hw1/assets/get_tweets.php")
          .then((res) => {
            return res.json();
          })
          .then(onTweets);
      });
  }
}

function onTweets(tweets) {
  if (tweets["num"] === 0) {
    document.querySelector("#article-list").innerHTML =
      "Non è stato trovato alcun risultato";
  }
  for (let t of tweets) {
    let content = t.content;
    let photo = t.photo;

    let article = document.createElement("div");
    article.classList.add("tweet");
    article.classList.add("article");

    let image = document.createElement("div");
    image.classList.add("image_article");
    image.style.backgroundImage = "url('" + photo + "')";

    let title = document.createElement("div");
    title.classList.add("article_content");
    title.innerHTML = content;

    article.appendChild(image);
    article.appendChild(title);

    document.querySelector("#article-list").appendChild(article);
  }

  hourglass.classList.add('hidden');
}

function onPopular(json) {
  document.querySelector("#most_popular").innerHTML = "";
  document.querySelector("#article-list").innerHTML = "";
  let num = 3;

  if(json[0]['num'] === 0) {
    return;
  }

  document.querySelector("#most_popular").style.display = 'flex';

  if (json.length < 3) {
    num = json.length;
  }

  for (let i = 0; i < num; i++) {
    let content = (json[i]["TITLE"].length > 60 ? json[i]["TITLE"].slice(0, 59) + "..." : json[i]["TITLE"]);
    let photo = json[i]["IMAGE_URL"];
    let id = json[i]["ID"];

    let article = document.createElement("a");
    article.classList.add("article");
    article.href = "article.php?q=" + id;

    let image = document.createElement("div");
    image.classList.add("image_article");
    image.style.backgroundImage = "url('" + photo + "')";

    let title = document.createElement("div");
    title.classList.add("article_title");
    title.innerHTML = content;

    article.appendChild(image);
    article.appendChild(title);

    document.querySelector("#most_popular").appendChild(article);
  }
  return;
}

function onAlike(json) {
  document.querySelector("#most_popular").innerHTML = "";
  document.querySelector("#most_popular").style.display = 'none';
  document.querySelector("#article-list").innerHTML = "";
  if (json[0]["num"] === 0) {
    return;
  }

  for (let j of json) {
    let content = (j["TITLE"].length > 60 ? j["TITLE"].slice(0, 59) + "..." : j["TITLE"]);
    let photo = j["IMAGE_URL"];
    let id = j["ID"];

    let article = document.createElement("a");
    article.classList.add("article");
    article.href = "article.php?q=" + id;

    let image = document.createElement("div");
    image.classList.add("image_article");
    image.style.backgroundImage = "url('" + photo + "')";

    let title = document.createElement("div");
    title.classList.add("article_title");
    title.innerHTML = content;

    article.appendChild(image);
    article.appendChild(title);

    document.querySelector("#article-list").appendChild(article);
  }
  return;
}
