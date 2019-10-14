<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
	header("Location: /");
}
else
{
	/*
	 * Function operatives
	 * Set the operation variable for the switch
	 */
	if (isset($_GET['op']))
	{
		$d = $_GET['op'];
	}
	elseif (isset($_POST['op']))
	{ // Forms
		$d = $_POST['op'];
	} 
	else
	{
		$d = NULL;
	}
	echo '<div class="main">';
	
	// Functions 
	function home()
	{
		$core = new microcms\core;
		if ($core->logged_in() == FALSE)
		{
			$core->redirect_to("/login");
		}
		else
		{
			echo 'Welcome, '.$_SESSION['name'].'';
		}
	}
	
	function login()
	{
		$db = new database\db;
		$core = new microcms\core;
		if(isset($_POST['login']))
		{
			if(empty($_POST['username']))
			{
				$error = 'Your Username is required';
				$this->usererror($error);
			}
			elseif(empty($_POST['password']))
			{
				$error = 'Your Password is required';
				$this->usererror($error);
			}
			else
			{
				$user = $_POST['username'];
				$pass = sha1($_POST['password']);
				
				$query = "SELECT * FROM accounts WHERE username = '$user' && password = '$pass'";
				$result = $db->query($query);
				if(!$result)
				{
					$error = 'Invalid User or Password';
					$this->usererror($error);
				}
				else
				{
					$loggedin = $db->fetch_array($result);
					$_SESSION['name'] = $loggedin['username'];
					$_SESSSION['user_id'] = $loggedin['id'];
					$core->redirect_to("/");
				}
			}
		}
		else
		{
			echo '<form id="login" name="login" action="/login" method="post">';
			echo 'Username: <input type="text" name="username" id="username" required>';
			echo '<br>';
			echo 'Password: <input type="password" name="password" id="password" required>';
			echo '<br>';
			echo '<input type="submit" name="login" value="Log In">';
			echo '</form>';
			echo '<br>';
			echo '<p>Don\'t have an account? <a href="/register">Register Here</a></p>';
		}
			
	}
	
	function logout()
	{
		$core = new microcms\core;
		// Unset all of the session variables.
		$_SESSION = array();

		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}

		// Finally, destroy the session.
		session_destroy();
		$core->redirect_to("/");
	}
	
	function register()
	{
		$db = new database\db;
		$core = new microcms\core;
		
		if(isset($_POST['register']))
		{
			if(empty($_POST['username']))
			{
				$error = 'Username is either invalid or missing';
				$this->usererror($error);
			}
			if(empty($_POST['password']))
			{
				$error = 'Password is either invalid or missing';
				$this->usererror($error);
			}
			if(empty($_POST['email']))
			{
				$error = 'Email Address is either invalid or missing';
				$this->usererror($error);
			}
			$user = $db->prep_data($_POST['username']);
			$password = $_POST['password'];
			$email = $db->prep_data($_POST['email']);
			
			// Lets check some things
			if($core->VerifyEmail($email))
			{
				$good_email = $email;
			}
			else
			{
				$error = 'The Email Address that you submitted does not seem to be a valid email address.';
				$this->usererror($error);
			}
			
			$securePass = $db->prep_data(sha1($password));
			echo $user;
			echo '<br>';
			echo $securePass;
			echo '<br>';
			echo $good_email;
			$query = "SELECT * FROM accounts WHERE username = '$user'";
			$result = $db->query($query);
			$theuser = $db->fetch_assoc($result);
			if($theuser)
			{
				echo 'An account with this username already exists';
			}
			else
			{
				// Insert into the accounts table
				$query = "INSERT INTO accounts (username, password, email) VALUES ('$user', '$securePass', '$good_email')";
				$result = $db->query($query);
				if(!$result)
				{
					$error = 'Something went wrong';
					$this->usererror($error);
				}
				else
				{
					$core->redirect_to("/login");
				}
			}
		}
		else
		{
			// Load the Form
			echo '<form id = "register" action = "/register" method="post">';
			echo 'Username: <input type="text" name="username" id="username" required>';
			echo '<br>';
			echo 'Password: <input type="password" name="password" id="password" required>';
			echo '<br>';
			echo 'Email: <input type="email" name="email" id="email" required">';
			echo '<br>';
			echo '<input type="submit" name="register" value="Register Now">';
			echo '</form>';
		}
	}
	
	function usererror($msg)
	{
		echo '<h2>ERROR!</h2>';
		echo '<p>'.$msg.'</p>';
	}
	
	/*
	 * Switch
	 * Allows function to be used
	 * $d is derived from the Function operatives
	 */
	switch($d)
	{
		// Login
		case 'login':
			login();
			break;
			
		// Logout
		case 'logout':
			logout();
			break;
			
		// Register
		case 'register':
			register();
			break;
			
		// Error
		case 'usererror':
			usererror($msg);
			break;
			
		// Main
		default:
		   home();
		   break;
	}
	
	echo '</div>';

}
?>