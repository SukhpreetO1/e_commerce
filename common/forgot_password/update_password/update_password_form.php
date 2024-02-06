<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Password</title>
    <link rel="stylesheet" href="./update_password.css">
</head>

<body>
    <div class="container d-flex justify-content-center mt-5 pt-5">
        <div class="card mt-5" style="width:500px">
            <div class="card-header">
                <h1 class="text-center">Create New Password</h1>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="mt-2">
                        <label for="password">Email Address : </label>
                        <input type="email" name="email" class="form-control update_email" id="email" placeholder="Email" value=<?= $email ?> readonly>
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
    </div>
    <script src="update_password.js"></script>
</body>

</html>