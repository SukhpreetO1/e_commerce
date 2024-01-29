<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Password</title>
    <link rel="stylesheet" href="../../common/common.css">
    <?php require_once '../../common/links.php' ?>
</head>

<body>
    <?php
    require('../../config/config.php');
    if (isset($_GET['reset_token'])) {
        date_default_timezone_set('Asia/kolkata');
        $date = date("Y-m-d");
        $reset_token = urldecode($_GET['reset_token']);
        
        $sql = "SELECT * FROM users WHERE reset_link_token = '$reset_token' AND reset_token_exp = '$date'";
        $result = $link->query($sql);

        if ($result && $row = $result->fetch_assoc()) {
            if ($row = $result->fetch_assoc()) {
                $hashed_token_from_database = $row['reset_link_token'];
                if (password_verify($reset_token, $hashed_token_from_database)) {     
                    $email = $row['email'];
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
                                            <div class="mt-2">
                                                <label for="password">Password : </label>
                                                <input type="password" name="password" class="form-control forgot_password_updation" id="forgot_password_updation" placeholder="Create New Password">
                                                <span class="invalid-feedback password_err" id="password_err"><?php echo $password_err; ?></span>
                                            </div>
                                            <div class="mt-4 text-end">
                                                <input type="submit" name="update" value="Reset Password" class="btn btn-primary">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>';
                } else {
                    echo '
                    <script>
                        alert("Invalid token");
                        window.location.href="../login.php";
                    </script>';
                }
            } else {
                echo '
                        <script>
                            alert("Invalid or Expired link");
                            // window.location.href="../login.php";
                        </script>';
            }
        }
    } else {
        echo "
                <script>
                    alert('server down!!');
                    window.location.href='../login.php'
                </script>";
    }

    if (isset($_POST['update'])) {
        $pass = $_POST['password'];
        $forgot_hashed_password = password_hash($pass, PASSWORD_DEFAULT);
        $email = $_GET['email'];
        $update = "UPDATE users SET password='$forgot_hashed_password',reset_link_token='NULL',reset_token_exp=NULL WHERE email = '$email'";

        if ($link->query($update) === TRUE) {
            echo "
                <script>
                    alert('New Password Created Successfully');
                    window.location.href='../login.php'                
                    </script>"; 
        } else {
            echo "Error: ".$sql."<br>".$link->error;
            echo "
                <script>
                    alert('Password not updated');
                    window.location.href='../login.php'                     
                </script>";
        }
    }
    ?>
    <script src="forgot_password.js"></script>
</body>

</html>