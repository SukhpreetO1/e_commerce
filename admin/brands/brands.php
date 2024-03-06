<?php
require dirname(__DIR__, 2) . "/common/config/config.php";
?>

<div class="brands_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="brands_heading">
         <h2>Brands Name</h2>
      </div>

      <div class="add_brands">
         <a href="#"><i class="fa-solid fa-arrow-left-long brands_back_button"></i></a>
         <a href="#"><i class="fa-solid fa-plus brands_plus_icon"></i></a>
      </div>

      <div class="brands_table">
         <table class="brands_table" id="brands_table">
            <thead>
               <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Active/ Inactive</th>
                  <th scope="col">Created At</th>
                  <th scope="col">Updated At</th>
                  <th scope="col">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php
               $query = "SELECT * from brands";
               $result = mysqli_query($database_connection, $query);

               while ($brands_data = mysqli_fetch_assoc($result)) {
               ?>
                  <tr scope="col">
                     <td>
                        <?php echo $brands_data['id']; ?>
                     </td>
                     <td>
                        <?php echo $brands_data['name']; ?>
                     </td>
                     <td>
                        <?php echo ($brands_data['active'] == 0) ? 'Inactive' : 'Active'; ?>
                     </td>
                     <td>
                        <?php echo date('d-m-Y', strtotime($brands_data['created_at'])); ?>
                     </td>
                     <td>
                        <?php echo date('d-m-Y', strtotime($brands_data['updated_at'])); ?>
                     </td>
                     <td style="width: 6rem;">
                        <div class="brands_action">
                           <input type="hidden" name="brands_id" class="brands_id" id="brands_id" value="<?php echo $brands_data['id']; ?>">
                           <input type="hidden" name="active_id" class="active_id" id="active_id" value="<?php echo $brands_data['active']; ?>">
                           <div class="brands_edit">
                              <i class="fa-regular fa-pen-to-square"></i>
                           </div>
                           <div class="brands_delete">
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
      $('#brands_table').DataTable();
   });

   /*--------------------------------------------------------------- Back Button JS on dashboard ----------------------------------------------------------------------------*/
   function brands_back_button(url) {
      $('.brands').removeClass('highlighted');
      $('.dashboard').addClass('highlighted');

      $.ajax({
         type: 'GET',
         url: BASE_URL + url,
         success: function(data) {
            $(".container").empty();
            var container = $('.container');
            if (!$(data).find('.homepage_sidebar').length) {
               container.html(data);
               var new_url = window.location.href.replace('?tab=brands', '?tab=dashboard');
               history.pushState(null, null, new_url);
            }
         },
         error: function(e) {
            console.log(e);
         }
      });
   }

   // redirection ajax for back button the category title
   $(document).off('click', '.brands_back_button').on('click', '.brands_back_button', function(e) {
      e.preventDefault();
      brands_back_button('/admin/homepage/dashboard/dashboard.php', e);
   });

   /*--------------------------------------------------------------- Click on plus (+) JS ----------------------------------------------------------------------------*/
   function brands_plus_icon(url) {
      $.ajax({
         type: 'GET',
         url: BASE_URL + url,
         success: function(data) {
            $(".container").empty();
            $('.container').html(data);
            var new_url = window.location.href.replace('?tab=brands', '?tab=add_brands');
            history.pushState(null, null, new_url);
         },
         error: function(e) {
            console.log(e);
         }
      });
   }

   // redirection ajax for adding the category title
   $(document).off('click', '.brands_plus_icon').on('click', '.brands_plus_icon', function(e) {
      e.preventDefault();
      brands_plus_icon('/admin/brands/add_brands/add_brands.php');
   });

   /*--------------------------------------------------------------- Delete Button JS on ADD PAGES ----------------------------------------------------------------------------*/
   function brands_delete_button(url, brands_id) {
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
               url: BASE_URL + url + '?brands_id=' + brands_id,
               success: function(response) {
                  if (parsed_response) {
                     parsed_response = null;
                  } else {
                     parsed_response = JSON.parse(response);
                     if (parsed_response.error) {
                        var alert_message = '<div class="alert alert-danger brands_delete_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                        $('#alert_container').append(alert_message);
                        setTimeout(function() {
                           $('.alert').remove();
                        }, 3000);
                     } else {
                        $.ajax({
                           url: BASE_URL + '/admin/brands/brands.php',
                           type: 'GET',
                           success: function(data) {
                              $(".container").empty();
                              $('.container').html(data);
                              var alert_message = '<div class="alert alert-success brands_delete_alert_dismissible" role="alert">' + parsed_response.success + '</div>';
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
   $(document).on('click', '.brands_delete', function(e) {
      e.preventDefault();
      var brands_id = $(this).siblings('.brands_id').val();
      brands_delete_button('/admin/brands/delete_brands/delete_brands.php', brands_id);
   });

   /*--------------------------------------------------------------- Click on Edit Button JS ----------------------------------------------------------------------------*/
   function brands_edit(url, brands_id) {
      $.ajax({
         type: 'GET',
         url: BASE_URL + url + '?brands_id=' + brands_id,
         success: function(data) {
            $(".container").empty();
            $('.container').html(data);
         },
         error: function(e) {
            console.log(e);
         }
      });
   }

   // redirection ajax
   $(document).off('click', '.brands_edit').on('click', '.brands_edit', function(e) {
      e.preventDefault();
      var brands_id = $(this).siblings('.brands_id').val();
      brands_edit('/admin/brands/edit_brands/edit_brands.php', brands_id);
   });
</script>