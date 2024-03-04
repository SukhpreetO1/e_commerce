<?php
if (isset($_GET['logged_in']) && $_GET['logged_in'] === "true") {
    $id = $_GET['admin_id'];
    echo '<div class="alert alert-success logged_in_alert_dismissible" role="alert" data-id="' . $id . '">Log in successfully</div>';
    echo '<script>setTimeout(function() { document.querySelector(".alert").remove(); }, 3000);</script>';
    echo '<script>history.replaceState(null, null, "index.php");</script>';
}
