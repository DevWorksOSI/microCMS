<?php

/*
 * Loader
 *
*/
/*
spl_autoload_register(function($class_name){
        require_once 'mc-core/'.str_replace('\\','/class-',$class_name).'.php';
});
*/
include 'database/class-db.php';
include 'sentry/class-security.php';
include 'site/class-blogs.php';
include 'site/class-core.php';
include 'site/class-router.php';
include 'site/class-settings.php';

use site\core;
use site\blogs;
use site\router;
use database\db;
use sentry\security;
use site\settings;

$core = new core();
$sentry = new security();
$blogs = new blogs();
$mcdb = new db();
$settings = new settings();
$router = new router();
global $mcdb;

// Load Sentry functions
$sentry->httpbl_check();
$ip = $sentry->get_real_ip();
$sentry->check_ban($ip);
$sentry->ip_location($ip);

$site_theme = $settings->site_theme;
$site_url = $settings->site_url;
$site_name = $settings->site_name;
$site_description = $settings->site_description;
$site_keywords = $settings->site_keywords;
$timezone = $settings->time_zone;

// Social Media
$facebook = $settings->facebook;
$twitter = $settings->twitter;
$youtube = $settings->youtube;
$instagram = $settings->instagram;
