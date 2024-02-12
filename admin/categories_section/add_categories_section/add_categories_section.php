<link rel="stylesheet" href="<?php echo $_ENV['BASE_URL'] ?>/e_commerce/admin/categories_section/add_categories_section/add_categories_section.css">
<div class="category_section_page">
    <div class="container">
        <div class="categories_section_heading">
            <h2>Add Category</h2>
        </div>

        <div class="add_categories_name">
            <div class="add_section">
                <form method="post" id="add_categories_section_form">
                    <div class="form-group">
                        <label for="add_categories_section_name" class="add_categories_section_name mt-2 mb-2">Category Name :</label>
                        <input type="text" name="add_categories_section_input_name" class="form-control add_categories_section_input_name" id="add_categories_section_input_name">
                        <span class="invalid-feedback" id="add_categories_section_name_err"><?php echo $add_categories_section_name_err; ?></span>
                    </div>
                    <div class="add_categories_section_name_button">
                        <button type="submit" name="create_category" class="btn btn-primary mt-2 create_category" id="create_category" value="Create Category">Create Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo $_ENV['BASE_URL'] ?>/e_commerce/admin/categories_section/add_categories_section/add_categories_section.js"></script>