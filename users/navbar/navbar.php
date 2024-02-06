<link rel="stylesheet" href="<?php echo $_ENV['BASE_URL'] ?>/users/navbar/navbar.css">
<div class="header">
    <nav class="header_navbar">
        <div class="container_fluid">
            <div class="navbar_logo">
                <a class="logo" href="#"><img src="<?php echo $_ENV['BASE_URL'] ?>/public/assets/images/m_letter.svg" alt="logo"></a>
            </div>
            <div class="navbar_items">
                <div class="nav_item">
                    <a class="nav-link navbar_text" href="./homepage.php">Home</a>
                </div>
                <div class="nav_item">
                    <a class="nav-link navbar_text" href="./navbar_list_section/men.php">Men</a>
                </div>
                <div class="nav_item">
                    <a class="nav-link navbar_text" href="./navbar_list_section/women.php">Women</a>
                </div>
                <div class="nav_item">
                    <a class="nav-link navbar_text" href="#">Kids</a>
                </div>
                <div class="nav_item">
                    <a class="nav-link navbar_text" href="#">Items</a>
                </div>
            </div>
            <div class="navbar_collapse" id="search_filter">
                <div class="navbar-nav navbar_dashboard_search_bar">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2 navbar_search_bar" type="search" placeholder="Search" aria-label="Search">
                    </form>
                    <div class="header_profile">
                        <a class="nav-link navbar_dropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Profile
                        </a>
                    </div>
                    <div class="header_wishlist">
                        <a class="nav-link navbar_dropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Wishlist
                        </a>
                    </div>
                    <div class="header_bag">
                        <a class="nav-link navbar_dropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Bag
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>