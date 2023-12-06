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
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form id="registrationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label>First Name <span class="asterik_important">*</span></label>
                <input type="text" id="first_name" name="first_name" class="form-control <?php echo (!empty($first_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>" placeholder="Enter First Name">
                <span class="invalid-feedback" id="first_name_err"><?php echo $first_name_err; ?></span>
            </div>
            <div class="form-group">
                <label>Last Name <span class="asterik_important">*</span></label>
                <input type="text" id="last_name" name="last_name" class="form-control <?php echo (!empty($last_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last_name; ?>" placeholder="Enter Last Name">
                <span class="invalid-feedback" id="last_name_err"><?php echo $last_name_err; ?></span>
            </div>
            <div class="form-group">
                <label>Username <span class="asterik_important">*</span></label>
                <input type="text" id="username" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" placeholder="Enter Username">
                <span class="invalid-feedback" id="username_err"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Email <span class="asterik_important">*</span></label>
                <input type="text" id="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" placeholder="Enter Email Address">
                <span class="invalid-feedback" id="email_err"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password <span class="asterik_important">*</span></label>
                <input type="password" id="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>" placeholder="Enter Password">
                <span class="invalid-feedback" id="password_err"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password <span class="asterik_important">*</span></label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>" placeholder="Enter Confirm Password">
                <span class="invalid-feedback" id="confirm_password_err"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit" id="submit_button">
            </div>
            <p>Already have an account? <a href="..\login\login.php">Login here</a>.</p>
        </form>
    </div>
    <script type="text/javascript" src="../signup/signup.js"></script>
</body>

</html>