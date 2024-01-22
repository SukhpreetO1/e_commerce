function forgot_password_validation() {
    var password = document.getElementById('forgot_password_updation').value;
    var forgot_password_regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;

    if (forgot_password_is_empty(password)) {
        forgot_password_display_error('password_err', 'Password cannot be empty');
        forgot_password_add_invalid_class('password');
    } else if (!forgot_password_regex.test(password)) {
        forgot_password_display_error('password_err', 'Invalid password format. Must contain at least 6 characters, 1 capital letter');
        forgot_password_add_invalid_class('password');
    } else {
        clear_error_and_invalid_class('password_err');
    }

    return true;
}

function forgot_password_is_empty(value) {
    return value.trim() === '';
}

function forgot_password_display_error(elementId, errorMessage) {
    document.getElementById(elementId).innerHTML = errorMessage;
}

function forgot_password_add_invalid_class(elementId) {
    document.getElementById('forgot_password_updation').classList.add('is-invalid');
}

// Add an event listener for input validation
document.getElementById('forgot_password_updation').addEventListener('input', function () {
    forgot_password_validation();
});

function clear_error_and_invalid_class(elementId) {
    document.getElementById(elementId).innerHTML = '';
    document.getElementById('forgot_password_updation').classList.remove('is-invalid');
}

// Call this function when the password is valid
clear_error_and_invalid_class('password_err');
