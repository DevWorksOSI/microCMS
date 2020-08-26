<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//Load Files
require 'mc_includes/lib/PHPMailer/PHPMailer.php';
require 'mc_includes/lib/PHPMailer/Exception.php';
require 'mc_includes/lib/PHPMailer/SMTP.php';
/*
 * Get the host, user and password from the database
 * if use_smtp = true
 * else tell them that they cannot use this
*/
require_once('mc_includes/core/autoload.php');
use core\settings;
$settings = new settings();
 
// Regular Email
$mail = new PHPMailer(true);
//Server settings
$mail->SMTPDebug = 0;                                 		
$mail->isSMTP();
$mail->Host = ''.$settings->smtp_server.'';                                   									
$mail->SMTPAuth = true;                               		
$mail->Username = ''.$settings->smtp_user.'';
$mail->Password = ''.$settings->smtp_pass.'';
$mail->SMTPSecure = 'tls';                          		
$mail->Port = 587;                                    		
// From
$mail->setFrom(''.$$settings->smtp_user.'', ''.$settings->smtp_name;.'');
