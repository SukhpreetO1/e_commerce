<?php
include dirname(__DIR__, 3) . "/common/config/config.php";

$edit_products_input_name = $edit_products_name_err = "";
$edit_products_description = $edit_products_description_err = "";
$edit_products_category_type = $edit_products_category_type_err = "";
$edit_products_quantity = $edit_products_quantity_err = "";
$edit_products_price = $edit_products_price_err = "";
$edit_products_discount = $edit_products_discount_err = "";
$edit_products_image = $edit_products_image_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $edit_products_input_name = trim($_POST["edit_products_input_name"]);
   $edit_products_description = trim($_POST["edit_products_description"]);
   $edit_products_category_type = trim($_POST["edit_products_category_type"]);
   $edit_products_quantity = trim($_POST["edit_products_quantity"]);
   $edit_products_price = trim($_POST["edit_products_price"]);
   $edit_products_discount = trim($_POST["edit_products_discount"]);
   $edit_product_id = trim($_POST["edit_product_id"]);

   $errors = array();

   // Validation for Product Name
   if (empty($edit_products_input_name)) {
      $errors['edit_products_input_name'] = "Product name is required.";
   } elseif (strlen($edit_products_input_name) < 3 || strlen($edit_products_input_name) > 15) {
      $errors['edit_products_input_name'] = "Product name must be between 3 and 15 characters long.";
   } elseif (!preg_match('/^[a-zA-Z\s]+$/', $edit_products_input_name)) {
      $errors['edit_products_input_name'] = "Only alphabets are allowed.";
   }

   // Validation for Product Description
   if (empty($edit_products_description)) {
      $errors['edit_products_description'] = 'Product description is required.';
   } elseif (strlen($edit_products_description) < 5) {
      $errors['edit_products_description'] = 'Product description must be greater than 5 characters long.';
   }

   // Validation for Category Type
   if (empty($edit_products_category_type)) {
      $errors['edit_products_category_type'] = 'Category type is required.';
   }

   // Validation for Product Quantity
   if (!preg_match('/^\s*\d+\s*$/', $edit_products_quantity)) {
      $errors['edit_products_quantity'] = 'Product quantity is required and should contain only numbers.';
   }

   // Validation for Product Price
   if (!preg_match('/^\d+(\.\d+)?$/', $edit_products_price)) {
      $errors['edit_products_price'] = 'Product price is required and should contain only numbers.';
   }

   if (empty($errors)) {
      $check_sql = "SELECT * FROM products WHERE id = $edit_product_id AND categories_type_id = ? AND name = ?";
      $check_stmt = mysqli_prepare($database_connection, $check_sql);
      mysqli_stmt_bind_param($check_stmt, "iis", $edit_product_id, $edit_products_category_type, $edit_products_input_name);
      mysqli_stmt_execute($check_stmt);
      mysqli_stmt_store_result($check_stmt);

      $response = array();
      mysqli_stmt_bind_result($check_stmt, $result);
      mysqli_stmt_fetch($check_stmt);

      if (mysqli_stmt_num_rows($check_stmt) != 0) {
         $response['error'] = "Product name does not exists in this category.";
      } else {
         $update_sql = "UPDATE products SET name=?, description=?, categories_type_id=?, quantity=?, price=?, discount_id=?, updated_at = CURRENT_TIMESTAMP  WHERE id=?";
         $update_stmt = mysqli_prepare($database_connection, $update_sql);
         mysqli_stmt_bind_param($update_stmt, "ssiiiii", $edit_products_input_name, $edit_products_description, $edit_products_category_type, $edit_products_quantity, $edit_products_price, $edit_products_discount, $edit_product_id);
         mysqli_stmt_execute($update_stmt);

         $product_id = mysqli_insert_id($database_connection);
         if (isset($_POST["image_file_names"])) {
            $image_file_names = explode(',', $_POST["image_file_names"]);
            $image_paths = array();
            foreach ($image_file_names as $key => $image_name) {
               $image_directory = dirname(__DIR__, 3) . '/public/assets/product_images/';
               if (!file_exists($image_directory)) {
                  mkdir($image_directory, 0777, true);
                  chmod($image_directory, 0777);
               }
               $image_name_without_space = str_replace(' ', '_', $image_name);
               $target_path = $image_directory . $image_name_without_space;

               if (move_uploaded_file($_FILES["edit_products_image"]["tmp_name"][$key], $target_path)) {
                  $image_paths[] = $target_path;
                  $insert_image_sql = "UPDATE product_image SET name = ?, products_id = ?, path = ?, updated_at = CURRENT_TIMESTAMP WHERE products_id = ?";
                  $insert_image_stmt = mysqli_prepare($database_connection, $insert_image_sql);
                  mysqli_stmt_bind_param($insert_image_stmt, "sis", $image_name, $product_id, $image_name_without_space);
                  mysqli_stmt_execute($insert_image_stmt);
               }
            }
         } 

         $response['success'] = "Product created successfully.";
         $response['url'] = '/admin/products/products.php';
      }

      echo json_encode($response, JSON_UNESCAPED_SLASHES);

      mysqli_stmt_close($check_stmt);
      mysqli_stmt_close($update_stmt);
   }
   mysqli_close($database_connection);
}
