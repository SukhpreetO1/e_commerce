<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
?>
<div class="add_dashboard_category_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="dashboard_category_heading">
         <h2>Add Dashboard Category</h2>
      </div>

      <div class="add_dashboard_category">
         <a href="#"><i class="fa-solid fa-arrow-left-long add_dashboard_category_back_button"></i></a>
      </div>

      <div class="add_category_name">
         <div class="add_section">
            <form method="post" id="add_dashboard_category_form" class="add_dashboard_category_form">
               <div class="form-group">
                  <label for="add_dashboard_category_input_name" class="add_dashboard_category_name mt-2 mb-2">Dashboard Category Name <span class="important_mark">*</span></label>
                  <input type="text" name="add_dashboard_category_input_name" class="form-control add_dashboard_category_input_name" id="add_dashboard_category_input_name">
                  <span class="invalid-feedback add_dashboard_category_name_err" id="add_dashboard_category_name_err"><?php echo $add_dashboard_category_name_err ?></php></span>
               </div>

               <div class="form-group">
                  <label for="add_dashboard_category_images" class="form-label add_product_image mt-2 mb-2">Images <span class="important_mark">*</span></label>
                  <input type="file" name="add_dashboard_category_images[]" id="add_dashboard_category_images" class="form-control add_dashboard_category_images mb-3" multiple accept="image/jpeg, image/png, image/jpg, image/webp" onchange="upload_preview_images(event)">
                  <span class="invalid-feedback add_dashboard_category_images_err" id="add_dashboard_category_images_err">
                     <?php echo $add_dashboard_category_images_err ?>
                  </span>
                  <div id="uploaded_image_preview" style="display: flex; flex-wrap: wrap; width: 23vw;"></div>
               </div>

               <div class="add_dashboard_category_name_button">
                  <button type="submit" name="create_category" class="btn btn-primary mt-2 create_category" id="create_category" value="Create Category">Create Category</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<script>
   /*--------------------------------------------------------------- Validation for submit button and input in add files ----------------------------------------------------------------------------*/
   function validate_category_name() {
      var category_name = $('#add_dashboard_category_input_name').val();
      var error_messages = '';
      if (category_name.trim() === '') {
         error_messages = 'Name is required.';
      } else if (category_name.length < 3 || category_name.length > 15) {
         error_messages = 'Name must be between 3 and 15 characters long.';
      } else if (!/^[a-zA-Z\s]+$/.test(category_name)) {
         error_messages = 'Only alphabets are allowed.';
      }
      $('.add_dashboard_category_name_err').text(error_messages);
      return error_messages === '';
   }

   function validate_file_input() {
      var error_messages = '';
      if (document.getElementById('add_dashboard_category_images').files.length === 0) {
         error_messages = 'Image field is required';
      }
      $('.add_dashboard_category_images_err').text(error_messages);
      return error_messages === '';
   }

   // when submit the new category title file
   $(document).off('submit', '#add_dashboard_category_form').on('submit', '#add_dashboard_category_form', function(e) {
      e.preventDefault();
      if (!validate_file_input()) {
         return false;
      } else {
         var formData = $(this).serialize();

         var form = this;
         var fileInput = document.getElementById('add_dashboard_category_images');
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
            url: BASE_URL + "/admin/homepage/dashboard_category/add_dashboard_category/add_dashboard_category_php.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
               if (response.trim() === "") {
                  var alert_message = '<div class="alert alert-danger dashboard_category_alert_dismissible" role="alert">Dashboard category not saved.</div>';
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
                              var new_url = window.location.href.replace('?tab=add_dashboard_category', '?tab=dashboard_category');
                              history.pushState(null, null, new_url);
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
   $(document).on('click', '#add_dashboard_category_form', function(e) {
      if (!validate_category_name()) {
         return false;
      }
   });

   // when input the new category title field
   $(document).on('input', '#add_dashboard_category_form', function(e) {
      if (!validate_category_name()) {
         return false;
      }
   });

   /*--------------------------------------------------------------- Back Button JS on ADD PAGES ----------------------------------------------------------------------------*/
   function back_button_in_dashboard_category_add_page(url, e) {
      $.ajax({
         type: 'GET',
         url: BASE_URL + url,
         success: function(data) {
            $(".container").empty();
            $('.container').html(data);
            var new_url = window.location.href.replace('?tab=add_dashboard_category', '?tab=dashboard_category');
            history.pushState(null, null, new_url);
         },
         error: function(e) {
            console.log(e);
         }
      });
   }

   // redirection ajax for back button the add category title
   $(document).off('click', '.add_dashboard_category_back_button').on('click', '.add_dashboard_category_back_button', function(e) {
      e.preventDefault();
      back_button_in_dashboard_category_add_page('/admin/homepage/dashboard_category/dashboard_category.php', e);
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