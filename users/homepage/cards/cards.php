<?php
require dirname(__DIR__, 3) . "/common/config/config.php";
?>

<div class="dashboard_carousel_card mb-4">
   <?php
   $sql = "SELECT dashboard_category_images.*, dashboard_category.id as dashboard_category_id, dashboard_category.name as dashboard_category_name 
        FROM dashboard_category_images 
        JOIN dashboard_category ON dashboard_category_images.dashboard_category_id = dashboard_category.id
        WHERE dashboard_category.id = $category_id";

   $result = $database_connection->query($sql);

   if ($result->num_rows > 0) {
      $dashboard_category_image = $result->fetch_assoc();
      echo "<h4 class='dashboard_category_list'>" . $dashboard_category_image['dashboard_category_name'] . "</h4>";
      $result->data_seek(0);
      echo '<div class="cards">';
      while ($dashboard_category_image = $result->fetch_assoc()) {
         echo '<div class="dashboard_category_list_card">';
         echo '<img src="' . $_ENV['BASE_URL'] . '/public/assets/dashboard_category_images/' . $dashboard_category_image['path'] . '" class="d-block" style="height: 15rem; width: 15rem;">';
         echo '</div>';
      }
      echo '</div>';
   }
   ?>
</div>