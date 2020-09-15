<?php
/*
Plugin name: Example Plugin
Text Domain: example-plugin
Author: Class Rebecca Boisvert <rboisvert@dwosi.us>
Author URI: https://www.dwosi.us
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Description: This is the example module for microCMS
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
public_page();

function public_page()
{
   // include public template
   include('mc-content/plugins/example-plugin/public/example-plugin-public.php');
}
