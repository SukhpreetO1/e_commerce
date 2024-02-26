<?php
include dirname(__DIR__, 3) . "/common/config/config.php";

$product_id = $_GET['product_id'];
$sql = "SELECT * FROM products WHERE id = $product_id";
$result = $database_connection->query($sql);
if ($result->num_rows > 0) {
   while ($product_data = $result->fetch_assoc()) {
?>
      <div class="product_images">
         <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
               <?php
               $sql = "SELECT * FROM product_image WHERE products_id = $product_id";
               $result = $database_connection->query($sql);
               $is_first = true;
               if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                     if ($is_first) {
                        echo '<div class="carousel-item active" data-bs-interval="10000">';
                        $is_first = false;
                     } else {
                        echo '<div class="carousel-item" data-bs-interval="10000">';
                     }
                     echo '<img src="' . $_ENV['BASE_URL'] . '/e_commerce/public/assets/product_images/' . $row['path'] . '" class="d-block w-100">';
                     echo '</div>';
                  }
               }
               ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
               <span class="carousel-control-prev-icon" aria-hidden="true"></span>
               <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
               <span class="carousel-control-next-icon" aria-hidden="true"></span>
               <span class="visually-hidden">Next</span>
            </button>
         </div>
      </div>
      <div class="product_name">
         <label for="product_name_in_modal" class="product_name_in_modal mt-2 mb-2"><strong>Name </strong></label>
         <div class="product_name_in_modal" name="product_name_in_modal" id="product_name_in_modal"><?php echo $product_data['name']; ?></div>
      </div>
      <div class="product_modal_description">
         <label for="products_description" class="edit_products_description mt-2 mb-2"><strong>Description </strong></label>
         <div name="products_description_in_modal" class="products_description_in_modal" id="products_description_in_modal"><?php echo $product_data["description"]; ?></div>
      </div>
<?php
   }
}
?>