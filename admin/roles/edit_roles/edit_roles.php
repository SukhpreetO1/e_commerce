<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
include dirname(__DIR__, 2) . "/roles/edit_roles/edit_roles_php.php";
?>
<div class="edit_section_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="edit_role_heading">
         <h2>Edit Role Title</h2>
      </div>

      <div class="edit_role">
         <a href="#"><i class="fa-solid fa-arrow-left-long edit_role_back_button"></i></a>
      </div>

      <?php
      $id = $_GET['roles_id'];

      $sql = "SELECT * FROM roles WHERE id = $id";
      $result = $database_connection->query($sql);

      if ($result->num_rows > 0) {
         while ($row = $result->fetch_assoc()) {
      ?>

            <div class="edit_role_name">
               <div class="edit_section">
                  <form method="post" id="edit_role_form" class="edit_role_form">
                     <div class="form-group">
                        <label for="edit_role_input_name" class="edit_role_names mt-2 mb-2">Role Name</label>
                        <input type="text" name="edit_role_input_name" class="form-control edit_role_input_name" id="edit_role_input_name" value="<?php echo $row["name"]; ?>">
                        <input type="hidden" name="edit_role_id" id="edit_role_id" value="<?php echo $row["id"]; ?>">
                        <span class="invalid-feedback edit_role_name_err" id="edit_role_name_err"><?php echo $edit_role_name_err ?>
                        </span>
                     </div>
                     <div class="edit_role_name_button">
                        <button type="submit" name="edit_role" class="btn btn-primary mt-2 edit_role" id="edit_role" value="Create Role">Save Role</button>
                     </div>
                  </form>
               </div>
            </div>
      <?php
         }
      }
      $database_connection->close();
      ?>
   </div>
</div>

<script>
   /*--------------------------------------------------------------- Validation for submit button and input in edit files ----------------------------------------------------------------------------*/
   function validate_role_name_in_edit_page() {
      var role_name = $('#edit_role_input_name').val();
      var error_messages = '';
      if (role_name.trim() === '') {
         error_messages = 'Role name is required.';
      } else if (role_name.length < 3 || role_name.length > 15) {
         error_messages = 'Role name must be between 3 and 15 characters long.';
      } else if (!/^[a-zA-Z\s]+$/.test(role_name)) {
         error_messages = 'Only alphabets are allowed.';
      }
      $('.edit_role_name_err').text(error_messages);
      return error_messages === '';
   }

   // when submit the role file
   $(document).off('submit', '#edit_role_form').on('submit', '#edit_role_form', function(e) {
      e.preventDefault();
      var edit_role_id = $('#edit_role_id').val();
      if (!validate_role_name_in_edit_page()) {
         return false;
      } else {
         var formData = $(this).serialize();
         var parsed_response = null;
         $.ajax({
            type: "POST",
            url: BASE_URL + "/admin/roles/edit_roles/edit_roles_php.php" + "?role_id=" + edit_role_id,
            data: formData,
            success: function(response) {
               if (response.trim() === "") {
                  var alert_message = '<div class="alert alert-danger role_alert_dismissible" role="alert">Role name not saved.</div>';
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
                        var alert_message = '<div class="alert alert-danger role_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                        $('#alert_container').append(alert_message);
                          setTimeout(function() {
                              $('.alert').remove();
                          }, 3000);
                     } else {
                        $.ajax({
                           url: BASE_URL + '/admin/roles/roles.php',
                           type: 'GET',
                           success: function(data) {
                              $(".container").empty();
                              $('.container').html(data);
                              var alert_message = '<div class="alert alert-success role_success_dismissible" role="alert">' + parsed_response.success + '</div>';
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

   // when click on the new role input field
   $(document).on('click', '#edit_role_form', function(e) {
      if (!validate_role_name_in_edit_page()) {
         return false;
      }
   });

   // when input the new role field
   $(document).on('input', '#edit_role_form  ', function(e) {
      if (!validate_role_name_in_edit_page()) {
         return false;
      }
   });

   /*----------------------------------------------------------------------- Back Button JS on edit pages -------------------------------------------------------------*/
   function handle_back_button_click_in_edit_page(url) {
      $.ajax({
         type: 'GET',
         url: BASE_URL + url,
         success: function(data) {
            $('.container').empty();
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

   // redirection ajax for back button the role
   $(document).off('click', '.edit_role_back_button').on('click', '.edit_role_back_button', function(e) {
      e.preventDefault();
      handle_back_button_click_in_edit_page('/admin/roles/roles.php');
   });
</script>