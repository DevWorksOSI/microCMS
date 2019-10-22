<?php
session_start();
if(isset($_SESSION['admin']))
{
	$admin = $_SESSION['admin'];
}
require_once('app/autoload.php');
use site\core;
use site\settings;
use database\db;
$core = new core();
$db = new db();
$settings = new settings();

//Function operatives
 if (isset($_GET['p']))
 {
	 $d = $_GET['p'];
 } 
// elseif (isset($_POST['p']))
// { // Forms
	// $d = $_POST['p'];
// }
 else
 {
	 $d = NULL;
 }
//The Page Switch
 switch($d)
 {
	 case 'error':
	 $content = 'modules/error/main.php';
	 break;
	// case 'announcements':
	// $content = 'modules/announcements/main.php';
	// break;
	 case 'enroll':
	 $content = 'modules/enroll/main.php';
	 break;
	case 'manage':
	 $content = 'modules/manage/main.php';
	 break;
	case 'signup':
	 $content = 'modules/account/signup.php';
	 break;
	 case 'login':
	 $content = 'modules/account/login.php';
	 break;
	 case 'logout':
	 $content = 'modules/account/logout.php';
	 break;
	 default:
	 $content = 'modules/main.php';
	 break;
 }
$bing_code = $settings->bing_verification;
$google_code = $settings->google_verification;
$base_url = $settings->base_url;
$site_name = $settings->site_name;
$description = $settings->description;
$keywords = $settings->keywords;
$theme = $settings->site_theme;
// Error Checking
$core->check_errors(1);

// Include the theme's Header
include 'themes/'.$theme.'/header.php';

// Set the Desired Time Zone
//date_default_timezone_set(TIMEZONE);
/*
 * Prevention Session Injection
 */
if (isset($_REQUEST['_SESSION']))
{
	die("Get lost Muppet!");
}
// Include content from each module
include $content;
// Include the themes Footer
include 'themes/'.$theme.'/footer.php';
?>