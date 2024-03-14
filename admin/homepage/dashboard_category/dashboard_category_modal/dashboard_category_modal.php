<?php
include dirname(__DIR__, 4) . "/common/config/config.php";

$dashboard_category_id = $_GET['dashboard_category_id'];
$sql = "SELECT * FROM dashboard_category WHERE id = $dashboard_category_id";
$result = $database_connection->query($sql);
if ($result->num_rows > 0) {
   while ($dashboard_category_data = $result->fetch_assoc()) {
?>
      <div class="dashboard_category_images_description">
         <div class="dashboard_category_name d-flex">
            <div class="col-4 d-flex">
               <h5>Name : </h5>
               <p style="font-size: 1.25rem; margin-left:3px; margin-top:-3px"><?php echo $dashboard_category_data['name']; ?></p>
            </div>
            <?php
            $dashboard_category_id = $dashboard_category_data['id'];
            $brand_sql = "SELECT dashboard_category_types_brands.* , brands.id as brands_id, brands.name as brands_name
                              FROM dashboard_category_types_brands 
                              JOIN brands ON dashboard_category_types_brands.brands_id = brands.id
                              WHERE dashboard_category_id = $dashboard_category_id";
            $result = $database_connection->query($brand_sql);
            if ($result->num_rows > 0) {
               while ($dashboard_category_brands = $result->fetch_assoc()) {
                  echo "<div class='col-4 d-flex'>";
                  echo "<h5>Brand Name : </h5>";
                  echo "<p style='font-size: 1.25rem; margin-left:3px; margin-top:-3px'>" . $dashboard_category_brands['brands_name'] . "</p>";
                  echo "</div>";
               }
            }

            $category_type_sql = "SELECT dashboard_category_types_brands.* , categories_type.id as categories_type_id, categories_type.name as categories_type_name
                              FROM dashboard_category_types_brands 
                              JOIN categories_type ON dashboard_category_types_brands.categories_types_id = categories_type.id
                              WHERE dashboard_category_id = $dashboard_category_id";
            $result = $database_connection->query($category_type_sql);
            if ($result->num_rows > 0) {
               while ($dashboard_category_category_type = $result->fetch_assoc()) {
                  echo "<div class='col-4 d-flex'>";
                  echo "<h5>Category Type : </h5>";
                  echo "<p style='font-size: 1.25rem; margin-left:3px; margin-top:-3px'>" . $dashboard_category_category_type['categories_type_name'] . "</p>";
                  echo "</div>";
               }
            }
            ?>

         </div>
         <div class="dashboard_category_images col-12">
            <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
               <div class="carousel-inner">
                  <?php
                  $sql = "SELECT * FROM dashboard_category_images WHERE dashboard_category_id = $dashboard_category_id";
                  $result = $database_connection->query($sql);
                  $is_first = true;
                  if ($result->num_rows > 0) {
                     while ($dashboard_category_image = $result->fetch_assoc()) {
                        if ($is_first) {
                           echo '<div class="carousel-item active" data-bs-interval="2000">';
                           $is_first = false;
                        } else {
                           echo '<div class="carousel-item" data-bs-interval="2000">';
                        }
                        echo '<img src="' . $_ENV['BASE_URL'] . '/e_commerce/public/assets/dashboard_category_images/' . $dashboard_category_image['path'] . '" class="d-block w-100" alt="Dashboard Category Image">';
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
      </div>
<?php
   }
}
?>