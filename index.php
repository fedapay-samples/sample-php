<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Sample</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>

<body>
    <style>
        .product-card .card-footer {
            background-color: #AAA0;
            border-top-color: #AAA0;
        }

        .product-card .card-footer {
            position: absolute;
            bottom: 0;
            width: 100%;

        }

        .product-card {
            padding-bottom: 55px;
        }
    </style>

    .<div class="container-fluid ">

        <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #4B0082;">
            <a class="navbar-brand text-white" href="#">Hoodies Store</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active ">
                        <a class="nav-link text-white" href="#">Products <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Jeans</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            3D Printing
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item text-primary" href="#">Animes</a>
                            <a class="dropdown-item text-primary" href="#">Music World</a>
                            <a class="dropdown-item text-primary" href="#">Tv Series</a>
                            <div class="dropdown-divider"></div>

                        </div>
                    </li>

                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>
        <div class="div">
            <h1 class="h1 mt-5 mb-3" style="text-align:center; margin-top:25px; margin-bottom:25px">Hoodie Store</h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <?php
            $data = file_get_contents("data.json", true);
            $array = json_decode($data, true);
            foreach ($array as $key => $value) {
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4">

                    <div class="card h-100 product-card">
                        <div class="text-content">
                            <p style="text-align: center; margin-left:20px;margin-right:20px; margin-top:12px; text"><strong><?php echo $array[$key]["subject"] ?> 's Hoodie</strong></p>
                        </div>
                        <div class="card-image mx-auto">
                            <a href="<?php echo $array[$key]["reference"] ?>">
                                <img src="<?php echo $array[$key]["src"] ?>" class="rounded-25 mx-auto" style="max-width:100%; max-height:100%">
                            </a>
                        </div>
                        <div class="card-footer mt-2 center-align">
                            <button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#des-<?php echo $key ?>">Détails</button>
                        </div>
                    </div>
                    <!--Description Modal-->

                    <div class="modal fade" id="des-<?php echo $key ?>" tabindex="-1" role="dialog" aria-labelledby="juice1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle"><strong><?php echo $array[$key]["subject"] ?>'s hoodie</strong></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card-image">
                                                <img src="<?php echo $array[$key]["src"] ?>" alt="" height="250" width="250" class="rounded-25">
                                            </div>
                                        </div>
                                        <div class="col-md-6" text-center>
                                            <h4><strong>Description</strong></h4>
                                            <p><?php echo $array[$key]["description"] ?> <strong><?php echo $array[$key]["subject"] ?></strong>.
                                            </p>
                                            <p>Disponible en <?php echo $array[$key]["modele"] ?> pour les tailles <?php echo $array[$key]["tailles"] ?> </p>

                                            <p>Prix: <strong><?php echo $array[$key]["price"] ?> FCFA</strong></p>

                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                    <a href="#trans-<?php echo $key ?>" data-toggle="modal" data-dismiss="modal"> <button type="button" class="btn btn-primary">Acheter</button></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Transaction creation modal-->
                    <div class="modal fade" id="trans-<?php echo $key ?>" tabindex="-1" role="dialog" aria-labelledby="juice1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle"><strong><?php echo $array[$key]["subject"] ?> 's <?php echo $array[$key]["color"] ?> Hoodie</strong></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="payment.php">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Nom</label>
                                                    <input type="text" class="form-control" name="name" id="name" placeholder="Doe">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="firstname">Prénoms</label>
                                                    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="John">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Email</label>
                                                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="johndoe@example.com">

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="number">Téléphone </label>
                                                    <input type="tel" class="form-control" name="number" id="number" placeholder="66000001"">
                                            </div>
    
                                        </div>
                                        <div class=" col-md-12">
                                                    <p>
                                                        Montant à payer :

                                                        <?php echo $array[$key]["price"] ?>
                                                        FCFA
                                                    </p>
                                                    <input type="hidden" name="amount" id="amount" value="<?php echo $array[$key]["price"] ?>">

                                                </div>
                                            </div>
                                            <button type=" submit" name="submit" class="btn btn-primary float-right">Payer</button>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    </div>

    <!-- Footer -->
    <footer class="page-footer font-small mdb-color pt-4 bg-gradient-dark" style=" background-image: linear-gradient(to right bottom, #5a1254, #561462, #4d1971, #3b2182, #0a2992);">

        <!-- Footer Links -->
        <div class="container text-center text-md-left">

            <!-- Footer links -->
            <div class="row text-center text-md-left mt-3 pb-3">

                <!-- Grid column -->
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 text-white font-weight-bold">My Hoodie Store</h6>
                    <p class="text-white"> Here you can find all you need to get well-dressed. Jeans, hoodies, shirts, skirts, anything you neede is yours.</p>
                </div>
                <!-- Grid column -->

                <hr class="w-100 clearfix d-md-none">

                <!-- Grid column -->
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 text-white font-weight-bold">Products</h6>
                    <p>
                        <a class="text-white" href="#!">Jeans</a>
                    </p>
                    <p>
                        <a class="text-white" href="#!">Hoodies</a>
                    </p>
                    <p>
                        <a class="text-white" href="#!">Shirts</a>
                    </p>
                    <p>
                        <a class="text-white" href="#!">3D Printing</a>
                    </p>
                </div>
                <!-- Grid column -->

                <hr class="w-100 clearfix d-md-none">

                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 text-white font-weight-bold">Useful links</h6>
                    <p>
                        <a class="text-white" href="#!">Your Account</a>
                    </p>
                    <p>
                        <a class="text-white" href="#!">Become an Affiliate</a>
                    </p>
                    <p>
                        <a class="text-white" href="#!">Shipping Rates</a>
                    </p>
                    <p>
                        <a class="text-white" href="#!">Help</a>
                    </p>
                </div>

                <!-- Grid column -->
                <hr class="w-100 clearfix d-md-none">
                <!-- Grid column -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h6 class="text-uppercase text-white mb-4 font-weight-bold">Contact</h6>
                    <p class="text-white">
                        <i class="fas fa-home  mr-3 text-white"></i> New York, NY 10012, US</p>
                    <p class="text-white">
                        <i class="fas  fa-envelope mr-3"></i> info@gmail.com</p>
                    <p class="text-white">
                        <i class="fas text-white fa-phone mr-3"></i> + 01 234 567 88</p>
                    <p class="text-white">
                        <i class="fas text-white fa-print mr-3"></i> + 01 234 567 89</p>
                </div>
                <!-- Grid column -->

            </div>
            <!-- Footer links -->

            <hr>

            <!-- Grid row -->
            <div class="row d-flex align-items-center">

                <!-- Grid column -->
                <div class="col-12">

                    <!--Copyright-->
                    <p class="text-center text-md-center text-white">© 2020 Copyright:
                        <a href="https:fedapay.com/">
                            <strong> FedaPay</strong>
                        </a>
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->

                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div>
        <!-- Footer Links -->
    </footer>
    <!-- Footer -->
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</html>