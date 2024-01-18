<?php
require_once "../config/config.php";
require_once "../signup/signup_php.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./signup.css">
</head>

<body>
    <div class="wrapper">
        <h2 class="signup_heading">Sign Up</h2>
        <form id="registrationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
            <div class="name_details">
                <div class="form-group mr-3">
                    <label>First Name <span class="asterik_important">*</span></label>
                    <input type="text" id="first_name" name="first_name" class="form-control first_name <?php echo (!empty($first_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>" placeholder="Enter First Name">
                    <span class="invalid-feedback" id="first_name_err"><?php echo $first_name_err; ?></span>
                </div>
                <div class="form-group mr-3">
                    <label>Last Name <span class="asterik_important">*</span></label>
                    <input type="text" id="last_name" name="last_name" class="form-control last_name <?php echo (!empty($last_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last_name; ?>" placeholder="Enter Last Name">
                    <span class="invalid-feedback" id="last_name_err"><?php echo $last_name_err; ?></span>
                </div>
            </div>
            <div class="username_email_detail">
                <div class="form-group mr-3">
                <label>Username <span class="asterik_important">*</span></label>
                    <input type="text" id="username" name="username" class="form-control username <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" placeholder="Enter Username">
                    <span class="invalid-feedback" id="username_err"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group mr-3">
                    <label>Email <span class="asterik_important">*</span></label>
                    <input type="text" id="email" name="email" class="form-control email <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" placeholder="Enter Email Address">
                    <span class="invalid-feedback" id="email_err"><?php echo $email_err; ?></span>
                </div>
            </div>
            <div class="username_password_detail">
                <div class="form-group mr-3">
                    <label>Password <span class="asterik_important">*</span></label>
                    <input type="password" id="password" name="password" class="form-control password <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>" placeholder="Enter Password">
                    <span class="invalid-feedback" id="password_err"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group mr-3">
                    <label>Confirm Password <span class="asterik_important">*</span></label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control confirm_password <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>" placeholder="Enter Confirm Password">
                    <span class="invalid-feedback" id="confirm_password_err"><?php echo $confirm_password_err; ?></span>
                </div>
            </div>
            <div class="form-group mr-3 mt-2 signup_submit_details">
                <input type="submit" class="btn btn-primary" value="Submit" id="submit_button">
                <p class="login_redirect mt-3">Already have an account? <a href="..\login\login.php">Login here</a>.</p>
            </div>
        </form>
    </div>
    <script type="text/javascript" src="../signup/signup.js"></script>
</body>

</html>