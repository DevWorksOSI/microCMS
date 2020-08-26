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
$plugin_version = '1.0.0';
?> 
<!-- This file should have html mixed with a little PHP to produce whatever content that you want. -->
<link rel="stylesheet" href="mc-content/plugins/example-plugin/public/css/style.css">
<div class="example-plugin">
  <p>This is an example plugin version <?php echo $plugin_version;?></p>
  <p>It was made with love, to demonstrate how to create a simple plugin for the microCMS.</p>
  <p>Of course, it can be extended to build bigger and better with more functionality. That is entirely up to you.</p>
  <p>~ RB</p>
</div>
