<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    echo '<div id="accountLoggedAlert" class="alert alert-success alert-dismissible fade show" role="alert">
            Login Successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    unset($_SESSION['loggedin']);
    echo '<script>
            console.log("Script is running");
            setTimeout(function(){
                console.log("Removing alert");
                var alertElement = document.getElementById("accountLoggedAlert");
                if (alertElement) {
                    alertElement.remove();
                } else {
                    console.log("Alert element not found");
                }
            }, 3000);
          </script>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once "../common/links.php" ?>
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