<?php

/*
 * Loader
 *
*/

spl_autoload_register(function($name){
        require_once 'mc-core/'.str_replace('\\','/',$name).'.php';
});

use site\core;
use site\settings;
use site\blogs;
use database\db;
use sentry\security;


$core = new core();
$db = new db();
$settings = new settings();
$blogs = new blogs();
$sentry = new security();

// Load Base Settings
$base_url = $settings->base_url;
$site_name = $settings->site_name;
$description = $settings->description;
$keywords = $settings->keywords;
$theme = $settings->site_theme;
$facebook = $settings->facebook;
$twitter = $settings->twitter;
$youtube = $settings->youtube;
$instagram = $settings->instagram;
$timezone = $settings->time_zone;
$admin_email = $settings->admin_email;


// Load Sentry functions
$sentry->httpbl_check();
$ip = $sentry->get_real_ip();
$sentry->ip_location($ip);
$sentry->check_ban($ip);

// Core Functions
$logged_in = $core->logged_in();
$is_admin = $core->is_admin();

// Blog Functions
$lastBlog = $blogs->get_lastBlog();
