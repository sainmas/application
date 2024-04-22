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
        if (empty($fname) || empty($lname) || empty($email) || empty($phone) || empty($state)) {
            //Data is invalid
            echo "Please fill out the data";
        } else {
            //Data is valid
            $f3->set('SESSION.userFirstName', $fname);
            $f3->set('SESSION.userLastName', $lname);
            $f3->set('SESSION.userEmail', $email);
            $f3->set('SESSION.userState', $state);
            $f3->set('SESSION.userPhone', $phone);
            //Redirect to the experience route
            $f3->reroute("apply2");
        }
    }
    // Render a view page
    $view = new Template();
    echo $view->render('views/app-personal-info.html');
});

// Define a route to apply2
$f3->route('GET|POST /apply2', function($f3) {
    session_start();

    //Check if the form has been posted
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $bio = $_POST['user-bio'];
        $github = $_POST['user-github'];
        $years = $_POST['user-years'];
        $relocate = $_POST['user-relocate'];
        //Validate the data
        if (empty($bio) || empty($github) || empty($years) || empty($relocate)) {
            //Data is invalid
            echo "Please fill out the data";
        } else {
            //Data is valid
            $f3->set('SESSION.userBio', $bio);
            $f3->set('SESSION.userGithub', $github);
            $f3->set('SESSION.userYears', $years);
            $f3->set('SESSION.userRelocate', $relocate);
            //Redirect to the mailing route
            $f3->reroute("apply3");
        }
    }

    // Render a view page
    $view = new Template();
    echo $view->render('views/app-experience.html');
});

// Define a route to apply3
$f3->route('GET|POST /apply3', function($f3) {
    session_start();


    //Check if the form has been posted
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Set up mailings
        $jobmailings = "";
        $vertmailings = "";
        for ($i = 1; $i < 9; $i++) {
            $jmailing = $_POST["user-job$i"];
            $vmailing = $_POST["user-verticals$i"];
            if(!empty($jmailing)) {
                if($jobmailings === "") {
                    $jobmailings = $jmailing;
                } else {
                    $jobmailings = $jobmailings . ", " . $jmailing;
                }
            }
            if(!empty($vmailing)) {
                if($vertmailings === "") {
                    $vertmailings = $vmailing;
                } else {
                    $vertmailings = $vertmailings . ", " . $vmailing;
                }
            }
        }

        //Combine the mailings
        if($jobmailings === "") {
            if($vertmailings === "") {
                $combinemailings = "";
            } else {
                $combinemailings = $vertmailings;
            }
        } else if ($vertmailings === "") {
            $combinemailings = $jobmailings;
        } else {
            $combinemailings = $jobmailings . ", " . $vertmailings;
        }

        //Validate the data
        if ($combinemailings === "") {
            //Data is invalid
            echo "Please fill a mailing";
        } else {
            //Data is valid
            $f3->set('SESSION.userMailings', $combinemailings);
            //echo $combinemailings;
            //Redirect to the summary route
            $f3->reroute("summary");
        }
    }

    // Render a view page
    $view = new Template();
    echo $view->render('views/app-mailing.html');
});

// Define a route to summary
$f3->route('GET|POST /summary', function($f3) {
    session_start();
    //echo "yay u madeit!";
    // Render a view page
    $view = new Template();
    echo $view->render('views/app-summary.html');
});

// Run Fat-Free
$f3->run();