<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
include dirname(__DIR__, 2) . "/category_header/add_category_header/add_category_header_php.php";
?>

<div class="category_heading_page">
    <div class="alert_container" id="alert_container"></div>
    <div class="container">
        <div class="category_header_title">
            <h2>Add Category Header</h2>
        </div>

        <div class="add_category_header">
            <a href="#"><i class="fa-solid fa-arrow-left-long add_category_header_back_button"></i></a>
        </div>

        <div class="add_category_header_names">
            <div class="add_section">
                <form method="post" id="add_category_header_form" class="add_category_header_form">
                    <div class="form-group category_header_dropdown">
                        <label for="add_category_header_input_title" class="add_category_header_title mt-2 mb-2">Title Name <span class="important_mark">*</span></label>
                        <select class="form-select add_category_header_input_title" id="add_category_header_input_title" aria-label="Select Category Title Name" name="add_category_header_input_title">
                            <option hidden disabled selected>Select Category Title Name</option>
                            <?php
                            $sql = "SELECT * FROM clothes_categories";
                            $result = $database_connection->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                            <?php
                                }
                            }
                            $database_connection->close();
                            ?>
                        </select>
                        <span class="invalid-feedback add_category_header_title_err" id="add_category_header_title_err"><?php echo $add_category_header_title_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="add_category_header_input_name" class="add_category_header_name mt-2 mb-2">Header Name <span class="important_mark">*</span></label>
                        <input type="text" name="add_category_header_input_name" class="form-control add_category_header_input_name" id="add_category_header_input_name">
                        <span class="invalid-feedback add_category_header_name_err" id="add_category_header_name_err"><?php echo $add_category_header_name_err; ?></span>
                    </div>
                    <div class="add_category_header_name_button">
                        <button type="submit" name="create_category_heading" class="btn btn-primary mt-2 create_category_heading" id="create_category_heading" value="Create Category Header">Create Header</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    /*--------------------------------------------------------------- Validation for submit button and input in add files ----------------------------------------------------------------------------*/
    function validate_category_name() {
        var category_name = $('#add_category_header_input_name').val();
        var error_messages = '';
        if (category_name.trim() === '') {
            error_messages = 'Category header name is required.';
        } else if (category_name.length < 3 || category_name.length > 15) {
            error_messages = 'Category header name must be between 3 and 15 characters long.';
        } else if (!/^[a-zA-Z\s]+$/.test(category_name)) {
            error_messages = 'Only alphabets are allowed.';
        }
        $('.add_category_header_name_err').text(error_messages);
        return error_messages === '';
    }

    function validate_category_title() {
        var selected_value = $('.add_category_header_input_title').val();
        var error_messages = '';
        if (selected_value === '' || selected_value === null) {
            error_messages = 'Category title is required.';
        }
        $('.add_category_header_title_err').text(error_messages);
        return error_messages === '';
    }

    // when submit the new category header file
    $(document).off('submit', '#add_category_header_form').on('submit', '#add_category_header_form', function(e) {
        e.preventDefault();
        var isNameValid = validate_category_name();
        var isTitleValid = validate_category_title();
        if (!isNameValid || !isTitleValid) {
            return false;
        } else {
            var formData = $(this).serialize();
            var parsed_response = null;
            $.ajax({
                type: "POST",
                url: BASE_URL + "/admin/category_header/add_category_header/add_category_header_php.php",
                data: formData,
                success: function(response) {
                    if (response.trim() === "") {
                        var alert_message = '<div class="alert alert-danger category_header_alert_dismissible" role="alert">Category header not saved.</div>';
                        $('#alert_container').append(alert_message);
                        setTimeout(function() {
                            $('.alert').remove();
                        }, 3000);
                    } else {
                        if (parsed_response) {
                            parsed_response = null;
                        } else {
                            parsed_response = JSON.parse(response);
                            if (parsed_response.error) {
                                var alert_message = '<div class="alert alert-danger category_header_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                                $('#alert_container').append(alert_message);
                                setTimeout(function() {
                                    $('.alert').remove();
                                }, 3000);
                            } else {
                                $.ajax({
                                    url: BASE_URL + '/admin/category_header/category_header.php',
                                    type: 'GET',
                                    success: function(data) {
                                        $(".container").empty();
                                        $('.container').html(data);
                                        var alert_message = '<div class="alert alert-success category_header_success_dismissible" role="alert">' + parsed_response.success + '</div>';
                                        $('#alert_container').append(alert_message);
                                        setTimeout(function() {
                                            $('.alert').remove();
                                        }, 2000);
                                    },
                                    error: function(xhr, status, error) {
                                        console.log(error);
                                    }
                                });
                            }
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Error" + error);
                }
            });
        }
    });

    // when click on the new category header input field
    $(document).on('click', '#add_category_header_form', function(e) {
        var isNameValid = validate_category_name();
        var isTitleValid = validate_category_title();
        if (!isNameValid || !isTitleValid) {
            return false;
        }
    });

    // when input the new category header field
    $(document).on('input', '#add_category_header_form', function(e) {
        var isNameValid = validate_category_name();
        if (!isNameValid) {
            return false;
        }
    });

    /*--------------------------------------------------------------- Back Button JS on ADD PAGES ----------------------------------------------------------------------------*/
    function handle_back_button_in_add_page(url) {
        $.ajax({
            type: 'GET',
            url: BASE_URL + url,
            success: function(data) {
                $(".container").empty();
                $('.container').html(data);
            },
            error: function(e) {
                console.log(e);
            }
        });
    }

    // redirection ajax for back button the add category header
    $(document).off('click', '.add_category_header_back_button').on('click', '.add_category_header_back_button', function(e) {
        e.preventDefault();
        handle_back_button_in_add_page('/admin/category_header/category_header.php');
    });
</script>