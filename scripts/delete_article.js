const delete_btn = document.querySelector('#delete_btn');
delete_btn.addEventListener('click', onDelete);

function onDelete(event) {
    fetch('/hw1/assets/search_articles/delete_article.php?article=' + article)
        .then((res) => {return res.json();})
        .then(onJson);
}

function onJson(json) {
    if(json['success']) {
        console.log('success');
    } else {
        console.log('error');
    }
}