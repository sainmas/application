<?php

class Controller
{
    private $_f3;

    function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    function home()
    {

        // Render a view page
        $view = new Template();
        echo $view->render('views/home.html');
    }

    function apply1()
    {
        //Add variables
        $fname = "";
        $lname = "";
        $email = "";
        $state = "";
        $phone = "";

        //Check if the form has been posted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Validate the data
            if (Validate::validName($_POST['first-name'])) {
                $fname = $_POST['first-name'];
            } else {
                $this->_f3->set('errors["userFName"]', 'Please enter a first name');
            }
            if (Validate::validName($_POST['last-name'])) {
                $lname = $_POST['last-name'];
            } else {
                $this->_f3->set('errors["userLName"]', 'Please enter a last name');
            }
            if (Validate::validEmail($_POST['user-email'])) {
                $email = $_POST['user-email'];
            } else {
                $this->_f3->set('errors["userEmail"]', 'Please enter a valid email');
            }

            $state = $_POST['user-state'];

            if (Validate::validPhone($_POST['phone-num'])) {
                $phone = $_POST['phone-num'];
            } else {
                $this->_f3->set('errors["userPhone"]', 'Please enter a valid phone number');
            }


            //Add the data to the session array
            $this->_f3->set('SESSION.userFirstName', $fname);
            $this->_f3->set('SESSION.userLastName', $lname);
            $this->_f3->set('SESSION.userEmail', $email);
            $this->_f3->set('SESSION.userState', $state);
            $this->_f3->set('SESSION.userPhone', $phone);

            //Redirect to the experience route
            if (empty($this->_f3->get('errors'))) {
                $this->_f3->reroute('apply2');
            }

        }
        // Render a view page
        $view = new Template();
        echo $view->render('views/app-personal-info.html');
    }

    function apply2() {
        //Add variables
        $bio = "";
        $github = "";
        $years = "";
        $relocate = "";

        //Check if the form has been posted
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $bio = $_POST['user-bio'];
            $github = Validate::validGithub($_POST['user-github']);
            $relocate = $_POST['user-relocate'];

            //Validate the years
            if (Validate::validExperience($_POST['user-years'])) {
                $years = $_POST['user-years'];
            } else {
                $this->_f3->set('errors["userYears"]', 'Please select an option');
            }

            //Set session variables
            $this->_f3->set('SESSION.userBio', $bio);
            $this->_f3->set('SESSION.userGithub', $github);
            $this->_f3->set('SESSION.userYears', $years);
            $this->_f3->set('SESSION.userRelocate', $relocate);

            //Redirect to the mailing route
            if(empty($this->_f3->get('errors'))) {
                $this->_f3->reroute('apply3');
            }
        }

        // Get the data from the model
        // add it to the F3 hive
        $this->_f3->set('years', DataLayer::getYears());
        $this->_f3->set('relocate', DataLayer::getRelocate());

        // Render a view page
        $view = new Template();
        echo $view->render('views/app-experience.html');
    }

    function apply3() {
        // Get the data from the model
        // add it to the F3 hive
        $softwareJobs = DataLayer::getSoftwareJobs();
        $this->_f3->set('jobs', $softwareJobs);
        $industryVerticals = DataLayer::getIndustryVerticals();
        $this->_f3->set('industryVerticals', $industryVerticals);

        //Check if the form has been posted
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Set up job mailings
            $jobMailings = Validate::getMailing($softwareJobs);

            //Set up vertical mailings
            $vertMailings = Validate::getMailing($industryVerticals);


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
            $this->_f3->set('SESSION.userMailings', $combineMailings);
            //Redirect to the summary route
            $this->_f3->reroute("summary");
        }

        // Render a view page
        $view = new Template();
        echo $view->render('views/app-mailing.html');
    }

    function summary() {
        //echo "yay u madeit!";
        // Render a view page
        $view = new Template();
        echo $view->render('views/app-summary.html');
    }
}