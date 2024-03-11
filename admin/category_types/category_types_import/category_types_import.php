<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
require dirname(__DIR__, 3) . "/vendor/autoload.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $file_name = $_FILES['file']['name'];
   $file_name = str_replace(' ', '_', $file_name);
   $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

   $allowed_ext = ['xls', 'csv', 'xlsx'];

   $response = array();
   if (in_array($file_ext, $allowed_ext)) {
      $input_file_name_path = $_FILES['file']['tmp_name'];
      $spread_sheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($input_file_name_path);
      $worksheet = $spread_sheet->getActiveSheet();
      $highestRow = $worksheet->getHighestRow();
      $names = array();

      function get_category_id_from_name($database_connection, $category_name)
      {
         $query = "SELECT id FROM categories WHERE name = ?";
         $stmt = mysqli_prepare($database_connection, $query);
         mysqli_stmt_bind_param($stmt, "s", $category_name);
         mysqli_stmt_execute($stmt);
         mysqli_stmt_bind_result($stmt, $category_id);
         mysqli_stmt_fetch($stmt);
         mysqli_stmt_close($stmt);
         return $category_id;
      }

      function get_category_header_id_from_name($database_connection, $category_header_name, $category_id)
      {
         $query = "SELECT id FROM categories_heading WHERE name = ? AND categories_id = ?";
         $stmt = mysqli_prepare($database_connection, $query);
         mysqli_stmt_bind_param($stmt, "si", $category_header_name, $category_id);
         mysqli_stmt_execute($stmt);
         mysqli_stmt_bind_result($stmt, $category_header_id);
         mysqli_stmt_fetch($stmt);
         mysqli_stmt_close($stmt);
         return $category_header_id;
      }

      for ($row = 2; $row <= $highestRow; ++$row) {
         $category_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
         $category_id = get_category_id_from_name($database_connection, $category_name);

         $category_header_name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
         $category_header_id = get_category_header_id_from_name($database_connection, $category_header_name, $category_id);

         $name = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
         $names[] = "('$category_id', '$category_header_id', '$name')";
      }

      if (!empty($names)) {
         $inserted_names = array();
         $failed_names = array();

         $check_sql = "SELECT category_heading_id, name FROM categories_type WHERE category_heading_id = ? AND name = ?";
         $check_stmt = mysqli_prepare($database_connection, $check_sql);

         foreach ($names as $name) {
            $parts = explode(',', $name);
            $category_header_id = str_replace("'", '', trim($parts[1]));
            $name = str_replace("'", '', ltrim(trim($parts[2], ")")));

            mysqli_stmt_bind_param($check_stmt, "is", $category_header_id, $name);
            mysqli_stmt_execute($check_stmt);
            mysqli_stmt_store_result($check_stmt);

            if (mysqli_stmt_num_rows($check_stmt) == 0) {
               $inserted_names[] = [$category_header_id, $name];
            } else {
               $failed_names[] = $name;
            }
         }

         if (!empty($inserted_names)) {
            $values = implode(',', array_map(function ($value) {
               $category_header_id = $value[0];
               $name = $value[1];

               return "($category_header_id,$name)";
            }, $inserted_names));

            $stmt = mysqli_prepare($database_connection, "INSERT INTO categories_type (category_heading_id, name) VALUES (?, ?)");
            foreach ($inserted_names as $value) {
               mysqli_stmt_bind_param($stmt, 'is', $value[0], $value[1]);
               mysqli_stmt_execute($stmt);
            }
            mysqli_stmt_close($stmt);

            if ($stmt) {
               $brands_directory = dirname(__DIR__, 3) . '/public/assets/uploaded_files/categories_type/';
               if (!file_exists($brands_directory)) {
                  mkdir($brands_directory, 0777, true);
               }

               $permissions = fileperms($brands_directory);
               if (($permissions & 0777) !== 0777) {
                  chmod($brands_directory, 0777);
               }

               move_uploaded_file($_FILES['file']['tmp_name'], dirname(__DIR__, 3) . '/public/assets/uploaded_files/categories_type/' . $file_name);
               $response['success'] = "Category types name imported successfully";
            } else {
               $response['error'] = "Failed to import categories types names";
            }
         } else {
            $response['error'] = "Names that already exists in the database are : " . implode(', ', $failed_names);
         }
      } else {
         $response['error'] = "No name to import";
      }

      echo json_encode($response, JSON_UNESCAPED_SLASHES);
      mysqli_stmt_close($category_header_import);
   } else {
      $response['error'] = "Invalid File";
      echo json_encode($errors, JSON_UNESCAPED_SLASHES);
   }
}
