<?php
    session_start();
?>
<div class="homepage_sidebar">
    <div class="admin_sidebar">
        <a href="#" class="mb-3 link-dark text-decoration-none title">
            <span class="sidebar fs-4 p-3">Sidebar</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li>
                <a href="#" class="nav-link dashboard">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="#" class="nav-link orders">
                    Orders
                </a>
            </li>
            <li>
                <a href="#" class="nav-link users">
                    Users Details
                </a>
            </li>
            <li>
                <a href="#" class="nav-link brands">
                    Brands
                </a>
            </li>
            <li>
                <a href="#" class="nav-link size">
                    Size
                </a>
            </li>
            <li>
                <a href="#" class="nav-link color">
                    Color
                </a>
            </li>
            <li>
                <a href="#" class="nav-link discount">
                    Discount
                </a>
            </li>
            <li>
                <a href="#" class="nav-link products">
                    Products
                </a>
            </li>
            <li>
                <a href="#" class="nav-link roles">
                    Roles
                </a>
            </li>
            <li>
                <a href="#" class="nav-link category_title">
                    Category Title
                </a>
            </li>
            <li>
                <a href="#" class="nav-link category_header">
                    Category Heading
                </a>
            </li>
            <li>
                <a href="#" class="nav-link categories_types">
                    Category Types
                </a>
            </li>
        </ul>
        <div class="dropdown profile">
            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" id="dropdownUser2" aria-expanded="false">
                <img src="#" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong>Profile</strong>
            </a>
            <ul class="dropdown-menu text-small shadow sidebar_profile_dropdown" aria-labelledby="dropdownUser2">
                <input type="hidden" name="user_id" class="user_id" id="user_id">
                <li><a class="dropdown-item admin_detail" href="#">Admin Detail</a></li>
                <li><a class="dropdown-item logout" href="#">Logout</a></li>
            </ul>
        </div>
    </div>
</div>