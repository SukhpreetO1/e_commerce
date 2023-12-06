document.getElementById('first_name').addEventListener('blur', function () {
  clearErrorMessages();
  clearInvalidClass('first_name');
  validateFirstName();
});

document.getElementById('last_name').addEventListener('blur', function () {
  clearErrorMessages();
  clearInvalidClass('last_name');
  validateLastName();
});

document.getElementById('username').addEventListener('blur', function () {
  clearErrorMessages();
  clearInvalidClass('username');
  validateUsername();
});

document.getElementById('email').addEventListener('blur', function () {
  clearErrorMessages();
  clearInvalidClass('email');
  validateEmail();
});

document.getElementById('password').addEventListener('blur', function () {
  clearErrorMessages();
  clearInvalidClass('password');
  validatePassword();
});

document.getElementById('confirm_password').addEventListener('blur', function () {
  clearErrorMessages();
  clearInvalidClass('confirm_password');
  validateConfirmPassword();
});



function validateFirstName() {
  var firstName = document.getElementById('first_name').value;

  if (isEmpty(firstName)) {
    displayError('first_name_err', 'First Name cannot be empty');
    addInvalidClass('first_name');
  } else if (!/^[a-zA-Z]+$/.test(firstName)) {
    displayError('first_name_err', 'First Name should contain only letters');
    addInvalidClass('first_name');
  }
}

function validateLastName() {
  var lastName = document.getElementById('last_name').value;

  if (isEmpty(lastName)) {
    displayError('last_name_err', 'Last Name cannot be empty');
    addInvalidClass('last_name');
  } else if (!/^[a-zA-Z]+$/.test(lastName)) {
    displayError('last_name_err', 'Last Name should contain only letters');
    addInvalidClass('last_name');
  }
}

function validateUsername() {
  var username = document.getElementById('username').value;

  if (isEmpty(username)) {
    displayError('username_err', 'Username cannot be empty');
    addInvalidClass('username');
  } else if (!/^[a-zA-Z0-9]+$/.test(username)) {
    displayError('username_err', 'Username should contain only letters and numbers');
    addInvalidClass('username');
  }
}

function validateEmail() {
  var email = document.getElementById('email').value;
  var emailRegex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;

  if (isEmpty(email)) {
    displayError('email_err', 'Email cannot be empty');
    addInvalidClass('email');
  } else if (!emailRegex.test(email)) {
    displayError('email_err', 'Invalid email format. Format should be like abc@gmail.com');
    addInvalidClass('email');
  }
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
}

function validateConfirmPassword() {
  var password = document.getElementById('password').value;
  var confirmPassword = document.getElementById('confirm_password').value;

  if (isEmpty(confirmPassword)) {
    displayError('confirm_password_err', 'Confirm Password cannot be empty');
    addInvalidClass('confirm_password');
  } else if (password !== confirmPassword) {
    displayError('confirm_password_err', 'Passwords do not match');
    addInvalidClass('confirm_password');
  }
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




function validateForm() {
  clearErrorMessages();

  var firstName = document.getElementById('first_name').value;
  var lastName = document.getElementById('last_name').value;
  var username = document.getElementById('username').value;
  var email = document.getElementById('email').value;
  var password = document.getElementById('password').value;
  var confirmPassword = document.getElementById('confirm_password').value;

  var isValid = true;

  // Validate First Name
  if (isEmpty(firstName)) {
    displayError('first_name_err', 'First Name cannot be empty');
    addInvalidClass('first_name');
    isValid = false;
  } else if (!/^[a-zA-Z]+$/.test(firstName)) {
    displayError('first_name_err', 'First Name should contain only letters');
    addInvalidClass('first_name');
    isValid = false;
  }

  // Validate Last Name
  if (isEmpty(lastName)) {
    displayError('last_name_err', 'Last Name cannot be empty');
    addInvalidClass('last_name');
    isValid = false;
  } else if (!/^[a-zA-Z]+$/.test(lastName)) {
    displayError('last_name_err', 'Last Name should contain only letters');
    addInvalidClass('last_name');
    isValid = false;
  }

  // Validate Username
  if (isEmpty(username)) {
    displayError('username_err', 'Username cannot be empty');
    addInvalidClass('username');
    isValid = false;
  } else if (!/^[a-zA-Z0-9]+$/.test(username)) {
    displayError('username_err', 'Username should contain only letters and numbers');
    addInvalidClass('username');
    isValid = false;
  }

  // Validate Email
  var emailRegex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
  if (isEmpty(email)) {
    displayError('email_err', 'Email cannot be empty');
    addInvalidClass('email');
    isValid = false;
  } else if (!emailRegex.test(email)) {
    displayError('email_err', 'Invalid email format. Format should be like abc@gmail.com');
    addInvalidClass('email');
    isValid = false;
  }

  // Validate Password
  var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
  if (isEmpty(password)) {
    displayError('password_err', 'Password cannot be empty');
    addInvalidClass('password');
    isValid = false;
  } else if (!passwordRegex.test(password)) {
    displayError('password_err', 'Invalid password format. Must contain at least 6 characters, 1 capital letter');
    addInvalidClass('password');
    isValid = false;
  }

  // Validate Confirm Password
  if (isEmpty(confirmPassword)) {
    displayError('confirm_password_err', 'Confirm Password cannot be empty');
    addInvalidClass('confirm_password');
    isValid = false;
  } else if (password !== confirmPassword) {
    displayError('confirm_password_err', 'Passwords do not match');
    addInvalidClass('confirm_password');
    isValid = false;
  }

  return isValid;
}
