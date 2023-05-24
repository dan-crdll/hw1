const like_btn = document.querySelector("#likes");
like_btn.addEventListener("click", like);
const like_icon = document.querySelector("#likes img");

console.log("#############" + article);

var FD = new FormData();
FD.append("article", article);
FD.append("user", user);

var req = {
  method: "post",
  body: FD,
};

fetch("/hw1/assets/likes/is_liked.php", req)
  .then((res) => {
    return res.json();
  })
  .then(isliked);

function isliked(json) {
  let alreadyliked = json["likes"];
  console.log(alreadyliked);
  if (alreadyliked) {
    like_icon.src = "/hw1/assets/full_star.png";
    like_btn.classList.add("liked");
  } else {
    like_icon.src = "/hw1/assets/star.png";
    like_btn.classList.remove("liked");
  }
}

function like(event) {
  fetch("/hw1/assets/likes/is_liked.php", req)
    .then((res) => {
      return res.json();
    })
    .then((json) => {
      let alreadyliked = json["likes"];
      
      if (!alreadyliked) {
        fetch("/hw1/assets/likes/add_like.php", req)
          .then((res) => {
            return res.json();
          })
          .then(onJson);
      } else {
        fetch("/hw1/assets/likes/remove_like.php", req)
          .then((res) => {
            return res.json();
          })
          .then(onRemove);
      }
    });
}

function onJson(json) {
  if (json[0]["success"]) {
    like_icon.src = "/hw1/assets/full_star.png";
    like_btn.classList.add("liked");

    document.querySelector("#num_like").innerHTML = json[1]["num"];
  }
}

function onRemove(json) {
  if (json[0]["success"]) {
    like_icon.src = "/hw1/assets/star.png";
    like_btn.classList.remove("liked");

    document.querySelector("#num_like").innerHTML = json[1]["num"];
  }
}
