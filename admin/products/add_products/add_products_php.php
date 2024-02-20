<?php
include dirname(__DIR__, 3) . "/common/config/config.php";

$add_products_input_name = $add_products_name_err = "";
$add_products_description = $add_products_description_err = "";
$add_products_category_type = $add_products_category_type_err = "";
$add_products_quantity = $add_products_quantity_err = "";
$add_products_price = $add_products_price_err = "";
$add_products_discount = $add_products_discount_err = "";
$add_products_image = $add_products_image_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $add_products_input_name = trim($_POST["add_products_input_name"]);
   $add_products_description = trim($_POST["add_products_description"]);
   $add_products_category_type = trim($_POST["add_products_category_type"]);
   $add_products_quantity = trim($_POST["add_products_quantity"]);
   $add_products_price = trim($_POST["add_products_price"]);
   $add_products_discount = trim($_POST["add_products_discount"]);
   $add_products_image = trim($_POST["add_products_image"]);

   $errors = array();

   // Validation for Product Name
   if (empty($add_products_input_name)) {
      $errors['add_products_input_name'] = "Product name is required.";
   } elseif (strlen($add_products_input_name) < 3 || strlen($add_products_input_name) > 15) {
      $errors['add_products_input_name'] = "Product name must be between 3 and 15 characters long.";
   } elseif (!preg_match('/^[a-zA-Z\s]+$/', $add_products_input_name)) {
      $errors['add_products_input_name'] = "Only alphabets are allowed.";
   }

   // Validation for Product Description
   if (empty($add_products_description)) {
      $errors['add_products_description'] = 'Product description is required.';
   } elseif (strlen($add_products_description) < 5) {
      $errors['add_products_description'] = 'Product description must be greater than 5 characters long.';
   }

   // Validation for Category Type
   if (empty($add_products_category_type)) {
      $errors['add_products_category_type'] = 'Category type is required.';
   }

   // Validation for Product Quantity
   if (!preg_match('/^\s*\d+\s*$/', $add_products_quantity)) {
      $errors['add_products_quantity'] = 'Product quantity is required and should contain only numbers.';
   }

   // Validation for Product Price
   if (!preg_match('/^\d+(\.\d+)?$/', $add_products_price)) {
      $errors['add_products_price'] = 'Product price is required and should contain only numbers.';
   }

   // Validation for Product Discount
   if (!preg_match('/^\d+$/', $add_products_discount)) {
      $errors['add_products_discount'] = 'Product discount should contain only numbers.';
   }

   if (empty($errors)) {
      $check_sql = "SELECT * FROM products WHERE categories_type_id = ? AND name = ?";
      $insert_sql = "INSERT INTO products (name, description,  product_image_id, categories_type_id, quantity, price, discount) VALUES (?, ?, ?, ?, ?, ?, ?)";

      $check_stmt = mysqli_prepare($database_connection, $check_sql);
      mysqli_stmt_bind_param($check_stmt, "ssiiiii", $add_products_input_name, $add_products_description, $add_products_category_type, $add_products_quantity, $add_products_price, $add_products_discount, $add_products_image);
      mysqli_stmt_execute($check_stmt);
      mysqli_stmt_store_result($check_stmt);

      $response = array();
      mysqli_stmt_bind_result($check_stmt, $result);
      mysqli_stmt_fetch($check_stmt);

      if (mysqli_stmt_num_rows($check_stmt) > 0) {
         $response['error'] = "Product name already exists.";
      } else {
         $insert_stmt = mysqli_prepare($database_connection, $insert_sql);
         mysqli_stmt_bind_param($insert_stmt, "ssiiiii", $add_products_input_name, $add_products_description, $add_products_category_type, $add_products_quantity, $add_products_price, $add_products_discount, $add_products_image);
         mysqli_stmt_execute($insert_stmt);
         $response['success'] = "Product created successfully.";
         $response['url'] = '/admin/category_header/category_header.php';
      }

      echo json_encode($response, JSON_UNESCAPED_SLASHES);

      mysqli_stmt_close($check_stmt);
      mysqli_stmt_close($insert_stmt);
   }
   mysqli_close($database_connection);
}
