<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
include dirname(__DIR__, 2) . "/products/add_products/add_products_php.php";
?>
<div class="add_products_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="products_heading">
         <h2>Add Product</h2>
      </div>

      <div class="add_products">
         <a href="#"><i class="fa-solid fa-arrow-left-long add_products_back_button"></i></a>
      </div>

      <div class="add_products_name">
         <div class="add_section">
            <form method="post" id="add_products_form" class="add_products_form">
               <div class="form-group">
                  <label for="add_products_input_name" class="add_product_name mt-2 mb-2">Name <span class="important_mark">*</span></label>
                  <input type="text" name="add_products_input_name" class="form-control add_products_input_name" id="add_products_input_name">
                  <span class="invalid-feedback add_products_name_err" id="add_products_name_err">
                     <?php echo $add_products_name_err ?>
                     </php>
                  </span>
               </div>

               <div class="form-group">
                  <label for="add_products_description" class="add_products_description mt-2 mb-2">Description <span class="important_mark">*</span></label>
                  <textarea type="text" name="add_products_description" class="form-control add_products_description" id="add_products_description" rows="3"></textarea>
                  <span class="invalid-feedback add_products_description_err" id="add_products_description_err">
                     <?php echo $add_products_description_err ?>
                     </php>
                  </span>
               </div>

               <div class="form-group products_category_type_and_quantity">
                  <div class="form-group me-3 col-6">
                     <label for="add_products_category_type" class="add_product_caegory_type mt-2 mb-2">Category Type
                        <span class="important_mark">*</span></label>
                     <select class="form-select add_products_category_type" id="add_products_category_type" aria-label="Select products Title Name" name="add_products_category_type">
                        <option hidden disabled selected>Select Category Type Name</option>
                        <?php
                        $sql = "SELECT * FROM categories_type";
                        $result = $database_connection->query($sql);
                        if ($result->num_rows > 0) {
                           while ($row = $result->fetch_assoc()) {
                        ?>
                              <option value="<?php echo $row['id']; ?>">
                                 <?php echo $row['name']; ?>
                              </option>
                        <?php
                           }
                        }
                        $database_connection->close();
                        ?>
                     </select>
                     <span class="invalid-feedback add_products_category_type_err" id="add_products_category_type_err">
                        <?php echo $add_products_category_type_err ?>
                        </php>
                     </span>
                  </div>

                  <div class="form-group col-6">
                     <label for="add_products_quantity" class="add_product_quantity mt-2 mb-2">Quantity <span class="important_mark">*</span></label>
                     <input type="text" name="add_products_quantity" class="form-control add_products_quantity" id="add_products_quantity">
                     <span class="invalid-feedback add_products_quantity_err" id="add_products_quantity_err">
                        <?php echo $add_products_quantity_err ?>
                        </php>
                     </span>
                  </div>
               </div>

               <div class="form-group products_price_and_discount">
                  <div class="form-group me-3 col-6">
                     <label for="add_products_price" class="add_product_price mt-2 mb-2">Price <span class="important_mark">*</span></label>
                     <div class="input-group mb-2">
                        <div class="input-group-prepend">
                           <div class="input-group-text indian_rupee_sign">₹</div>
                        </div>
                        <input type="text" name="add_products_price" class="form-control add_products_price" id="add_products_price">
                     </div>
                     <span class="invalid-feedback add_products_price_err" id="add_products_price_err">
                        <?php echo $add_products_price_err ?>
                        </php>
                     </span>
                  </div>

                  <div class="form-group col-6">
                     <label for="add_products_discount" class="add_product_discount mt-2 mb-2">Discount </label>
                     <div class="input-group mb-2">
                        <input type="text" name="add_products_discount" class="form-control add_products_discount" id="add_products_discount">
                        <div class="input-group-prepend">
                           <div class="input-group-text percentage_sign">%</div>
                        </div>
                     </div>
                     <span class="invalid-feedback add_products_discount_err" id="add_products_discount_err">
                        <?php echo $add_products_discount_err ?>
                        </php>
                     </span>
                  </div>
               </div>

               <!-- <div class="form-group">
                  <label for="add_products_image" class="add_product_image mt-2 mb-2">Images <span class="important_mark">*</span></label>
                  <input type="file" name="add_products_image" id="add_products_image" class="add_products_image" multiple accept="image/jpeg, image/png, image/jpg">
                  <span class="invalid-feedback add_products_image_err" id="add_products_image_err">
                     <?php // echo $add_products_image_err 
                     ?>
                  </span>
               </div> -->

               <div class="add_products_name_button">
                  <button type="submit" name="create_products" class="btn btn-primary mt-2 create_products" id="create_products" value="Create products">Create product</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<script>
   /*--------------------------------------------------------------- Validation for submit button and input in add files ----------------------------------------------------------------------------*/
   function validate_input(value, validation_regex, required_error_message, format_error_message, length_error_message, selector) {
      var error_messages = '';
      if (value.trim() === '') {
         error_messages = required_error_message;
      } else if (length_error_message && (value.length < 3 || value.length > 15)) {
         error_messages = length_error_message;
      } else if (validation_regex && !validation_regex.test(value)) {
         error_messages = format_error_message;
      }
      $(selector).text(error_messages);
      return error_messages === '';
   }

   function validate_products_name() {
      var products_name = $('#add_products_input_name').val();
      return validate_input(products_name, /^[a-zA-Z\s]+$/, 'Product name is required.', 'Only alphabets are allowed.', 'Product name must be between 3 and 15 characters long.', '.add_products_name_err');
   }

   function validate_products_description() {
      var products_description = $('#add_products_description').val();
      var error_messages = '';
      if (products_description.trim() === '') {
         error_messages = 'Product description is required.';
      } else if (products_description.length < 5) {
         error_messages = 'Product description must be greater than 5 words.';
      }
      $('.add_products_description_err').text(error_messages);
      return error_messages === '';
   }

   function validate_category_title() {
      var selected_value = $('.add_products_category_type').val();
      var error_messages = '';
      if (selected_value === '' || selected_value === null) {
         error_messages = 'Category type is required.';
      }
      $('.add_products_category_type_err').text(error_messages);
      return error_messages === '';
   }

   function validate_products_quantity() {
      var product_quantity = $('.add_products_quantity').val();
      return validate_input(product_quantity, /^\s*\d+\s*$/, 'Product quantity is required.', 'Only numbers are allowed.', null, '.add_products_quantity_err');
   }

   function validate_products_price() {
      var product_price = $('.add_products_price').val();
      return validate_input(product_price, /^\d+(\.\d+)?$/, 'Product price is required.', 'Only numbers are allowed.', null, '.add_products_price_err');
   }

   function validate_products_discount() {
      var product_discount = $('.add_products_discount').val();
      return validate_input(product_discount, /^\d+$/, null, 'Only numbers are allowed.', null, '.add_products_discount_err');
   }

   // when submit the new products title file
   $(document).off('submit', '#add_products_form').on('submit', '#add_products_form', function(e) {
      e.preventDefault();

      if ($('.add_products_discount').val().trim() === '') {
         $('.add_products_discount').val('0');
      }
      var formData = $(this).serialize();
      var parsed_response = null;
      $.ajax({
         type: "POST",
         url: BASE_URL + "/admin/products/add_products/add_products_php.php",
         data: formData,
         success: function(response) {
            if (response.trim() === "") {
               var alert_message = '<div class="alert alert-danger products_alert_dismissible" role="alert">Product name not saved.</div>';
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
                     var alert_message = '<div class="alert alert-danger products_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                     $('#alert_container').append(alert_message);
                     setTimeout(function() {
                        $('.alert').remove();
                     }, 3000);
                  } else {
                     $.ajax({
                        url: BASE_URL + '/admin/products/products.php',
                        type: 'GET',
                        success: function(data) {
                           $(".container").empty();
                           $('.container').html(data);
                           var alert_message = '<div class="alert alert-success products_success_dismissible" role="alert">' + parsed_response.success + '</div>';
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

   // when click on the new products title input field
   $(document).on('click', '#add_products_form', function(e) {
      var is_valid_name = validate_products_name();
      var is_valid_description = validate_products_description();
      var is_valid_title = validate_category_title();
      var is_valid_quantity = validate_products_quantity();
      var is_valid_price = validate_products_price();
      var is_valid_discount = validate_products_discount();
      if ($('.add_products_discount').val().trim() === '') {
         $('.add_products_discount').val('0');
      }
      if (!is_valid_name || !is_valid_description || !is_valid_title || !is_valid_quantity || !is_valid_price || !is_valid_discount) {
         return false;
      }
   });

   // when input the new products title field
   $(document).on('input', '#add_products_form', function(e) {
      var is_valid_name = validate_products_name();
      var is_valid_description = validate_products_description();
      var is_valid_quantity = validate_products_quantity();
      var is_valid_price = validate_products_price();
      var is_valid_discount = validate_products_discount();
      if (!is_valid_name || !is_valid_description || !is_valid_quantity || !is_valid_price || !is_valid_discount) {
         return false;
      }
   });

   /*--------------------------------------------------------------- Back Button JS on ADD PAGES ----------------------------------------------------------------------------*/
   function back_button_in_products_add_page(url, e) {
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

   // redirection ajax for back button the add products title
   $(document).off('click', '.add_products_back_button').on('click', '.add_products_back_button', function(e) {
      e.preventDefault();
      back_button_in_products_add_page('/admin/products/products.php', e);
   });
</script>