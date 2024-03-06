<?php
require dirname(__DIR__, 2) . "/common/base_url.php";
require dirname(__DIR__, 2) . "/common/config/config.php";
?>
<div class="category_header_page">
    <div class="alert_container" id="alert_container"></div>
    <div class="container">
        <div class="category_header_title">
            <h2>Category Header</h2>
        </div>

        <div class="add_category_header">
            <a href="#"><i class="fa-solid fa-arrow-left-long category_header_back_button"></i></a>
            <a href="#"><i class="fa-solid fa-plus category_header_plus_icon"></i></a>
        </div>

        <div class="category_header_table">
            <table class="table" id="category_header_table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Category Name</th>
                        <th scope="col">Heading Name</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Updated At</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT categories_heading.*, categories.id as categories, categories.name as categories_name, categories.created_at as categories_created_at, categories.updated_at as categories_updated_at
                    FROM categories_heading
                    JOIN categories ON categories_heading.categories_id = categories.id;";
                    $result = mysqli_query($database_connection, $query);
                    while ($category_data = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?php echo $category_data['id']; ?></td>
                            <td><?php echo $category_data['categories_name']; ?></td>
                            <td><?php echo $category_data['name']; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($category_data['created_at'])); ?></td>
                            <td><?php echo date('d-m-Y', strtotime($category_data['updated_at'])); ?></td>
                            <td>
                                <div class="category_header_action">
                                    <input type="hidden" name="category_id" class="category_id" id="category_id" value="<?php echo $category_data['id']; ?>">
                                    <div class="category_header_edit">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </div>
                                    <div class="category_header_delete">
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
    /*--------------------------------------------------------------- Adding datatables ----------------------------------------------------------------------------*/
    // for creating the tables using datatables
    $(document).ready(function() {
        $('#category_header_table').DataTable();
    });

    /*--------------------------------------------------------------- Click on plus (+) JS ----------------------------------------------------------------------------*/
    function category_header_plus_icon(url) {
        $.ajax({
            type: 'GET',
            url: BASE_URL + url,
            success: function(data) {
                $(".container").empty();
                $('.container').html(data);
            },
            error: function(e) {
                console.log(e);
            }
        });
    }

    // redirection ajax for adding the category title
    $(document).off('click', '.category_header_plus_icon').on('click', '.category_header_plus_icon', function(e) {
        e.preventDefault();
        category_header_plus_icon('/admin/category_header/add_category_header/add_category_header.php');
    });

    /*--------------------------------------------------------------- Back Button JS on dashboard ----------------------------------------------------------------------------*/
    function category_header_back_button(url) {
        $('.category_header').removeClass('highlighted');
        $('.dashboard').addClass('highlighted');

        $.ajax({
            type: 'GET',
            url: BASE_URL + url,
            success: function(data) {
                $(".container").empty();
                var container = $('.container');
                if (!$(data).find('.homepage_sidebar').length) {
                    container.html(data);
                    var new_url = window.location.href.replace('?tab=category_header', '?tab=dashboard');
                    history.pushState(null, null, new_url);
                }
            },
            error: function(e) {
                console.log(e);
            }
        });
    }

    // redirection ajax for back button the category title
    $(document).off('click', '.category_header_back_button').on('click', '.category_header_back_button', function(e) {
        e.preventDefault();
        category_header_back_button('/admin/homepage/dashboard/dashboard.php', e);
    });

    /*--------------------------------------------------------------- Delete Button JS on ADD PAGES ----------------------------------------------------------------------------*/
    function category_header_delete_button(url, category_id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var parsed_response = null;
                $.ajax({
                    type: 'DELETE',
                    url: BASE_URL + url + '?category_id=' + category_id,
                    success: function(response) {
                        if (parsed_response) {
                            parsed_response = null;
                        } else {
                            parsed_response = JSON.parse(response);
                            if (parsed_response.error) {
                                var alert_message = '<div class="alert alert-danger category_header_delete_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                                $('#alert_container').append(alert_message);
                                setTimeout(function() {
                                    $('.alert').remove();
                                }, 3000);
                            } else {
                                $.ajax({
                                    url: BASE_URL + '/admin/category_header/category_header.php',
                                    type: 'GET',
                                    success: function(data) {
                                        $(".container").empty();
                                        $('.container').html(data);
                                        var alert_message = '<div class="alert alert-success category_header_delete_alert_dismissible" role="alert">' + parsed_response.success + '</div>';
                                        $('#alert_container').append(alert_message);
                                        setTimeout(function() {
                                            $('.alert').remove();
                                        }, 2000);
                                    },
                                    error: function(xhr, status, error) {
                                        console.log(error);
                                    }
                                });
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            }
        });
    }

    // redirection ajax for delete button the category title
    $(document).on('click', '.category_header_delete', function(e) {
        e.preventDefault();
        var category_id = $(this).siblings('.category_id').val();
        category_header_delete_button('/admin/category_header/delete_category_header/delete_category_header.php', category_id);
    });

    /*--------------------------------------------------------------- Click on Edit Button JS ----------------------------------------------------------------------------*/
    function category_header_edit_icon(url, category_id) {
        $.ajax({
            type: 'GET',
            url: BASE_URL + url + '?category_id=' + category_id,
            success: function(data) {
                $(".container").empty();
                $('.container').html(data);
            },
            error: function(e) {
                console.log(e);
            }
        });
    }

    // redirection ajax for adding the category title
    $(document).off('click', '.category_header_edit').on('click', '.category_header_edit', function(e) {
        e.preventDefault();
        var category_id = $(this).siblings('.category_id').val();
        category_header_edit_icon('/admin/category_header/edit_category_header/edit_category_header.php', category_id);
    });
</script>