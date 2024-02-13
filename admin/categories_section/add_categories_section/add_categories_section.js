console.log('here');
$('.add_categories_section_form').submit(function(e) {
    e.preventDefault();
    console.log('asdasdasasd');
    var categoryName = $('#add_categories_section_input_name').val();
    console.log(categoryName);
    if (categoryName.trim() === '') {
        $('#add_categories_section_name_err').text('Category name is required');
        return;
    }
});