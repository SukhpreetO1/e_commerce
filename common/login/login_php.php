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
        $sql = "SELECT id, email, password, role_id, active FROM users WHERE email = ?";
   
        if ($stmt = mysqli_prepare($database_connection, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = $email;
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1 && mysqli_stmt_bind_result($stmt, $id, $param_email, $hashed_password, $active, $role_id) && mysqli_stmt_fetch($stmt)) {
                    if(password_verify($password, $hashed_password)) {
                        if($active === 1) {
                            // session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            $_SESSION["role_id"] = $role_id;
                            // if ($role_id == 2) {
                            //     header("location:" . $_ENV['BASE_URL'] . "/users/homepage/index/index.php?logged_in=true");
                            // } else {
                            //     header("location:" . $_ENV['BASE_URL'] . "/admin/homepage/index/index.php?logged_in=true");
                            // }
                            header("location:" . $_ENV['BASE_URL'] . "/common/session.php?logged_in=true&role_id=" . $role_id . "&id=" . $id);
                        } else {
                            $login_err = "Your account has been blocked. Please contact with Admin to activate it.";
                        }
                    } else {
                        $login_err = "Incorrect Password";
                    }
                } else {
                    $login_err = "Invalid email or password.";
                }
            } else {
                $login_err = "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($database_connection);
}
