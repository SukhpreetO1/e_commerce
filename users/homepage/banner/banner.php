<?php
require dirname(__DIR__, 3) . "/common/config/config.php";
?>
<div id="dashboard_carousel_slider" class="carousel carousel-dark slide" data-bs-ride="carousel" style="margin-top: 8rem;">
    <div class="carousel-inner">
        <?php
        $sql = "SELECT dashboard_category_images.*, dashboard_category.id as dashboard_category_id, dashboard_category.name as dashboard_category_name 
        FROM dashboard_category_images 
        JOIN dashboard_category ON dashboard_category_images.dashboard_category_id = dashboard_category.id
        WHERE dashboard_category.id = $category_id";
        $result = $database_connection->query($sql);
        $is_first = true;
        if ($result->num_rows > 0) {
            while ($dashboard_category_image = $result->fetch_assoc()) {
                $active_class = ($is_first) ? 'active' : '';
                if ($is_first) {
                    echo '<div class="carousel-item ' . $active_class . '" data-bs-interval="2000">';
                    $is_first = false;
                } else {
                    echo '<div class="carousel-item" data-bs-interval="2000">';
                }
                echo '<img src="' . $_ENV['BASE_URL'] . '/public/assets/dashboard_category_images/' . $dashboard_category_image['path'] . '" class="d-block" alt="Dashboard Category Image" style="width: 100vw; height: 30rem;">';
                echo '</div>';
            }
        }
        ?>
    </div>
    <div class="carousel-indicators">
        <?php
        $sql = "SELECT dashboard_category_images.*, dashboard_category.id as dashboard_category_id, dashboard_category.name as dashboard_category_name 
        FROM dashboard_category_images 
        JOIN dashboard_category ON dashboard_category_images.dashboard_category_id = dashboard_category.id
        WHERE dashboard_category.id = $category_id";
        $result = $database_connection->query($sql);
        $indicator_index = 0;
        if ($result->num_rows > 0) {
            while ($dashboard_category_image = $result->fetch_assoc()) {
                $active_class = ($indicator_index === 0) ? 'active' : '';
                echo '<button type="button" data-bs-target="#dashboard_carousel_slider" data-bs-slide-to="' . $indicator_index . '" class="dashboard_category_carousel_button ' . $active_class . '" aria-current="' . ($indicator_index === 0 ? 'true' : 'false') . '" aria-label="Slide ' . ($indicator_index + 1) . '"></button>';
                $indicator_index++;
            }
        }
        ?>
    </div>
</div>