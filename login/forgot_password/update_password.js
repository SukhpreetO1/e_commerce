// when form submitted
document.getElementById('submit_button').addEventListener('click', function (event) {
    clear_error_and_invalid_class();
  
    // Validate all fields
    var is_valid = true;
    var empty_fields = [];
    
    if (!forgot_password_validation()) {
      empty_fields.push('forgot_password_updation');
      is_valid = false;
    }
  
    if (!forgot_confirm_password_validation()) {
      empty_fields.push('forgot_confirm_password_updation');
      is_valid = false;
    }
    if (!is_valid) {
      event.preventDefault(); // Prevent form submission if there are validation errors
      display_error_messages(empty_fields);
    }
});

function display_error_messages(fields) {
var customMessages = {
    password: "Password cannot be empty",
    confirm_password: "Confirm Password cannot be empty",
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



function forgot_password_validation() {
    var password = document.getElementById('forgot_password_updation').value;
    var forgot_password_regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;

    if (forgot_password_is_empty(password)) {
        forgot_password_display_error('password_err', 'Password cannot be empty');
        forgot_password_add_invalid_class('forgot_password_updation');
    } else if (!forgot_password_regex.test(password)) {
        forgot_password_display_error('password_err', 'Invalid password format. Must contain at least 6 characters, 1 capital letter');
        forgot_password_add_invalid_class('forgot_password_updation');
    } else {
        clear_error_and_invalid_class('password_err');
    }

    return true;
}

var field_validation_status = {};
function forgot_confirm_password_validation() {
    var password_value = document.getElementById('forgot_password_updation').value;
    var confirm_password = document.getElementById('forgot_confirm_password_updation').value;
    var forgot_confirm_password_regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;

    if (forgot_password_is_empty(confirm_password)) {
        forgot_password_display_error('confirm_password_err', 'Confirm Password cannot be empty');
        forgot_password_add_invalid_class('forgot_confirm_password_updation');
        return false;
    } else if (!forgot_confirm_password_regex.test(confirm_password)) {
        forgot_password_display_error('confirm_password_err', 'Invalid password format. Must contain at least 6 characters, 1 capital letter');
        forgot_password_add_invalid_class('forgot_confirm_password_updation');
        return false;
    }
    
    if(password_value != confirm_password){
        forgot_password_display_error('confirm_password_err', 'Password do not match');
        forgot_password_add_invalid_class('forgot_confirm_password_updation');
        clear_password_match_classes();
        field_validation_status['forgot_confirm_password_updation'] = false;
    } else {
        clear_error_and_invalid_class('confirm_password_err');
        add_password_match_classes();
        field_validation_status['forgot_confirm_password_updation'] = true;
        return true;
    }
}

function clear_password_match_classes() {
    document.getElementById('forgot_password_updation').classList.remove('password_match');
    document.getElementById('forgot_confirm_password_updation').classList.remove('password_match');
  }
  
  function add_password_match_classes() {
    document.getElementById('forgot_password_updation').classList.add('password_match');
    document.getElementById('forgot_confirm_password_updation').classList.add('password_match');
  }

function forgot_password_is_empty(value) {
    return typeof value === 'string' && value.trim() === '';
}

function forgot_password_display_error(elementId, errorMessage) {
    document.getElementById(elementId).textContent = errorMessage;
}

function forgot_password_add_invalid_class(elementId) {
    document.getElementById(elementId).classList.add('is-invalid');
}

// Add an event listener for input validation
document.getElementById('forgot_password_updation').addEventListener('input', function () {
    forgot_password_validation();
});

document.getElementById('forgot_confirm_password_updation').addEventListener('input', function () {
    forgot_confirm_password_validation();
});

function clear_error_and_invalid_class(elementId) {
    document.getElementById('forgot_password_updation').classList.remove('is-invalid');
    document.getElementById('forgot_confirm_password_updation').classList.remove('is-invalid');
}

// Call this function when the password is valid
clear_error_and_invalid_class('password_err');
clear_error_and_invalid_class('confirm_password_err');

function toggle_update_password_visibility() {
    var passwordInput = document.getElementById('forgot_password_updation');
    var eyeIcon = document.querySelector('.visible_update_password i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}

function toggle_update_confirm_password_visibility() {
    var passwordInput = document.getElementById('forgot_confirm_password_updation');
    var eyeIcon = document.querySelector('.visible_update_confirm_password i');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}