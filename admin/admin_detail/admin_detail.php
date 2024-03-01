<?php
require dirname(__DIR__, 2) . "/common/config/config.php";
include dirname(__DIR__, 2) . "/admin/user_detail/toggle_button_php.php";
?>

<div class="admin_detail_page">
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
         $sql = "SELECT * FROM users WHERE id = ?";
      ?>

      <div class="admin_detail_page">
         <div class="admin_personal_detials">
            <div class="firstname_last_name">
               <div class="form-group me-3 mt-3">
                  <label>First Name</label>
                  <input type="text" id="first_name" name="first_name" class="form-control first_name" value="<?php echo $first_name; ?>">
               </div>
               <div class="form-group me-3 mt-3">
                  <label>Last Name</label>
                  <input type="text" id="last_name" name="last_name" class="form-control last_name" value="<?php echo $last_name; ?>">
               </div>
            </div>
         </div>
      </div>
   </div>
</div>