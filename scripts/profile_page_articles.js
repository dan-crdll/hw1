const articles = document.querySelector("#articles");

fetch("assets/get_articles_by_user.php?q=" + user_id)
  .then(onRes)
  .then(onJson);

function onRes(res) {
  return res.json();
}

function onJson(json) {
  const articles = json["articles"];
  let title;
  let img;
  let title_el;
  let image_el;

  if (articles.length === 0) {
    document.querySelector("#articles").innerHTML =
      "Non hai ancora pubblicato nulla...";
    return;
  }

  for (let a of articles) {
    title = (a["TITLE"].length > 60 ? a["TITLE"].slice(0, 59) + "..." : a["TITLE"]);
    img = a["IMAGE_URL"];

    const article = document.createElement("a");
    title_el = document.createElement("div");
    image_el = document.createElement("div");

    title_el.classList.add("article_title");
    title_el.innerHTML = title;

    article.classList.add("article");
    image_el.classList.add("image_article");
    image_el.style.backgroundImage = "url(" + img + ")";
    console.log(img);

    article.appendChild(image_el);
    article.appendChild(title_el);

    article.href = "article.php?q=" + a["ID"];

    document.querySelector("#articles").appendChild(article);
  }
}
