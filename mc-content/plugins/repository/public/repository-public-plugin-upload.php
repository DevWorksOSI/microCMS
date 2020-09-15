<?php
/*
Plugin name: Repository
Text Domain: repository
Author: Scott Cilley <scilley@dwosi.us>
Author URI: https://www.dwosi.us
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Description: Public Repository Plugin for the microCMS, microCMS.ORG
Requires at least: Since 1.5
Requires PHP: 7.4.8
Version: 0.1.0
*/
$settings = new site\settings;
echo '<div class="container">';
echo '<div class="row">';
if(isset($_SESSION['username']))
{
   if(isset($_POST['upload']))
   {
      $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
      $allowed = ['zip'];
      if (in_array($ext, $allowed))
      {
         move_uploaded_file($_FILES['file']['tmp_name'],"./uploads/plugins/{$_FILES['file']['name']}");
          echo '<div> File upload complete</div>';
          
         // Alert the team
         include 'mc-includes/PHPMailer.php';
         $file = $_FILES['file']['name'];
         $user = $_SESSION['username'];
         $mail->Subject = ''.$site_name.' - New File';
	  $mail->addAddress(''.$settings->admin_email.'', ''.$site_name.'');
	  $mail->Body = "<p>
	  Hello team, a plugin has been uploaded for review:<br><br>
	  <strong>Username:</strong> $user<br>
	  <strong>Type:</strong> Plugin<br>
	  <strong>File:</strong> $file
	  <br>
	  <br>
	  $site_name
	  </p>";
	  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
	  $mail->send();
          
      }
      else 
      {
         echo '<div>This file type cannot be uploaded. Only zip folders with the naming convention plugin-name-*.*.* are accepted</div>';
      }
   }
   else
   {
      echo '<form id="fileUpload" enctype="multipart/form-data" method="post" action="#">';
      echo '<input id="file" name="file" type="file" />';
      echo '<input type="submit" value="Upload" name="upload" id="upload" />';
      echo '</form>';
   }
}

else
{
   echo '<p>You must be <a href="/login">Logged in</a> in order to upload your plugin for review.</p>';
}
echo '</div>';
echo '</div>';
