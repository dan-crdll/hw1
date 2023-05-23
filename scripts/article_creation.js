article_city = document.querySelector("#city_sec");

article_city.addEventListener("blur", titleAdded);

function titleAdded(event) {
  const city = event.target.value;
  if (city.length > 0) {
    fetch("get_unsplash.php?q=" + encodeURIComponent(city.replace(/\s/g, "")))
      .then(onRes)
      .then(onJson);
  }
}

function onRes(res) {
  return res.json();
}

function onJson(json) {
  if (json["found"]) {
    const link = json["link"];
    const background = document.querySelector("#article_img");
    background.style.backgroundImage = "url('" + link + "')";
    document.forms["article_creation"]["image_url"].value = link;
  }
}
