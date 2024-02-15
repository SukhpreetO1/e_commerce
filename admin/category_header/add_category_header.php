
<link rel="stylesheet" href="<?php echo $_ENV['BASE_URL'] ?>/admin/category_header/add_category_header/add_category_header.css">
<div class="category_heading_page">
    <div class="container">
        <div class="category_header_title">
            <h2>Add Category Header</h2>
        </div>

        <div class="add_category_title">
            <a href="#"><i class="fa-solid fa-arrow-left-long add_category_header_back_button"></i></a>
        </div>

        <div class="add_category_header_names">
            <div class="add_section">
                <form method="post" id="add_category_header_form" class="add_category_header_form">
                    <div class="form-group">
                        <label for="add_category_header_input_name" class="add_category_header_name mt-2 mb-2">Header Name <span class="important_mark">*</span></label>
                        <input type="text" name="add_category_header_input_name" class="form-control add_category_header_input_name" id="add_category_header_input_name">
                        <span class="invalid-feedback " id="add_category_header_name_err"><?php echo $add_category_header_name_err; ?></span>
                    </div>
                    <div class="add_category_header_name_button">
                        <button type="submit" name="create_category_heading" class="btn btn-primary mt-2 create_category_heading" id="create_category_heading" value="Create Category Header">Create Header</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
