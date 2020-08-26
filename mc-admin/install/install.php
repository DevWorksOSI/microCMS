<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* install.php
 * 6 Minute or less install
 * Use to install the microCMS
 * requires an established database
 * will write the config file
 * On complete, the admin/install folder will be deleted.
*/

if (isset($_GET['op'])) {
	$d = $_GET['op'];
} else {
	$d = NULL;
}

function step1() {
	echo '<p>Use this form to create your configuration file, continue to the next step when prompted.</p>';
        echo '<p><strong>Ensure that the config directory permissions is set to 0775</strong></p>';
        echo '<p><strong>Ensure that the config/mc-config.php file permissions is set to 0664</strong></p>';
	echo '<form action="install.php?op=step2" method="post">';
	echo '<p><em>Your MySQL username, normally root</em><br>';
	echo 'DB Username:  <input type="text" name="dbusername"></p>';
	echo '<p><em>Your MySQL Password</em><br>';
	echo 'DB Password:  <input type="text" name="dbpassword"></p>';
	echo '<p><em>The database that you setup for this site.</em><br>';
	echo 'Database:  <input type="text" name="database"></p>';
	echo '<input type="submit" name="submit" value="Continue">';
	echo '</form>';
}

function step2() {

	if (isset($_POST['submit'])) {
	
		$dbuser = $_POST['dbusername'];
		$dbpasswd = $_POST['dbpassword'];
		$dbname = $_POST['database'];
		$dbserver = 'localhost';
		
		$conn = mysqli_connect($dbserver,$dbuser,$dbpasswd,$dbname);
		if(!$conn)
		{
		   echo 'Database could not be connected to.';
		}
		else
		{
		
		   $configfile = '../../config/mc-config.php';
		   $config = fopen($configfile, "w") or die("Unable to open $configfile");
	
			
			$begin = "<?php\n\n";
			fwrite($config, $begin);
			$notes0 = "/*\n";
			fwrite($config, $notes0);
			$notes1 = "* config.php\n";
			fwrite($config, $notes1);
			$notes2 = "* Database Configuration\n";
			fwrite($config, $notes2);
			$notes3 = "* @ DBUSER\n";
			fwrite($config, $notes2);
			$notes4 = "* @ DBPASS\n";
			fwrite($config, $notes4);
			$notes5 = "* @ DBNAME\n";
			fwrite($config, $notes5);
			$notes6 = "* @ DBHOST\n";
			fwrite($config, $notes6);
			$notes7 = "*/\n\n";
			fwrite($config, $notes7);
			
			$duser = "define('DBUSER', '$dbuser');\n";
			fwrite($config, $duser);
			$dbpass = "define('DBPASS', '$dbpasswd');\n";
			fwrite($config, $dbpass);
			$db = "define('DBNAME', '$dbname');\n";
			fwrite($config, $db);
			$dbs = "define('DBHOST', 'localhost');\n\n";
			fwrite($config, $dbs);
			
			
			fclose($configfile);
			
			echo '<p>Config file created<br><a href="install.php?op=step3"><button>Continue..</button></a></p>';
		   }
	}
}

function step3() {
	echo '<p>Setting up data tables, this could take some time..</p>';
	// import the site sql
	// we need the config file
	include '../../config/mc-config.php';
	$conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);
	// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 
	// Test Table
	/*
	$sql = "CREATE TABLE MyGuests (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
  echo "Table MyGuests created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}
*/
	
	// Users Table
	$users = "CREATE TABLE wc_users (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_login VARCHAR(30) NOT NULL,
	user_firstname VARCHAR(30),
	user_lastname VARCHAR(30),
	user_pass VARCHAR(100) NOT NULL,
	user_nicname VARCHAR(30) NOT NULL,
	user_url VARCHAR(150),
	display_name VARCHAR(30) NOT NULL,
	user_email VARCHAR(50) NOT NULL,
	user_status int(1) NOT NULL DEFAULT '0',
	reg_date DATETIME
	)";
	if ($conn->query($users) === TRUE) {
	   echo "<p>Users Table Created</p>";
	}
	else
	{
	   echo "<p>Users table was not created</p>";
	   echo "<p>Error creating table: " . $conn->error;
	   echo "</p>";
	}
	
	// Settings Table
	$settings = "CREATE TABLE wc_settings (
	site_name VARCHAR(50) NOT NULL,
	site_url VARCHAR(150) NOT NULL,
	site_description VARCHAR(150) NOT NULL,
	mailserver_url VARCHAR(100),
	mailserver_login VARCHAR(30),
	mailserver_pass VARCHAR(100),
	mailserver_port VARCHAR(3),
	site_keywords VARCHAR(255),
	admin_email VARCHAR(150) NOT NULL,
	facebook VARCHAR(50),
	twitter VARCHAR(50),
	instagram VARCHAR(50),
	youtube VARCHAR(50),
	time_zone VARCHAR(100) NOT NULL
	)";
	if ($conn->query($settings) === TRUE) {
	   echo "<p>Settings Table Created</p>";
	   $do_settings = "INSERT INTO wc_settings 
	                  (site_description, mailserver_url, mailserver_login, mailserver_pass, mailserver_port) VALUES ('A microCMS Driven site', 'mail.example.com', 'password', '587')";
	   if ($conn->query($do_settings) === TRUE) {
	     echo "<p>Settings Were updated</p>";
	   }
	   else
	   {
	      echo "<p>Settings table was not update</p>";
	      echo "<p>Error creating table: " . $conn->error;
	      echo "</p>";
	   }
	else
	{
	   echo "<p>Settings table was not created</p>";
	   echo "<p>Error creating table: " . $conn->error;
	   echo "</p>";
	}
	
	// Blogs Table
	$blogs = "CREATE TABLE wc_blogs (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	blog_title VARCHAR(150) NOT NULL,
	blog_exerpt VARCHAR(150) NOT NULL,
	blog_contents text,
	blog_author VARCHAR(30),
	blog_date DATETIME
	)";
	if ($conn->query($blogs) === TRUE) {
	   echo "<p>Blogs Table Created</p>";
	}
	else
	{
	   echo "<p>Blogs table was not created</p>";
	   echo "<p>Error creating table: " . $conn->error;
	   echo "</p>";
	}
	
	// Plugins Table
	$plugins = "CREATE TABLE wc_plugins (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	plugin_name VARCHAR(150) NOT NULL,
	plugin_slug VARCHAR(150) NOT NULL,
	plugin_type INT(1) NOT NULL,
	plugin_status text,
	plugin_text VARCHAR(255) NOT NULL
	)";
	if ($conn->query($plugins) === TRUE) {
	   echo "<p>Plugins Table Created</p>";
	}
	else
	{
	   echo "<p>Plugin table was not created</p>";
	   echo "<p>Error creating table: " . $conn->error;
	   echo "</p>";
	}
	
	// Version Table
	$version = "CREATE TABLE wc_version (
	major INT(1) NOT NULL,
	minor INT(1) NOT NULL,
	increment INT(1) NOT NULL,
	codename VARCHAR(20) NOT NULL
	)";
	if ($conn->query($version) === TRUE) {
	   echo "<p>Version Table Created</p>";
	   $set_version = "INSERT INTO wc_version (major, minor, increment, codename) VALUES ('1', '5', '1', 'Odin')";
	   if ($conn->query($set_version) === TRUE) {
	      echo "<p>Version Table Updated</p>";
	   }
	   else
	   {
	      echo "<p>Version was not updated</p>";
	   }
	}
	else
	{
	   echo "<p>Version table was not created</p>";
	   echo "<p>Error creating table: " . $conn->error;
	   echo "</p>";
	}
	
	$conn->close();
	
	echo '<br><p><a href="install.php?op=step4"><button>Continue..</button></a></a>';

}

function step4() {
	echo '<h1>Set Your Time Zone</h1>';
	echo '<form action="install.php?op=step5" method="post">';
	echo '<table border="0" cellpadding="3" cellspacing="3" align="center" width="100%">';
	echo '</tr>';
	echo '<td>Your Time Zone:</td>';
	echo '<td>&nbsp;</td>';
	echo '<td><select name="time_zone">';
	$tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
	foreach($tzlist as $value)
	{
  	   echo "<option value=". $value .">". $value ."</option>";
	}
	echo '</select>';
	echo '</td>';
	echo '</tr>';
	echo '</table>';
	echo '<p align="center"><input type="submit" name="submit" value="Continue"></p>';
}

function step5() {
	if (isset($_POST['submit'])) {
		$tz = $_POST['time_zone'];
		
		include '../../config/mc-config.php';
		$conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);
		
		// Add the TimeZone to the settings table
		$query = "UPDATE wc_settings SET time_zone='$tz'";
		$result = mysqli_query($conn, $query);
		//confirm_query($result);
		
		// Echo the button
		echo '<h1>Time Zone Set</h1>';
		echo '<p>Your time zone has been set to '.$tz.'</p>';
		echo '<p><a href="install.php?op=step6"><input type="button" value="Continue"></a></p>';
		
	}
}

function step6() {
   // Add first user and make them the site admin
   echo '<h1>Your Account</h1>';
   echo '<form action="install.php?op=step7" method="post">';
   echo '<table border="0" cellpadding="3" cellspacing="3" align="center" width="100%">';
   echo '<tr>';
   echo '<td><strong>Username:</strong></td>';
   echo '<td><input type="text" name="user_name"></td>';
   echo '</tr>';
   echo '<tr>';
   echo '<td><strong>Password:</strong></td>';
   echo '<td><input type="password" name="password1"></td>';
   echo '</tr>';
   echo '<tr>';
   echo '<td><strong>Password Again:</strong></td>';
   echo '<td><input type="password" name="password2"></td>';
   echo '</tr>';
   echo '<tr>';
   echo '<td><strong>Email:</strong></td>';
   echo '<td><input type="email" name="user_email"></td>';
   echo '</tr>';
   echo '<tr>';
   echo '<td><strong>Display Name:</strong></td>';
   echo '<td><input type="text" name="display_name"></td>';
   echo '</tr>';
   echo '<tr>';
   echo '<td></td>';
   echo '<td><input type="submit" name="add_admin"></td>';
   echo '</tr>';
   echo '</table>';
   echo '</form>';
}

function step7() {
   if(isset($_POST['add_admin']))
   {
      $user_name = $_POST['user_name'];
      $pass1 = $_POST['password1'];
      $pass2 = $_POST['password2'];
      $user_email = $_POST['user_email'];
      $display_name = $_POST['display_name'];
      if($pass2 != $pass1)
      {
        echo '<h2>Password Issue</h2>';
        echo '<p>Your Passwords did not match, please go <a href="/install.php?op=step6">Go Back</a></p>';
      }
      else
      {
        if (filter_var($user_email, FILTER_VALIDATE_EMAIL))
        {
           include '../../config/mc-config.php';
	   $conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);
	   $valid_pass = sha1($pass1);
	   $add_admin = "INSERT INTO wc_users
	                (user_login, user_pass, user_nicname, display_name, user_email, user_status, reg_date ) 
	                VALUES ('$user_name', '$valid_pass', '$display_name', '$display_name', '$user_email', '1', NOW())";
	   if ($conn->query($add_admin) === TRUE) {
	     echo '<a href="install.php?op=complete"><button>Continue..</button></a>';
	   }
	
        }
        else
        {
          echo '<h2>Invalid Email address</h2>';
          echo '<p>Your Email address does not appear to be valid, please go <a href="/install.php?op=step6">Go Back</a></p>';
        }
      }
      
   }
}

function complete() {
	echo '<h2>Congrats</h2>';
	echo '<p>Your site is all setup and installed, please remember to <strong>DELETE</strong> the INSTALL folder.</p>';
	echo '<p>Then <a href="/"><strong>Log In</strong></a> to your site and change your site settings.</p>';
}

switch($d) {

	case 'step2':
			step2();
			break;
			
	case 'step3':
			step3();
			break;
			
	case 'step4':
			step4();
			break;
			
	case 'step5':
			step5();
			break;
			
	case 'step6':
			step6();
			break;
			
	case 'step7':
			step7();
			break;
			
	case 'complete':
			complete();
			break;
			
	// Main
	default:
		   step1();
		   break;
}
