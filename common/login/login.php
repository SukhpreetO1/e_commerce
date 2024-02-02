<?php
require_once __DIR__ . '/../base_url.php';
require_once BASE_DIR . "/common/config/config.php";
require_once BASE_DIR . "/common/login/login_php.php";
require_once BASE_DIR . "/common/links.php";
require_once BASE_DIR . "/common/alerts/login_alerts.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="./login.css">
</head>

<body>
    <div class="wrapper login">
        <h2 class="login_page_heading">Login</h2>

        <?php
        if (!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group mt-3">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" class="form-control login_email <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($email); ?>">
                <span class="invalid-feedback" id="email_err"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group mt-3" style="position:relative">
                <label name="password">Password</label>
                <input type="password" id="password" name="password" class="form-control password_password <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password ?>"><span class="visible_password" onclick="toggle_password()"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                <span class="invalid-feedback" id="password_err"><?php echo $password_err; ?></span>
                <div class="form-group forgot_password mt-3">
                    <p class="login_forgot_password mt-2"><a href= "<?php echo $_ENV['BASE_URL'] ?>common/forgot_password/forgot_password/forgot_password.php">Forgot Password?</a></p>
                </div>
            </div>
            <div class="form-group login_submit_details mt-3">
                <button type="submit" id="login_submit" class="btn btn-primary" value="Login">Login</button>
                <p class="signup_page_redirect mt-2">Don't have an account? <a href="<?php echo $_ENV['BASE_URL'] ?>common/signup/signup.php">Create now</a>.</p>
            </div>
        </form>
    </div>
    <script src="./login.js"></script>
</body>

</html>