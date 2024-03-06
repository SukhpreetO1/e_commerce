<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
// include dirname(__DIR__, 2) . "/category_types/add_category_types/add_category_types_php.php";
?>
<div class="add_category_types_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="category_types_heading">
         <h2>Add Category Types</h2>
      </div>

      <div class="add_category_types">
         <a href="#"><i class="fa-solid fa-arrow-left-long add_category_types_back_button"></i></a>
      </div>

      <div class="add_category_name">
         <div class="add_section">
            <form method="post" id="add_category_types_form" class="add_category_types_form">
               <div class="form-group category_title_dropdown">
                  <label for="add_category_title_input_title" class="add_category_title_field mt-2 mb-2">Category Title Name <span class="important_mark">*</span></label>
                  <select class="form-select add_category_title_input_title" id="add_category_title_input_title" aria-label="Select Category Title Name" name="add_category_title_input_title">
                     <option hidden disabled selected>Select Category Title Name</option>
                     <?php
                     $sql = "SELECT * FROM categories";
                     $result = $database_connection->query($sql);
                     if ($result->num_rows > 0) {
                        while ($categories_data = $result->fetch_assoc()) {
                     ?>
                           <option value="<?php echo $categories_data['id']; ?>"><?php echo $categories_data['name']; ?></option>
                     <?php
                        }
                     }
                     ?>
                  </select>
                  <span class="invalid-feedback edit_category_title_name_err" id="edit_category_title_name_err"><?php echo $edit_category_title_name_err; ?></span>
               </div>
               <div class="form-group category_header_dropdown">
                  <label for="add_category_header_input_title" class="add_category_header_title mt-2 mb-2">Category Header Name <span class="important_mark">*</span></label>
                  <input type="hidden" name="categories_id" class="categories_id" id="categories_id" value="">
                  <select class="form-select add_category_header_input_title" id="add_category_header_input_title" aria-label="Select Category Title Name" name="add_category_header_input_title" value="">
                     <option hidden disabled selected>Select Category Header Name</option>
                     <?php
                     $selected_category_id = isset($_POST['selected_categories_id']) ? $_POST['selected_categories_id'] : 0;
                     var_dump($_POST);
                     $sql = "SELECT * FROM categories_heading WHERE categories_id = ";
                     $result = $database_connection->query($sql);
                     if ($result->num_rows > 0) {
                        while ($categories_heading_row = $result->fetch_assoc()) {
                     ?>
                           <option value="<?php echo $categories_heading_row['id']; ?>"><?php echo $categories_heading_row['name']; ?></option>
                        <?php
                        }
                     } else {
                        ?>
                        <option value="0">No Category Header</option>
                     <?php
                     }
                     $database_connection->close();
                     ?>
                  </select>
                  <span class="invalid-feedback add_category_header_title_err" id="add_category_header_title_err"><?php echo $add_category_header_title_err; ?></span>
               </div>
               <div class="form-group">
                  <label for="add_category_types_input_name" class="add_category_types_name mt-2 mb-2">Category Type Name <span class="important_mark">*</span></label>
                  <input type="text" name="add_category_types_input_name" class="form-control add_category_types_input_name" id="add_category_types_input_name">
                  <span class="invalid-feedback add_category_types_name_err" id="add_category_types_name_err"><?php echo $add_category_types_name_err ?></php></span>
               </div>
               <div class="add_category_types_name_button">
                  <button type="submit" name="create_category" class="btn btn-primary mt-2 create_category" id="create_category" value="Create Category Type">Create Category Type</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<script>
   /*--------------------------------------------------------------- Validation for submit button and input in add files ----------------------------------------------------------------------------*/
   function validate_category_header() {
      var selected_value = $('.add_category_header_input_title').val();
      var error_messages = '';
      if (selected_value === '' || selected_value === null) {
         error_messages = 'Category Header is required.';
      }
      $('.add_category_header_title_err').text(error_messages);
      return error_messages === '';
   }

   function validate_category_title() {
      var selected_value = $('.add_category_title_input_title').val();
      var error_messages = '';
      if (selected_value === '' || selected_value === null) {
         error_messages = 'Category title is required.';
      }
      $('.edit_category_title_name_err').text(error_messages);
      return error_messages === '';
   }

   function validate_category_name() {
      var category_name = $('#add_category_types_input_name').val();
      var error_messages = '';
      if (category_name.trim() === '') {
         error_messages = 'Category name is required.';
      } else if (category_name.length < 3 || category_name.length > 15) {
         error_messages = 'Category name must be between 3 and 15 characters long.';
      } else if (!/^[a-zA-Z\s]+$/.test(category_name)) {
         error_messages = 'Only alphabets are allowed.';
      }
      $('.add_category_types_name_err').text(error_messages);
      return error_messages === '';
   }

   // when submit the new category types file
   $(document).off('submit', '#add_category_types_form').on('submit', '#add_category_types_form', function(e) {
      e.preventDefault();
      var isTitleValid = validate_category_title();
      var isHeaderValid = validate_category_header();
      var isNameValid = validate_category_name();
      if (!isTitleValid || !isHeaderValid || !isHeadisNameValiderValid) {
         return false;
      } else {
         var formData = $(this).serialize();
         var parsed_response = null;
         $.ajax({
            type: "POST",
            url: BASE_URL + "/admin/category_types/add_category_types/add_category_types_php.php",
            data: formData,
            success: function(response) {
               if (response.trim() === "") {
                  var alert_message = '<div class="alert alert-danger category_types_alert_dismissible" role="alert">Category Type not saved.</div>';
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
                        var alert_message = '<div class="alert alert-danger category_types_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                        $('#alert_container').append(alert_message);
                        setTimeout(function() {
                           $('.alert').remove();
                        }, 3000);
                     } else {
                        $.ajax({
                           url: BASE_URL + '/admin/category_types/category_types.php',
                           type: 'GET',
                           success: function(data) {
                              $(".container").empty();
                              $('.container').html(data);
                              var alert_message = '<div class="alert alert-success category_types_success_dismissible" role="alert">' + parsed_response.success + '</div>';
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

   // when click on the new category types input field
   $(document).on('click', '#add_category_types_form', function(e) {
      e.preventDefault();
      var isTitleValid = validate_category_title();
      var isHeaderValid = validate_category_header();
      var isNameValid = validate_category_name();
      if (!isTitleValid || !isHeaderValid || !isHeadisNameValiderValid) {
         return false;
      }
   });

   // when input the new category types field
   $(document).on('input', '#add_category_types_form', function(e) {
      e.preventDefault();
      var isTitleValid = validate_category_title();
      var isHeaderValid = validate_category_header();
      var isNameValid = validate_category_name();
      if (!isTitleValid || !isHeaderValid || !isHeadisNameValiderValid) {
         return false;
      }
   });

   /*--------------------------------------------------------------- Back Button JS on ADD PAGES ----------------------------------------------------------------------------*/
   function back_button_in_category_types_add_page(url, e) {
      $.ajax({
         type: 'GET',
         url: BASE_URL + url,
         success: function(data) {
            $(".container").empty();
            $('.container').html(data);
            var new_url = window.location.href.replace('?tab=add_categories_types', '?tab=categories_types');
            history.pushState(null, null, new_url);
         },
         error: function(e) {
            console.log(e);
         }
      });
   }

   // redirection ajax for back button the add category types
   $(document).off('click', '.add_category_types_back_button').on('click', '.add_category_types_back_button', function(e) {
      e.preventDefault();
      back_button_in_category_types_add_page('/admin/category_types/category_types.php', e);
   });

   /*--------------------------------------------------------------- getting categories id ----------------------------------------------------------------------------*/
   $(document).ready(function() {
      $('.add_category_title_input_title').change(function() {
         var selected_categories_id = $(this).val();
         $.ajax({
            type: 'post',
            data: {
               selected_categories_id: selected_categories_id,
            },
            success: function(response) {
               $('#categories_id').val(selected_categories_id);
            }
         });
      });
   });
</script>