var fieldValidationStatus = {
  first_name: { isValid: false, errorMessage: '' },
  last_name: { isValid: false, errorMessage: '' },
  username: { isValid: false, errorMessage: '' },
  email: { isValid: false, errorMessage: '' },
  password: { isValid: false, errorMessage: '' },
  confirm_password: { isValid: false, errorMessage: '' }
};

document.getElementById('first_name').addEventListener('blur', function () {
  validateFieldAndUpdateStatus('first_name', 'First Name', /^[a-zA-Z]+$/);
});

document.getElementById('last_name').addEventListener('blur', function () {
  validateFieldAndUpdateStatus('last_name', 'Last Name', /^[a-zA-Z]+$/);
});

document.getElementById('username').addEventListener('blur', function () {
  validateFieldAndUpdateStatus('username', 'Username', /^[a-zA-Z0-9]+$/);
});

document.getElementById('email').addEventListener('blur', function () {
  validateEmailAndUpdateStatus();
});

document.getElementById('password').addEventListener('blur', function () {
  validatePasswordAndUpdateStatus();
});

document.getElementById('confirm_password').addEventListener('blur', function () {
  validateConfirmPasswordAndUpdateStatus();
});

// Event listeners for input events on input fields
document.getElementById('first_name').addEventListener('input', function () {
  clearErrorMessages('first_name_err');
  clearInvalidClass('first_name');
  validateFieldOnInput('first_name', 'First Name', /^[a-zA-Z]+$/);
});

document.getElementById('last_name').addEventListener('input', function () {
  clearErrorMessages('last_name_err');
  clearInvalidClass('last_name');
  validateFieldOnInput('last_name', 'Last Name', /^[a-zA-Z]+$/);
});

document.getElementById('username').addEventListener('input', function () {
  clearErrorMessages('username_err');
  clearInvalidClass('username');
  validateFieldOnInput('username', 'Username', /^[a-zA-Z0-9]+$/);
});

document.getElementById('email').addEventListener('input', function () {
  clearErrorMessages('email_err');
  clearInvalidClass('email');
  validateFieldOnInput('email', 'Email', /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/);
});

document.getElementById('password').addEventListener('input', function () {
  clearErrorMessages('password_err');
  clearInvalidClass('password');
  validateFieldOnInput('password', 'Password', /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/);
});

document.getElementById('confirm_password').addEventListener('input', function () {
  clearErrorMessages('confirm_password_err');
  clearInvalidClass('confirm_password');
  validateFieldOnInput('confirm_password', 'Confirm Password', /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/);
});

// Event listener for form submission
document.getElementById('submit_button').addEventListener('click', function (event) {
  clearErrorMessages();

  // Validate all fields
  var isValid = true;

  isValid = isValid && validateFieldAndUpdateStatus('first_name', 'First Name', /^[a-zA-Z]+$/);
  isValid = isValid && validateFieldAndUpdateStatus('last_name', 'Last Name', /^[a-zA-Z]+$/);
  isValid = isValid && validateFieldAndUpdateStatus('username', 'Username', /^[a-zA-Z0-9]+$/);
  isValid = isValid && validateEmailAndUpdateStatus();
  isValid = isValid && validatePasswordAndUpdateStatus();
  isValid = isValid && validateConfirmPasswordAndUpdateStatus();

  if (!isValid) {
    event.preventDefault(); // Prevent form submission if there are validation errors
  }
});

// Validation functions
function validateFieldAndUpdateStatus(fieldId, fieldName, regex) {
  clearErrorMessages();
  var isValid = true;
  var fieldValue = document.getElementById(fieldId).value;

  if (isEmpty(fieldValue)) {
    displayError(fieldId + '_err', fieldName + ' cannot be empty');
    addInvalidClass(fieldId);
    isValid = false;
  } else if (!regex.test(fieldValue)) {
    displayError(fieldId + '_err', fieldName + ' should contain only specified characters');
    addInvalidClass(fieldId);
    isValid = false;
  }

  fieldValidationStatus[fieldId] = isValid;
  return isValid;
}

function validateFieldOnInput(fieldId, fieldName, regex) {
  var fieldValue = document.getElementById(fieldId).value;

  if (!isEmpty(fieldValue) && regex.test(fieldValue)) {
    clearErrorMessages();
    clearInvalidClass(fieldId);
    fieldValidationStatus[fieldId] = true;
  }
}

function validateEmailAndUpdateStatus() {
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

function validatePasswordAndUpdateStatus() {
  var password = document.getElementById('password').value;
  var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;

  if (isEmpty(password)) {
    displayError('password_err', 'Password cannot be empty');
    addInvalidClass('password');
    return false;
  } else if (!passwordRegex.test(password)) {
    displayError('password_err', 'Invalid password format. Must contain at least 6 characters, 1 capital letter');
    addInvalidClass('password');
    return false;
  }

  return true;
}

function validateConfirmPasswordAndUpdateStatus() {
  var password = document.getElementById('password').value;
  var confirmPassword = document.getElementById('confirm_password').value;

  if (isEmpty(confirmPassword)) {
    displayError('confirm_password_err', 'Confirm Password cannot be empty');
    addInvalidClass('confirm_password');
    return false;
  } else if (password !== confirmPassword) {
    displayError('confirm_password_err', 'Passwords do not match');
    addInvalidClass('confirm_password');
    return false;
  }

  return true;
}

function addInvalidClass(field) {
  document.getElementById(field).classList.add('is-invalid');
}

function clearInvalidClass(field) {
  document.getElementById(field).classList.remove('is-invalid');
}

function isEmpty(value) {
  return value.trim() === '';
}   

function displayError(elementId, message) {
  var errorMessageElement = document.getElementById(elementId);
  errorMessageElement.textContent = message;
}

function clearErrorMessages() {
  clearErrorMessage('first_name_err');
  clearErrorMessage('last_name_err');
  clearErrorMessage('username_err');
  clearErrorMessage('email_err');
  clearErrorMessage('password_err');
  clearErrorMessage('confirm_password_err');
}

function clearErrorMessage(elementId) {
  var errorMessageElement = document.getElementById(elementId);
  errorMessageElement.textContent = '';
}
