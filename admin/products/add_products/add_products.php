<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
include dirname(__DIR__, 2) . "/products/add_products/add_products_php.php";
?>
<div class="add_products_page">
   <div class="alert_container" id="alert_container"></div>
   <div class="container">
      <div class="products_heading">
         <h2>Add Product</h2>
      </div>

      <div class="add_products">
         <a href="#"><i class="fa-solid fa-arrow-left-long add_products_back_button"></i></a>
      </div>

      <div class="add_products_name">
         <div class="add_section">
            <form method="post" id="add_products_form" class="add_products_form">
               <div class="form-group">
                  <label for="add_products_input_name" class="add_product_name mt-2 mb-2">Name <span class="important_mark">*</span></label>
                  <input type="text" name="add_products_input_name" class="form-control add_products_input_name" id="add_products_input_name">
                  <span class="invalid-feedback add_products_name_err" id="add_products_name_err"><?php echo $add_products_name_err ?></php></span>
               </div>

               <div class="form-group">
                  <label for="add_products_description" class="add_products_description mt-2 mb-2">Description <span class="important_mark">*</span></label>
                  <textarea type="text" name="add_products_description" class="form-control add_products_description" id="add_products_description" rows="3"></textarea>
                  <span class="invalid-feedback add_products_description_err" id="add_products_description_err"><?php echo $add_products_description_err ?></php></span>
               </div>

               <div class="products_category_type_and_quantity">
                  <div class="form-group me-3">
                     <label for="add_products_category_type" class="add_products_category_type mt-2 mb-2">Category Type <span class="important_mark">*</span></label>
                     <select class="form-select add_products_category_type" id="add_products_category_type" aria-label="Select Category Title Name" name="add_products_category_type">
                        <option hidden disabled selected>Select Category Title Name</option>
                        <?php
                        $sql = "SELECT * FROM categories_type";
                        $result = $database_connection->query($sql);
                        if ($result->num_rows > 0) {
                           while ($row = $result->fetch_assoc()) {
                        ?>
                              <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                        <?php
                           }
                        }
                        $database_connection->close();
                        ?>
                     </select>
                     <span class="invalid-feedback add_products_category_type_err" id="add_products_category_type_err"><?php echo $add_products_category_type_err ?></php></span>
                  </div>

                  <div class="form-group">
                     <label for="add_products_quantity" class="add_products_quantity mt-2 mb-2">Quantity <span class="important_mark">*</span></label>
                     <input type="text" name="add_products_quantity" class="form-control add_products_quantity" id="add_products_quantity">
                     <span class="invalid-feedback add_products_quantity_err" id="add_products_quantity_err"><?php echo $add_products_quantity_err ?></php></span>
                  </div>
               </div>

               <div class="products_price_and_discount">
                  <div class="form-group me-3">
                     <label for="add_products_price" class="add_products_price mt-2 mb-2">Price <span class="important_mark">*</span></label>
                     <input type="text" name="add_products_price" class="form-control add_products_price" id="add_products_price">
                     <span class="invalid-feedback add_products_price_err" id="add_products_price_err"><?php echo $add_products_price_err ?></php></span>
                  </div>

                  <div class="form-group">
                     <label for="add_products_discount" class="add_products_discount mt-2 mb-2">Discount </label>
                     <input type="text" name="add_products_discount" class="form-control add_products_discount" id="add_products_discount">
                     <span class="invalid-feedback add_products_discount_err" id="add_products_discount_err"><?php echo $add_products_discount_err ?></php></span>
                  </div>
               </div>

               <div class="form-group upload-div">
                  <label for="add_products_image" class="add_products_image mt-2 mb-2">Image <span class="important_mark">*</span></label>
                  <div name="add_products_image" class="dropzone add_products_image" id="add_products_image"></div>
                  <span class="invalid-feedback add_products_image_err" id="add_products_image_err"><?php echo $add_products_image_err ?></span>
               </div>

               <div class="add_products_name_button">
                  <button type="submit" name="create_products" class="btn btn-primary mt-2 create_products" id="create_products" value="Create products">Create product</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<script>
   /*--------------------------------------------------------------- Validation for submit button and input in add files ----------------------------------------------------------------------------*/


   /*--------------------------------------------------------------- Back Button JS on ADD PAGES ----------------------------------------------------------------------------*/
   function back_button_in_products_add_page(url, e) {
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

   // redirection ajax for back button the add products title
   $(document).off('click', '.add_products_back_button').on('click', '.add_products_back_button', function(e) {
      e.preventDefault();
      back_button_in_products_add_page('/admin/products/products.php', e);
   });

   Dropzone.autoDiscover = false;

   document.addEventListener("DOMContentLoaded", function() {
      var myDropzone = new Dropzone("#add_products_image", {
         url: "upload_product.php",
         autoProcessQueue: false
      });

      // Manually trigger file uploads on form submit
      document.getElementById('add_products_form').addEventListener('submit', function(event) {
         event.preventDefault(); // Prevent the default form submission
         myDropzone.processQueue(); // Trigger file uploads manually
      });
   });
</script>