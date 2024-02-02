<?php
require_once dirname(__DIR__, 2 ) . '/config/config.php';
require_once dirname(__DIR__, 3 ) . '/vendor/autoload.php';
require_once dirname(__DIR__, 2 ) . '/base_url.php';

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
        $mail->Body = "We received a request from you to reset your password. Please click the link below to reset your password. This link is only valid for 5 minutes.<br>
        <a href=".$_ENV['BASE_URL']."/common/forgot_password/update_password/update_password.php?reset_token=$reset_token'>Reset Password</a>";
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }    
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $database_connection->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
        $row = $result->fetch_assoc();
        if ($row) {
            $reset_token = bin2hex(random_bytes(50));
            date_default_timezone_set('Asia/kolkata');
            $date = date("Y-m-d H:i:s");

            $sql = "UPDATE users SET reset_link_token = ?, reset_token_exp = ? WHERE email = ?";
            $stmt = $database_connection->prepare($sql);
            $stmt->bind_param("sss", $reset_token, $date, $email);
            if ($stmt->execute() && sendmail($email, $reset_token)) {
                $response = array("redirect_url" => $_ENV['BASE_URL'] . "/common/login/login.php?mail_send=true");
                echo json_encode($response);
            } else {
                $response = array("redirect_url" =>  $_ENV['BASE_URL'] . "/common/forgot_password/forgot_passwordforgot_password.php?mail_send=false");
                echo json_encode($response);
            }

        } else {
            $response = array("redirect_url" => $_ENV['BASE_URL'] . "/common/forgot_password/forgot_password/forgot_password.php?mail_send=email_not_found");
            echo json_encode($response);
        }
    } else {
        $response = array("redirect_url" => $_ENV['BASE_URL'] . "/common/forgot_password/forgot_passwordforgot_password.php", "message" => "Server Down.");
        echo json_encode($response);
    }
}
?>