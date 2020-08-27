<?php

namespace sentry;
require_once('mc-config.php');
// We need the database
use database\db;


class security
{
	private function httpbl_config()
	{
		$this->httpbl_key = httpBL_KEY;
	}
	public function redirect_to($new_location)
	{
		header("Location: " . $new_location);
		exit;
	}
	
	public function httpbl_check()
	{
		// Initialize values
		//setup();
		$apikey = $this->httpbl_config();
		
		// IP to test
		$ip = $this->get_real_ip();
		
		// build the lookup DNS query
		// Example : for '127.9.1.2' you should query 'abcdefghijkl.2.1.9.127.dnsbl.httpbl.org'
		$lookup = $apikey . '.' . implode('.', array_reverse(explode ('.', $ip ))) . '.dnsbl.httpbl.org';
		
		// check query response
		$result = explode( '.', gethostbyname($lookup));
		
		if ($result[0] == 127)
		{
			// query successful !
			$activity = $result[1];
			$threat = $result[2];
			$type = $result[3];
			
			if ($type & 0) $typemeaning .= 'Search Engine, ';
			if ($type & 1) $typemeaning .= 'Suspicious, ';
			if ($type & 2) $typemeaning .= 'Harvester, ';
			if ($type & 4) $typemeaning .= 'Comment Spammer, ';
			$typemeaning = trim($typemeaning,', ');
			
			if ($type >= 4 && $threat > 0)
			{
				$this->ban_ip($ip);
			}
			if($type < 4 && $threat > 20)
			{
				$this->ban_ip($ip);
			}
		}
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
		include("mc-includes/lib/ip_files/".$numbers[0].".php");
		$code=($numbers[0] * 16777216) + ($numbers[1] * 65536) + ($numbers[2] * 256) + ($numbers[3]);    
		foreach($ranges as $key => $value)
		{
			if($key<=$code)
			{
				if($ranges[$key][0]>=$code){$country=$ranges[$key][1];break;}
            }
		}
		if ($country=="")
		{
			$country="unkown";
		}
		
		if($country == "CN")
		{
			$this->ban_ip($ip);
			$this->redirect_to("https://www.projecthoneypot.org");
		}
		elseif($country == "RU")
		{
			$this->ban_ip($ip);
		}
		elseif($country == "AF")
		{
			$this->ban_ip($ip);
			$this->redirect_to("https://www.projecthoneypot.org");
		}
		elseif($country == "IQ")
		{
			$this->ban_ip($ip);
			$this->redirect_to("https://www.projecthoneypot.org");
		}
		elseif($country == "KP")
		{
			$this->ban_ip($ip);
			$this->redirect_to("https://www.projecthoneypot.org");
		}
		elseif($country == "IR")
		{
			$this->ban_ip($ip);
			$this->redirect_to("https://www.projecthoneypot.org");
		}
		else
		{
			return $country;
		}
	}
	
	public function check_ban($ip)
	{
		$db = new db();
		$query = "SELECT * FROM mc_bannedip WHERE ip = '$ip'";
		$result = $db->query($query);
		$banned = $db->rows($result);
		if($banned == true)
		{
			$this->redirect_to("https://www.projecthoneypot.org");
		}
	}
	
	public function ban_ip($ip)
	{
		$db = new db();
		$query = "INSERT INTO mc_bannedip (ip, bann_date) VALUES ('$ip', now())";
		$result = $db->query($query);
		return $result;
		$this->redirect_to("https://www.projecthoneypot.org");
	}
}

?>
