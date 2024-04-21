<?php
session_start();

require 'functions.php';
require 'controllers/appointment.php';

$appointments = myAppointments(getUserId());


?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="remixicons/fonts/remixicon.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>BarberBook</title>
</head>

<body id="home" data-bs-spy="scroll" data-bs-target=".navbar">


    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">BarberBook</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#about">About the project</a>
                    </li>


                    <?php
                    if (isUserLoggedIn()) {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="modal" data-bs-target="#mioCalendario">Calendario</a>
                        </li>
                    <?php
                    }
                    ?>


                    <?php if (empty($_SESSION['userloggedin'])) { ?>
                        <a href="#"><button type="button" class="btn btn-outline-brand ms-lg-3" id="userAccess" data-bs-toggle="modal" data-bs-target="#LoginSignup">Accedi</button></a>
                    <?php } else if ($_SESSION['userloggedin']) { ?>

                        <form method="POST" id="formLogout">
                            <input type="hidden" name="action" value="logout">
                            <button type="button" class="btn btn-outline-success" id="logout">LogOut</button>
                        </form>
                    <?php } ?>

                </ul>
            </div>
        </div>
    </nav>
    <!-- // NAVBAR -->


    <!-- HERO -->
    <section id="hero">
        <div class="container">
            <div class="row pic">
                <div class="d-flex flex-column justify-content-center align-items-center mt-lg-5 mt-sm-5 text-center ">
                    <h1 class="display-4">Barber Book</h1>
                    <p>Simplify appointment management for barbers and clients with BarberBook. Easily book your appointments online and efficiently manage your barber schedule. Try it now!</p>

                    <a href="#"><button type="button" class="btn btn-brand mt-lg-5 mt-sm-5" data-bs-toggle="modal" data-bs-target="#calendario">Prenota ora!</button></a>

                    <?php if (isUserLoggedIn()) { ?>
                        <a href="#"><button type="button" class="btn btn-outline-brand mt-lg-5 mt-sm-5" data-bs-toggle="modal" data-bs-target="#mioCalendario">Calendario</button></a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

    </section>
    <!-- // HERO -->


    <!-- ABOUT -->
    <section id="about">
        <div class="container">
            <div class="row align-items-center text-white fw-bold text-center flex-column gap-4">
                <div class="col-8">
                    <h6>Revolutionizing Barber Services</h6>

                    <h1>About the project</h1>

                    <p class="fs-5">Welcome to BarberBook, the innovative solution designed to transform the way barbers engage with their clients. Our platform serves as a dynamic showcase for barbershops, presenting their services and fostering seamless communication with clients. Simultaneously, BarberBook empowers clients with the convenience of online appointment scheduling, while providing barbers with efficient appointment management tools. Join us in revolutionizing the barbering industry with BarberBook.
                    </p>
                </div>

                <div class="col-8">
                    <h6>Simplifying Appointment Management</h6>

                    <h1>How It Works?</h1>

                    <p class="fs-5">Welcome to BarberBook, the innovative solution designed to transform the way barbers engage with their clients. Our platform serves as a dynamic showcase for barbershops, presenting their services and fostering seamless communication with clients. Simultaneously, BarberBook empowers clients with the convenience of online appointment scheduling, while providing barbers with efficient appointment management tools. Join us in revolutionizing the barbering industry with BarberBook.
                    </p>
                </div>


            </div>
        </div>

    </section>
    <!-- // ABOUT -->


    <!-- // FOOTER -->
    <section id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row gy-5">
                    <div class="col-lg-4">

                        <h3 class="mb-3">My Barber Saloon</h3>

                        <p> Simplifying barber appointments for both barbers and clients.</p>
                        <div class="social-link">
                            <a href=""><i class="ri-mail-fill"></i></a>
                            <a href=""><i class="ri-instagram-fill"></i></a>
                            <a href=""><i class="ri-facebook-fill"></i></a>
                            <a href=""><i class="ri-twitter-fill"></i></a>
                        </div>
                        <a href="#" id="adminAccess" data-bs-toggle="modal" data-bs-target="#LoginSignup">AREA ADMIN</a>
                    </div>


                    <div class="col-lg-3 offset-lg-1">

                        <h4 class="mb-3">Working hours</h3>

                            <div>
                                <h6>Tuesday - Sunday</h6>
                                <p> 09:00 - 21:00</p>
                            </div>

                            <div>
                                <h6>Monday</h6>
                                <p>We are closed</p>
                            </div>

                    </div>

                    <div class="col-lg-3">

                        <h4>Contacts</h3>

                            <div>

                                <p><i class="ri-map-pin-fill "></i>
                                    <span>Via Giuseppe Garibaldi, 32, Milano</span>
                                </p>

                                <p><i class="ri-phone-fill"></i>
                                    <span>+39 323 223 3232</span>
                                </p>

                                <p><i class="ri-mail-fill"></i>
                                    <span>BarberBook@gmail.com</span>
                                </p>
                            </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- // FOOTER -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.js"></script>


    <?php
    require 'views/signIn_login.php';
    require 'views/calendario.php';
    require 'views/mioCalendario.php';
    ?>




</body>

</html>