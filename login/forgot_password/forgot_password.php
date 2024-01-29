<?php 
if (isset($_GET['mail_send']) && $_GET['mail_send'] === "false") {
    echo '<div class="alert alert-danger account_created_alert_dismissible" role="alert">Someting got wrong.</div>';
} else if (isset($_GET['mail_send']) && $_GET['mail_send'] === "email_not_found") {
    echo '<div class="alert alert-danger account_created_alert_dismissible" role="alert">Email address not found. Please check it again.</div>';
} 

echo '<script>setTimeout(function() { document.querySelector(".alert").remove(); }, 3000);</script>';
echo '<script>history.replaceState(null, null, "forgot_password.php");</script>';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <?php require_once "../../common/links.php" ?>
    <link rel="stylesheet" href="../../common/common.css">
</head>

<body>
    <div class="container forgot_password_mail_form">
        <div class="heading">
            <h3>Forgot Password</h3>
        </div>
        <form method="post" id="forgot_password_form" >
            <div class="form-group">
                <label for="email" class="email mt-2">Email :</label>
                <input type="email" name="email" class="form-control forgot_email" id="email">
                <span class="invalid-feedback" id="email_err"><?php echo $email_err; ?></span>
            </div>
            <input type="submit" name="send-link" class="btn btn-primary mt-2 send_link" id="send_link">
        </form>
    </div>
</body>
<script src="./forgot_password.js"></script>
</html>