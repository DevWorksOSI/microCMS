<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
	header("Location: /");
}
else
{
        echo '<link rel="stylesheet" href="mc-content/plugins/codex/public/css/codex.css">';
        echo '<div class="container">';
        echo '<div class="row">';
	echo '<div class="codex">';
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
	   include 'mc-content/plugins/codex/public/codex.php';
	}
	
	function core()
	{
	  include 'mc-content/plugins/codex/public/core.php';
	}
	
	function plugins()
	{
	   include 'mc-content/plugins/codex/public/plugin.php';
	}
	
	function themes()
	{
	   include 'mc-content/plugins/codex/public/theme.php';
	}
	
	function roadmap()
	{
	   include 'mc-content/plugins/codex/public/roadmap.php';
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
	echo '</div>';
	echo '</div>';
}
