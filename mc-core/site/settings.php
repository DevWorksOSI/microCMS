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
		$db = new db();
		$query = "SELECT * FROM mc_settings";
		$result = $db->query($query);
		$seo = $db->fetch_array($result);
		
		/*
		 * We need the bare minimals from the Database
		 * For the sites SEO
		*/
		$this->facebook = $seo['facebook'];
		$this->twitter = $seo['twitter'];
		$this->youtube = $seo['youtube'];
		$this->instagram = $seo['instagram'];
		$this->site_name = $seo['site_name'];
		$this->base_url = $seo['site_url'];
		$this->description = $seo['site_description'];
		$this->keywords = $seo['site_keywords'];
		$this->site_email = $seo['admin_email'];
		//$this->site_logo = $row['site_logo'];
		$this->site_theme = $seo['site_theme'];
		$this->time_zone = $seo['time_zone'];
	}
}
