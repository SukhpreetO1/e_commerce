<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
?>

<div class="edit_category_types_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="category_types_heading">
         <h2>Edit Category Types</h2>
      </div>

      <div class="edit_category_types">
         <a href="#"><i class="fa-solid fa-arrow-left-long edit_category_types_back_button"></i></a>
      </div>

      <?php
      $id = $_GET['category_type_id'];

      $sql = "SELECT * FROM categories_type WHERE id = $id";
      $result = $database_connection->query($sql);

      if ($result->num_rows > 0) {
         while ($categories_type_data = $result->fetch_assoc()) {
            $selected_category_heading_id = $categories_type_data["category_heading_id"];
            $categories_sql = "SELECT * FROM categories_heading WHERE id = $selected_category_heading_id";
            $selected_categories_id = $database_connection->query($categories_sql);

            if ($selected_categories_id->num_rows > 0) {
               while ($categories_heading_data = $selected_categories_id->fetch_assoc()) {
                  $selected_category_id = $categories_heading_data["categories_id"];
               }
            }
      ?>

            <div class="edit_category_name">
               <div class="edit_section">
                  <form method="post" id="edit_category_types_form" class="edit_category_types_form">
                     <div class="form-group category_title_dropdown">
                        <label for="edit_category_title_input_title" class="edit_category_title_field mt-2 mb-2">Category Title Name <span class="important_mark">*</span></label>
                        <select class="form-select edit_category_title_input_title" id="edit_category_title_input_title" aria-label="Select Category Title Name" name="edit_category_title_input_title">
                           <option hidden disabled selected>Select Category Title Name</option>
                           <?php
                           $sql = "SELECT * FROM categories";
                           $result = $database_connection->query($sql);
                           if ($result->num_rows > 0) {
                              while ($categories_data = $result->fetch_assoc()) {
                                 $selected = ($categories_data['id'] == $selected_category_id) ? "selected" : "";
                           ?>
                                 <option value="<?php echo $categories_data['id']; ?>" <?php echo $selected; ?>><?php echo $categories_data['name']; ?></option>
                           <?php
                              }
                           }
                           ?>
                        </select>
                        <span class="invalid-feedback edit_category_title_input_title_err" id="edit_category_title_input_title_err"><?php echo $edit_category_title_input_title_err; ?></span>
                     </div>
                     <div class="form-group category_header_dropdown">
                        <label for="edit_category_header_input_title" class="edit_category_header_title mt-2 mb-2">Category Header Name <span class="important_mark">*</span></label>
                        <input type="hidden" name="category_id" id="category_id" class="category_id" value="<?php echo $selected_category_id ?>">
                        <input type="hidden" name="category_header_id" id="category_header_id" class="category_header_id" value="<?php echo $selected_category_heading_id ?>">
                        <input type="hidden" name="category_type_id" id="category_type_id" class="category_type_id" value="<?php echo $categories_type_data['id'] ?>">
                        <select class="form-select edit_category_header_input_title" id="edit_category_header_input_title" aria-label="Select Category Title Name" name="edit_category_header_input_title" value="">
                           <option hidden disabled selected>Select Category Header Name</option>
                           <option value="0" disabled readonly>Select first category title.</option>
                        </select>
                        <span class="invalid-feedback edit_category_header_input_title_err" id="edit_category_header_input_title_err"><?php echo $edit_category_header_input_title_err; ?></span>
                     </div>
                     <div class="form-group">
                        <label for="edit_category_types_input_name" class="edit_category_types_name mt-2 mb-2">Category Type Name <span class="important_mark">*</span></label>
                        <input type="text" name="edit_category_types_input_name" class="form-control edit_category_types_input_name" id="edit_category_types_input_name" value="<?php echo $categories_type_data['name'] ?>">
                        <span class="invalid-feedback edit_category_types_input_name_err" id="edit_category_types_input_name_err"><?php echo $edit_category_types_input_name_err ?></php></span>
                     </div>
                     <div class="edit_category_types_name_button">
                        <button type="submit" name="create_category" class="btn btn-primary mt-2 create_category" id="create_category" value="Create Category Type">Update Category Type</button>
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
   /*--------------------------------------------------------------- getting categories id ----------------------------------------------------------------------------*/
   $(document).ready(function() {
      function load_category_headers(category_id, selected_category_header_id) {
         $.ajax({
            url: BASE_URL + '/admin/category_types/get_category_headers.php',
            method: 'POST',
            data: {
               category_id: category_id
            },
            dataType: 'json',
            success: function(response) {
               var options = '<option hidden disabled selected>Select Category Header Name</option>';
               if (response.length > 0) {
                  $.each(response, function(index, categoryHeader) {
                     var selected = (categoryHeader.id == selected_category_header_id) ? 'selected' : '';
                     options += '<option value="' + categoryHeader.id + '" ' + selected + '>' + categoryHeader.name + '</option>';
                  });
               } else {
                  options += '<option value="0" disabled readonly>No category heading in this category title</option>';
               }
               $('.edit_category_header_input_title').html(options);
            }
         });
      }

      // Initial load when the document is ready
      var category_id = $('#category_id').val();
      var category_header_id = $('#category_header_id').val();
      load_category_headers(category_id, category_header_id);

      // Change event handling
      $('.edit_category_title_input_title').change(function() {
         var category_id = $(this).val();
         load_category_headers(category_id, 0);
      });
   });

   /*--------------------------------------------------------------- Back Button JS on edit PAGES ----------------------------------------------------------------------------*/
   function back_button_in_category_types_edit_page(url, e) {
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

   // redirection ajax for back button the edit category types
   $(document).off('click', '.edit_category_types_back_button').on('click', '.edit_category_types_back_button', function(e) {
      e.preventDefault();
      back_button_in_category_types_edit_page('/admin/category_types/category_types.php', e);
   });

   /*--------------------------------------------------------------- Validation for submit button and input in edit files ----------------------------------------------------------------------------*/
   function validate_category_title() {
      var selected_value = $('.edit_category_title_input_title').val();
      var error_messages = '';
      if (selected_value === '' || selected_value === null) {
         error_messages = 'Category title is required.';
      }
      $('.edit_category_title_input_title_err').text(error_messages);
      return error_messages === '';
   }

   function validate_category_header() {
      var selected_value = $('.edit_category_header_input_title').val();
      var error_messages = '';
      if (selected_value === '' || selected_value === null) {
         error_messages = 'Category Header is required.';
      }
      $('.edit_category_header_input_title_err').text(error_messages);
      return error_messages === '';
   }

   function validate_category_name() {
      var category_name = $('#edit_category_types_input_name').val();
      var error_messages = '';
      if (category_name.trim() === '') {
         error_messages = 'Category name is required.';
      } else if (category_name.length < 3 || category_name.length > 15) {
         error_messages = 'Category name must be between 3 and 15 characters long.';
      } else if (!/^[a-zA-Z\s]+$/.test(category_name)) {
         error_messages = 'Only alphabets are allowed.';
      }
      $('.edit_category_types_input_name_err').text(error_messages);
      return error_messages === '';
   }

   // when submit the new category types file
   $(document).off('submit', '#edit_category_types_form').on('submit', '#edit_category_types_form', function(e) {
      e.preventDefault();
      var is_title_valid = validate_category_title();
      var is_header_valid = validate_category_header();
      var is_name_valid = validate_category_name();
      if (!is_title_valid || !is_header_valid || !is_name_valid) {
         return false;
      } else {
         var formData = $(this).serialize();
         var parsed_response = null;
         $.ajax({
            type: "POST",
            url: BASE_URL + "/admin/category_types/edit_category_types/edit_category_types_php.php",
            data: formData,
            success: function(response) {
               if (response.trim() === "") {
                  var alert_message = '<div class="alert alert-danger category_types_alert_dismissible" role="alert">Category Type name not saved.</div>';
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
   $(document).on('click', '#edit_category_types_form', function(e) {
      var is_title_valid = validate_category_title();
      var is_header_valid = validate_category_header();
      var is_name_valid = validate_category_name();
      if (!is_title_valid || !is_header_valid || !is_name_valid) {
         return false;
      }
   });

   // when input the new category types field
   $(document).on('input', '#edit_category_types_form', function(e) {
      var is_title_valid = validate_category_title();
      var is_header_valid = validate_category_header();
      var is_name_valid = validate_category_name();
      if (!is_title_valid || !is_header_valid || !is_name_valid) {
         return false;
      }
   });
</script>