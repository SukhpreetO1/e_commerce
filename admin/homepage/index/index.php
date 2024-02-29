<?php
// require_once dirname(__DIR__, 3) . "/common/session.php";
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
    <link rel="stylesheet" href="<?php echo $_ENV['BASE_URL'] ?>/public/assets/css/index.css">
    <title>Homepage</title>
</head>

<body>
    <div class="homepage_section">
        <div class="homepage_sidebar"></div>

        <div class="container">
            <?php require dirname(__DIR__, 2) . "/homepage/dashboard/dashboard.php" ?>
        </div>
    </div>
    <script src="<?php echo $_ENV['BASE_URL'] ?>/admin/homepage/index/index.js"></script>
</body>

</html>