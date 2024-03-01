<?php
$first_name = $last_name = $email = $username = $mobile_number = $date_of_birth = $password = $confirm_password = "";
$first_name_err = $last_name_err = $email_err = $username_err = $mobile_number_err = $date_of_birth_err = $password_err = $confirm_password_err = $signup_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate first name
    if (empty($_POST["first_name"])) {
        $first_name_err = "Please enter your first name.";
    } else {
        $first_name = trim($_POST["first_name"]);
    }

    // Validate last name
    if (empty($_POST["last_name"])) {
        $last_name_err = "Please enter your last name.";
    } else {
        $last_name = trim($_POST["last_name"]);
    }

    // Validate email
    if (empty($_POST["email"])) {
        $email_err = "Please enter your email.";
    } elseif (!preg_match('/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/', trim($_POST["email"]))) {
        $email_err = "Invalid email format.";
    } else {
        $email = trim($_POST["email"]);

        // Check if the email already exists
        $sql = "SELECT id FROM users WHERE email = ?";
        if ($stmt = mysqli_prepare($database_connection, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = $email;
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) > 0) {
                    $email_err = "This email is already registered.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                $signup_err = "Something is wrong in email.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Validate mobile number
    if (empty($_POST["mobile_number"])) {
        $mobile_number_err = "Please enter a mobile number.";
    } elseif (trim(!preg_match('/^\d{10,12}$/', $_POST["mobile_number"]))) {
        $mobile_number_err = "Mobile number must contain 10 to 12 numbers only.";
    } else {
        $mobile_number = trim($_POST["mobile_number"]);

        // Check if the mobile_number already exists
        $sql = "SELECT id FROM users WHERE mobile_number = ?";
        if ($stmt = mysqli_prepare($database_connection, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_mobile_number);
            $param_mobile_number = $mobile_number;
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) > 0) {
                    $mobile_number_err = "This mobile number is already registered.";
                } else {
                    $mobile_number = trim($_POST["mobile_number"]);
                }
            } else {
                $signup_err = "Something is wrong in mobile number.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Validate date of birth
    if ($_POST["date_of_birth"] == null) {
        $date_of_birth_err = "Please select your date of birth.";
    } else {
        if (DateTime::createFromFormat('Y-m-d', $_POST["date_of_birth"]) === false) {
            $date_of_birth = DateTime::createFromFormat('m/d/Y', trim($_POST["date_of_birth"]))->format('Y-m-d');
        } else {
            $date_of_birth = $_POST["date_of_birth"];
        }
    }

    // Validate username
    if (empty($_POST["username"])) {
        $username_err = "Please enter a username.";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]+$/', trim($_POST["username"]))) {
        $username_err = "Username must contain 1 capital letter and 1 numbers.";
    } else {
        $username = trim($_POST["username"]);

        // Check if the username already exists
        $sql = "SELECT id FROM users WHERE username = ?";
        if ($stmt = mysqli_prepare($database_connection, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) > 0) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                $signup_err = "Something is wrong in username.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if (empty($_POST["password"])) {
        $password_err = "Please enter a password.";
    } elseif (trim(!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/', $_POST["password"]))) {
        $password_err = "Password must have atleast 6 characters, 1 capital letter and 1 special character";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty($_POST["confirm_password"])) {
        $confirm_password_err = "Please enter the confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // If all fields are validated, proceed with the database insertion
    if (empty($first_name_err) && empty($last_name_err) && empty($email_err) && empty($mobile_number_err) && empty($date_of_birth_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO users (first_name, last_name, username, email, mobile_number, date_of_birth, password) VALUES (?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($database_connection, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssssiss", $param_first_name, $param_last_name, $param_username, $param_email, $param_mobile_number, $param_date_of_birth, $param_password);

            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_username = $username;
            $param_mobile_number = $mobile_number;
            $param_date_of_birth = $date_of_birth;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            if (mysqli_stmt_execute($stmt)) {
                header("location: ../login/login.php?account_created=true");
            } else {
                $signup_err = "Account not created. Please contact admin.";
            }
        } else {
            $signup_err = "Oops! Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($database_connection);
}
