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

$(document).ready(function () {
    var click_events = [
        { selector: '.title', url: '/homepage/dashboard/dashboard', param: 'tab=dashboard' },
        { selector: '.dashboard', url: '/homepage/dashboard/dashboard', param: 'tab=dashboard' },
        { selector: '.dashboard_category', url: '/homepage/dashboard_category/dashboard_category', param: 'tab=dashboard_category' },
        { selector: '.brands', url: '/brands/brands', param: 'tab=brands' },
        { selector: '.size', url: '/size/size', param: 'tab=size' },
        { selector: '.color', url: '/color/color', param: 'tab=color' },
        { selector: '.discount', url: '/discount/discount', param: 'tab=discount' },
        { selector: '.products', url: '/products/products', param: 'tab=products' },
        { selector: '.roles', url: '/roles/roles', param: 'tab=roles' },
        { selector: '.users', url: '/user_detail/user_detail', param: 'tab=user_detail' },
        { selector: '.category_title', url: '/category_title/category_title', param: 'tab=category_title' },
        { selector: '.category_header', url: '/category_header/category_header', param: 'tab=category_header' },
        { selector: '.categories_types', url: '/category_types/category_types', param: 'tab=categories_types' },
        { selector: '.admin_detail', url: '/admin_detail/admin_detail', param: 'tab=admin_detail' }
    ];

    click_events.forEach(function (event) {
        $(document).on('click', event.selector, function (e) {
            e.preventDefault();
            add_background_color(this);
            handle_redirection_and_push_state(event.url, event.param);
        });
    });

    var query_param_mappings = {
        'dashboard': ['/admin/homepage/dashboard/dashboard.php', '.dashboard'],
        'dashboard_category': ['/admin/homepage/dashboard_category/dashboard_category.php', '.dashboard_category'],
        'brands': ['/admin/brands/brands.php', '.brands'],
        'add_brands': ['/admin/brands/add_brands/add_brands.php', '.brands'],
        'size': ['/admin/size/size.php', '.size'],
        'add_size': ['/admin/size/add_size/add_size.php', '.size'],
        'color': ['/admin/color/color.php', '.color'],
        'add_color': ['/admin/color/add_color/add_color.php', '.color'],
        'discount': ['/admin/discount/discount.php', '.discount'],
        'add_discount': ['/admin/discount/add_discount/add_discount.php', '.discount'],
        'products': ['/admin/products/products.php', '.products'],
        'add_products': ['/admin/products/add_products/add_products.php', '.products'],
        'roles': ['/admin/roles/roles.php', '.roles'],
        'add_roles': ['/admin/roles/add_roles/add_roles.php', '.roles'],
        'user_detail': ['/admin/user_detail/user_detail.php', '.users'],
        'category_title': ['/admin/category_title/category_title.php', '.category_title'],
        'add_category_title': ['/admin/category_title/add_category_title/add_category_title.php', '.category_title'],
        'category_header': ['/admin/category_header/category_header.php', '.category_header'],
        'add_category_header': ['/admin/category_header/add_category_header/add_category_header.php', '.category_header'],
        'categories_types': ['/admin/category_types/category_types.php', '.categories_types'],
        'add_categories_types': ['/admin/category_types/add_category_types/add_category_types.php', '.categories_types'],
        'admin_detail': ['/admin/admin_detail/admin_detail.php', null] // No background color specified
    };

    var query_param = window.location.search;
    for (var param in query_param_mappings) {
        if (query_param.includes('=' + param)) {
            var url = query_param_mappings[param][0];
            var bgColorClass = query_param_mappings[param][1];
            handle_ajax_redirection(url, function () {
                if (bgColorClass) {
                    add_background_color(bgColorClass);
                }
            });
            break;
        }
    }
});
