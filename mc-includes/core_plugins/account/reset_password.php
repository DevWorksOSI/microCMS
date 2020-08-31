<div class="container">
<div class="row">
<?php
	if(isset($_POST['reset-password']))
	{
	   $user_email = $_POST['member_email'];
	   $query = "SELECT * FROM mc_users WHERE user_email = '$user_email'";
	   $isMember = $db->query($query);
	   $member = $db->rows($result);
	   if(!$member)
	   {
	       $error_message = 'Email address not found';
	       echo '<div class="col">';
	       echo '<div class="error_response">'.$error_message.'</div>';
	       echo '</div>';
	   }
	   else
	   {
	      $new_pass = $_POST['member_password'];
	      $confirm_pass = $_POST['confirm_password'];
	      if($new_pass != $confirm_pass)
	      {
	         $error_message = 'Password do not match';
	      }
	      else
	      {
	         $hash_pass = sha1($new_pass);
	         $sql = "UPDATE mc_users SET user_pass='$hash_pass' WHERE user_email='$user_email'";
	         $result = $db->query($sql);
	         if(!$result)
	         {
	            $error_message = 'Error: Something went wrong';
	         }
	         else
	         {
	            $success_message = 'Password is reset successfully.';
	            echo '<div class="col">';
	            echo '<div class="success_response">'.$success_message.'</div>';
	            echo '</div>';
	         }
	      }
	   }
		
	}
	else
	{
	?>
<script>
function validate_form() {
        if((document.getElementById("member_email").value == "") && (document.getElementById("member_email").value == "")) {
		document.getElementById("validation-message").innerHTML = "Please enter your email address!"
		return false;
	}
	if((document.getElementById("member_password").value == "") && (document.getElementById("confirm_password").value == "")) {
		document.getElementById("validation-message").innerHTML = "Please enter new password!"
		return false;
	}
	if(document.getElementById("member_password").value  != document.getElementById("confirm_password").value) {
		document.getElementById("validation-message").innerHTML = "Both password should be same!"
		return false;
	}
	
	return true;
}
</script>
<div class="col">
<form name="frmReset" id="frmReset" method="post" onSubmit="return validate_form();">
<h1>Reset Password</h1>
<?php if(!empty($success_message))
{ ?>
   <div class="success_response"><?php echo $success_message; ?></div>
<?php } ?>

<div id="validation-message">
<?php if(!empty($error_message)) { ?>
   <div class="error_response"><?php echo $error_message; ?></div>
<?php } ?>
</div>
<div class="field-group">
  <div><label for="Email">Email</label></div>
  <div>
    <input type="email" name="member_email" id="member_email" class="input-field">
  </div>
</div>
<div class="field-group">
  <div><label for="Password">Password</label></div>
  <div>
    <input type="password" name="member_password" id="member_password" class="input-field"></div>
  </div>
	
<div class="field-group">
  <div><label for="email">Confirm Password</label></div>
  <div><input type="password" name="confirm_password" id="confirm_password" class="input-field"></div>
</div>
	
<div class="field-group">
  <div><input type="submit" name="reset-password" id="reset-password" value="Reset Password" class="form-submit-button"></div>
</div>	
</form>
<?php
}
?>
</div>
</div>
</div>				
