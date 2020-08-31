<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
	header("Location: /");
}
else
{
	echo '<div class="container">';
	if(isset($_POST['register']))
	{
	   if(isset($_POST['human_check']))
	   {
		$db = new database\db;
		$username = $db->prep_data($_POST['username']);
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		if($password2 != $password)
		{
			echo '<div id="alert">';
			echo '<h3>ERROR!</h3>';
			echo '<p>Passwords do not match</p>';
			echo '<p><a href="/signup" hreflang="en"><strong>Return</strong></a></p>';
			echo '</div>';
			exit;
		}
		else
		{
		  $secure_pass = sha1($password);
		}
		$display_name = $db->prep_data($_POST['display_name']);
		$email = $db->prep_data($_POST['email']);
		$secure_pass = $db->prep_data($secure_pass);
		
		// Lookup Methods
		$valid_email = $core->VerifyEmail($email);
		//$user_lookup = $db->user_lookup($username);
		//$email_lookup = $db->email_lookup($email);
		
		// Is the email address valid?
		if($valid_email == FALSE)
		{
			echo '<div id="alert">';
			echo '<h3>ERROR!</h3>';
			echo '<p>The email address that you submitted does not appear to valid, please go back and try again.</p>';
			echo '<p><a href="/signup" hreflang="en"><strong>Return</strong></a></p>';
			echo '</div>';
			exit;
		}
		
		$query = "SELECT * FROM mc_users WHERE user_login='$username'";
		$user = $db->query($query);
		while($users = $db->fetch_assoc($user))
		{
			$members = $users['user_login'];
			if($members)
			{
				echo '<div id="alert">';
				echo '<h3>ERROR!</h3>';
				echo '<p>That Username is already taken, please go back and try again.</p>';
				echo '<p><a href="/signup" hreflang="en"><strong>Return</strong></a></p>';
				echo '</div>';
				exit;
			}
		}
		
		$query = "SELECT * FROM mc_users WHERE user_email='$email'";
		$result = $db->query($query);
		while($rows = $db->fetch_assoc($result))
		{
			$eaddy = $rows['user_email'];
			if($eaddy)
			{
				echo '<div id="alert">';
				echo '<h3>ERROR!</h3>';
				echo '<p>An account under that email address, already exists, please go back and enter a different, valid email address.</p>';
				echo '<p><a href="/signup" hreflang="en"><strong>Return</strong></a></p>';
				echo '</div>';
				exit;
			}
		}
		
		// register the user
			$query = "INSERT INTO mc_users (user_login, user_pass, user_nickname, display_name, user_email, user_status, reg_date) VALUES ('$username', '$secure_pass', '$username', '$display_name', '$email', 0, NOW())";
			$result = $db->query($query);
			if(!$result)
			{
				echo '<div id="alert">';
				echo '<h3>ERROR!</h3>';
				echo '<p>Your account could not be registered.</p>';
				echo '<p><a href="/signup" hreflang="en"><strong>Return</strong></a></p>';
				echo '</div>';
			}
			else
			{  
			   // Send email to user
			   $core->welcome_user($email, $display_name, $username);
			     
			   // Now email the site admin
			   //$core->newuser_admin($email, $display_name, $username);
			   
			   $core->redirect_to("/login");	
			}
	   }
	   else
	   {
	      echo '<div class="alert">';
	      echo '<h2>Error</h2>';
	      echo '<p>Please ensure that you have completed all parts of the form.</p>';
	      echo '</div>';
	   }
	}
	else
	{
	   // The Login Form
	   echo '<section>';
	   echo '<table border="0" cellpadding="3" cellspacing="3" align="center">';
	   echo '<tr>';
	   echo '<td>';
	   echo '<form action="/signup" method="post">';
	   echo '<fieldset>';
	   echo '<legend><strong>Register</strong></legend>';
	   echo '<table border="0" cellpadding="3" cellspacing="3" width="100%" align="center">';
	   echo '<tr>';
	   echo '<td><label for="username">Username:</label></td>';
	   echo '<td>&nbsp;</td>';
	   echo '<td><input id="username" type="text" name="username" required placeholder="username">';
	   echo '</tr>';
	   echo '<tr>';
	   echo '<td><label for="password">Password:</label></td>';
	   echo '<td>&nbsp;</td>';
	   echo '<td><input id="password" type="password" name="password" required placeholder="password" pattern=".{5,10}" title="Your password must consist of 5 to 10 characters">';
	   echo '</tr>';
	   echo '<td><label for="password2">Verify Password:</label></td>';
	   echo '<td>&nbsp;</td>';
	   echo '<td><input id="password2" type="password" name="password2" required placeholder="verify password" pattern=".{5,10}" title="Your password must consist of 5 to 10 characters">';
	   echo '</tr>';
	   echo '<tr>';
	   echo '<td><label for="email">Email Address:</label></td>';
	   echo '<td>&nbsp;</td>';
	   echo '<td><input id="email" type="email" name="email" required placeholder="you@gmail.com" title="Please enter a valid email address">';
	   echo '</tr>';
	    echo '<tr>';
	   echo '<td><label for="display_name">Display Name:</label></td>';
	   echo '<td>&nbsp;</td>';
	   echo '<td><input id="display_name" type="text" name="display_name" required placeholder="You" title="Please enter a Display Name">';
	   echo '</tr>';
	   echo '<tr>';
	   echo '<tr>';
	   echo '<td><label for="human_check">Are you Human?:</label></td>';
	   echo '<td>&nbsp;</td>';
	   echo '<td><input type="checkbox" id="human_check" name="human_check">';
	   echo '</tr>';
	   echo '<tr>';
	   echo '<td>&nbsp;</td>';
	   echo '<td>&nbsp;</td>';
	   echo '<td><br><input type="submit" name="register" value="Sign Up">';
	   echo '</tr>';
	   echo '</table>';
	   echo '</fieldset>';
	   echo '</form>';
	   echo '</td>';
	   echo '</tr>';
	   echo '</table>';
	   echo '</section>';
	}
	echo '</div>';
}
?>
