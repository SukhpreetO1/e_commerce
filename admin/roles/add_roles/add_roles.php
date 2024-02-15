<?php
include dirname(__DIR__, 2) . "/roles/add_roles/add_roles_php.php";
?>
<div class="add_roles_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="roles_heading">
         <h2>Add Role</h2>
      </div>

      <div class="add_role_title">
         <a href="#"><i class="fa-solid fa-arrow-left-long add_role_back_button"></i></a>
      </div>

      <div class="add_role_name">
         <div class="add_section">
            <form method="post" id="add_role_form" class="add_role_form">
               <div class="form-group">
                  <label for="add_role_input_name" class="add_roles_title_name mt-2 mb-2">Role Name <span class="important_mark">*</span></label>
                  <input type="text" name="add_role_input_name" class="form-control add_role_input_name" id="add_role_input_name">
                  <span class="invalid-feedback add_role_name_err" id="add_role_name_err"><?php echo $add_role_name_err ?></php></span>
               </div>
               <div class="add_role_name_button">
                  <button type="submit" name="create_role" class="btn btn-primary mt-2 create_role" id="create_role" value="Create Role">Create Role</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<script>
   /*--------------------------------------------------------------- Back Button JS on ADD PAGES ----------------------------------------------------------------------------*/
   function back_button_in_roles_add_page(url, e) {
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

   // redirection ajax for back button the add category title
   $(document).off('click', '.add_role_back_button').on('click', '.add_role_back_button', function(e) {
      e.preventDefault();
      back_button_in_roles_add_page('/admin/roles/roles.php', e);
   });
</script>