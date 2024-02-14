<?php
require dirname(__DIR__, 2) . "/common/config/config.php";
?>

<div class="users_detail_page">
    <div class="alert_container" id="alert_container"></div>
    <div class="container">
        <div class="users_detail_heading">
            <h2>Users Details</h2>
        </div>

        <div class="users_detail_page">
            <a href="#"><i class="fa-solid fa-arrow-left-long users_detail_back_button"></i></a>
            <a href="#"><i class="fa-solid fa-plus users_detail_plus_icon"></i></a>
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
                        <th scope="col">Role</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Updated At</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT users.*, roles.id as role_id, roles.name as role_name, roles.created_at as role_created_at, roles.updated_at as role_updated_at
                    FROM users
                    JOIN roles ON users.role_id = roles.id;";
                    $result = mysqli_query($database_connection, $query);

                    while ($category_data = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr scope="col">
                            <td>
                                <?php echo $category_data['id']; ?>
                            </td>
                            <td>
                                <?php echo $category_data['first_name']; ?>
                            </td>
                            <td>
                                <?php echo $category_data['last_name']; ?>
                            </td>
                            <td>
                                <?php echo $category_data['username']; ?>
                            </td>
                            <td>
                                <?php echo $category_data['email']; ?>
                            </td>
                            <td>
                                <?php echo $category_data['role_name']; ?>
                            </td>
                            <td>
                                <?php echo date('d-m-Y', strtotime($category_data['created_at'])); ?>
                            </td>
                            <td>
                                <?php echo date('d-m-Y', strtotime($category_data['updated_at'])); ?>
                            </td>
                            <td>
                                <div class="users_detail_page_action">
                                    <input type="hidden" name="users_id" class="users_id" id="users_id" value="<?php echo $category_data['id']; ?>">
                                    <div class="users_detail_toogle_button">
                                        <label class="switch"><input type="checkbox">
                                        <span class="users_detail_toogle_button_role_change" id="users_detail_toogle_button_role_change" name='users_detail_toogle_button_role_change'></span></label>
                                    </div>
                                    <div class="users_detail_edit">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </div>
                                    <div class="users_detail_delete">
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
    // for creating the tables using datatables
    $(document).ready(function() {
        $('#users_detail_table').DataTable();
    });
</script>