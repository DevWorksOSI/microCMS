<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
	header("Location: /");
}
else
{
	echo '<section>';
	echo '<main>';
	echo'<div class="main">';
	if(isset($_SESSION['user_id']))
	{
		$name = $_SESSION['username'];
		$welcome = 'Welcome '.$name.'';
	}
	else
	{
		$welcome = 'Welcome';
	}
		
	echo '<h3>'.$welcome.'</h3>';
	echo '</div>';
	echo '<div class="main">';
	echo '<p>This is the official Home of the Devworks OSI microCMS.</p>';
	echo '<p><strong>microCMS Version 1.5.1 Codename:</strong> Odin</p>';
	echo '</div>';
	echo '<div class="main">';
	echo '<p>The official public release of the microCMS will be available to download soon, once we finish up writing the remainder of the Management Interface.</p>';
	echo '<p><strong>Target Date:</strong> Not Set.</p>';
	echo '</div>';
	echo '<div class="main">';
	echo '<p><a href="/codex">Development Continues</a>.</p>';
	echo '<p>This site runs on the latest version of the microCMS</p>';
	echo '</div>';
	echo '</main>';
	echo '</section>';
}
?>
