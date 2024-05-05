<?php

/* Validate data for application app
 */

//checks if there are only characters (no numbers)
function validName($name) {
    return ctype_alnum(trim($name));
}

//uses FILTER_VALIDATE_URL to make sure it real github
function validGithub() {
}

//checks if above 20 characters
function validExperience() {
}

//checks if phone number above 9 characters and bellow 12
function validPhone($phone) {
    return is_numeric($phone) && strlen(trim($phone)) < 13 && strlen(trim($phone)) > 8;
}

//checks if valid email
function validEmail($email) {
    return filter_var(trim($email), FILTER_VALIDATE_EMAIL);
}