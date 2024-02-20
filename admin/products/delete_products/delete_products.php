<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
   $product_id = trim($_GET["product_id"]);
   
   $response = array();
   $result = mysqli_query($database_connection, "SELECT id FROM products WHERE id = $product_id");
   if (mysqli_num_rows($result) > 0) {
      mysqli_query($database_connection, "DELETE FROM products WHERE id = $product_id");
      mysqli_close($database_connection);
      $response['success'] = "Product name deleted successfully.";
   } else {
      $response['error'] = "Somthing went wrong. Please try again after sometime";
   }
   echo json_encode($response);
}
