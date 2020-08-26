<?php
/*
Core 
Description: takes variables from all core files and comiles them into one file, it gets included in index and makes everything available.
It will also have re assignments (mc-core/database/db query-> becomes mcdb)
Version: 1.0
since microCMS Version 1.5
Author: Scott Cilley
Author URI: https://www.dwosi.us
*/

require_once('../../../../mc-core/autoload.php');
use site\core;
use site\settings;
use database\db;
$mcdb = new db();
$mcCore = new core();
$mcSite = new site();

function do_header()
{
	global $mcdb;
	$query = "SELECT * FROM mc_settings";
	$result = $mcdb->query($query);
	$setting = $mcdb->fetch_assoc($result);
	$theme = $setting['site_theme'];
	include 'mc-content/themes/'.$theme.'/header.php';
}

function do_footer()
{
	global $mcdb;
	$query = "SELECT * FROM mc_settings";
	$result = $mcdb->query($query);
	$setting = $mcdb->fetch_assoc($result);
	$theme = $setting['site_theme'];
	include 'mc-content/themes/'.$theme.'/footer.php';
}
