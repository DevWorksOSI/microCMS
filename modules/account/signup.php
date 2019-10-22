<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
	header("Location: /");
}
else
{
	echo '<div class="main">';
	if(isset($_POST['register']))
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
		$email = $db->prep_data($_POST['email']);
		$secure_pass = $db->prep_data(sha1($password));
		
		// Lookup Methods
		$valid_email = $core->VerifyEmail($email);
		$user_lookup = $core->user_lookup($username);
		$email_lookup = $core->email_lookup($email);
		
		// Is the email address valid?
		if($valid_email === 0)
		{
			echo '<div id="alert">';
			echo '<h3>ERROR!</h3>';
			echo '<p>The email address that you submitted does not appear to valid, please go back and try again.</p>';
			echo '<p><a href="/signup" hreflang="en"><strong>Return</strong></a></p>';
			echo '</div>';
			exit;
		}
		
		$query = "SELECT * FROM accounts WHERE username = '$username'";
		$user = $db->query($query);
		while($users = $db->fetch_assoc($user))
		{
			$members = $users['username'];
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
		
		$query = "SELECT * FROM accounts WHERE email = '$email'";
		$result = $db->query($query);
		while($rows = $db->fetch_assoc($result))
		{
			$eaddy = $rows['email'];
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
			$query = "INSERT INTO accounts (username, password, email, isAdmin) VALUES ('$username', '$secure_pass', '$email', '0')";
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
				$core->redirect_to("/login");
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