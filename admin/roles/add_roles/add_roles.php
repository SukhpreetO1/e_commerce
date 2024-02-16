<?php
include dirname(__DIR__, 2) . "/roles/add_roles/add_roles_php.php";
?>
<div class="add_roles_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="roles_heading">
         <h2>Add Role</h2>
      </div>

      <div class="add_role_title">
         <a href="#"><i class="fa-solid fa-arrow-left-long add_role_back_button"></i></a>
      </div>

      <div class="add_role_name">
         <div class="add_section">
            <form method="post" id="add_role_form" class="add_role_form">
               <div class="form-group">
                  <label for="add_role_input_name" class="add_roles_title_name mt-2 mb-2">Role Name <span class="important_mark">*</span></label>
                  <input type="text" name="add_role_input_name" class="form-control add_role_input_name" id="add_role_input_name">
                  <span class="invalid-feedback add_role_name_err" id="add_role_name_err"><?php echo $add_role_name_err ?></php></span>
               </div>
               <div class="add_role_name_button">
                  <button type="submit" name="create_role" class="btn btn-primary mt-2 create_role" id="create_role" value="Create Role">Create Role</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<script>
   /*--------------------------------------------------------------- Back Button JS on ADD PAGES ----------------------------------------------------------------------------*/
   function back_button_in_roles_add_page(url, e) {
      $.ajax({
         type: 'GET',
         url: BASE_URL + url,
         success: function(data) {
            $(".container").empty();
            $('.container').html(data);
         },
         error: function(e) {
            console.log(e);
         }
      });
   }

   // redirection ajax for back button the add role title
   $(document).off('click', '.add_role_back_button').on('click', '.add_role_back_button', function(e) {
      e.preventDefault();
      back_button_in_roles_add_page('/admin/roles/roles.php', e);
   });

   /*--------------------------------------------------------------- Validation for submit button and input in add files ----------------------------------------------------------------------------*/
   function validate_role_name() {
      var role_name = $('#add_role_input_name').val();
      var error_messages = '';
      if (role_name.trim() === '') {
         error_messages = 'Role name is required.';
      } else if (role_name.length < 3 || role_name.length > 15) {
         error_messages = 'Roles name must be between 3 and 15 characters long.';
      } else if (!/^[a-zA-Z\s]+$/.test(role_name)) {
         error_messages = 'Only alphabets are allowed.';
      }
      $('.add_role_name_err').text(error_messages);
      return error_messages === '';
   }

   // when submit the new role title file
   $(document).off('submit', '#add_role_form').on('submit', '#add_role_form', function(e) {
      e.preventDefault();
      if (!validate_role_name()) {
         return false;
      } else {
         var formData = $(this).serialize();
         var parsed_response = null;
         $.ajax({
            type: "POST",
            url: BASE_URL + "/admin/roles/add_roles/add_roles_php.php",
            data: formData,
            success: function(response) {
               if (response.trim() === "") {
                  var alert_message = '<div class="alert alert-danger role_alert_dismissible" role="alert">Role name not saved.</div>';
                  $('#alert_container').append(alert_message);
                  // setTimeout(function() {
                  //    $('.alert').remove();
                  // }, 3000);
               } else {
                  if (parsed_response) {
                     parsed_response = null;
                  } else {
                     parsed_response = JSON.parse(response);
                     if (parsed_response.error) {
                        var alert_message = '<div class="alert alert-danger role_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                        $('#alert_container').append(alert_message);
                        // setTimeout(function() {
                        //    $('.alert').remove();
                        // }, 3000);
                     } else {
                        $.ajax({
                           url: BASE_URL + '/admin/roles/roles.php',
                           type: 'GET',
                           success: function(data) {
                              $(".container").empty();
                              $('.container').html(data);
                              var alert_message = '<div class="alert alert-success role_success_dismissible" role="alert">' + parsed_response.success + '</div>';
                              $('#alert_container').append(alert_message);
                              // setTimeout(function() {
                              //    $('.alert').remove();
                              // }, 2000);
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

   // when click on the new role input field
   $(document).on('click', '#add_role_form', function(e) {
      if (!validate_role_name()) {
         return false;
      }
   });

   // when input the new role field
   $(document).on('input', '#add_role_form', function(e) {
      if (!validate_role_name()) {
         return false;
      }
   });
</script>