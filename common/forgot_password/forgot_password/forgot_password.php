<?php
require_once dirname(__DIR__, 2 ) . '/base_url.php';
require_once BASE_DIR . "/common/links.php";
require_once BASE_DIR . "/common/alerts/forgot_password_alerts.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="./forgot_password.css">
</head>

<body>
    <div class="loader">
        <div class="spinner" style="display: none;">
            <img src="<?= $_ENV['BASE_URL']?>/public/assets/images/loader.gif" alt="loader">
        </div>
    </div>
    <div class="container forgot_password_mail_form">
        <div class="heading" style="text-align: center; ">
            <h3>Forgot Password</h3>
        </div>
        <form method="post" id="forgot_password_form">
            <div class="form-group">
                <label for="email" class="email mt-2 mb-2">Email </label>
                <input type="email" name="email" class="form-control forgot_email" id="email">
                <span class="invalid-feedback" id="email_err"><?php echo $email_err; ?></span>
            </div>
            <div class="forgot_submit_button">
                <button type="submit" name="send-link" class="btn btn-primary mt-2 send_link" id="send_link" value="Send Password Reset Link">Send Password Reset Link</button>
                <span class="login_redirection_from_forgot_password"><a href="<?= $_ENV['BASE_URL']?>/common/login/login.php">Login</a></span>
            </div>
        </form>
    </div>
</body>
<script src="./forgot_password.js"></script>
</html>