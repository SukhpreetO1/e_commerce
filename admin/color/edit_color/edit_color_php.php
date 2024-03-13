<?php
include dirname(__DIR__, 3) . "/common/config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $edit_color_input_name = trim($_POST["edit_color_input_name"]);
   $edit_color_id = trim($_POST["edit_color_id"]);

   $apiUrl = "https://www.thecolorapi.com/id?hex=" . urlencode($edit_color_input_name);
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $apiUrl);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

   $response = curl_exec($ch);
   curl_close($ch);

   $data = json_decode($response, true);

   if (isset($data['name']['value'])) {
      $color_name = $data['name']['value'];
   }

   $check_sql = "SELECT * FROM color WHERE id = ?";
   $check_stmt = mysqli_prepare($database_connection, $check_sql);
   mysqli_stmt_bind_param($check_stmt, "i", $edit_color_id);
   mysqli_stmt_execute($check_stmt);
   mysqli_stmt_store_result($check_stmt);

   $response = array();
   if (mysqli_stmt_num_rows($check_stmt) == 0) {
      $response['error'] = "Color name does not exist.";
   } else {
      $update_sql = "UPDATE color SET name = ?, color_code = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
      $update_stmt = mysqli_prepare($database_connection, $update_sql);
      mysqli_stmt_bind_param($update_stmt, "ssi", $color_name, $edit_color_input_name, $edit_color_id);
      mysqli_stmt_execute($update_stmt);
      $response['success'] = "Color name updated successfully.";
      $response['url'] = '/admin/color/color.php';
   }
   echo json_encode($response, JSON_UNESCAPED_SLASHES);

   mysqli_stmt_close($update_stmt);
   mysqli_close($database_connection);
}
