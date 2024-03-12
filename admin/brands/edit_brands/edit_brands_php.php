<?php
include dirname(__DIR__, 3) . "/common/config/config.php";

$edit_brands_input_name = $edit_brands_name_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $edit_brands_input_name = trim($_POST["edit_brands_input_name"]);

   if (empty($edit_brands_input_name)) {
      $edit_brands_name_err = "Brand name is required.";
   } elseif (strlen($edit_brands_input_name) < 1 || strlen($edit_brands_input_name) > 20) {
      $edit_brands_name_err = "Brand name must be between 1 and 20 characters long.";
   } elseif (!preg_match('/^[a-zA-Z\s\W]+$/', $edit_brands_input_name)) {
      $edit_brands_name_err = "Only alphabets are allowed.";
   } else {
      $update_brands_input_name = trim($_POST["edit_brands_input_name"]);
      $brands_id = trim($_POST["edit_brands_id"]);

      $check_sql = "SELECT * FROM brands WHERE id = ?";
      $check_stmt = mysqli_prepare($database_connection, $check_sql);
      mysqli_stmt_bind_param($check_stmt, "i", $brands_id);
      mysqli_stmt_execute($check_stmt);
      mysqli_stmt_store_result($check_stmt);

      $response = array();
      if (mysqli_stmt_num_rows($check_stmt) == 0) {
         $response['error'] = "Brand name does not exist.";
      } else {
         $update_sql = "UPDATE brands SET name = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
         $update_stmt = mysqli_prepare($database_connection, $update_sql);
         mysqli_stmt_bind_param($update_stmt, "si", $update_brands_input_name, $brands_id);
         mysqli_stmt_execute($update_stmt);
         $response['success'] = "Brand name updated successfully.";
         $response['url'] = '/admin/brands/brands.php';
      }
      echo json_encode($response, JSON_UNESCAPED_SLASHES);

      mysqli_stmt_close($update_stmt);
   }
   mysqli_close($database_connection);
}
