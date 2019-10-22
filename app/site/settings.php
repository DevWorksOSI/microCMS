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
		$query = "SELECT * FROM seo";
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
		$this->google_verification = $seo['google_verification'];
		$this->google_analytics_id = $seo['google_analytics'];
		$this->bing_verification = $seo['bing_verification'];
		
		/* 
		 * We need the core settings
		 * to add to the site's SEO and Presentation.
		 * This is stored in the settings table.
		*/
		$query = "SELECT * FROM settings";
		$result = $db->query($query);
		$row = $db->fetch_array($result);
		$this->site_name = $row['site_name'];
		$this->base_url = $row['base_url'];
		$this->description = $row['description'];
		$this->keywords = $row['keywords'];
		$this->site_email = $row['site_email'];
		$this->site_logo = $row['site_logo'];
		$this->site_theme = $row['site_theme'];
	}
}
