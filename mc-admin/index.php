<?php
ob_start();
session_start();
if(isset($_SESSION['admin']))
{
   $user_status = $_SESSION['admin'];
}
if($user_status != 1)
{
  header("Location: /");
}
else
{
	include '../mc-config.php';
	include '../mc-core/site/class-settings.php';
	include '../mc-core/site/class-core.php';
	include '../mc-core/database/class-db.php';
	include '../mc-includes/functions.php';
	include 'includes/header.php';
	// Are we in debug mode?
	if(defined('DEBUG') && DEBUG){
       mc_debug(true);
	}
	include 'includes/menu.php';
	echo '<div class="col pages">';
	include 'includes/router.php';
	$router = new router();
	// Static Route (main)
	$router->get('/', function () {
	   include 'pages/main.php';
	});
	// Dynamic Route (posts)
	$router->match('GET|POST', '/posts', function () {
	   include 'pages/posts.php';
	});
	// Dynamic Route (sentry)
	$router->match('GET|POST', '/sentry', function () {
	   include 'pages/sentry.php';
	});
	// Dynamic Route (plugins)
	$router->match('GET|POST', '/plugins', function () {
	   include 'pages/plugins.php';
	});
	// Dynamic Route (settings)
	$router->match('GET|POST', '/settings', function () {
	   include 'pages/settings.php';
	});
	// Dynamic Route (themes)
	$router->match('GET|POST', '/themes', function () {
	   include 'pages/themes.php';
	});
	// Dynamic Route (updates)
	$router->match('GET|POST', '/updates', function () {
	   include 'pages/updates.php';
	});
	// Dynamic Route (users)
	$router->match('GET|POST', '/users', function () {
	   include 'pages/users.php';
	});
	$admin_switch = mc_adminSwitch();
	/*
	while($row = mc_fetchAssoc($admin_switch))
	{
		$plugin = $row['plugin_slug'];
		if(file_exists('/mc-content/plugins/'.$plugin.'/admin/'.$plugin.'-admin.php')
		{
			$router->match('GET|POST', '/'.$plugin.'', function () {
	           include '/mc-content/plugins/'.$plugin.'/admin/'.$plugin.'-admin.php';
	        });
		}
	}
	*/
	$router->run();
	echo '</div>';
	include 'includes/footer.php';
	ob_end_flush();
}