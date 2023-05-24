const sandwich = document.querySelector("#sandwich_btn");
var isOpen = false;

sandwich.addEventListener("click", onOpenMenu);

function onOpenMenu(event) {
  console.log(isOpen);
  if (isOpen) {
    document.querySelector("#sandwich").style.display = "none";
  } else {
    document.querySelector("#sandwich").style.display = "flex";
  }
  isOpen = !isOpen;
}
