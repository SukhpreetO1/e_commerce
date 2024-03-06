<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
   $brands_id = trim($_GET["brands_id"]);
   
   $response = array();
   $result = mysqli_query($database_connection, "SELECT id FROM brands WHERE id = $brands_id");
   if (mysqli_num_rows($result) > 0) {
      mysqli_query($database_connection, "DELETE FROM brands WHERE id = $brands_id");
      mysqli_close($database_connection);
      $response['success'] = "Brand deleted successfully.";
   } else {
      $response['error'] = "Somthing went wrong. Please try again after sometime";
   }
   echo json_encode($response);
}
