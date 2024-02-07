<?php
// $query = "SELECT *
// FROM clothes_categories
// JOIN categories_heading ON clothes_categories.id = categories_heading.clothes_category_id
// JOIN categories_type ON categories_heading.id = categories_type.category_heading_id";

$query = "SELECT *
FROM clothes_categories
JOIN categories_heading ON clothes_categories.id = categories_heading.clothes_category_id
";

$result = mysqli_query($database_connection, $query);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        print_r($row);
        // echo "<div class='nav_item navbar_heading'><a href='#'>" . $row['name'] . "</a></div>";
    }
}
