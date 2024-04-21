<?php 
 session_start();
require 'db/connection.php';
require 'functions.php';
require 'controllers/loginSignUpController.php';
require 'controllers/bookingController.php';

$action = $_REQUEST['action'] ?? '';



    if(function_exists($action)){
        echo json_encode($action());

        exit();
    }