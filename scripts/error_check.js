var signup_form = document.forms["signup_form"];
var login_form = document.forms["login_form"];
var fullname;
var surname;
var email;
var password;
var username;

if (signup_form) {
  fullname = signup_form["name"];
  surname = signup_form["surname"];
  email = signup_form["email"];
  password = signup_form["password"];
  username = signup_form["username"];

  fullname.addEventListener("blur", checkName);
  surname.addEventListener("blur", checkSurname);
  email.addEventListener("blur", checkEmail);

  signup_form.addEventListener("submit", onSubmit);
} else {
  if (login_form) {
    password = login_form["password"];
    username = login_form["username"];
    login_form.addEventListener("submit", onSubmit);
  }
}

password.addEventListener("blur", checkPassword);
username.addEventListener("blur", checkUsername);

//FUNCTIONS

function checkName(event) {
  if (!/^[a-zA-ZÀ-ÿ\s]+$/.test(fullname.value)) {
    document.querySelector("#name_error").classList.remove("hidden");
    document.querySelector("#name_error").classList.add("errorjs");
  } else {
    document.querySelector("#name_error").classList.add("hidden");
    document.querySelector("#name_error").classList.remove("errorjs");
  }
}

function checkSurname(event) {
  if (!/^[a-zA-ZÀ-ÿ\s]+$/.test(surname.value)) {
    document.querySelector("#surname_error").classList.remove("hidden");
    document.querySelector("#surname_error").classList.add("errorjs");
  } else {
    document.querySelector("#surname_error").classList.add("hidden");
    document.querySelector("#surname_error").classList.remove("errorjs");
  }
}

function checkUsername(event) {
  let wrong = false;
  if (!/^[a-zA-Z][a-zA-Z0-9_]*$/.test(username.value)) {
    document.querySelector("#username_error").classList.remove("hidden");
    document.querySelector("#username_error").classList.add("errorjs");
    wrong = true;
  } else {
    document.querySelector("#username_error").classList.add("hidden");
    document.querySelector("#username_error").classList.remove("errorjs");
    wrong = false;
  }

  if (signup_form && !wrong)
    fetch("/hw1/assets/check-username.php?user=" + username.value)
      .then((res) => {
        return res.json();
      })
      .then((json) => {
        if (json["present"]) {
          document.querySelector("#username_error").classList.remove("hidden");
          document.querySelector("#username_error").classList.add("errorjs");
        } else {
          document.querySelector("#username_error").classList.add("hidden");
          document.querySelector("#username_error").classList.remove("errorjs");
        }
      });
}

function checkPassword(event) {
  if (!/^(?=.*[!@#$%^&*])(?=.*[A-Z])(?=.*[0-9]).{8,}$/.test(password.value)) {
    document.querySelector("#password_error").classList.remove("hidden");
    document.querySelector("#password_error").classList.add("errorjs");
  } else {
    document.querySelector("#password_error").classList.add("hidden");
    document.querySelector("#password_error").classList.remove("errorjs");
  }
}

function checkEmail(event) {
  let wrong = false;
  if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email.value)) {
    document.querySelector("#email_error").classList.remove("hidden");
    document.querySelector("#email_error").classList.add("errorjs");
    wrong = true;
  } else {
    document.querySelector("#email_error").classList.add("hidden");
    document.querySelector("#email_error").classList.remove("errorjs");
    wrong = false;
  }
  if (!wrong)
    fetch("/hw1/assets/check-email.php?email=" + email.value)
      .then((res) => {
        return res.json();
      })
      .then((json) => {
        if (json["present"]) {
          document.querySelector("#email_error").classList.remove("hidden");
          document.querySelector("#email_error").classList.add("errorjs");
        } else {
          document.querySelector("#email_error").classList.add("hidden");
          document.querySelector("#email_error").classList.remove("errorjs");
        }
      });
}

function onSubmit(event) {
  const errors = document.querySelectorAll(".errorjs");

  errors = document.querySelectorAll(".errorjs");
  if (errors.length > 0) {
    event.preventDefault();
    return;
  }

  if (signup_form) {
    checkEmail();
    checkName();
    checkSurname();
  }
  checkUsername();
  checkPassword();

  errors = document.querySelectorAll(".errorjs");
  if (errors.length > 0) {
    event.preventDefault();
  }
}
