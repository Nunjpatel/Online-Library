// javascript for the reveal password toggle

// get the password input and the reveal button
const passwordInput = document.getElementById("password");
const revealButton = document.getElementById("show");

// add an event listener to the reveal button
revealButton.addEventListener("click", () => {
    // if the password input is of type text, change it to password and change the text of the button to "show"
    if (passwordInput.type === "text") {
        passwordInput.type = "password";
        passwordInput.nextElementSibling.innerHTML = "Show";
    } else {
        // if the password input is of type password, change it to text and change the text of the button to "hide"
        passwordInput.type = "text";
        passwordInput.nextElementSibling.innerHTML = "Hide";
    }
})