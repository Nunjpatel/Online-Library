const form = document.querySelector('#addbook-form');

      // Add a submit event listener to the form
      form.addEventListener('submit', function(event) {
        // Prevent the form from submitting
        event.preventDefault();

        // Get the form inputs
        const titleInput = document.querySelector('#title');
        const authorInput = document.querySelector('#author');
        const dateInput = document.querySelector('#date');

        // Get the input values
        const title = titleInput.value.trim();
        const author = authorInput.value.trim();
        const date = dateInput.value.trim();

        // Validate the inputs
        let errors = [];

        if (title === '') {
          errors.push('Please enter a title.');
        }

        if (author === '') {
          errors.push('Please enter an author.');
        }

        if (!isValidDate(date)) {
          errors.push('Please enter a valid date (YYYY-MM-DD).');
        }

        // If there are errors, display them in the error container
        const errorContainer = document.querySelector('#error-container');
        errorContainer.innerHTML = '';

        if (errors.length > 0) {
          const errorList = document.createElement('ul');
          errors.forEach(function(error) {
            const errorListItem = document.createElement('li');
            errorListItem.textContent = error;
            errorList.appendChild(errorListItem);
          });

          errorContainer.appendChild(errorList);
        } else {
          // If there are no errors, submit the form
          form.submit();
        }
      });

      // Helper function to validate date format
      function isValidDate(dateString) {
        // First check for the pattern
        if (!/^\d{4}-\d{2}-\d{2}$/.test(dateString)) {
          return false;
        }

        // Parse the date parts to integers
        const parts = dateString.split("-");
        const year = parseInt(parts[0], 10);
        const month = parseInt(parts[1], 10);
        const day = parseInt(parts[2], 10);

        // Check if the date is valid
        if (month < 1 || month > 12 || day < 1 || day > 31) {
          return false;
        }


        return true;
      }