<?php
require_once "../session.php";
require_once "../config/config.php";
require_once "../login/login_php.php";

// when user create a new accout then show this alert message
if (isset($_GET['account_created']) && $_GET['account_created'] === "true") {
    echo '<div class="alert alert-success account_created_alert_dismissible" role="alert">Account created successfully!</div>';
} 

// when user generated password then show this alert message
if (isset($_GET['forgot_password']) && $_GET['forgot_password'] === "true") {
    echo '<div class="alert alert-success account_created_alert_dismissible" role="alert">New Password Created Successfully!</div>';
} else if(isset($_GET['forgot_password']) && $_GET['forgot_password'] === "token_expire") {
    echo '<div class="alert alert-danger account_created_alert_dismissible" role="alert">Invalid or Expired link!</div>';
} else if(isset($_GET['forgot_password']) && $_GET['forgot_password'] === "server_down") {
    echo '<div class="alert alert-danger account_created_alert_dismissible" role="alert">Server Down</div>';
} else if(isset($_GET['forgot_password']) && $_GET['forgot_password'] === "password_not_match") {
    echo '<div class="alert alert-danger account_created_alert_dismissible" role="alert">Password not updated</div>';
}

// when user send mail for forgot password then show this alert message
if (isset($_GET['mail_send']) && $_GET['mail_send'] === "true") {
    echo '<div class="alert alert-success account_created_alert_dismissible" role="alert">Password reset link sent to your email address.</div>';
} 

echo '<script>setTimeout(function() { document.querySelector(".alert").remove(); }, 3000);</script>';
echo '<script>history.replaceState(null, null, "login.php");</script>';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <?php require_once "../common/links.php" ?>
    <link rel="stylesheet" href="../common/common.css">
</head>

<body>
    <div class="wrapper login">
        <h2 class="login_page_heading">Login</h2>

        <?php
        if (!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="validateForm(event)">
            <div class="form-group mt-3">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" class="form-control login_email <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($email); ?>">
                <span class="invalid-feedback" id="email_err"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group mt-3">
                <label name="password">Password</label>
                <input type="password" id="password" name="password" class="form-control password_password <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password ?>">
                <span class="invalid-feedback" id="password_err"><?php echo $password_err; ?></span>
                <div class="form-group forgot_password mt-3">
                    <p class="login_forgot_password mt-2"><a href="../login/forgot_password/forgot_password.php">Forgot Password?</a></p>
                </div>
            </div>
            <div class="form-group login_submit_details mt-3">
                <input type="submit" id="login_submit" class="btn btn-primary" value="Login">
                <p class="signup_page_redirect mt-2">Don't have an account? <a href="../signup/signup.php">Create now</a>.</p>
            </div>
        </form>
    </div>
    <script src="login.js"></script>
</body>

</html>