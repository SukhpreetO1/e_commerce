<?php
include dirname(__DIR__, 3) . "/common/config/config.php";

$edit_size_input_name = $edit_size_name_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $edit_size_input_name = trim($_POST["edit_size_input_name"]);

   if (empty($edit_size_input_name)) {
      $edit_size_name_err = "Size code is required.";
   } elseif (strlen($edit_size_input_name) > 9) {
      $edit_size_name_err = "Size code must not be greater then 9 characters.";
   } elseif (!preg_match('/^[a-zA-Z\s]+$/', $edit_size_input_name)) {
      $edit_size_name_err = "Only alphabets are allowed.";
   } else {
      $update_size_input_name = trim($_POST["edit_size_input_name"]);
      $edit_size_id = trim($_POST["edit_size_id"]);

      $check_sql = "SELECT * FROM size WHERE id = ?";

      $check_stmt = mysqli_prepare($database_connection, $check_sql);
      mysqli_stmt_bind_param($check_stmt, "i", $edit_size_id);
      mysqli_stmt_execute($check_stmt);
      mysqli_stmt_store_result($check_stmt);

      $response = array();
      if (mysqli_stmt_num_rows($check_stmt) == 0) {
         $response['error'] = "Size Code does not exist.";
      } else {
         $update_sql = "UPDATE size SET name = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
         $update_stmt = mysqli_prepare($database_connection, $update_sql);
         mysqli_stmt_bind_param($update_stmt, "si", $update_size_input_name, $edit_size_id);
         mysqli_stmt_execute($update_stmt);
         $response['success'] = "Size code updated successfully.";
         $response['url'] = '/admin/size/size.php';
      }
      echo json_encode($response, JSON_UNESCAPED_SLASHES);

      mysqli_stmt_close($update_stmt);
   }
   mysqli_close($database_connection);
}
