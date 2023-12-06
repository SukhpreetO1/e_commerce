var field_validation_status = {
  first_name: { is_valid: false, error_message: '' },
  last_name: { is_valid: false, error_message: '' },
  username: { is_valid: false, error_message: '' },
  email: { is_valid: false, error_message: '' },
  password: { is_valid: false, error_message: '' },
  confirm_password: { is_valid: false, error_message: '' }
};

document.getElementById('first_name').addEventListener('blur', function () {
  validate_field_and_update_status('first_name', 'First Name', /^[a-zA-Z]+$/);
});

document.getElementById('last_name').addEventListener('blur', function () {
  validate_field_and_update_status('last_name', 'Last Name', /^[a-zA-Z]+$/);
});

document.getElementById('username').addEventListener('blur', function () {
  validate_field_and_update_status('username', 'Username', /^[a-zA-Z0-9]+$/);
});

document.getElementById('email').addEventListener('blur', function () {
  validate_email_and_update_status();
});

document.getElementById('password').addEventListener('blur', function () {
  validate_password_and_update_status();
});

document.getElementById('confirm_password').addEventListener('blur', function () {
  validate_confirm_password_and_update_status();
});

// Event listeners for input events on input fields
document.getElementById('first_name').addEventListener('input', function () {
  clear_error_messages('first_name_err');
  clear_invalid_class('first_name');
  validate_field_on_input('first_name', 'First Name', /^[a-zA-Z]+$/);
});

document.getElementById('last_name').addEventListener('input', function () {
  clear_error_messages('last_name_err');
  clear_invalid_class('last_name');
  validate_field_on_input('last_name', 'Last Name', /^[a-zA-Z]+$/);
});

document.getElementById('username').addEventListener('input', function () {
  clear_error_messages('username_err');
  clear_invalid_class('username');
  validate_field_on_input('username', 'Username', /^[a-zA-Z]+[a-zA-Z0-9]*$/);
});

document.getElementById('email').addEventListener('input', function () {
  clear_error_messages('email_err');
  clear_invalid_class('email');
  validate_field_on_input('email', 'Email', /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/);
});

document.getElementById('password').addEventListener('input', function () {
  clear_error_messages('password_err');
  clear_invalid_class('password');
  validate_field_on_input('password', 'Password', /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/);
});

document.getElementById('confirm_password').addEventListener('input', function () {
  clear_error_messages('confirm_password_err');
  clear_invalid_class('confirm_password');
  validate_field_on_input('confirm_password', 'Confirm Password', /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/);
});

// Event listener for form submission
document.getElementById('submit_button').addEventListener('click', function (event) {
  clear_error_messages();

  // Validate all fields
  var is_valid = true;

  is_valid = is_valid && validate_field_and_update_status('first_name', 'First Name', /^[a-zA-Z]+$/);
  is_valid = is_valid && validate_field_and_update_status('last_name', 'Last Name', /^[a-zA-Z]+$/);
  is_valid = is_valid && validate_field_and_update_status('username', 'Username', /^[a-zA-Z0-9]+$/);
  is_valid = is_valid && validate_email_and_update_status();
  is_valid = is_valid && validate_password_and_update_status();
  is_valid = is_valid && validate_confirm_password_and_update_status();

  if (!is_valid) {
    event.preventDefault(); // Prevent form submission if there are validation errors
  }
});

// Validation functions
function validate_field_and_update_status(field_id, field_name, regex) {
  clear_error_messages();
  var is_valid = true;
  var field_value = document.getElementById(field_id).value;

  if (is_empty(field_value)) {
    display_error(field_id + '_err', field_name + ' cannot be empty');
    add_invalid_class(field_id);
    is_valid = false;
  } else if (!regex.test(field_value)) {
    display_error(field_id + '_err', field_name + ' should contain only specified characters');
    add_invalid_class(field_id);
    is_valid = false;
  }

  field_validation_status[field_id] = is_valid;
  return is_valid;
}

function validate_field_on_input(field_id, field_name, regex) {
  var field_value = document.getElementById(field_id).value;

  if (!is_empty(field_value) && regex.test(field_value)) {
    clear_error_messages();
    clear_invalid_class(field_id);
    field_validation_status[field_id] = true;
  }
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

function validate_password_and_update_status() {
  var password = document.getElementById('password').value;
  var password_regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;

  if (is_empty(password)) {
    display_error('password_err', 'Password cannot be empty');
    add_invalid_class('password');
    return false;
  } else if (!password_regex.test(password)) {
    display_error('password_err', 'Invalid password format. Must contain at least 6 characters, 1 capital letter');
    add_invalid_class('password');
    return false;
  }

  return true;
}

function validate_confirm_password_and_update_status() {
  var password = document.getElementById('password').value;
  var confirm_password = document.getElementById('confirm_password').value;

  if (is_empty(confirm_password)) {
    display_error('confirm_password_err', 'Confirm Password cannot be empty');
    add_invalid_class('confirm_password');
    return false;
  } else if (password !== confirm_password) {
    display_error('confirm_password_err', 'Passwords do not match');
    add_invalid_class('confirm_password');
    return false;
  }

  return true;
}

function add_invalid_class(field) {
  document.getElementById(field).classList.add('is-invalid');
}

function clear_invalid_class(field) {
  document.getElementById(field).classList.remove('is-invalid');
}

function is_empty(value) {
  return value.trim() === '';
}   

function display_error(element_id, message) {
  var error_message_element = document.getElementById(element_id);
  error_message_element.text_content = message;
}

function clear_error_messages() {
  clear_error_message('first_name_err');
  clear_error_message('last_name_err');
  clear_error_message('username_err');
  clear_error_message('email_err');
  clear_error_message('password_err');
  clear_error_message('confirm_password_err');
}

function clear_error_message(element_id) {
  var error_message_element = document.getElementById(element_id);
  error_message_element.text_content = '';
}
