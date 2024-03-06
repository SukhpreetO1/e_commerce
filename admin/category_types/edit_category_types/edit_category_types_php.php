<?php
include dirname(__DIR__, 3) . "/common/config/config.php";

$edit_category_title_input_title = $edit_category_title_input_title_err = "";
$edit_category_header_input_title = $edit_category_header_input_title_err = "";
$edit_category_types_input_name = $edit_category_types_input_name_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $edit_category_title_input_title = trim($_POST["edit_category_title_input_title"]);
   $edit_category_header_input_title = trim($_POST["edit_category_header_input_title"]);
   $edit_category_types_input_name = trim($_POST["edit_category_types_input_name"]);
   $category_type_id = trim($_POST["category_type_id"]);

   if (empty($edit_category_title_input_title)) {
      $errors['edit_category_title_input_title'] = 'Select atleast 1 category title.';
   }

   if (empty($edit_category_header_input_title)) {
      $errors['edit_category_header_input_title'] = 'Select atleast 1 category header.';
   }

   if (empty($edit_category_types_input_name)) {
      $add_category_types_name_err = "Category types name is required.";
   } elseif (strlen($edit_category_types_input_name) < 3 || strlen($edit_category_types_input_name) > 15) {
      $add_category_types_name_err = "Category types name must be between 3 and 15 characters long.";
   } elseif (!preg_match('/^[a-zA-Z\s]+$/', $edit_category_types_input_name)) {
      $add_category_types_name_err = "Only alphabets are allowed.";
   } else {
      $updated_category_types_input_name = trim($_POST["edit_category_types_input_name"]);
      $category_type_id = trim($_POST["category_type_id"]);

      $check_sql = "SELECT * FROM categories_type WHERE name = ? AND id = ?";
      $check_stmt = mysqli_prepare($database_connection, $check_sql);
      mysqli_stmt_bind_param($check_stmt, "si", $updated_category_types_input_name, $category_type_id);
      mysqli_stmt_execute($check_stmt);
      mysqli_stmt_store_result($check_stmt);

      $response = array();
      if (mysqli_stmt_num_rows($check_stmt) == 0) {
         $response['error'] = "Category type name does not exists in this category header.";
      } else {
         $update_sql = "UPDATE categories_type SET category_heading_id=?, name = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
         $update_stmt = mysqli_prepare($database_connection, $update_sql);
         mysqli_stmt_bind_param($update_stmt, "isi", $edit_category_header_input_title, $edit_category_types_input_name, $category_type_id);
         mysqli_stmt_execute($update_stmt);
         $response['success'] = "Category types updated successfully.";
         $response['url'] = '/admin/category_types/category_types.php';
      }
      echo json_encode($response, JSON_UNESCAPED_SLASHES);

      mysqli_stmt_close($check_stmt);
      mysqli_stmt_close($update_stmt);
   }
   mysqli_close($database_connection);
}
