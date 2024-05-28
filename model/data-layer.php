<?php

/* This is my data layer
 * This belongs to the model
 */
Class DataLayer {
    // Gets the years for the application app
    static function getYears() {
        return array('0-2', '2-4', '4+');
    }

    //returns the options for relocate
    static function getRelocate() {
        return array('Yes', 'No', 'Maybe');
    }

    //returns the options for software jobs
    static function getSoftwareJobs() {
        return array('Javascript', 'PHP', 'Java', 'Python', 'HTML', 'CSS', 'ReactJS', 'NodeJS');
    }

    //returns the options for industry verticals
    static function getIndustryVerticals() {
        return array('SaaS', 'Health tech', 'Ag tech', 'HR tech', 'Industrial Tech', 'Cybersecurity');
    }
}