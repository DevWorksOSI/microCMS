<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
	header("Location: /");
}
else
{
	echo '<div class="main">';
	if(isset($_POST['login']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$secure_pass = sha1($password);
		
		$query = "SELECT * FROM mc_accounts WHERE username = '$username' && password = '$secure_pass'";
		$result = $db->query($query);
		$user_count = $db->rows($result);
		if(!$user_count)
		{
			echo '<div id="alert">';
		    echo '<h3>ERROR!</h3>';
		    echo '<p>Wrong Username or Password.</p>';
		    echo '<p><a href="/login" hreflang="en"><strong>Return</strong></a></p>';
			echo '</div>';
		}
		else
		{
			$query = "SELECT * FROM mc_accounts WHERE username = '$username'";
			$result = $db->query($query);
			$user = $db->fetch_array($result);
			$_SESSION['user_id'] = $user['id'];
			$_SESSION['username'] = $user['username'];
			$_SESSION['admin'] = $user['isAdmin'];
			$userDateTime = new DateTime('NOW');
			$_SESSSION['loggedin_time'] = $userDateTime;
			$core->redirect_to("/");
		}
	}
	else
	{
	   // The Login Form
	   echo '<section>';
	   echo '<table border="0" cellpadding="3" cellspacing="3" align="center">';
	   echo '<tr>';
	   echo '<td>';
	   echo '<form action="/login" method="post">';
	   echo '<fieldset>';
	   echo '<legend><strong>Log In</strong></legend>';
	   echo '<table border="0" cellpadding="3" cellspacing="3" width="100%" align="center">';
	   echo '<tr>';
	   echo '<td><label for="username">Username:</label></td>';
	   echo '<td>&nbsp;</td>';
	   echo '<td><input id="username" type="text" name="username" required>';
	   echo '</tr>';
	   echo '<tr>';
	   echo '<td><label for="password">Password:</label></td>';
	   echo '<td>&nbsp;</td>';
	   echo '<td><input id="password" type="password" name="password" required>';
	   echo '</tr>';
	   echo '<tr>';
	   echo '<td>&nbsp;</td>';
	   echo '<td>&nbsp;</td>';
	   echo '<td><br><input type="submit" name="login" value="Log In">';
	   echo '</tr>';
	   echo '</table>';
	   echo '</fieldset>';
	   echo '</form>';
	   echo '</td>';
	   echo '</tr>';
	   echo '</table>';
	   echo '<div align="center"><a href="/signup">Don\'t have an account?</a>  <a href="#">Forgot Password?</a></div>';
	   echo '</section>';
	}
	echo '</div>';
}
?>
