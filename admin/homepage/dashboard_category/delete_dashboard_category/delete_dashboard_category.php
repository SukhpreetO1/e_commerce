<?php
include dirname(__DIR__, 4) . "/common/config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
   $dashboard_category_id = trim($_GET["dashboard_category_id"]);
   
   $response = array();
   $result = mysqli_query($database_connection, "SELECT id FROM dashboard_category WHERE id = $dashboard_category_id");
   if (mysqli_num_rows($result) > 0) {
      $category_types_brands_query = "SELECT id FROM dashboard_category_types_brands WHERE dashboard_category_id = $dashboard_category_id";
      $category_types_brands_result = mysqli_query($database_connection, $category_types_brands_query);
      while ($row = mysqli_fetch_assoc($category_types_brands_result)) {
         mysqli_query($database_connection, "DELETE FROM dashboard_category_types_brands WHERE dashboard_category_id = $dashboard_category_id");
      }

      $uploaded_image_query = "SELECT path FROM dashboard_category_images WHERE dashboard_category_id = $dashboard_category_id";
      $uploaded_image_result = mysqli_query($database_connection, $uploaded_image_query);
      while ($row = mysqli_fetch_assoc($uploaded_image_result)) {
         $image_path = dirname(__DIR__, 4) . "/public/assets/dashboard_category_images/" . $row['path'];
         if (file_exists($image_path)) {
            unlink($image_path);
         }
      }
      mysqli_query($database_connection, "DELETE FROM dashboard_category_images WHERE dashboard_category_id = $dashboard_category_id");

      mysqli_query($database_connection, "DELETE FROM dashboard_category WHERE id = $dashboard_category_id");
      mysqli_close($database_connection);
      $response['success'] = "Dashboard category deleted successfully.";
   } else {
      $response['error'] = "Somthing went wrong. Please try again after sometime";
   }
   echo json_encode($response);
}
