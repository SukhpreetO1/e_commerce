
function forgot_password_validation() {
    var password = document.getElementById('forgot_password_updation').value;
    var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;

    if (isEmpty(password)) {
        displayError('password_err', 'Password cannot be empty');
        addInvalidClass('password');
    } else if (!passwordRegex.test(password)) {
        displayError('password_err', 'Invalid password format. Must contain at least 6 characters, 1 capital letter');
        addInvalidClass('password');
    }

    return true;
}

function isEmpty(value) {
    return value.trim() === '';
}

function displayError(elementId, errorMessage) {
    document.getElementById(elementId).innerHTML = errorMessage;
}

function addInvalidClass(elementId) {
    document.getElementById(elementId).classList.add('invalid');
}

// Add an event listener for input validation
document.getElementById('forgot_password_updation').addEventListener('input', function () {
    forgot_password_validation();
});
