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

      for ($row = 2; $row <= $highestRow; ++$row) {
         $name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
         $names[] = "('$name')";
      }

      if (!empty($names)) {
         $inserted_names = array();
         $failed_names = array();

         $check_sql = "SELECT name FROM size WHERE name = ?";
         $check_stmt = mysqli_prepare($database_connection, $check_sql);

         foreach ($names as $name) {
            $name = trim($name, "('')");
            mysqli_stmt_bind_param($check_stmt, "s", $name);
            mysqli_stmt_execute($check_stmt);
            mysqli_stmt_store_result($check_stmt);

            if (mysqli_stmt_num_rows($check_stmt) == 0) {
               $inserted_names[] = $name;
            } else {
               $failed_names[] = $name;
            }
         }

         if (!empty($inserted_names)) {
            $values = implode(',', array_map(function ($value) {
               return "('$value')";
            }, $inserted_names));
            $size_import = "INSERT INTO size (name) VALUES $values";
            $result = mysqli_query($database_connection, $size_import);

            if ($result) {
               move_uploaded_file($_FILES['file']['tmp_name'], dirname(__DIR__, 3) . '/public/assets/uploaded_files/size/' . $file_name);
               $response['success'] = "Name imported successfully";
            } else {
               $response['error'] = "Failed to import names";
            }
         } else {
            $response['error'] = "Names that already exists in the database are : " . implode(', ', $failed_names);
         }
      } else {
         $response['error'] = "No name to import";
      }

      echo json_encode($response, JSON_UNESCAPED_SLASHES);
      mysqli_stmt_close($size_import);
   } else {
      $response['error'] = "Invalid File";
      echo json_encode($errors, JSON_UNESCAPED_SLASHES);
   }
}
