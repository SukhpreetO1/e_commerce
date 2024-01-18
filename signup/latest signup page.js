var field_validation_status = {
  first_name: { is_valid: false, error_message: '' },
  last_name: { is_valid: false, error_message: '' },
  username: { is_valid: false, error_message: '' },
  email: { is_valid: false, error_message: '' },
  password: { is_valid: false, error_message: '' },
  confirm_password: { is_valid: false, error_message: '' }
};

var form = document.getElementById('myForm');
var fields = ['first_name', 'last_name', 'username', 'email', 'password', 'confirm_password'];

// Cache DOM elements
var elements = {};
fields.forEach(function(field) {
  elements[field] = document.getElementById(field);
});

// Event listeners for blur and input events
form.addEventListener('blur', function(event) {
  var target = event.target;
  var field = target.id;
  
  if (fields.includes(field)) {
    validateFieldAndUpdateStatus(field);
  }
}, true);

form.addEventListener('input', function(event) {
  var target = event.target;
  var field = target.id;
  
  if (fields.includes(field)) {
    clearErrorMessages(field + '_err');
    clearInvalidClass(field);
    validateFieldOnInput(field);
  }
}, true);

// Event listener for form submission
document.getElementById('submit_button').addEventListener('click', function(event) {
  clearErrorMessages();

  // Validate all fields
  var is_valid = true;

  fields.forEach(function(field) {
    is_valid = is_valid && validateFieldAndUpdateStatus(field);
  });

  if (!is_valid) {
    event.preventDefault(); // Prevent form submission if there are validation errors
  }
});

// Event listener for page refresh
window.addEventListener('beforeunload', function() {
  clearErrorMessages();
});

// Validation functions
function validateFieldAndUpdateStatus(field) {
  clearErrorMessages();
  var is_valid = true;
  var field_value = elements[field].value;

  if (isEmpty(field_value)) {
    displayError(field + '_err', 'Cannot be empty');
    addInvalidClass(field);
    is_valid = false;
  } else if (!isValidFormat(field, field_value)) {
    displayError(field + '_err', 'Invalid format');
    addInvalidClass(field);
    is_valid = false;
  }

  field_validation_status[field] = is_valid;
  return is_valid;
}

function validateFieldOnInput(field) {
  var field_value = elements[field].value;

  if (!isEmpty(field_value) && isValidFormat(field, value)) {
    console.log(field);
    clearErrorMessages();
    clearInvalidClass(field);
    field_validation_status[field] = true;
  }
}

function isValidFormat(field, value) {
  switch (field) {
    case 'first_name':
    return /^[a-zA-Z]+$/.test(value);
    case 'last_name':
      return /^[a-zA-Z]+$/.test(value);
    case 'username':
      return /^(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]+$/.test(value);
    case 'email':
      return /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(value);
    case 'password':
      return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/.test(value);
    case 'confirm_password':
      return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/.test(value);
    default:
      return true;
    }
}

function addInvalidClass(field) {
  elements[field].classList.add('is-invalid');
}

function clearInvalidClass(field) {
  elements[field].classList.remove('is-invalid');
}

function isEmpty(value) {
  return value.trim() === '';
}

function displayError(element_id, message) {
  var error_message_element = document.getElementById(element_id);
  error_message_element.textContent = message;
}

function clearErrorMessages() {
  fields.forEach(function(field) {
    clearErrorMessage(field + '_err');
  });
}

function clearErrorMessage(element_id) {
  var error_message_element = document.getElementById(element_id);
  error_message_element.textContent = '';
}