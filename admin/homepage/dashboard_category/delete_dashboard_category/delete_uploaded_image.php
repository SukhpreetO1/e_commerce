<?php
include dirname(__DIR__, 4) . "/common/config/config.php";
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
   $dashboard_category_id = trim($_GET["dashboard_category_id"]);
   $image_id = trim($_GET["image_id"]);

   $response = array();
   $result = mysqli_query($database_connection, "SELECT id FROM dashboard_category_images WHERE dashboard_category_id = $dashboard_category_id AND id = $image_id");
   if (mysqli_num_rows($result) > 0) {
      $uploaded_image_query = "SELECT path FROM dashboard_category_images WHERE id = $image_id";
      $uploaded_image_result = mysqli_query($database_connection, $uploaded_image_query);
      while ($row = mysqli_fetch_assoc($uploaded_image_result)) {
         $image_path = dirname(__DIR__, 4) . "/public/assets/dashboard_category_images/" . $row['path'];
         if (file_exists($image_path)) {
            unlink($image_path);
         }
      }
      mysqli_query($database_connection, "DELETE FROM dashboard_category_images WHERE dashboard_category_id = $dashboard_category_id AND id = $image_id");
      mysqli_close($database_connection);
      $response['success'] = "Dashboard category image deleted successfully.";
   } else {
      $response['error'] = "Image not deleted";
   }
   echo json_encode($response);
}
