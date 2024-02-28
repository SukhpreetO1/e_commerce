<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
   $color_id = trim($_GET["color_id"]);
   
   $response = array();
   $result = mysqli_query($database_connection, "SELECT id FROM color WHERE id = $color_id");
   if (mysqli_num_rows($result) > 0) {
      mysqli_query($database_connection, "DELETE FROM color WHERE id = $color_id");
      mysqli_close($database_connection);
      $response['success'] = "Color deleted successfully.";
   } else {
      $response['error'] = "Somthing went wrong. Please try again after sometime";
   }
   echo json_encode($response);
}
