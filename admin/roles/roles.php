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

               while ($category_data = mysqli_fetch_assoc($result)) {
               ?>
                  <tr scope="col">
                     <td>
                        <?php echo $category_data['id']; ?>
                     </td>
                     <td>
                        <?php echo $category_data['name']; ?>
                     </td>
                     <td>
                        <?php echo date('d-m-Y', strtotime($category_data['created_at'])); ?>
                     </td>
                     <td>
                        <?php echo date('d-m-Y', strtotime($category_data['updated_at'])); ?>
                     </td>
                     <td>
                        <div class="roles_action">
                           <input type="hidden" name="roles_id" class="roles_id" id="roles_id" value="<?php echo $category_data['id']; ?>">
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

   // redirection ajax for back button the category title
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

   // redirection ajax for adding the category title
   $(document).off('click', '.roles_plus_icon').on('click', '.roles_plus_icon', function(e) {
      e.preventDefault();
      roles_plus_icon('/admin/roles/add_roles/add_roles.php');
   });
</script>