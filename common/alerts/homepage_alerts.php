<?php 
if (isset($_GET['logged_in']) && $_GET['logged_in'] === "true") {
    echo '<div class="alert alert-success logged_in_alert_dismissible" role="alert">Log in successfully</div>';
    echo '<script>setTimeout(function() { document.querySelector(".alert").remove(); }, 3000);</script>'; 
    echo '<script>history.replaceState(null, null, "homepage.php");</script>';
}
?>