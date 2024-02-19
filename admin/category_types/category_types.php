<?php
require dirname(__DIR__, 2) . "/common/config/config.php";
?>

<div class="category_types_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="category_types_heading">
         <h2>Category Types</h2>
      </div>

      <div class="add_category_types">
         <a href="#"><i class="fa-solid fa-arrow-left-long category_types_back_button"></i></a>
         <a href="#"><i class="fa-solid fa-plus category_types_plus_icon"></i></a>
      </div>

      <div class="category_types_table">
         <table class="category_types_table" id="category_types_table">
            <thead>
               <tr>
                  <th scope="col">#</th>
                  <th scope="col">Category Name</th>
                  <th scope="col">Category Heading Name</th>
                  <th scope="col">Category Type Name</th>
                  <th scope="col">Created At</th>
                  <th scope="col">Updated At</th>
                  <th scope="col">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php
               $query = "SELECT categories_type.*, categories_heading.id as categories_heading_id, categories_heading.name as categories_heading_name, categories_heading.clothes_category_id as categories_heading_clothes_category_id, clothes_categories.id as clothes_categories_id, clothes_categories.name as clothes_categories_name
               FROM categories_type
               JOIN categories_heading ON categories_type.category_heading_id = categories_heading.id
               JOIN clothes_categories ON categories_heading.clothes_category_id = clothes_categories.id";
               $result = mysqli_query($database_connection, $query);

               while ($category_data = mysqli_fetch_assoc($result)) {
               ?>
                  <tr scope="col">
                     <td>
                        <?php echo $category_data['id']; ?>
                     </td>
                     <td>
                        <?php echo $category_data['clothes_categories_name']; ?>
                     </td>
                     <td>
                        <?php echo $category_data['categories_heading_name']; ?>
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
                        <div class="category_types_action">
                           <input type="hidden" name="category_id" class="category_id" id="category_id" value="<?php echo $category_data['id']; ?>">
                           <div class="category_types_edit">
                              <i class="fa-regular fa-pen-to-square"></i>
                           </div>
                           <div class="category_types_delete">
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
   function category_types_plus_icon(url) {
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

   // redirection ajax for adding the category types
   $(document).off('click', '.category_types_plus_icon').on('click', '.category_types_plus_icon', function(e) {
      e.preventDefault();
      category_types_plus_icon('/admin/category_types/add_category_types/add_category_types.php');
   });

   /*--------------------------------------------------------------- Click on Edit Button JS ----------------------------------------------------------------------------*/
   function category_types_edit_icon(url, category_id) {
      $.ajax({
         type: 'GET',
         url: BASE_URL + url + '?category_id=' + category_id,
         success: function(data) {
            $(".container").empty();
            $('.container').html(data);
         },
         error: function(e) {
            console.log(e);
         }
      });
   }

   // redirection ajax for adding the category types
   $(document).off('click', '.category_types_edit').on('click', '.category_types_edit', function(e) {
      e.preventDefault();
      var category_id = $(this).siblings('.category_id').val();
      category_types_edit_icon('/admin/category_types/edit_category_types/edit_category_types.php', category_id);
   });

   /*--------------------------------------------------------------- Back Button JS on dashboard ----------------------------------------------------------------------------*/
   function category_types_back_button(url) {
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

   // redirection ajax for back button the category types
   $(document).off('click', '.category_types_back_button').on('click', '.category_types_back_button', function(e) {
      e.preventDefault();
      category_types_back_button('/admin/homepage/dashboard/dashboard.php', e);
   });

   /*--------------------------------------------------------------- Adding datatables ----------------------------------------------------------------------------*/
   // for creating the tables using datatables
   $(document).ready(function() {
      $('#category_types_table').DataTable();
   });

   /*--------------------------------------------------------------- Delete Button JS on ADD PAGES ----------------------------------------------------------------------------*/
   function category_types_delete_button(url, category_id) {
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
               url: BASE_URL + url + '?category_id=' + category_id,
               success: function(response) {
                  if (parsed_response) {
                     parsed_response = null;
                  } else {
                     parsed_response = JSON.parse(response);
                     if (parsed_response.error) {
                        var alert_message = '<div class="alert alert-danger category_types_delete_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
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
                              var alert_message = '<div class="alert alert-success category_types_delete_alert_dismissible" role="alert">' + parsed_response.success + '</div>';
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

   // redirection ajax for delete button the category types
   $(document).on('click', '.category_types_delete', function(e) {
      e.preventDefault();
      var category_id = $(this).siblings('.category_id').val();
      category_types_delete_button('/admin/category_types/delete_category_types/delete_category_types.php', category_id);
   });
</script>