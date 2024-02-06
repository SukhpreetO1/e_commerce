<?php
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
    if ($_SESSION["is_admin"] == 2) {
        header("location: /e_commerce/users/homepage/index/index.php");
        exit;
    } else {
        header("location: /e_commerce/admin/homepage/index/index.php");
        exit;
    }
}