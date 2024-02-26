<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
include dirname(__DIR__, 2) . "/discount/add_discount/add_discount_php.php";
?>
<div class="add_discount_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="discount_heading">
         <h2>Add Discount</h2>
      </div>

      <div class="add_discount">
         <a href="#"><i class="fa-solid fa-arrow-left-long add_discount_back_button"></i></a>
      </div>

      <div class="add_discount_name">
         <div class="add_section">
            <form method="post" id="add_discount_form" class="add_discount_form">
               <div class="form-group">
                  <label for="add_discount_input_code_name" class="add_product_name mt-2 mb-2">Code Name <span class="important_mark">*</span></label>
                  <input type="text" name="add_discount_input_code_name" class="form-control add_discount_input_code_name" id="add_discount_input_code_name">
                  <span class="invalid-feedback add_discount_code_name_err" id="add_discount_code_name_err">
                     <?php echo $add_discount_code_name_err ?>
                  </span>
               </div>

               <div class="form-group">
                  <label for="add_discount_input_discount_type" class="add_product_name mt-2 mb-2">Discount Name <span class="important_mark">*</span></label>
                  <input type="text" name="add_discount_input_discount_type" class="form-control add_discount_input_discount_type" id="add_discount_input_discount_type">
                  <span class="invalid-feedback add_discount_discount_type_err" id="add_discount_discount_type_err">
                     <?php echo $add_discount_discount_type_err ?>
                  </span>
               </div>

               <div class="form-group">
                  <label for="add_discount_input_discount_active_inactive" class="add_product_name mt-2 mb-2">Active/ Inactive <span class="important_mark">*</span></label>
                  <select name="add_discount_input_discount_active_inactive" class="form-control add_discount_input_discount_active_inactive" id="add_discount_input_discount_active_inactive">
                     <option value="">Select active/ inactive option</option>
                     <option value="active">Active</option>
                     <option value="inactive">Inactive</option>
                  </select>
                  <span class="invalid-feedback add_discount_active_inactive_err" id="add_discount_active_inactive_err">
                     <?php echo $add_discount_active_inactive_err ?>
                  </span>
               </div>

               <div class="form-group">
                  <label for="add_discount_amount" class="add_product_price mt-2 mb-2">Amount <span class="important_mark">*</span></label>
                  <div class="input-group mb-2">
                     <input type="text" name="add_discount_amount" class="form-control add_discount_amount" id="add_discount_amount">
                     <div class="input-group-prepend">
                        <select class="custom-select discount_type_dropdown" name="discount_type">
                           <option value="%">%</option>
                           <option value="₹">₹</option>
                        </select>
                     </div>
                  </div>
                  <span class="invalid-feedback add_discount_price_err" id="add_discount_price_err">
                     <?php echo $add_discount_price_err ?>
                  </span>
               </div>

               <div class="form-group">
                  <label for="add_discount_expire_date" class="add_product_discount mt-2 mb-2">Expire Date <span class="important_mark">*</span></label>
                  <input type="text" name="add_discount_expire_date" class="form-control add_discount_expire_date" id="add_discount_expire_date">
                  <span class="invalid-feedback add_discount_expire_date_err" id="add_discount_expire_date_err">
                     <?php echo $add_discount_expire_date_err ?>
                  </span>
               </div>

               <div class="add_discount_name_button">
                  <button type="submit" name="create_discount" class="btn btn-primary mt-2 create_discount" id="create_discount" value="Create discount">Create discount</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<script>
   $(document).ready(function() {
      $('#add_discount_expire_date').datepicker({
         onSelect: function() {
            $('.add_discount_expire_date_err').text('');
         }
      });
   });

   /*--------------------------------------------------------------- Back Button JS on dashboard ----------------------------------------------------------------------------*/
   function add_discount_back_button(url) {
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
   $(document).off('click', '.add_discount_back_button').on('click', '.add_discount_back_button', function(e) {
      e.preventDefault();
      add_discount_back_button('/admin/discount/discount.php', e);
   });

   /*--------------------------------------------------------------- Validation for submit button and input in add files ----------------------------------------------------------------------------*/
   function validate_input(inputValue, errorSelector, requiredMessage, lengthMessage, formatMessage, validationRegex) {
      var errorMessages = '';
      if (inputValue.trim() === '') {
         errorMessages = requiredMessage;
      } else if (inputValue.length < 5 || inputValue.length > 15) {
         errorMessages = lengthMessage;
      } else if (!validationRegex.test(inputValue)) {
         errorMessages = formatMessage;
      }
      $(errorSelector).text(errorMessages);
      return errorMessages === '';
   }

   function validate_discount_name() {
      var discount_name = $('#add_discount_input_code_name').val();
      return validate_input(
         discount_name, '.add_discount_code_name_err', 'Discount name is required.', 'Discount name must be between 5 and 15 characters long.', 'Only alphabets and numbers are allowed.', /^[a-zA-Z0-9]+$/
      );
   }

   function validate_discount_type() {
      var discount_type = $('#add_discount_input_discount_type').val();
      return validate_input(
         discount_type, '.add_discount_discount_type_err', 'Discount type is required.', 'Discount type must be between 5 and 15 characters long.', 'Only alphabets and numbers are allowed.', /^[a-zA-Z0-9\s]+$/
      );
   }

   function validate_active_inactive() {
      var selected_option = $('#add_discount_input_discount_active_inactive').val();
      if (selected_option === '') {
         error_messages = 'Please select an option';
      } else {
         error_messages = '';
      }
      $('.add_discount_active_inactive_err').text(error_messages);
      return error_messages === '';
   }

   function validate_discount_price() {
      var discount_price = $('.add_discount_amount').val();
      if (discount_price === '') {
         error_messages = 'Discount price is required.';
      } else if (!/^(0+(\.\d+)?|[1-9]\d*(\.\d+)?)$/.test(discount_price)) {
         error_messages = 'Only numbers are allowed.';
      }
      $('.add_discount_price_err').text(error_messages);
      return error_messages === '';
   }

   function validate_discount_expire_date() {
      var expire_date = $('#add_discount_expire_date').val();
      var isValidDate = moment(expire_date, 'MM/DD/YYYY', true).isValid();
      if (expire_date === '') {
         error_messages = 'Expire date is required.';
      } else if (!isValidDate) {
         error_messages = 'Invalid date format. Please use MM/DD/YYYY';
      } else {
         error_messages = '';
      }
      $('.add_discount_expire_date_err').text(error_messages);
      return error_messages === '';
   }

   // when submit the new file
   $(document).off('submit', '#add_discount_form').on('submit', '#add_discount_form', function(e) {
      e.preventDefault();

      var formData = $(this).serialize();
      formData += "&discount_amount_type=" + $(".discount_type_dropdown").val();
      var parsed_response = null;
      $.ajax({
         type: "POST",
         url: BASE_URL + "/admin/discount/add_discount/add_discount_php.php",
         data: formData,
         success: function(response) {
            if (response.trim() === "") {
               var alert_message = '<div class="alert alert-danger add_discount_alert_dismissible" role="alert">Discount name not saved.</div>';
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
                     var alert_message = '<div class="alert alert-danger add_discount_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                     $('#alert_container').append(alert_message);
                     setTimeout(function() {
                        $('.alert').remove();
                     }, 3000);
                  } else {
                     $.ajax({
                        url: BASE_URL + '/admin/discount/discount.php',
                        type: 'GET',
                        success: function(data) {
                           $(".container").empty();
                           $('.container').html(data);
                           var alert_message = '<div class="alert alert-success add_discount_success_dismissible" role="alert">' + parsed_response.success + '</div>';
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

      $('.add_discount_amount').on('input', function() {
         validate_discount_price();
      });
   });

   // when click on the new
   $(document).on('click', '#add_discount_form', function(e) {
      var is_valid_name = validate_discount_name();
      var is_valid_description = validate_discount_type();
      var is_valid_active_inactive = validate_active_inactive();
      var is_valid_price = validate_discount_price();
      var is_valid_expire_date = validate_discount_expire_date();
      if (!is_valid_name || !is_valid_description || !is_valid_active_inactive || !is_valid_price || !is_valid_expire_date) {
         return false;
      }
   });

   // when input the new 
   $(document).on('input', '#add_discount_form', function(e) {
      var is_valid_name = validate_discount_name();
      var is_valid_description = validate_discount_type();
      var is_valid_active_inactive = validate_active_inactive();
      var is_valid_price = validate_discount_price();
      var is_valid_expire_date = validate_discount_expire_date();
      if (!is_valid_name || !is_valid_description || !is_valid_active_inactive || !is_valid_price || !is_valid_expire_date) {
         return false;
      }
   });
</script>