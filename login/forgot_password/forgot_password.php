<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">'
    <title>Forgot Password</title>
    <?php require_once "../../common/links.php" ?>
    <link rel="stylesheet" href="../../common/common.css">
</head>

<body>
    <div class="container forgot_password_mail_form">
        <div class="heading">
            <h3>Forgot Password</h3>
        </div>
        <form action="send_token_email.php" method="post">
            <div class="form-group">
                <label for="email" class="email mt-2">Email address</label>
                <input type="email" name="email" class="form-control" id="email">
            </div>
            <input type="submit"    name="send-link" class="btn btn-primary mt-2">
        </form>
    </div>
</body>

</html>