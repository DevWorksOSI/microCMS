<?php

/* install.php
 * 6 Minute or less install
 * Use to install the microCMS
 * requires an established database
 * will write the config file
 * On complete, the admin/install folder will be deleted.
*/

?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="mc-includes/css/install.css">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<title>microCMS Install</title>
</head>
<body>
<div class="install">
<?php

if (isset($_GET['op'])) {
	$d = $_GET['op'];
} else {
	$d = NULL;
}

function begin_install() {
   // Lets check the permissions on wp-config.php
   echo '<h2>Install Permissions</h2>';
   echo '<p>Checking to see if we have permission to read and write. If not, a Fix this button will appear.</p>';
   $config = 'wp-config.php';
   $msg = is_readable($config);
   if($msg)
   {
      $msg = '<p>Good to Go!</p><br><p><a href="mc-install.php?op=step1"><button>Continue</button></a></p>';
   }
   else
   {
      $msg = '<p>Config File is not readable <a href="mc-install.php?op=fix_perms"><button>Fix This</button></a></p>';
   }
   echo $msg . '<br/>';
}

function fix_perms()
{
   // Fix file permissions
   $file = 'mc-config.php';
   $fix = chmod($file, 0664);
   if(!$fix)
   {
     echo '</p>Config file permissions could not be changed.</p>';
   }
   else
   {
     echo '</p>Config file permissions changed.</p><br><p><a href="mc-install.php?op=step1"><button>Continue</button></a></p>';
   }
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
		var_dump($dbuser);
		echo '<br>';
		var_dump($dbname);
		echo '<br>';
		var_dump($dbpasswd);
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
		      chmod($configfile, 0664);
		   }
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
			
			// Sentry/HTTPBL Using ours
			$notes8 = "\n\n";
			fwrite($config, $notes8);
			$notes9 = "// Sentry/HTTPBL KEY\n";
			fwrite($config, $notes9);
			$notes10 = "define('httpBL_KEY','gbraupsxiodf');\n";
			fwrite($config, $notes10);
			
			
			fclose($configfile);
			
			echo '<p>Config file created<br><a href="mc-install.php?op=step3"><button>Continue..</button></a></p>';
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
	$settings = "CREATE TABLE mc_settings (
	site_name VARCHAR(150) NOT NULL,
	site_url VARCHAR(150) NOT NULL,
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
	time_zone VARCHAR(150) NOT NULL
	)";
	if ($conn->query($settings) === TRUE) {
	   echo "<p>Settings Table Created</p>";
	   $do_settings = "INSERT INTO mc_settings
	   (
	   site_name,
	   site_url,
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
	   time_zone
	   )
	   VALUES
	   (
	   'microCMS',
	   'http://localhost',
	   'a microCMS driven Site', 
	   'core',
	   'mail.example.com',
	   'you@example.com',
	   'password',
	   '587',
	   'a,whole,bunch.of.key,words',
	   'admin@localhost',
	   'NULL',
	   'NULL',
	   'NULL',
	   'NULL',
	   'unknown'
	   )";
	   if ($conn->query($do_settings) === TRUE) {
	      echo '<p>Settings Updated..</p>';
	   }
	   else
	   {
	      echo '<p>Settings could not be updated.</p>';
	      echo "<p>Error: " . $conn->error;
	      echo '</p>';
	   }
	}
	else
	{
	   echo "<p>Settings table was not created</p>";
	   echo "<p>Error creating table: " . $conn->error;
	   echo "</p>";
	}
	
	// Blogs Table
	$blogs = "CREATE TABLE mc_blogs (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	blog_title VARCHAR(150) NOT NULL,
	blog_exerpt VARCHAR(150) NOT NULL,
	blog_contents text,
	blog_author VARCHAR(30),
	blog_date DATETIME,
	blog_views INT(1),
	blog_loves INT(1),
	allow_comments INT(1) 
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
	$plugins = "CREATE TABLE mc_plugins (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	plugin_name VARCHAR(150) NOT NULL,
	plugin_slug VARCHAR(150) NOT NULL,
	plugin_type INT(1) NOT NULL,
	plugin_status INT(1) NOT NULL,
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
	
	// Metadata Table
	$meta = "CREATE TABLE mc_metadata (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	type INT(1),
	post_date DATETIME,
	post_id INT(1),
	content TEXT,
	who INT(1)
	)";
	if ($conn->query($meta) === TRUE) {
	   echo "<p>Metadata Table Created</p>";
	}
	else
	{
	   echo "<p>Metadata table was not created</p>";
	   echo "<p>Error creating table: " . $conn->error;
	   echo "</p>";
	}
	
	// Symlink Table
	$meta = "CREATE TABLE mc_symlinks (
	id INT(1) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	link_type VARCHAR(50),
	page VARCHAR(100),
	slug VARCHAR(150),
	link_status INT(1)
	)";
	if ($conn->query($meta) === TRUE) {
	   echo "<p>Metadata Table Created</p>";
	}
	else
	{
	   echo "<p>Metadata table was not created</p>";
	   echo "<p>Error creating table: " . $conn->error;
	   echo "</p>";
	}
	
	// Version Table
	$version = "CREATE TABLE mc_version (
	major INT(1) NOT NULL,
	minor INT(1) NOT NULL,
	increment INT(1) NOT NULL,
	codename VARCHAR(20) NOT NULL
	)";
	if ($conn->query($version) === TRUE) {
	   echo "<p>Version Table Created</p>";
	   $set_version = "INSERT INTO mc_version (major, minor, increment, codename) VALUES ('1', '5', '1', 'Odin')";
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
	
	echo '<br><p><a href="mc-install.php?op=step4"><button>Continue..</button></a></a>';

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
		//confirm_query($result);
		
		// Echo the button
		echo '<h1>Time Zone Set</h1>';
		echo '<p>Your time zone has been set to '.$tz.'</p>';
		echo '<p><a href="mc-install.php?op=step6"><input type="button" value="Continue"></a></p>';
		
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
	                (user_login, user_pass, user_nicname, display_name, user_email, user_status, reg_date ) 
	                VALUES ('$user_name', '$valid_pass', '$display_name', '$display_name', '$user_email', '1', NOW())";
	   if ($conn->query($add_admin) === TRUE) {
	   $do_admin_settings = "UPDATE mc_settings SET admin_email='$user_email', site_name='$site_name', site_url='$site_url', site_description='%$site_description', site_keywords='$site_keywords'";
	   $conn->query($do_admin_settings);
	     echo '<p>Great, your admin account and site settings has been established, let\'s continue.</p>';
	     echo '<a href="mc-install.php?op=complete"><button>Continue..</button></a>';
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
			
	case 'fix_perms':
			fix_perms();
			break;
			
	case 'complete':
			complete();
			break;
			
	// Main
	default:
		   begin_install();
		   break;
}
?>
</div>
</body>
</html>
