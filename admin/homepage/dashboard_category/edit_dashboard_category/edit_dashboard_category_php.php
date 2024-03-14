<?php
include dirname(__DIR__, 4) . "/common/config/config.php";

$edit_dashboard_category_input_name = $edit_dashboard_category_name_err = "";
$edit_dashboard_category_categories_type = $edit_dashboard_category_categories_type_err = "";
$edit_dashboard_category_brand = $edit_dashboard_category_brand_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $edit_dashboard_category_input_name = trim($_POST["edit_dashboard_category_input_name"]);
   $edit_dashboard_category_categories_type = trim($_POST["edit_dashboard_category_categories_type"]);
   $edit_dashboard_category_brand = trim($_POST["edit_dashboard_category_brand"]);

   $errors = array();

   if (empty($edit_dashboard_category_input_name)) {
      $edit_dashboard_category_name_err = "Name is required.";
   } elseif (strlen($edit_dashboard_category_input_name) < 3 || strlen($edit_dashboard_category_input_name) > 25) {
      $edit_dashboard_category_name_err = "Name must be between 3 and 25 characters long.";
   } elseif (!preg_match('/^[a-zA-Z\s]+$/', $edit_dashboard_category_input_name)) {
      $edit_dashboard_category_name_err = "Only alphabets are allowed.";
   }

   if (empty($errors)) {
      $update_dashboard_category_input_name = trim($_POST["edit_dashboard_category_input_name"]);
      $edit_dashboard_category_id = trim($_POST["edit_dashboard_category_id"]);

      $check_sql = "SELECT * FROM dashboard_category WHERE name = ? AND id = ?";
      $check_stmt = mysqli_prepare($database_connection, $check_sql);
      mysqli_stmt_bind_param($check_stmt, "si", $update_dashboard_category_input_name, $edit_dashboard_category_id);
      mysqli_stmt_execute($check_stmt);
      mysqli_stmt_store_result($check_stmt);

      $response = array();
      if (mysqli_stmt_num_rows($check_stmt) < 0) {
         $response['error'] = "Name does not exist.";
      } else {
         $update_sql = "UPDATE dashboard_category SET name = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
         $update_stmt = mysqli_prepare($database_connection, $update_sql);
         mysqli_stmt_bind_param($update_stmt, "si", $update_dashboard_category_input_name, $edit_dashboard_category_id);
         mysqli_stmt_execute($update_stmt);
      }

      if (isset($_POST["edit_dashboard_category_categories_type"]) || isset($_POST["edit_dashboard_category_brand"])) {
         $categoriesTypesArray = explode(", ", $_POST["edit_dashboard_category_categories_type"]);
         $brandsArray = explode(", ", $_POST["edit_dashboard_category_brand"]);

         $update_categories_types_brand_sql = "UPDATE dashboard_category_types_brands SET dashboard_category_id = ?, categories_types_id = ?, brands_id = ?, updated_at = CURRENT_TIMESTAMP WHERE dashboard_category_id = ?";
         $update_categories_types_brand_stmt = mysqli_prepare($database_connection, $update_categories_types_brand_sql);

         $minLength = min(count($categoriesTypesArray), count($brandsArray));

         for ($i = 0; $i < $minLength; $i++) {
            $categoryTypeValue = ($categoriesTypesArray[$i] == '0') ? null : $categoriesTypesArray[$i];
            $brandValue = ($brandsArray[$i] == '0') ? null : $brandsArray[$i];

            mysqli_stmt_bind_param($update_categories_types_brand_stmt, "iii", $edit_dashboard_category_id, $categoryTypeValue, $brandValue);
            mysqli_stmt_execute($update_categories_types_brand_stmt);
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
            
            foreach ($_FILES as $fileKey => $fileArray) {
               if (strpos($fileKey, 'edit_dashboard_category_images') !== false) {
                  $image_name_without_space = str_replace(' ', '_', $fileArray['name']);
                  $image_name_without_space = is_array($image_name_without_space) ? $image_name_without_space[0] : $image_name_without_space;
                  $target_path = $image_directory . $image_name_without_space;
                  if (move_uploaded_file($fileArray["tmp_name"][$key], $target_path)) {
                     $image_paths[] = $target_path;
                     $insert__image_sql = "INSERT INTO dashboard_category_images (dashboard_category_id, path) VALUES (?, ?)";
                     $insert__image_stmt = mysqli_prepare($database_connection, $insert__image_sql);
                     mysqli_stmt_bind_param($insert__image_stmt, "is", $edit_dashboard_category_id, $image_name_without_space);
                     mysqli_stmt_execute($insert__image_stmt);
                  }
               }
            }
         }
      } else {
         $edit_products_image = null;
      }

      $response['success'] = "Dashboard category updated successfully.";
      $response['url'] = '/admin/homepage/dashboard_category/dashboard_category.php';
      echo json_encode($response, JSON_UNESCAPED_SLASHES);
      mysqli_stmt_close($update_stmt);
   }
   mysqli_close($database_connection);
}
