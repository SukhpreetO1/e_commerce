function validateForm() {
  clearErrorMessages();

  // Get form values
  var firstName = document.getElementById('first_name').value;
  var lastName = document.getElementById('last_name').value;
  var username = document.getElementById('username').value;
  var email = document.getElementById('email').value;
  var password = document.getElementById('password').value;
  var confirmPassword = document.getElementById('confirm_password').value;

  if (isEmpty(firstName)) {
    displayError('first_name_err', 'First Name cannot be empty');
    addInvalidClass('first_name');
    return false;
  }

  if (!/^[a-zA-Z]+$/.test(firstName)) {
    displayError('first_name_err', 'First Name should contain only letters');
    addInvalidClass('first_name');
    return false;
  }

  if (isEmpty(lastName)) {
    displayError('last_name_err', 'Last Name cannot be empty');
    addInvalidClass('last_name');
    return false;
  }

  if (!/^[a-zA-Z]+$/.test(lastName)) {
    displayError('first_name_err', 'First Name should contain only letters');
    addInvalidClass('last_name');
    return false;
  }

  if (isEmpty(username)) {
    displayError('username_err', 'Username cannot be empty');
    addInvalidClass('username');
    return false;
  }

  if (!/^[a-zA-Z0-9]+$/.test(username)) {
    displayError('username_err', 'Username should contain only letters and numbers');
    addInvalidClass('username');
    return false;
  }

  var emailRegex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
  if (isEmpty(email)) {
    displayError('email_err', 'Email cannot be empty');
    addInvalidClass('email');
    return false;
  } else if (!emailRegex.test(email)) {
    displayError('email_err', 'Invalid email format');
    addInvalidClass('email');
    return false;
  }

  var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
  if (isEmpty(password)) {
    displayError('password_err', 'Password cannot be empty');
    addInvalidClass('password');
    return false;
  } else if (!passwordRegex.test(password)) {
    displayError('password_err', 'Invalid password format. Must contain atlease 6 words, 1 capital letter');
    addInvalidClass('password');
    return false;
  }

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

function isEmpty(value) {
  return value.trim() === '';
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
  clearErrorMessage('first_name_err');
  clearErrorMessage('last_name_err');
  clearErrorMessage('username_err');
  clearErrorMessage('email_err');
  clearErrorMessage('password_err');
  clearErrorMessage('confirm_password_err');
}
