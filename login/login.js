document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('form').addEventListener('submit', function (event) {
        if (!validateForm()) {
            event.preventDefault();
        }
    });

    document.getElementById('email').addEventListener('blur', validateEmail);
    document.getElementById('password').addEventListener('blur', validatePassword);
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

function addInvalidClass(field) {
    document.getElementById(field).classList.add('is-invalid');
}

function validateEmail() {
    clearErrorMessage('email_err');

    var email = document.getElementById('email').value;
    var emailRegex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;

    if (email === '') {
        displayError('email_err', 'Email cannot be empty');
    } else if (!emailRegex.test(email)) {
        displayError('email_err', 'Invalid email format');
    }
}

function validatePassword() {
    clearErrorMessage('password_err');

    var password = document.getElementById('password').value;
    var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;

    if (password === '') {
        displayError('password_err', 'Password cannot be empty');
    } else if (!passwordRegex.test(password)) {
        displayError('password_err', 'Invalid password format');
    }
}

function displayError(elementId, message) {
    var errorMessageElement = document.getElementById(elementId);
    errorMessageElement.textContent = message;
}

function clearErrorMessage(elementId) {
    var errorMessageElement = document.getElementById(elementId);
    errorMessageElement.textContent = '';
}

function clearErrorMessages() {
    clearErrorMessage('email_err');
    clearErrorMessage('password_err');
}
