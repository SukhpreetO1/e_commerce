<?php
include dirname(__DIR__, 3) . "/common/config/config.php";

$add_role_input_name = $add_role_name_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $add_role_input_name = trim($_POST["add_role_input_name"]);

   if (empty($add_role_input_name)) {
      $add_role_name_err = "Role name is required.";
   } elseif (strlen($add_role_input_name) < 3 || strlen($add_role_input_name) > 15) {
      $add_role_name_err = "Role name must be between 3 and 15 characters long.";
   } elseif (!preg_match('/^[a-zA-Z\s]+$/', $add_role_input_name)) {
      $add_role_name_err = "Only alphabets are allowed.";
   } else {
      $check_sql = "SELECT * FROM roles WHERE name = ?";
      $insert_sql = "INSERT INTO roles (name) VALUES (?)";

      $check_stmt = mysqli_prepare($database_connection, $check_sql);
      mysqli_stmt_bind_param($check_stmt, "s", $add_role_input_name);
      mysqli_stmt_execute($check_stmt);
      mysqli_stmt_store_result($check_stmt);

      $response = array();
      if (mysqli_stmt_num_rows($check_stmt) > 0) {
         $response['error'] = "Role name already exists.";
      } else {
         $insert_stmt = mysqli_prepare($database_connection, $insert_sql);
         mysqli_stmt_bind_param($insert_stmt, "s", $add_role_input_name);
         mysqli_stmt_execute($insert_stmt);
         $response['success'] = "New role created successfully.";
         $response['url'] = '/admin/roles/roles.php';
      }
      echo json_encode($response, JSON_UNESCAPED_SLASHES);

      mysqli_stmt_close($check_stmt);
      mysqli_stmt_close($insert_stmt);
   }
   mysqli_close($database_connection);
}
