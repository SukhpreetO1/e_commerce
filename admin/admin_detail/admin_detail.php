<?php
session_start();
require dirname(__DIR__, 2) . "/common/config/config.php";
?>

<div class="admin_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="admin_detail_heading">
         <h2>Admin Details</h2>
      </div>

      <div class="admin_detail_page">
         <a href="#"><i class="fa-solid fa-arrow-left-long admin_detail_back_button"></i></a>
         <a href="#"><i class="fa-regular fa-pen-to-square admin_detail_edit_button"></i></a>
      </div>

      <?php
      $user_id = $_SESSION['id'];
      $sql = "SELECT * FROM users WHERE id = $user_id";
      $result = mysqli_query($database_connection, $sql);
      while ($admin_details = mysqli_fetch_assoc($result)) {
      ?>

         <div class="admin_details_page">
            <div class="admin_personal_detials">
               <div class="admin_detials_firstname_lastname">
                  <div class="form-group me-3 mt-3">
                     <label>First Name</label>
                     <input type="hidden" name="users_id" class="users_id" id="users_id" value="<?php echo $admin_details['id']; ?>">
                     <input type="text" id="admin_first_name" name="admin_first_name" class="form-control admin_first_name" value="<?php echo $admin_details['first_name']; ?>" readonly>
                  </div>
                  <div class="form-group me-3 mt-3">
                     <label>Last Name</label>
                     <input type="text" id="admin_last_name" name="admin_last_name" class="form-control admin_last_name" value="<?php echo $admin_details['last_name']; ?>" readonly>
                  </div>
               </div>
               <div class="admin_detials_username_email">
                  <div class="form-group me-3 mt-3">
                     <label>Username</label>
                     <input type="text" id="admin_username" name="admin_username" class="form-control admin_username" value="<?php echo $admin_details['username']; ?>" readonly>
                  </div>
                  <div class="form-group me-3 mt-3">
                     <label>Email</label>
                     <input type="text" id="admin_email" name="admin_email" class="form-control admin_email" value="<?php echo $admin_details['email']; ?>" readonly>
                  </div>
               </div>
               <div class="admin_detials_mobile_number_date_of_birth">
                  <div class="form-group me-3 mt-3">
                     <label>Mobile Number</label>
                     <input type="text" id="admin_mobile_number" name="admin_mobile_number" class="form-control admin_mobile_number" value="<?php echo $admin_details['mobile_number']; ?>" readonly>
                  </div>
                  <?php
                     $date = new DateTime($admin_details['date_of_birth']);
                     $formatted_date = $date->format('d-m-Y');
                     ?>
                  <div class="form-group me-3 mt-3">
                     <label>Date Of Birth</label>
                     <input type="text" id="admin_date_of_birth" name="admin_date_of_birth" class="form-control admin_date_of_birth" value="<?php echo $formatted_date ?>" readonly>
                  </div>
               </div>
            </div>
         </div>
      <?php
      }
      ?>
   </div>
</div>

<script>
   /*--------------------------------------------------------------- Click on edit button ----------------------------------------------------------------------------*/
   function admin_detail_edit_button(url, users_id) {
      $.ajax({
         type: 'GET',
         url: BASE_URL + url + '?users_id=' + users_id,
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
   $(document).off('click', '.admin_detail_edit_button').on('click', '.admin_detail_edit_button', function(e) {
      e.preventDefault();
      var users_id = $('#users_id').val();
      admin_detail_edit_button('/admin/admin_detail/edit_admin_detail/edit_admin_detail.php', users_id);
   });

   /*--------------------------------------------------------------- Back Button ----------------------------------------------------------------------------*/
   function admin_detail_back_button(url) {
      $('.admin_detail').removeClass('highlighted');
      $('.dashboard').addClass('highlighted');
      $.ajax({
         type: 'GET',
         url: BASE_URL + url,
         success: function(data) {
            $(".container").empty();
            var container = $('.container');
            if (!$(data).find('.homepage_sidebar').length) {
               container.html(data);
               var new_url = window.location.href.replace('?tab=admin_detail', '?tab=dashboard');
               history.pushState(null, null, new_url);
            }
         },
         error: function(e) {
            console.log(e);
         }
      });
   }

   // redirection ajax for back button the category title
   $(document).off('click', '.admin_detail_back_button').on('click', '.admin_detail_back_button', function(e) {
      e.preventDefault();
      admin_detail_back_button('/admin/homepage/dashboard/dashboard.php', e);
   });
</script>