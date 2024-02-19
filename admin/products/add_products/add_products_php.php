<?php
include dirname(__DIR__, 3) . "/common/config/config.php";

$add_products_input_name = $add_products_name_err = "";
$add_products_description = $add_products_description_err = "";
$add_products_category_type = $add_products_category_type_err = "";
$add_products_quantity = $add_products_quantity_err = "";
$add_products_price = $add_products_price_err = "";
$add_products_discount = $add_products_discount_err = "";
$add_products_image = $add_products_image_err = "";

// var_dump($_POST);
// die();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $add_products_input_name = trim($_POST["add_products_input_name"]);
   $add_products_description = trim($_POST["add_products_description"]);
   $add_products_category_type = trim($_POST["add_products_category_type"]);
   $add_products_quantity = trim($_POST["add_products_quantity"]);
   $add_products_price = trim($_POST["add_products_price"]);
   $add_products_discount = trim($_POST["add_products_discount"]);
   $add_products_image = trim($_POST["add_products_image"]);

   if (empty($add_products_input_name)) {
      $add_category_header_title_err = "Category title is required.";
   }

   if (empty($add_category_header_input_name)) {
      $add_category_header_name_err = "Category header name is required.";
   } elseif (strlen($add_category_header_input_name) < 3 || strlen($add_category_header_input_name) > 15) {
      $add_category_header_name_err = "Category header name must be between 3 and 15 characters long.";
   } elseif (!preg_match('/^[a-zA-Z\s]+$/', $add_category_header_input_name)) {
      $add_category_header_name_err = "Only alphabets are allowed.";
   } else {
      $check_sql = "SELECT * FROM products WHERE categories_type_id = ? AND name = ?";
      $insert_sql = "INSERT INTO products (name, description,  product_image_id, categories_type_id, quantity, price, discount) VALUES (?, ?, ?, ?, ?, ?, ?)";

      $check_stmt = mysqli_prepare($database_connection, $check_sql);
      mysqli_stmt_bind_param($check_stmt, "is", $add_category_header_input_title, $add_category_header_input_name);
      mysqli_stmt_execute($check_stmt);
      mysqli_stmt_store_result($check_stmt);

      $response = array();
      mysqli_stmt_bind_result($check_stmt, $result);
      mysqli_stmt_fetch($check_stmt);

      if (mysqli_stmt_num_rows($check_stmt) > 0) {
         $response['error'] = "Category header name already exists in this category.";
      } else {
         $insert_stmt = mysqli_prepare($database_connection, $insert_sql);
         mysqli_stmt_bind_param($insert_stmt, "is", $add_category_header_input_title, $add_category_header_input_name);
         mysqli_stmt_execute($insert_stmt);
         $response['success'] = "Category header created successfully.";
         $response['url'] = '/admin/category_header/category_header.php';
      }

      echo json_encode($response, JSON_UNESCAPED_SLASHES);

      mysqli_stmt_close($check_stmt);
      mysqli_stmt_close($insert_stmt);
   }
   mysqli_close($database_connection);
}
