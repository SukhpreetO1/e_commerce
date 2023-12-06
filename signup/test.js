document.getElementById('first_name').addEventListener('blur', function () {
  clear_error_messages();
  clear_invalid_class('first_name');
  validate_first_name();
});

document.getElementById('last_name').addEventListener('blur', function () {
  clear_error_messages();
  clear_invalid_class('last_name');
  validate_last_name();
});

document.getElementById('username').addEventListener('blur', function () {
  clear_error_messages();
  clear_invalid_class('username');
  validate_username();
});

document.getElementById('email').addEventListener('blur', function () {
  clear_error_messages();
  clear_invalid_class('email');
  validate_email();
});

document.getElementById('password').addEventListener('blur', function () {
  clear_error_messages();
  clear_invalid_class('password');
  validate_password();
});

document.getElementById('confirm_password').addEventListener('blur', function () {
  clear_error_messages();
  clear_invalid_class('confirm_password');
  validate_confirm__password();
});



function validate_first_name() {
  var first_name = document.getElementById('first_name').value;

  if (is_empty(first_name)) {
    display_error('first_name_err', 'First Name cannot be empty');
    addInvalidClass('first_name');
  } else if (!/^[a-zA-Z]+$/.test(first_name)) {
    display_error('first_name_err', 'First Name should contain only letters');
    addInvalidClass('first_name');
  }
}

function validate_last_name() {
  var last_name = document.getElementById('last_name').value;

  if (is_empty(last_name)) {
    display_error('last_name_err', 'Last Name cannot be empty');
    addInvalidClass('last_name');
  } else if (!/^[a-zA-Z]+$/.test(last_name)) {
    display_error('last_name_err', 'Last Name should contain only letters');
    addInvalidClass('last_name');
  }
}

function validate_username() {
  var username = document.getElementById('username').value;

  if (is_empty(username)) {
    display_error('username_err', 'Username cannot be empty');
    addInvalidClass('username');
  } else if (!/^[a-zA-Z0-9]+$/.test(username)) {
    display_error('username_err', 'Username should contain only letters and numbers');
    addInvalidClass('username');
  }
}

function validate_email() {
  var email = document.getElementById('email').value;
  var emailRegex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;

  if (is_empty(email)) {
    display_error('email_err', 'Email cannot be empty');
    addInvalidClass('email');
  } else if (!emailRegex.test(email)) {
    display_error('email_err', 'Invalid email format. Format should be like abc@gmail.com');
    addInvalidClass('email');
  }
}

function validate_password() {
  var password = document.getElementById('password').value;
  var password_regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;

  if (is_empty(password)) {
    display_error('password_err', 'Password cannot be empty');
    addInvalidClass('password');
  } else if (!password_regex.test(password)) {
    display_error('password_err', 'Invalid password format. Must contain at least 6 characters, 1 capital letter');
    addInvalidClass('password');
  }
}

function validate_confirm__password() {
  var password = document.getElementById('password').value;
  var confirm__password = document.getElementById('confirm_password').value;

  if (is_empty(confirm__password)) {
    display_error('confirm_password_err', 'Confirm Password cannot be empty');
    addInvalidClass('confirm_password');
  } else if (password !== confirm__password) {
    display_error('confirm_password_err', 'Passwords do not match');
    addInvalidClass('confirm_password');
  }
}

function addInvalidClass(field) {
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

function clear_error_message(element_id) {
  var error_message_element = document.getElementById(element_id);
  error_message_element.text_content = '';
}

function clear_error_messages() {
  clear_error_message('first_name_err');
  clear_error_message('last_name_err');
  clear_error_message('username_err');
  clear_error_message('email_err');
  clear_error_message('password_err');
  clear_error_message('confirm_password_err');
}




function validateForm() {
  clear_error_messages();

  var first_name = document.getElementById('first_name').value;
  var last_name = document.getElementById('last_name').value;
  var username = document.getElementById('username').value;
  var email = document.getElementById('email').value;
  var password = document.getElementById('password').value;
  var confirm__password = document.getElementById('confirm_password').value;

  var is_valid = true;

  // Validate First Name
  if (is_empty(first_name)) {
    display_error('first_name_err', 'First Name cannot be empty');
    addInvalidClass('first_name');
    is_valid = false;
  } else if (!/^[a-zA-Z]+$/.test(first_name)) {
    display_error('first_name_err', 'First Name should contain only letters');
    addInvalidClass('first_name');
    is_valid = false;
  }

  // Validate Last Name
  if (is_empty(last_name)) {
    display_error('last_name_err', 'Last Name cannot be empty');
    addInvalidClass('last_name');
    is_valid = false;
  } else if (!/^[a-zA-Z]+$/.test(last_name)) {
    display_error('last_name_err', 'Last Name should contain only letters');
    addInvalidClass('last_name');
    is_valid = false;
  }

  // Validate Username
  if (is_empty(username)) {
    display_error('username_err', 'Username cannot be empty');
    addInvalidClass('username');
    is_valid = false;
  } else if (!/^[a-zA-Z0-9]+$/.test(username)) {
    display_error('username_err', 'Username should contain only letters and numbers');
    addInvalidClass('username');
    is_valid = false;
  }

  // Validate Email
  var emailRegex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
  if (is_empty(email)) {
    display_error('email_err', 'Email cannot be empty');
    addInvalidClass('email');
    is_valid = false;
  } else if (!emailRegex.test(email)) {
    display_error('email_err', 'Invalid email format. Format should be like abc@gmail.com');
    addInvalidClass('email');
    is_valid = false;
  }

  // Validate Password
  var password_regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
  if (is_empty(password)) {
    display_error('password_err', 'Password cannot be empty');
    addInvalidClass('password');
    is_valid = false;
  } else if (!password_regex.test(password)) {
    display_error('password_err', 'Invalid password format. Must contain at least 6 characters, 1 capital letter');
    addInvalidClass('password');
    is_valid = false;
  }

  // Validate Confirm Password
  if (is_empty(confirm__password)) {
    display_error('confirm_password_err', 'Confirm Password cannot be empty');
    addInvalidClass('confirm_password');
    is_valid = false;
  } else if (password !== confirm__password) {
    display_error('confirm_password_err', 'Passwords do not match');
    addInvalidClass('confirm_password');
    is_valid = false;
  }

  return is_valid;
}
