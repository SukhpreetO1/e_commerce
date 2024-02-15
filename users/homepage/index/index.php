<?php 
session_start();
require_once dirname(__DIR__, 3) . "/common/base_url.php";
require_once dirname(__DIR__, 3) . "/common/config/config.php";
require_once dirname(__DIR__, 3) . "/common/links.php";
require_once dirname(__DIR__, 3) . "/common/alerts/homepage_alerts.php";
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
    <div class="homepage_sidebar">
        <?php require dirname(__DIR__, 2) . "/navbar/navbar.php"?>
    </div>
    <div class="homepage_slider">
        <?php require dirname(__DIR__) . "/slider/slider.php"?>
    </div>

    <div class="homepage_content">
        <?php require dirname(__DIR__) . "/content/content.php"?>
    </div>
</body>

</html>