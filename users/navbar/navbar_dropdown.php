<?php

$query = "SELECT 
cc.id AS clothes_categories_id,
cc.name AS name,
cc.created_at AS created_at,
cc.updated_at AS updated_at,
JSON_ARRAYAGG(
    JSON_OBJECT(
        'categories_heading_id', ch.id,
        'clothes_categories_id', ch.clothes_category_id,
        'name', ch.name,
        'created_at', ch.created_at,
        'updated_at', ch.updated_at,
        'categories_types', (
            SELECT JSON_ARRAYAGG(JSON_OBJECT(
                'categories_type_id', ct.id,
                'category_heading_id', ct.category_heading_id,
                'name', ct.name,
                'description', ct.description,
                'created_at', ct.created_at,
                'updated_at', ct.updated_at
            ))
            FROM categories_type ct
            WHERE ct.category_heading_id = ch.id
        )
    )
) AS categories_heading
FROM 
clothes_categories cc
LEFT JOIN 
categories_heading ch ON cc.id = ch.clothes_category_id
GROUP BY 
cc.id, cc.name, cc.created_at, cc.updated_at";

$result = mysqli_query($database_connection, $query);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories = json_decode($row['categories_heading'], true);
        echo "<div class='nav_item navbar_heading'><a href='#'>" . $row['name'] . "</a>
                  <div class='dropdown_content category_header'>";
                foreach ($categories as $category) {
                    echo "<div class='category_heading_section" . $category['categories_heading_id'] . "'>" . $category['name'] . "<br></div>";
                }
        echo "</div></div>";
    }
}
