<?php

// 328/pets/index.php
// Start session
session_start();

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require autoload.php
require_once ('vendor/autoload.php');

// Instantiate the F3 base class
$f3 = Base::instance();
$con = new Controller($f3);

// Define a default route
$f3->route('GET /', function() {
    $GLOBALS['con']->home();
});

// Define a route to apply1
$f3->route('GET|POST /apply1', function() {
    $GLOBALS['con']->apply1();
});

// Define a route to apply2
$f3->route('GET|POST /apply2', function() {
    $GLOBALS['con']->apply2();
});

// Define a route to apply3
$f3->route('GET|POST /apply3', function() {
    $GLOBALS['con']->apply3();
});

// Define a route to summary
$f3->route('GET|POST /summary', function() {
    $GLOBALS['con']->summary();
});

// Run Fat-Free
$f3->run();