<?php
include 'mc-config.php';
function check_install()
{
   // check connection
   if (mysqli_connect_errno())
   {
       header("Location: /mc-install.php");
   }
}
check_install();
include 'mc-core/loader.php';
include 'mc-includes/functions.php';
session_start();

$maintenance = check_maintenance();
if($maintenance == 1)
{
	include 'mc-includes/maintenance.php';
}
else
{
	if(file_exists('mc-content/themes/'.$site_theme.'/functions.php'))
	{
		include 'mc-content/themes/'.$site_theme.'/functions.php';
	}
	date_default_timezone_set($timezone);
	include 'mc-content/themes/'.$site_theme.'/header.php';

    // Are we in debug mode?
	if(defined('DEBUG') && DEBUG){
       mc_debug(true);
	   echo '<!-- DEBUG is Active -->';
	}
	// Custom 404 Handler
	$router->set404(function () {
	   header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
	   require 'mc-includes/core_plugins/errors/404.php';
	});

	// Before Router Middleware
	$router->before('GET', '/.*', function () {
	   header('X-Powered-By: microCMS');
	});

	// Static route: / (homepage)
	$router->get('/', function () {
	   require 'mc-content/themes/'.get_siteTheme().'/front_page.php';
	});

	// Static route: / (login)
	$router->match('GET|POST', '/login', function () {
	   require 'mc-includes/core_plugins/account/login.php';
	});

	// Static route: / (logout)
	$router->get('/logout', function () {
	   require 'mc-includes/core_plugins/account/logout.php';
	});

	// Static route: / (signup)
	$router->match('GET|POST','/signup', function () {
	   require 'mc-includes/core_plugins/account/signup.php';
	});

	// Static route: / (posts)
	$router->get('/posts', function () {
	   require 'mc-includes/core_plugins/posts/posts.php';
	});

	// Dynamic route: / (posts/slug)
	$router->match('GET|POST', '/posts(/[a-z0-9_-]+)', function ($slug) {
	   require 'mc-includes/core_plugins/posts/show_post.php';
	});

	// Static route: / (plugins repository)
	$router->get('/products/plugins', function () {
	   require 'mc-content/plugins/repository/public/repository-public-plugins.php';
	});

	// Static route: / (themes repository)
	$router->get('/products/themes', function () {
	   require 'mc-content/plugins/repository/public/repository-public-themes.php';
	});

	// Static route: / (privacy policy)
	$router->get('/privacy-policy', function () {
	   require 'mc-includes/core_plugins/privacy-policy/privacy-policy.php';
	});

	// Plugins
	$mcdb = new database\db;
	$query = "SELECT * FROM mc_plugins WHERE plugin_status = 1";
	$result = $mcdb->query($query);
	while($plugins = $mcdb->fetch_assoc($result))
	{
	   $plugin = $plugins['plugin_slug'];
	   $router->get('/'.$plugin.'', function() use($plugin){
		 require 'mc-content/plugins/'.$plugin.'/'.$plugin.'.php';
	   }, ['get','post']);
	}
	// Run the router
	$router->run();
	include 'mc-content/themes/'.$site_theme.'/footer.php';
}