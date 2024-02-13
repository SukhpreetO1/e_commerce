/*------------------------- Click on sidebar options --------------------------------------*/
function handleAjaxRedirection(url) {
    $.ajax({
        type: 'GET',
        url: BASE_URL + url,
        success: function(data) {
            $('.container').html(data);
        },
        error: function(e) {
            console.log(e);
        }
    });
}

// redirection ajax when click on sidebar text / logo
$(document).on('click', '.title', function(e) {
    e.preventDefault(); 
    handleAjaxRedirection('/admin/homepage/dashboard/dashboard.php');
});

// redirection ajax for the category title
$(document).on('click', '.category_title', function(e) {
    e.preventDefault(); 
    handleAjaxRedirection('/admin/category_title/category_title.php');
});

// redirection ajax for the category header sections
$(document).on('click', '.category_heading', function(e) {
    e.preventDefault(); 
    handleAjaxRedirection('/admin/category_header/category_header.php');
});



/*------------------------- Click on submit button in add files JS --------------------------------------*/
// when submit the add category title the validations are given below
$(document).on('submit', '.add_category_title_form', function(e) {
    e.preventDefault();
    var category_name = $('#add_category_title_input_name').val();
    if (category_name.trim() === '') {
        $('#add_category_title_name_err').text('Category name is required');
        return;
    }
});






/*------------------------- Click on + to add JS --------------------------------------*/
function handleIconClick(url) {
    $.ajax({
        type: 'GET',
        url: BASE_URL + url,
        success: function(data) {
            $('.container').html(data);
        },
        error: function(e) {
            console.log(e);
        }
    });
}

// redirection ajax for adding the category title
$(document).on('click', '.category_title_plus_icon', function(e) {
    e.preventDefault(); 
    handleIconClick('/admin/category_title/add_category_title.php');
});

// redirection ajax for adding the category header
$(document).on('click', '.category_header_plus_icon', function(e) {
    e.preventDefault(); 
    handleIconClick('/admin/category_header/add_category_header.php');
});






/*------------------------- Back Button JS --------------------------------------*/
function handleButtonClick(url, e) {
    e.preventDefault();
    $.ajax({
        type: 'GET',
        url: BASE_URL + url,
        success: function(data) {
            var container = $('.container');
            if (!$(data).find('.homepage_header').length) {
                container.html(data);
            }
        },
        error: function(e) {
            console.log(e);
        }
    });
}

// redirection ajax for back button the category sections
$(document).on('click', '.category_title_back_button', function(e) {
    handleButtonClick('/admin/homepage/dashboard/dashboard.php', e);
});

// redirection ajax for back button the category header
$(document).on('click', '.category_header_back_button', function(e) {
    handleButtonClick('/admin/homepage/dashboard/dashboard.php', e);
});





/*------------------------- Back Button JS on ADD PAGES --------------------------------------*/
function handleButtonClick(url, e) {
    e.preventDefault();
    $.ajax({
        type: 'GET',
        url: BASE_URL + url,
        success: function(data) {
            var container = $('.container');
            if (!$(data).find('.homepage_header').length) {
                container.html(data);
            }
        },
        error: function(e) {
            console.log(e);
        }
    });
}

// redirection ajax for back button the add category title
$(document).on('click', '.add_category_title_back_button', function(e) {
    handleButtonClick('/admin/category_title/category_title.php', e);
});

// redirection ajax for back button the add category header
$(document).on('click', '.add_category_header_back_button', function(e) {
    handleButtonClick('/admin/category_header/category_header.php', e);
});