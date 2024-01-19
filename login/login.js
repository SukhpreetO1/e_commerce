document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('form').addEventListener('submit', function (event) {
        if (!validateForm()) {
            event.preventDefault();
        }
    });
    document.getElementById('email').addEventListener('blur', function () {
        validateEmail();
    });
    document.getElementById('password').addEventListener('blur', function () {
        validatePassword();
    });
});

function validateForm() {
    clearErrorMessages();

    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var emailRegex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
    var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
    
    var isEmailValid = emailRegex.test(email);
    var isPasswordValid = passwordRegex.test(password);

    // Validate email
    if (email === '') {
        displayError('email_err', 'Email cannot be empty');
        addInvalidClass('email');
    } else if (!isEmailValid) {
        displayError('email_err', 'Invalid email format');
        addInvalidClass('email');
    }

    // Validate password
    if (password === '') {
        displayError('password_err', 'Password cannot be empty');
        addInvalidClass('password');
    } else if (!isPasswordValid || !/\d/.test(password) || !/[a-z]/.test(password) || !/[A-Z]/.test(password) || password.length < 6 || password.length > 20) {
        displayError('password_err', 'Invalid password format');
        addInvalidClass('password');
        return false;
    }

    // Check if either field has an error
    if (email === '' || password === '') {
        return false;
    } 
    
    if (!isEmailValid && !isPasswordValid) {
        return false;
    }

    return true;
}

function validateEmail() {
    var email = document.getElementById('email').value;
    var emailRegex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
  
    if (isEmpty(email)) {
        displayError('email_err', 'Email cannot be empty');
        addInvalidClass('email');
      return false;
    } else if (!emailRegex.test(email)) {
        displayError('email_err', 'Invalid email format. Format should be like abc@gmail.com');
        addInvalidClass('email');
      return false;
    }
    return true;
}

function validatePassword() {
    var password = document.getElementById('password').value;
    var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
  
    if (isEmpty(password)) {
        displayError('password_err', 'Password cannot be empty');
        addInvalidClass('password');
    } else if (!passwordRegex.test(password)) {
        displayError('password_err', 'Invalid password format. Must contain at least 6 characters, 1 capital letter');
        addInvalidClass('password');
    }
  
    return true;
}

function displayError(elementId, message) {
    var errorMessageElement = document.getElementById(elementId);
    errorMessageElement.textContent = message;
}

function clearErrorMessages() {
    var errorElements = document.getElementsByClassName('error-message');
    for (var i = 0; i < errorElements.length; i++) {
      errorElements[i].textContent = '';
    }
  }

  function isEmpty(value) {
    return typeof value === 'string' && value.trim() === '';
  } 

  function addInvalidClass(field) {
    document.getElementById(field).classList.add('is-invalid');
}

function addInvalidClass(field) {
    document.getElementById(field).classList.add('is-invalid');
  }
