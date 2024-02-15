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

// redirection ajax for the category title
$(document).on('click', '.category_title', function (e) {
    e.preventDefault();
    handle_ajax_redirection('/admin/category_title/category_title.php');
});