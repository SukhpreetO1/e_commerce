<?php
require dirname(__DIR__, 3) . "/common/config/config.php";
?>

<div class="dashboard_category_page">
    <div class="alert_container" id="alert_container"></div>
    <div class="container">
        <div class="dashboard_category_heading">
            <h2>Dashboard Category</h2>
        </div>

        <div class="add_dashboard_category">
            <a href="#"><i class="fa-solid fa-arrow-left-long dashboard_category_back_button"></i></a>
            <a href="#"><i class="fa-solid fa-plus dashboard_category_plus_icon"></i></a>
        </div>

        <div class="dashboard_category_table">
            <table class="dashboard_category_table" id="dashboard_category_table">
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
                    $query = "SELECT * FROM dashboard_category";
                    $result = mysqli_query($database_connection, $query);

                    while ($dashboard_category = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr scope="col">
                            <td>
                                <?php echo $dashboard_category['id']; ?>
                            </td>
                            <td>
                                <?php echo $dashboard_category['name']; ?>
                            </td>
                            <td>
                                <?php echo date('d-m-Y', strtotime($dashboard_category['created_at'])); ?>
                            </td>
                            <td>
                                <?php echo date('d-m-Y', strtotime($dashboard_category['updated_at'])); ?>
                            </td>
                            <td>
                                <div class="dashboard_category_action">
                                    <input type="hidden" name="dashboard_category_id" class="dashboard_category_id" id="dashboard_category_id" value="<?php echo $dashboard_category['id']; ?>">
                                    <div class="dashboard_category_edit">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </div>
                                    <div class="dashboard_category_delete">
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
    /*--------------------------------------------------------------- Click on plus (+) JS ----------------------------------------------------------------------------*/
    function dashboard_category_plus_icon(url) {
        $.ajax({
            type: 'GET',
            url: BASE_URL + url,
            success: function(data) {
                $(".container").empty();
                $('.container').html(data);
                var new_url = window.location.href.replace('?tab=dashboard_category', '?tab=add_dashboard_category');
                history.pushState(null, null, new_url);
            },
            error: function(e) {
                console.log(e);
            }
        });
    }

    // redirection ajax for adding the category category
    $(document).off('click', '.dashboard_category_plus_icon').on('click', '.dashboard_category_plus_icon', function(e) {
        e.preventDefault();
        dashboard_category_plus_icon('/admin/homepage/dashboard_category/add_dashboard_category/add_dashboard_category.php');
    });

    /*--------------------------------------------------------------- Click on Edit Button JS ----------------------------------------------------------------------------*/
    function dashboard_category_edit_icon(url, dashboard_category_id) {
        $.ajax({
            type: 'GET',
            url: BASE_URL + url + '?dashboard_category_id=' + dashboard_category_id,
            success: function(data) {
                $(".container").empty();
                $('.container').html(data);
            },
            error: function(e) {
                console.log(e);
            }
        });
    }

    // redirection ajax for adding the category category
    $(document).off('click', '.dashboard_category_edit').on('click', '.dashboard_category_edit', function(e) {
        e.preventDefault();
        var dashboard_category_id = $(this).siblings('.dashboard_category_id').val();
        dashboard_category_edit_icon('/admin/homepage/dashboard_category/edit_dashboard_category/edit_dashboard_category.php', dashboard_category_id);
    });

    /*--------------------------------------------------------------- Back Button JS on dashboard ----------------------------------------------------------------------------*/
    function dashboard_category_back_button(url) {
        $('.dashboard_category').removeClass('highlighted');
        $('.dashboard').addClass('highlighted');
        $.ajax({
            type: 'GET',
            url: BASE_URL + url,
            success: function(data) {
                $(".container").empty();
                var container = $('.container');
                if (!$(data).find('.homepage_sidebar').length) {
                    container.html(data);
                    var new_url = window.location.href.replace('?tab=dashboard_category', '?tab=dashboard');
                    history.pushState(null, null, new_url);
                }
            },
            error: function(e) {
                console.log(e);
            }
        });
    }

    // redirection ajax for back button the category category
    $(document).off('click', '.dashboard_category_back_button').on('click', '.dashboard_category_back_button', function(e) {
        e.preventDefault();
        dashboard_category_back_button('/admin/homepage/dashboard/dashboard.php', e);
    });

    /*--------------------------------------------------------------- Adding datatables ----------------------------------------------------------------------------*/
    // for creating the tables using datatables
    $(document).ready(function() {
        $('#dashboard_category_table').DataTable();
    });

    /*--------------------------------------------------------------- Delete Button JS on ADD PAGES ----------------------------------------------------------------------------*/
    function dashboard_category_delete_button(url, dashboard_category_id) {
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
                    url: BASE_URL + url + '?dashboard_category_id=' + dashboard_category_id,
                    success: function(response) {
                        if (parsed_response) {
                            parsed_response = null;
                        } else {
                            parsed_response = JSON.parse(response);
                            if (parsed_response.error) {
                                var alert_message = '<div class="alert alert-danger dashboard_category_delete_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                                $('#alert_container').append(alert_message);
                                setTimeout(function() {
                                    $('.alert').remove();
                                }, 3000);
                            } else {
                                $.ajax({
                                    url: BASE_URL + '/admin/dashboard_category/dashboard_category.php',
                                    type: 'GET',
                                    success: function(data) {
                                        $(".container").empty();
                                        $('.container').html(data);
                                        var alert_message = '<div class="alert alert-success dashboard_category_delete_alert_dismissible" role="alert">' + parsed_response.success + '</div>';
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

    // redirection ajax for delete button the category category
    $(document).on('click', '.dashboard_category_delete', function(e) {
        e.preventDefault();
        var dashboard_category_id = $(this).siblings('.dashboard_category_id').val();
        dashboard_category_delete_button('/admin/homepage/dashboard_category/delete_category/delete_dashboard_category.php', dashboard_category_id);
    });
</script>