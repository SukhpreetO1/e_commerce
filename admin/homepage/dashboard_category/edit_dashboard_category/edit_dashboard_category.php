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
         while ($row = $result->fetch_assoc()) {
      ?>
            <div class="edit_category_name">
               <div class="edit_section">
                  <form method="post" id="edit_dashboard_category_form" class="edit_dashboard_category_form">
                     <div class="form-group">
                        <label for="edit_dashboard_category_input_name" class="edit_dashboard_category_name mt-2 mb-2">Dashboard Category Name</label>
                        <input type="text" name="edit_dashboard_category_input_name" class="form-control edit_dashboard_category_input_name" id="edit_dashboard_category_input_name" value="<?php echo $row["name"]; ?>">
                        <input type="hidden" name="edit_dashboard_category_id" id="edit_dashboard_category_id" value="<?php echo $row["id"]; ?>">
                        <span class="invalid-feedback edit_dashboard_category_name_err" id="edit_dashboard_category_name_err"><?php echo $edit_dashboard_category_name_err ?>
                        </span>
                     </div>

                     <div class="form-group">
                        <div id="uploaded_images_preview">
                           <?php
                           $image_sql = "SELECT id, dashboard_category_id, path FROM dashboard_category_images WHERE dashboard_category_id = " . $row['id'];
                           $image_result = $database_connection->query($image_sql);
                           if ($image_result->num_rows > 0) {
                              echo '<label for="edit_uploaded_dashboard_category_image" class="edit_uploaded_dashboard_category_image mt-2 mb-2">Uploaded Images <span class="important_mark">*</span></label>';
                              echo "<div class='dashboard_category_uploaded_images'>";
                              while ($row = $image_result->fetch_assoc()) {
                                 echo "<div class='uploaded_image_container' style='position:relative' data-image-id='" . $row['id'] . "' data-dashboard-category-id='" . $row['dashboard_category_id'] . "'>";
                                 echo "<img src='" . $_ENV['BASE_URL'] . '/e_commerce/public/assets/dashboard_category_images/' . $row['path'] . "' style='max-width: 10rem; margin-right: 10px;' alt='Dashboard Category Image' class='dashboard_categories_images'>";
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
                        <input type="file" name="edit_dashboard_category_images[]" id="edit_dashboard_category_images" class="form-control edit_dashboard_category_images mb-3" multiple accept="image/jpeg, image/png, image/jpg, image/webp" onchange="upload_preview_images(event)">
                        <span class="invalid-feedback edit_dashboard_category_images_err" id="edit_dashboard_category_images_err">
                           <?php echo $edit_dashboard_category_images_err ?>
                        </span>
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
      }
      $database_connection->close();
      ?>
   </div>
</div>

<script>
   /*--------------------------------------------------------------- Validation for submit button and input in edit files ----------------------------------------------------------------------------*/
   function validate_category_name_in_edit_page() {
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

   // when submit the new category title file
   $(document).off('submit', '#edit_dashboard_category_form').on('submit', '#edit_dashboard_category_form', function(e) {
      e.preventDefault();
      var edit_dashboard_category_id = $('#edit_dashboard_category_id').val();
      if (!validate_file_input()) {
         return false;
      } else {
         var formData = $(this).serialize();

         var form = this;
         var fileInput = document.getElementById('edit_dashboard_category_images');
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
      if (!validate_category_name_in_edit_page()) {
         return false;
      }
   });

   // when input the new category title field
   $(document).on('input', '#edit_dashboard_category_form  ', function(e) {
      if (!validate_category_name_in_edit_page()) {
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
</script>