// redirection ajax for the category sections
$('.categories').click(function(e) {
    e.preventDefault(); 
        $.ajax({
        type: 'GET',
        url: BASE_URL + '/admin/categories_section/categories_section.php',
        success: function(data) {
            $('.container').html(data);
        },
        error: function(e) {
            console.log(e);
        }
    });
});

// redirection ajax for adding the category sections
$('.categories_section_plus_icon').click(function(e) {
    e.preventDefault(); 
        $.ajax({
        type: 'GET',
        url: BASE_URL + '/admin/categories_section/add_categories_section/add_categories_section.php',
        success: function(data) {
            $('.container').html(data);
        },
        error: function(e) {
            console.log(e);
        }
    });
});

// redirection ajax for the categories heading sections
$('.sub_categories').click(function(e) {
    e.preventDefault(); 
        $.ajax({
        type: 'GET',
        url: BASE_URL + '/admin/categories_heading/categories_heading.php',
        success: function(data) {
            $('.container').html(data);
        },
        error: function(e) {
            console.log(e);
        }
    });
});

// redirection ajax for adding the category heading section
$('.categories_heading_plus_icon').click(function(e) {
    e.preventDefault(); 
        $.ajax({
        type: 'GET',
        url: BASE_URL + '/admin/categories_heading/add_categories_heading/add_categories_heading.php',
        success: function(data) {
            $('.container').html(data);
        },
        error: function(e) {
            console.log(e);
        }
    });
});