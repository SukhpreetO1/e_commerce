<link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>/users/navbar/men_dropdown/men_dropdown_list.css">
<div class="men_list">
    <?php
        $query = "SELECT * FROM categories_heading WHERE clothes_category_id IN (SELECT id FROM categories_heading)";
        $result = mysqli_query($database_connection, $query);
        $headings_per_section = array(2, 3, 4, 2, 3);
        if ($result) {
            foreach ($headings_per_section as $count) {
                echo "<div class='custom_section_group'>";
                for ($i = 0; $i < $count; $i++) {
                    if ($category_heading = mysqli_fetch_assoc($result)) {
                        echo "<div class='section" . $category_heading['id'] . "'><h6 class='men_section_heading'>" . $category_heading["name"] . "</h6></div>";
                    }
                }
                echo "</div><br>";
            }
        } else {
            echo "Error executing query: " . mysqli_error($database_connection);
        }

        mysqli_free_result($result);
    ?>
</div>