let article_city = document.querySelector("#city_sec");

article_city.addEventListener("blur", titleAdded);

let article_title = document.querySelector("#article_title");
let article_content = document.querySelector("#article_body");
let save_btn = document.querySelector("#save_btn");

article_content.addEventListener("blur", checkContents);
article_title.addEventListener("blur", checkContents);

function checkContents(event) {
  if (article_content.value.length && article_title.value.length)
    save_btn.classList.remove("hidden");
  else save_btn.classList.add("hidden");
}

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
