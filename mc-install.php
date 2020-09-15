<?php

/* install.php
 * 6 Minute or less install
 * Use to install the microCMS
 * requires an established database
 * will write the config file
 * On complete, the admin/install folder will be deleted.
*/
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="mc-includes/css/install.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<title>microCMS Install</title>
</head>
<body>
<div class="container">
<div class="row">
<div class="install">
<?php

if (isset($_GET['op'])) {
	$d = $_GET['op'];
} else {
	$d = NULL;
}

function begin_install() {
   step1();
}

function step1() {
	echo '<p>Use this form to create your configuration file, continue to the next step when prompted.</p>';
	echo '<form action="mc-install.php?op=step2" method="post">';
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
		
		   $configfile = 'mc-config.php';
		   if(file_exists($configfile))
		   {
		      chmod($configfile, 0775);
		   
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
			   fwrite($config, $notes3);
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
			   $dbs = "define('DBHOST', 'localhost');\n";
			   fwrite($config, $dbs);
			   $notes8 = "\n\n";
			   fwrite($config, $notes8);
			   $notes9 = "// Application Root\n";
			   fwrite($config, $notes9);
			   $approot = "define('APPROOT', '/');;\n";
			   fwrite($config, $approot);
			   $notes10 = "\n\n";
			   fwrite($config, $notes10);
			   $notes11 = "// HTTPBL KEY for Sentry\n";
			   $sentry = "define('httpBL_KEY','gbraupsxiodf');";
			   fwrite($config, $sentry);
			   $notes12 = "\n\n";
			   fwrite($config, $notes12);
			   $notes13 = "/* Site Debug\n";
			   fwrite($config, $notes13);
			   $notes14 = "* Set to true to turn on Debug During Development\n";
			   fwrite($config, $notes14);
			   $notes15 = "* use define('DEBUG', true); whenever you are developing something\n";
			   fwrite($config, $notes15);
			   $debug = "define('DEBUG', false);";
			   fwrite($config, $debug);
			   fclose($configfile);
			   header("Location: mc-install.php?op=step3");
		    }
		}
	}
}

function step3() {
	echo '<p>Setting up data tables, this could take some time..</p>';
	// import the site sql
	// we need the config file
	include 'mc-config.php';
	$conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);
		
	// Users Table
	$drop_users = "DROP TABLE IF EXISTS mc_users";
	$conn->query($drop_users);
	$users = "CREATE TABLE mc_users (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_login VARCHAR(30) NOT NULL,
	user_firstname VARCHAR(30),
	user_lastname VARCHAR(30),
	user_pass VARCHAR(100) NOT NULL,
	user_nickname VARCHAR(30) NOT NULL,
	user_url VARCHAR(150),
	display_name VARCHAR(30) NOT NULL,
	user_email VARCHAR(50) NOT NULL,
	user_status int(1) NOT NULL DEFAULT '0',
	reg_date DATETIME
	)";
	$conn->query($users);
	
	// Settings Table
	$drop_settings = "DROP TABLE IF EXISTS mc_settings";
	$conn->query($drop_settings);
	$settings = "CREATE TABLE mc_settings (
	id INT(1) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	site_name VARCHAR(150) NOT NULL,
	site_url VARCHAR(150) NOT NULL,
	site_slug VARCHAR(150),
	site_description VARCHAR(255) NOT NULL,
	site_theme VARCHAR(50) NOT NULL,
	mailserver_url VARCHAR(150),
	mailserver_login VARCHAR(100),
	mailserver_pass VARCHAR(100),
	mailserver_port VARCHAR(3),
	site_keywords TEXT,
	admin_email VARCHAR(150) NOT NULL,
	facebook VARCHAR(50),
	twitter VARCHAR(50),
	instagram VARCHAR(50),
	youtube VARCHAR(50),
	time_zone VARCHAR(150) NOT NULL,
	maintenance INT(1)
	)";
	if ($conn->query($settings) === TRUE) {
	   $do_settings = "INSERT INTO mc_settings
	   (
	   site_name,
	   site_url,
	   site_slug,
	   site_description,
	   site_theme,
	   mailserver_url,
	   mailserver_login,
	   mailserver_pass,
	   mailserver_port,
	   site_keywords,
	   admin_email,
	   facebook,
	   twitter,
	   instagram,
	   youtube,
	   time_zone,
	   maintenance
	   )
	   VALUES
	   (
	   'microCMS',
	   'http://localhost',
	   'a microCMS Website',
	   'a microCMS driven Site', 
	   'core',
	   'mail.example.com',
	   'you@example.com',
	   'password',
	   '587',
	   'a,whole,bunch,of,key,words',
	   'admin@localhost',
	   'NULL',
	   'NULL',
	   'NULL',
	   'NULL',
	   'unknown',
	   '0'
	   )";
	   $conn->query($do_settings);
	}
	
	// Blogs Table
	$drop_blogs = "DROP TABLE IF EXISTS mc_posts";
	$conn->query($drop_blogs);
	$blogs = "CREATE TABLE mc_posts (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	post_title VARCHAR(150) NOT NULL,
	post_exerpt VARCHAR(150) NOT NULL,
	post_contents text NOT NULL,
	post_author VARCHAR(30) NOT NULL,
	post_date DATETIME NOT NULL,
	allow_comments INT(1) NOT NULL,
	post_slug VARCHAR(150) NOT NULL,
	post_likes INT(1) NOT NULL
	)";
	$conn->query($blogs);
	
	// Visits Table
	$drop_visits = "DROP TABLE IF EXISTS mc_sitevisits";
	$conn->query($drop_visits);
	$visits = "CREATE TABLE mc_sitevisits (
	id INT(1) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	count MEDIUMINT(6)
	)";
	if($conn->query($visits) === TRUE) {
		$query = "INSERT INTO mc_sitevisits (id, count) VALUES (1, 0)";
		$conn->query($query);
	}
	
	// Plugins Table
	$drop_plugins = "DROP TABLE IF EXISTS mc_plugins";
	$conn->query($drop_plugins);
	$plugins = "CREATE TABLE mc_plugins (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	plugin_name VARCHAR(150) NOT NULL,
	plugin_slug VARCHAR(150) NOT NULL,
	plugin_type INT(1) NOT NULL,
	plugin_status INT(1) NOT NULL,
	plugin_text VARCHAR(255) NOT NULL,
	plugin_version VARCHAR(5) NOT NULL
	)";
	$conn->query($plugins);
	
	// Version Table
	$drop_version = "DROP TABLE IF EXISTS mc_version";
	$conn->query($drop_version);
	$version = "CREATE TABLE mc_version (
	major INT(1) NOT NULL,
	minor INT(1) NOT NULL,
	increment INT(1) NOT NULL,
	codename VARCHAR(20) NOT NULL
	)";
	if ($conn->query($version) === TRUE) {
	   $set_version = "INSERT INTO mc_version (major, minor, increment, codename) VALUES ('1', '5', '1', 'Odin')";
	   $conn->query($set_version);
	}
	
	// Sentry Table
	$drop_sentry = "DROP TABLE IF EXISTS mc_bannedip";
	$conn->query($drop_sentry);
	$sentry = "CREATE TABLE mc_bannedip (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	ip VARCHAR(100) NOT NULL,
	bann_date DATETIME,
	source VARCHAR(20) NOT NULL,
	country VARCHAR(8) NOT NULL
	)";
	$conn->query($sentry);
	
	// MataData Table
	$drop_meta = "DROP TABLE IF EXISTS mc_metadata";
	$conn->query($drop_meta);
	$meta = "CREATE TABLE mc_metadata (
	id INT(1) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	post_type INT(1) NOT NULL,
	content TEXT,
	content_date DATETIME,
	post_id MEDIUMINT(6),
	user_id MEDIUMINT(6),
	user_name VARCHAR(50) NOT NULL
	)";
	$conn->query($meta);
	
	$conn->close();
	
	header("Location: mc-install.php?op=step4");

}

function step4() {
	echo '<h1>Set Your Time Zone</h1>';
	echo '<form action="mc-install.php?op=step5" method="post">';
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
		
		include 'mc-config.php';
		$conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);
		
		// Add the TimeZone to the settings table
		$query = "UPDATE mc_settings SET time_zone='$tz'";
		$result = mysqli_query($conn, $query);
		
		header("Location: mc-install.php?op=step6");
		
	}
}

function step6() {
   // Add first user and make them the site admin
   echo '<h1>Settings</h1>';
   echo '<form action="mc-install.php?op=step7" method="post">';
    echo '<fieldset>';
   echo '<legend><strong>Your Account</strong></legend>';
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
   echo '</table>';
   echo '</fieldset>';
   
   /*
    * Site settings
    * @ site_name
    * @ site_url
    * @ site_description
    * @ site_keywords
    *
   */
   echo '<fieldset>';
   echo '<legend><strong>Site Settings</strong></legend>';
   echo '<table border="0" cellpadding="3" cellspacing="3" align="center" width="100%">';
   echo '<tr>';
   echo '<td><strong>Site Name:</strong></td>';
   echo '<td><input type="text" name="site_name" placeholder="Example Company"></td>';
   echo '</tr>';
   echo '<tr>';
   echo '<td><strong>Site URL:</strong></td>';
   echo '<td><input type="text" name="site_url" placeholder="https://www.example.com"></td>';
   echo '</tr>';
   echo '<tr>';
   echo '<td><strong>Site Description:</strong></td>';
   echo '<td><input type="text" name="site_description" placeholder="Describe your site"></td>';
   echo '</tr>';
   echo '<tr>';
   echo '<td><strong>Site Short Description:</strong></td>';
   echo '<td><input type="text" name="site_shortdescription" placeholder="a microCMS Website"></td>';
   echo '</tr>';
   echo '<tr>';
   echo '<td><strong>Site Keywords:</strong></td>';
   echo '<td><input type="text" name="site_keywords" placeholder="words,seperated,by,commas"></td>';
   echo '</tr>';
   echo '<tr>';
   echo '<td></td>';
   echo '<td><input type="submit" name="add_admin"></td>';
   echo '</tr>';
   echo '</table>';
   echo '</fieldset>';
    
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
      $site_name = $_POST['site_name'];
      $site_url = $_POST['site_url'];
      $site_description = $_POST['site_description'];
	  $short_description = $_POST['site_shortdescription'];
      $site_keywords = $_POST['site_keywords'];
      if($pass2 != $pass1)
      {
        echo '<h2>Password Issue</h2>';
        echo '<p>Your Passwords did not match, please go <a href="/install.php?op=step6">Go Back</a></p>';
      }
      else
      {
        if (filter_var($user_email, FILTER_VALIDATE_EMAIL))
        {
           include 'mc-config.php';
	   $conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);
	   $valid_pass = sha1($pass1);
	   $add_admin = "INSERT INTO mc_users
	                (user_login, user_pass, user_nickname, display_name, user_email, user_status, reg_date ) 
	                VALUES ('$user_name', '$valid_pass', '$display_name', '$display_name', '$user_email', '1', NOW())";
	   if ($conn->query($add_admin) === TRUE) {
	   $do_admin_settings = "UPDATE mc_settings SET admin_email='$user_email', site_name='$site_name', site_url='$site_url', site_slug='$short_description', site_description='$site_description', site_keywords='$site_keywords'";
	   $conn->query($do_admin_settings);
	     header("Location: mc-install.php?op=complete");
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
	echo '<p>Your site is all setup and installed.</p>';
	echo '<p>Then <a href="/"><strong>Log In</strong></a> to your site and change your site settings.</p>';
}

switch($d) {

	case 'step1':
			step1();
			break;
	
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
		   begin_install();
		   break;
}
ob_end_flush();
?>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>
