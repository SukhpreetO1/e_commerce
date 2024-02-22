<?php
include dirname(__DIR__, 3) . "/common/config/config.php";

$edit_category_title_input_name = $edit_category_title_name_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $edit_category_title_input_name = trim($_POST["edit_category_title_input_name"]);

   if (empty($edit_category_title_input_name)) {
      $edit_category_title_name_err = "Category name is required.";
   } elseif (strlen($edit_category_title_input_name) < 3 || strlen($edit_category_title_input_name) > 15) {
      $edit_category_title_name_err = "Category name must be between 3 and 15 characters long.";
   } elseif (!preg_match('/^[a-zA-Z\s]+$/', $edit_category_title_input_name)) {
      $edit_category_title_name_err = "Only alphabets are allowed.";
   } else {
      $update_category_title_input_name = trim($_POST["edit_category_title_input_name"]);
      $edit_category_id = trim($_POST["edit_category_id"]);

      $check_sql = "SELECT categories WHERE name = ? WHERE id = $edit_category_id";
      $update_sql = "UPDATE categories SET name = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";

      $check_stmt = mysqli_prepare($database_connection, $check_sql);
      mysqli_stmt_bind_param($check_stmt, "si", $update_category_title_input_name, $edit_category_id);
      mysqli_stmt_execute($check_stmt);
      mysqli_stmt_store_result($check_stmt);

      $response = array();
      if (mysqli_stmt_num_rows($check_stmt) != 0) {
         $response['error'] = "Category name does not exist.";
      } else {
         $update_stmt = mysqli_prepare($database_connection, $update_sql);
         mysqli_stmt_bind_param($update_stmt, "si", $update_category_title_input_name, $edit_category_id);
         mysqli_stmt_execute($update_stmt);
         $response['success'] = "Category title updated successfully.";
         $response['url'] = '/admin/category_title/category_title.php';
      }
      echo json_encode($response, JSON_UNESCAPED_SLASHES);

      mysqli_stmt_close($update_stmt);
   }
   mysqli_close($database_connection);
}
