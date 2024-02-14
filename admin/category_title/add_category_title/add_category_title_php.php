<?php
$add_category_title_input_name = $add_category_title_name_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $add_category_title_input_name = trim($_POST["add_category_title_input_name"]);

   if (empty($add_category_title_input_name)) {
      $add_category_title_name_err = "Category name is required.";
   } elseif (strlen($add_category_title_input_name) < 3 || strlen($add_category_title_input_name) > 10) {
      $add_category_title_name_err = "Category name must be between 3 and 10 characters long.";
   } elseif (!preg_match('/^[a-zA-Z]+$/', $add_category_title_input_name)) {
      $add_category_title_name_err = "Only alphabets are allowed.";
   } else {
      $check_sql = "SELECT * FROM clothes_categories WHERE name = ?";
      $insert_sql = "INSERT INTO clothes_categories (name) VALUES (?)";

      $check_stmt = mysqli_prepare($database_connection, $check_sql);
      mysqli_stmt_bind_param($check_stmt, "s", $add_category_title_input_name);
      mysqli_stmt_execute($check_stmt);
      mysqli_stmt_store_result($check_stmt);

      if (mysqli_stmt_num_rows($check_stmt) > 0) {
         $add_category_title_name_err = "Category name already exists.";
      } else {
         $insert_stmt = mysqli_prepare($database_connection, $insert_sql);
         mysqli_stmt_bind_param($insert_stmt, "s", $add_category_title_input_name);
         mysqli_stmt_execute($insert_stmt);
         $add_category_title_success = "Category created successfully.";
      }

      mysqli_stmt_close($check_stmt);
      mysqli_stmt_close($insert_stmt);
   }
   mysqli_close($database_connection);
}
