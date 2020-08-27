<?php
session_start();
if(isset($_SESSION['admin']))
{
	$admin = $_SESSION['admin'];
}

include 'mc-core/loader.php';

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

// Error Checking
$core->check_errors(true);

 // Include the theme's Header
include 'mc-content/themes/'.$theme.'/header.php';

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
while($row = $db->fetch_assoc($result))
{
    $plugin = $row['plugin_slug'];
	
    if ($d === $plugin)
	{
        include 'mc-content/plugins/'.$plugin.'/'.$plugin.'.php';
        $finished = true;
        break;
    }
    /*
	if ($d === 'manage')
	{
		include 'modules/manage/main.php';
		$finished = true;
		break;
	}
    */
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
	if ($d === 'account')
	{
		include 'mc-includes/core_plugins/account/user.php';
		$finished = true;
		break;
	}
}

if (!$finished)
{
    include 'mc-content/themes/'.$theme.'/front_page.php';
}


// Do SSL and Sentry check
include 'mc-includes/footer-check.php';


// Include the themes Footer
include 'mc-content/themes/'.$theme.'/footer.php';

?>
