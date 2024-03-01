<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once dirname(__DIR__, 2) . '/common/config/config.php';
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
require_once dirname(__DIR__, 2) . '/common/base_url.php';
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $user_id = $_POST['user_id'];
   $active_id = $_POST['active_id'];

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

      $mail->setFrom('change_user_active@gmail.com');
      $mail->addAddress($user_email);

      //Content
      $mail->isHTML(true);
      $mail->Subject = 'User Update';
      if($active_id === '1'){
         $mail->Body = 'Dear User, We are going to inform you that your account has been blocked by the admin. Please contact with Admin to activate your account again. Thank you.';
      } else {
         $mail->Body = 'Dear User, We are going to inform you that your account has been activated again by the admin. If you find any problem then please contact with Admin. Thank you.';
      }

      $mail->send();
      $response['status'] = 'success';
      $response['message'] = 'Email sent successfully';
   } catch (Exception $e) {
      $response['status'] = 'error';
      $response['message'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
   }
}
