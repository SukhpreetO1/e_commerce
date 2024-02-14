<?php
require dirname(__DIR__, 2) . "/common/config/config.php";
?>

<div class="category_section_page">
    <div class="container">
        <div class="category_title_heading">
            <h2>Category Title</h2>
        </div>

        <div class="add_category_title">
            <a href="#"><i class="fa-solid fa-arrow-left-long category_title_back_button"></i></a>
            <a href="#"><i class="fa-solid fa-plus category_title_plus_icon"></i></a>
        </div>

        <div class="category_title_table">
            <table class="category_title_table" id="category_title_table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Updated At</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM clothes_categories";
                    $result = mysqli_query($database_connection, $query);

                    while ($category_data = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr scope="col">
                            <td>
                                <?php echo $category_data['id']; ?>
                            </td>
                            <td>
                                <?php echo $category_data['name']; ?>
                            </td>
                            <td>
                                <?php echo date('d-m-Y', strtotime($category_data['created_at'])); ?>
                            </td>
                            <td>
                                <?php echo date('d-m-Y', strtotime($category_data['updated_at'])); ?>
                            </td>
                            <td>
                                <div class="category_title_action">
                                    <input type="hidden" name="category_id" class="category_id" id="category_id" value="<?php echo $category_data['id']; ?>">
                                    <div class="category_title_edit">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </div>
                                    <div class="category_title_delete">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    /*------------------------- Click on plus (+) JS --------------------------------------*/ 
    function handle_plus_icon_click(url) {
        $.ajax({
            type: 'GET',
            url: BASE_URL + url,
            success: function (data) {
                $(".container").empty();
                $('.container').html(data);
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    // redirection ajax for adding the category title
    $(document).off('click', '.category_title_plus_icon').on('click', '.category_title_plus_icon', function (e) {
        e.preventDefault();
        handle_plus_icon_click('/admin/category_title/add_category_title/add_category_title.php');
    });

    /*------------------------- Click on Edit Button JS --------------------------------------*/
    function handle_edit_icon_click(url, category_id) {
        $.ajax({
            type: 'GET',
            url: BASE_URL + url + '?category_id=' + category_id,
            success: function (data) {
                $(".container").empty();
                $('.container').html(data);
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    // redirection ajax for adding the category title
    $(document).off('click', '.category_title_edit').on('click', '.category_title_edit', function (e) {
        e.preventDefault();
        var category_id = $(this).siblings('.category_id').val();
        handle_edit_icon_click('/admin/category_title/edit_category_title/edit_category_title.php', category_id);
    });

    /*------------------------- Back Button JS on dashboard --------------------------------------*/
    function handle_back_button_click(url){ 
        $.ajax({
            type: 'GET',
            url: BASE_URL + url,
            success: function (data) {
                var container = $('.container');
                $(".container").empty();
                if (!$(data).find('.homepage_sidebar').length) {
                    container.html(data);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    // redirection ajax for back button the category sections
    $(document).on('click', '.category_title_back_button', function (e) {
        e.preventDefault();
        handle_back_button_click('/admin/homepage/dashboard/dashboard.php', e);
    });

    // for creating the tables using datatables
    $(document).ready(function() {
        $('#category_title_table').DataTable();
    });
</script>