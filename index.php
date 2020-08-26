<?php
session_start();
if(isset($_SESSION['admin']))
{
	$admin = $_SESSION['admin'];
}
//require_once('mc-includes/core/site.php');
require_once('mc-core/autoload.php');
use site\core;
use site\settings;
use site\blogs;
use database\db;
$core = new core();
$db = new db();
$settings = new settings();
$blogs = new blogs();

//Function operatives
 if (isset($_GET['page']))
 {
	 $d = $_GET['page'];
 } 
elseif (isset($_POST['page']))
{ // Forms
	 $d = $_POST['page'];
}
 else
 {
	 $d = NULL;
 }

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
// Error Checking
$core->check_errors(true);

 // Include the theme's Header
include 'mc-content/themes/'.$theme.'/header.php';
//$core->do_header();
/*
 * Prevention Session Injection
 */
if (isset($_REQUEST['_SESSION']))
{
	die("Get lost Muppet!");
}

// Set the Desired Time Zone
date_default_timezone_set($timezone);

$query = "SELECT * FROM mc_plugins WHERE plugin_status = 1";
$result = $db->query($query);
$finished = false;
while($row = mysqli_fetch_assoc($result))
{
    $plugin = $row['plugin_slug'];
	
    if ($d === $plugin)
	{
        include 'mc-content/plugins/'.$plugin.'/'.$plugin.'.php';
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
		include 'mc-includes/core_plugins/error/error.php';
		$finished = true;
		break;
	}
	if ($d === 'login')
	{
		include 'mc-includes/core_plugins/account/login.php';
		$finished = true;
		break;
	}
	if ($d === 'logout')
	{
		include 'mc-includes/core_plugins/account/logout.php';
		$finished = true;
		break;
	}
	if ($d === 'signup')
	{
		include 'mc-includes/core_plugins/account/signup.php';
		$finished = true;
		break;
	}
	if ($d === 'blogs')
	{
		include 'mc-includes/core_plugins/blogs/main.php';
		$finished = true;
		break;
	}
}

if (!$finished)
{
    include 'mc-content/themes/'.$theme.'/front_page.php';
}


//include $content;


// Include the themes Footer
include 'mc-content/themes/'.$theme.'/footer.php';
//$core->do_footer();
?>
