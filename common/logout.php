<?php
session_start();
$_SESSION = array();
session_destroy();
header("location: " . $_ENV['BASE_URL'] . "/e_commerce" . "/common/login/login.php");
exit;
?>