<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
   $category_id = trim($_GET["category_id"]);
   
   $response = array();
   $result = mysqli_query($database_connection, "SELECT id FROM categories_heading WHERE id = $category_id");
   if (mysqli_num_rows($result) > 0) {
      mysqli_query($database_connection, "DELETE FROM categories_heading WHERE id = $category_id");
      mysqli_close($database_connection);
      $response['success'] = "Category header Deleted successfully.";
   } else {
      $response['error'] = "Somthing went wrong. Please try again after sometime";
   }
   echo json_encode($response);
}
