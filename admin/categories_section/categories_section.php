<?php
require dirname(__DIR__, 2) . "/common/base_url.php";
require dirname(__DIR__, 2) . "/common/config/config.php";
?>

<div class="category_section_page">
    <div class="container">
        <div class="categories_section_heading">
            <h2>Category Section</h2>
        </div>

        <div class="add_categories_section">
            <a href="#"><i class="fa-solid fa-plus categories_section_plus_icon"></i></a>
        </div>

        <div class="categories_section_table">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Updated At</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM clothes_categories";
                    $result = mysqli_query($database_connection, $query);

                    while ($category_data = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr scope="col">
                            <td><?php echo $category_data['id']; ?></td>
                            <td><?php echo $category_data['name']; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($category_data['created_at'])); ?></td>
                            <td><?php echo date('d-m-Y', strtotime($category_data['updated_at'])); ?></td>
                            <td>
                                <div class="categories_section_action">
                                    <div class="categories_section_edit">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </div>
                                    <div class="categories_section_delete">
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