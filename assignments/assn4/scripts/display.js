// Get the modal element
const modal = document.getElementById("modal");

// Get the button that opens the modal
const displayBtn = document.querySelector("input[type='submit']");

// Get the close button element
const closeBtn = document.querySelector(".close");

// When the user clicks the button, display the modal
displayBtn.addEventListener("click", function() {
  modal.style.display = "block";
});

// When the user clicks on the close button, hide the modal
closeBtn.addEventListener("click", function() {
  modal.style.display = "none";
});

// When the user clicks outside the modal, hide the modal
window.addEventListener("click", function(event) {
  if (event.target === modal) {
    modal.style.display = "none";
  }
});
