<?php 
function displayAlert($message) {
    echo '<div class="alert alert-danger account_created_alert_dismissible" role="alert">' . $message . '</div>';
    echo '<script>setTimeout(function() { document.querySelector(".alert").remove(); }, 3000);</script>';
    echo '<script>history.replaceState(null, null, "forgot_password.php");</script>';
}

if (isset($_GET['mail_send'])) {
    if ($_GET['mail_send'] === "false") {
        displayAlert('Something went wrong.');
    } else if ($_GET['mail_send'] === "email_not_found") {
        displayAlert('Email address not found. Please check it again.');
    }
}
?>