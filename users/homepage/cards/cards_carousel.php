<?php
require dirname(__DIR__, 3) . "/common/config/config.php";

$sql = "SELECT dashboard_category_images.path, dashboard_category.name as dashboard_category_name
        FROM dashboard_category_images 
        JOIN dashboard_category ON dashboard_category_images.dashboard_category_id = dashboard_category.id
        WHERE dashboard_category.id = $category_id";
$result = $database_connection->query($sql);
$cards = [];
while ($row = $result->fetch_assoc()) {
   $cards[] = $row;
}
$chunks = array_chunk($cards, 6);
?>

<div>
   <?php
   $category_name = $chunks[0][0]['dashboard_category_name'];
   echo "<h4 class='dashboard_category_list'>$category_name</h4>";
   ?>
</div>

<div class="dashboard_card_carousel">
   <div id="medal_worthy_brands" class="carousel carousel-dark slide" data-bs-ride="carousel">
      <div class="carousel-inner">
         <?php
         $key = 0;
         while ($key < count($chunks)) {
            $chunk = $chunks[$key];
            echo "<div class='carousel-item " . ($key === 0 ? 'active' : '') . "'>";
            echo "<div class='d-flex' data-bs-interval='5000'>";
            $card_index = 0;
            while ($card_index < count($chunk)) {
               $card = $chunk[$card_index];
               echo "<div class='card' style='width: 17.15vw;'>";
               echo "<img src='" . $_ENV['BASE_URL'] . "/public/assets/dashboard_category_images/" . $card['path'] . "' class='d-block' alt='Dashboard Category Image' style='height: 18rem; width: 17vw;'>";
               echo "</div>";
               $card_index++;
            }
            echo "</div>";
            echo "</div>";
            $key++;
         }
         ?>
      </div>
   </div>
   <div class="carousel-indicators">
      <?php
      $slide_count = count($chunks);
      $key = 0;
      for ($i = 0; $i < $slide_count; $i++) {
         $active_class = ($i === 0) ? 'active' : '';
         echo '<button type="button" data-bs-target="#medal_worthy_brands" data-bs-slide-to="' . $i . '" class="dashboard_category_carousel_button ' . $active_class . '" aria-label="Slide ' . ($i + 1) . '"></button>';
      }
      ?>
   </div>
</div>