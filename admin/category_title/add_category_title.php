<script>console.log('4656456456');</script>
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
                <form method="post" id="add_category_title_form" class="add_category_title_form"
                    action="#">
                    <div class="form-group">
                        <label for="add_category_title_input_name" class="add_category_title_name mt-2 mb-2">Category
                            Name <span class="important_mark">*</span></label>
                        <input type="text" name="add_category_title_input_name"
                            class="form-control add_category_title_input_name" id="add_category_title_input_name">
                        <span class="invalid-feedback add_category_title_name_err"
                            id="add_category_title_name_err"></span>
                    </div>
                    <div class="add_category_title_name_button">
                        <button type="submit" name="create_category" class="btn btn-primary mt-2 create_category"
                            id="create_category" value="Create Category">Create Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript"> 
    /*------------------------- Validation for submit button and input in add files --------------------------------------*/
    function validate_category_name() {
        var category_name = $('#add_category_title_input_name').val();
        var error_messages = '';
        if (category_name.trim() === '') {
            error_messages = 'Category name is required.';
        } else if (category_name.length < 3 || category_name.length > 10) {
            error_messages = 'Category name must be between 3 and 10 characters long.';
        } else if (!/^[a-zA-Z]+$/.test(category_name)) {
            error_messages = 'Only alphabets are allowed.';
        }
        $('.add_category_title_name_err').text(error_messages);
        return error_messages === '';
    }

    // when submit the new category title file
    $(document).on('submit', '#add_category_title_form', function (e) {
        if (!validate_category_name()) {
            return false;
        } else {
            var formData = $(this).serialize();
            $.ajax({
                type: "POST",
                url: BASE_URL + "/admin/category_title/add_category_title_php.php",
                data: formData,
                success: function (response) {
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        }
    });

    // when click on the new category title input field
    $(document).on('click', '#add_category_title_form', function (e) {
        if (!validate_category_name()) {
            return false;
        }
    });

    // when input the new category title field
    $(document).on('input', '#add_category_title_form', function (e) {
        if (!validate_category_name()) {
            return false;
        }
    });

    /*------------------------- Back Button JS on ADD PAGES --------------------------------------*/
    function handleButtonClick(url, e) {
        e.preventDefault();
        $.ajax({
            type: 'GET',
            url: BASE_URL + url,
            success: function (data) {
                var container = $('.container');
                if (!$(data).find('.homepage_header').length) {
                    container.html(data);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    // redirection ajax for back button the add category title
    $(document).on('click', '.add_category_title_back_button', function (e) {
        handleButtonClick('/admin/category_title/category_title.php', e);
    });
</script>