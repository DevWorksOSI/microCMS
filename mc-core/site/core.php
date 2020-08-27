<?php
namespace site;
// We need the database
use database\db;

class core
{
	public function logged_in()
	{
	   if (isset($_SESSION['username']) && isset($_SESSION['user_id']))
	   {
	      return true;
	   } 
	   else
	   {
	      return false;
	   }
	}
	
	public function is_admin()
	{
		if (isset($_SESSION['admin']))
		{
			return true;
		} 
		else
		{
			return false;
		}
	}
	
	public function check_errors($text)
	{
		if($text == true)
		{
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL);
		}
	}
	
	public function sentry_active()
	{
	  if(file_exists('mc-core/sentry/security.php'))
	  {
	     return true;
	  }
	  else
	  {
	     return false;
	  }
	}
	
	
	public function is_ssl()
	{
		if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
		    // SSL connection
		    return true;
		}
		else
		{
			return false;
		}
		exit;
	}
	
	public function redirect_to($new_location)
	{
		header("Location: " . $new_location);
		exit;
	}
	
	// Checking email addresses
	public function verifyEmail($email)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	
	public function log_timer($time)
	{
		$login_session_duration = $time; 
		$current_time = time(); 
		if(isset($_SESSION['loggedin_time']) and isset($_SESSION["user_id"]))
		{  
			if(((time() - $_SESSION['loggedin_time']) > $login_session_duration))
			{ 
				return true; 
				$this->redirect_to("/logout");
			} 
		}
		return false;
	}
	function get_status()
	{
	   /*
	    * Templated function to interact with the DW OSI REST API
	    * To get the sites current status and display it in the 
	    * admin dashboard.
	   */
	}
	
	/*
	 * This needs a serious update
	 * Versioning is to be changed soon
	*/
	public function check_version()
	{
		// Data
		$db = new db();
		$query = "SELECT * from version";
		$result = $db->query($query);

		$row = $db->fetch_assoc($result);
		$major = $row['major'];
		$minor = $row['minor'];
		$increment = $row['increment'];
		$tail = $row['tail'];
		$local_version = ''.$major.'.'.$minor.'.'.$increment.'.'.$tail.'';

		$remote_version = file_get_contents("http://microcms.dwosi.us/version.php");

		// If remote and local do not match
		if ($local_version !== $remote_version)
		{
			$this->msg = '<strong>Your Version - '.$local_version.', is OUT OF DATE, v.'.$remote_version.' is available for <a href="http://microcms.dwosi.usd/" target="_blank">download</strong></a>';
			// Can we download and extract updates here?
		}
		if ($local_version === $remote_version)
		{
			$this->msg = '<strong>Your Version - '.$local_version.', is UP TO DATE!</strong>';
		}
		if ($local_version > $remote_version)
		{
			$this->msg = '<strong>Your Version - '.$local_version.', is a Development Version</strong>';
		}
		
		// Return the message
		return $this->msg;
	}
	
	public function slugify($string)
	{
		$slug = strtolower(preg_replace('/[^a-zA-Z0-9\-]/', '',preg_replace('/\s+/', '-', $string) ));
		return $slug;
	}
	
	public function ago($time)
	{
	  $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	  $lengths = array("60","60","24","7","4.35","12","10");

	  $now = time();

       $difference     = $now - $time;
       $tense         = "ago";

	  for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++)
	  {
        $difference /= $lengths[$j];
	  }

	  $difference = round($difference);

	 if($difference != 1)
	 {
       $periods[$j].= "s";
	 }

	 return "$difference $periods[$j] $tense ";
	 }
}
