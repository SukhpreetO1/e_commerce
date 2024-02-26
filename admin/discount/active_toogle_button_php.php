<?php
include dirname(__DIR__, 2) . "/common/config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $discount_id = $_POST['discount_id'];
   $active_id = $_POST['active_id'];

   $new_active_id = ($active_id == 1) ? 0 : 1;

   $check_sql = "SELECT * FROM discount WHERE id = ?";
   $update_sql = "UPDATE discount SET activate = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";

   $check_stmt = mysqli_prepare($database_connection, $check_sql);
   mysqli_stmt_bind_param($check_stmt, "i", $discount_id);
   mysqli_stmt_execute($check_stmt);
   mysqli_stmt_store_result($check_stmt);

   $response = array();
   if (mysqli_stmt_num_rows($check_stmt) == 0) {
      $response['error'] = "Discount name does not exist.";
   } else {
      $update_stmt = mysqli_prepare($database_connection, $update_sql);
      mysqli_stmt_bind_param($update_stmt, "ii", $new_active_id, $discount_id);
      mysqli_stmt_execute($update_stmt);
      $response['success'] = "Discount status updated successfully.";
      $response['url'] = '/admin/discount/discount.php';
   }
   echo json_encode($response, JSON_UNESCAPED_SLASHES);

   mysqli_stmt_close($check_stmt);
   mysqli_stmt_close($update_stmt);
}
?>
