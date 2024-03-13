<div class="header">
    <nav class="header_navbar">
        <div class="container_fluid col-12">
            <div class="navbar_logo col-1">
                <a class="logo" href="#"><img src="<?php echo $_ENV['BASE_URL'] ?>/public/assets/images/m_letter.svg" alt="logo"></a>
            </div>
            <div class="navbar_items col-5">
                <?php
                include dirname(__DIR__) . "/navbar/navbar_dropdown.php";
                ?>
            </div>
            <div class="navbar_collapse col-6" id="search_filter">
                <div class="navbar-nav navbar_dashboard_search_bar">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2 navbar_search_bar" type="search" placeholder="Search for products, brands and more" aria-label="Search">
                    </form>
                    <div class="header_profile">
                        <i class="fa-regular fa-user"></i>
                        <div class="nav-link navbar_dropdown profile" role="button">
                            Profile
                            <ul class="dropdown-menu navbar_dropdown_menu">
                                <li style="width: 100%;"><a class="dropdown-item" href="<?php echo $_ENV['BASE_URL'] ?>/common/logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="header_wishlist">
                        <i class="fa-regular fa-heart"></i>
                        <a class="nav-link navbar_dropdown wishlist" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Wishlist
                        </a>
                    </div>
                    <div class="header_bag">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <a class="nav-link navbar_dropdown bag" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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