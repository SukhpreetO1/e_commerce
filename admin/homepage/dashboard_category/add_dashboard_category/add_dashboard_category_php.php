<?php
include dirname(__DIR__, 4) . "/common/config/config.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

$add_dashboard_category_input_name = $add_dashboard_category_name_err = "";
$add_dashboard_category_categories_type = $add_dashboard_category_categories_type_err = "";
$add_dashboard_category_brand = $add_dashboard_category_brand_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $add_dashboard_category_input_name = trim($_POST["add_dashboard_category_input_name"]);
   $add_dashboard_category_categories_type = trim($_POST["add_dashboard_category_categories_type"]);
   $add_dashboard_category_brand = trim($_POST["add_dashboard_category_brand"]);

   $errors = array();

   if (empty($add_dashboard_category_input_name)) {
      $errors['add_dashboard_category_name'] = "Name is required.";
   } elseif (strlen($add_dashboard_category_input_name) < 3 || strlen($add_dashboard_category_input_name) > 25) {
      $errors['add_dashboard_category_name'] = "Name must be between 3 and 25 characters long.";
   } elseif (!preg_match('/^[a-zA-Z\s]+$/', $add_dashboard_category_input_name)) {
      $errors['add_dashboard_category_name'] = "Only alphabets are allowed.";
   }

   //  

   if (empty($errors)) {
      $check_sql = "SELECT * FROM dashboard_category WHERE name = ?";
      $check_stmt = mysqli_prepare($database_connection, $check_sql);
      mysqli_stmt_bind_param($check_stmt, "s", $add_dashboard_category_input_name);
      mysqli_stmt_execute($check_stmt);
      mysqli_stmt_store_result($check_stmt);

      $response = array();
      if (mysqli_stmt_num_rows($check_stmt) > 0) {
         $response['error'] = "Category name already exists.";
      } else {
         $insert_sql = "INSERT INTO dashboard_category (name) VALUES (?)";
         $insert_stmt = mysqli_prepare($database_connection, $insert_sql);
         mysqli_stmt_bind_param($insert_stmt, "s", $add_dashboard_category_input_name);
         mysqli_stmt_execute($insert_stmt);

         $dashboard_category_id = mysqli_insert_id($database_connection);

         if ($_POST["add_dashboard_category_categories_type"] !== "" && $_POST["add_dashboard_category_brand"] == "") {
            $categories_types_array = explode(", ", $_POST["add_dashboard_category_categories_type"]);
            $insert_categories_type_sql = "INSERT INTO dashboard_category_types_brands (dashboard_category_id, categories_types_id) VALUES (?, ?)";
            $insert_categories_type_stmt = mysqli_prepare($database_connection, $insert_categories_type_sql);

            foreach ($categories_types_array as $category_type) {
               mysqli_stmt_bind_param($insert_categories_type_stmt, "ii", $dashboard_category_id, $category_type);
               mysqli_stmt_execute($insert_categories_type_stmt);
            }
         } else if ($_POST["add_dashboard_category_categories_type"] == "" && $_POST["add_dashboard_category_brand"] !== "") {
            $brands_array = explode(", ", $_POST["add_dashboard_category_brand"]);
            $insert_categories_brand_sql = "INSERT INTO dashboard_category_types_brands (dashboard_category_id, brands_id) VALUES (?, ?)";
            $insert_categories_brand_stmt = mysqli_prepare($database_connection, $insert_categories_brand_sql);

            foreach ($brands_array as $brands) {
               mysqli_stmt_bind_param($insert_categories_brand_stmt, "ii", $dashboard_category_id, $brands);
               mysqli_stmt_execute($insert_categories_brand_stmt);
            }
         } else {
            $categoriesTypesArray = explode(", ", $_POST["add_dashboard_category_categories_type"]);
            $brandsArray = explode(", ", $_POST["add_dashboard_category_brand"]);

            $insert_categories_types_brand_sql = "INSERT INTO dashboard_category_types_brands (dashboard_category_id, categories_types_id, brands_id) VALUES (?, ?, ?)";
            $insert_categories_types_brand_stmt = mysqli_prepare($database_connection, $insert_categories_types_brand_sql);

            foreach ($categoriesTypesArray as $categoryType) {
               foreach ($brandsArray as $brand) {
                  mysqli_stmt_bind_param($insert_categories_types_brand_stmt, "iii", $dashboard_category_id, $categoryType, $brand);
                  mysqli_stmt_execute($insert_categories_types_brand_stmt);
               }
            }
         }

         if (isset($_POST["image_file_names"])) {
            $image_file_names = explode(',', $_POST["image_file_names"]);
            $image_paths = array();
            foreach ($image_file_names as $key => $image_name) {
               $image_directory = dirname(__DIR__, 4) . '/public/assets/dashboard_category_images/';
               if (!file_exists($image_directory)) {
                  mkdir($image_directory, 0777, true);
               }

               $permissions = fileperms($image_directory);
               if (($permissions & 0777) !== 0777) {
                  chmod($image_directory, 0777);
               }

               $image_name_without_space = str_replace(' ', '_', $image_name);
               $target_path = $image_directory . $image_name_without_space;

               foreach ($_FILES as $fileKey => $fileArray) {
                  if (strpos($fileKey, 'add_dashboard_category_images_') !== false) {
                     if (move_uploaded_file($fileArray["tmp_name"][$key], $target_path)) {
                        $image_paths[] = $target_path;
                        $insert_image_sql = "INSERT INTO dashboard_category_images (dashboard_category_id, path) VALUES (?, ?)";
                        $insert_image_stmt = mysqli_prepare($database_connection, $insert_image_sql);
                        mysqli_stmt_bind_param($insert_image_stmt, "is", $dashboard_category_id, $image_name_without_space);
                        mysqli_stmt_execute($insert_image_stmt);
                     } else {
                        $response['error'] = "Failed to move uploaded file.";
                     }
                  } else if (strpos($fileKey, 'add_dashboard_category_images') !== false) {
                     if (move_uploaded_file($fileArray["tmp_name"][$key], $target_path)) {
                        $image_paths[] = $target_path;
                        $insert_image_sql = "INSERT INTO dashboard_category_images (dashboard_category_id, path) VALUES (?, ?)";
                        $insert_image_stmt = mysqli_prepare($database_connection, $insert_image_sql);
                        mysqli_stmt_bind_param($insert_image_stmt, "is", $dashboard_category_id, $image_name_without_space);
                        mysqli_stmt_execute($insert_image_stmt);
                     } else {
                        $response['error'] = "Failed to move uploaded file.";
                     }
                  }
               }

               var_dump(move_uploaded_file($fileArray["tmp_name"][$key], $target_path));
               die;
            }
         } else {
            $add_products_image = null;
         }

         $response['success'] = "Dashboard category created successfully.";
         $response['url'] = '/admin/homepage/dashboard_category/dashboard_category.php';
      }
      echo json_encode($response, JSON_UNESCAPED_SLASHES);

      mysqli_stmt_close($check_stmt);
   }
   mysqli_close($database_connection);
}
