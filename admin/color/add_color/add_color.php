<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
// include dirname(__DIR__, 2) . "/color/add_color/add_color_php.php";
?>
<div class="add_color_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="add_color_name">
         <div class="add_section">
            <form method="post" id="add_color_form" class="add_color_form">
               <div class="form-group">
                  <label for="add_color_input_name" class="add_product_name mt-2 mb-2">Color Name <span class="important_mark">*</span></label>
                  <div id="color_picker_container">
                     <label for="color_picker">Select color : </label>
                     <input type="color" id="color_picker" value="#0000ff">
                  </div>
                  <input type="hidden" name="add_color_input_name" class="form-control add_color_input_name" id="add_color_input_name" value="" placeholder="Enter color name">
               </div>

               <div class="add_color_name_button">
                  <button type="submit" name="create_color" class="btn btn-primary mt-2 create_color" id="create_color" value="Create color">Create color</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<script>
   /*--------------------------------------------------------------- Color Picker ----------------------------------------------------------------------------*/
   var selected_color_picker = document.getElementById('color_picker');
   var color_name_input = document.getElementById('add_color_input_name');

   selected_color_picker.addEventListener('input', function() {
      color_name_input.value = selected_color_picker.value;
   });

   /*--------------------------------------------------------------- Validation for submit button and input in add files ----------------------------------------------------------------------------*/
   // when submit the new file
   $(document).off('submit', '#add_color_form').on('submit', '#add_color_form', function(e) {
      e.preventDefault();

      var formData = $(this).serialize();
      var parsed_response = null;
      $.ajax({
         type: "POST",
         url: BASE_URL + "/admin/color/add_color/add_color_php.php",
         data: formData,
         success: function(response) {
            if (response.trim() === "") {
               var alert_message = '<div class="alert alert-danger add_color_alert_dismissible" role="alert">Color name not saved.</div>';
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
                     var alert_message = '<div class="alert alert-danger add_color_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                     $('.modal-backdrop').css('display', 'none');
                     $('#alert_container').append(alert_message);
                     setTimeout(function() {
                        $('.alert').remove();
                     }, 3000);
                  } else {
                     $.ajax({
                        url: BASE_URL + '/admin/color/color.php',
                        type: 'GET',
                        success: function(data) {
                           $(".container").empty();
                           $('.container').html(data);
                           $('.modal-backdrop').css('display', 'none');
                           var alert_message = '<div class="alert alert-success add_color_success_dismissible" role="alert">' + parsed_response.success + '</div>';
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
</script>