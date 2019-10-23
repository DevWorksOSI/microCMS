<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
	header("Location: /");
}
else
{
	echo '<div class="main">';
	
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
	
	function module_name_manage() // change module_name
	{
		echo '<p><small><a href="/manage" hreflang="en">Manage</a> >> Module Name</small></p>'; //change Module Name
		echo '<h3>Module Name</h3>'; // change Module Name
	}
	
	function add()
	{
		echo '<p>Comming Soon</p>';
	}
	
	function edit()
	{
		echo '<p>Comming Soon</p>';
	}
	
	function drop()
	{
		echo '<p>Comming Soon</p>';
	}
	
	/*
	 * Switch
	 * Allows function to be used
	 * $d is derived from the Function operatives
	 */
	switch($d) {
		// add
		case 'add':
				add();
				break;
				
		// edit
		case 'edit':
				edit();
				break;
				
		// drop
		case 'drop':
				drop();
				break;
				
		// Main
		default:
			   module_name_manage(); // change module_name
			   break;
	}
	
	
	echo '</div>';
}
?>