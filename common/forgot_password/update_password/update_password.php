<?php 
require_once dirname(__DIR__, 2) . '/base_url.php';
require_once dirname(__DIR__, 2) . '/links.php';
require_once dirname(__DIR__, 2) . '/config/config.php';

if (isset($_GET['reset_token'])) {
    date_default_timezone_set('Asia/kolkata');
    $date = date("Y-m-d H:i:s");
    $reset_token = $_GET['reset_token'];
    $sql = "SELECT * FROM users WHERE reset_link_token = '$reset_token'";
    $result = $database_connection->query($sql);
    if ($row = $result->fetch_assoc()) {
        $email = $row['email'];
        $resetTokenExp = strtotime($row['reset_token_exp']);
        $currentTime = strtotime($date);
        $timeDifference = $currentTime - $resetTokenExp;
        if ($timeDifference > 300) {
            $sql = "UPDATE users SET reset_link_token = NULL, reset_token_exp = NULL WHERE email = '$email'";
            $database_connection->query($sql);
            header("location:" .$_ENV['BASE_URL'] . "/common/login/login.php?forgot_password=token_expire");
        } else {
            include dirname(__DIR__, 2) . "/forgot_password/update_password/update_password_form.php";
        }
    } else {
        header("location:" .$_ENV['BASE_URL'] . "/common/login/login.php?forgot_password=token_expire");
    }
} else {
    header("location:" .$_ENV['BASE_URL'] . "/common/login/login.php?forgot_password=server_down");
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
            $update = "UPDATE users SET password='$forgot_hashed_password', reset_link_token = 'NULL', reset_token_exp = NULL, updated_at = NOW() WHERE email = '$email'";
            if ($database_connection->query($update) === TRUE) {
                header("location:" .$_ENV['BASE_URL'] . "/common/login/login.php?forgot_password=true");
            } else {
                header("location:" .$_ENV['BASE_URL'] . "/common/login/login.php?forgot_password=password_not_match");
            }
        }
    }
}
?>
