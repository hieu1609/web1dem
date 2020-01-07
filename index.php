<?php
session_start();
?>
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
    <link href="/web1/style.css" rel="stylesheet">

    <title>Gundam Shop</title>
    <?php
    include "presentation/categoryP.php";
    $cp = new CategoryP();
    include "presentation/productP.php";
    $pp = new ProductP();
    ?>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script type="text/javascript">
        $(window).on('scroll', function() {
            if ($(window).scrollTop()) {
                $('nav').addClass('black');
            } else {
                $('nav').removeClass('black');
            }
        })
    </script>
</head>

<body>

    <nav class="navbar navbar-expand-sm px-0 py-0 shop_navbar">

        <a class="navbar-brand ml-3 px-0 py-0 shop_name" href="index.php">
            <img src="/web1/include/img/Cartoons__Anime_Gundam_Artboard_7-512.png" height="70" width="70" alt="" />
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
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Contact</a>
                </li>
                <li>
                    <?php
                    $pp->GetProductInCart();
                    ?>
                </li>
            </ul>
        </div>
    </nav>
    <div id="carouselId" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselId" data-slide-to="0" class="active"></li>
            <li data-target="#carouselId" data-slide-to="1"></li>
            <li data-target="#carouselId" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
                <img src="/web1/include/img/https___s3-ap-northeast-1.amazonaws.com_psh-ex-ftnikkei-3937bb4_images_2_4_6_7_21917642-1-eng-GB_コピー）ガンプラ仕掛け写真候補(2)プラモデル20190730142633 のコピー.jpg" width="1350" height="500" alt="First slide">
            </div>
            <div class="carousel-item">
                <img src="/web1/include/img/20150901_001929.jpg" width="1350" height="500" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img src="/web1/include/img/gv_banner.jpg" width="1350" height="500" alt="Third slide">
            </div>
            <a class="carousel-control-prev" href="#carouselId" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselId" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <div class="container">

            <div class="row">
                <?php
                $pp->ShowProductsByUser();
                ?>
            </div>
            <?php
            $cp->BuildLinks();
            ?>

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