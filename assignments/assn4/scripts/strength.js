// script to keep track of the strength of the password

// fucntions checking individual password requirements

// check if the password is at least 8 characters long
const check_password_length = (password) => {
  return password.length >= 6;
}

// check if the password contains at least one number
const check_password_numbers = (password) => {
  return /\d/.test(password);
}

// check if the password contains at least one special character
const check_password_special = (password) => {
  return /[!@#$%^&*()]/.test(password);
}

// check if the password contains at least one uppercase letter
const check_password_uppercase = (password) => {
  return /[A-Z]/.test(password);
}

// check if the password contains at least one lowercase letter
const check_password_lowercase = (password) => {
  return /[a-z]/.test(password);
}

// get the password input and the strength text
const passwordInput = document.getElementById("password");
const strengthText = document.getElementById("strength-text")

// add an event listener to the form
document.addEventListener("submit", (e) => {
  // setup an array of the password requirements
  const strength = [check_password_length(passwordInput.value), check_password_numbers(passwordInput.value), check_password_special(passwordInput.value), check_password_uppercase(passwordInput.value), check_password_lowercase(passwordInput.value)];
  let strengthNum = 0; // variable to keep track of the strength of the password
  // loop through the array and check if the requirements are met and increment the strength variable
  strength.map((val) => {
      if (val) {
          strengthNum++;
      }
  })

// set the text of the strength text
strengthText.innerHTML = `Password Strength: ${strengthNum}/5`; 

  // check if the strength is less than 5 and prevent the form from submitting
  if (strengthNum < 5) {
      e.preventDefault();
      console.log(strengthNum);
      passwordInput.parentElement.nextElementSibling.classList.remove("hidden");
  // set the text of the strength text
  strengthText.innerHTML = `Password Strength: ${strengthNum}/5`; 
  } else {
      console.log(strengthNum);
      passwordInput.parentElement.nextElementSibling.classList.add("hidden");
  }
})