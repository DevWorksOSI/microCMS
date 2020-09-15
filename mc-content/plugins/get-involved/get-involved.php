<?php
/*
Plugin name: get Involved
Text Domain: get-involved
Author: Scott Cilley <scilley@dwosi.us>
Author URI: https://www.dwosi.us
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Description: This is the Public Get Involved Plugin for the microCMS
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
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
	header("Location: /");
}
else
{
   echo '<link rel="stylesheet" href="mc-content/plugins/get-involved/public/css/style.css">';
   echo '<div class="container">';
   echo '<div class="row">';
   /*
    * Function operatives
    * Set the operation variable for the switch
    */
    if (isset($_GET['p']))
    {
       $d = $_GET['p'];
    }
    elseif (isset($_POST['p']))
    {
       $d = $_POST['p'];
    } 
    else
    {
       $d = NULL;
    }
    
    function get_involved()
    {
      include 'mc-content/plugins/get-involved/public/get-involved-public.php';
    }
    
    function slack()
    {
       include 'mc-content/plugins/get-involved/public/get-involved-public-slack.php';
    }
    
    /*
     * Switch
     * Allows function to be used
     * $d is derived from the Function operatives
    */
    switch($d) {
      case 'slack':
      slack();
      break;
				
      default:
      get_involved();
      break;
    }
}
