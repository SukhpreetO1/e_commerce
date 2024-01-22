<?php
require('../../config/config.php');
session_start();

require '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendmail($email, $reset_token)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'qorutopel@gmail.com';
        $mail->Password = 'scyb oifg byxa zjfs';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('forgot_password@gmail.com');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset link';
        $mail->Body = "we got a request from you regarding the reset password <br>Click the link below: <br>
        <a href='http://localhost/php/php_e-commerce/login/forgot_password/update_password.php?email=$email&reset_token=$reset_token'>reset password</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
        return false;
    }    
}
if (isset($_POST['send-link'])) {
    $email = $_POST['email'];
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $link->query($sql);

    if ($result) {
        if ($row = $result->fetch_assoc()) {
            $reset_token = bin2hex(random_bytes(16));
            date_default_timezone_set('Asia/kolkata');
            $date = date("Y-m-d");

            $sql = "UPDATE users SET reset_link_token ='$reset_token', reset_token_exp = '$date' WHERE email = '$email'";

            if (($link->query($sql) === TRUE) && sendmail($email, $reset_token) === TRUE) {
                echo "
                        <script>
                            alert('Password reset link send to mail.');
                            window.location.href='../login.php'    
                        </script>";
            } else {
                echo "
                        <script>
                            alert('Something got Wrong');
                            window.location.href='../forgot_password/forgot_password.php'
                        </script>";
            }

        } else {
            echo "
                <script>
                    alert('Email Address Not Found');
                    window.location.href='../forgot_password/forgot_password.php'
                </script>";
        }

    } else {
        echo "
            <script>
                alert('Server Down');
                window.location.href='../forgot_password/forgot_password.php'
            </script>";
    }
}
?>