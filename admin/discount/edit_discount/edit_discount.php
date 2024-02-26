<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
// include dirname(__DIR__, 2) . "/discount/edit_discount/edit_discount_php.php";
?>
<div class="edit_discount_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="discount_heading">
         <h2>Edit Discount</h2>
      </div>

      <div class="edit_discount">
         <a href="#"><i class="fa-solid fa-arrow-left-long edit_discount_back_button"></i></a>
      </div>

      <?php
      $id = $_GET['discount_id'];
      $sql = "SELECT * FROM discount WHERE id = $id";
      $result = $database_connection->query($sql);
      if ($result->num_rows > 0) {
         while ($discount_data = $result->fetch_assoc()) {
            $selected_category_id = $discount_data["categories_type_id"];
      ?>

            <div class="edit_discount_name">
               <div class="edit_section">
                  <form method="post" id="edit_discount_form" class="edit_discount_form">
                     <div class="form-group">
                        <label for="edit_discount_input_code_name" class="edit_product_name mt-2 mb-2">Code Name <span class="important_mark">*</span></label>
                        <input type="hidden" name="edit_discount_id" id="edit_discount_id" value="<?php echo $discount_data["id"]; ?>">
                        <input type="text" name="edit_discount_input_code_name" class="form-control edit_discount_input_code_name" id="edit_discount_input_code_name" value="<?php echo $discount_data["code_name"]; ?>">
                        <span class="invalid-feedback edit_discount_code_name_err" id="edit_discount_code_name_err">
                           <?php echo $edit_discount_code_name_err ?>
                        </span>
                     </div>

                     <div class="form-group">
                        <label for="edit_discount_input_discount_type" class="edit_product_name mt-2 mb-2">Discount Name <span class="important_mark">*</span></label>
                        <input type="text" name="edit_discount_input_discount_type" class="form-control edit_discount_input_discount_type" id="edit_discount_input_discount_type" value="<?php echo $discount_data["discount_type"]; ?>">
                        <span class="invalid-feedback edit_discount_discount_type_err" id="edit_discount_discount_type_err">
                           <?php echo $edit_discount_discount_type_err ?>
                        </span>
                     </div>

                     <div class="form-group">
                        <label for="edit_discount_input_discount_active_inactive" class="edit_product_name mt-2 mb-2">Active/ Inactive <span class="important_mark">*</span></label>
                        <select name="edit_discount_input_discount_active_inactive" class="form-control edit_discount_input_discount_active_inactive" id="edit_discount_input_discount_active_inactive">
                           <option value="">Select active/ inactive option</option>
                           <option value="active" <?php echo ($discount_data['activate'] == '1') ? 'selected' : ''; ?>>Active</option>
                           <option value="inactive" <?php echo ($discount_data['activate'] == '0') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                        <span class="invalid-feedback edit_discount_active_inactive_err" id="edit_discount_active_inactive_err">
                           <?php echo $edit_discount_active_inactive_err ?>
                        </span>
                     </div>

                     <div class="form-group">
                        <label for="edit_discount_amount" class="edit_product_price mt-2 mb-2">Amount <span class="important_mark">*</span></label>
                        <div class="input-group mb-2">
                           <input type="text" name="edit_discount_amount" class="form-control edit_discount_amount" id="edit_discount_amount" value="<?php echo $discount_data["amount"]; ?>">
                           <div class="input-group-prepend">
                              <select class="custom-select discount_type_dropdown" name="discount_type">
                                 <option value="%" <?php echo ($discount_type == '1') ? 'selected' : ''; ?>>%</option>
                                 <option value="₹" <?php echo ($discount_type == '0') ? 'selected' : ''; ?>>₹</option>
                              </select>
                           </div>
                        </div>
                        <span class="invalid-feedback edit_discount_price_err" id="edit_discount_price_err">
                           <?php echo $edit_discount_price_err ?>
                        </span>
                     </div>

                     <div class="form-group">
                        <label for="edit_discount_expire_date" class="edit_product_discount mt-2 mb-2">Expire Date <span class="important_mark">*</span></label>
                        <input type="text" name="edit_discount_expire_date" class="form-control edit_discount_expire_date" id="edit_discount_expire_date" value="<?php echo date('m/d/Y', strtotime($discount_data["expiration_date"])); ?>">
                        <span class="invalid-feedback edit_discount_expire_date_err" id="edit_discount_expire_date_err">
                           <?php echo $edit_discount_expire_date_err ?>
                        </span>
                     </div>

                     <div class="edit_discount_name_button">
                        <button type="submit" name="update_discount" class="btn btn-primary mt-2 update_discount" id="update_discount" value="Update discount">Update discount</button>
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
   $(document).ready(function() {
      $('#edit_discount_expire_date').datepicker({
         onSelect: function() {
            $('.edit_discount_expire_date_err').text('');
         }
      });
   });

   /*--------------------------------------------------------------- Back Button JS on edit PAGES ----------------------------------------------------------------------------*/
   function back_button_in_discount_edit_page(url, e) {
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

   // redirection ajax for back button the edit discount title
   $(document).off('click', '.edit_discount_back_button').on('click', '.edit_discount_back_button', function(e) {
      e.preventDefault();
      back_button_in_discount_edit_page('/admin/discount/discount.php', e);
   });

   /*--------------------------------------------------------------- Validation for submit button and input in edit files ----------------------------------------------------------------------------*/
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
      var discount_name = $('#edit_discount_input_code_name').val();
      return validate_input(
         discount_name, '.edit_discount_code_name_err', 'Discount name is required.', 'Discount name must be between 5 and 15 characters long.', 'Only alphabets and numbers are allowed.', /^[a-zA-Z0-9]+$/
      );
   }

   function validate_discount_type() {
      var discount_type = $('#edit_discount_input_discount_type').val();
      return validate_input(
         discount_type, '.edit_discount_discount_type_err', 'Discount type is required.', 'Discount type must be between 5 and 15 characters long.', 'Only alphabets and numbers are allowed.', /^[a-zA-Z0-9\s]+$/
      );
   }

   function validate_active_inactive() {
      var selected_option = $('#edit_discount_input_discount_active_inactive').val();
      if (selected_option === '') {
         error_messages = 'Please select an option';
      } else {
         error_messages = '';
      }
      $('.edit_discount_active_inactive_err').text(error_messages);
      return error_messages === '';
   }

   function validate_discount_price() {
      var discount_price = $('.edit_discount_amount').val();
      if (discount_price === '') {
         error_messages = 'Discount price is required.';
      } else if (!/^(0+(\.\d+)?|[1-9]\d*(\.\d+)?)$/.test(discount_price)) {
         error_messages = 'Only numbers are allowed.';
      }
      $('.edit_discount_price_err').text(error_messages);
      return error_messages === '';
   }

   function validate_discount_expire_date() {
      var expire_date = $('#edit_discount_expire_date').val();
      var isValidDate = moment(expire_date, 'MM/DD/YYYY', true).isValid();
      if (expire_date === '') {
         error_messages = 'Expire date is required.';
      } else if (!isValidDate) {
         error_messages = 'Invalid date format. Please use MM/DD/YYYY';
      } else {
         error_messages = '';
      }
      $('.edit_discount_expire_date_err').text(error_messages);
      return error_messages === '';
   }

   // when submit the new file
   $(document).off('submit', '#edit_discount_form').on('submit', '#edit_discount_form', function(e) {
      e.preventDefault();
      var edit_discount_id = $('#edit_discount_id').val();
      var is_valid_name = validate_discount_name();
      var is_valid_description = validate_discount_type();
      var is_valid_active_inactive = validate_active_inactive();
      var is_valid_price = validate_discount_price();
      var is_valid_expire_date = validate_discount_expire_date();
      if (!is_valid_name || !is_valid_description || !is_valid_active_inactive || !is_valid_price || !is_valid_expire_date) {
         return false;
      } else {
         var formData = $(this).serialize();
         formData += "&discount_amount_type=" + $(".discount_type_dropdown").val();
         var parsed_response = null;
         $.ajax({
            type: "POST",
            url: BASE_URL + "/admin/discount/edit_discount/edit_discount_php.php" + "?edit_discount_id=" + edit_discount_id,
            data: formData,
            success: function(response) {
               if (response.trim() === "") {
                  var alert_message = '<div class="alert alert-danger edit_discount_alert_dismissible" role="alert">Discount name not saved.</div>';
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
                        var alert_message = '<div class="alert alert-danger edit_discount_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
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
                              var alert_message = '<div class="alert alert-success edit_discount_success_dismissible" role="alert">' + parsed_response.success + '</div>';
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

      $('.edit_discount_amount').on('input', function() {
         validate_discount_price();
      });
   });

   // when click on the new
   $(document).on('click', '#edit_discount_form', function(e) {
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
   $(document).on('input', '#edit_discount_form', function(e) {
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