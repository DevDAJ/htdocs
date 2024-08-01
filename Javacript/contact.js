// Wait for the DOM to fully load before running the script
document.addEventListener("DOMContentLoaded", function() {
  // Get references to the form elements
  const nameInput = document.getElementById("name");
  const nameError = document.getElementById("name-error");
  const emptyNameError = document.getElementById("empty-name");

  const emailInput = document.getElementById("email");
  const emailError = document.getElementById("email-error");
  const emptyEmailError = document.getElementById("empty-email");

  const subjectInput = document.getElementById("subject");

  const messageTextarea = document.getElementById("message");

  const submitButton = document.getElementById("submit");
  const popup = document.getElementById("popup");

  // Function to verify text input (only letters and spaces, minimum 3 characters)
  const textVerify = (text) => {
    const regex = /^[a-zA-Z\s]{3,}$/;
    return regex.test(text);
  };

  // Function to verify email input
  const emailVerify = (input) => {
    const regex = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/;
    return regex.test(input);
  };

  // Function to handle empty input fields
  const emptyUpdate = (inputReference, emptyErrorReference, otherErrorReference) => {
    if (!inputReference.value) {
      // Input is null/empty
      emptyErrorReference.classList.remove("hide");
      otherErrorReference.classList.add("hide");
      inputReference.classList.add("error");
    } else {
      // Input has some content
      emptyErrorReference.classList.add("hide");
    }
  };

  // Function to handle displaying error messages and styling
  const errorUpdate = (inputReference, errorReference) => {
    errorReference.classList.remove("hide");
    inputReference.classList.remove("valid");
    inputReference.classList.add("error");
  };

  // Function to handle valid input styling
  const validInput = (inputReference) => {
    inputReference.classList.remove("error");
    inputReference.classList.add("valid");
  };

  // Event listener for name input validation
  nameInput.addEventListener("input", () => {
    if (textVerify(nameInput.value)) {
      nameError.classList.add("hide");
      validInput(nameInput);
    } else {
      errorUpdate(nameInput, nameError);
      emptyUpdate(nameInput, emptyNameError, nameError);
    }
  });

  // Event listener for email input validation
  emailInput.addEventListener("input", () => {
    if (emailVerify(emailInput.value)) {
      emailError.classList.add("hide");
      validInput(emailInput);
    } else {
      errorUpdate(emailInput, emailError);
      emptyUpdate(emailInput, emptyEmailError, emailError);
    }
  });

  // Event listener for form submission
  submitButton.addEventListener("click", (event) => {
    event.preventDefault(); // Prevent default form submission

    // Validate inputs
    const isNameValid = textVerify(nameInput.value);
    const isEmailValid = emailVerify(emailInput.value);
    const isSubjectValid = subjectInput.value.trim() !== "";
    const isMessageValid = messageTextarea.value.trim() !== "";

    // Check if all inputs are valid
    if (isNameValid && isEmailValid && isSubjectValid && isMessageValid) {
        popup.style.display = "block"; // Show the popup
        const formData = new FormData();
        formData.append("name", nameInput.value);
        formData.append("email", emailInput.value);
        formData.append("subject", subjectInput.value);
        formData.append("message", messageTextarea.value);

        const request = fetch("/api/contact.php", {
            method: "POST",
            body: formData,
        });
        request.then(response => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            popup.style.display = "block";
            document.querySelector("form").reset();
            for (const element of document.querySelectorAll(".valid")) {
              element.classList.remove("valid");
            }
        })
            .catch(error => {
                console.error(error);
        });

    } else {
        alert("Please correct the highlighted errors and try again.");
    }
  });

  // Function to close the popup
  window.closePopup = function() {
    popup.style.display = "none";
  };
});