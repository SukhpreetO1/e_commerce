<?php
include dirname(__DIR__, 3) . "/common/config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $add_color_input_name = trim($_POST["add_color_input_name"]);

   $apiUrl = "https://www.thecolorapi.com/id?hex=" . urlencode($add_color_input_name);

   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $apiUrl);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

   $response = curl_exec($ch);
   curl_close($ch);

   $data = json_decode($response, true);

   if (isset($data['name']['value'])) {
      $color_name = $data['name']['value'];
   }

   $check_sql = "SELECT * FROM color WHERE color_code = ?";

   $check_stmt = mysqli_prepare($database_connection, $check_sql);
   mysqli_stmt_bind_param($check_stmt, "s", $add_color_input_name);
   mysqli_stmt_execute($check_stmt);
   mysqli_stmt_store_result($check_stmt);

   $response = array();
   if (mysqli_stmt_num_rows($check_stmt) > 0) {
      $response['error'] = "Color name already exists.";
   } else {
      $insert_sql = "INSERT INTO color (name, color_code) VALUES (?, ?)";
      $insert_stmt = mysqli_prepare($database_connection, $insert_sql);
      mysqli_stmt_bind_param($insert_stmt, "ss", $color_name, $add_color_input_name);
      mysqli_stmt_execute($insert_stmt);
      $response['success'] = "Color added successfully.";
      $response['url'] = '/admin/color/color.php';
   }
   echo json_encode($response, JSON_UNESCAPED_SLASHES);

   mysqli_stmt_close($check_stmt);
   mysqli_stmt_close($insert_stmt);
   mysqli_close($database_connection);
}
