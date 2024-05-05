<?php

/* This is my data layer
 * This belongs to the model
 */

// Gets the years for the application app
function getYears() {
    return array('0-2', '2-4', '4+');
}

//returns the options for relocate
function getRelocate() {
    return array('Yes', 'No', 'Maybe');
}