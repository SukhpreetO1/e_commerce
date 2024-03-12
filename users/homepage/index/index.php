<?php
require_once dirname(__DIR__, 3) . "/common/alerts/homepage_alerts.php";
require_once dirname(__DIR__, 3) . "/common/base_url.php";
require_once dirname(__DIR__, 3) . "/common/config/config.php";
require_once dirname(__DIR__, 3) . "/common/links.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $_ENV['BASE_URL'] ?>/public/assets/css/user_index.css">
    <title>Homepage</title>
</head>

<body>
    <div class="container">
        <div class="homepage_navbar">
            <?php require dirname(__DIR__, 2) . "/navbar/navbar.php" ?>
        </div>
        <?php
        $sql = "SELECT * FROM dashboard_category";
        $result = $database_connection->query($sql);
        if ($result->num_rows > 0) {
            $category_ids = [];
            while ($dashboard_category_data = $result->fetch_assoc()) {
                $category_id = $dashboard_category_data['id'];
                $category_ids[] = $category_id;
            }

            $file_paths = [
                dirname(__DIR__, 2) . "/homepage/banner/banner.php",
                dirname(__DIR__, 2) . "/homepage/content/content.php",
            ];

            foreach ($category_ids as $index => $category_id) {
                echo '<input type="hidden" class="dashboard_category_id" value="' . $category_id . '">';
                if (isset($file_paths[$index])) {
                    include $file_paths[$index];
                }
            }
        }
        ?>
    </div>
</body>

</html>