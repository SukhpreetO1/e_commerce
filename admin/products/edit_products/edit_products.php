<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
?>
<div class="edit_products_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="products_heading">
         <h2>Edit Product</h2>
      </div>

      <div class="edit_products">
         <a href="#"><i class="fa-solid fa-arrow-left-long edit_products_back_button"></i></a>
      </div>

      <?php
      $id = $_GET['product_id'];
      $sql = "SELECT * FROM products WHERE id = $id";
      $result = $database_connection->query($sql);
      if ($result->num_rows > 0) {
         while ($product_data = $result->fetch_assoc()) {
            $selected_category_id = $product_data["categories_type_id"];
            $selected_discount_id = $product_data["discount_id"];
            $selected_brands_id = $product_data["brands_id"];
            $selected_color_id = $product_data["color_id"];
      ?>

            <div class="edit_products_name">
               <div class="edit_section">
                  <form method="post" id="edit_products_form" class="edit_products_form">
                     <div class="form-group products_brands_name_and_names">
                        <div class="form-group me-2 col-6">
                           <input type="hidden" name="edit_product_id" id="edit_product_id" value="<?php echo $product_data["id"]; ?>">
                           <label for="edit_product_brands_name" class="edit_product_discount mt-2 mb-2">Discount <span class="important_mark">*</span></label>
                           <select class="form-select edit_product_brands_name" id="edit_product_brands_name" name="edit_product_brands_name">
                              <option hidden disabled selected>Select Discount</option>
                              <?php
                              $brands_sql = "SELECT * FROM brands";
                              $result = $database_connection->query($brands_sql);
                              if ($result->num_rows > 0) {
                                 while ($brands = $result->fetch_assoc()) {
                                    $selected_brands = ($brands['id'] == $selected_brands_id) ? "selected" : "";
                              ?>
                                    <option value="<?php echo $brands['id']; ?>" <?php echo $selected_brands; ?>> <?php echo $brands['name']; ?></option>
                              <?php
                                 }
                              }
                              ?>
                           </select>
                           <span class="invalid-feedback edit_products_brands_name_err" id="edit_products_brands_name_err">
                              <?php echo $edit_products_brands_name_err ?>
                           </span>
                        </div>

                        <div class="form-group me-2 col-6">
                           <label for="edit_products_input_name" class="edit_product_name mt-2 mb-2">Name <span class="important_mark">*</span></label>
                           <input type="text" name="edit_products_input_name" class="form-control edit_products_input_name" id="edit_products_input_name" value="<?php echo $product_data["name"]; ?>">
                           <span class="invalid-feedback edit_products_name_err" id="edit_products_name_err">
                              <?php echo $edit_products_name_err ?>
                           </span>
                        </div>
                     </div>

                     <div class="form-group">
                        <label for="edit_products_description" class="edit_products_description mt-2 mb-2">Description <span class="important_mark">*</span></label>
                        <textarea type="text" name="edit_products_description" class="form-control edit_products_description" id="edit_products_description" rows="3"><?php echo $product_data["description"]; ?></textarea>
                        <span class="invalid-feedback edit_products_description_err" id="edit_products_description_err">
                           <?php echo $edit_products_description_err ?>
                        </span>
                     </div>

                     <div class="form-group products_category_type_and_quantity">
                        <div class="form-group me-2 col-6"">
                           <label for=" edit_products_category_type" class="edit_product_caegory_type mt-2 mb-2">Category Type
                           <span class="important_mark">*</span></label>
                           <select class="form-select edit_products_category_type" id="edit_products_category_type" aria-label="Select products Title Name" name="edit_products_category_type">
                              <option hidden disabled selected>Select Category Type Name</option>
                              <?php
                              $sql = "SELECT * FROM categories_type";
                              $result = $database_connection->query($sql);
                              if ($result->num_rows > 0) {
                                 while ($row = $result->fetch_assoc()) {
                                    $selected = ($row['id'] == $selected_category_id) ? "selected" : "";
                              ?>
                                    <option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>><?php echo $row['name']; ?></option>
                              <?php
                                 }
                              }
                              ?>
                           </select>
                           <span class="invalid-feedback edit_products_category_type_err" id="edit_products_category_type_err">
                              <?php echo $edit_products_category_type_err ?>
                           </span>
                        </div>

                        <div class="form-group me-2 col-6">
                           <label for="edit_products_quantity" class="edit_product_quantity mt-2 mb-2">Quantity <span class="important_mark">*</span></label>
                           <input type="text" name="edit_products_quantity" class="form-control edit_products_quantity" id="edit_products_quantity" value="<?php echo $product_data["quantity"]; ?>">
                           <span class="invalid-feedback edit_products_quantity_err" id="edit_products_quantity_err">
                              <?php echo $edit_products_quantity_err ?>
                           </span>
                        </div>
                     </div>

                     <div class="form-group products_size_and_color">
                        <div class="form-group me-2 col-6">
                           <label for="edit_products_size" class="edit_product_size mt-2 mb-2">Size <span class="important_mark">*</span></label>
                           <select class="selectpicker edit_products_size" id="edit_products_size" aria-label="Select products size" name="edit_products_size[]" multiple data-live-search="true">
                              <option disabled>Select products Size</option>
                              <?php
                              $size_sql = "SELECT * FROM size";
                              $result = $database_connection->query($size_sql);
                              $selected_size_ids = [];
                              $selected_size_id_query = "SELECT size_id FROM product_size_variant WHERE product_id = " . $product_data['id'];
                              $selected_size_id_result = $database_connection->query($selected_size_id_query);
                              if ($selected_size_id_result->num_rows > 0) {
                                 while ($row = $selected_size_id_result->fetch_assoc()) {
                                    $selected_size_ids[] = $row['size_id'];
                                 }
                              }
                              if ($result->num_rows > 0) {
                                 while ($size = $result->fetch_assoc()) {
                                    $selected_sizes = (in_array($size['id'], $selected_size_ids)) ? "selected" : "";
                                    echo "<option value='" . $size['id'] . "' " . $selected_sizes . ">" . $size['name'] . "</option>";
                                 }
                              }
                              ?>
                           </select>
                           <span class="invalid-feedback edit_products_size_err" id="edit_products_size_err">
                              <?php echo $edit_products_size_err ?>
                           </span>
                        </div>

                        <div class="form-group me-2 col-6">
                           <label for="edit_products_color" class="edit_product_color mt-2 mb-2">Color <span class="important_mark">*</span></label>
                           <div class="custom-dropdown edit_products_color" id="edit_products_color" name="edit_products_color">
                              <div class="selected-option custom_product_dropdown_option">Select product color</div>
                              <ul class="options custom_product_dropdown">
                                 <?php
                                 $color_sql = "SELECT * FROM color";
                                 $result = $database_connection->query($color_sql);
                                 if ($result->num_rows > 0) {
                                    while ($color = $result->fetch_assoc()) {
                                       $selected_color = ($color['id'] == $selected_color_id) ? "selected" : "";
                                 ?>
                                       <li data-value="<?php echo $color['id'] ?>" class="<?php echo $selected_color; ?>">
                                          <span class="additional-info color_name" value="<?php echo $color['color_code'] ?>" style="background-color: <?php echo $color['color_code'] ?>"></span>
                                          <span class="color_name"><?php echo $color['name']; ?></span>
                                       </li>
                                 <?php
                                    }
                                 }
                                 ?>
                              </ul>
                           </div>
                           <span class="invalid-feedback edit_products_color_err" id="edit_products_color_err">
                              <?php echo $edit_products_color_err ?>
                           </span>
                        </div>
                     </div>

                     <div class="form-group products_price_and_discount">
                        <div class="form-group me-2 col-6">
                           <label for="edit_products_price" class="edit_product_price mt-2 mb-2">Price <span class="important_mark">*</span></label>
                           <div class="input-group mb-2">
                              <div class="input-group-prepend">
                                 <div class="input-group-text indian_rupee_sign">₹</div>
                              </div>
                              <input type="text" name="edit_products_price" class="form-control edit_products_price" id="edit_products_price" value="<?php echo $product_data["price"]; ?>">
                           </div>
                           <span class="invalid-feedback edit_products_price_err" id="edit_products_price_err">
                              <?php echo $edit_products_price_err ?>
                           </span>
                        </div>

                        <div class="form-group me-2 col-6">
                           <label for="edit_products_discount" class="edit_product_discount mt-2 mb-2">Discount </label>
                           <select class="form-select edit_products_discount" id="edit_products_discount" name="edit_products_discount" style="height: 2.8rem;">
                              <option hidden disabled selected>Select Discount</option>
                              <?php
                              $discount_sql = "SELECT * FROM discount";
                              $result = $database_connection->query($discount_sql);
                              if ($result->num_rows > 0) {
                                 while ($discount = $result->fetch_assoc()) {
                                    $selected_discount = ($discount['id'] == $selected_discount_id) ? "selected" : "";
                              ?>
                                    <option value="<?php echo $discount['id']; ?>" <?php echo $selected_discount; ?>> <?php echo $discount['code_name']; ?></option>
                              <?php
                                 }
                              }
                              ?>
                           </select>
                           <span class="invalid-feedback edit_products_discount_err" id="edit_products_discount_err">
                              <?php echo $edit_products_discount_err ?>
                           </span>
                        </div>
                     </div>

                     <div class="form-group">
                        <div id="uploaded_images_preview">
                           <?php
                           $image_sql = "SELECT id, products_id, path FROM product_image WHERE products_id = " . $product_data['id'];
                           $image_result = $database_connection->query($image_sql);
                           if ($image_result->num_rows > 0) {
                              echo '<label for="edit_uploaded_products_image" class="edit_uploaded_products_image mt-2 mb-2">Uploaded Images <span class="important_mark">*</span></label>';
                              echo "<div class='products_uploaded_images'>";
                              while ($row = $image_result->fetch_assoc()) {
                                 echo "<div class='uploaded_image_container' style='position:relative' data-image-id='" . $row['id'] . "' data-product-id='" . $row['products_id'] . "'>";
                                 echo "<img src='" . $_ENV['BASE_URL'] . '/e_commerce/public/assets/product_images/' . $row['path'] . "' style='max-width: 10rem; margin-right: 10px;' alt='Product Image' class='product_uploded_images'>";
                                 echo "<button class='uploaded_image_close_button' i='uploaded_image_close_button'>X</button>";
                                 echo "</div>";
                              }
                              echo "</div>";
                           }
                           ?>
                        </div>
                     </div>

                     <div class="form-group">
                        <label for="edit_products_image" class="edit_product_image mt-2 mb-2">Images <span class="important_mark">*</span></label>
                        <input type="file" name="edit_products_image[]" id="edit_products_image" class="edit_products_image" multiple accept="image/jpeg, image/png, image/jpg" onchange="upload_preview_images(event)">
                        <span class="invalid-feedback edit_products_image_err" id="edit_products_image_err">
                           <?php echo $edit_products_image_err ?>
                        </span>
                        <div id="uploaded_image_preview" style="display: flex; flex-wrap: wrap;"></div>
                     </div>

                     <div class="edit_products_name_button">
                        <button type="submit" name="create_products" class="btn btn-primary mt-2 create_products" id="create_products" value="Create products">Update product</button>
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
   /*--------------------------------------------------------------- js for the custom dropdown ---------------------------------------------------------------*/
   $(document).ready(function() {
      var initialColorName = $('.options li.selected .color_name').text().trim();
      $('.selected-option').text(initialColorName);
      $(document).on('click', '.custom_product_dropdown_option', function(event) {
         event.stopPropagation();
         var dropdown = $(this).closest('.custom-dropdown');
         var options = dropdown.find('.options');
         options.toggle();
      });

      $(document).on('click', '.options li', function(event) {
         event.stopPropagation();
         var dropdown = $(this).closest('.custom-dropdown');
         var selectedOption = dropdown.find('.selected-option');
         var options = dropdown.find('.options');
         var target = $(event.target).closest('li');
         if (target.length) {
            selectedOption.text(target.find('.color_name').text().trim());
            target.addClass('selected').siblings().removeClass('selected');
            options.hide();
            validate_color();
         }
      });

      $(document).click(function(event) {
         var dropdown = $('.custom-dropdown');
         var options = dropdown.find('.options');
         if (!$(event.target).closest('.custom_product_dropdown').length) {
            options.hide();
         }
      });
   });

   /*--------------------------------------------------------------- Multi select dropdown ----------------------------------------------------------------------------*/
   $('.selectpicker').selectpicker('refresh');

   /*--------------------------------------------------------------- Delete the uploaded image ----------------------------------------------------------------------------*/
   $(document).off('click', '.uploaded_image_close_button').on('click', '.uploaded_image_close_button', function(e) {
      e.preventDefault();
      var image_id = $(this).parent().data('image-id');
      var product_id = $(this).parent().data('product-id');
      $(this).parent().remove();
      var parsed_response = null;
      $.ajax({
         type: 'DELETE',
         url: BASE_URL + '/admin/products/delete_products/delete_uploaded_image.php' + '?image_id=' + image_id + '&product_id=' + product_id,
         success: function(response) {
            if (parsed_response) {
               parsed_response = null;
            } else {
               parsed_response = JSON.parse(response);
               if (parsed_response.error) {
                  var alert_message = '<div class="alert alert-danger products_uploaded_image_delete_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                  $('#alert_container').append(alert_message);
                  setTimeout(function() {
                     $('.alert').remove();
                  }, 3000);
               } else {
                  var alert_message = '<div class="alert alert-success products_uploaded_image_delete_success_dismissible" role="alert">' + parsed_response.success + '</div>';
                  $('#alert_container').append(alert_message);
                  setTimeout(function() {
                     $('.alert').remove();
                  }, 2000);
               }
            }
         },
         error: function(e) {
            console.log(e);
         }
      });
   });

   /*--------------------------------------------------------------- Validation for submit button and input in edit files ----------------------------------------------------------------------------*/
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

   function validate_brands_name() {
      var selected_color = $('#edit_product_brands_name').val();
      var error_messages = '';
      if (selected_color === '' || selected_color === null) {
         error_messages = 'Please select atleast 1 brand name.';
      }
      $('.edit_products_brands_name_err').text(error_messages);
      return error_messages === '';
   }

   function validate_products_name() {
      var products_name = $('#edit_products_input_name').val();
      return validate_input(products_name, /^[a-zA-Z\s]+$/, 'Product name is required.', 'Only alphabets are allowed.', 'Product name must be between 3 and 15 characters long.', '.edit_products_name_err');
   }

   function validate_products_description() {
      var products_description = $('#edit_products_description').val();
      var error_messages = '';
      if (products_description.trim() === '') {
         error_messages = 'Product description is required.';
      } else if (products_description.length < 5) {
         error_messages = 'Product description must be greater than 5 words.';
      }
      $('.edit_products_description_err').text(error_messages);
      return error_messages === '';
   }

   function validate_category_title() {
      var selected_value = $('.edit_products_category_type').val();
      var error_messages = '';
      if (selected_value === '' || selected_value === null) {
         error_messages = 'Category type is required.';
      }
      $('.edit_products_category_type_err').text(error_messages);
      return error_messages === '';
   }

   function validate_products_quantity() {
      var product_quantity = $('.edit_products_quantity').val();
      return validate_input(product_quantity, /^\s*\d+\s*$/, 'Product quantity is required.', 'Only numbers are allowed.', null, '.edit_products_quantity_err');
   }

   function validate_size() {
      var selected_size = $('#edit_products_size').val();
      var error_messages = '';
      if (selected_size == '') {
         error_messages = 'Select atleast 1 size.';
      }
      $('.edit_products_size_err').text(error_messages);
      return error_messages === '';
   }

   function validate_color() {
      var selected_color = $('#edit_products_color .selected-option').text().trim();
      var error_messages = '';
      if (selected_color === 'Select product color') {
         error_messages = 'Please select atleast 1 color.';
      }
      $('.edit_products_color_err').text(error_messages);
      return error_messages === '';
   }

   function validate_products_price() {
      var product_price = $('.edit_products_price').val();
      return validate_input(product_price, /^\d+(\.\d+)?$/, 'Product price is required.', 'Only numbers are allowed.', null, '.edit_products_price_err');
   }

   function validate_products_discount() {
      var product_discount = $('.edit_products_discount').val();
      return validate_input(product_discount, /^\d+$/, null, 'Only numbers are allowed.', null, '.edit_products_discount_err');
   }

   // when submit the new products title file
   $(document).off('submit', '#edit_products_form').on('submit', '#edit_products_form', function(e) {
      e.preventDefault();
      var edit_product_id = $('#edit_product_id').val();
      if ($('.edit_products_discount').val().trim() === '') {
         $('.edit_products_discount').val('0');
      }
      var form = this;
      var fileInput = document.getElementById('edit_products_image');
      var files = fileInput.files;
      var fileNames = [];

      for (var i = 0; i < files.length; i++) {
         fileNames.push(files[i].name);
      }
      var selectedSizes = $('#edit_products_size').val().join(',');
      var selectedColorId = $('#edit_products_color .options li.selected').attr('data-value');

      var formData = new FormData(form);
      formData.append('image_file_names', fileNames.join(','));
      formData.append('edit_products_size', selectedSizes);
      formData.append('edit_products_color', selectedColorId);

      var parsed_response = null;
      $.ajax({
         type: "POST",
         url: BASE_URL + "/admin/products/edit_products/edit_products_php.php" + "?edit_product_id=" + edit_product_id,
         data: formData,
         processData: false,
         contentType: false,
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
                     var alert_message = '<div class="alert alert-danger edit_products_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
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
   $(document).off('click', '#edit_products_form').on('click', '#edit_products_form', function(e) {
      var is_valid_brand_name = validate_brands_name();
      var is_valid_name = validate_products_name();
      var is_valid_description = validate_products_description();
      var is_valid_title = validate_category_title();
      var is_valid_quantity = validate_products_quantity();
      var is_valid_size = validate_size();
      var is_valid_color = validate_color();
      var is_valid_price = validate_products_price();
      var is_valid_discount = validate_products_discount();
      if ($('.edit_products_discount').val().trim() === '') {
         $('.edit_products_discount').val('0');
      }
      if (!is_valid_brand_name || !is_valid_name || !is_valid_description || !is_valid_title || !is_valid_quantity || !is_valid_price || !is_valid_size || !is_valid_color) {
         return false;
      }
   });

   // when input the new products title field
   $(document).on('input', '#edit_products_form', function(e) {
      var is_valid_name = validate_products_name();
      var is_valid_description = validate_products_description();
      var is_valid_quantity = validate_products_quantity();
      var is_valid_price = validate_products_price();
      var is_valid_discount = validate_products_discount();
      if (!is_valid_name || !is_valid_description || !is_valid_quantity || !is_valid_price || !is_valid_discount) {
         return false;
      }
   });

   /*--------------------------------------------------------------- Back Button JS on edit PAGES ----------------------------------------------------------------------------*/
   function back_button_in_products_edit_page(url, e) {
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

   // redirection ajax for back button the edit products title
   $(document).off('click', '.edit_products_back_button').on('click', '.edit_products_back_button', function(e) {
      e.preventDefault();
      back_button_in_products_edit_page('/admin/products/products.php', e);
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
</script>