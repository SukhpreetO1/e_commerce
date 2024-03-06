<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
?>
<div class="category_section_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="brands_heading">
         <h2>Edit Brand Name</h2>
      </div>

      <div class="edit_brands">
         <a href="#"><i class="fa-solid fa-arrow-left-long edit_brands_back_button"></i></a>
      </div>

      <?php
      $id = $_GET['brands_id'];

      $sql = "SELECT * FROM brands WHERE id = $id";
      $result = $database_connection->query($sql);

      if ($result->num_rows > 0) {
         while ($row = $result->fetch_assoc()) {
      ?>

            <div class="edit_brands_names">
               <div class="edit_section">
                  <form method="post" id="edit_brands_form" class="edit_brands_form">
                     <div class="form-group">
                        <label for="edit_brands_input_name" class="edit_brands_name mt-2 mb-2">Brand Name</label>
                        <input type="text" name="edit_brands_input_name" class="form-control edit_brands_input_name" id="edit_brands_input_name" value="<?php echo $row["name"]; ?>">
                        <input type="hidden" name="edit_brands_id" id="edit_brands_id" value="<?php echo $row["id"]; ?>">
                        <span class="invalid-feedback edit_brands_name_err" id="edit_brands_name_err"><?php echo $edit_brands_name_err ?>
                        </span>
                     </div>
                     <div class="edit_brands_name_button">
                        <button type="submit" name="create_category" class="btn btn-primary mt-2 create_category" id="create_category" value="Create Category">Update Name</button>
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
   function validate_brands_in_edit_page() {
      var brands = $('#edit_brands_input_name').val();
      var error_messages = '';
      if (brands.trim() === '') {
         error_messages = 'Brand name is required.';
      } else if (brands.length < 1 || brands.length > 15) {
         error_messages = 'Brand name must be between 1 and 15 characters long.';
      } else if (!/^[a-zA-Z\s\W]+$/.test(brands)) {
         error_messages = 'Only alphabets are allowed.';
      }
      $('.edit_brands_name_err').text(error_messages);
      return error_messages === '';
   }

   // when submit the new category title file
   $(document).off('submit', '#edit_brands_form').on('submit', '#edit_brands_form', function(e) {
      e.preventDefault();
      var edit_brands_id = $('#edit_brands_id').val();
      if (!validate_brands_in_edit_page()) {
         return false;
      } else {
         var formData = $(this).serialize();
         var parsed_response = null;
         $.ajax({
            type: "POST",
            url: BASE_URL + "/admin/brands/edit_brands/edit_brands_php.php" + "?brands_id=" + edit_brands_id,
            data: formData,
            success: function(response) {
               if (response.trim() === "") {
                  var alert_message = '<div class="alert alert-danger brands_alert_dismissible" role="alert">Category title not saved.</div>';
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
                        var alert_message = '<div class="alert alert-danger brands_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                        $('#alert_container').append(alert_message);
                        setTimeout(function() {
                           $('.alert').remove();
                        }, 3000);
                     } else {
                        $.ajax({
                           url: BASE_URL + '/admin/brands/brands.php',
                           type: 'GET',
                           success: function(data) {
                              $(".container").empty();
                              $('.container').html(data);
                              var alert_message = '<div class="alert alert-success brands_success_dismissible" role="alert">' + parsed_response.success + '</div>';
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

   // when click on new
   $(document).on('click', '#edit_brands_form', function(e) {
      if (!validate_brands_in_edit_page()) {
         return false;
      }
   });

   // when input the new 
   $(document).on('input', '#edit_brands_form  ', function(e) {
      if (!validate_brands_in_edit_page()) {
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

   // redirection ajax for back button the category sections
   $(document).off('click', '.edit_brands_back_button').on('click', '.edit_brands_back_button', function(e) {
      e.preventDefault();
      handle_back_button_click_in_edit_page('/admin/brands/brands.php');
   });
</script>