// setup nodes for form elements
const registerForm = document.getElementById("register_form");
const username = document.getElementById("username");
const name = document.getElementById("name");
const email = document.getElementById("email");
const password = document.getElementById("password");
const verifyPassword = document.getElementById("VPassword");
const errorElement = document.getElementById("error");

// create a request object
let request = new XMLHttpRequest();
// set up a callback function for the request object
request.addEventListener('load', (ev) => {
    if (request.status != 200) {
        console.log(request);
    }
    else if (request.response == "true") {
        // if the username already exists, show the error message
        if (document.getElementById("usernameexists") == null) { // if the error message is not already there
            username.parentElement.nextElementSibling.insertAdjacentHTML("afterend", "<p id='usernameexists' class='error'>*That user already exists</p>");
        }
    } else {
        // if the username does not exist, hide the error message
        if (document.getElementById("usernameexists") != null) { // if the error message is already there
            document.getElementById("usernameexists").remove();
        }
    }
});

// function that removes the hidden class from the error message
showErrorMessage = (element) => {
    element.parentElement.nextElementSibling.classList.remove("hidden");
}

// function that adds the hidden class to the error message
hideErrorMessage = (element) => {
    element.parentElement.nextElementSibling.classList.add("hidden");
}

// add an event listener to the form
registerForm.addEventListener("submit", (e) => {
    // check if the username already exists in the database
    request.open("GET", "./usernameexists.php?username=" + username.value);
    request.send();

    let errors = 0; // variable to keep track of errors

    // check if the fields are empty
    if (username.value === "" || username.value == null) {
        errors++;
        showErrorMessage(username)
    } else hideErrorMessage(username)
    if (name.value === "" || name.value == null) {
        errors++;

        showErrorMessage(name)
    } else hideErrorMessage(name)

    if (email.value === "" || email.value == null) {
        errors++;
        showErrorMessage(email)

    } else hideErrorMessage(email)

    if (password.value === "" || password.value == null) {
        errors++;
        showErrorMessage(password)
    } else hideErrorMessage(password)

    // check if verify password is equal to password
    if (verifyPassword.value === "" || verifyPassword.value == null || password.value !== verifyPassword.value) {
        errors++;
        showErrorMessage(verifyPassword)
    } else hideErrorMessage(verifyPassword)

    if (password.value !== verifyPassword.value) {
        errors++;
        showErrorMessage(verifyPassword)

    } else hideErrorMessage(verifyPassword)

    // if there are errors, prevent the form from submitting
    if (errors > 0) {
        e.preventDefault();
    }
})