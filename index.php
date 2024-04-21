<?php

// 328/pets/index.php

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require autoload.php
require_once ('vendor/autoload.php');

// Instantiate the F3 base class
$f3 = Base::instance();

// Define a default route
$f3->route('GET /', function() {

    // Render a view page
    $view = new Template();
    echo $view->render('views/home.html');
});

// Define a route to apply1
$f3->route('GET|POST /apply1', function($f3) {
    session_start();

    //Check if the form has been posted
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fname = $_POST['first-name'];
        $lname = $_POST['last-name'];
        $email = $_POST['user-email'];
        $state = $_POST['user-state'];
        $phone = $_POST['phone-num'];
        //Validate the data
        if (empty($fname) || empty($lname) || empty($email) || empty($phone)) {
            //Data is invalid
            echo "Please fill out the data";
        } else {
            //Data is valid
            $f3->set('SESSION.user-first-name', $fname);
            $f3->set('SESSION.user-last-name', $lname);
            $f3->set('SESSION.user-email', $email);
            $f3->set('SESSION.user-state', $state);
            $f3->set('SESSION.user-phone', $phone);
            //Redirect to the summary route
            $f3->reroute("apply2");
        }
    }
    // Render a view page
    $view = new Template();
    echo $view->render('views/app-personal-info.html');
});

// Define a route to apply2
$f3->route('GET|POST /apply2', function() {
    session_start();

    echo '<h1>Application Apply!</h1>';

    // Render a view page
    //$view = new Template();
    //echo $view->render('views/app-personal-info.html');
});

// Run Fat-Free
$f3->run();