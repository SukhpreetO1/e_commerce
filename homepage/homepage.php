<?php require_once "../common/links.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../common/common.css">
    <title>Homepage</title>
</head>
<body>
    <div class="homepage_navbar">
        <?php require_once "./navbar.php" ?>
    </div>

    <div class="homepage_slider">
        <?php require "./slider.php"?>
    </div>

    <div class="homepage_content">
        <?php require "./content.php"?>
    </div>
</body>

</html>