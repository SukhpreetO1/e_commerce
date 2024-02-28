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

function handle_redirection_and_push_state(urlPath, urlName) {
    handle_ajax_redirection('/admin' + urlPath + '.php');
    var newUrl = BASE_URL + '/admin/homepage/index/index.php?' + urlName;
    history.pushState(null, null, newUrl);
}

// redirection ajax when click on sidebar text / logo
$(document).on('click', '.title', function (e) {
    e.preventDefault();
    handle_redirection_and_push_state('/homepage/dashboard/dashboard', 'tab=dashboard');
});

// redirection ajax when click on dashboard
$(document).on('click', '.dashboard', function (e) {
    e.preventDefault();
    handle_redirection_and_push_state('/homepage/dashboard/dashboard', 'tab=dashboard');
});

// redirection ajax when click on brands
$(document).on('click', '.brands', function (e) {
    e.preventDefault();
    handle_redirection_and_push_state('/brands/brands', 'tab=brands');
});

// redirection ajax when click on size
$(document).on('click', '.size', function (e) {
    e.preventDefault();
    handle_redirection_and_push_state('/size/size', 'tab=size');
});

// redirection ajax when click on color
$(document).on('click', '.color', function (e) {
    e.preventDefault();
    handle_redirection_and_push_state('/color/color', 'tab=color');
});

// redirection ajax when click on discount
$(document).on('click', '.discount', function (e) {
    e.preventDefault();
    handle_redirection_and_push_state('/discount/discount', 'tab=discount');
});

// redirection ajax when click on products
$(document).on('click', '.products', function (e) {
    e.preventDefault();
    handle_redirection_and_push_state('/products/products', 'tab=products');
});

// redirection ajax for the user detials
$(document).on('click', '.roles', function (e) {
    e.preventDefault();
    handle_redirection_and_push_state('/roles/roles', 'tab=roles');
});

// redirection ajax for the user detials
$(document).on('click', '.users', function (e) {
    e.preventDefault();
    handle_redirection_and_push_state('/user_detail/user_detail', 'tab=user_detail');
});

// redirection ajax for the category title
$(document).on('click', '.category_title', function (e) {
    e.preventDefault();
    handle_redirection_and_push_state('/category_title/category_title', 'tab=category_title');
});

// redirection ajax for the category heading
$(document).on('click', '.category_heading', function (e) {
    e.preventDefault();
    handle_redirection_and_push_state('/category_header/category_header', 'tab=category_header');
});

// redirection ajax for the category types
$(document).on('click', '.categories_types', function (e) {
    e.preventDefault();
    handle_redirection_and_push_state('/category_types/category_types', 'tab=category_types');
});

$(document).ready(function () {
    var query_param = window.location.search;
    if (query_param.includes('dashboard')) {
        handle_ajax_redirection('/admin/homepage/dashboard/dashboard.php');
    } else if (query_param.includes('brands')) {
        handle_ajax_redirection('/admin/brands/brands.php');
    } else if (query_param.includes('size')) {
        handle_ajax_redirection('/admin/size/size.php');
    } else if (query_param.includes('color')) {
        handle_ajax_redirection('/admin/color/color.php');
    } else if (query_param.includes('discount')) {
        handle_ajax_redirection('/admin/discount/discount.php');
    } else if (query_param.includes('products')) {
        handle_ajax_redirection('/admin/products/products.php');
    } else if (query_param.includes('roles')) {
        handle_ajax_redirection('/admin/roles/roles.php');
    } else if (query_param.includes('user_detail')) {
        handle_ajax_redirection('/admin/user_detail/user_detail.php');
    } else if (query_param.includes('category_title')) {
        handle_ajax_redirection('/admin/category_title/category_title.php');
    } else if (query_param.includes('category_header')) {
        handle_ajax_redirection('/admin/category_header/category_header.php');
    } else if (query_param.includes('category_types')) {
        handle_ajax_redirection('/admin/category_types/category_types.php');
    }
});