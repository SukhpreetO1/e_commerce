<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
// include dirname(__DIR__, 2) . "/size/edit_size/edit_size_php.php";
?>
<div class="size_section_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="size_heading">
         <h2>Edit Size</h2>
      </div>

      <div class="edit_size">
         <a href="#"><i class="fa-solid fa-arrow-left-long edit_size_back_button"></i></a>
      </div>

      <?php
      $id = $_GET['size_id'];

      $sql = "SELECT * FROM size WHERE id = $id";
      $result = $database_connection->query($sql);

      if ($result->num_rows > 0) {
         while ($row = $result->fetch_assoc()) {
      ?>

            <div class="edit_size_name">
               <div class="edit_section">
                  <form method="post" id="edit_size_form" class="edit_size_form">
                     <div class="form-group">
                        <label for="edit_size_input_name" class="edit_size_code mt-2 mb-2">Size Code</label>
                        <input type="text" name="edit_size_input_name" class="form-control edit_size_input_name" id="edit_size_input_name" value="<?php echo $row["name"]; ?>">
                        <input type="hidden" name="edit_size_id" id="edit_size_id" value="<?php echo $row["id"]; ?>">
                        <span class="invalid-feedback edit_size_name_err" id="edit_size_name_err"><?php echo $edit_size_name_err ?>
                        </span>
                     </div>
                     <div class="edit_size_name_button">
                        <button type="submit" name="create_size" class="btn btn-primary mt-2 create_size" id="create_size" value="Create size">Update Size</button>
                     </div>
                  </form>
               </div>
            </div>
      <?php
         }
      }
      ?>
   </div>
</div>

<script>
   /*--------------------------------------------------------------- Validation for submit button and input in edit files ----------------------------------------------------------------------------*/
   function validate_size_name_in_edit_page() {
      var size_name = $('#edit_size_input_name').val();
      var error_messages = '';
      if (size_name.trim() === '') {
         error_messages = 'Size code is required.';
      } else if (size_name.length > 9) {
         error_messages = 'Size code must not be greater then 9 characters.';
      } else if (!/^[a-zA-Z\s]+$/.test(size_name)) {
         error_messages = 'Only alphabets are allowed.';
      }
      $('.edit_size_name_err').text(error_messages);
      return error_messages === '';
   }

   // when submit the new size title file
   $(document).off('submit', '#edit_size_form').on('submit', '#edit_size_form', function(e) {
      e.preventDefault();
      var formData = $(this).serialize();
      var parsed_response = null;
      $.ajax({
         type: "POST",
         url: BASE_URL + "/admin/size/edit_size/edit_size_php.php" + "?size_id=" + edit_size_id,
         data: formData,
         success: function(response) {
            if (response.trim() === "") {
               var alert_message = '<div class="alert alert-danger size_alert_dismissible" role="alert">size title not saved.</div>';
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
                     var alert_message = '<div class="alert alert-danger size_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                     $('#alert_container').append(alert_message);
                     setTimeout(function() {
                        $('.alert').remove();
                     }, 3000);
                  } else {
                     $.ajax({
                        url: BASE_URL + '/admin/size/size.php',
                        type: 'GET',
                        success: function(data) {
                           $(".container").empty();
                           $('.container').html(data);
                           var alert_message = '<div class="alert alert-success size_success_dismissible" role="alert">' + parsed_response.success + '</div>';
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
   });

   // when click on the new size title input field
   $(document).on('click', '#edit_size_form', function(e) {
      if (!validate_size_name_in_edit_page()) {
         return false;
      }
   });

   // when input the new size title field
   $(document).on('input', '#edit_size_form  ', function(e) {
      if (!validate_size_name_in_edit_page()) {
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

   // redirection ajax for back button the size sections
   $(document).off('click', '.edit_size_back_button').on('click', '.edit_size_back_button', function(e) {
      e.preventDefault();
      handle_back_button_click_in_edit_page('/admin/size/size.php');
   });
</script>