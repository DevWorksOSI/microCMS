<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
	header("Location: /");
}
else
{
	/*
	 * Function operatives
	 * Set the operation variable for the switch
	 */
	if (isset($_GET['op']))
	{
		$d = $_GET['op'];
	}
	elseif (isset($_POST['op']))
	{ // Forms
		$d = $_POST['op'];
	} 
	else
	{
		$d = NULL;
	}
	
	// Functions
	
	function manage()
	{
		$core = new microcms\core;
		$db = new database\db;
		echo '<div class="main">';
		if(!isset($_SESSION['admin']))
		{
			echo '<h2>WARNING!</h2>';
			echo '<p>You do not belong here, your IP address has been tracked. We will ban you if you continue. you have been warned.</p>';
		}
		else
		{
			echo '<div id="adminmenu">';
			echo '<ul>';
			$query = "SELECT * FROM modules WHERE module_type = 1";
			$result = $db->query($query);
			while($row = $db->fetch_assoc($result))
			{
				$module_name = $row['module_name'];
				$module_link = $row['module_link'];
				echo '<li><a href="/?p=manage&op='.$module_name.'"><img src="/img/manage/'.$module_name.'.png"><br>'.$module_link.'</a></li>';
			}
			echo '<li><a href="/?p=manage&op=settings"><img src="/img/manage/settings.png"><br>Site Settings</a></li>';
			echo '</ul>';
			echo '<br><br>';
			echo '</div>';
				
		}
		echo '</div>';		
	}
	function seo()
	{
		$core = new microcms\core;
		$db = new database\db;
		$settings = new microcms\settings;
		if(!isset($_SESSION['admin']))
		{
			echo '<h2>WARNING!</h2>';
			echo '<p>You do not belong here, your IP address has been tracked. We will ban you if you continue. you have been warned.</p>';
		}
		else
		{
			echo '<div class="main">';
			echo '<h2>SEO</h2>';
			echo '<p>Welcome to SEO Settings</p>';
			echo '<div>';
		
			if(isset($_POST['update']))
			{
				$facebook = $db->prep_data($_POST['facebook']);
				$twitter = $db->prep_data($_POST['twitter']);
				$youtube = $db->prep_data($_POST['youtube']);
				$instagram = $db->prep_data($_POST['instagram']);
				$google_verification = $db->prep_data($_POST['google_verification']);
				$google_analytics_id = $db->prep_data($_POST['google_analytics_id']);
				$bing_verification = $db->prep_data($_POST['bing_verification']);
			
				$query = "UPDATE seo SET facebook='$facebook', twitter='$twitter', youtube='$youtube', instagram='$instagram', google_verification='$google_verification', google_analytics='$google_analytics_id', bing_verification='$bing_verification'";
				$result = $db->query($query);
				if(!$result)
				{
					echo '<h2>ERROR</h2>';
					echo '<p>There was an error while attemptng to update the SEO settings.</p>';
				}
				else
				{
					$core->redirect_to("/?p=manage&op=seo");
				}
			}
			else
			{
				echo '<p>Please only use your handle for each Social and SEO setting as the base url for each is hard coded.<br>IE: Facebook, Twitter, Youtube, Etc...</p>';
				echo '<p>If you are not going to use any of the Feilds below, just leave them blank, the rest of your information will be stored.</p>';
				echo '<p>';
				// Wee need the SEO data
				$facebook = $settings->facebook;
				$twitter = $settings->twitter;
				$youtube = $settings->youtube;
				$instagram = $settings->instagram;
				$google_verification = $settings->google_verification;
				$google_analytics_id = $settings->google_analytics_id;
				$bing_verification = $settings->bing_verification;

				echo '<form name="seo" id="seo" action="/?p=manage&op=seo" method="post">';
				echo '<fieldset>';
				echo '<legend><strong>Social Media Settings</strong></legend>';
				// Facebook
				if($facebook == '')
				{
					echo '<strong>Facebook</strong>: <input type="text" name="facebook"><br>';
				}
				else
				{
					echo '<strong>Facebook</strong>: <input type="text" name="facebook" value="'.$facebook.'"><br>';
				}
				// Twitter
				if($twitter == '')
				{
					echo '<strong>Twitter</strong>: <input type="text" name="twitter"><br>';
				}
				else
				{
					echo '<strong>Twitter</strong>: <input type="text" name="twitter" value="'.$twitter.'"><br>';
				}
				// Youtube
				if($youtube == '')
				{
					echo '<strong>Youtube</strong>: <input type="text" name="youtube"><br>';
				}
				else
				{
					echo '<strong>Youtube:</strong> <input type="text" name="youtube" value="'.$youtube.'"><br>';
				}
			
				// Instagram
				if($instagram == '')
				{
					echo '<strong>Instagram</strong>: <input type="text" name="instagram"><br>';
				}
				else
				{
					echo '<strong>Instagram:</strong> <input type="text" name="instagram" value="'.$instagram.'"><br>';
				}
				echo '</fieldset>';
				echo '<br>';
				echo '<fieldset>';
				echo '<legend><strong>Search Engine Settings</strong></legend>';
				// Google Site Verification
				if($google_verification == '')
				{
					echo '<strong>Google Site Verification</strong>: <input type="text" name="google_verification"><br>';
				}
				else
				{
					echo '<strong>Google Site Verification:</strong> <input type="text" name="google_verification" value="'.$google_verification.'"><br>';
				}
				
				// Google Analytics
				if($google_analytics_id == '')
				{
					echo '<strong>Google Analytics ID</strong>: <input type="text" name="google_analytics_id"><br>';
				}
				else
				{
					echo '<strong>Google Analytics ID:</strong> <input type="text" name="google_analytics_id" value="'.$google_analytics_id.'"><br>';
				}
				
				// Bing Site Verification
				if($bing_verification == '')
				{
					echo '<strong>Bing Site Verification</strong>: <input type="text" name="bing_verification"><br>';
				}
				else
				{
					echo '<strong>Bing Site Verification:</strong> <input type="text" name="bing_verification" value="'.$bing_verification.'"><br>';
				}
				echo '</fieldset>';
				
				echo '<input type="submit" name="update" value="Update SEO"><br>';
				echo '</form>';
				echo '</p>';
			}
			echo '</div>';
			echo '<p><a href="/manage">Return to Management</a></p>';
			echo '</div>';
		}
	}
	
	function settings()
	{
		$core = new microcms\core;
		$db = new database\db;
		$settings = new microcms\settings;
		echo '<div class="main">';
		if(!isset($_SESSION['admin']))
		{
			echo '<h2>WARNING!</h2>';
			echo '<p>You do not belong here, your IP address has been tracked. We will ban you if you continue. you have been warned.</p>';
		}
		else
		{
			if(isset($_POST['update']))
			{
				$site_name = $db->prep_data($_POST['site_name']);
				$base_url = $db->prep_data($_POST['base_url']);
				$site_logo = $db->prep_data($_POST['site_logo']);
				$site_description = $db->prep_data($_POST['site_description']);
				$site_keywords = $db->prep_data($_POST['site_keywords']);
				$site_email = $db->prep_data($_POST['site_email']);
				$site_theme = $db->prep_data($_POST['site_theme']);
				$query = "UPDATE settings SET site_name='$site_name', base_url='$base_url', site_logo='$site_logo', description='$site_description', keywords='$site_keywords', site_email='$site_email', site_theme='$site_theme'";
				$result = $db->query($query);
				if($result)
				{
					echo '<h2>Success!</h2>';
					echo '<p><a href="/?p=manage&op=settings"><strong>Confirm</strong></a></p>';
				}
				else
				{
					echo '<h2>ERROR!</h2>';
					echo '<p>There was an error when trying to update your site\'s settings!</p>';
				}
			}
			else
			{
				
				$site_name = $settings->site_name;
				$base_url = $settings->base_url;
				$description = $settings->description;
				$keywords = $settings->keywords;
				$site_email = $settings->site_email;
				$site_logo = $settings->site_logo;
				$site_theme = $settings->site_theme;
				echo '<br>';
				echo '<h1>Site Settings</h1>';
				echo '<p>Every part of this form is required or your site will not work correctly and never be found by anyone.</p>';
				echo '<br>';
				echo '<fieldset>';
				echo '<legend><strong>Base Settings</strong></legend>';
				echo '<form name="settings" id="settings" action="/?p=manage&op=settings" method="post">';
				// Facebook
				if($site_name == '')
				{
					echo '<strong>Site Name:</strong>: <input type="text" name="site_name"><br><br>';
				}
				else
				{
					echo '<strong>Site Name:</strong>: <input type="text" name="site_name" value="'.$site_name.'"><br><br>';
				}
				if($base_url == '')
				{
					echo '<strong>Base URL:</strong>: <input type="text" name="base_url"> <small>http:// or https://somedomain.com</small><br><br>';
				}
				else
				{
					echo '<strong>Base URL:</strong>: <input type="text" name="base_url" value="'.$base_url.'"><br><br>';
				}
				echo '<legend><strong>Site Logo</strong></legend>';
				if($site_logo == '')
				{
					echo '<strong>Site Logo:</strong>: <input type="text" name="site_logo"> <small>Image must be in the <code>img</code> directory</small><br><br>';
				}
				else
				{
					echo '<strong>Site Logo:</strong>: <input type="text" name="site_logo" value="'.$site_logo.'"><br><br>';
				}
				echo '<legend><strong>Site Description</strong></legend>';
				if($description == '')
				{
					echo '<textarea name="site_description" rows="10" cols="60"></textarea><br><br>';
				}
				else
				{
					echo '<textarea name="site_description" rows="10" cols="60">'.$description.'</textarea><br><br>';
				}
				echo '<legend><strong>Key Words</strong></legend>';
				if($keywords == '')
				{
					echo '<textarea name="site_keywords" rows="10" cols="60"></textarea><br><br>';
				}
				else
				{
					echo '<textarea name="site_keywords" rows="10" cols="60">'.$keywords.'</textarea><br><br>';
				}
				echo '<legend><strong>Site Email Address</strong></legend>';
				if($site_email == '')
				{
					echo '<strong>Site Email:</strong>: <input type="text" name="site_email"><br><br>';
				}
				else
				{
					echo '<strong>Site Email:</strong>: <input type="text" name="site_email" value="'.$site_email.'"><br><br>';
				}
				echo '<legend><strong>Theme</strong></legend>';
				$dir = "themes";
				$handle = opendir($dir);
				while($name = readdir($handle))
				{
					if(is_dir("$dir/$name"))
					{
						if($name != '.' && $name != '..')
						{
							if($site_theme == '')
							{
								echo '<input type="radio" name="site_theme" value="'.$name.'">  '.$name.'&nbsp;';
							}
							else
							{
								echo '<input type="radio" name="site_theme" value="'.$name.'" checked>  '.$name.'&nbsp;';
							}
						}
					}
				}
				closedir($handle);
				echo '</fieldset>';
				echo '<input type="submit" name="update" value="Update Now!"><br>';
				echo '</form>';
				echo '<p></p>';
				echo '<p><a href="/manage">Return to Site Management</a></p>';
				echo '</div>';
			}
		}
	}
	
	/*
	 * Additional Functions needed
	 * For each Method within the Management Center
	 * Blogs
	 * News
	 * The Switch Below will become dynamic
	*/
	
	/*
	 * Switch
	 * Allows function to be used
	 * $d is derived from the Function operatives
	 */
	switch($d)
	{
		// SEO
		case 'seo':
			seo();
			break;
			
		// Core Sttings
		case 'settings':
			settings();
			break;
			
		// Main
		default:
		   manage();
		   break;
	}
}
?>
