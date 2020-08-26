<?php

namespace site;

// We need the database
use database\db;

class settings
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
		$query = "SELECT * FROM mc_settings";
		$result = $mcdb->query($query);
		if(!$result)
		{
		   echo $mcdb->error;
		}
		else
		{
		   $setting = $mcdb->fetch_array($result);
		   $this->site_name = $setting['site_name'];
		   $this->site_url = $setting['site_url'];
		   $this->description = $setting['description'];
		   $this->keywords = $setting['keywords'];
		   $this->admin_email = $setting['admin_email'];
		   //$this->site_logo = $setting['site_logo'];
		   //$this->site_theme = $setting['site_theme'];
		   $this->facebook = $setting['facebook'];
		   $this->twitter = $setting['twitter'];
		   $this->youtube = $setting['youtube'];
		   $this->instagram = $setting['instagram'];
		   //$this->google_verification = $setting['google_verification'];
		   //$this->google_analytics_id = $setting['google_analytics'];
		   //$this->bing_verification = $setting['bing_verification'];
		}
	}
}
