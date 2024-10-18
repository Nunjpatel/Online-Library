
// get the password input and the reveal button
const descriptionInput = document.getElementById("description");
const charCounter = document.getElementById("numbercount");
  // Set the maximum length of the description input
  const maxLength = 2500;
  descriptionInput.maxLength = maxLength;

  // Update the character counter on input
  descriptionInput.addEventListener('input', () => {
    const length = descriptionInput.value.length;
    charCounter.textContent = `${length}/${maxLength}`;
  });
