$(document).ready(function () {
    $.ajax({
        url: BASE_URL + '/admin/sidebar/sidebar.php',
        type: 'GET',
        success: function (data) {
            var modified_data = data.replace('BASE_URL_PLACEHOLDER', BASE_URL);
            modified_data = modified_data.replace('img src="#"', 'img src="' + BASE_URL + '/public/assets/images/m_letter.svg"');
            modified_data = $(modified_data).find('.dropdown-menu a.logout').attr('href', BASE_URL + '/common/logout.php').end().html();
            $('.homepage_sidebar').html(modified_data);
        }
    });
});

/*------------------------- Sidebar options --------------------------------------*/
function handle_ajax_redirection(url, callback) {
    $.ajax({
        type: 'GET',
        url: BASE_URL + url,
        success: function (data) {
            $('.container').empty();
            $('.container').html(data);
            if (callback && typeof (callback) === "function") {
                callback();
            }
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

function add_background_color(element) {
    $('.size').removeClass('highlighted');
    $('.dashboard').removeClass('highlighted');
    $('.dashboard_category').removeClass('highlighted');
    $('.brands').removeClass('highlighted');
    $('.size').removeClass('highlighted');
    $('.color').removeClass('highlighted');
    $('.discount').removeClass('highlighted');
    $('.products').removeClass('highlighted');
    $('.roles').removeClass('highlighted');
    $('.users').removeClass('highlighted');
    $('.category_title').removeClass('highlighted');
    $('.category_header').removeClass('highlighted');
    $('.categories_types').removeClass('highlighted');
    $(element).addClass('highlighted');
}

// redirection ajax when click on sidebar text / logo
$(document).on('click', '.title', function (e) {
    e.preventDefault();
    handle_redirection_and_push_state('/homepage/dashboard/dashboard', 'tab=dashboard');
});

// redirection ajax when click on dashboard
$(document).on('click', '.dashboard', function (e) {
    e.preventDefault();
    add_background_color(this);
    handle_redirection_and_push_state('/homepage/dashboard/dashboard', 'tab=dashboard');
});

// redirection ajax when click on dashboard category
$(document).on('click', '.dashboard_category', function (e) {
    e.preventDefault();
    add_background_color(this);
    handle_redirection_and_push_state('/homepage/dashboard_category/dashboard_category', 'tab=dashboard_category');
});

// redirection ajax when click on brands
$(document).on('click', '.brands', function (e) {
    e.preventDefault();
    add_background_color(this);
    handle_redirection_and_push_state('/brands/brands', 'tab=brands');
});

// redirection ajax when click on size
$(document).on('click', '.size', function (e) {
    e.preventDefault();
    add_background_color(this);
    handle_redirection_and_push_state('/size/size', 'tab=size');
});

// redirection ajax when click on color
$(document).on('click', '.color', function (e) {
    e.preventDefault();
    add_background_color(this);
    handle_redirection_and_push_state('/color/color', 'tab=color');
});

// redirection ajax when click on discount
$(document).on('click', '.discount', function (e) {
    e.preventDefault();
    add_background_color(this);
    handle_redirection_and_push_state('/discount/discount', 'tab=discount');
});

// redirection ajax when click on products
$(document).on('click', '.products', function (e) {
    e.preventDefault();
    add_background_color(this);
    handle_redirection_and_push_state('/products/products', 'tab=products');
});

// redirection ajax for the user detials
$(document).on('click', '.roles', function (e) {
    e.preventDefault();
    add_background_color(this);
    handle_redirection_and_push_state('/roles/roles', 'tab=roles');
});

// redirection ajax for the user detials
$(document).on('click', '.users', function (e) {
    e.preventDefault();
    add_background_color(this);
    handle_redirection_and_push_state('/user_detail/user_detail', 'tab=user_detail');
});

// redirection ajax for the category title
$(document).on('click', '.category_title', function (e) {
    e.preventDefault();
    add_background_color(this);
    handle_redirection_and_push_state('/category_title/category_title', 'tab=category_title');
});

// redirection ajax for the category heading
$(document).on('click', '.category_header', function (e) {
    e.preventDefault();
    add_background_color(this);
    handle_redirection_and_push_state('/category_header/category_header', 'tab=category_header');
});

// redirection ajax for the category types
$(document).on('click', '.categories_types', function (e) {
    e.preventDefault();
    add_background_color(this);
    handle_redirection_and_push_state('/category_types/category_types', 'tab=categories_types');
});

// redirection ajax for the admin details
$(document).on('click', '.admin_detail', function (e) {
    e.preventDefault();
    add_background_color(this);
    handle_redirection_and_push_state('/admin_detail/admin_detail', 'tab=admin_detail');
});

$(document).ready(function () {
    var query_param = window.location.search;

    if (query_param.includes('=dashboard')) {
        handle_ajax_redirection('/admin/homepage/dashboard/dashboard.php', function () {
            add_background_color('.dashboard');
        });
    } else if (query_param.includes('=dashboard_category')) {
        handle_ajax_redirection('/admin/homepage/dashboard_category/dashboard_category.php', function () {
            add_background_color('.dashboard_category');
        });
    } else if (query_param.includes('=brands')) {
        handle_ajax_redirection('/admin/brands/brands.php', function () {
            add_background_color('.brands');
        });
    } else if (query_param.includes('=add_brands')) {
        handle_ajax_redirection('/admin/brands/add_brands/add_brands.php', function () {
            add_background_color('.brands');
        });
    } else if (query_param.includes('=size')) {
        handle_ajax_redirection('/admin/size/size.php', function () {
            add_background_color('.size');
        });
    } else if (query_param.includes('=add_roles')) {
        handle_ajax_redirection('/admin/size/add_size/add_size.php', function () {
            add_background_color('.size');
        });
    } else if (query_param.includes('=color')) {
        handle_ajax_redirection('/admin/color/color.php', function () {
            add_background_color('.color');
        });
    } else if (query_param.includes('=add_color')) {
        handle_ajax_redirection('/admin/color/add_color/add_color.php', function () {
            add_background_color('.color');
        });
    } else if (query_param.includes('=discount')) {
        handle_ajax_redirection('/admin/discount/discount.php', function () {
            add_background_color('.discount');
        });
    } else if (query_param.includes('=add_discount')) {
        handle_ajax_redirection('/admin/discount/add_discount/add_discount.php', function () {
            add_background_color('.discount');
        });
    } else if (query_param.includes('=products')) {
        handle_ajax_redirection('/admin/products/products.php', function () {
            add_background_color('.products');
        });
    } else if (query_param.includes('=add_products')) {
        handle_ajax_redirection('/admin/products/add_products/add_products.php', function () {
            add_background_color('.products');
        });
    } else if (query_param.includes('=roles')) {
        handle_ajax_redirection('/admin/roles/roles.php', function () {
            add_background_color('.roles');
        });
    } else if (query_param.includes('=add_roles')) {
        handle_ajax_redirection('/admin/roles/add_roles/add_roles.php', function () {
            add_background_color('.roles');
        });
    } else if (query_param.includes('=user_detail')) {
        handle_ajax_redirection('/admin/user_detail/user_detail.php', function () {
            add_background_color('.users');
        });
    } else if (query_param.includes('=category_title')) {
        handle_ajax_redirection('/admin/category_title/category_title.php', function () {
            add_background_color('.category_title');
        });
    } else if (query_param.includes('=add_category_title')) {
        handle_ajax_redirection('/admin/category_title/add_category_title/add_category_title.php', function () {
            add_background_color('.category_title');
        });
    } else if (query_param.includes('=category_header')) {
        handle_ajax_redirection('/admin/category_header/category_header.php', function () {
            add_background_color('.category_header');
        });
    } else if (query_param.includes('=add_category_header')) {
        handle_ajax_redirection('/admin/category_header/add_category_header/add_category_header.php', function () {
            add_background_color('.category_header');
        });
    } else if (query_param.includes('=categories_types')) {
        handle_ajax_redirection('/admin/category_types/category_types.php', function () {
            add_background_color('.categories_types');
        });
    } else if (query_param.includes('=add_categories_types')) {
        handle_ajax_redirection('/admin/category_types/add_category_types/add_category_types.php', function () {
            add_background_color('.categories_types');
        });
    } else if (query_param.includes('=admin_detail')) {
        handle_ajax_redirection('/admin/admin_detail/admin_detail.php', function () {
            // add_background_color('.admin_detail');
        });
    }
});
