<?php
require dirname(__DIR__, 2) . "/common/config/config.php";
?>

<div class="roles_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="roles_heading">
         <h2>Roles</h2>
      </div>

      <div class="roles_title">
         <a href="#"><i class="fa-solid fa-arrow-left-long roles_back_button"></i></a>
         <a href="#"><i class="fa-solid fa-plus roles_plus_icon"></i></a>
      </div>

      <div class="roles_table">
         <table class="roles_table" id="roles_table">
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
               $query = "SELECT * FROM roles";
               $result = mysqli_query($database_connection, $query);

               while ($role_data = mysqli_fetch_assoc($result)) {
               ?>
                  <tr scope="col">
                     <td>
                        <?php echo $role_data['id']; ?>
                     </td>
                     <td>
                        <?php echo $role_data['name']; ?>
                     </td>
                     <td>
                        <?php echo date('d-m-Y', strtotime($role_data['created_at'])); ?>
                     </td>
                     <td>
                        <?php echo date('d-m-Y', strtotime($role_data['updated_at'])); ?>
                     </td>
                     <td>
                        <div class="roles_action">
                           <input type="hidden" name="roles_id" class="roles_id" id="roles_id" value="<?php echo $role_data['id']; ?>">
                           <div class="roles_edit">
                              <i class="fa-regular fa-pen-to-square"></i>
                           </div>
                           <div class="roles_delete">
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
   /*--------------------------------------------------------------- Adding datatables ----------------------------------------------------------------------------*/
   // for creating the tables using datatables
   $(document).ready(function() {
      $('#roles_table').DataTable();
   });

   /*--------------------------------------------------------------- Back Button JS on dashboard ----------------------------------------------------------------------------*/
   function roles_back_button(url) {
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

   // redirection ajax for back button the role title
   $(document).off('click', '.roles_back_button').on('click', '.roles_back_button', function(e) {
      e.preventDefault();
      roles_back_button('/admin/homepage/dashboard/dashboard.php', e);
   });

   /*--------------------------------------------------------------- Click on plus (+) JS ----------------------------------------------------------------------------*/
   function roles_plus_icon(url) {
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

   // redirection ajax for adding the role title
   $(document).off('click', '.roles_plus_icon').on('click', '.roles_plus_icon', function(e) {
      e.preventDefault();
      roles_plus_icon('/admin/roles/add_roles/add_roles.php');
   });

   /*--------------------------------------------------------------- Delete Button JS on ADD PAGES ----------------------------------------------------------------------------*/
   function role_delete_button(url, roles_id) {
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
               url: BASE_URL + url + '?roles_id=' + roles_id,
               success: function(response) {
                  if (parsed_response) {
                     parsed_response = null;
                  } else {
                     parsed_response = JSON.parse(response);
                     if (parsed_response.error) {
                        var alert_message = '<div class="alert alert-danger role_delete_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                        $('#alert_container').append(alert_message);
                        setTimeout(function() {
                           $('.alert').remove();
                        }, 3000);
                     } else {
                        $.ajax({
                           url: BASE_URL + '/admin/roles/roles.php',
                           type: 'GET',
                           success: function(data) {
                              $(".container").empty();
                              $('.container').html(data);
                              var alert_message = '<div class="alert alert-success role_delete_alert_dismissible" role="alert">' + parsed_response.success + '</div>';
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

   // redirection ajax for delete button the role title
   $(document).on('click', '.roles_delete', function(e) {
      e.preventDefault();
      var roles_id = $(this).siblings('.roles_id').val();
      role_delete_button('/admin/roles/delete_roles/delete_roles.php', roles_id);
   });
</script>