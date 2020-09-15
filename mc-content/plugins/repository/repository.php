<?php
/*
Plugin name: Repository
Text Domain: repository
Author: Scott Cilley <scilley@dwosi.us>
Author URI: https://www.dwosi.us
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Description: Public Repository Plugin for the microCMS, @ microCMS.ORG
Requires at least: Since 1.5
Requires PHP: 7.4.8
Version: 0.1.0
*/


/*
There should be absolutely no HTML here. Either direct code or functions
You may even use an op/switch situation
How you code your plugins is entirely up to you, as long as it does not interfere
with the Core Code.
*/

/*
 * Function operatives
 * Set the operation variable for the switch
*/
if (isset($_GET['op']))
{
   $d = $_GET['op'];
}
elseif (isset($_POST['op']))
{
   $d = $_POST['op'];
} 
else
{
   $d = NULL;
}

function products()
{
   // Include public view
   include 'mc-content/plugins/repository/public/repository-public.php';
}

function plugins()
{
   // Plugins
   include 'mc-content/plugins/repository/public/repository-public-plugins.php';
}

function themes()
{
   // Themes
   include 'mc-content/plugins/repository/public/repository-public-themes.php';
}

function plugin_upload()
{
   // Upload (Must be logged in)
   include 'mc-content/plugins/repository/public/repository-public-plugin-upload.php';
}

function theme_upload()
{
   // Upload (Must be logged in)
   include 'mc-content/plugins/repository/public/repository-public-theme-upload.php';
}

/*
 * Switch
 * Allows function to be used
 * $d is derived from the Function operatives
*/
switch($d)
{
   // plugins
   case 'plugins':
   plugins();
   break;
   
   // themes
   case 'themes':
   themes();
   break;
   
   // plugin upload
   case 'plugin_upload':
   plugin_upload();
   break;
   
   // theme upload
   case 'theme_upload':
   theme_upload();
   break;
				
   // Main
   default:
   products();
   break;
}
