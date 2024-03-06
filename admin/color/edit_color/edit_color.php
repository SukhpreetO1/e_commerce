<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
// include dirname(__DIR__, 2) . "/color/edit_color/edit_color_php.php";
?>
<div class="color_section_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="color_heading">
         <h2>Edit color</h2>
      </div>

      <div class="edit_color">
         <a href="#"><i class="fa-solid fa-arrow-left-long edit_color_back_button"></i></a>
      </div>

      <?php
      $id = $_GET['color_id'];

      $sql = "SELECT * FROM color WHERE id = $id";
      $result = $database_connection->query($sql);

      if ($result->num_rows > 0) {
         while ($row = $result->fetch_assoc()) {
      ?>

            <div class="edit_color_name">
               <div class="edit_section">
                  <form method="post" id="edit_color_form" class="edit_color_form">
                     <div class="form-group">
                        <!-- <label for="edit_color_input_name" class="edit_product_name mt-2 mb-2">Color Name</label> -->
                        <div id="color_picker_container">
                           <label for="color_picker">Select color : </label>
                           <input type="color" id="color_picker" value="<?php echo $row["color_code"]; ?>">
                        </div>
                        <input type="hidden" name="edit_color_id" id="edit_color_id" value="<?php echo $row["id"]; ?>">
                        <input type="hidden" name="edit_color_input_name" class="form-control edit_color_input_name" id="edit_color_input_name" value="">
                     </div>

                     <div class="edit_color_name_button">
                        <button type="submit" name="create_color" class="btn btn-primary mt-2 create_color" id="create_color" value="Create color">Update color</button>
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
   /*--------------------------------------------------------------- Color Picker ----------------------------------------------------------------------------*/
   var selected_color_picker = document.getElementById('color_picker');
   var color_name_input = document.getElementById('edit_color_input_name');

   selected_color_picker.addEventListener('input', function() {
      color_name_input.value = selected_color_picker.value;
   });

   /*--------------------------------------------------------------- Validation for submit button and input in edit files ----------------------------------------------------------------------------*/
   // when submit the new color title file
   $(document).off('submit', '#edit_color_form').on('submit', '#edit_color_form', function(e) {
      e.preventDefault();
      var edit_color_id = $('#edit_color_id').val();
      var formData = $(this).serialize();
      var parsed_response = null;
      $.ajax({
         type: "POST",
         url: BASE_URL + "/admin/color/edit_color/edit_color_php.php" + "?color_id=" + edit_color_id,
         data: formData,
         success: function(response) {
            if (response.trim() === "") {
               var alert_message = '<div class="alert alert-danger color_alert_dismissible" role="alert">color title not saved.</div>';
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
                     var alert_message = '<div class="alert alert-danger color_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
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
                           var alert_message = '<div class="alert alert-success color_success_dismissible" role="alert">' + parsed_response.success + '</div>';
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

   // redirection ajax for back button the color sections
   $(document).off('click', '.edit_color_back_button').on('click', '.edit_color_back_button', function(e) {
      e.preventDefault();
      handle_back_button_click_in_edit_page('/admin/color/color.php');
   });
</script>