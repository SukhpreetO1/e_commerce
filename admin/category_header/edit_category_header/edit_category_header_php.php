<?php
include dirname(__DIR__, 3) . "/common/config/config.php";

$edit_category_header_input_title = $edit_category_header_title_err = "";
$edit_category_header_input_name = $edit_category_header_name_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $edit_category_header_input_title = trim($_POST["edit_category_header_input_title"]);
   $edit_category_header_input_name = trim($_POST["edit_category_header_input_name"]);

   if (empty($edit_category_header_input_title)) {
      $edit_category_header_title_err = "Category title is required.";
   }

   if (empty($edit_category_header_input_name)) {
      $edit_category_header_name_err = "Category header name is required.";
   } elseif (strlen($edit_category_header_input_name) < 3 || strlen($edit_category_header_input_name) > 15) {
      $edit_category_header_name_err = "Category header name must be between 3 and 15 characters long.";
   } elseif (!preg_match('/^[a-zA-Z\s]+$/', $edit_category_header_input_name)) {
      $edit_category_header_name_err = "Only alphabets are allowed.";
   } else {
      $update_category_header_input_name = trim($_POST["edit_category_header_input_name"]);
      $edit_category_id = trim($_POST["edit_category_id"]);

      $check_sql = "SELECT * FROM categories_heading WHERE categories_id = ? AND name = ? AND id = ?";
      $update_sql = "UPDATE categories_heading SET categories_id = ?, name = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";

      $check_stmt = mysqli_prepare($database_connection, $check_sql);
      mysqli_stmt_bind_param($check_stmt, "isi", $edit_category_header_input_title, $edit_category_header_input_name, $edit_category_id);
      mysqli_stmt_execute($check_stmt);
      mysqli_stmt_store_result($check_stmt);
      
      $response = array();
      mysqli_stmt_bind_result($check_stmt, $result);
      mysqli_stmt_fetch($check_stmt);

      if (mysqli_stmt_num_rows($check_stmt) == 0) {
         $response['error'] = "Category header name does not exist in this category.";
      } else {
         $insert_stmt = mysqli_prepare($database_connection, $update_sql);
         mysqli_stmt_bind_param($insert_stmt, "isi", $edit_category_header_input_title, $edit_category_header_input_name, $edit_category_id);
         mysqli_stmt_execute($insert_stmt);
         $response['success'] = "Category header updated successfully.";
         $response['url'] = '/admin/category_header/category_header.php';
      }
      
      echo json_encode($response, JSON_UNESCAPED_SLASHES);

      mysqli_stmt_close($update_stmt);
   }
   mysqli_close($database_connection);
}
