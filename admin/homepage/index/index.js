$(document).ready(function () {
    $.ajax({
        url: BASE_URL + '/admin/sidebar/sidebar.php',
        type: 'GET',
        success: function (data) {
            var modified_data = data.replace('BASE_URL_PLACEHOLDER', BASE_URL);
            modified_data = modified_data.replace('img src="#"', 'img src="' + BASE_URL + '/public/assets/images/m_letter.svg"');
            modified_data = $(modified_data).find('.dropdown-menu a').attr('href', BASE_URL + '/common/logout.php').end().html();
            $('.homepage_header').html(modified_data);
        }
    });
});

/*------------------------- Sidebar options --------------------------------------*/
function handle_ajax_redirection(url) {
    $.ajax({
        type: 'GET',
        url: BASE_URL + url,
        success: function (data) {
            $('.container').html(data);
        },
        error: function (e) {
            console.log(e);
        }
    });
}

// redirection ajax when click on sidebar text / logo
$(document).on('click', '.title', function (e) {
    e.preventDefault();
    handle_ajax_redirection('/admin/homepage/dashboard/dashboard.php');
});

// redirection ajax for the category title
$(document).on('click', '.category_title', function (e) {
    e.preventDefault();
    handle_ajax_redirection('/admin/category_title/category_title.php');
});

// redirection ajax for the category header sections
$(document).on('click', '.category_heading', function (e) {
    e.preventDefault();
    handle_ajax_redirection('/admin/category_header/category_header.php');
});



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







/*------------------------- Click on plus (+) JS --------------------------------------*/
function handle_icon_click(url) {
    $.ajax({
        type: 'GET',
        url: BASE_URL + url,
        success: function (data) {
            $('.container').html(data);
        },
        error: function (e) {
            console.log(e);
        }
    });
}

// redirection ajax for adding the category title
$(document).on('click', '.category_title_plus_icon', function (e) {
    e.preventDefault();
    handle_icon_click('/admin/category_title/add_category_title.php');
});

// redirection ajax for adding the category header
$(document).on('click', '.category_header_plus_icon', function (e) {
    e.preventDefault();
    handle_icon_click('/admin/category_header/add_category_header.php');
});






/*------------------------- Click on Edit Button JS --------------------------------------*/
function handle_icon_click(url) {
    $.ajax({
        type: 'GET',
        url: BASE_URL + url,
        success: function (data) {
            $('.container').html(data);
        },
        error: function (e) {
            console.log(e);
        }
    });
}

// redirection ajax for adding the category title
$(document).on('click', '.category_title_edit', function (e) {
    e.preventDefault();
    handle_icon_click('/admin/category_title/edit_category_title.php');
});

// redirection ajax for adding the category header
$(document).on('click', '.category_header_edit', function (e) {
    e.preventDefault();
    handle_icon_click('/admin/category_header/edit_category_header.php');
});






/*------------------------- Back Button JS on dashboard --------------------------------------*/
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

// redirection ajax for back button the category sections
$(document).on('click', '.category_title_back_button', function (e) {
    handleButtonClick('/admin/homepage/dashboard/dashboard.php', e);
});

// redirection ajax for back button the category header
$(document).on('click', '.category_header_back_button', function (e) {
    handleButtonClick('/admin/homepage/dashboard/dashboard.php', e);
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

// redirection ajax for back button the add category header
$(document).on('click', '.add_category_header_back_button', function (e) {
    handleButtonClick('/admin/category_header/category_header.php', e);
});







/*------------------------- Back Button JS on edit pages --------------------------------------*/
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

// redirection ajax for back button the category sections
$(document).on('click', '.edit_category_title_back_button', function (e) {
    handleButtonClick('/admin/category_title/category_title.php', e);
});

// redirection ajax for back button the category header
$(document).on('click', '.edit_category_header_back_button', function (e) {
    handleButtonClick('/admin/category_header/category_header.php', e);
});



