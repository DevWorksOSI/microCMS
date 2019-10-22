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
	echo '<p><strong>microCMS Version 2.0</strong></p>';
	echo '</div>';
	echo '</main>';
	echo '</section>';
}
?>