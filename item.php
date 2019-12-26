<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Girassol&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Volkhov&display=swap" rel="stylesheet">
    <link href="/web1dem/style.css" rel="stylesheet">

    <title>Gundam Shop</title>
    <?php
    include "presentation/categoryP.php";
    $cp = new CategoryP();
    ?>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <!-- <script type="text/javascript">
        $(window).on('scroll', function() {
            if ($(window).scrollTop()) {
                $('nav').addClass('black');
            } else {
                $('nav').removeClass('black');
            }
        })
    </script> -->
</head>

<body>

    <nav class="navbar navbar-expand-sm px-0 py-0 shop_navbar black">

        <a class="navbar-brand ml-3 px-0 py-0 shop_name" href="#">
            <img src="/web1dem/include/img/Cartoons__Anime_Gundam_Artboard_7-512.png" height="70" width="70" alt="" />
            Gundam Shop</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="dropdown">
            <button class="dropbtn"><i class="fa fa-list"></i> Categories</button>
            <div class="dropdown-content">

                <?php
                $cp->ShowAllCategories();
                ?>
            </div>
        </div>
        <form class="form-inline ml-4 my-2 my-lg-0 search_form" action="search.php" method="get">
            <input class="pl-3 mr-0 mr-sm-0" name="search" type="search" placeholder="Search" aria-label="Search">
            <button class="  " name="ok" type="submit"><i class="fa fa-search"></i></button>
        </form>

        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0 mr-5">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
                <li>
                    <div class="cart ">
                        <i class="fa fa-shopping-cart"></i>
                        <span>3</span>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="product_detail">


        <div class="container">

            <div class="row">
                <?php
                include "presentation/productP.php";
                $pp = new ProductP();
                $pp->ShowItem();
                ?>
            </div>

        </div>
    </div>

    <footer class="page-footer font-small py-3 bg-dark mt-4">
        <p class="footer-copyright text-center py-3 text-white">
            Copyright © Your Website 2019
        </p>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>