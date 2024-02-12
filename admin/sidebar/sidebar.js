// redirection ajax for the type sections
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

// redirection ajax for title page when click on the sidebar text
// $('.title').click(function(e) {
//     e.preventDefault(); 
//     $.ajax({
//         type: 'GET',
//         url: BASE_URL + '/admin/homepage/index/index.php',
//         success: function(data) {
//             $('.homepage_section').html(data);
//         },
//         error: function(e) {
//             console.log(e);
//         }
//     });
// });