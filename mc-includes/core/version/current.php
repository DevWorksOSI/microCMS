<?php

namespace version;

// We need the database
use database\db;

class current
{
	/*
	 * Get the sites information
	 * @ Header
	 * @ Footer
	 * From config/config.php
	*/

	function __construct()
	{
		$mcdb = new db();
		global $mcdb;
		/* 
		 * We need the core settings
		 * to add to the site's SEO and Presentation.
		 * This is stored in the settings table.
		*/
		$query = "SELECT * FROM mc_version";
		$result = $mcdb->query($query);
		if(!$result)
		{
		   echo $mcdb->error;
		}
		else
		{
		   $version = $mcdb->fetch_array($result);
		   $this->major = $version['major'];
		   $this->minor = $version['minor'];
		   $this->increment = $version['description'];
		   $this->codename = $version['coddename'];
		}
	}
}
