<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
// include dirname(__DIR__, 2) . "/size/add_size/add_size_php.php";
?>
<div class="add_size_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="size_heading">
         <h2>Add size</h2>
      </div>

      <div class="add_size">
         <a href="#"><i class="fa-solid fa-arrow-left-long add_size_back_button"></i></a>
      </div>

      <div class="add_size_name">
         <div class="add_section">
            <form method="post" id="add_size_form" class="add_size_form">
               <div class="form-group">
                  <label for="add_size_input_name" class="add_product_name mt-2 mb-2">Size Code <span class="important_mark">*</span></label>
                  <input type="text" name="add_size_input_name" class="form-control add_size_input_name" id="add_size_input_name">
                  <span class="invalid-feedback add_size_name_err" id="add_size_name_err">
                     <?php echo $add_size_name_err ?>
                  </span>
               </div>

               <div class="add_size_name_button">
                  <button type="submit" name="create_size" class="btn btn-primary mt-2 create_size" id="create_size" value="Create size">Create Size</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<script>
   /*--------------------------------------------------------------- Back Button JS on dashboard ----------------------------------------------------------------------------*/
   function add_size_back_button(url) {
      $.ajax({
         type: 'GET',
         url: BASE_URL + url,
         success: function(data) {
            $(".container").empty();
            var container = $('.container');
            if (!$(data).find('.homepage_sidebar').length) {
               container.html(data);
            }
            var new_url = window.location.href.replace('?tab=add_roles', '?tab=roles');
            history.pushState(null, null, new_url);
         },
         error: function(e) {
            console.log(e);
         }
      });
   }

   // redirection ajax for back button
   $(document).off('click', '.add_size_back_button').on('click', '.add_size_back_button', function(e) {
      e.preventDefault();
      add_size_back_button('/admin/size/size.php', e);
   });

   /*--------------------------------------------------------------- Validation for submit button and input in add files ----------------------------------------------------------------------------*/
   function validate_size_name() {
      var size_name = $('#add_size_input_name').val();
      var error_messages = '';
      if (size_name.trim() === '') {
         error_messages = 'Size code is required.';
      } else if (size_name.length > 9) {
         error_messages = 'Size code must not be greater than 9 characters.';
      } else if (!/^[a-zA-Z\s]+$/.test(size_name)) {
         error_messages = 'Only alphabets are allowed.';
      }
      $('.add_size_name_err').text(error_messages);
      return error_messages === '';
   }

   // when submit the new file
   $(document).off('submit', '#add_size_form').on('submit', '#add_size_form', function(e) {
      e.preventDefault();

      var formData = $(this).serialize();
      var parsed_response = null;
      $.ajax({
         type: "POST",
         url: BASE_URL + "/admin/size/add_size/add_size_php.php",
         data: formData,
         success: function(response) {
            if (response.trim() === "") {
               var alert_message = '<div class="alert alert-danger add_size_alert_dismissible" role="alert">Size code not saved.</div>';
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
                     var alert_message = '<div class="alert alert-danger add_size_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
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
                           var alert_message = '<div class="alert alert-success add_size_success_dismissible" role="alert">' + parsed_response.success + '</div>';
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

   // when click on the new size input field
   $(document).on('click', '#add_size_form', function(e) {
      if (!validate_size_name()) {
         return false;
      }
   });

   // when input the new size field
   $(document).on('input', '#add_size_form', function(e) {
      if (!validate_size_name()) {
         return false;
      }
   });
</script>