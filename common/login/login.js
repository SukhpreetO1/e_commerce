var field_validation_status = {
  email: { is_valid: false, error_message: '' },
  password: { is_valid: false, error_message: '' },
};

// Showing validaton message when press tab button
document.getElementById('email').addEventListener('blur', function () {
  validateEmail();
});

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

  if (isEmpty(password)) {
    displayError('password_err', 'Password cannot be empty');
    addInvalidClass('password');
  }
  return true;
}



// Event listener for form submission
document.getElementById('login_submit').addEventListener('click', function (event) {
  clearErrorMessages();

  // Validate all fields
  var is_valid = true;
  var empty_fields = [];

  if (!validateEmail('email', 'Email', /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/)) {
    empty_fields.push('email');
    is_valid = false;
  }

  if (!validatePassword()) {
    empty_fields.push('password');
    is_valid = false;
  }

  if (!is_valid) {
    event.preventDefault(); // Prevent form submission if there are validation errors
    displayErrorMessages(empty_fields);
  }
});

function displayErrorMessages(fields) {
  var customMessages = {
    email: "Email cannot be empty",
    password: "Password cannot be empty",
  };

  fields.forEach(function (field) {
    var customMessage = customMessages[field] || field + " cannot be empty";
    var errorElement = document.getElementById(field + "_err");
    var fieldElement = document.getElementById(field);

    if (errorElement) {
      errorElement.textContent = customMessage;
    }

    if (fieldElement) {
      fieldElement.classList.add("invalid");
    }
  });
}


// Event listeners for input events on input fields
var field_validation_status = {};
document.getElementById('email').addEventListener('input', function () {
  validateFieldOnInput('email', 'Email', /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/);
});

function validateFieldOnInput(field_id, field_name, regex) {
  var field_value = document.getElementById(field_id).value;

  if (!isEmpty(field_value) && regex.test(field_value)) {
    clearErrorMessages();
    clearInvalidClass(field_id);
    field_validation_status[field_id] = true;
  } else {
    displayError('email_err', 'Invalid email format. Format should be like abc@gmail.com');
    addInvalidClass(field_id);
    field_validation_status[field_id] = false;
  }
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

function clearInvalidClass(field) {
  document.getElementById(field).classList.remove('is-invalid');
}

function toggle_password() {
  var passwordInput = document.getElementById('password');
  var eyeIcon = document.querySelector('.visible_password i');

  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    eyeIcon.classList.remove('fa-eye-slash');
    eyeIcon.classList.add('fa-eye');
  } else {
    passwordInput.type = 'password';
    eyeIcon.classList.remove('fa-eye');
    eyeIcon.classList.add('fa-eye-slash');
  }
}

document.getElementById('password').addEventListener('input', function () {
  var visible_password_icon = document.getElementById('visible_password');
  if (this.value.length > 0) {
    visible_password_icon.style.display = 'block';
  } else {
    visible_password_icon.style.display = 'none';
  }
});