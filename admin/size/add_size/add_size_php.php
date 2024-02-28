<?php
include dirname(__DIR__, 3) . "/common/config/config.php";

$add_size_input_name = $add_size_name_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $add_size_input_name = trim($_POST["add_size_input_name"]);

   if (empty($add_size_input_name)) {
      $add_size_name_err = "Size Code is required.";
   } elseif (strlen($add_size_input_name) > 9) {
      $add_size_name_err = "Size Code must not be greater than 9 characters.";
   } elseif (!preg_match('/^[a-zA-Z\s]+$/', $add_size_input_name)) {
      $add_size_name_err = "Only alphabets are allowed.";
   } else {
      $check_sql = "SELECT * FROM size WHERE name = ?";

      $check_stmt = mysqli_prepare($database_connection, $check_sql);
      mysqli_stmt_bind_param($check_stmt, "s", $add_size_input_name);
      mysqli_stmt_execute($check_stmt);
      mysqli_stmt_store_result($check_stmt);

      $response = array();
      if (mysqli_stmt_num_rows($check_stmt) > 0) {
         $response['error'] = "Size Code already exists.";
      } else {
         $insert_sql = "INSERT INTO size (name) VALUES (?)";
         $insert_stmt = mysqli_prepare($database_connection, $insert_sql);
         mysqli_stmt_bind_param($insert_stmt, "s", $add_size_input_name);
         mysqli_stmt_execute($insert_stmt);
         $response['success'] = "Size created successfully.";
         $response['url'] = '/admin/size/size.php';
      }
      echo json_encode($response, JSON_UNESCAPED_SLASHES);

      mysqli_stmt_close($check_stmt);
      mysqli_stmt_close($insert_stmt);
   }
   mysqli_close($database_connection);
}
