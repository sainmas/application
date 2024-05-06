<?php

/* Validate data for application app
 */

//checks if there are only characters (no numbers)
function validName($name) {
    return ctype_alnum(trim($name));
}

//uses FILTER_VALIDATE_URL to make sure it real github
function validGithub($github) {
    return filter_var(trim($github), FILTER_VALIDATE_URL);
}

//checks if above 20 characters
function validExperience($years) {
    return in_array($years, getYears());
}

//checks if phone number above 9 characters and bellow 12
function validPhone($phone) {
    return is_numeric($phone) && strlen(trim($phone)) < 13 && strlen(trim($phone)) > 8;
}

//checks if valid email
function validEmail($email) {
    return filter_var(trim($email), FILTER_VALIDATE_EMAIL);
}


/**
 * Extracts the mailing from the jobs provided and checks if it's provided from the data-layer
 * @param array $jobs array gotten from data-layer, loop over
 * @return mixed|string Combined mailing with commas between each of them
 */
function getMailing(array $jobs)
{
    $mailings = "";
    foreach ($jobs as $job) {
        $dashJob = str_replace(" ", "_", "$job");
        $mail = $_POST[$dashJob];
        //checks if not empty and in the array provided from data-layer
        if (!empty($mail) && in_array($mail, $jobs)) {
            if ($mailings === "") {
                $mailings = $mail;
            } else {
                $mailings = $mailings . ", " . $mail;
            }
        }
    }
    return $mailings;
}