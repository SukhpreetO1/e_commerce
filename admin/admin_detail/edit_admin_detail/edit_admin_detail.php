<?php
require dirname(__DIR__, 3) . "/common/config/config.php";
?>

<div class="edit_admin_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="edit_admin_detail_heading">
         <h2>Edit Admin Details</h2>
      </div>

      <div class="edit_admin_detail_page">
         <a href="#"><i class="fa-solid fa-arrow-left-long edit_admin_detail_back_button"></i></a>
      </div>

      <?php
      $user_id = $_GET['users_id'];
      $sql = "SELECT * FROM users WHERE id = $user_id";
      $result = mysqli_query($database_connection, $sql);
      while ($admin_details = mysqli_fetch_assoc($result)) {
      ?>

         <div class="edit_admin_details_page">
            <div class="edit_admin_personal_detials">
               <form class="edit_admin_user_details_form" method="post" id="edit_admin_user_details_form">
                  <div class="edit_admin_detials_firstname_lastname">
                     <div class="form-group me-3 mt-3">
                        <label for="edit_admin_first_name">First Name <span class="important_mark">*</span></label>
                        <input type="hidden" name="edit_admin_id" id="edit_admin_id" value="<?php echo $admin_details["id"]; ?>">
                        <input type="text" id="edit_admin_first_name" name="edit_admin_first_name" class="form-control edit_admin_first_name <?php echo (!empty($edit_admin_first_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $admin_details['first_name']; ?>">
                        <span class="invalid-feedback edit_admin_first_name_err" id="edit_admin_first_name_err"><?php echo $edit_admin_first_name_err; ?></span>
                     </div>
                     <div class="form-group me-3 mt-3">
                        <label for="edit_admin_last_name">Last Name <span class="important_mark">*</span></label>
                        <input type="text" id="edit_admin_last_name" name="edit_admin_last_name" class="form-control edit_admin_last_name <?php echo (!empty($edit_admin_last_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $admin_details['last_name']; ?>">
                        <span class="invalid-feedback edit_admin_last_name_err" id="edit_admin_last_name_err"><?php echo $edit_admin_last_name_err; ?></span>
                     </div>
                  </div>
                  <div class="edit_admin_detials_username_email">
                     <div class="form-group me-3 mt-3">
                        <label for="edit_admin_username">Username <span class="important_mark">*</span></label>
                        <input type="text" id="edit_admin_username" name="edit_admin_username" class="form-control edit_admin_username <?php echo (!empty($edit_admin_username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $admin_details['username']; ?>">
                        <span class="invalid-feedback edit_admin_username_err" id="edit_admin_username_err"><?php echo $edit_admin_username_err; ?></span>
                     </div>
                     <div class="form-group me-3 mt-3">
                        <label for="edit_admin_email">Email <span class="important_mark">*</span></label>
                        <input type="text" id="edit_admin_email" name="edit_admin_email" class="form-control edit_admin_email" value="<?php echo $admin_details['email']; ?>">
                        <span class="invalid-feedback edit_admin_email_err" id="edit_admin_email_err"><?php echo $edit_admin_email_err; ?></span>
                     </div>
                  </div>
                  <div class="edit_admin_detials_mobile_number_date_of_birth">
                     <div class="form-group me-3 mt-3">
                        <label for="edit_admin_mobile_number">Mobile Number <span class="important_mark">*</span></label>
                        <input type="text" id="edit_admin_mobile_number" name="edit_admin_mobile_number" class="form-control edit_admin_mobile_number <?php echo (!empty($edit_admin_mobile_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $admin_details['mobile_number']; ?>">
                        <span class="invalid-feedback edit_admin_mobile_number_err" id="edit_admin_mobile_number_err"><?php echo $edit_admin_mobile_number_err; ?></span>
                     </div>
                     <?php
                     $date = new DateTime($admin_details['date_of_birth']);
                     $formatted_date = $date->format('m/d/Y');
                     ?>
                     <div class="form-group me-3 mt-3">
                        <label for="edit_admin_date_of_birth">Date Of Birth <span class="important_mark">*</span></label>
                        <input type="text" id="edit_admin_date_of_birth" name="edit_admin_date_of_birth" class="form-control edit_admin_date_of_birth <?php echo (!empty($edit_admin_date_of_birth_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $formatted_date; ?>">
                        <span class="invalid-feedback edit_admin_date_of_birth_err" id="edit_admin_date_of_birth_err"><?php echo $edit_admin_date_of_birth_err; ?></span>
                     </div>
                  </div>
                  <div class="edit_admin_detials_password_confirm_password">
                     <div class="form-group me-3 mt-3" style="position:relative">
                        <label for="edit_admin_password">Password <span class="important_mark">*</span></label>
                        <input type="password" id="edit_admin_password" name="edit_admin_password" class="form-control edit_admin_password <?php echo (!empty($edit_admin_password_err)) ? 'is-invalid' : ''; ?>" value=""><span class="edit_admin_password_icon" id="edit_admin_password_icon" onclick="toggle_admin_password_visibility()"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                        <span class="invalid-feedback edit_admin_password_err" id="edit_admin_password_err"><?php echo $edit_admin_password_err; ?></span>
                     </div>
                     <div class="form-group me-3 mt-3" style="position:relative">
                        <label for="edit_admin_confirm_password">Confirm Password <span class="important_mark">*</span></label>
                        <input type="password" id="edit_admin_confirm_password" name="edit_admin_confirm_password" class="form-control edit_admin_confirm_password <?php echo (!empty($edit_admin_confirm_password_err)) ? 'is-invalid' : ''; ?>" value=""><span class="edit_admin_confirm_password_icon" id="edit_admin_confirm_password_icon" onclick="toggle_admin_confirm_password_visibility()"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                        <span class="invalid-feedback edit_admin_confirm_password_err" id="edit_admin_confirm_password_err"><?php echo $edit_admin_confirm_password_err; ?></span>
                     </div>
                  </div>
                  <div class="form-group mt-2 admin_detail_submit_details">
                     <button type="submit" class="btn btn-primary" value="Submit" id="submit_button">Submit</button>
                  </div>
               </form>
            </div>
         </div>
      <?php
      }
      ?>
   </div>
</div>

<script>
   /*--------------------------------------------------------------- Datepicker ----------------------------------------------------------------------------*/
   $('#edit_admin_date_of_birth').datepicker();

   /*--------------------------------------------------------------- Back Button ----------------------------------------------------------------------------*/
   function edit_admin_detail_back_button(url) {
      $.ajax({
         type: 'GET',
         url: BASE_URL + url,
         success: function(data) {
            $(".container").empty();
            var container = $('.container');
            if (!$(data).find('.homepage_sidebar').length) {
               container.html(data);
            }
         },
         error: function(e) {
            console.log(e);
         }
      });
   }

   // redirection ajax for back button the category title
   $(document).off('click', '.edit_admin_detail_back_button').on('click', '.edit_admin_detail_back_button', function(e) {
      e.preventDefault();
      edit_admin_detail_back_button('/admin/admin_detail/admin_detail.php', e);
   });
</script>

<script>
   /*--------------------------------------------------------------- admin edit form validation ---------------------------------------------------------------*/
   function validate_input(inputValue, errorSelector, requiredMessage, formatMessage, validationRegex) {
      var errorMessages = '';
      if (inputValue.trim() === '') {
         errorMessages = requiredMessage;
      } else if (validationRegex && !validationRegex.test(inputValue)) {
         errorMessages = formatMessage;
      }
      $(errorSelector).text(errorMessages);
      return errorMessages === '';
   }

   function validate_edit_admin_first_name() {
      var edit_admin_first_name = document.getElementById('edit_admin_first_name').value;
      return validate_input(
         edit_admin_first_name, '.edit_admin_first_name_err', 'First name is required.', 'Only letters are allowed.', /^[a-zA-Z]+$/
      );
   }

   function validate_edit_admin_last_name() {
      var edit_admin_last_name = document.getElementById('edit_admin_last_name').value;
      return validate_input(
         edit_admin_last_name, '.edit_admin_last_name_err', 'Last name is required.', 'Only letters are allowed.', /^[a-zA-Z]+$/
      );
   }

   function validate_edit_admin_username() {
      var edit_admin_username = document.getElementById('edit_admin_username').value;
      return validate_input(
         edit_admin_username, '.edit_admin_username_err', 'Username is required.', 'Only letters and numbers are allowed.', /^[a-zA-Z0-9]+$/
      );
   }

   function validate_edit_admin_email() {
      var edit_admin_email = document.getElementById('edit_admin_email').value;
      return validate_input(
         edit_admin_email, '.edit_admin_email_err', 'Email is required.', 'Invalid email format. Format should be like abc@gmail.com', /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/
      );
   }

   function validate_edit_admin_mobile_number() {
      var edit_admin_mobile_number = document.getElementById('edit_admin_mobile_number').value;
      return validate_input(
         edit_admin_mobile_number, '.edit_admin_mobile_number_err', 'Mobile number is required.', 'Mobile number must be between 10 and 12 characters long.', /^\d{10,12}$/
      );
   }

   function validate_edit_admin_date_of_birth() {
      var edit_admin_date_of_birth = $('#edit_admin_date_of_birth').datepicker('getDate');
      return validate_input(
         edit_admin_date_of_birth.toString(), '.edit_admin_date_of_birth_err', 'Date of birth is required.', null, null
      );
   }

   function validate_edit_admin_password() {
      var edit_admin_password = document.getElementById('edit_admin_password').value;
      return validate_input(
         edit_admin_password, '.edit_admin_password_err', 'Password is required.', 'Password must contain at least 6 characters, 1 capital letter and 1 number.', /^(?=.*\d)(?=.*[a-z]|[A-Z]).{6,20}$/
      );
   }

   function validate_confirm_edit_admin_password() {
      const edit_admin_password = document.getElementById('edit_admin_password');
      const edit_admin_confirm_password = document.getElementById('edit_admin_confirm_password');
      const passwordValue = edit_admin_confirm_password.value;
      const passwordMatch = passwordValue === edit_admin_password.value;
      const passwordValid = validate_input(
         passwordValue, '.edit_admin_confirm_password_err', 'Confirm password is required.', 'Confirm password must contain at least 6 characters, 1 capital letter and 1 number.', /^(?=.*\d)(?=.*[a-z]|[A-Z]).{6,20}$/
      );
      const passwordsMatchError = passwordMatch ? '' : 'Passwords do not match';
      $('.edit_admin_confirm_password').text(passwordsMatchError);
      edit_admin_password.classList.toggle('password-not-matched', !passwordMatch);
      edit_admin_confirm_password.classList.toggle('password-not-matched', !passwordMatch);
      edit_admin_password.classList.toggle('password-match', passwordMatch && passwordValid);
      edit_admin_confirm_password.classList.toggle('password-match', passwordMatch && passwordValid);
      return passwordValid && passwordMatch;
   }

   // when click on the new
   $('#edit_admin_first_name').on('click', function(e) {
      validate_edit_admin_first_name();
   });
   $('#edit_admin_last_name').on('click', function(e) {
      validate_edit_admin_last_name();
   });
   $('#edit_admin_username').on('click', function(e) {
      validate_edit_admin_username();
   });
   $('#edit_admin_email').on('click', function(e) {
      validate_edit_admin_email();
   });
   $('#edit_admin_mobile_number').on('click', function(e) {
      validate_edit_admin_mobile_number();
   });
   $('#edit_admin_password').on('click', function(e) {
      validate_edit_admin_password();
   });
   $('#edit_admin_confirm_password').on('click', function(e) {
      validate_confirm_edit_admin_password();
   });

   // when input the new 
   $('#edit_admin_first_name').on('input', function(e) {
      validate_edit_admin_first_name();
   });
   $('#edit_admin_last_name').on('input', function(e) {
      validate_edit_admin_last_name();
   });
   $('#edit_admin_username').on('input', function(e) {
      validate_edit_admin_username();
   });
   $('#edit_admin_email').on('input', function(e) {
      validate_edit_admin_email();
   });
   $('#edit_admin_mobile_number').on('input', function(e) {
      validate_edit_admin_mobile_number();
   });
   $('#edit_admin_password').on('input', function(e) {
      validate_edit_admin_password();
   });
   $('#edit_admin_confirm_password').on('input', function(e) {
      validate_confirm_edit_admin_password();
   });

   // when submit the new file
   $(document).off('submit', '#edit_admin_user_details_form').on('submit', '#edit_admin_user_details_form', function(e) {
      e.preventDefault();
      var edit_admin_id = $('#edit_admin_id').val();

      var is_first_name_valid = validate_edit_admin_first_name();
      var is_last_name_valid = validate_edit_admin_last_name();
      var is_username_valid = validate_edit_admin_username();
      var is_email_valid = validate_edit_admin_email();
      var is_date_of_birth_valid = validate_edit_admin_date_of_birth();
      var is_mobile_number_valid = validate_edit_admin_mobile_number();
      var is_password_valid = validate_edit_admin_password();
      var is_confirm_password_valid = validate_confirm_edit_admin_password();

      var is_form_valid = is_first_name_valid && is_last_name_valid && is_username_valid && is_email_valid && is_date_of_birth_valid && is_mobile_number_valid && is_password_valid && is_confirm_password_valid;

      if (!is_form_valid) {
         $('.edit_admin_first_name_err').text(is_first_name_valid ? '' : 'First name is required.');
         $('.edit_admin_last_name_err').text(is_last_name_valid ? '' : 'Last name is required.');
         $('.edit_admin_username_err').text(is_username_valid ? '' : 'Username is required.');
         $('.edit_admin_email_err').text(is_email_valid ? '' : 'Email is required.');
         $('.edit_admin_date_of_birth_err').text(is_date_of_birth_valid ? '' : 'Date of birth is required.');
         $('.edit_admin_mobile_number_err').text(is_mobile_number_valid ? '' : 'Mobile number is required.');
         $('.edit_admin_password_err').text(is_password_valid ? '' : 'Password is required.');
         $('.edit_admin_confirm_password_err').text(is_confirm_password_valid ? '' : 'Confirm password is required.');
         return false;
      } else {
         var formData = $(this).serialize();
         var parsed_response = null;
         $.ajax({
            type: "POST",
            url: BASE_URL + "/admin/admin_detail/edit_admin_detail/edit_admin_detail_php.php" + "?edit_admin_id=" + edit_admin_id,
            data: formData,
            success: function(response) {
               console.log(response);
               if (response.trim() === "") {
                  var alert_message = '<div class="alert alert-danger edit_admin_detail_alert_dismissible" role="alert">Admin details not updated.</div>';
                  $('#alert_container').append(alert_message);
                  setTimeout(function() {
                     $('.alert').remove();
                  }, 3000);
               } else {
                  if (parsed_response) {
                     parsed_response = null;
                  } else {
                     parsed_response = JSON.parse(response);
                     if (parsed_response.error) {
                        var alert_message = '<div class="alert alert-danger edit_admin_detail_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                        $('#alert_container').append(alert_message);
                        setTimeout(function() {
                           $('.alert').remove();
                        }, 3000);
                     } else {
                        $.ajax({
                           url: BASE_URL + '/admin/admin_detail/admin_detail.php',
                           type: 'GET',
                           success: function(data) {
                              $(".container").empty();
                              $('.container').html(data);
                              var alert_message = '<div class="alert alert-success edit_admin_detail_success_dismissible" role="alert">' + parsed_response.success + '</div>';
                              $('#alert_container').append(alert_message);
                              setTimeout(function() {
                                 $('.alert').remove();
                              }, 2000);
                           },
                           error: function(xhr, status, error) {
                              console.log(error);
                           }
                        });
                     }
                  }
               }
            },
            error: function(xhr, status, error) {
               console.log("Error" + error);
            }
         });
      }
   });

   function toggle_admin_password_visibility() {
      var password_input = document.getElementById('edit_admin_password');
      var eyeIcon = document.querySelector('.edit_admin_password_icon i');

      if (password_input.type === 'password') {
         password_input.type = 'text';
         eyeIcon.classList.remove('fa-eye-slash');
         eyeIcon.classList.add('fa-eye');
      } else {
         password_input.type = 'password';
         eyeIcon.classList.remove('fa-eye');
         eyeIcon.classList.add('fa-eye-slash');
      }
   }

   document.addEventListener("DOMContentLoaded", function() {
      var edit_admin_password_icon = document.getElementById('edit_admin_password_icon');
      edit_admin_password_icon.style.display = document.getElementById('password').value.length > 0 ? 'block' : 'none';
   });

   document.getElementById('edit_admin_password').addEventListener('input', function() {
      var edit_admin_password_icon = document.getElementById('edit_admin_password_icon');
      edit_admin_password_icon.style.display = this.value.length > 0 ? 'block' : 'none';
   });

   function toggle_admin_confirm_password_visibility() {
      var confirm_password_input = document.getElementById('edit_admin_confirm_password');
      var eyeIcon = document.querySelector('.edit_admin_confirm_password_icon i');

      if (confirm_password_input.type === 'password') {
         confirm_password_input.type = 'text';
         eyeIcon.classList.remove('fa-eye-slash');
         eyeIcon.classList.add('fa-eye');
      } else {
         confirm_password_input.type = 'password';
         eyeIcon.classList.remove('fa-eye');
         eyeIcon.classList.add('fa-eye-slash');
      }
   }

   document.addEventListener("DOMContentLoaded", function() {
      var edit_admin_confirm_password = document.getElementById('edit_admin_confirm_password_icon');
      edit_admin_confirm_password.style.display = edit_admin_confirm_password.value.length > 0 ? 'block' : 'none';
   });

   document.getElementById('edit_admin_confirm_password').addEventListener('input', function() {
      var edit_admin_confirm_password = document.getElementById('edit_admin_confirm_password_icon');
      edit_admin_confirm_password.style.display = this.value.length > 0 ? 'block' : 'none';
   });
</script>