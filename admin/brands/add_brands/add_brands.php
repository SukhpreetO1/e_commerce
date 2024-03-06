<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
?>

<div class="brands_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="brands_title">
         <h2>Add Brand Header</h2>
      </div>

      <div class="add_brands">
         <a href="#"><i class="fa-solid fa-arrow-left-long add_brands_back_button"></i></a>
      </div>

      <div class="add_brands_names">
         <div class="add_section">
            <form method="post" id="add_brands_form" class="add_brands_form">
               <div class="form-group">
                  <label for="add_brands_input_name" class="add_brands_name mt-2 mb-2">Brand Name <span class="important_mark">*</span></label>
                  <input type="text" name="add_brands_input_name" class="form-control add_brands_input_name" id="add_brands_input_name">
                  <span class="invalid-feedback add_brands_name_err" id="add_brands_name_err"><?php echo $add_brands_name_err; ?></span>
               </div>
               <div class="add_brands_name_button">
                  <button type="submit" name="create_brands" class="btn btn-primary mt-2 create_brands" id="create_brands" value="Create Category Header">Create Brand</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<script>
   /*--------------------------------------------------------------- Validation for submit button and input in add files ----------------------------------------------------------------------------*/
   function validate_brand_name() {
      var brand_name = $('#add_brands_input_name').val();
      var error_messages = '';
      if (brand_name.trim() === '') {
         error_messages = 'Brand name is required.';
      } else if (brand_name.length < 1 || brand_name.length > 15) {
         error_messages = 'Brand name must be between 1 and 15 characters long.';
      } else if (!/^[a-zA-Z\s\W]+$/.test(brand_name)) {
         error_messages = 'Only alphabets and special character are allowed.';
      }
      $('.add_brands_name_err').text(error_messages);
      return error_messages === '';
   }

   // when submit the new category header file
   $(document).off('submit', '#add_brands_form').on('submit', '#add_brands_form', function(e) {
      e.preventDefault();
      var isNameValid = validate_brand_name();
      if (!isNameValid) {
         return false;
      } else {
         var formData = $(this).serialize();
         var parsed_response = null;
         $.ajax({
            type: "POST",
            url: BASE_URL + "/admin/brands/add_brands/add_brands_php.php",
            data: formData,
            success: function(response) {
               if (response.trim() === "") {
                  var alert_message = '<div class="alert alert-danger brands_alert_dismissible" role="alert">Category header not saved.</div>';
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

   // when click on the new category header input field
   $(document).on('click', '#add_brands_form', function(e) {
      var isNameValid = validate_brand_name();
      if (!isNameValid) {
         return false;
      }
   });

   // when input the new category header field
   $(document).on('input', '#add_brands_form', function(e) {
      var isNameValid = validate_brand_name();
      if (!isNameValid) {
         return false;
      }
   });

   /*--------------------------------------------------------------- Back Button JS on ADD PAGES ----------------------------------------------------------------------------*/
   function handle_back_button_in_add_page(url) {
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

   // redirection ajax for back button the add category header
   $(document).off('click', '.add_brands_back_button').on('click', '.add_brands_back_button', function(e) {
      e.preventDefault();
      handle_back_button_in_add_page('/admin/brands/brands.php');
   });
</script>