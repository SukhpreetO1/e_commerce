<nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid">
        <div class="logo col-1">
            <a class="logo" href="#"><img src="https://1000logos.net/wp-content/uploads/2016/10/Apple-Logo.png" alt="logo" class="navbar_logo"></a>
        </div>
        <div class="collapse navbar-collapse col-5" id="home_content">
            <ul class="navbar-nav navbar_text_items">
                <li class="nav-item">
                    <a class="nav-link navbar_text" href="./homepage.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link navbar_text" href="./navbar_list_section/men.php">Men</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link navbar_text" href="./navbar_list_section/women.php">Women</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link navbar_text" href="#">Kids</a>
                </li>
            </ul>
        </div>
        <div class="collapse navbar-collapse col-5" id="search_filter">
            <ul class="navbar-nav navbar_dashboard_search_bar">
                <form class="d-flex" role="search">
                    <input class="form-control me-2 navbar_search_bar" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle navbar_dropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Dashboard
                    </a>
                    <ul class="dropdown-menu navbar_dropdown_menu">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="<?php echo $_ENV['BASE_URL'] ?>/common/logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>