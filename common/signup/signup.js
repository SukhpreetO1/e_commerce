var field_validation_status = {
  first_name: { is_valid: false, error_message: '' },
  last_name: { is_valid: false, error_message: '' },
  username: { is_valid: false, error_message: '' },
  email: { is_valid: false, error_message: '' },
  mobile_number: { is_valid: false, error_message: '' },
  date_of_birth: { is_valid: false, error_message: '' },
  password: { is_valid: false, error_message: '' },
  confirm_password: { is_valid: false, error_message: '' }
};

// Showing validaton message when press tab button
document.getElementById('first_name').addEventListener('blur', function () {
  validate_first_name();
});

document.getElementById('last_name').addEventListener('blur', function () {
  validate_last_name();
});

document.getElementById('username').addEventListener('blur', function () {
  validate_username();
});

document.getElementById('email').addEventListener('blur', function () {
  validate_email_and_update_status();
});

document.getElementById('mobile_number').addEventListener('blur', function () {
  validate_mobile_number_and_update_status();
});

document.getElementById('date_of_birth').addEventListener('blur', function () {
  validate_date_of_birth_and_update_status();
});

document.getElementById('password').addEventListener('blur', function () {
  validate_password_and_update_status();
});

document.getElementById('confirm_password').addEventListener('blur', function () {
  validate_confirm_password_and_update_status();
});

function validate_first_name() {
  var first_name = document.getElementById('first_name').value;
  var firstNameRegex = /^[a-zA-Z]+$/;

  if (is_empty(first_name)) {
    display_error('first_name_err', 'First Name cannot be empty');
    add_invalid_class('first_name');
    return false;
  } else if (!firstNameRegex.test(first_name)) {
    display_error('first_name_err', 'First Name should contain only letters');
    add_invalid_class('first_name');
    return false;
  }

  return true;
}

function validate_last_name() {
  var last_name = document.getElementById('last_name').value;
  var lastNameRegex = /^[a-zA-Z]+$/;

  if (is_empty(username)) {
    display_error('last_name_err', 'Last Name cannot be empty');
    add_invalid_class('last_name');
    return false;
  } else if (!lastNameRegex.test(last_name)) {
    display_error('last_name_err', 'Last Name should contain only letters');
    add_invalid_class('last_name');
    return false;
  }

  return true;
}

function validate_username() {
  var username = document.getElementById('username').value;
  var usernameRegex = /^[a-zA-Z0-9]+$/;

  if (is_empty(username)) {
    display_error('username_err', 'Username cannot be empty');
    add_invalid_class('username');
    return false;
  } else if (!usernameRegex.test(username)) {
    display_error('username_err', 'Username should contain letters and numbers');
    add_invalid_class('username');
    return false;
  }

  return true;
}




// Event listener for form submission
document.getElementById('submit_button').addEventListener('click', function (event) {
  clear_error_messages();

  // Validate all fields
  var is_valid = true;
  var empty_fields = [];

  if (!validate_field_and_update_status('first_name', 'First Name', /^[a-zA-Z]+$/)) {
    empty_fields.push('first_name');
    is_valid = false;
  }

  if (!validate_field_and_update_status('last_name', 'Last Name', /^[a-zA-Z]+$/)) {
    empty_fields.push('last_name');
    is_valid = false;
  }

  if (!validate_field_and_update_status('username', 'Username', /^[a-zA-Z0-9]+$/)) {
    empty_fields.push('username');
    is_valid = false;
  }

  if (!validate_email_and_update_status()) {
    empty_fields.push('email');
    is_valid = false;
  }

  if (!validate_mobile_number_and_update_status()) {
    empty_fields.push('mobile_number');
    is_valid = false;
  }

  if (!validate_date_of_birth_and_update_status()) {
    empty_fields.push('date_of_birth');
    is_valid = false;
  }

  if (!validate_password_and_update_status()) {
    empty_fields.push('password');
    is_valid = false;
  }

  if (!validate_confirm_password_and_update_status()) {
    empty_fields.push('confirm_password');
    is_valid = false;
  }

  if (!is_valid) {
    event.preventDefault(); // Prevent form submission if there are validation errors
    display_error_messages(empty_fields);
  }
});

function validate_field_and_update_status(field_id, field_name, regex) {
  var is_valid = true;
  var field_element = document.getElementById(field_id);

  if (field_element) {
    var field_value = field_element.value;

    if (is_empty(field_value)) {
      display_error(field_id + '_err', field_name + ' cannot be empty');
      add_invalid_class(field_id);
      is_valid = false;
    } else if (!regex.test(field_value)) {
      display_error(field_id + '_err', field_name + ' should contain only specified characters');
      add_invalid_class(field_id);
      is_valid = false;
    }

    if (!is_empty(field_value)) {
      clear_error_messages(field_id + '_err');
      clear_invalid_class(field_id);
    }

    field_validation_status[field_id] = is_valid;
  }

  return is_valid;
}

function validate_email_and_update_status() {
  var email = document.getElementById('email').value;
  var emailRegex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;

  if (is_empty(email)) {
    display_error('email_err', 'Email cannot be empty');
    add_invalid_class('email');
    return false;
  } else if (!emailRegex.test(email)) {
    display_error('email_err', 'Invalid email format. Format should be like abc@gmail.com');
    add_invalid_class('email');
    return false;
  }

  return true;
}

function validate_mobile_number_and_update_status() {
  var mobile_number = document.getElementById('mobile_number').value;
  var mobileNumberRegex = /^\d{10,12}$/;

  if (is_empty(mobile_number)) {
    display_error('mobile_number_err', 'Mobile Number cannot be empty');
    add_invalid_class('mobile_number');
    return false;
  } else if (!mobileNumberRegex.test(mobile_number)) {
    display_error('mobile_number_err', 'Mobile number must contain 10 to 12 numbers only.');
    add_invalid_class('mobile_number');
    return false;
  }

  return true;
}

$(document).ready(function () {
  $('#date_of_birth').on('change', function () {
    validate_date_of_birth_and_update_status();
  });
});

function validate_date_of_birth_and_update_status() {
  var date_of_birth = $('#date_of_birth').datepicker('getDate');
  if (date_of_birth != null) {
    clear_invalid_class('date_of_birth');
    return true;
  } else {
    display_error('date_of_birth_err', 'Please select your date of birth');
    add_invalid_class('date_of_birth');
    return false;
  }
}

function validate_password_and_update_status() {
  var password = document.getElementById('password').value;
  var password_regex = /^(?=.*\d)(?=.*[a-z]|[A-Z]).{6,20}$/;

  if (is_empty(password)) {
    display_error('password_err', 'Password cannot be empty');
    add_invalid_class('password');
  } else if (!password_regex.test(password)) {
    display_error('password_err', 'Invalid password format. Must contain at least 6 characters, 1 capital letter and 1 number.');
    add_invalid_class('password');
  }

  return true;
}

function validate_confirm_password_and_update_status() {
  var password = document.getElementById('password').value;
  var confirm_password = document.getElementById('confirm_password').value;

  if (is_empty(confirm_password)) {
    display_error('confirm_password_err', 'Confirm password cannot be empty');
    add_invalid_class('confirm_password');
    return false;
  } else if (password !== confirm_password) {
    display_error('confirm_password_err', 'Password do not match');
    add_invalid_class('confirm_password');
    return false;
  } else {
    clear_error_messages('confirm_password_err');
    clear_invalid_class('confirm_password');
  }

  return true;
}





// Function to display error messages for empty fields
function display_error_messages(fields) {
  var customMessages = {
    first_name: "First name cannot be empty",
    last_name: "Last name cannot be empty",
    username: "Username cannot be empty",
    email: "Email cannot be empty",
    mobile_number: "Mobile number cannot be empty",
    date_of_birth: "Date of birth cannot be empty",
    password: "Password cannot be empty",
    confirm_password: "Confirm password cannot be empty",
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

document.getElementById('first_name').addEventListener('input', function () {
  validate_field_on_input('first_name', 'First name', /^[a-zA-Z]+$/);
});

document.getElementById('last_name').addEventListener('input', function () {
  validate_field_on_input('last_name', 'Last name', /^[a-zA-Z]+$/);
});

document.getElementById('username').addEventListener('input', function () {
  validate_field_on_input('username', 'Username', /^(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]+$/);
});

document.getElementById('email').addEventListener('input', function () {
  validate_field_on_input('email', 'Email', /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/);
});

document.getElementById('mobile_number').addEventListener('input', function () {
  validate_field_on_input('mobile_number', 'Mobile number', /^\d{10,12}$/);
});

document.getElementById('password').addEventListener('input', function () {
  validate_field_on_input('password', 'Password', /^(?=.*\d)(?=.*[a-z]|[A-Z]).{6,20}$/);
});

document.getElementById('confirm_password').addEventListener('input', function () {
  validate_field_on_input('confirm_password', 'Confirm password', /^(?=.*\d)(?=.*[a-z]|[A-Z]).{6,20}$/);
  var passwordValue = document.getElementById('password').value;
  var confirmPasswordValue = document.getElementById('confirm_password').value;

  if (passwordValue !== confirmPasswordValue) {
    display_error('confirm_password_err', 'Password do not match');
    add_invalid_class('confirm_password');
    clear_password_match_classes(); // New function to clear the green border
    field_validation_status['confirm_password'] = false;
  } else {
    clear_error_messages('confirm_password_err');
    clear_invalid_class('confirm_password');
    add_password_match_classes(); // New function to add green border
    field_validation_status['confirm_password'] = true;
  }
});

function clear_password_match_classes() {
  document.getElementById('password').classList.remove('password-match');
  document.getElementById('confirm_password').classList.remove('password-match');
}

function add_password_match_classes() {
  document.getElementById('password').classList.add('password-match');
  document.getElementById('confirm_password').classList.add('password-match');
}

function validate_field_on_input(field_id, field_name, regex) {
  var field_value = document.getElementById(field_id).value;

  if (!is_empty(field_value) && regex.test(field_value)) {
    clear_error_messages();
    clear_invalid_class(field_id);
    field_validation_status[field_id] = true;
  } else {
    // display_error(field_id + '_err', field_name + ' should contain only specified characters');
    display_error('first_name_err', 'First name should contain only letters');
    display_error('last_name_err', 'Last name should contain only letters');
    display_error('username_err', 'Username must contain 1 capital letter and 1 numbers.');
    display_error('email_err', 'Invalid email format. Format should be like abc@gmail.com');
    display_error('mobile_number_err', 'Mobile number must contain 10 to 12 numbers only.');
    display_error('password_err', 'Invalid password format. Must contain at least 6 characters, 1 capital letter and 1 number.');
    display_error('confirm_password_err', 'Password do not match');
    add_invalid_class(field_id);
    field_validation_status[field_id] = false;
  }
}

function clear_error_messages() {
  var errorElements = document.getElementsByClassName('error-message');
  for (var i = 0; i < errorElements.length; i++) {
    errorElements[i].textContent = '';
  }
}

function add_invalid_class(field) {
  document.getElementById(field).classList.add('is-invalid');
}

function clear_invalid_class(field) {
  document.getElementById(field).classList.remove('is-invalid');
}

function is_empty(value) {
  return typeof value === 'string' && value.trim() === '';
}

function display_error(error_id, error_message) {
  document.getElementById(error_id).textContent = error_message;
}

function clear_error_messages() {
  var errorElements = document.getElementsByClassName('error-message');
  for (var i = 0; i < errorElements.length; i++) {
    errorElements[i].textContent = '';
  }
}

function toggle_password_visibility() {
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

function toggle_confirm_password_visibility() {
  var passwordInput = document.getElementById('confirm_password');
  var eyeIcon = document.querySelector('.visible_confirm_password i');

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

document.addEventListener("DOMContentLoaded", function () {
  var visible_password_icon = document.getElementById('visible_password');
  var password_value = document.getElementById('password').value;
  if (password_value.length > 0) {
    visible_password_icon.style.display = 'block';
  } else {
    visible_password_icon.style.display = 'none';
  }
});

document.addEventListener("DOMContentLoaded", function () {
  var visible_confirm_password_icon = document.getElementById('visible_confirm_password');
  var confirm_password_value = document.getElementById('confirm_password').value;
  if (confirm_password_value.length > 0) {
    visible_confirm_password_icon.style.display = 'block';
  } else {
    visible_confirm_password_icon.style.display = 'none';
  }
});

document.getElementById('confirm_password').addEventListener('input', function () {
  var visible_confirm_password_icon = document.getElementById('visible_confirm_password');
  if (this.value.length > 0) {
    visible_confirm_password_icon.style.display = 'block';
  } else {
    visible_confirm_password_icon.style.display = 'none';
  }
});