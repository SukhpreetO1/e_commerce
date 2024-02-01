<?php 
require_once '../../common/links.php';
require_once '../../config/config.php';

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
            include "../forgot_password/update_password_form.php";
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
