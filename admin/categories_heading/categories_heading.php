<?php
require dirname(__DIR__, 2) . "/common/base_url.php";
require dirname(__DIR__, 2) . "/common/config/config.php";
?>
<div class="categories_heading_page">
    <div class="container">
        <div class="categories_heading">
            <h2>Category Heading</h2>
        </div>

        <div class="add_categories_heading">
            <a href="#"><i class="fa-solid fa-plus categories_heading_plus_icon"></i></a>
        </div>

        <div class="categories_heading_table">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Category Name</th>
                        <th scope="col">Heading Name</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Updated At</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $query = "SELECT 
                                ch.id AS categories_heading_id,
                                ch.name AS categories_heading_name,
                                ch.created_at AS categories_heading_created_at,
                                ch.updated_at AS categories_heading_updated_at,
                                JSON_ARRAYAGG(
                                    JSON_OBJECT(
                                        'clothes_categories_id', cc.id,
                                        'clothes_categories_name', cc.name,
                                        'clothes_categories_created_at', cc.created_at,
                                        'clothes_categories_updated_at', cc.updated_at
                                    )
                                ) AS clothes_categories
                            FROM categories_heading ch
                            LEFT JOIN clothes_categories cc ON cc.id = ch.clothes_category_id
                            GROUP BY ch.id, ch.name, ch.created_at, ch.updated_at";
                    $result = mysqli_query($database_connection, $query);
                    while ($category_data = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?php echo $category_data['categories_heading_id']; ?></td>
                        <td><?php echo json_decode($category_data['clothes_categories'], true)[0]['clothes_categories_name']; ?></td>
                        <td><?php echo $category_data['categories_heading_name']; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($category_data['categories_heading_created_at'])); ?></td>
                        <td><?php echo date('d-m-Y', strtotime($category_data['categories_heading_updated_at'])); ?></td>
                        <td>
                            <div class="categories_heading_action">
                                <div class="categories_heading_edit">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </div>
                                <div class="categories_heading_delete">
                                    <i class="fa-regular fa-trash-can"></i>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="<?php echo $_ENV['BASE_URL'] ?>/admin/homepage/index/index.js"></script>