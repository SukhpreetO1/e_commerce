<?php
$query = "SELECT * FROM categories";
$result = mysqli_query($database_connection, $query);
if ($result) {
   while ($categories = mysqli_fetch_assoc($result)) {
      echo "<div class='nav_item navbar_heading'><a href='#'>" . $categories['name'] . "</a>";
      echo "<div class='dropdown_content category_header'>";

      $categories_id = $categories['id'];
      $categories_heading_query = "SELECT * FROM categories_heading WHERE categories_id = $categories_id";
      $categories_heading_result = mysqli_query($database_connection, $categories_heading_query);

      if ($categories_heading_result) {
         $group_sizes = [
            1 => [2, 3, 4, 2, 3],
            2 => [3, 2, 4, 2, 5],
            3 => [1, 1, 2, 3, 2],
            4 => [2, 2, 3, 3, 1],
            5 => [1, 3, 2, 5, 1]
         ];

         $group_index = 0;
         $group_count = 0;

         while ($heading_row = mysqli_fetch_assoc($categories_heading_result)) {
            $current_group_sizes = $group_sizes[$categories_id];
            if ($group_count == 0) {
               echo "<div class='category_heading_group'>";
            }
            echo "<div class='category_heading'><a href='#' class='category_heading_name' style='color: " . ($heading_row['categories_id'] == 1 ? '#ee5f73' : ($heading_row['categories_id'] == 2 ? '#fb56c1' : ($heading_row['categories_id'] == 3 ? '#f26a10' : ($heading_row['categories_id'] == 4 ? '#f2c210' : ($heading_row['categories_id'] == 5 ? '#0db7af' : 'black'))))) . "'>" . $heading_row['name'];
            echo "<div class='category_types'>";

            $categories_heading_id = $heading_row['id'];
            $categories_type_query = "SELECT * FROM categories_type WHERE category_heading_id = $categories_heading_id";
            $categories_type_result = mysqli_query($database_connection, $categories_type_query);
            if ($categories_type_result) {
               while ($type_row = mysqli_fetch_assoc($categories_type_result)) {
                  echo "<div class='category_type'><a href='#'>" . $type_row['name'] . "</a></div>";
               }
            }
            echo "</div>";
            echo "</a></div>";
            $group_count++;

            if ($group_count == $current_group_sizes[$group_index]) {
               echo "</div>";
               $group_count = 0;
               $group_index++;
            }
         }
         if ($group_count > 0) {
            echo "</div>";
         }
      }
      echo "</div></div>";
   }
}
