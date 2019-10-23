<?php
session_start();
if(isset($_SESSION['admin']))
{
	$admin = $_SESSION['admin'];
}
require_once('app/autoload.php');
use site\core;
use site\settings;
use site\blogs;
use database\db;
$core = new core();
$db = new db();
$settings = new settings();
$blogs = new blogs();

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

$bing_code = $settings->bing_verification;
$google_code = $settings->google_verification;
$base_url = $settings->base_url;
$site_name = $settings->site_name;
$description = $settings->description;
$keywords = $settings->keywords;
$theme = $settings->site_theme;
$facebook = $settings->facebook;
$twitter = $settings->twitter;
$youtube = $settings->youtube;
$instagram = $settings->instagram;
$site_logo = $settings->site_logo;
// Error Checking
$core->check_errors(1);

if (isset($_REQUEST['_SESSION']))
{
	die("Get lost Muppet!");
}

 // Include the theme's Header
include 'themes/'.$theme.'/header.php';
$query = "SELECT * FROM modules WHERE active = 1";
$result = $db->query($query);
$finished = false;
while($row = mysqli_fetch_assoc($result))
{
    $module = $row['module_link'];
	$active = $row['active'];
	
    if ($d === $module)
	{
        include 'modules/'.$module.'/main.php';
        $finished = true;
        break;
    }
	if ($d === 'manage')
	{
		include 'modules/manage/main.php';
		$finished = true;
		break;
	}
	if ($d === 'error')
	{
		include 'modules/error/main.php';
		$finished = true;
		break;
	}
	if ($d === 'login')
	{
		include 'modules/account/login.php';
		$finished = true;
		break;
	}
	if ($d === 'logout')
	{
		include 'modules/account/logout.php';
		$finished = true;
		break;
	}
	if ($d === 'signup')
	{
		include 'modules/account/signup.php';
		$finished = true;
		break;
	}
	if ($d === 'blogs')
	{
		include 'modules/blogs/main.php';
		$finished = true;
		break;
	}
}

if (!$finished)
{
    include 'modules/main.php';
}


// Include the theme's Header
//include 'themes/'.$theme.'/header.php';

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
//include $content;
// Include the themes Footer
include 'themes/'.$theme.'/footer.php';
?>