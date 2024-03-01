<?php
include dirname(__DIR__, 3) . "/common/config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $user_id = $_POST['user_id'];
   $role_id = $_POST['role_id'];

   $new_role_id = ($role_id == 1) ? 2 : 1;

   $check_sql = "SELECT * FROM users WHERE id = ?";

   $check_stmt = mysqli_prepare($database_connection, $check_sql);
   mysqli_stmt_bind_param($check_stmt, "i", $user_id);
   mysqli_stmt_execute($check_stmt);
   mysqli_stmt_store_result($check_stmt);

   $response = array();
   if (mysqli_stmt_num_rows($check_stmt) == 0) {
      $response['error'] = "User does not exist.";
   } else {
      // Update user's role
      $update_sql = "UPDATE users SET role_id = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
      $update_stmt = mysqli_prepare($database_connection, $update_sql);
      mysqli_stmt_bind_param($update_stmt, "ii", $new_role_id, $user_id);
      mysqli_stmt_execute($update_stmt);
      $response['success'] = "Role updated successfully.";
      $response['url'] = '/admin/user_detail/user_detail.php';

      include dirname(__DIR__, 2) . "/admin/mails/change_role_mail.php";
   }
   echo json_encode($response, JSON_UNESCAPED_SLASHES);

   mysqli_stmt_close($check_stmt);
   mysqli_stmt_close($update_stmt);
}
?>
