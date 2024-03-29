<?php
require dirname(__DIR__, 2) . "/common/config/config.php";
?>

<div class="size_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="size_heading">
         <h2>Size</h2>
      </div>

      <div class="error_messages" style="display: none;">
         <div class="alert alert-danger uploading_file_err" role="alert" id="uploading_file_err">
            <?php echo $uploading_file_err ?>
         </div>
      </div>

      <div class="add_size">
         <a href="#"><i class="fa-solid fa-arrow-left-long size_back_button"></i></a>
         <div>
            <a href="#"><i class="fa-solid fa-plus size_plus_icon"></i></a>
            <a href="#" id="size_import_file_link"><i class="fa-solid fa-file-arrow-down size_file_import"></i></a>
         </div>
      </div>

      <div class="size_table">
         <table class="size_table" id="size_table">
            <thead>
               <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Created At</th>
                  <th scope="col">Updated At</th>
                  <th scope="col">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php
               $query = "SELECT * from size";
               $result = mysqli_query($database_connection, $query);

               while ($size_data = mysqli_fetch_assoc($result)) {
               ?>
                  <tr scope="col">
                     <td>
                        <?php echo $size_data['id']; ?>
                     </td>
                     <td>
                        <?php echo $size_data['name']; ?>
                     </td>
                     <td>
                        <?php echo date('d-m-Y', strtotime($size_data['created_at'])); ?>
                     </td>
                     <td>
                        <?php echo date('d-m-Y', strtotime($size_data['updated_at'])); ?>
                     </td>
                     <td style="width: 6rem;">
                        <div class="size_action">
                           <input type="hidden" name="size_id" class="size_id" id="size_id" value="<?php echo $size_data['id']; ?>">
                           <div class="size_edit">
                              <i class="fa-regular fa-pen-to-square"></i>
                           </div>
                           <div class="size_delete">
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
   function size_plus_icon(url) {
      $.ajax({
         type: 'GET',
         url: BASE_URL + url,
         success: function(data) {
            $(".container").empty();
            $('.container').html(data);
            var new_url = window.location.href.replace('?tab=size', '?tab=add_size');
            history.pushState(null, null, new_url);
         },
         error: function(e) {
            console.log(e);
         }
      });
   }

   // redirection ajax for adding the category title
   $(document).off('click', '.size_plus_icon').on('click', '.size_plus_icon', function(e) {
      e.preventDefault();
      size_plus_icon('/admin/size/add_size/add_size.php');
   });

   /*--------------------------------------------------------------- Back Button JS on dashboard ----------------------------------------------------------------------------*/
   function size_back_button(url) {
      $('.size').removeClass('highlighted');
      $('.dashboard').addClass('highlighted');
      $.ajax({
         type: 'GET',
         url: BASE_URL + url,
         success: function(data) {
            $(".container").empty();
            var container = $('.container');
            if (!$(data).find('.homepage_sidebar').length) {
               container.html(data);
               var new_url = window.location.href.replace('?tab=size', '?tab=dashboard');
               history.pushState(null, null, new_url);
            }
         },
         error: function(e) {
            console.log(e);
         }
      });
   }

   // redirection ajax for back button the category title
   $(document).off('click', '.size_back_button').on('click', '.size_back_button', function(e) {
      e.preventDefault();
      size_back_button('/admin/homepage/dashboard/dashboard.php', e);
   });

   /*--------------------------------------------------------------- Adding datatables ----------------------------------------------------------------------------*/
   // for creating the tables using datatables
   $(document).ready(function() {
      $('#size_table').DataTable();
   });

   /*--------------------------------------------------------------- Delete Button JS on ADD PAGES ----------------------------------------------------------------------------*/
   function size_delete_button(url, size_id) {
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
               url: BASE_URL + url + '?size_id=' + size_id,
               success: function(response) {
                  if (parsed_response) {
                     parsed_response = null;
                  } else {
                     parsed_response = JSON.parse(response);
                     if (parsed_response.error) {
                        var alert_message = '<div class="alert alert-danger size_delete_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                        $('#alert_container').append(alert_message);
                        setTimeout(function() {
                           $('.alert').remove();
                        }, 3000);
                     } else {
                        $.ajax({
                           url: BASE_URL + '/admin/size/size.php',
                           type: 'GET',
                           success: function(data) {
                              $(".container").empty();
                              $('.container').html(data);
                              var alert_message = '<div class="alert alert-success size_delete_alert_dismissible" role="alert">' + parsed_response.success + '</div>';
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
   $(document).on('click', '.size_delete', function(e) {
      e.preventDefault();
      var size_id = $(this).siblings('.size_id').val();
      size_delete_button('/admin/size/delete_size/delete_size.php', size_id);
   });

   /*--------------------------------------------------------------- Click on Edit Button JS ----------------------------------------------------------------------------*/
   function size_edit_icon(url, size_id) {
      $.ajax({
         type: 'GET',
         url: BASE_URL + url + '?size_id=' + size_id,
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
   $(document).off('click', '.size_edit').on('click', '.size_edit', function(e) {
      e.preventDefault();
      var size_id = $(this).siblings('.size_id').val();
      size_edit_icon('/admin/size/edit_size/edit_size.php', size_id);
   });

   /*--------------------------------------------------------------- Import Button ----------------------------------------------------------------------------*/
   $(document).ready(function() {
      $('#size_import_file_link').click(function() {
         var fileInput = $('<input type="file">');
         fileInput.on('change', function() {
            var file = this.files[0];
            if (file.name.toLowerCase().endsWith('.csv') || file.name.toLowerCase().endsWith('.xlsx')) {
               var formData = new FormData();
               formData.append('file', file);
               // formData.append('file_name', file.name);
               var parsed_response = null;
               $.ajax({
                  type: 'POST',
                  url: BASE_URL + '/admin/size/size_import/size_import.php',
                  data: formData,
                  contentType: false,
                  processData: false,
                  success: function(response) {
                     if (response.trim() === "") {
                        var alert_message = '<div class="alert alert-danger size_imported_alert_dismissible" role="alert">File not uploaded.</div>';
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
                              var alert_message = '<div class="alert alert-danger size_imported_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                              $('#alert_container').append(alert_message);
                              setTimeout(function() {
                                 $('.alert').remove();
                              }, 3000);
                           } else {
                              $.ajax({
                                 url: BASE_URL + '/admin/size/size.php',
                                 type: 'GET',
                                 success: function(data) {
                                    $(".container").empty();
                                    $('.container').html(data);
                                    var alert_message = '<div class="alert alert-success size_imported_success_dismissible" role="alert">' + parsed_response.success + '</div>';
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
                  error: function(e) {
                     console.log(e);
                  }
               });
            } else {
               $('.error_messages').css({
                  'display': 'block',
                  'width': '17rem',
                  'position': 'absolute',
                  'top': '-0.5rem',
                  'right': '-10rem'
               });
               $('.uploading_file_err').text('Please select a CSV or XLSX file');
               setTimeout(function() {
                  $('.error_messages').css('display', 'none');
               }, 3000);
            }
         });
         fileInput.click();
      });
   });
</script>