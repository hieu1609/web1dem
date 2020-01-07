<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Girassol&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="/web1/stylecart.css" rel="stylesheet">
    <title>Gundam Shop</title>
    <?php
    include "presentation/categoryP.php";
    $cp = new CategoryP();
    ?>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-sm px-0 py-0 shop_navbar black">
        <a class="navbar-brand ml-3 px-0 py-0 shop_name" href="index.php">
            <img src="/web1/include/img/Cartoons__Anime_Gundam_Artboard_7-512.png" height="70" width="70" alt="" />
            Gundam Shop</a>
        <h3 class="ml-4 brand">Cart</h3>
    </nav>
    <div class="product_detail">
        <div class="container">
            <ul style="list-style: none">
                <li>
                    <div class="row ">
                        <div class="col-2">
                        </div>
                        <div class="col-4 mt-3 pb-2  ">

                        </div>
                        <div class="col-2 mt-3 pb-2">
                            Price
                        </div>
                        <div class="col-2 mt-3 pb-2">
                            Number
                        </div>
                        <div class="col-2 mt-3 pb-2">
                            Total
                        </div>
                    </div>
                </li>
                <li class="mt-3">
                    <div class="row">
                        <div class="col-2">
                            <img height="70" width="70" src="/web1/include/img/Cartoons__Anime_Gundam_Artboard_7-512.png" alt="">
                        </div>
                        <div class="col-4 mt-4  ">
                            Tên sản phẩm
                        </div>
                        <div class="col-2 mt-4 ">
                            3000000VND
                        </div>
                        <div class="col-2 mt-4">
                            <button class="mr-1">-</button>
                            <span>20</span>
                            <button class="ml-1">+</button>
                        </div>
                        <div class="col-2 mt-4 ">
                            600000 VNd
                        </div>
                    </div>
                </li>
                <li class="mt-3">
                    <div class="row">
                        <div class="col-2">
                            <img height="70" width="70" src="/web1/include/img/Cartoons__Anime_Gundam_Artboard_7-512.png" alt="">
                        </div>
                        <div class="col-4 mt-4  ">
                            Tên sản phẩm
                        </div>
                        <div class="col-2 mt-4 ">
                            3000000VND
                        </div>
                        <div class="col-2 mt-4">
                            <button class="mr-1">-</button>
                            <span>20</span>
                            <button class="ml-1">+</button>
                        </div>
                        <div class="col-2 mt-4 ">
                            600000 VNd
                        </div>
                    </div>
                </li>
            </ul>
            <h5>Giỏ hàng đang trống
            </h5>
        </div>
    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>