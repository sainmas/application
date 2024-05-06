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

//returns the options for software jobs
function getSoftwareJobs() {
    return array('Javascript', 'PHP', 'Java', 'Python', 'HTML', 'CSS', 'ReactJS', 'NodeJS');
}

//returns the options for industry verticals
function getIndustryVerticals() {
    return array('SaaS', 'Health tech', 'Ag tech', 'HR tech', 'Industrial Tech', 'Cybersecurity');
}