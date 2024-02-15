<?php

$query = "SELECT 
cc.id AS clothes_categories_id,
cc.name AS name,
cc.created_at AS created_at,
cc.updated_at AS updated_at,
JSON_ARRAYAGG(
    JSON_OBJECT(
        'category_header_id', ch.id,
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
) AS category_header
FROM 
clothes_categories cc
LEFT JOIN 
categories_heading ch ON cc.id = ch.clothes_category_id
GROUP BY 
cc.id, cc.name, cc.created_at, cc.updated_at";

$result = mysqli_query($database_connection, $query);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $category_title = json_decode($row['category_header'], true);
        echo "<div class='nav_item navbar_heading'><a href='#'>" . $row['name'] . "</a>
            <div class='dropdown_content category_header'>";
        $current_pair = [];
        foreach ($category_title as $category) {
            if (!empty($category['categories_types'])) {
                if (count($current_pair) < 2) {
                    $current_pair[] = $category;
                } else {
                    display_category_pair($current_pair);
                    $current_pair = [$category];
                }
            } else {
                $current_pair[] = $category;
                if (count($current_pair) == 6) {
                    display_category_pair($current_pair);
                    $current_pair = [];
                }
            }
        }
        
        if (!empty($current_pair)) {
            display_category_pair($current_pair);
        }
        echo "</div></div>";
    }
}

function display_category_pair($pair) {
    echo "<div class='category_pair'>";
    foreach ($pair as $category) {
        echo "<div class='category_heading category_heading_section_" . $category['category_header_id'] . "'><span class='mb-2'>" . $category['name'] . "</span>";
        foreach ($category['categories_types'] as $categoryType) {
            echo "<div class='category_type category_type_" . $categoryType['categories_type_id'] . "'>" . $categoryType['name'] . "<br></div>";
        }
        echo "<br></div>";
    }
    echo "</div>";
}