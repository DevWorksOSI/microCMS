<?php

namespace sentry;

// We need the database
use database\db;

class security
{
	public function redirect_to($new_location)
	{
		header("Location: " . $new_location);
		exit;
	}
	
	/*
	 * Get Real IP
	 * Diggs deep to get the visitors actual ip address
	 * Doesnt matter if it's Spoofed or behind a VPN
	*/
	public function get_real_ip()
	{
		if (isset($_SERVER))
		{
			if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
			{
				return $_SERVER["HTTP_X_FORWARDED_FOR"];
			}
			if (isset($_SERVER["HTTP_CLIENT_IP"]))
			{
				return $_SERVER["HTTP_CLIENT_IP"];
			}

			return $_SERVER["REMOTE_ADDR"];
		}

		if (getenv('HTTP_X_FORWARDED_FOR'))
        {
			return getenv('HTTP_X_FORWARDED_FOR');
		}
		if (getenv('HTTP_CLIENT_IP'))
        {
			return getenv('HTTP_CLIENT_IP');
		}
		return getenv('REMOTE_ADDR');
	}
	
	public function ip_location($ip)
	{
		$numbers = preg_split( "/\./", $ip);    
		include("lib/ip_files/".$numbers[0].".php");
		$code=($numbers[0] * 16777216) + ($numbers[1] * 65536) + ($numbers[2] * 256) + ($numbers[3]);    
		foreach($ranges as $key => $value)
		{
			if($key<=$code)
			{
				if($ranges[$key][0]>=$code){$country=$ranges[$key][1];break;}
            }
		}
		if ($country==""){$country="unkown";}
		
		if($country == "CN")
		{
			$this->ban_ip($ip);
		}
		elseif($country == "RU")
		{
			$this->ban_ip($ip);
		}
		else
		{
			return $country;
		}
	}
	
	public function check_ban($ip)
	{
		$db = new db();
		$query = "SELECT * FROM banned_ip WHERE ip = '$ip'";
		$result = $db->query($query);
		$banned = $db->rows($result);
		if($banned == 1)
		{
			$this->redirect_to("https://www.projecthoneypot.org");
		}
	}
	
	public function ban_ip($ip)
	{
		$db = new db();
		$query = "INSERT INTO banned_ip (ip, bann_date) VALUES ('$ip', now())";
		$result = $db->query($query);
		return $result;
	}
}

?>