<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once dirname(__DIR__, 2) . '/common/config/config.php';
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
require_once dirname(__DIR__, 2) . '/common/base_url.php';
// Check if the form is submitted

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
   $user_id = $_GET['user_id'];
   $email_sql = "SELECT email FROM users WHERE id = ?";
   $email_stmt = mysqli_prepare($database_connection, $email_sql);
   mysqli_stmt_bind_param($email_stmt, "i", $user_id);
   mysqli_stmt_execute($email_stmt);
   mysqli_stmt_bind_result($email_stmt, $user_email);
   mysqli_stmt_fetch($email_stmt);
   mysqli_stmt_close($email_stmt);

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

      $mail->setFrom('delete_user@gmail.com');
      $mail->addAddress($user_email);

      //Content
      $mail->isHTML(true);
      $mail->Subject = 'Delete User';
      $mail->Body = 'Dear User,<br><br>We are writing to inform you that your account has been deleted by the admin.<br><br>Thank you for using our website.<br>Best regards.<br>';

      $mail->send();
      $response['status'] = 'success';
      $response['message'] = 'Email sent successfully';
   } catch (Exception $e) {
      $response['status'] = 'error';
      $response['message'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
   }
}
