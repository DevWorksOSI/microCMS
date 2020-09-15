<?php
namespace site;

class core
{
   /*
    * check_errors
    * if set to true, show and log PHP errros
    * will also load no_cacheHeaders()
    * set  in index.php
   */
   public function check_errors($text)
   {
      if($text == true)
      {
         error_reporting(E_ALL); // Error engine - always ON!
         ini_set('display_errors', TRUE); // Error display - OFF in production env or real server
         ini_set('log_errors', TRUE); // Error logging
         ini_set('error_log', 'errors.log'); // Logging file
         ini_set('log_errors_max_len', 1024); // Logging file size
         $this->no_cacheHeader();
      }
   }
   
   /*
    * no_cacheHeader()
    * Used during development if check_errors is true
    * Browser Cache's are a pain in the ass
   */
   public function no_cacheHeader()
   {
      header('Cache-Control: no-store, no-cache, must-revalidate');
      header('Cache-Control: post-check=0, pre-check=0', false);
      header('Pragma: no-cache');
   }
   
   /*
    * verifyEmail($email)
    * takes input variable $email from forms
    * uses PHPS built-in FILTER_VALIDATE_EMAIL
   */
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
   
   /*
    * redirect_to()
    * takes an argument from the calling script
    * then does a head redirect to where the calling script is sending
    * Usage: $core-redirect-to("/");
  */
   public function redirect_to($new_location)
   {
      header("Location: " . $new_location);
      exit;
   }
   
   /*
    * slugify()
	* takes the title string of a post and slugifies it
	* usage $core->slugify($string);
	* used in mc-includes/functions.php
   */
   public function slugify($string)
	{
		$slug = strtolower(preg_replace('/[^a-zA-Z0-9\-]/', '',preg_replace('/\s+/', '-', $string) ));
		return $slug;
	}
	
	public function welcome_user($email, $display_name, $user_login)
	 {
	    global $mcdb;
	    // Check if we have a valid email server
	    $query = "SELECT mailserver_url FROM mc_settings";
	    $result = $mcdb->query($query);
	    $ms = $mcdb->fetch_assoc($result);
	    $mail_server = $ms['mailserver_url'];
	    if($mail_server != '' || $mail_server != 'mail.example.com')
	    {
	       include 'mc-includes/PHPMailer.php';
	       $mail->Subject = ''.$site_name.' - Welcome';
	       $mail->addAddress(''.$email.'', ''.$display_name.'');
	       $mail->Body = "<p>Hello $display_name,<br>
	       Welcome to $site_name<br><br> We are so happy to have you with us.<br>
	       Your Login is $user_login and your password is the one you used to signup with.<br>
	       Please note that we cannot retrieve your password for you, for security reasons.
	       <br>
	       <br>
	       $site_name
	       </p>";
	       $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
	       //$mail->send();
	       if (!$mail->send())
	       {
	         $to = ''.$email.'';
			 $subject = ''.$site_name.' - Welcome';
			 $headers .= 'From: '.$admin_email.', '.$site_name.'' . "\r\n";
			 $headers = "MIME-Version: 1.0" . "\r\n";
			 $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			 $message = "<p>Hello $display_name, Welcome to $site_name</p>
			 <p>We are happy to have you!</p>
			 ";
			 mail($to,$subject,$message,$headers);
	       }
	       else
	       {
	         echo '<h2>Welcome</h2>';
	         echo '<p>Hello '.$display_name.', an email has been sent to your inbox, please remember to check the Spam/Junk folder. Welcome to '.$site_name.', please <a href="/login">Log In</a></p>';
	         
	         // Send to admin
	       $mail2->Subject = ''.$site_name.' - New user';
	       $mail2->addAddress(''.$settings->admin_email.'', ''.$settings->site_name.'');
	       $mail2->Body = "<p>
	       New user on your site, $site_name:<br><br>
	       Username: $user_login<br><br>
	       Email: $email
	       <br>
	       <br>
	       $site_name
	       </p>";
	       $mail2->AltBody = 'To view the message, please use an HTML compatible email viewer!';
	       $mail2->send();
	       }
	       
	    }
	    else
	    {
	       // Send email the old way
	       $subject = "Welcome to $site_name";
	       $msg = "Hello $display_name, welcome to $site_name, we are so happy to have you with us. Your Login is $user_login and your password is the one that you used to sign up at $site_name. Please note that we cannot retrieve your password for you for security reasons.";
	       
	       mail($email,$subject,$msg);
	    }
	 }
}
