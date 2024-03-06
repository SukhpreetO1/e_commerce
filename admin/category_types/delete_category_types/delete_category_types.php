<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
   $category_type_id = trim($_GET["category_type_id"]);
   
   $response = array();
   $result = mysqli_query($database_connection, "SELECT id FROM categories_type WHERE id = $category_type_id");
   if (mysqli_num_rows($result) > 0) {
      mysqli_query($database_connection, "DELETE FROM categories_type WHERE id = $category_type_id");
      mysqli_close($database_connection);
      $response['success'] = "Category type deleted successfully.";
   } else {
      $response['error'] = "Somthing went wrong. Please try again after sometime";
   }
   echo json_encode($response);
}
