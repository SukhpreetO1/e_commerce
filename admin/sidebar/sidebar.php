<link rel="stylesheet" href="<?php echo $_ENV['BASE_URL'] ?>/admin/sidebar/sidebar.css">
<div class="homepage_sidebar">
    <div class="p-3 admin_sidebar">
        <a href="#" class="mb-3 link-dark text-decoration-none title">
            <span class="fs-4">Sidebar</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li>
                <a href="#" class="nav-link link-dark dashboard">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="#" class="nav-link link-dark orders">
                    Orders
                </a>
            </li>
            <li>
                <a href="#" class="nav-link link-dark products">
                    Products
                </a>
            </li>
            <li>
                <a href="#" class="nav-link link-dark customers">
                    Customers
                </a>
            </li>
            <li>
                <a href="#" class="nav-link link-dark category_title">
                    Category Title
                </a>
            </li>
            <li>
                <a href="#" class="nav-link link-dark category_heading">
                    Category Heading
                </a>
            </li>
            <li>
                <a href="#" class="nav-link link-dark categories_types">
                    Category Types
                </a>
            </li>
        </ul>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?php echo $_ENV['BASE_URL'] ?>/public/assets/images/m_letter.svg" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong>Profile</strong>
            </a>
            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                <li><a class="dropdown-item" href="<?php echo $_ENV['BASE_URL'] ?>/common/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</div>