function validate_form(event) {
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var emailErrorMsg = document.getElementById("email_err");
    var passwordErrorMsg = document.getElementById("password_err");
    var emailErrorValue = document.getElementById("email_err").value;
    var passwordErrorValue = document.getElementById("password_err").value;
    
    // Regex pattern for email validation
    var emailRegex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
    
    // Regex pattern for password validation
    var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
    
    if (email === "") {
        event.preventDefault();
        emailErrorMsg.textContent = "Email cannot be empty";
        return false;
    }
    
    if (!emailRegex.test(email)) {
        event.preventDefault();
        emailErrorMsg.textContent = emailErrorValue;
        return false;
    }

    if (password === "") {
        event.preventDefault();
        passwordErrorMsg.textContent = "Password cannot be empty";
        return false;
    }
    
    if (!passwordRegex.test(password)) {
        event.preventDefault();
        passwordErrorMsg.textContent = passwordErrorValue;
        return false;
    }
    
    // Clear the error messages if there are no validation errors
    emailErrorMsg.textContent = "";
    passwordErrorMsg.textContent = "";
}