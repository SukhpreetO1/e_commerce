<?php 
session_start();
require_once "../../common/links.php" ;
require_once "../../common/alerts/homepage_alerts.php";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if ($_SESSION["is_admin"] == 2) {
        header("location: ../../users/homepage/index/index.php?logged_in=true");
        exit;
    } else {
        header("location: ../../admin/homepage/index/index.php?logged_in=true");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./index.css">
    <title>Homepage</title>
</head>
<body>
    <div class="homepage_navbar">
        <?php require_once "../navbar/navbar.php" ?>
    </div>

    <div class="homepage_slider">
        <?php require "../slider/slider.php"?>
    </div>

    <div class="homepage_content">
        <?php require "../content/content.php"?>
    </div>
</body>

</html>