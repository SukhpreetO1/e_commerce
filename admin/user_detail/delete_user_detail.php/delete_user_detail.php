<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
   $user_id = trim($_GET["user_id"]);
   
   $response = array();
   $result = mysqli_query($database_connection, "SELECT id FROM users WHERE id = $user_id");
   if (mysqli_num_rows($result) > 0) {
      include dirname(__DIR__, 2) . "/mails/delete_user_mail.php";
      mysqli_query($database_connection, "DELETE FROM users WHERE id = $user_id");
      mysqli_close($database_connection);
      $response['success'] = "User Deleted successfully.";
   } else {
      $response['error'] = "Somthing went wrong. Please try again after sometime";
   }
   echo json_encode($response);
}
