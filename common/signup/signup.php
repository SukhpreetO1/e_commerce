<?php
// require_once dirname(__DIR__) . "/session.php";
require_once dirname(__DIR__) . "/config/config.php";
require_once dirname(__DIR__) . "/signup/signup_php.php";
require_once dirname(__DIR__) . "/links.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="./signup.css">
</head>

<body>
    <div class="wrapper signup">
        <h2 class="signup_heading">Sign Up</h2>

        <?php
        if (!empty($signup_err)) {
            echo '<div class="alert alert-danger">' . $signup_err . '</div>';
        }
        ?>

        <form id="registrationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="name_details">
                <div class="form-group me-3 mt-3">
                    <label>First Name <span class="asterik_important">*</span></label>
                    <input type="text" id="first_name" name="first_name" class="form-control first_name <?php echo (!empty($first_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>" placeholder="Enter First Name">
                    <span class="invalid-feedback" id="first_name_err"><?php echo $first_name_err; ?></span>
                </div>
                <div class="form-group me-3 mt-3">
                    <label>Last Name <span class="asterik_important">*</span></label>
                    <input type="text" id="last_name" name="last_name" class="form-control last_name <?php echo (!empty($last_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last_name; ?>" placeholder="Enter Last Name">
                    <span class="invalid-feedback" id="last_name_err"><?php echo $last_name_err; ?></span>
                </div>
            </div>
            <div class="username_email_detail">
                <div class="form-group me-3 mt-3">
                    <label>Username <span class="asterik_important">*</span></label>
                    <input type="text" id="username" name="username" class="form-control username <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" placeholder="Enter Username">
                    <span class="invalid-feedback" id="username_err"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group me-3 mt-3">
                    <label>Email <span class="asterik_important">*</span></label>
                    <input type="text" id="email" name="email" class="form-control email <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" placeholder="Enter Email Address">
                    <span class="invalid-feedback" id="email_err"><?php echo $email_err; ?></span>
                </div>
            </div>
            <div class="mobile_number_dob_details">
                <div class="form-group me-3 mt-3">
                    <label>Mobile Number <span class="asterik_important">*</span></label>
                    <input type="text" id="mobile_number" name="mobile_number" class="form-control mobile_number <?php echo (!empty($mobile_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $mobile_number; ?>" placeholder="Enter Mobile Number">
                    <span class="invalid-feedback" id="mobile_number_err"><?php echo $mobile_number_err; ?></span>
                </div>
                <div class="form-group me-3 mt-3">
                    <label>Date of Birth <span class="asterik_important">*</span></label>
                    <input type="text" id="date_of_birth" name="date_of_birth" class="form-control d_o_b <?php echo (!empty($date_of_birth_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date_of_birth; ?>" placeholder="Select Date of Birth">
                    <span class="invalid-feedback" id="date_of_birth_err"><?php echo $date_of_birth_err; ?></span>
                </div>
            </div>
            <div class="username_password_detail">
                <div class="form-group me-3 mt-3" style="position:relative">
                    <label>Password <span class="asterik_important">*</span></label>
                    <input type="password" id="password" name="password" class="form-control password <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>" placeholder="Enter Password"><span class="visible_password" onclick="toggle_password_visibility()"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                    <span class="invalid-feedback" id="password_err"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group me-3 mt-3" style="position:relative">
                    <label>Confirm Password <span class="asterik_important">*</span></label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control confirm_password <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>" placeholder="Enter Confirm Password"><span class="visible_confirm_password" onclick="toggle_confirm_password_visibility()"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                    <span class="invalid-feedback" id="confirm_password_err"><?php echo $confirm_password_err; ?></span>
                </div>
            </div>
            <div class="form-group me-3 mt-3 mt-2 signup_submit_details">
                <button type="submit" class="btn btn-primary" value="Submit" id="submit_button">Submit</button>
                <p class="login_redirect mt-3">Already have an account? <a href="../login/login.php">Login here</a>.</p>
            </div>
        </form>
    </div>
    <script>
        $('#date_of_birth').datepicker();
    </script>
    <script type="text/javascript" src="./signup.js"></script>
</body>

</html>