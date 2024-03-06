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
                  <span class="invalid-feedback add_category_title_input_title_err" id="add_category_title_input_title_err"><?php echo $add_category_title_input_title_err; ?></span>
               </div>
               <div class="form-group category_header_dropdown">
                  <label for="add_category_header_input_title" class="add_category_header_title mt-2 mb-2">Category Header Name <span class="important_mark">*</span></label>
                  <select class="form-select add_category_header_input_title" id="add_category_header_input_title" aria-label="Select Category Title Name" name="add_category_header_input_title" value="">
                     <option hidden disabled selected>Select Category Header Name</option>
                     <option value="0" disabled readonly>Select first category title.</option>
                  </select>
                  <span class="invalid-feedback add_category_header_input_title_err" id="add_category_header_input_title_err"><?php echo $add_category_header_input_title_err; ?></span>
               </div>
               <div class="form-group">
                  <label for="add_category_types_input_name" class="add_category_types_name mt-2 mb-2">Category Type Name <span class="important_mark">*</span></label>
                  <input type="text" name="add_category_types_input_name" class="form-control add_category_types_input_name" id="add_category_types_input_name">
                  <span class="invalid-feedback add_category_types_input_name_err" id="add_category_types_input_name_err"><?php echo $add_category_types_input_name_err ?></php></span>
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
   /*--------------------------------------------------------------- getting categories id ----------------------------------------------------------------------------*/
   $(document).ready(function() {
      $('.add_category_title_input_title').change(function() {
         var category_id = $(this).val();
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
                     options += '<option value="' + categoryHeader.id + '">' + categoryHeader.name + '</option>';
                  });
               } else {
                  options += '<option value="0" disabled readonly>No category heading in this category title</option>';
               }
               $('.add_category_header_input_title').html(options);
            }
         });
      });
   });

   /*--------------------------------------------------------------- Validation for submit button and input in add files ----------------------------------------------------------------------------*/
   function validate_category_title() {
      var selected_value = $('.add_category_title_input_title').val();
      var error_messages = '';
      if (selected_value === '' || selected_value === null) {
         error_messages = 'Category title is required.';
      }
      $('.add_category_title_input_title_err').text(error_messages);
      return error_messages === '';
   }
   
   function validate_category_header() {
      var selected_value = $('.add_category_header_input_title').val();
      var error_messages = '';
      if (selected_value === '' || selected_value === null) {
         error_messages = 'Category Header is required.';
      }
      $('.add_category_header_input_title_err').text(error_messages);
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
      $('.add_category_types_input_name_err').text(error_messages);
      return error_messages === '';
   }

   // when submit the new category types file
   $(document).off('submit', '#add_category_types_form').on('submit', '#add_category_types_form', function(e) {
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
            url: BASE_URL + "/admin/category_types/add_category_types/add_category_types_php.php",
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
                              var new_url = window.location.href.replace('?tab=add_categories_types', '?tab=categories_types');
                              history.pushState(null, null, new_url);
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
      var is_title_valid = validate_category_title();
      var is_header_valid = validate_category_header();
      var is_name_valid = validate_category_name();
      if (!is_title_valid || !is_header_valid || !is_name_valid) {
         return false;
      }
   });

   // when input the new category types field
   $(document).on('input', '#add_category_types_form', function(e) {
      var is_title_valid = validate_category_title();
      var is_header_valid = validate_category_header();
      var is_name_valid = validate_category_name();
      if (!is_title_valid || !is_header_valid || !is_name_valid) {
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
</script>