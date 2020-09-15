<?php
/*
Plugin name: Example Plugin
Text Domain: example-plugin
Author: Rebecca Boisvert <rboisvert@dwosi.us>
Author URI: https://www.dwosi.us
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Description: This is the example module for the microCMS
Requires at least: Since 1.5
Requires PHP: 7.4.8
Version: 0.1.0
*/
?> 
<!-- This file should have html mixed with a little PHP to produce whatever content that you want. -->
<link rel="stylesheet" href="mc-content/plugins/development/public/css/style.css">
<div class="container">
  <div id="development">
    <div class="content">
      <h2><i class="fa fa-code" aria-hidden="true"></i> Development</h2>
      <p>microCMS Delopment Status</p>
      <h3>Core</h3>
      <p>Core is comprised of Settings, Core Methods, Blog Methods, Database Methods Sentry Security Methods and Routing Methods</p>
      <p>What is does is run the entire core of the site, and gets interacted with by a functions file in <code>mc-includes</code> that acts as a front-end for all back-end methods.</p>
	  <p><strong>Notice:</strong> Although the file structure does follow the WordPress way of doing things, this is not a rewrite of or a new version of WordPress, the microCMS itself has been under development 
	  for years and has never strived to be another WordPress CMS.</p>
	  
      <p>
	  <ul>
	    <li><strong>Settings</strong> <i>100%</i></li>
		<li><strong>Core</strong> <i>100%</i></li>
		<li><strong>Posts</strong> <i>100%</i></li>
		<li><strong>Database</strong> <i>100%</i></li>
		<li><strong>Sentry</strong> <i>100%</i></li>
		<li><strong>Routing</strong> <i>100%</i></li>
	  </ul>
	  </p>
	  
	  <h3>Admin Dashboard</h3>
      <p>As with every CMS, there comes a dashboard</p>
      <p>The microCMS Dashboard acts as a site all by itself but utilizes the methods from the functions file to do its job.</p>
	  
      <p>
	  <ul>
	    <li><strong>Posts</strong> <i>90%</i></li>
		<li><strong>Plugins</strong> <i>0%</i></li>
		<li><strong>Sentry</strong> <i>90%</i></li>
		<li><strong>Settings</strong> <i>0%</i></li>
		<li><strong>Themes</strong> <i>0%</i></li>
		<li><strong>Updates</strong> <i>0%</i></li>
		<li><strong>Users</strong> <i>0%</i></li>
		<li><strong>Site Health</strong> <i>0%</i></li>
	  </ul>
	  </p>
	  
	  <h3>External API</h3>
      <p>The microCMS Control Server</p>
      <p>Its purpose is to handle Version and Update Control</p>
	  
      <p>
	  <ul>
	    <li><strong>Sentry</strong> <i>For PHP-Sentry with microCMS and External Websites 90%</i></li>
		<li><strong>microCMS</strong> <i>50%</i></li>
		<li><strong>API</strong> <i>30%</i></li>
	  </ul>
	  </p>
	  
	  <h3>Development Site</h3>
      <p>Where the microCMS is staged <i>100%</i></p>
	  
	  <h3>Codex Site</h3>
      <p>Where the Codex is accessible for developers <i>0%</i></p>
	  
	  <h3>Project Storage and Git</h3>
      <p>This project originally started being stored on Github but as of late we have kept the code stored internally on an internal git server for quality control. We may push current code to Github which is where
	  we hope to have other Developers take an interest in and participate in, the development of this project.</p>
	  <p>If you do have an interest in jumping on the Dev team for this project, please start <a href="/get-involved"><strong>here</strong></a></p>

     </div>
  </div>
  <hr>
</div>
