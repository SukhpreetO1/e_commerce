<?php
if (strpos($_SERVER['REQUEST_URI'], 'logged_in') !== false) {
    $queryString = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    parse_str($queryString, $params);
    $roleId = $params['role_id'];
    if ($roleId === "2") {
        header("location: /e_commerce/users/homepage/index/index.php?logged_in=true&user_id=" . $params['id']);
    } else if ($roleId === "1") {
        header("location: /e_commerce/admin/homepage/index/index.php?logged_in=true&admin_id=" . $params['id']);
    } else {
        header("location: /e_commerce/common/login/login.php");
    }
} else {
    header("location: /e_commerce/common/login/login.php");
}