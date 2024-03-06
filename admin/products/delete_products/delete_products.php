<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
   $product_id = trim($_GET["product_id"]);

   $response = array();
   $result = mysqli_query($database_connection, "SELECT id FROM products WHERE id = $product_id");
   if (mysqli_num_rows($result) > 0) {
      $uploaded_image_query = "SELECT path FROM product_image WHERE products_id = $product_id";
      $uploaded_image_result = mysqli_query($database_connection, $uploaded_image_query);
      while ($row = mysqli_fetch_assoc($uploaded_image_result)) {
         $image_path = dirname(__DIR__, 3) . "/public/assets/product_images/" . $row['path'];
         if (file_exists($image_path)) {
            unlink($image_path);
         }
      }
      mysqli_query($database_connection, "DELETE FROM product_image WHERE products_id = $product_id");

      $product_size = "SELECT * FROM product_size_variant where product_id = $product_id";
      $product_size_result = mysqli_query($database_connection, $product_size);
      while ($row = mysqli_fetch_assoc($product_size_result)) {
         mysqli_query($database_connection, "DELETE FROM product_size_variant WHERE product_id = $product_id");
      }
      mysqli_query($database_connection, "DELETE FROM products WHERE id = $product_id");
      mysqli_close($database_connection);
      $response['success'] = "Product name deleted successfully.";
   } else {
      $response['error'] = "Somthing went wrong. Please try again after sometime";
   }
   echo json_encode($response);
}
