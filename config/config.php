<?php
/*
 * Database Settings
 * @ User
 * @ Password
 * @ Database
 * @ Host
*/
define('DBUSER', 'u343006961_mcms');
define('DBPASS', 'Ru$197303');
define('DBNAME', 'u343006961_mcms');
define('DBHOST', 'localhost');

$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}