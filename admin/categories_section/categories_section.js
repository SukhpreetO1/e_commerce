// redirection ajax for adding the category sections
$('.plus_icon').click(function(e) {
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