/*TODO: CONTROLLO ERRORI FORM*/

const comment_btn = document.querySelector("#comments");
var inComment = false;

const comment_form = document.forms["comment"];
comment_form.addEventListener("submit", onComment);

comment_btn.addEventListener("click", onEnterComment);

function onEnterComment(event) {
  if (inComment) {
    comment_btn.classList.remove("inComment");
    document.querySelector("#comment_section").classList.add("hidden");
  } else {
    comment_btn.classList.add("inComment");
    document.querySelector("#comment_section").classList.remove("hidden");
    fetchComments();
  }
  inComment = !inComment;
}

function fetchComments() {
  comment_list.innerHTML = "";
  let body = new FormData();
  body.append("article", article);
  fetch("/hw1/assets/comments/get_comments.php", { method: "post", body: body })
    .then((res) => {
      return res.json();
    })
    .then(onFetchComments);
}

function onFetchComments(json) {
  let comment_list = document.querySelector("#comment_list");
  document.querySelector("#num_comment").innerHTML = json["num"];

  if (!json["num"]) {
    comment_list.innerHTML = "Nessun commento.";
  } else {
    for (let c of json["comments"]) {
      let comment = document.createElement("div");
      let author = document.createElement("a");
      let text = document.createElement("div");
      let date = document.createElement("div");

      comment.classList.add("comment");
      author.classList.add("author");
      text.classList.add("text");
      date.classList.add("date");

      author.innerHTML = "@" + c["USERNAME"];
      author.href = "account.php?user=" + c["USERNAME"];
      text.innerHTML = c["CONTENT"];
      date.innerHTML = c["COMMENT_DATE"];

      comment.appendChild(author);
      comment.appendChild(text);
      comment.appendChild(date);
      comment_list.appendChild(comment);
    }
  }
}

function onComment(event) {
  event.preventDefault();
  let content = comment_form["comment_content"].value;
  let date = comment_form["date"].value;
  comment_form.reset();
  body = new FormData();
  body.append("content", content);
  body.append("article", article);
  body.append("user", user);
  body.append("date", date);

  fetch("/hw1/assets/comments/add_comment.php", {
    method: "post",
    body: body,
  }).then(() => {
    fetchComments();
  });
}
