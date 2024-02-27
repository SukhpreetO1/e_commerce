<?php
require dirname(__DIR__, 2) . "/common/config/config.php";
?>

<div class="discount_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="discount_heading">
         <h2>Discount</h2>
      </div>

      <div class="error_messages" style="display: none;">
         <div class="alert alert-danger uploading_file_err" role="alert" id="uploading_file_err">
            <?php echo $uploading_file_err ?>
         </div>
      </div>

      <div class="add_discount">
         <a href="#"><i class="fa-solid fa-arrow-left-long discount_back_button"></i></a>
         <div>
            <a href="#"><i class="fa-solid fa-plus discount_plus_icon"></i></a>
            <a href="#" id="discount_import_file_link"><i class="fa-solid fa-file-arrow-down discount_file_import"></i></a>
         </div>
      </div>

      <div class="discount_table">
         <table class="discount_table" id="discount_table">
            <thead>
               <tr>
                  <th scope="col">#</th>
                  <th scope="col">Code Name</th>
                  <th scope="col">Discount Name</th>
                  <th scope="col">Active/ Inactive</th>
                  <th scope="col">Amount</th>
                  <th scope="col">Expiration Date</th>
                  <th scope="col">Created At</th>
                  <th scope="col">Updated At</th>
                  <th scope="col">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php
               $query = "SELECT * from discount";
               $result = mysqli_query($database_connection, $query);

               while ($discount_data = mysqli_fetch_assoc($result)) {
               ?>
                  <tr scope="col">
                     <td>
                        <?php echo $discount_data['id']; ?>
                     </td>
                     <td>
                        <?php echo $discount_data['code_name']; ?>
                     </td>
                     <td>
                        <?php echo $discount_data['discount_type']; ?>
                     </td>
                     <td>
                        <?php echo ($discount_data['activate'] == 0) ? 'Inactive' : 'Active'; ?>
                     </td>
                     <td>
                        <?php echo ($discount_data['rupees_or_percentage'] == 0) ? '₹ ' . $discount_data['amount'] : $discount_data['amount'] . ' %'; ?>
                     </td>
                     <td>
                        <?php
                        $original_date = $discount_data['expiration_date'];
                        $new_date = date('d-m-Y', strtotime($original_date));
                        echo $new_date;
                        ?>
                     </td>
                     <td>
                        <?php echo date('d-m-Y', strtotime($discount_data['created_at'])); ?>
                     </td>
                     <td>
                        <?php echo date('d-m-Y', strtotime($discount_data['updated_at'])); ?>
                     </td>
                     <td style="width: 6rem;">
                        <div class="discount_action">
                           <input type="hidden" name="discount_id" class="discount_id" id="discount_id" value="<?php echo $discount_data['id']; ?>">
                           <input type="hidden" name="active_id" class="active_id" id="active_id" value="<?php echo $discount_data['activate']; ?>">
                           <div class="discount_toogle_button">
                              <label class="switch">
                                 <input type="checkbox" <?php echo ($discount_data['activate'] == 1) ? 'checked' : ''; ?>>
                                 <span class="discount_toogle_button_active_change" id="discount_toogle_button_active_change" name='discount_toogle_button_active_change'></span>
                              </label>
                           </div>
                           <div class="discount_edit">
                              <i class="fa-regular fa-pen-to-square"></i>
                           </div>
                           <div class="discount_delete">
                              <i class="fa-regular fa-trash-can"></i>
                           </div>
                        </div>
                     </td>
                  </tr>
               <?php
               }
               ?>
            </tbody>
         </table>
      </div>
   </div>
</div>

<script>
   /*--------------------------------------------------------------- Click on plus (+) JS ----------------------------------------------------------------------------*/
   function discount_plus_icon(url) {
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

   // redirection ajax for adding the category title
   $(document).off('click', '.discount_plus_icon').on('click', '.discount_plus_icon', function(e) {
      e.preventDefault();
      discount_plus_icon('/admin/discount/add_discount/add_discount.php');
   });

   /*--------------------------------------------------------------- Back Button JS on dashboard ----------------------------------------------------------------------------*/
   function discount_back_button(url) {
      $.ajax({
         type: 'GET',
         url: BASE_URL + url,
         success: function(data) {
            $(".container").empty();
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

   // redirection ajax for back button the category title
   $(document).off('click', '.discount_back_button').on('click', '.discount_back_button', function(e) {
      e.preventDefault();
      discount_back_button('/admin/homepage/dashboard/dashboard.php', e);
   });

   /*--------------------------------------------------------------- Adding datatables ----------------------------------------------------------------------------*/
   // for creating the tables using datatables
   $(document).ready(function() {
      $('#discount_table').DataTable();
   });

   /*--------------------------------------------------------------- Delete Button JS on ADD PAGES ----------------------------------------------------------------------------*/
   function discount_delete_button(url, discount_id) {
      Swal.fire({
         title: 'Are you sure?',
         text: "You won't be able to revert this!",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
         if (result.isConfirmed) {
            var parsed_response = null;
            $.ajax({
               type: 'DELETE',
               url: BASE_URL + url + '?discount_id=' + discount_id,
               success: function(response) {
                  if (parsed_response) {
                     parsed_response = null;
                  } else {
                     parsed_response = JSON.parse(response);
                     if (parsed_response.error) {
                        var alert_message = '<div class="alert alert-danger discount_delete_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
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
                              var alert_message = '<div class="alert alert-success discount_delete_alert_dismissible" role="alert">' + parsed_response.success + '</div>';
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
               },
               error: function(xhr, status, error) {
                  console.log(error);
               }
            });
         }
      });
   }

   // redirection ajax for delete button the category title
   $(document).on('click', '.discount_delete', function(e) {
      e.preventDefault();
      var discount_id = $(this).siblings('.discount_id').val();
      discount_delete_button('/admin/discount/delete_discount/delete_discount.php', discount_id);
   });

   /* --------------------------------------------------------------- Toggle Button JS ----------------------------------------------------------------------------*/
   $(document).off('click', '.discount_toogle_button_active_change').on('click', '.discount_toogle_button_active_change', function() {
      var discount_id = $(this).parent().parent().parent().find('.discount_id').val();
      var active_id = $(this).parent().parent().parent().find('.active_id').val();
      $.ajax({
         url: BASE_URL + "/admin/discount/active_toogle_button_php.php",
         type: "POST",
         data: {
            discount_id: discount_id,
            active_id: active_id
         },
         success: function(response) {
            parsed_response = JSON.parse(response);
            if (parsed_response.error) {
               var alert_message = '<div class="alert alert-danger discount_update_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
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
                     var alert_message = '<div class="alert alert-success discount_update_success_dismissible" role="alert">' + parsed_response.success + '</div>';
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
      });
   });

   /*--------------------------------------------------------------- Click on Edit Button JS ----------------------------------------------------------------------------*/
   function discount_edit_icon(url, discount_id) {
      $.ajax({
         type: 'GET',
         url: BASE_URL + url + '?discount_id=' + discount_id,
         success: function(data) {
            $(".container").empty();
            $('.container').html(data);
         },
         error: function(e) {
            console.log(e);
         }
      });
   }

   // redirection ajax for adding the category title
   $(document).off('click', '.discount_edit').on('click', '.discount_edit', function(e) {
      e.preventDefault();
      var discount_id = $(this).siblings('.discount_id').val();
      discount_edit_icon('/admin/discount/edit_discount/edit_discount.php', discount_id);
   });

   /*--------------------------------------------------------------- Import Button ----------------------------------------------------------------------------*/
   function discount_import_button(url) {
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

   $(document).ready(function() {
      $('#discount_import_file_link').click(function() {
         $('<input type="file">').click().change(function() {
            if (this.files[0].name.toLowerCase().endsWith('.csv')) {
               discount_import_button('/admin/discount/discount_import/discount_import.php');
            } else {
               $('.error_messages').css({
                  'display': 'block',
                  'width': '14rem',
                  'position': 'absolute',
                  'top': '-0.5rem',
                  'right': '0.75rem'
               });
               $('.uploading_file_err').text('Please select a CSV file');
               setTimeout(function() {
                  $('.error_messages').css('display', 'none');
               }, 3000);
            }
         });
      });
   });
</script>