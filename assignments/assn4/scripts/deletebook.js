const deleteButton = document.querySelector('input[name="submit"]');
  
deleteButton.addEventListener('click', function(event) {
  // Prevent form submission
  event.preventDefault();
  
  // Show confirmation dialog
  const confirmDelete = confirm("Are you sure you want to delete this book?");
  
  // If user confirms, submit form
  if (confirmDelete) {
    document.querySelector('form').submit();
  }
});