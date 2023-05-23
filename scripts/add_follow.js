const follow_btn = document.querySelector("#follow");
follow_btn.addEventListener("click", follow);
const follow_icon = document.querySelector("#follow img");

var FD = new FormData();
FD.append("follower", follower);
FD.append("followed", followed);

var req = {
  method: "post",
  body: FD,
};

fetch("/hw1/assets/followings/is_follow.php", req)
  .then((res) => {
    return res.json();
  })
  .then(isFollowed);

function isFollowed(json) {
  let alreadyFollowed = json["follows"];

  if (alreadyFollowed) {
    follow_icon.src = "/hw1/assets/full_following.png";
  } else {
    follow_icon.src = "/hw1/assets/following.png";
  }
}

function follow(event) {
  fetch("/hw1/assets/followings/is_follow.php", req)
    .then((res) => {
      return res.json();
    })
    .then((json) => {
      let alreadyFollowed = json["follows"];
      
      if (!alreadyFollowed) {
        fetch("/hw1/assets/followings/add_follow.php", req)
          .then((res) => {
            return res.json();
          })
          .then(onJson);
      } else {
        fetch("/hw1/assets/followings/remove_follow.php", req)
          .then((res) => {
            return res.json();
          })
          .then(onRemove);
      }
    });
}

function onJson(json) {
  if (json[0]["success"]) {
    follow_icon.src = "/hw1/assets/full_following.png";

    document.querySelector("#num_follow").innerHTML = json[1]["num"];
  }
}

function onRemove(json) {
  if (json[0]["success"]) {
    follow_icon.src = "/hw1/assets/following.png";

    document.querySelector("#num_follow").innerHTML = json[1]["num"];
  }
}
