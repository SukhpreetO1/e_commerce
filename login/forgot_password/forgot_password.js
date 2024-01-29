$(document).ready(function() {
    $('#forgot_password_form').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            // url: 'send_token_email.php',
            data: formData,
            success: function(response) {
              // window.location.href = "../login.php?mail_send=true";
                try {
                    var jsonResponse = JSON.parse(response);
                    if (jsonResponse.redirect_url) {
                        window.location.href = jsonResponse.redirect_url;
                    } else {
                        alert('An error occurred while processing the request.');
                    }
                } catch (e) {
                    alert('An error occurred while processing the response.');
                }
            },
            error: function(error) {
                alert('An error occurred while processing the request.');
            }
        });
    });
});


document.getElementById('send_link').addEventListener('click', function (event) {
  clearError();

  var is_valid = true;
  var empty_fields = [];

  if (!updateFieldStatus('email', 'Email', /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/)) {
    empty_fields.push('email');
    is_valid = false;
  }

  if (!is_valid) {
    event.preventDefault();
    displayError(empty_fields);
  }
});  

const field_validation_status = {};
document.getElementById('email').addEventListener('input', function () {
  const emailField = document.getElementById('email');
  const isValid = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(emailField.value.trim());
  updateFieldStatus('email', isValid, 'Invalid email format. Format should be like abc@gmail.com');
});

function updateFieldStatus(field_id, isValid, errorMessage) {
  const field = document.getElementById(field_id);
  if (isValid == true) {
    clearError(field_id);
    field.classList.remove('is-invalid');
    field_validation_status[field_id] = true;
  } else {
    displayError('email_err', errorMessage);
    field.classList.add('is-invalid');
    field_validation_status[field_id] = false;
  }
}

function displayError() {
  var errorMessageElement = document.getElementById('email_err');
  errorMessageElement.textContent = 'Email cannot be empty';
}

function clearError() {
  displayError('email_err', '');
}

function isEmpty(value) {
  return typeof value === 'string' && value.trim() === '';
} 