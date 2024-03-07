<?php
include dirname(__DIR__, 3) . "/common/config/config.php";

$product_id = $_GET['product_id'];
$sql = "SELECT products.*, color.id AS color_id, color.name AS color_name, color.color_code AS color_color_code, brands.id as brands_id, brands.name as brands_name
FROM products 
LEFT JOIN color ON products.color_id = color.id
LEFT JOIN brands ON products.brands_id = brands.id
WHERE products.id = $product_id";
$result = $database_connection->query($sql);
if ($result->num_rows > 0) {
   while ($product_data = $result->fetch_assoc()) {
?>
      <div class="product_images_description">
         <div class="product_images col-6">
            <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
               <div class="carousel-inner">
                  <?php
                  $sql = "SELECT * FROM product_image WHERE products_id = $product_id";
                  $result = $database_connection->query($sql);
                  $is_first = true;
                  if ($result->num_rows > 0) {
                     while ($product_image = $result->fetch_assoc()) {
                        if ($is_first) {
                           echo '<div class="carousel-item active" data-bs-interval="10000">';
                           $is_first = false;
                        } else {
                           echo '<div class="carousel-item" data-bs-interval="10000">';
                        }
                        echo '<img src="' . $_ENV['BASE_URL'] . '/e_commerce/public/assets/product_images/' . $product_image['path'] . '" class="d-block w-100" alt="Product Image">';
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
         <div class="product_details col-5 ms-4">
            <div class="product_name">
               <span class="products_modal_brands_name"><?php echo $product_data['brands_name']; ?></span><h5 class="product_name_in_modal" name="product_name_in_modal" id="product_name_in_modal"><?php echo $product_data['name']; ?></h5>
            </div>
            <div class="product_modal_description">
               <div name="products_description_in_modal" class="products_description_in_modal" id="products_description_in_modal"><?php echo $product_data["description"]; ?></div>
            </div>
            <div class="product_modal_size">
               <div name="products_sizes_in_modal" class="products_sizes_in_modal" id="products_sizes_in_modal">
                  <?php
                  $sql = "SELECT product_size_variant.*, size.name AS size_name
                            FROM product_size_variant
                            INNER JOIN size ON product_size_variant.size_id = size.id
                            WHERE product_size_variant.product_id = $product_id;";
                  $result = $database_connection->query($sql);
                  if ($result->num_rows > 0) {
                     while ($sizes = $result->fetch_assoc()) {
                        echo '<div class="product_selected_size">' . $sizes['size_name'] . '</div>';
                     }
                  }
                  ?>
               </div>
            </div>
            <div class="product_modal_color">
               <div name="products_color_in_modal" class="products_color_in_modal" id="products_color_in_modal">
                  <span class="product_selected_color_name" value="<?php echo $product_data['color_color_code'] ?>" style="background-color: <?php echo $product_data['color_color_code'] ?>">
                  </span>
               </div>
            </div>
         </div>
      </div>
      <div class="product_review_details">
         <div class="product_review_user_detail_and_review">
            <div class="user_detail_email">
               <?php
               $sql = "SELECT product_reviews.*, users.* FROM product_reviews INNER JOIN users ON product_reviews.user_id = users.id";
               $result = $database_connection->query($sql);
               if ($result->num_rows > 0) {
                  while ($product_review = $result->fetch_assoc()) {
                     echo "<div class='user_review_part'><div class='product_review_rating'>";
                     $product_id = $product_review['product_id'];
                     $rating_sql = "SELECT * from product_reviews WHERE product_id = $product_id AND user_id = " . $product_review['user_id'];
                     $rating_result = $database_connection->query($rating_sql);
                     if ($rating_result->num_rows > 0) {
                        $rating_row = $rating_result->fetch_assoc();
                        $rating = $rating_row['rating'];
                        $full_stars = floor($rating);
                        $half_star = ceil($rating) > $full_stars;

                        echo 'Rating ' . $rating_row['rating'] . '/5 ';
                        for ($i = 1; $i <= 5; $i++) {
                           echo '<i class="fa-star-wrapper">';
                           if ($i <= $full_stars) {
                              echo '<i class="fa-solid fa-star product_review_rating_star"></i>';
                           } elseif ($i == $full_stars + 1 && $half_star) {
                              echo '<i class="fa-solid fa-star-half product_review_rating_star"></i>';
                           } else {
                              echo '<i class="fa-regular fa-star"></i>';
                           }
                           echo '</i>';
                        }
                     }
                     echo "</div>";
                     echo "<p class='user_fullname mb-0'><span class='user_fullname_for_product_review'>" . $product_review["first_name"] . " " . $product_review["last_name"] . "</span> <span class='user_email_for_product_review'>" . $product_review["email"] . "</span></p>";

                     $image_sql = "SELECT * FROM product_reviews_images WHERE product_review_id = " . $product_review['id'];
                     $image_result = $database_connection->query($image_sql);
                     if ($image_result->num_rows > 0) {
                        echo '<div class="product_review_user_uploded_images_wrapper d-flex">';
                        while ($image_row = $image_result->fetch_assoc()) {
                           echo '<img src="' . $_ENV['BASE_URL'] . '/e_commerce/public/assets/product_review_images/' . $image_row['path'] . '" class="d-block product_review_user_uploded_images" onclick="window.open(\'' . $_ENV['BASE_URL'] . '/e_commerce/public/assets/product_review_images/' . $image_row['path'] . '\', \'_blank\');">';
                        }
                        echo '</div>';
                     }

                     echo "<span class='user_review_details'>" . $product_review['review_text'] . "</span><br>";
                     echo "<span class='user_review_date'>" . date('d-m-Y H:i:s', strtotime($product_review["review_date"])) . "</span>";
                     echo "</div>";
                  }
               }
               ?>
            </div>
         </div>
      </div>
<?php
   }
}
?>