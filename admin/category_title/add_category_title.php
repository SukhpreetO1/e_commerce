<div class="category_section_page">
    <div class="container">
        <div class="category_title_heading">
            <h2>Add Category</h2>
        </div>

        <div class="add_category_title">
            <a href="#"><i class="fa-solid fa-arrow-left-long add_category_title_back_button"></i></a>
        </div>

        <div class="add_category_name">
            <div class="add_section">
                <form method="post" id="add_category_title_form" class="add_category_title_form">
                    <div class="form-group">
                        <label for="add_category_title_input_name" class="add_category_title_name mt-2 mb-2">Category Name <span class="important_mark">*</span></label>
                        <input type="text" name="add_category_title_input_name" class="form-control add_category_title_input_name" id="add_category_title_input_name">
                        <span class="invalid-feedback add_category_title_name_err" id="add_category_title_name_err"><?php echo $add_category_title_name_err; ?></span>
                    </div>
                    <div class="add_category_title_name_button">
                        <button type="submit" name="create_category" class="btn btn-primary mt-2 create_category" id="create_category" value="Create Category">Create Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>