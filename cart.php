<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Add meta tags for mobile and IE -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Girassol&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="/web1/stylecart.css" rel="stylesheet">
    <title>Gundam Shop</title>
    <?php
    include "presentation/productP.php";
    $pp = new ProductP();
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
                <?php
                    $pp->ShowProductsInCart();
                ?>
            </ul>
        </div>
    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>