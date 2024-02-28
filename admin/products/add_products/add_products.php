<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
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
                  </span>
               </div>

               <div class="form-group">
                  <label for="add_products_description" class="add_products_description mt-2 mb-2">Description <span class="important_mark">*</span></label>
                  <textarea type="text" name="add_products_description" class="form-control add_products_description" id="add_products_description" rows="3"></textarea>
                  <span class="invalid-feedback add_products_description_err" id="add_products_description_err">
                     <?php echo $add_products_description_err ?>
                  </span>
               </div>

               <div class="form-group products_category_type_and_quantity">
                  <div class="form-group me-2 col-6">
                     <label for="add_products_category_type" class="add_product_caegory_type mt-2 mb-2">Category Type <span class="important_mark">*</span></label>
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
                        ?>
                     </select>
                     <span class="invalid-feedback add_products_category_type_err" id="add_products_category_type_err">
                        <?php echo $add_products_category_type_err ?>
                     </span>
                  </div>

                  <div class="form-group col-6">
                     <label for="add_products_quantity" class="add_product_quantity mt-2 mb-2">Quantity <span class="important_mark">*</span></label>
                     <input type="text" name="add_products_quantity" class="form-control add_products_quantity" id="add_products_quantity">
                     <span class="invalid-feedback add_products_quantity_err" id="add_products_quantity_err">
                        <?php echo $add_products_quantity_err ?>
                     </span>
                  </div>
               </div>

               <div class="form-group products_size_and_color">
                  <div class="form-group me-2 col-6">
                     <label for="add_products_size" class="add_product_size mt-2 mb-2">Size <span class="important_mark">*</span></label>
                     <select class="form-select add_products_size" id="add_products_size" aria-label="Select products size" name="add_products_size[]">
                        <option hidden disabled selected>Select products size</option>
                        <?php
                        $sql = "SELECT * FROM size";
                        $result = $database_connection->query($sql);
                        if ($result->num_rows > 0) {
                           while ($product_size = $result->fetch_assoc()) {
                        ?>
                              <option value="<?php echo $product_size['id']; ?>">
                                 <?php echo $product_size['name']; ?>
                              </option>
                        <?php
                           }
                        }
                        ?>
                     </select>
                     <span class="invalid-feedback add_products_size_err" id="add_products_size_err">
                        <?php echo $add_products_size_err ?>
                     </span>
                  </div>

                  <div class="form-group me-2 col-6">
                     <label for="add_products_color" class="add_product_color mt-2 mb-2">Color <span class="important_mark">*</span></label>
                     <select class="form-select add_products_color" id="add_products_color" aria-label="Select products size" name="add_products_color[]" multiple="multiple">
                        <option hidden disabled selected>Select products color</option>
                        <?php
                        $sql = "SELECT * FROM color";
                        $result = $database_connection->query($sql);
                        if ($result->num_rows > 0) {
                           while ($product_color = $result->fetch_assoc()) {
                        ?>
                              <option value="<?php echo $product_color['id'] ?>" class="color_code_showing_color" style="background-color: <?php echo $product_color['color_code']; ?>;">
                                 <?php echo $product_color['name']; ?>
                              </option>
                        <?php
                           }
                        }
                        ?>
                     </select>
                     <span class="invalid-feedback add_products_color_err" id="add_products_color_err">
                        <?php echo $add_products_color_err ?>
                     </span>
                  </div>
               </div>

               <div class="form-group products_price_and_discount">
                  <div class="form-group me-2 col-6">
                     <label for="add_products_price" class="add_product_price mt-2 mb-2">Price <span class="important_mark">*</span></label>
                     <div class="input-group mb-2">
                        <div class="input-group-prepend">
                           <div class="input-group-text indian_rupee_sign">₹</div>
                        </div>
                        <input type="text" name="add_products_price" class="form-control add_products_price" id="add_products_price">
                     </div>
                     <span class="invalid-feedback add_products_price_err" id="add_products_price_err">
                        <?php echo $add_products_price_err ?>
                     </span>
                  </div>

                  <div class="form-group col-6">
                     <label for="add_products_discount" class="add_product_discount mt-2 mb-2">Discount </label>
                     <select class="form-select add_products_discount" id="add_products_discount" name="add_products_discount" style="height: 2.8rem;">
                        <option hidden disabled selected>Select Discount</option>
                        <?php
                        $sql = "SELECT * FROM discount";
                        $result = $database_connection->query($sql);
                        if ($result->num_rows > 0) {
                           while ($row = $result->fetch_assoc()) {
                        ?>
                              <option value="<?php echo $row['id']; ?>">
                                 <?php echo $row['code_name']; ?>
                              </option>
                        <?php
                           }
                        }
                        ?>
                     </select>
                     <span class="invalid-feedback add_products_discount_err" id="add_products_discount_err">
                        <?php echo $add_products_discount_err ?>
                     </span>
                  </div>
               </div>

               <div class="form-group">
                  <label for="add_products_image" class="add_product_image mt-2 mb-2">Images <span class="important_mark">*</span></label>
                  <input type="file" name="add_products_image[]" id="add_products_image" class="add_products_image" multiple accept="image/jpeg, image/png, image/jpg" onchange="upload_preview_images(event)">
                  <span class="invalid-feedback add_products_image_err" id="add_products_image_err">
                     <?php echo $add_products_image_err ?>
                  </span>
                  <div id="uploaded_image_preview" style="display: flex; flex-wrap: wrap;"></div>
               </div>

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
      if (value === '') {
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
      if (products_description === '') {
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
      return validate_input(product_quantity, /^(?!0+(\.\d+)?$)\d+$/, 'Product quantity is required.', 'Only numbers are allowed and must start from 1 without decimal.', null, '.add_products_quantity_err');
   }

   function validate_products_price() {
      var product_price = $('.add_products_price').val();
      return validate_input(product_price, /^(?!0+(\.0+)?$)\d+(\.\d+)?$/, 'Product price is required.', 'Only numbers are allowed.', null, '.add_products_price_err');
   }

   // when submit the new products title file
   $(document).off('submit', '#add_products_form').on('submit', '#add_products_form', function(e) {
      e.preventDefault();

      if ($('#add_products_discount').val() === '') {
         $('#add_products_discount option:eq(1)').prop('selected', true);
      }

      var form = this;
      var fileInput = document.getElementById('add_products_image');
      var files = fileInput.files;
      var fileNames = [];

      for (var i = 0; i < files.length; i++) {
         fileNames.push(files[i].name);
      }

      var formData = new FormData(form);
      formData.append('image_file_names', fileNames.join(','));
      var parsed_response = null;
      $.ajax({
         type: "POST",
         url: BASE_URL + "/admin/products/add_products/add_products_php.php",
         data: formData,
         processData: false,
         contentType: false,
         success: function(response) {
            if (response === "") {
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

   // when click on the new products title field
   $(document).off('click', '#add_products_form').on('click', '#add_products_form', function(e) {
      var is_valid_name = validate_products_name();
      var is_valid_description = validate_products_description();
      var is_valid_title = validate_category_title();
      var is_valid_quantity = validate_products_quantity();
      var is_valid_price = validate_products_price();
      if ($('#add_products_discount').val() === '') {
         $('#add_products_discount option:eq(1)').prop('selected', true);
      }
      if (!is_valid_name || !is_valid_description || !is_valid_title || !is_valid_quantity || !is_valid_price) {
         return false;
      }
   });

   // when input the new products title field
   $(document).on('input', '#add_products_form', function(e) {
      var is_valid_name = validate_products_name();
      var is_valid_description = validate_products_description();
      var is_valid_quantity = validate_products_quantity();
      var is_valid_price = validate_products_price();
      if (!is_valid_name || !is_valid_description || !is_valid_quantity || !is_valid_price) {
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

   /*--------------------------------------------------------------- Uploaded image preview ----------------------------------------------------------------------------*/
   var filesCount = 0;

   function upload_preview_images(event) {
      var preview = document.getElementById('uploaded_image_preview');
      var fileInput = event.target;
      preview.innerHTML = '';
      if (event.target.files) {
         [...event.target.files].forEach(function(file) {
            var reader = new FileReader();
            reader.onload = function(e) {
               var imgContainer = document.createElement('div');
               imgContainer.style.position = 'relative';
               var img = document.createElement('img');
               img.src = e.target.result;
               img.style.maxWidth = '8rem';
               img.style.marginRight = '10px';
               img.style.cursor = 'pointer';
               img.onclick = function() {
                  window.open(e.target.result);
               };
               imgContainer.appendChild(img);
               var removeBtn = document.createElement('button');
               removeBtn.innerHTML = 'x';
               removeBtn.classList.add('preview_image_remove_button');
               removeBtn.onclick = function() {
                  imgContainer.remove();
                  var newFiles = Array.from(fileInput.files).filter(function(file) {
                     return file.name !== fileInput.files[0].name;
                  });
                  var dataTransfer = new DataTransfer();
                  newFiles.forEach(function(file) {
                     dataTransfer.items.add(file);
                  });
                  fileInput.files = dataTransfer.files;
                  filesCount--;
                  updateFileInputValue(fileInput, filesCount);
               };
               imgContainer.appendChild(removeBtn);
               preview.appendChild(imgContainer);
               filesCount++;
               updateFileInputValue(fileInput, filesCount);
            };
            reader.readAsDataURL(file);
         });
      }
   }

   function updateFileInputValue(fileInput, count) {
      if (count > 0) {
         fileInput.dataset.fileCount = count;
      } else {
         fileInput.removeAttribute('data-file-count');
      }
   }

   $(document).ready(function() {
      $('#add_products_color').multiselect({
         includeSelectAllOption: true,
      });
   });
</script>