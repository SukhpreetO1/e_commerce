<?php
    require dirname(__DIR__, 2) . "/common/config/config.php"; 
?>
<div class="category_section_page">
    <div class="container">
        <div class="category_title_heading">
            <h2>Edit Category</h2>
        </div>

        <div class="edit_category_title">
            <a href="#"><i class="fa-solid fa-arrow-left-long edit_category_title_back_button"></i></a>
        </div>

        <?php
        $id = $_GET['category_id'];
        
        $sql = "SELECT * FROM clothes_categories WHERE id = $id";
        $result = $database_connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>

                <div class="edit_category_name">
                    <div class="edit_section">
                        <form method="post" id="edit_category_title_form" class="edit_category_title_form">
                            <div class="form-group">
                                <label for="edit_category_title_input_name" class="edit_category_title_name mt-2 mb-2">Category
                                    Name</label>
                                <input type="text" name="edit_category_title_input_name"
                                    class="form-control edit_category_title_input_name" id="edit_category_title_input_name"
                                    value="<?php echo $row["name"]; ?>">
                                <span class="invalid-feedback edit_category_title_name_err" id="edit_category_title_name_err">
                                </span>
                            </div>
                            <div class="edit_category_title_name_button">
                                <button type="submit" name="create_category" class="btn btn-primary mt-2 create_category"
                                    id="create_category" value="Create Category">Save Category</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
            }
        }
        $database_connection->close();
        ?>
    </div>
</div>