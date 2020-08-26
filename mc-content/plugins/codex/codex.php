<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
	header("Location: /");
}
else
{
	echo '<div class="main">';
	echo '<p><small><a href="/" hreflang="en">Home</a> >> Codex</small></p>';
	
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
	
	function codex() // change module_name
	{
	   echo '<p>Codex > <a href="/dev/core">Core</a> > <a href="/dev/plugins">Plugins</a> > <a href="/dev/themes">Themes</a> > <a href="/dev/roadmap">Road Map</a></p>';
	   echo '<h3>microCMS Codex</h3>';
	   echo '<p>The microCMS Codex is the base rules for development within the microCMS Project.</p>';
	   echo '<p>If you are looking to become a Developer in the microCMS project, please read everything on this page and the adjoining Core, Plugins Themes and Road Map pages.<p>';
	   echo '<p>As of the latest revamp, you will find that the root layout is much like that of WordPress but rest assured that we structured it that way to keep things neat and clean. Our API and Load systems are nothing like the ones in use with WordPress.</p>';
	   echo '<p>Our goal is small, simple, easy to use and simple to install as well as update. As with the original concept of this project, to keep it within a small footprint on a webserver.</p>';
	   echo '<p>It is <strong>NOT</strong> our goal to make this as big as WordPress, Drupal, PHPNuke, etc.</p>';
	   echo '<p>This page will be extended over time and as time allows. You may join us on our <a href="https://devworksosi.slack.com" target="_blank"><strong>Slack Server</strong></a> if you are considering on getting involved.';
	}
	
	function core()
	{
	   echo '<p><a href="/codex">Codex</a> > <strong>Core</strong> > <a href="/dev/plugins">Plugins</a> > <a href="/dev/themes">Themes</a> > <a href="/dev/roadmap">Road Map</a></p>';
	   echo '<h3>microCMS Codex -> Core</h3>';
	   echo '<p>The microCMS Core is a set of core classes that run the entire site. As of now we have the sites Core Functionality, Settings, Blogs and Data</p>';
	   echo '<p>The Core can be extended by creating new classes in the <code>mc-core</code> directory then linking them to index. With that we must stress that all Core Functionality must be in a class file.';
	}
	
	function plugins()
	{
	   echo '<p><a href="/codex">Codex</a> > <a href="/dev/core">Core</a> > <strong>Plugins</strong> > <a href="/dev/themes">Themes</a> > <a href="/dev/roadmap">Road Map</a></p>';
	   echo '<h3>microCMS Codex -> Plugins</h3>';
	   echo '<p>Plugins for the microCMS are quite simply modules that extend the microCMS in many ways. This page in itself is a plugin. We have yet to decide if we are going to require plugins to be class driven and have languages, etc. </p>';
	}
	
	function themes()
	{
	   echo '<p><a href="/codex">Codex</a> > <a href="/dev/core">Core</a> > <a href="/dev/plugins">Plugins</a> > <strong>Themes</strong> > <a href="/dev/roadmap">Road Map</a></p>';
	   echo '<h3>microCMS Codex -> Themes</h3>';
	   echo '<p>Themes are what make a CMS driven site look good and we have plans to make the installation of them quite easy.</p>';
	   echo '<p><strong>Whats required in a theme:</strong><br><ul><li> <code>css</code></li><li> <code>images</code></li><li> <code>js</code> if needed</li><li> <code>header</code></li><li> <code>footer</code></li><li> <code>front_page</code></li></ul></p>';
	  echo '<p>The sites primary control looks for <code>front_page.php</code> in the theme directory.</p>';
	}
	
	function roadmap()
	{
	   echo '<p><a href="/codex">Codex</a> > <a href="/dev/core">Core</a> > <a href="/dev/plugins">Plugins</a> > <a href="dev/themes">Themes</a> > <strong>Road Map</strong></p>';
	   echo '<h3>microCMS Codex -> Road Map</h3>';
	   echo '<p>Last update, Tuesday, August 25, 2020</p>';
	   echo '<p>';
	   echo '<ul>';
	   echo '<li><strong>To Do</strong>';
	   echo '<ul>';
	   echo '<li> Administration Dashboard</li>';
	   echo '<li> Site Settings</li>';
	   echo '<li> Plugin Management</li>';
	   echo '<li> Theme Management</li>';
	   echo '<li> Blog Management</li>';
	   echo '<li> Site Permalinks (<code>PHP/Data</code>, not <code>.htaccess</code>)</li>';
	   echo '<li> Misc Core Functions (<code>do_header()</code>, <code>do_footer()</code>, <code>load_css()</code>, <code>load_scripts()</code>, etc.)</li>';
	   echo '</ul>';
	   echo '</li>';
	   echo '<li><strong>What\'s Done</strong>';
	   echo '<ul>';
	   echo '<li> <strong>Core</strong></li>';
	   echo '<li> Database</li>';
	   echo '<li> Settings</li>';
	   echo '<li> Core Functionality</li>';
	   echo '<li> Simple Bootstrap Theme</li>';
	   echo '</ul>';
	   echo '</li>';
	   echo '</p>';
	   echo '<p>microCMS Version 1.5.1, Codename: Odin</p>';
	}
	
	/*
	 * Switch
	 * Allows function to be used
	 * $d is derived from the Function operatives
	 */
	switch($d) {
	   // core
	   case 'core':
	   core();
	   break;
				
	   // plugins
	   case 'plugins':
	   plugins();
	   break;
				
	   // themes
	   case 'themes':
	   themes();
	   break;
	   
	   // roadmap
	   case 'roadmap':
	   roadmap();
	   break;
				
	   // Main
	   default:
	   codex();
	   break;
	}
	
	
	echo '</div>';
}
