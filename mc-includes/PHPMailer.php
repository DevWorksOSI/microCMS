<?php
 // Import PHPMailer classes into the global namespace
   // These must be at the top of your script, not inside a function
   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;
   //Load Files
   require 'PHPMailer/PHPMailer.php';
   require 'PHPMailer/Exception.php';
   require 'PHPMailer/SMTP.php';
/*
 * Get the host, user and password from the database
 * if use_smtp = true
 * else tell them that they cannot use this
*/

$db = new database\db;
$query = "SELECT mailserver_url, mailserver_login, mailserver_pass, mailserver_port, site_name, admin_email FROM mc_settings";
$result = $db->query($query);
$setting = $db->fetch_array($result);
$mail_server = $setting['mailserver_url'];
$mail_user = $setting['mailserver_login'];
$mail_pass = $setting['mailserver_pass'];
$mail_port = $setting['mailserver_port'];
$site_name = $setting['site_name'];
$admin_email = $setting['admin_email'];

if($mail_server != '' || $mail_server != 'mail.example.com')
{
   $use_smtp = 1;
   $smtp_user = ''.$mail_user.'';
   $smtp_pass = ''.$mail_pass.'';
   $smtp_server = ''.$mail_server.'';
   $smtp_port = ''.$mail_port.'';
   $site_name = ''.$site_name.'';
   
   // Send mail with PHPMailer
   $mail = new PHPMailer(true);
   $mail->isHTML(true);
   $mail->SMTPDebug = 0;                                 		
   $mail->isSMTP();                                      		
   $mail->Host = ''.$smtp_server.'';  							
   $mail->SMTPAuth = true;                               		
   $mail->Username = ''.$smtp_user.'';
   $mail->Password = ''.$smtp_pass.'';
   $mail->SMTPSecure = 'tls';                          		
   $mail->Port = ''.$smtp_port.'';                                    		
   $mail->setFrom(''.$mail_user.'', ''.$site_name.'');
   $mail->ClearAddresses();
   
   // If mail to admin is needed
   $mail2 = new PHPMailer(true);
   $mail2->isHTML(true);
   $mail2->SMTPDebug = 0;                                 		
   $mail2->isSMTP();                                      		
   $mail2->Host = ''.$smtp_server.'';  							
   $mail2->SMTPAuth = true;                               		
   $mail2->Username = ''.$smtp_user.'';
   $mail2->Password = ''.$smtp_pass.'';
   $mail2->SMTPSecure = 'tls';                          		
   $mail2->Port = ''.$smtp_port.'';                                    		
   $mail2->setFrom(''.$mail_user.'', ''.$site_name.'');
   $mail2->ClearAddresses();
}
