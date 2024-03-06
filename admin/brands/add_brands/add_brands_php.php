<?php
include dirname(__DIR__, 3) . "/common/config/config.php";

$add_brands_input_name = $add_brands_name_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $add_brands_input_name = trim($_POST["add_brands_input_name"]);

   if (empty($add_brands_input_name)) {
      $add_brands_name_err = "Brand name is required.";
   } elseif (strlen($add_brands_input_name) < 1 || strlen($add_brands_input_name) > 15) {
      $add_brands_name_err = "Brand name must be between 1 and 15 characters long.";
   } elseif (!preg_match('/^[a-zA-Z\s\W]+$/', $add_brands_input_name)) {
      $add_brands_name_err = "Only alphabets and special character are allowed.";
   } else {
      $check_sql = "SELECT * FROM brands WHERE name = ?";

      $check_stmt = mysqli_prepare($database_connection, $check_sql);
      mysqli_stmt_bind_param($check_stmt, "s", $add_brands_input_name);
      mysqli_stmt_execute($check_stmt);
      mysqli_stmt_store_result($check_stmt);

      $response = array();
      if (mysqli_stmt_num_rows($check_stmt) > 0) {
         $response['error'] = "Brand name already exists.";
      } else {
         $insert_sql = "INSERT INTO brands (name) VALUES (?)";
         $insert_stmt = mysqli_prepare($database_connection, $insert_sql);
         mysqli_stmt_bind_param($insert_stmt, "s", $add_brands_input_name);
         mysqli_stmt_execute($insert_stmt);
         $response['success'] = "New brand created successfully.";
         $response['url'] = '/admin/brands/brands.php';
      }
      echo json_encode($response, JSON_UNESCAPED_SLASHES);

      mysqli_stmt_close($check_stmt);
      mysqli_stmt_close($insert_stmt);
   }
   mysqli_close($database_connection);
}
