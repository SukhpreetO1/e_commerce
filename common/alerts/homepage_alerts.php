<?php
if (isset($_GET['logged_in']) && $_GET['logged_in'] === "true") {
    $role_id = $_GET['role_id'];
    $id = $_GET['id'];
    echo '<div class="alert alert-success logged_in_alert_dismissible" role="alert" data-role-id="' . $role_id . '" data-id="' . $id . '">Log in successfully</div>';
    echo '<script>setTimeout(function() { document.querySelector(".alert").remove(); }, 3000);</script>';
    echo '<script>history.replaceState(null, null, "index.php");</script>';
}
