<?php
/*
 * Database Settings
 * @ User
 * @ Password
 * @ Database
 * @ Host
*/
define('DBUSER', '');
define('DBPASS', '');
define('DBNAME', '');
define('DBHOST', 'localhost');

$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
