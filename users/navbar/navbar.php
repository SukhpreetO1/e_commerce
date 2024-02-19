<div class="header">
    <nav class="header_navbar">
        <div class="container_fluid">
            <div class="navbar_logo">
                <a class="logo" href="#"><img src="<?php echo $_ENV['BASE_URL'] ?>/public/assets/images/m_letter.svg" alt="logo"></a>
            </div>
            <div class="navbar_items">
                <?php
                include dirname(__DIR__) . "/navbar/navbar_dropdown.php";
                ?>
            </div>
            <div class="navbar_collapse" id="search_filter">
                <div class="navbar-nav navbar_dashboard_search_bar">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2 navbar_search_bar" type="search" placeholder="Search" aria-label="Search">
                    </form>
                    <div class="header_profile">
                        <div class="nav-link navbar_dropdown" role="button">
                            Profile
                            <ul class="dropdown-menu navbar_dropdown_menu">
                                <li><a class="dropdown-item" href="<?php echo $_ENV['BASE_URL'] ?>/common/logout.php">Logout</a></li>
                            </ul>
                        </div>
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

<script>
    document.querySelectorAll('.navbar_heading').forEach(item => {
        item.addEventListener('mouseover', event => {
            item.querySelector('.category_header').style.display = 'flex';
        });

        item.addEventListener('mouseout', event => {
            item.querySelector('.category_header').style.display = 'none';
        });
    });

    // Add this JavaScript to your script file
    document.querySelector(".navbar_dropdown").addEventListener("mouseenter", function() {
        document.querySelector(".navbar_dropdown_menu").style.display = "flex";
    });

    document.querySelector(".header_profile").addEventListener("mouseleave", function() {
        document.querySelector(".navbar_dropdown_menu").style.display = "none";
    });
</script>