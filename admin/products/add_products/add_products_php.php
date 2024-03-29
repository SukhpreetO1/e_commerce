<?php
include dirname(__DIR__, 3) . "/common/config/config.php";

$add_product_brands_name = $add_products_brands_name_err = "";
$add_products_input_name = $add_products_name_err = "";
$add_products_description = $add_products_description_err = "";
$add_products_category_type = $add_products_category_type_err = "";
$add_products_quantity = $add_products_quantity_err = "";
$add_products_size = $add_products_size_err = "";
$add_products_color = $add_products_color_err = "";
$add_products_price = $add_products_price_err = "";
$add_products_discount = $add_products_discount_err = "";
$add_products_image = $add_products_image_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $add_product_brands_name = trim($_POST["add_product_brands_name"]);
   $add_products_input_name = trim($_POST["add_products_input_name"]);
   $add_products_description = trim($_POST["add_products_description"]);
   $add_products_category_type = trim($_POST["add_products_category_type"]);
   $add_products_quantity = trim($_POST["add_products_quantity"]);
   $add_products_size = trim($_POST["add_products_size"]);
   $add_products_color = trim($_POST["add_products_color"]);
   $add_products_price = trim($_POST["add_products_price"]);
   $add_products_discount = trim($_POST["add_products_discount"] ? $_POST["add_products_discount"] : 1);

   $errors = array();

   // Validation for brand name
   if (empty($add_product_brands_name)) {
      $errors['add_product_brands_name'] = 'Select atleast 1 brand name.';
   }

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

   // Validation for size
   if (empty($add_products_size)) {
      $errors['add_products_size'] = 'Select atleast 1 size.';
   }

   // Validation for color
   if (empty($add_products_color)) {
      $errors['add_products_color'] = 'Select atleast 1 color.';
   }

   // Validation for Product Price
   if (!preg_match('/^\d+(\.\d+)?$/', $add_products_price)) {
      $errors['add_products_price'] = 'Product price is required and should contain only numbers.';
   }

   if (empty($errors)) {
      $check_sql = "SELECT * FROM products WHERE categories_type_id = ? AND name = ?";
      $check_stmt = mysqli_prepare($database_connection, $check_sql);
      mysqli_stmt_bind_param($check_stmt, "is", $add_products_category_type, $add_products_input_name);
      mysqli_stmt_execute($check_stmt);
      mysqli_stmt_store_result($check_stmt);

      $response = array();
      mysqli_stmt_bind_result($check_stmt, $result);
      mysqli_stmt_fetch($check_stmt);

      if (mysqli_stmt_num_rows($check_stmt) > 0) {
         $response['error'] = "Product name already exists in this category.";
      } else {
         $insert_sql = "INSERT INTO products (name, brands_id, description, categories_type_id, quantity, color_id, price, discount_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
         $insert_stmt = mysqli_prepare($database_connection, $insert_sql);
         mysqli_stmt_bind_param($insert_stmt, "sisiiiii", $add_products_input_name, $add_product_brands_name, $add_products_description, $add_products_category_type, $add_products_quantity, $add_products_color, $add_products_price, $add_products_discount);
         mysqli_stmt_execute($insert_stmt);

         $product_id = mysqli_insert_id($database_connection);

         $size_ids = explode(',', $_POST['add_products_size']);
         $insert_product_size_sql = "INSERT INTO product_size_variant (product_id, size_id) VALUES (?, ?)";
         $stmt = $database_connection->prepare($insert_product_size_sql);
         foreach ($size_ids as $size_id) {
            $stmt->bind_param("ii", $product_id, $size_id);
            $stmt->execute();
         }
         $stmt->close();

         if (isset($_POST["image_file_names"])) {
            $image_file_names = explode(',', $_POST["image_file_names"]);
            $image_paths = array();
            foreach ($image_file_names as $key => $image_name) {
               $image_directory = dirname(__DIR__, 3) . '/public/assets/product_images/';
               if (!file_exists($image_directory)) {
                  mkdir($image_directory, 0777, true);
               }

               $permissions = fileperms($image_directory);
               if (($permissions & 0777) !== 0777) {
                  chmod($image_directory, 0777);
               }

               $image_name_without_space = str_replace(' ', '_', $image_name);
               $target_path = $image_directory . $image_name_without_space;

               if (move_uploaded_file($_FILES["add_products_image"]["tmp_name"][$key], $target_path)) {
                  $image_paths[] = $target_path;
                  $insert_image_sql = "INSERT INTO product_image (name, products_id, path) VALUES (?, ?, ?)";
                  $insert_image_stmt = mysqli_prepare($database_connection, $insert_image_sql);
                  mysqli_stmt_bind_param($insert_image_stmt, "sis", $image_name, $product_id, $image_name_without_space);
                  mysqli_stmt_execute($insert_image_stmt);
               } else {
                  $response['error'] = "Images not uploaded.";
               }
            }
         } else {
            $add_products_image = null;
         }

         $response['success'] = "Product created successfully.";
         $response['url'] = '/admin/products/products.php';
      }

      echo json_encode($response, JSON_UNESCAPED_SLASHES);

      mysqli_stmt_close($check_stmt);
      mysqli_stmt_close($insert_stmt);
   }
   mysqli_close($database_connection);
}
