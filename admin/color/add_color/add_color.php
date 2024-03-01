<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
?>
<div class="add_color_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="color_heading">
         <h2>Add color</h2>
      </div>

      <div class="add_color">
         <a href="#"><i class="fa-solid fa-arrow-left-long add_color_back_button"></i></a>
      </div>

      <div class="add_color_name">
         <div class="add_section">
            <form method="post" id="add_color_form" class="add_color_form">
               <div class="form-group">
                  <label for="add_color_input_name" class="add_product_name mt-2 mb-2">Color Name <span class="important_mark">*</span></label>
                  <input type="text" name="add_color_input_name" class="form-control add_color_input_name" id="add_color_input_name" value="" placeholder="Enter color name">
                  <span class="invalid-feedback add_color_input_name_err" id="add_color_input_name_err">
                     <?php echo $add_color_input_name_err ?>
                  </span>
                  <div id="color_picker_container" class="mt-4">
                     <label for="color_picker">Select color : </label>
                     <input type="color" id="color_picker" class="color_picker" value="" name="add_color_hex_code">
                  </div>
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
   /*--------------------------------------------------------------- Back Button JS on dashboard ----------------------------------------------------------------------------*/
   function add_color_back_button(url) {
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

   // redirection ajax for back button
   $(document).off('click', '.add_color_back_button').on('click', '.add_color_back_button', function(e) {
      e.preventDefault();
      add_color_back_button('/admin/color/color.php', e);
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

   /*--------------------------------------------------------------- Hex code converted ----------------------------------------------------------------------------*/
   $('.color_picker').on('change', function() {
      var color_picker_value = $(this).val();
      color_picker_value = color_picker_value.substring(1);
      var apiUrl = "https://www.thecolorapi.com/id?hex=" + color_picker_value;
     
      $.ajax({
         url: apiUrl,
         method: "GET",
         success: function(data) {
            var colorName = data.name.value;
            $('#add_color_input_name').val(colorName);
         },
         error: function(xhr, status, error) {
            var errorMessage = "The Color API doesn't understand the query parameter. Please supply a query parameter of `rgb`, `hsl`, `cmyk` or `hex`.";
            $('.add_color_input_name_err').text(errorMessage);
         }
      });
   });

   $('.add_color_input_name').on('input', function() {
      var color_input_value = $(this).val();
      var apiUrl = "https://x-colors.yurace.pro/api/random/color?type=" + color_input_value;
     
      $.ajax({
         url: apiUrl,
         method: "GET",
         success: function(data) {
            var colorName = data.hex;
            $('#color_picker').val(colorName);
         },
         error: function(xhr, status, error) {
            var errorMessage = "Please select one color from color picker";
            $('.add_color_input_name_err').text(errorMessage);
         }
      });
   });
</script>