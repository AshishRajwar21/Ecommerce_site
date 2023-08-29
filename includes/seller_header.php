<div class="header sticky-top">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand logo" href="#"><img src="logo/logo3.jpeg"></a>
            <div class="navbar-brand">
                    <form id="search-form" method="get" action="item_list.php">
                        <div class="input-group product-search">
                            <input type="text" class="form-control input-product" id="item" name="item"
                                placeholder="Enter your product to search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-secondary">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </div>
                    </form>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars"></i>
                <!-- <span class="navbar-toggler-icon"></span> -->
            </button>
            <div class="collapse navbar-collapse side-navbar" id="navbarTogglerDemo02">
                
                    <div class="nav-name">
                        Hi, <?= $_SESSION['seller_name'] ?>
                    </div>
                    
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php"><i class="fa-solid fa-house"></i>Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">
                                <i class="fa-solid fa-right-to-bracket"></i>Logout
                            </a>
                        </li>                    
                    </ul>
                  
            </div>
        </div>
    </nav>
    </div>
    <div id="loading">

    </div>
    


