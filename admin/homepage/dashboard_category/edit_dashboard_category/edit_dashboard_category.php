<?php
include dirname(__DIR__, 4) . "/common/config/config.php";
// include dirname(__DIR__, 2) . "/dashboard_category/edit_dashboard_category/edit_dashboard_category_php.php";
?>
<div class="category_section_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="dashboard_category_heading">
         <h2>Edit Dashboard Category</h2>
      </div>

      <div class="edit_dashboard_category">
         <a href="#"><i class="fa-solid fa-arrow-left-long edit_dashboard_category_back_button"></i></a>
      </div>

      <?php
      $id = $_GET['dashboard_category_id'];
      $sql = "SELECT * FROM dashboard_category WHERE id = $id";
      $result = $database_connection->query($sql);

      if ($result->num_rows > 0) {
         $row = $result->fetch_assoc();
      ?>
         <div class="edit_category_name">
            <div class="edit_section">
               <form method="post" id="edit_dashboard_category_form" class="edit_dashboard_category_form">
                  <div class="form-group">
                     <label for="edit_dashboard_category_input_name" class="edit_dashboard_category_name mt-2 mb-2">Dashboard Category Name</label>
                     <input type="text" name="edit_dashboard_category_input_name" class="form-control edit_dashboard_category_input_name" id="edit_dashboard_category_input_name" value="<?= $row["name"] ?>">
                     <input type="hidden" name="edit_dashboard_category_id" id="edit_dashboard_category_id" value="<?= $row["id"] ?>">
                     <span class="invalid-feedback edit_dashboard_category_name_err" id="edit_dashboard_category_name_err"><?= $edit_dashboard_category_name_err ?></span>
                  </div>

                  <div class="categories_types_and_brands d-flex">
                     <?php
                     $types_brands_sql = "SELECT dctb.*, ct.name as type_name, b.name as brand_name
                                         FROM dashboard_category_types_brands dctb
                                         LEFT JOIN categories_type ct ON dctb.categories_types_id = ct.id
                                         LEFT JOIN brands b ON dctb.brands_id = b.id
                                         WHERE dctb.dashboard_category_id = $id";
                     $types_brands_result = $database_connection->query($types_brands_sql);
                     if ($types_brands_result->num_rows > 0) {
                        while ($types_brands_row = $types_brands_result->fetch_assoc()) {
                           $selected_type_id = $types_brands_row["categories_types_id"];
                           $selected_brand_id = $types_brands_row["brands_id"];
                     ?>
                           <div class="form-group dashboard_category_categories_types col-6">
                              <label for="edit_dashboard_category_categories_type" class="edit_dashboard_category_categories_types mt-2 mb-2">Category types <span class="important_mark">*</span></label>
                              <select class="form-select edit_dashboard_category_categories_type" id="edit_dashboard_category_categories_type" aria-label="Select Category types name" name="edit_dashboard_category_categories_type">
                                 <option hidden disabled selected>Select Category types name</option>
                                 <?php
                                 $types_sql = "SELECT * FROM categories_type";
                                 $types_result = $database_connection->query($types_sql);
                                 if ($types_result->num_rows > 0) {
                                    while ($types_row = $types_result->fetch_assoc()) {
                                       $selected = ($types_row['id'] == $selected_type_id) ? "selected" : "";
                                 ?>
                                       <option value="<?= $types_row['id'] ?>" <?= $selected ?>><?= $types_row['name'] ?></option>
                                 <?php
                                    }
                                 }
                                 ?>
                              </select>
                              <span class="invalid-feedback edit_dashboard_category_categories_type_err" id="edit_dashboard_category_categories_type_err"><?= $edit_dashboard_category_categories_type_err ?></span>
                           </div>
                           <div class="form-group dashboard_category_brand col-5">
                              <label for="edit_dashboard_category_brand" class="edit_dashboard_category_brands mt-2 mb-2">Brands <span class="important_mark">*</span></label>
                              <select class="form-select edit_dashboard_category_brand" id="edit_dashboard_category_brand" aria-label="Select Brands Name" name="edit_dashboard_category_brand">
                                 <option hidden disabled selected>Select Brands Name</option>
                                 <?php
                                 $brands_sql = "SELECT * FROM brands";
                                 $brands_result = $database_connection->query($brands_sql);
                                 if ($brands_result->num_rows > 0) {
                                    while ($brands_row = $brands_result->fetch_assoc()) {
                                       $selected = ($brands_row['id'] == $selected_brand_id) ? "selected" : "";
                                 ?>
                                       <option value="<?= $brands_row['id'] ?>" <?= $selected ?>><?= $brands_row['name'] ?></option>
                                 <?php
                                    }
                                 }
                                 ?>
                              </select>
                              <span class="invalid-feedback edit_dashboard_category_brand_err" id="edit_dashboard_category_brand_err"><?= $edit_dashboard_category_brand_err ?></span>
                           </div>
                     <?php
                        }
                     }
                     ?>
                  </div>

                  <div class="form-group">
                     <div id="uploaded_images_preview">
                        <?php
                        $image_sql = "SELECT id, dashboard_category_id, path FROM dashboard_category_images WHERE dashboard_category_id = " . $row['id'];
                        $image_result = $database_connection->query($image_sql);
                        if ($image_result->num_rows > 0) {
                           echo '<label for="edit_uploaded_dashboard_category_image" class="edit_uploaded_dashboard_category_image mt-2 mb-2">Uploaded Images <span class="important_mark">*</span></label>';
                           echo "<div class='dashboard_category_uploaded_images'>";
                           while ($image_row = $image_result->fetch_assoc()) {
                              echo "<div class='uploaded_image_container' style='position:relative' data-image-id='" . $image_row['id'] . "' data-dashboard-category-id='" . $image_row['dashboard_category_id'] . "'>";
                              echo "<img src='" . $_ENV['BASE_URL'] . '/e_commerce/public/assets/dashboard_category_images/' . $image_row['path'] . "' style='max-width: 10rem; margin-right: 10px;' alt='Dashboard Category Image' class='dashboard_categories_images'>";
                              echo "<button class='uploaded_image_close_button' i='uploaded_image_close_button'>X</button>";
                              echo "</div>";
                           }
                           echo "</div>";
                        }
                        ?>
                     </div>
                  </div>

                  <div class="form-group">
                     <label for="edit_dashboard_category_images" class="form-label edit_dashboard_category_image mt-2 mb-2">Images <span class="important_mark">*</span></label>
                     <input type="file" name="edit_dashboard_category_images[]" id="edit_dashboard_category_images" class="form-control edit_dashboard_category_images mb-3" accept="image/jpeg, image/png, image/jpg, image/webp" onchange="upload_preview_images(event)">
                     <span class="invalid-feedback edit_dashboard_category_images_err" id="edit_dashboard_category_images_err"><?= $edit_dashboard_category_images_err ?></span>
                     <div id="uploaded_image_preview" style="display: flex; flex-wrap: wrap; width: 23vw;"></div>
                  </div>

                  <div class="edit_dashboard_category_name_button">
                     <button type="submit" name="create_category" class="btn btn-primary mt-2 create_category" id="create_category" value="Create Category">Save Category</button>
                  </div>
               </form>
            </div>
         </div>
      <?php
      }
      ?>
   </div>
</div>

<script>
   /*--------------------------------------------------------------- Validation for submit button and input in edit files ----------------------------------------------------------------------------*/
   function validate_category_name() {
      var category_name = $('#edit_dashboard_category_input_name').val();
      var error_messages = '';
      if (category_name.trim() === '') {
         error_messages = 'Name is required.';
      } else if (category_name.length < 3 || category_name.length > 25) {
         error_messages = 'Name must be between 3 and 25 characters long.';
      } else if (!/^[a-zA-Z\s]+$/.test(category_name)) {
         error_messages = 'Only alphabets are allowed.';
      }
      $('.edit_dashboard_category_name_err').text(error_messages);
      return error_messages === '';
   }

   function validate_file_input() {
      var error_messages = '';
      if (document.getElementById('edit_dashboard_category_images').files.length === 0) {
         error_messages = 'Image field is required';
      }
      $('.edit_dashboard_category_images_err').text(error_messages);
      return error_messages === '';
   }

   function validate_category_type() {
      var category_categories_type = $('.edit_dashboard_category_categories_type').val();
      var category_brand = $('.edit_dashboard_category_brand').val();
      var error_messages = '';
      if (category_categories_type === '' || category_categories_type === null) {
         if (category_brand === '' || category_brand === null) {
            error_messages = 'Please select either category type or brand.';
         } else {
            error_messages = '';
            $('.edit_dashboard_category_brand_err').text(error_messages);
         }
      }
      $('.edit_dashboard_category_categories_type_err').text(error_messages);
      return error_messages === '';
   }

   // when submit the new category title file
   $(document).off('submit', '#edit_dashboard_category_form').on('submit', '#edit_dashboard_category_form', function(e) {
      e.preventDefault();
      var edit_dashboard_category_id = $('#edit_dashboard_category_id').val();
      var isNameValid = validate_category_name();
      var isTypeValid = validate_category_type();
      if (!isNameValid || !isTypeValid) {
         return false;
      } else {
         var formData = $(this).serialize();
         var form = this;
         var originalFileInput = document.getElementById('edit_dashboard_category_images');
         var originalFiles = originalFileInput.files;
         var fileNames = [];

         for (var i = 0; i < originalFiles.length; i++) {
            fileNames.push(originalFiles[i].name);
         }

         for (var j = 1; j <= fieldCounter; j++) {
            var fileInput = document.getElementById('edit_dashboard_category_images_' + j);
            if (fileInput && fileInput.files.length > 0) {
               var files = fileInput.files;
               for (var k = 0; k < files.length; k++) {
                  fileNames.push(files[k].name);
               }
            }
         }

         var formData = new FormData(form);
         var combined_categories = formData.get('edit_dashboard_category_categories_type') || '0';
         var combined_brands = formData.get('edit_dashboard_category_brand') || '0';

         for (var l = 0; l <= fieldCounter; l++) {
            var category_type_value = $('[name="edit_dashboard_category_categories_type_' + l + '"]').val();
            var category_brands_value = $('[name="edit_dashboard_category_brand_' + l + '"]').val();

            if (category_type_value && category_brands_value) {
               combined_categories += (combined_categories ? ', ' : '') + category_type_value;
               combined_brands += (combined_brands ? ', ' : '0') + category_brands_value;
            } else if (category_type_value) {
               combined_categories += (combined_categories ? ', ' : '') + category_type_value;
               combined_brands += (combined_brands ? ', ' : '0') + (category_brands_value ? category_brands_value : '0');
            } else if (category_brands_value) {
               combined_categories += (combined_categories ? ', ' : '0') + (category_type_value ? category_type_value : '0');
               combined_brands += (combined_brands ? ', ' : '') + category_brands_value;
            }
         }

         formData.set('edit_dashboard_category_categories_type', combined_categories);
         formData.set('edit_dashboard_category_brand', combined_brands);

         formData.append('image_file_names', fileNames.join(','));
         var parsed_response = null;

         $.ajax({
            type: "POST",
            url: BASE_URL + "/admin/homepage/dashboard_category/edit_dashboard_category/edit_dashboard_category_php.php" + "?dashboard_category_id=" + edit_dashboard_category_id,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
               if (response.trim() === "") {
                  var alert_message = '<div class="alert alert-danger dashboard_category_alert_dismissible" role="alert">Category title not saved.</div>';
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
                        var alert_message = '<div class="alert alert-danger dashboard_category_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                        $('#alert_container').append(alert_message);
                        setTimeout(function() {
                           $('.alert').remove();
                        }, 3000);
                     } else {
                        $.ajax({
                           url: BASE_URL + '/admin/homepage/dashboard_category/dashboard_category.php',
                           type: 'GET',
                           success: function(data) {
                              $(".container").empty();
                              $('.container').html(data);
                              var alert_message = '<div class="alert alert-success dashboard_category_success_dismissible" role="alert">' + parsed_response.success + '</div>';
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

   // when click on the new category title input field
   $(document).on('click', '#edit_dashboard_category_form', function(e) {
      var isNameValid = validate_category_name();
      var isTypeValid = validate_category_type();
      if (!isNameValid || !isTypeValid) {
         return false;
      }
   });

   // when input the new category title field
   $(document).on('input', '#edit_dashboard_category_form  ', function(e) {
      var isNameValid = validate_category_name();
      if (!isNameValid) {
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
   $(document).off('click', '.edit_dashboard_category_back_button').on('click', '.edit_dashboard_category_back_button', function(e) {
      e.preventDefault();
      handle_back_button_click_in_edit_page('/admin/homepage/dashboard_category/dashboard_category.php');
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

   /*--------------------------------------------------------------- Delete the uploaded image ----------------------------------------------------------------------------*/
   $(document).off('click', '.uploaded_image_close_button').on('click', '.uploaded_image_close_button', function(e) {
      e.preventDefault();
      var image_id = $(this).parent().data('image-id');
      var dashboard_category_id = $(this).parent().data('dashboard-category-id');
      $(this).parent().remove();
      var parsed_response = null;
      $.ajax({
         type: 'DELETE',
         url: BASE_URL + '/admin/homepage/dashboard_category/delete_dashboard_category/delete_uploaded_image.php' + '?image_id=' + image_id + '&dashboard_category_id=' + dashboard_category_id,
         success: function(response) {
            if (parsed_response) {
               parsed_response = null;
            } else {
               parsed_response = JSON.parse(response);
               if (parsed_response.error) {
                  var alert_message = '<div class="alert alert-danger dashboard_category_uploaded_image_delete_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                  $('#alert_container').append(alert_message);
                  setTimeout(function() {
                     $('.alert').remove();
                  }, 3000);
               } else {
                  var alert_message = '<div class="alert alert-success dashboard_category_uploaded_image_delete_success_dismissible" role="alert">' + parsed_response.success + '</div>';
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

   /*--------------------------------------------------------------- Click on more button to add more category, types, images field ----------------------------------------------------------------------------*/
   var fieldCounter = 1;

   function edit_more_fields() {
      var container = document.getElementById('additional_fields_container');
      container.style.display = 'block';
      var new_fields = `
     <div class="categories_types_and_brands d-flex">
         <div class="form-group dashboard_category_categories_types col-6">
             <label for="edit_dashboard_category_categories_type_${fieldCounter}" class="edit_dashboard_category_categories_types mt-2 mb-2">Category types <span class="important_mark">*</span></label>
             <select class="form-select edit_dashboard_category_categories_type" id="edit_dashboard_category_categories_type_${fieldCounter}" aria-label="Select Category types name" name="edit_dashboard_category_categories_type_${fieldCounter}">
                 <option hidden disabled selected>Select Category types name</option>
                 <?php
                  $sql = "SELECT * FROM categories_type";
                  $result = $database_connection->query($sql);
                  if ($result->num_rows > 0) {
                     while ($categories_type = $result->fetch_assoc()) {
                  ?>
                         <option value="<?php echo $categories_type['id']; ?>"><?php echo $categories_type['name']; ?></option>
                 <?php
                     }
                  }
                  ?>
             </select>
             <span class="invalid-feedback edit_dashboard_category_categories_type_err"></span>
         </div>

         <div class="form-group dashboard_category_brand col-5">
             <label for="edit_dashboard_category_brand_${fieldCounter}" class="edit_dashboard_category_brands mt-2 mb-2">Brands <span class="important_mark">*</span></label>
             <select class="form-select edit_dashboard_category_brand" id="edit_dashboard_category_brand_${fieldCounter}" aria-label="Select Brands Name" name="edit_dashboard_category_brand_${fieldCounter}">
                 <option hidden disabled selected>Select Brands Name</option>
                 <?php
                  $sql = "SELECT * FROM brands";
                  $result = $database_connection->query($sql);
                  if ($result->num_rows > 0) {
                     while ($brands = $result->fetch_assoc()) {
                  ?>
                         <option value="<?php echo $brands['id']; ?>"><?php echo $brands['name']; ?></option>
                 <?php
                     }
                  }
                  ?>
             </select>
             <span class="invalid-feedback edit_dashboard_category_brand_err"></span>
         </div>
     </div>

     <div class="image_and_more_button">
         <div class="form-group col-12">
             <label for="edit_dashboard_category_images_${fieldCounter}" class="form-label edit_product_image mt-2 mb-2">Images <span class="important_mark">*</span></label>
             <input type="file" name="edit_dashboard_category_images_${fieldCounter}" id="edit_dashboard_category_images_${fieldCounter}" class="form-control edit_dashboard_category_images_${fieldCounter}" accept="image/jpeg, image/png, image/jpg, image/webp" onchange="upload_preview_images(event)">
             <span class="invalid-feedback edit_dashboard_category_images_err"></span>
             <div id="uploaded_image_preview_${fieldCounter}" style="display: flex; flex-wrap: wrap; width: 23vw;"></div>
         </div>
     </div>
     <hr>
 `;
      container.insertAdjacentHTML('beforeend', new_fields);
      fieldCounter++;
   }
</script>