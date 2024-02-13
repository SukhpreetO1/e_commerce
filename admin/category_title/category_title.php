<?php
require dirname(__DIR__, 2) . "/common/base_url.php";
require dirname(__DIR__, 2) . "/common/config/config.php";
?>

<div class="category_section_page">
    <div class="container">
        <div class="category_title_heading">
            <h2>Category Title</h2>
        </div>

        <div class="add_category_title">
            <a href="#"><i class="fa-solid fa-arrow-left-long category_title_back_button"></i></a>
            <a href="#"><i class="fa-solid fa-plus category_title_plus_icon"></i></a>
        </div>

        <div class="category_title_table">
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
                                <div class="category_title_action">
                                    <div class="category_title_edit">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </div>
                                    <div class="category_title_delete">
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