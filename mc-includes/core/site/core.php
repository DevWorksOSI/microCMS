<?php
namespace site;
// We need the database
//use database\db;

class core
{
	/*
	 * mc_environment
	 * Gets this sites environment setting from the DW API
	 * This only works for the microCMS
	 * Since 1.6
	 * gets called in admin dashboard
	 * no public usage
	*/
	private function mc_environment($sitename)
	{
	   /*
	    * Templated function to interact with the DW OSI REST API
	    * To get the sites current status and display it in the 
	    * admin dashboard.
	   */
	}
	
	/*
	 * mc_deBug
	 * On Demand error checking
	 * Since 1.4
	 * 
	 * Usage echo $core->mc_error_check(true);
	*/
	public function mc_deBug($text)
	{
		if($text == true)
		{
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL);
		}
	}
	
	/*
	 * mc_redirect
	 * On Demand Re Direction
	 * Since 1.4
	 * 
	 * Usage $core->mc_redirect("/");
	*/
	public function mc_redirect($location)
	{
		header("Location: " . $location);
		exit;
	}
	
	/*
	 * mc_mail
	 * Send email using PHP_Mailer
	 * Since 1.5
	 *
	 * Usage: $core->mc_mail('yourEmail, theirEmail, their name, Some Subject, Body Contents. Plain Text or HTML);
	*/
	public function mc_mail($from, $to, $name, $subject, $body)
	{
	  include 'mc_includes/lib/mailer.php';
	  $mail->Subject = ''.$from.'';
	  $mail->addAddress(''.$to.'', ''.$name.'');
	  $mail->Body = ''.$body.'';
	  $mail->isHTML(true);
	  $mail->send();
	}
	
	/*
	 * VerifyEmail
	 * Verifies a Valid Email Address
	 * Returns bool true if yes and false if no
	 * uses built in php function
	 * Since 1.3
	 * usage $core->mc_verifyEmail($email);
	*/
	public function mc_verifyEmail($email)
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
}
