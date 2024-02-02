<?php
$email = $password = "";
$email_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email"]) && !empty($_POST["email"])) {
        $email = trim($_POST["email"]);
    } else {
        $email_err = "Please enter email.";
    }

    if (empty($_POST["password"])) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($email_err) && empty($password_err)) {
        $sql = "SELECT id, email, password, is_admin FROM users WHERE email = ?";
    
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = $email;
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1 && mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password, $is_admin) && mysqli_stmt_fetch($stmt)) {
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["email"] = $email;
                    $_SESSION["is_admin"] = $is_admin;
                    if ($is_admin == 2) {
                        header("location:" . $_ENV['BASE_URL'] . "users/homepage/homepage.php?logged_in=true");
                        exit;
                    } else {
                        header("location:" . $_ENV['BASE_URL'] . "admin/homepage/homepage.php?logged_in=true");
                        exit;
                    }
                } else {
                    $login_err = "Invalid email or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
