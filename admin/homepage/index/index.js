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