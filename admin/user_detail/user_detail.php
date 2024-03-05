<?php
require dirname(__DIR__, 2) . "/common/config/config.php";
// include dirname(__DIR__, 2) . "/admin/user_detail/toggle_button_php.php";
?>

<div class="users_detail_page">
    <div class="alert_container" id="alert_container"></div>
    <div class="container" style=" min-width: 86vw; margin-left: -13%;">
        <div class="users_detail_heading">
            <h2>Users Details</h2>
        </div>

        <div class="users_detail_page">
            <a href="#"><i class="fa-solid fa-arrow-left-long users_detail_back_button"></i></a>
        </div>

        <div class="users_detail_page_table">
            <table class="users_detail_table" id="users_detail_table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Mobile Number</th>
                        <th scope="col">Date of Birth</th>
                        <th scope="col">Active/ Blocked</th>
                        <th scope="col">Role</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Updated At</th>
                        <th scope="col" style="width: 10%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT users.*, roles.id as role_id, roles.name as role_name, roles.created_at as role_created_at, roles.updated_at as role_updated_at
                    FROM users
                    JOIN roles ON users.role_id = roles.id;";
                    $result = mysqli_query($database_connection, $query);

                    while ($users = mysqli_fetch_assoc($result)) {
                        if ($users['role_id'] == 2) {
                    ?>
                            <tr scope="col">
                                <td>
                                    <?php echo $users['id']; ?>
                                </td>
                                <td>
                                    <?php echo $users['first_name']; ?>
                                </td>
                                <td>
                                    <?php echo $users['last_name']; ?>
                                </td>
                                <td>
                                    <?php echo $users['username']; ?>
                                </td>
                                <td>
                                    <?php echo $users['email']; ?>
                                </td>
                                <td>
                                    <?php echo $users['mobile_number']; ?>
                                </td>
                                <td>
                                    <?php
                                    $date_of_birth = $users['date_of_birth'];
                                    $new_date = date('d-m-Y', strtotime($date_of_birth));
                                    echo $new_date;
                                    ?>
                                </td>
                                <td>
                                    <?php echo ($users['active'] == 1) ? 'Active' : 'Blocked'; ?>
                                </td>
                                <td>
                                    <?php echo $users['role_name']; ?>
                                </td>
                                <td>
                                    <?php echo date('d-m-Y', strtotime($users['created_at'])); ?>
                                </td>
                                <td>
                                    <?php echo date('d-m-Y', strtotime($users['updated_at'])); ?>
                                </td>
                                <td>
                                    <div class="users_detail_page_action">
                                        <input type="hidden" name="user_id" class="user_id" id="user_id" value="<?php echo $users['id']; ?>">
                                        <input type="hidden" name="role_id" class="role_id" id="role_id" value="<?php echo $users['role_id']; ?>">
                                        <input type="hidden" name="active_id" class="active_id" id="active_id" value="<?php echo $users['active']; ?>">
                                        <div class="users_active_toggle_button">
                                            <label class="switch">
                                                <input type="checkbox" <?php echo ($users['active'] == 1) ? 'checked' : ''; ?>>
                                                <span class="users_active_toggle_button_change" id="users_active_toggle_button_change" name='users_active_toggle_button_change' title="<?php echo ($users['active'] == 1) ? 'Active Account' : 'Blocked Account'; ?>"></span>
                                            </label>
                                        </div>
                                        <div class="users_detail_toggle_button">
                                            <label class="switch">
                                                <input type="checkbox" <?php echo ($users['role_id'] == 1) ? 'checked' : ''; ?>>
                                                <span class="users_detail_toggle_button_role_change" id="users_detail_toggle_button_role_change" name='users_detail_toggle_button_role_change' title="<?php echo ($users['role_id'] == 1) ? 'Role : Admin' : 'Role : User'; ?>"></span>
                                            </label>
                                        </div>
                                        <!-- <div class="users_detail_edit">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </div> -->
                                        <div class="users_detail_delete">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                    <?php
                        }
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
        $('#users_detail_table').DataTable();
    });

    /* --------------------------------------------------------------- Role Toggle Button JS ----------------------------------------------------------------------------*/
    $(document).off('click', '.users_detail_toggle_button_role_change').on('click', '.users_detail_toggle_button_role_change', function() {
        var user_id = $(this).parent().parent().parent().find('.user_id').val();
        var role_id = $(this).parent().parent().parent().find('.role_id').val();
        $.ajax({
            url: BASE_URL + "/admin/user_detail/toggle_button/toggle_button_php.php",
            type: "POST",
            data: {
                user_id: user_id,
                role_id: role_id
            },
            success: function(response) {
                parsed_response = JSON.parse(response);
                if (parsed_response.error) {
                    var alert_message = '<div class="alert alert-danger role_update_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                    $('#alert_container').append(alert_message);
                    setTimeout(function() {
                        $('.alert').remove();
                    }, 3000);
                } else {
                    $.ajax({
                        url: BASE_URL + '/admin/user_detail/user_detail.php',
                        type: 'GET',
                        success: function(data) {
                            $(".container").empty();
                            $('.container').html(data);
                            var alert_message = '<div class="alert alert-success role_update_success_dismissible" role="alert">' + parsed_response.success + '</div>';
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
        });
    });

    /* --------------------------------------------------------------- Active/ inactive Toggle Button JS ----------------------------------------------------------------------------*/
    $(document).off('click', '.users_active_toggle_button_change').on('click', '.users_active_toggle_button_change', function() {
        var user_id = $(this).parent().parent().parent().find('.user_id').val();
        var active_id = $(this).parent().parent().parent().find('.active_id').val();
        $.ajax({
            url: BASE_URL + "/admin/user_detail/toggle_button/active_toggle_button_php.php",
            type: "POST",
            data: {
                user_id: user_id,
                active_id: active_id
            },
            success: function(response) {
                parsed_response = JSON.parse(response);
                if (parsed_response.error) {
                    var alert_message = '<div class="alert alert-danger user_active_update_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                    $('#alert_container').append(alert_message);
                    setTimeout(function() {
                        $('.alert').remove();
                    }, 3000);
                } else {
                    $.ajax({
                        url: BASE_URL + '/admin/user_detail/user_detail.php',
                        type: 'GET',
                        success: function(data) {
                            $(".container").empty();
                            $('.container').html(data);
                            var alert_message = '<div class="alert alert-success user_active_update_success_dismissible" role="alert">' + parsed_response.success + '</div>';
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
        });
    });

    /*--------------------------------------------------------------- Delete Button JS ----------------------------------------------------------------------------*/
    function user_delete_button(url, user_id) {
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
                    url: BASE_URL + url + '?user_id=' + user_id,
                    data: {
                        user_id: user_id,
                    },
                    success: function(response) {
                        if (parsed_response) {
                            parsed_response = null;
                        } else {
                            parsed_response = JSON.parse(response);
                            if (parsed_response.error) {
                                var alert_message = '<div class="alert alert-danger user_delete_alert_dismissible" role="alert">' + parsed_response.error + '</div>';
                                $('#alert_container').append(alert_message);
                                setTimeout(function() {
                                    $('.alert').remove();
                                }, 3000);
                            } else {
                                $.ajax({
                                    url: BASE_URL + '/admin/user_detail/user_detail.php',
                                    type: 'GET',
                                    success: function(data) {
                                        $(".container").empty();
                                        $('.container').html(data);
                                        var alert_message = '<div class="alert alert-success user_delete_alert_dismissible" role="alert">' + parsed_response.success + '</div>';
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

    // redirection ajax for delete button the users
    $(document).on('click', '.users_detail_delete', function(e) {
        e.preventDefault();
        var user_id = $(this).siblings('.user_id').val();
        user_delete_button('/admin/user_detail/delete_user_detail.php/delete_user_detail.php', user_id);
    });

    /*--------------------------------------------------------------- Back Button JS on dashboard ----------------------------------------------------------------------------*/
    function users_detail_back_button(url) {
        $('.users').removeClass('highlighted');
        $('.dashboard').addClass('highlighted');
        $.ajax({
            type: 'GET',
            url: BASE_URL + url,
            success: function(data) {
                $(".container").empty();
                var container = $('.container');
                if (!$(data).find('.homepage_sidebar').length) {
                    container.html(data);
                    var new_url = window.location.href.replace('?tab=user_detail', '?tab=dashboard');
                    history.pushState(null, null, new_url);
                }
            },
            error: function(e) {
                console.log(e);
            }
        });
    }

    // redirection ajax for back button the category title
    $(document).off('click', '.users_detail_back_button').on('click', '.users_detail_back_button', function(e) {
        e.preventDefault();
        users_detail_back_button('/admin/homepage/dashboard/dashboard.php', e);
    });
</script>