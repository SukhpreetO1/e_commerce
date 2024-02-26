<?php
require dirname(__DIR__, 2) . "/common/config/config.php";
?>

<div class="products_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="products_heading">
         <h2>Products Name</h2>
      </div>

      <div class="add_products">
         <a href="#"><i class="fa-solid fa-arrow-left-long products_back_button"></i></a>
         <a href="#"><i class="fa-solid fa-plus products_plus_icon"></i></a>
      </div>

      <div class="products_table">
         <table class="products_table" id="products_table">
            <thead>
               <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Description</th>
                  <th scope="col">Category Type</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Price (in ₹)/ piece</th>
                  <th scope="col">Discount</th>
                  <th scope="col">Created At</th>
                  <th scope="col">Updated At</th>
                  <th scope="col">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php
               $query = "SELECT products.*, categories_type.id as categories_type_id, categories_type.name as categories_type_name, discount.id as discount_id, discount.code_name as discount_code_name, discount.discount_type as discount_discount_type, discount.activate as discount_activate, discount.amount as discount_amount, discount.rupees_or_percentage as discount_rupees_or_percentage, discount.expiration_date as discount_expiration_date
               FROM products 
               JOIN categories_type ON products.categories_type_id = categories_type.id
               JOIN discount ON products.discount_id = discount.id";
               $result = mysqli_query($database_connection, $query);

               while ($products_data = mysqli_fetch_assoc($result)) {
               ?>
                  <tr scope="col">
                     <td>
                        <?php echo $products_data['id']; ?>
                     </td>
                     <td>
                        <?php echo $products_data['name']; ?>
                     </td>
                     <td>
                        <?php
                        $limited_description = substr($products_data['description'], 0, 6) . '...';
                        echo $limited_description;
                        ?>
                     </td>
                     <td>
                        <?php echo $products_data['categories_type_name']; ?>
                     </td>
                     <td>
                        <?php echo $products_data['quantity']; ?>
                     </td>
                     <td>
                        <?php echo $products_data['price']; ?>
                     </td>
                     <td>
                        <?php echo ($products_data['discount_rupees_or_percentage'] == 0) ? '₹ ' . $products_data['discount_amount'] : $products_data['discount_amount'] . ' %'; ?>
                     </td>
                     <td>
                        <?php echo date('d-m-Y', strtotime($products_data['created_at'])); ?>
                     </td>
                     <td>
                        <?php echo date('d-m-Y', strtotime($products_data['updated_at'])); ?>
                     </td>
                     <td>
                        <div class="products_action">
                           <input type="hidden" name="product_id" class="product_id" id="product_id" value="<?php echo $products_data['id']; ?>">
                           <div class="product_info" data-bs-toggle="modal" data-bs-target="#product_modal">
                              <i class="fa-solid fa-circle-info"></i>
                           </div>
                           <div class="products_edit">
                              <i class="fa-regular fa-pen-to-square"></i>
                           </div>
                           <div class="products_delete">
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

<!-- Modal -->
<div class="modal fade product_modal" id="product_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Product Detail</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
         </div>
      </div>
   </div>
</div>

<script>
   /*--------------------------------------------------------------- Click on plus (+) JS ----------------------------------------------------------------------------*/
   function products_plus_icon(url) {
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
   $(document).off('click', '.products_plus_icon').on('click', '.products_plus_icon', function(e) {
      e.preventDefault();
      products_plus_icon('/admin/products/add_products/add_products.php');
   });

   /*--------------------------------------------------------------- Click on Edit Button JS ----------------------------------------------------------------------------*/
   function products_edit_icon(url, product_id) {
      $.ajax({
         type: 'GET',
         url: BASE_URL + url + '?product_id=' + product_id,
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
   $(document).off('click', '.products_edit').on('click', '.products_edit', function(e) {
      e.preventDefault();
      var product_id = $(this).siblings('.product_id').val();
      products_edit_icon('/admin/products/edit_products/edit_products.php', product_id);
   });

   /*--------------------------------------------------------------- Back Button JS on dashboard ----------------------------------------------------------------------------*/
   function products_back_button(url) {
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
   $(document).off('click', '.products_back_button').on('click', '.products_back_button', function(e) {
      e.preventDefault();
      products_back_button('/admin/homepage/dashboard/dashboard.php', e);
   });

   /*--------------------------------------------------------------- Adding datatables ----------------------------------------------------------------------------*/
   // for creating the tables using datatables
   $(document).ready(function() {
      $('#products_table').DataTable();
   });

   /*--------------------------------------------------------------- Delete Button JS on ADD PAGES ----------------------------------------------------------------------------*/
   function products_delete_button(url, product_id) {
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
               url: BASE_URL + url + '?product_id=' + product_id,
               success: function(response) {
                  if (parsed_response) {
                     parsed_response = null;
                  } else {
                     parsed_response = JSON.parse(response);
                     if (parsed_response.error) {
                        var alert_message = '<div class="alert alert-danger products_delete_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                        $('#alert_container').append(alert_message);
                        setTimeout(function() {
                           $('.alert').remove();
                        }, 3000);
                     } else {
                        $.ajax({
                           url: BASE_URL + '/admin/products/products.php',
                           type: 'GET',
                           success: function(data) {
                              $(".container").empty();
                              $('.container').html(data);
                              var alert_message = '<div class="alert alert-success products_delete_alert_dismissible" role="alert">' + parsed_response.success + '</div>';
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
   $(document).on('click', '.products_delete', function(e) {
      e.preventDefault();
      var product_id = $(this).siblings('.product_id').val();
      products_delete_button('/admin/products/delete_products/delete_products.php', product_id);
   });

   /*--------------------------------------------------------------- Showing modal when click on info icon ----------------------------------------------------------------------------*/
   $(document).off('click', '.product_info').on('click', '.product_info', function(e) {
      // $('.product_info').click(function() {
      var productId = $(this).siblings('.product_id').val();
      $.ajax({
         url: BASE_URL + "/admin/products/product_modal/product_description_modal.php",
         method: 'GET',
         data: {
            product_id: productId
         },
         success: function(response) {
            $('.modal-body').html(response);
            $('#product_modal').modal('show');
         },
         error: function() {
            console.log(e);
         }
      });
   });
</script>