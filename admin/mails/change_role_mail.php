<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once dirname(__DIR__, 2) . '/common/config/config.php';
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
require_once dirname(__DIR__, 2) . '/common/base_url.php';
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $user_id = $_POST['user_id'];
   $role_id = $_POST['role_id'];

   $new_role_id = ($role_id == 1) ? 2 : 1;

   $email_sql = "SELECT email FROM users WHERE id = ?";
   $email_stmt = mysqli_prepare($database_connection, $email_sql);
   mysqli_stmt_bind_param($email_stmt, "i", $user_id);
   mysqli_stmt_execute($email_stmt);
   mysqli_stmt_bind_result($email_stmt, $user_email);
   mysqli_stmt_fetch($email_stmt);
   mysqli_stmt_close($email_stmt);

   // Fetch role name based on role ID
   $role_name_sql = "SELECT name FROM roles WHERE id = $role_id";
   $role_name_stmt = mysqli_prepare($database_connection, $role_name_sql);
   mysqli_stmt_bind_param($role_name_stmt, "i", $role_id);
   mysqli_stmt_execute($role_name_stmt);
   mysqli_stmt_bind_result($role_name_stmt, $role_name);
   mysqli_stmt_fetch($role_name_stmt);
   mysqli_stmt_close($role_name_stmt);

   // Fetch role name based on role ID
   $new_role_name_sql = "SELECT name FROM roles WHERE id = $new_role_id";
   $new_role_name_stmt = mysqli_prepare($database_connection, $new_role_name_sql);
   mysqli_stmt_bind_param($new_role_name_stmt, "i", $new_role_id);
   mysqli_stmt_execute($new_role_name_stmt);
   mysqli_stmt_bind_result($new_role_name_stmt, $new_role_name);
   mysqli_stmt_fetch($new_role_name_stmt);
   mysqli_stmt_close($new_role_name_stmt);

   // Send email using PHPMailer
   $mail = new PHPMailer(true);
   try {
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'qorutopel@gmail.com';
      $mail->Password = 'scyb oifg byxa zjfs';
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
      $mail->Port = 465;

      $mail->setFrom('change_role@gmail.com');
      $mail->addAddress($user_email);

      //Content
      $mail->isHTML(true);
      $mail->Subject = 'Role Updated';
      $mail->Body = 'Dear User,<br><br>We are writing to inform you that your role has been updated successfully.<br>Your previous role was : ' . $role_name . '<br>Your new role is : ' . $new_role_name . '<br><br>Thank you for your attention.<br>Best regards.<br>';

      $mail->send();
      $response['status'] = 'success';
      $response['message'] = 'Email sent successfully';
   } catch (Exception $e) {
      $response['status'] = 'error';
      $response['message'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
   }
}
