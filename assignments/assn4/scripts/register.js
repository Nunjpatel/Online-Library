const form = document.getElementById("register-form");
const nameInput = document.getElementById("name");
const emailInput = document.getElementById("email");
const passwordInput = document.getElementById("password");

function validateName() {
  const nameError = document.getElementById("name-error");
  if (nameInput.value.trim() === "") {
    nameError.textContent = "Please enter your name";
    return false;
  }
  nameError.textContent = "";
  return true;
}

function validateEmail() {
  const emailError = document.getElementById("email-error");
  if (emailInput.value.trim() === "") {
    emailError.textContent = "Please enter your email";
    return false;
  }
  if (!/^\S+@\S+\.\S+$/.test(emailInput.value.trim())) {
    emailError.textContent = "Please enter a valid email";
    return false;
  }
  emailError.textContent = "";
  return true;
}

function validatePassword() {
  const passwordError = document.getElementById("password-error");
  if (passwordInput.value.trim() === "") {
    passwordError.textContent = "Please enter your password";
    return false;
  }
  if (passwordInput.value.length < 6) {
    passwordError.textContent = "Password must be at least 6 characters long";
    return false;
  }
  passwordError.textContent = "";
  return true;
}

function validateForm() {
  const isValidName = validateName();
  const isValidEmail = validateEmail();
  const isValidPassword = validatePassword();
  return isValidName && isValidEmail && isValidPassword;
}

form.addEventListener("submit", function(event) {
  if (!validateForm()) {
    event.preventDefault();
  }
});
