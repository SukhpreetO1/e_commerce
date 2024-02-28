<?php
require dirname(__DIR__, 2) . "/common/config/config.php";
?>

<div class="color_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="color_heading">
         <h2>Color</h2>
      </div>

      <div class="add_color">
         <a href="#"><i class="fa-solid fa-arrow-left-long color_back_button"></i></a>
         <a href="#"><i class="fa-solid fa-plus color_plus_icon"></i></a>
      </div>

      <div class="color_table">
         <table class="color_table" id="color_table">
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
               $query = "SELECT * from color";
               $result = mysqli_query($database_connection, $query);

               while ($color_data = mysqli_fetch_assoc($result)) {
               ?>
                  <tr scope="col">
                     <td>
                        <?php echo $color_data['id']; ?>
                     </td>
                     <td>
                        <?php echo $color_data['name']; ?>
                     </td>
                     <td>
                        <?php echo date('d-m-Y', strtotime($color_data['created_at'])); ?>
                     </td>
                     <td>
                        <?php echo date('d-m-Y', strtotime($color_data['updated_at'])); ?>
                     </td>
                     <td style="width: 6rem;">
                        <div class="color_action">
                           <input type="hidden" name="color_id" class="color_id" id="color_id" value="<?php echo $color_data['id']; ?>">
                           <div class="color_edit">
                              <i class="fa-regular fa-pen-to-square"></i>
                           </div>
                           <div class="color_delete">
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

<div class="modal fade color_modal" id="color_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Color </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
         </div>
      </div>
   </div>
</div>

<script>
   /*--------------------------------------------------------------- Back Button JS on dashboard ----------------------------------------------------------------------------*/
   function color_back_button(url) {
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
   $(document).off('click', '.color_back_button').on('click', '.color_back_button', function(e) {
      e.preventDefault();
      color_back_button('/admin/homepage/dashboard/dashboard.php', e);
   });

   /*--------------------------------------------------------------- Adding datatables ----------------------------------------------------------------------------*/
   // for creating the tables using datatables
   $(document).ready(function() {
      $('#color_table').DataTable();
   });

   /*--------------------------------------------------------------- Delete Button JS on ADD PAGES ----------------------------------------------------------------------------*/
   function color_delete_button(url, color_id) {
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
               url: BASE_URL + url + '?color_id=' + color_id,
               success: function(response) {
                  if (parsed_response) {
                     parsed_response = null;
                  } else {
                     parsed_response = JSON.parse(response);
                     if (parsed_response.error) {
                        var alert_message = '<div class="alert alert-danger color_delete_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                        $('#alert_container').append(alert_message);
                        setTimeout(function() {
                           $('.alert').remove();
                        }, 3000);
                     } else {
                        $.ajax({
                           url: BASE_URL + '/admin/color/color.php',
                           type: 'GET',
                           success: function(data) {
                              $(".container").empty();
                              $('.container').html(data);
                              var alert_message = '<div class="alert alert-success color_delete_alert_dismissible" role="alert">' + parsed_response.success + '</div>';
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
   $(document).on('click', '.color_delete', function(e) {
      e.preventDefault();
      var color_id = $(this).siblings('.color_id').val();
      color_delete_button('/admin/color/delete_color/delete_color.php', color_id);
   });

   /*--------------------------------------------------------------- Click on Edit Button JS ----------------------------------------------------------------------------*/
   function color_edit_icon(url, color_id) {
      $.ajax({
         type: 'GET',
         url: BASE_URL + url + '?color_id=' + color_id,
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
   $(document).off('click', '.color_edit').on('click', '.color_edit', function(e) {
      e.preventDefault();
      var color_id = $(this).siblings('.color_id').val();
      color_edit_icon('/admin/color/edit_color/edit_color.php', color_id);
   });

   /*--------------------------------------------------------------- Showing modal when click on info icon ----------------------------------------------------------------------------*/
   $(document).off('click', '.color_plus_icon').on('click', '.color_plus_icon', function(e) {
      $.ajax({
         url: BASE_URL + "/admin/color/add_color/add_color.php",
         method: 'GET',
         success: function(response) {
            $('.modal-body').html(response);
            $('#color_modal').modal('show');
         },
         error: function() {
            console.log(e);
         }
      });
   });
</script>