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
		$scdb = new db();
		$query = "SELECT * FROM mc_settings";
		$result = $scdb->query($query);
		$seo = $scdb->fetch_array($result);
		
		/*
		 * We need the bare minimals from the Database
		 * For the sites SEO
		*/
		$this->facebook = $seo['facebook'];
		$this->twitter = $seo['twitter'];
		$this->youtube = $seo['youtube'];
		$this->instagram = $seo['instagram'];
		$this->site_name = $seo['site_name'];
		//$this->site_slug = $seo['site_slug'];
		$this->site_url = $seo['site_url'];
		$this->site_description = $seo['site_description'];
		$this->site_keywords = $seo['site_keywords'];
		$this->site_email = $seo['admin_email'];
		//$this->site_logo = $row['site_logo'];
		$this->site_theme = $seo['site_theme'];
		$this->time_zone = $seo['time_zone'];
		$this->site_maint = $seo['maintenance'];
		//$this->admin_email = $seo['admin_email'];
	}
}
