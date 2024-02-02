$(document).ready(function() {
    $('#forgot_password_form').submit(function(e) {
        e.preventDefault();
        $('.spinner').show();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: BASE_URL + '/common/forgot_password/mail_send/send_token_email.php',
            data: formData,
            success: function(response) {
              $('.spinner').hide();
                try {
                    var jsonResponse = JSON.parse(response);
                    if (jsonResponse.redirect_url) {
                        window.location.href = jsonResponse.redirect_url;
                    } else {
                        alert('An error occurred while processing the request.');
                    }
                } catch (e) {
                    alert(e);
                }
            },
            error: function(xhr, status, error) {
              $('.spinner').hide();
              alert('An error occurred while processing the request: ' + status + ' - ' + error);
            }
        });
    });
});


document.getElementById('send_link').addEventListener('click', function (event) {
  clearError();

  var is_valid = true;
  var empty_fields = [];
  
  if (!validateEmail('email', 'Email', /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/)) {
    empty_fields.push('email');
    is_valid = false;
  }

  if (!is_valid) {
    event.preventDefault();
    displayErrorMessage(empty_fields);
  }
});  

function validateEmail() {
  var email = document.getElementById('email').value;
  var emailRegex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;

  if (isEmpty(email)) {
      displayError('email_err', 'Email cannot be empty');
      addInvalidClass('email');
      return false;
  } else if (!emailRegex.test(email)) {
      displayError('email_err', 'Invalid email format. Format should be like abc@gmail.com');
      addInvalidClass('email');
      return false;
  }
  return true;
}

function displayErrorMessage(fields) {
  var customMessages = { email: "Email cannot be empty" };
  fields.forEach(function (field) {
    var customMessage = customMessages[field] || field + " cannot be empty";
    var errorElem = document.getElementById(field + "_err");
    var fieldElem = document.getElementById(field);
    if (errorElem) { errorElem.textContent = customMessage; }
    if (fieldElem) { fieldElem.classList.add("invalid"); }
  });
}

const field_validation_status = {};
document.getElementById('email').addEventListener('input', function () {
  updateFieldStatus('email', 'Email', /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/);
});

function updateFieldStatus(field_id, field_name, regex) {
  var field = document.getElementById(field_id).value;
  if (!isEmpty(field) && regex.test(field)) {
      clearError();
      clearInvalidClass(field_id);
      field_validation_status[field_id] = true;
  } else {
      displayError('email_err', 'Invalid email format. Format should be like abc@gmail.com');
      addInvalidClass(field_id);
      field_validation_status[field_id] = false;
  }
}

function displayError(elementId, errorMessage) {
  var errorMessageElement = document.getElementById(elementId);
  errorMessageElement.textContent = errorMessage;
}

function clearError() {
  var errorElements = document.getElementsByClassName('error-message');
  for (var i = 0; i < errorElements.length; i++) {
    errorElements[i].textContent = '';
  }
}

function isEmpty(value) {
  return typeof value === 'string' && value.trim() === '';
} 

function addInvalidClass(field) {
  document.getElementById(field).classList.add('is-invalid');
}

function clearInvalidClass(field) {
  document.getElementById(field).classList.remove('is-invalid');
}