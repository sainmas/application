<?php

// 328/pets/index.php

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require autoload.php
require_once ('vendor/autoload.php');
require_once ('model/validate.php');
require_once ('model/data-layer.php');

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

    //Add variables
    $fname = "";
    $lname = "";
    $email = "";
    $state = "";
    $phone = "";

    //Check if the form has been posted
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        //Validate the data
        if (validName($_POST['first-name'])) {
            $fname = $_POST['first-name'];
        } else {
            $f3->set('errors["userFName"]', 'Please enter a first name');
        }
        if (validName($_POST['last-name'])) {
            $lname = $_POST['last-name'];
        } else {
            $f3->set('errors["userLName"]', 'Please enter a last name');
        }
        if (validEmail($_POST['user-email'])) {
            $email = $_POST['user-email'];
        } else {
            $f3->set('errors["userEmail"]', 'Please enter a valid email');
        }

        $state = $_POST['user-state'];

        if (validPhone($_POST['phone-num'])) {
            $phone = $_POST['phone-num'];
        } else {
            $f3->set('errors["userPhone"]', 'Please enter a valid phone number');
        }


        //Add the data to the session array
        $f3->set('SESSION.userFirstName', $fname);
        $f3->set('SESSION.userLastName', $lname);
        $f3->set('SESSION.userEmail', $email);
        $f3->set('SESSION.userState', $state);
        $f3->set('SESSION.userPhone', $phone);

        //Redirect to the experience route
        if(empty($f3->get('errors'))) {
            $f3->reroute('apply2');
        }

    }
    // Render a view page
    $view = new Template();
    echo $view->render('views/app-personal-info.html');
});

// Define a route to apply2
$f3->route('GET|POST /apply2', function($f3) {
    session_start();

    //Add variables
    $bio = "";
    $github = "";
    $years = "";
    $relocate = "";

    //Check if the form has been posted
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $bio = $_POST['user-bio'];
        $github = validGithub($_POST['user-github']);
        $relocate = $_POST['user-relocate'];

        //Validate the years
        if (validExperience($_POST['user-years'])) {
            $years = $_POST['user-years'];
        } else {
            $f3->set('errors["userYears"]', 'Please select an option');
        }

        //Set session variables
        $f3->set('SESSION.userBio', $bio);
        $f3->set('SESSION.userGithub', $github);
        $f3->set('SESSION.userYears', $years);
        $f3->set('SESSION.userRelocate', $relocate);

        //Redirect to the mailing route
        if(empty($f3->get('errors'))) {
            $f3->reroute('apply3');
        }
    }

    // Get the data from the model
    // add it to the F3 hive
    $f3->set('years', getYears());
    $f3->set('relocate', getRelocate());

    // Render a view page
    $view = new Template();
    echo $view->render('views/app-experience.html');
});


// Define a route to apply3
$f3->route('GET|POST /apply3', function($f3) {
    session_start();

    // Get the data from the model
    // add it to the F3 hive
    $softwareJobs = getSoftwareJobs();
    $f3->set('jobs', $softwareJobs);
    $industryVerticals = getIndustryVerticals();
    $f3->set('industryVerticals', $industryVerticals);

    //Check if the form has been posted
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Set up job mailings
        $jobMailings = getMailing($softwareJobs);

        //Set up vertical mailings
        $vertMailings = getMailing($industryVerticals);


        //Combine the mailings
        if($jobMailings === "") {
            if($vertMailings === "") {
                $combineMailings = "";
            } else {
                $combineMailings = $vertMailings;
            }
        } else if ($vertMailings === "") {
            $combineMailings = $jobMailings;
        } else {
            $combineMailings = $jobMailings . ", " . $vertMailings;
        }

        //Set session variable
        $f3->set('SESSION.userMailings', $combineMailings);
        //Redirect to the summary route
        $f3->reroute("summary");
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