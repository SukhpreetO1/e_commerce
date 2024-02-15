<?php 
function displayAlert($message, $type = 'success') {
    echo '<div class="alert alert-' . $type . ' account_created_alert_dismissible" role="alert">' . $message . '</div>';
}

$alerts = [
    'account_created' => 'Account created successfully!',
    'forgot_password' => [
        'true' => 'New Password Created Successfully!',
        'token_expire' => 'Invalid or Expired link!',
        'server_down' => 'Server Down',
        'password_not_match' => 'Password not updated'
    ],
    'mail_send' => 'Password reset link sent to your email address!',
    'logout' => 'Logout successfully'
];

foreach ($alerts as $key => $value) {
    if (isset($_GET[$key])) {
        if (is_array($value)) {
            if (array_key_exists($_GET[$key], $value)) {
                displayAlert($value[$_GET[$key]], ($_GET[$key] === 'true' ? 'success' : 'danger'));
            }
        } else {
            displayAlert($value);
        }
    }
}

echo '<script>if(document.querySelector(".alert")) {setTimeout(function() { document.querySelector(".alert").remove(); }, 3000);}</script>';
echo '<script>history.replaceState(null, null, "login.php");</script>';
?>