$(document).ready(function () {
    $.ajax({
        url: BASE_URL + '/admin/sidebar/sidebar.php',
        type: 'GET',
        success: function (data) {
            var modified_data = data.replace('BASE_URL_PLACEHOLDER', BASE_URL);
            modified_data = modified_data.replace('img src="#"', 'img src="' + BASE_URL + '/public/assets/images/m_letter.svg"');
            modified_data = $(modified_data).find('.dropdown-menu a').attr('href', BASE_URL + '/common/logout.php').end().html();
            $('.homepage_sidebar').html(modified_data);
        }
    });
});

/*------------------------- Sidebar options --------------------------------------*/
function handle_ajax_redirection(url) {
    $.ajax({
        type: 'GET',
        url: BASE_URL + url,
        success: function (data) {
            $('.container').empty();
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

// redirection ajax when click on dashboard
$(document).on('click', '.dashboard', function (e) {
    e.preventDefault();
    handle_ajax_redirection('/admin/homepage/dashboard/dashboard.php');
});

// redirection ajax when click on dashboard
$(document).on('click', '.products', function (e) {
    e.preventDefault();
    handle_ajax_redirection('/admin/products/products.php');
});

// redirection ajax for the user detials
$(document).on('click', '.users', function (e) {
    e.preventDefault();
    handle_ajax_redirection('/admin/user_detail/user_detail.php');
});

// redirection ajax for the user detials
$(document).on('click', '.roles', function (e) {
    e.preventDefault();
    handle_ajax_redirection('/admin/roles/roles.php');
});

// redirection ajax for the category title
$(document).on('click', '.category_title', function (e) {
    e.preventDefault();
    handle_ajax_redirection('/admin/category_title/category_title.php');
});

// redirection ajax for the category heading
$(document).on('click', '.category_heading', function (e) {
    e.preventDefault();
    handle_ajax_redirection('/admin/category_header/category_header.php');
});

// redirection ajax for the category types
$(document).on('click', '.categories_types', function (e) {
    e.preventDefault();
    handle_ajax_redirection('/admin/category_types/category_types.php');
});