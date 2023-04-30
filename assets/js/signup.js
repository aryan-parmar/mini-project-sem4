const form = document.querySelector("#signup-form");
const username = form.elements.username;
const fullname = form.elements.fullname;
const email = form.elements.email;
const password = form.elements.password;

form.addEventListener("submit", (event) => {
  event.preventDefault();
  if (!validatePassword(password.value)) {
    alert("Please enter a password that is at least 8 characters long.");
    return;
  }
  form.submit();
});

function validatePassword(password) {
  if(password.length < 8) {
    return false;
  }
  return true;
}

document.querySelector("input").addEventListener("change", (e) => {
  if (e.target.value.trim() !== "") {
    document.querySelector(".ulabel").style.top = "0%";
    document.querySelector(".ulabel").style.transform = "translate(0%, -110%)";
  } else {
    document.querySelector(".ulabel").style.top = "50%";
    document.querySelector(".ulabel").style.transform = "translate(0%, -50%)";
  }
});
document
  .querySelector('input[type="email"]')
  .addEventListener("change", (e) => {
    if (e.target.value.trim() !== "") {
      document.querySelector(".elabel").style.top = "0%";
      document.querySelector(".elabel").style.transform =
        "translate(0%, -110%)";
    } else {
      document.querySelector(".elabel").style.top = "50%";
      document.querySelector(".elabel").style.transform = "translate(0%, -50%)";
    }
  });
document
  .querySelector('input[type="password"]')
  .addEventListener("change", (e) => {
    if (e.target.value.trim() !== "") {
      document.querySelector(".plabel").style.top = "0%";
      document.querySelector(".plabel").style.transform =
        "translate(0%, -110%)";
    } else {
      document.querySelector(".plabel").style.top = "50%";
      document.querySelector(".plabel").style.transform = "translate(0%, -50%)";
    }
  });
document.querySelector(".fni").addEventListener("change", (e) => {
  if (e.target.value.trim() !== "") {
    document.querySelector(".flabel").style.top = "0%";
    document.querySelector(".flabel").style.transform = "translate(0%, -110%)";
  } else {
    document.querySelector(".flabel").style.top = "50%";
    document.querySelector(".flabel").style.transform = "translate(0%, -50%)";
  }
});
