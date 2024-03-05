<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
   $product_id = trim($_GET["product_id"]);
   $image_id = trim($_GET["image_id"]);

   $response = array();
   $result = mysqli_query($database_connection, "SELECT id FROM product_image WHERE id = $image_id");
   if (mysqli_num_rows($result) > 0) {
      mysqli_query($database_connection, "DELETE FROM product_image WHERE products_id = $product_id AND id = $image_id");
      mysqli_close($database_connection);
      $response['success'] = "Image deleted successfully.";
   } else {
      $response['error'] = "Image not deleted";
   }
   echo json_encode($response);
}
