$(document).ready(function() {
    $('#add_categories_section_form').submit(function(e) {
        e.preventDefault();
        var categoryName = $('#add_categories_section_input_name').val();
        console.log(categoryName);
        if (categoryName.trim() === '') {
            $('#add_categories_section_name_err').text('Category name is required');
            return;
        }
    });
});