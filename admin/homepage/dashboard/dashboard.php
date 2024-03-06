<?php
require dirname(__DIR__, 3) . "/common/config/config.php";
?>

<div class="dashboard_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="dashboard_charts_details">
         <div class="card_header">
            <div class="order_details d-flex">
               <div class="card text-bg-light mb-3 me-3 pending_orders_count_details">
                  <div class="card-body">
                     <h6 class="card-title pending_orders_count">Pending Orders</h5>
                        <p class="card-text">0</p>
                  </div>
               </div>

               <div class="card text-bg-light mb-3 me-3 active_orders_count_detials">
                  <div class="card-body">
                     <h6 class="card-title active_orders_count">Active Orders</h5>
                        <p class="card-text">0</p>
                  </div>
               </div>

               <div class="card text-bg-light mb-3 me-3 delivered_orders_count_detials">
                  <div class="card-body">
                     <h6 class="card-title delivered_orders_count">Delivered Orders</h5>
                        <p class="card-text">0</p>
                  </div>
               </div>

               <div class="card text-bg-light mb-3 me-3 customer_cancel_orders_count_details">
                  <div class="card-body">
                     <h6 class="card-title customer_cancel_orders_count">Customer Cancel Orders</h5>
                        <p class="card-text">0</p>
                  </div>
               </div>
            </div>

            <div class="categories_details d-flex">
               <div class="card text-bg-light mb-3 me-3 category_heading_count_details">
                  <div class="card-body">
                     <h6 class="card-title category_heading_count">Categories Heading</h5>
                        <p class="card-text">
                           <?php
                           $query = "SELECT * FROM categories_heading";
                           $result = mysqli_query($database_connection, $query);
                           $categories_heading_count = mysqli_num_rows($result);
                           echo $categories_heading_count
                           ?>
                        </p>
                  </div>
               </div>

               <div class="card text-bg-light mb-3 me-3 category_types_count_details">
                  <div class="card-body">
                     <h6 class="card-title category_types_count">Categories Types</h5>
                        <p class="card-text">
                           <?php
                           $query = "SELECT * FROM categories_type";
                           $result = mysqli_query($database_connection, $query);
                           $categories_type_count = mysqli_num_rows($result);
                           echo $categories_type_count
                           ?>
                        </p>
                  </div>
               </div>

               <div class="card text-bg-light mb-3 me-3 products_count_details">
                  <div class="card-body">
                     <h6 class="card-title products_count">Products</h5>
                        <p class="card-text">
                           <?php
                           $query = "SELECT * FROM products";
                           $result = mysqli_query($database_connection, $query);
                           $products_count = mysqli_num_rows($result);
                           echo $products_count
                           ?>
                        </p>
                  </div>
               </div>

               <div class="card text-bg-light mb-3 me-3 discount_count_details">
                  <div class="card-body">
                     <h6 class="card-title discount_count">Discount</h5>
                        <p class="card-text">
                           <?php
                           $query = "SELECT * FROM discount";
                           $result = mysqli_query($database_connection, $query);
                           $discount_count = mysqli_num_rows($result);
                           echo $discount_count
                           ?>
                        </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   // redirection links
   function handle_dashboard_redirection(url, tabName) {
      $('.dashboard').removeClass('highlighted');
      $(`.${tabName}`).addClass('highlighted');
      $.ajax({
         type: 'GET',
         url: BASE_URL + url,
         success: function(data) {
            $('.container').empty();
            $('.container').html(data);
            var new_url = window.location.href.replace('?tab=dashboard', `?tab=${tabName}`);
            history.pushState(null, null, new_url);
         },
         error: function(e) {
            console.log(e);
         }
      });
   }

   $(document).off('click', '.category_heading_count_details').on('click', '.category_heading_count_details', function(e) {
      e.preventDefault();
      handle_dashboard_redirection('/admin/category_header/category_header.php', 'category_header');
   });

   $(document).off('click', '.category_types_count_details').on('click', '.category_types_count_details', function(e) {
      e.preventDefault();
      handle_dashboard_redirection('/admin/category_types/category_types.php', 'categories_types');
   });

   $(document).off('click', '.products_count_details').on('click', '.products_count_details', function(e) {
      e.preventDefault();
      handle_dashboard_redirection('/admin/products/products.php', 'products');
   });

   $(document).off('click', '.discount_count_details').on('click', '.discount_count_details', function(e) {
      e.preventDefault();
      handle_dashboard_redirection('/admin/discount/discount.php', 'discount');
   });
</script>