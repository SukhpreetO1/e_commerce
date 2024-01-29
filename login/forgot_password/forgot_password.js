$(document).ready(function() {
    $('#forgot_password_form').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'send_token_email.php',
            data: formData,
            success: function(response) {
                try {
                    var jsonResponse = JSON.parse(response);
                    if (jsonResponse.redirect_url) {
                        alert(jsonResponse.message);
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


const field_validation_status = {};

document.getElementById('email').addEventListener('input', function () {
  const emailField = document.getElementById('email');
  const isValid = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(emailField.value.trim());
  updateFieldStatus('email', isValid, 'Invalid email format. Format should be like abc@gmail.com');
});

function updateFieldStatus(field_id, isValid, errorMessage) {
  const field = document.getElementById(field_id);
  if (isValid) {
    clearError(field_id);
    field.classList.remove('is-invalid');
    field_validation_status[field_id] = true;
  } else {
    displayError(`${field_id}_err`, errorMessage);
    field.classList.add('is-invalid');
    field_validation_status[field_id] = false;
  }
}

function displayError(error_id, error_message) {
  document.getElementById(error_id).textContent = error_message;
}

function clearError(field_id) {
  displayError(`${field_id}_err`, '');
}