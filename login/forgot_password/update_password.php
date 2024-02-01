<?php 
require_once '../../common/links.php';
require('../../config/config.php');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Password</title>
    <link rel="stylesheet" href="../../common/common.css">
</head>

<body>
    <?php
    if (isset($_GET['reset_token'])) {
        date_default_timezone_set('Asia/kolkata');
        $date = date("Y-m-d H:i:s");
        $reset_token = $_GET['reset_token'];
        
        $sql = "SELECT * FROM users WHERE reset_link_token = '$reset_token'";
        $result = $link->query($sql);

        if ($row = $result->fetch_assoc()) {
            $email = $row['email'];
            $resetTokenExp = strtotime($row['reset_token_exp']);
            $currentTime = strtotime($date);
            $timeDifference = $currentTime - $resetTokenExp;
            if ($timeDifference > 300) {
                $sql = "UPDATE users SET reset_link_token = NULL, reset_token_exp = NULL WHERE email = '$email'";
                $link->query($sql);
                header("location: ../../login/login.php?forgot_password=token_expire");
            } else {
                echo '
                        <div class="container d-flex justify-content-center mt-5 pt-5">
                            <div class="card mt-5" style="width:500px">
                                <div class="card-header">
                                    <h1 class="text-center">Create New Password</h1>
                                </div>
                                <div class="card-body">
                                    <form method="post" onsubmit="return forgot_password_validation();">
                                        <div class="mt-2">
                                            <label for="password">Email Address :  </label>
                                            <input type="email" name="email" class="form-control email" id="email" placeholder="Email" value="' .$email .' " readonly>
                                        </div>
                                        <div class="mt-2" style="position:relative">
                                            <label for="password">Password : </label>
                                            <input type="password" name="password" class="form-control forgot_password_updation" id="forgot_password_updation" placeholder="New Password"><span class="visible_update_password" onclick="toggle_update_password_visibility()"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                            <span class="invalid-feedback password_err" id="password_err"><?php echo $password_err; ?></span>
                                        </div>
                                        <div class="mt-2" style="position:relative">
                                            <label for="password">Confirm Password : </label>
                                            <input type="password" name="confirm_password" class="form-control forgot_confirm_password_updation" id="forgot_confirm_password_updation" placeholder="Retype New Password"><span class="visible_update_confirm_password" onclick="toggle_update_confirm_password_visibility()"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                            <span class="invalid-feedback confirm_password_err" id="confirm_password_err"><?php echo $confirm_password_err; ?></span>
                                        </div>
                                        <div class="mt-4 text-end">
                                            <button type="submit" name="update" value="Reset Password" class="btn btn-primary" id="submit_button">Reset Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>';
            }
        } else {
            header("location: ../../login/login.php?forgot_password=token_expire");
        }
    } else {
        header("location: ../../login/login.php?forgot_password=server_down");
    }

    if (isset($_POST['update'])) {
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        if($password != $confirm_password){
            echo "
            <script>
                alert('Password did not match.');
                window.location.href='../login.php'                     
            </script>";
        } else {
            $forgot_hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $email = $_POST['email'];
            if($email == NULL){
                echo "
                <script>
                    alert('Email not found.');
                    window.location.href='../login.php'                     
                </script>";

            } else {
                $update = "UPDATE users SET password='$forgot_hashed_password', reset_link_token = 'NULL', reset_token_exp = NULL WHERE email = '$email'";
                if ($link->query($update) === TRUE) {
                    header("location: ../../login/login.php?forgot_password=true");
                } else {
                    header("location: ../../login/login.php?forgot_password=password_not_match");
                }
            }
        }
    }
    ?>
    <script src="update_password.js"></script>
</body>

</html>