<link rel="stylesheet" href="<?php echo $_ENV['BASE_URL'] ?>/users/navbar/men_dropdown/men_dropdown_list.css">
<div class="men_list">
    <?php
        $query = "SELECT * FROM categories_heading WHERE clothes_category_id IN (SELECT id FROM categories_heading)";
        $result = mysqli_query($database_connection, $query);

        if ($result) {
            while ($category_heading = mysqli_fetch_assoc($result)) {
                echo "<div class='section_part_1'>
                        <div class='section" . $category_heading['id'] . "'>
                            <h6 class='men_section_heading'>" . $category_heading["name"] . "</h6>
                        </div>
                    </div><br>";
            }
        } else {
            echo "Error executing query: " . mysqli_error($database_connection);
        }

        mysqli_free_result($result);
    ?>
</div>