<?php
include dirname(__DIR__, 3) . "/common/config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $add_color_input_name = empty($_POST["add_color_input_name"]) ? "Black" : trim($_POST["add_color_input_name"]);
   $add_color_hex_code = trim($_POST["add_color_hex_code"]);

   $response = array();
   if ($add_color_input_name != "") {
      $check_sql = "SELECT * FROM color WHERE color_code = ?";

      $check_stmt = mysqli_prepare($database_connection, $check_sql);
      mysqli_stmt_bind_param($check_stmt, "s", $add_color_hex_code);
      mysqli_stmt_execute($check_stmt);
      mysqli_stmt_store_result($check_stmt);

      if (mysqli_stmt_num_rows($check_stmt) > 0) {
         $response['error'] = "Color name already exists.";
      } else {
         $insert_sql = "INSERT INTO color (name, color_code) VALUES (?, ?)";
         $insert_stmt = mysqli_prepare($database_connection, $insert_sql);
         mysqli_stmt_bind_param($insert_stmt, "ss", $add_color_input_name, $add_color_hex_code);
         mysqli_stmt_execute($insert_stmt);
         $response['success'] = "Color added successfully.";
         $response['url'] = '/admin/color/color.php';
      }
   } else {
      $response['error'] = "Please select atleast one color";
   }
   echo json_encode($response, JSON_UNESCAPED_SLASHES);

   mysqli_stmt_close($check_stmt);
   mysqli_stmt_close($insert_stmt);
   mysqli_close($database_connection);
}
