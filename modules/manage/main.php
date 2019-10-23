<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
	header("Location: /");
}
else
{
	$admin = $_SESSION['admin'];
	if($admin == FALSE)
	{
		$core->redirect_to("/");
	}
	else
	{
		echo '<div class="container">';
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		/*
		* Function operatives
		* Set the operation variable for the switch
		*/
		if (isset($_GET['op']))
		{
			$d = $_GET['op'];
		}
		elseif (isset($_POST['op']))
		{
			$d = $_POST['op'];
		} 
		else
		{
			$d = NULL;
		}
		
		function all()
		{
			echo '<p><small><a href="/" hreflang="en">Home</a> >> Site Management</small></p>';
			echo '<h3>Site Management</h3>';
			$db = new database\db;
			echo '<div id="adminmenu">';
			echo '<h3>Non Core Modules</h3>';
			echo '<ul>';
			$query = "SELECT * FROM modules WHERE module_type = 1 && active = 1 && core = 0";
			$result = $db->query($query);
			while($row = $db->fetch_assoc($result))
			{
				$module_name = $row['module_name'];
				$module_link = $row['module_link'];
				echo '<li><a href="/?p=manage&op='.$module_link.'"><img src="img/manage/'.$module_link.'.png" width="40" width="40"><br>'.$module_name.'</a></li>';
			}
			echo '</ul>';
			echo '<hr>';
			echo '<h3>Core Modules</h3>';
			echo '<ul>';
			echo '<li><a href="/?p=manage&op=blogs"><img src="img/manage/blogs.png" height="40" width="40"><br>Blogs</a></li>';
			echo '<li><a href="/?p=manage&op=modules"><img src="img/manage/modules.png" height="40" width="40"><br>Modules</a></li>';
			echo '<li><a href="/?p=manage&op=seo"><img src="img/manage/seo.png" width="40" width="40"><br>Settings</a></li>';
			echo '<li><a href="/?p=manage&op=version"><img src="img/manage/version.png" width="40" width="40"><br>Update</a></li>';
			echo '</ul>';
			echo '<br>';
			echo '</div>';
			echo '<br><br>';
		}
		
		function seo()
		{
			$db = new database\db;
			$core = new site\core;
			echo '<p><small><a href="/" hreflang="en">Home</a> >> <a href="/manage">Site Management</a> >> SEO</small></p>';
			echo '<h3>SEO</h3>';
			echo '<p>The Purpose of SEO is to make your site Search Engine Optimized. What you will find here is the most common information used by search engines.</p>';
			if(isset($_POST['update']))
			{
				// Settings
				$site_name = $_POST['site_name'];
				$base_url = $_POST['base_url'];
				$site_logo = $_POST['site_logo'];
				$description = $_POST['description'];
				$keywords = $_POST['keywords'];
				$site_email = $_POST['site_email'];
				$site_theme = $_POST['site_theme'];
				
				// SEO
				$facebook = $_POST['facebook'];
				$twitter = $_POST['twitter'];
				$youtube = $_POST['youtube'];
				$instagram = $_POST['instagram'];
				$google_analytics = $_POST['google_analytics'];
				$google_code = $_POST['google_code'];
				$bing_code = $_POST['bing_code'];
				
				// Update settings
				$query = "UPDATE settings SET site_name='$site_name', base_url='$base_url', site_logo='$site_logo', description='$description', keywords='$keywords', site_email='$site_email', site_theme='$site_theme'";
				$result = $db->query($query);
				if($result)
				{
					// Update SEO
					$query = "UPDATE seo SET facebook='$facebook', twitter='$twitter', youtube='$youtube', instagram='$instagram', google_analytics='$google_analytics', google_verification='$google_code', bing_verification='$bing_code'";
					$result = $db->query($query);
					if($result)
					{
						$core->redirect_to("/?p=manage&op=seo");
					}
				}
			}
			else
			{
				// We need the data from Settings and SEO
				$query = "SELECT * FROM settings";
				$result = $db->query($query);
				$row = $db->fetch_assoc($result);
				echo '<form action="/?p=manage&op=seo" method="POST">';
				echo '<fieldset>';
				echo '<legend><strong>Site Settings</strong></legend>';
				echo '<table border="0" cellpadding="3" cellsapcing="3" width="100%">';
				echo '<tr>';
				echo '<td><label for="site_name">Site Name:</label></td>';
				echo '<td>&nbsp;</td>';
				echo '<td><input id="site_name" name="site_name" type="text" required value="'.$row['site_name'].'"></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td><label for="base_url">URL:</label></td>';
				echo '<td>&nbsp;</td>';
				echo '<td><input id="base_url" name="base_url" type="text" required value="'.$row['base_url'].'"></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td><label for="site_logo">Logo:</label></td>';
				echo '<td>&nbsp;</td>';
				// We need to change this to a select
				//echo '<td><input id="site_logo" name="site_logo" type="text" required value="'.$row['site_logo'].'"></td>';
				echo '<td><select name="site_logo" id="site_logo">';
				$dirPath = dir('img/assets');
				while (($file = $dirPath->read()) !== false)
				{
					if($file != '.' && $file != '..' && $file != '.ico' && $file != '.php')
					{
						echo "<option value=\"" . trim($file) . "\">" . $file . "\n";
					}
				}
				$dirPath->close();
				echo '</select>';
				echo '</select>';
				echo '</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td valign="top"><label for="description">Site Description:</label></td>';
				echo '<td>&nbsp;</td>';
				echo '<td><textarea rows="5" cols="50" id="description" name="description">'.$row['description'].'</textarea></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td valign="top"><label for="keywords">Site Key Words:</label></td>';
				echo '<td>&nbsp;</td>';
				echo '<td><textarea rows="5" cols="50" id="keywords" name="keywords">'.$row['keywords'].'</textarea></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td><label for="site_email">Site Email Address:</label></td>';
				echo '<td>&nbsp;</td>';
				echo '<td><input id="site_email" name="site_email" required value="'.$row['site_email'].'"></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td><label for="site_theme">Site Theme:</label></td>';
				echo '<td>&nbsp;</td>';
				echo '<td>';
				echo '<select name="site_theme" id="site_theme">';
				$dir = "themes";
				$handle = opendir($dir);
				while($name = readdir($handle))
				{
					if(is_dir("$dir/$name"))
					{
						if($name != '.' && $name != '..')
						{
							echo '<option>'.$name.'</option>';
						}
					}
				}
				closedir($handle);
				echo '</select>';
				echo '</td>';
				echo '</tr>';
				echo '</table>';
				echo '<br>';
				$query = "SELECT * FROM seo";
				$result = $db->query($query);
				$seo = $db->fetch_assoc($result);
				echo '<legend><strong>Social Media</strong></legend>';
				echo '<table border="0" cellpadding="3" cellspacing="3" width="100%">';
				echo '<tr>';
				echo '<td><label for="facebook">Facebook:</label></td>';
				echo '<td>&nbsp;</td>';
				echo '<td><input id="facebook" name="facebook" type="text" value="'.$seo['facebook'].'"> <small>Facebook Account Name</small></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td><label for="twitter">Twitter:</label></td>';
				echo '<td>&nbsp;</td>';
				echo '<td><input id="twitter" name="twitter" type="text" value="'.$seo['twitter'].'"> <small>Twitter Account Name</small></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td><label for="youtube">Youtube:</label></td>';
				echo '<td>&nbsp;</td>';
				echo '<td><input id="youtube" name="youtube" type="text" value="'.$seo['youtube'].'"> <small>Youtube Account Name</small></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td><label for="instagram">Instagram:</label></td>';
				echo '<td>&nbsp;</td>';
				echo '<td><input id="instagram" name="instagram" type="text" value="'.$seo['instagram'].'"> <small>Instagram Account Name</small></td>';
				echo '</tr>';
				echo '</table>';
				echo '<br>';
				echo '<legend><strong>Google Analytics</strong></legend>';
				echo '<table border="0" cellpadding="3" cellsapcing="3" width="100%">';
				echo '<tr>';
				echo '<td><label for="google_analytics">Analytics ID:</label></td>';
				echo '<td>&nbsp;</td>';
				echo '<td><input id="google_analytics" name="google_analytics" type="text" value="'.$seo['google_analytics'].'"> <a href="https://support.google.com/analytics/answer/1008015?hl=en" hreflang="en" target="_blank"><strong>?</strong></a></td>';
				echo '</tr>';
				echo '</table>';
				echo '<br>';
				echo '<legend><strong>Google Search Engine</strong></legend>';
				echo '<table border="0" cellpadding="3" cellsapcing="3" width="100%">';
				echo '<tr>';
				echo '<td><label for="google_code">Google Meta Code:</label></td>';
				echo '<td>&nbsp;</td>';
				echo '<td><input id="google_code" name="google_code" type="text" value="'.$seo['google_verification'].'"> <a href="https://support.google.com/webmasters/answer/9008080?hl=en" hreflang="en" target="_blank"><strong>?</strong></a></td>';
				echo '</tr>';
				echo '</table>';
				echo '<br>';
				echo '<legend><strong>Bing Search Engine</strong></legend>';
				echo '<table border="0" cellpadding="3" cellsapcing="3" width="100%">';
				echo '<tr>';
				echo '<td><label for="bing_code">Bing Meta Code:</label></td>';
				echo '<td>&nbsp;</td>';
				echo '<td><input id="bing_code" name="bing_code" type="text" value="'.$seo['bing_verification'].'"> <a href="https://www.bing.com/webmaster/help/how-to-verify-ownership-of-your-site-afcfefc6" hreflang="en" target="_blank"><strong>?</strong></a></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>&nbsp;</td>';
				echo '<td>&nbsp;</td>';
				echo '<td><br><input id="update" name="update" type="submit" value="Update Now"></td>';
				echo '</tr>';
				echo '</table>';
				echo '</fieldset>';
				echo '</form>';
			}
		}
		
		function modules()
		{
			$db = new database\db;
			$core = new site\core;
			echo '<p><small><a href="/" hreflang="en">Home</a> >> <a href="/manage">Site Management</a> >> Modules</small></p>';
			echo '<h3>Modules</h3>';
			echo '<table border="0" cellpadding="3" cellspacing="3" width="100%">';
			echo '<tr>';
			echo '<td><strong>Module Name</strong></td>';
			echo '<td>&nbsp;</td>';
			echo '<td><strong>Module Type</strong></td>';
			echo '<td>&nbsp;</td>';
			echo '<td><strong>Status</strong></td>';;
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
			echo '</tr>';
			$query = "SELECT * FROM modules ORDER BY module_name ASC";
			$result = $db->query($query);
			while($rows = $db->fetch_assoc($result))
			{
				$module_id = $rows['id'];
				$module_name = $rows['module_name'];
				$module_link = $rows['module_link'];
				$module_type = $rows['module_type'];
				$active = $rows['active'];
				
				// Module Types
				if($module_type == 1)
				{
					$type = 'Admin';
				}
				if($module_type == 0)
				{
					$type = 'User';
				}
				
				// Statuses
				if($active == 1)
				{
					$status = 'Active';
				}
				else
				{
					$status = 'In Active';
				}
				echo '<tr>';
				echo '<td>'.$module_link.'</td>';
				echo '<td>&nbsp;</td>';
				echo '<td>'.$type.'</td>';
				echo '<td>&nbsp;</td>';
				echo '<td>'.$status.'</td>';
				echo '<td>&nbsp;</td>';
				if($status == 'Active')
				{
					echo '<td>&nbsp;</td>';
					echo '<td><a href="/?p=manage&op=stop_module&id='.$module_id.'"><img src="img/manage/stop.png" height="30" width="30"></a></td>';
					echo '<td>&nbsp;</td>';
					echo '<td><a href="/?p=manage&op=drop_module&id='.$module_id.'"><img src="img/manage/delete.png" height="30" width="30"></a></td>';
				}
				elseif($status == 'In Active')
				{
					echo '<td><a href="/?p=manage&op=start_module&id='.$module_id.'"><img src="img/manage/plus.png" height="30" width="30"></a></td>';
					echo '<td>&nbsp;</td>';
					echo '<td>&nbsp;</td>';
					echo '<td><a href="/?p=manage&op=drop_module&id='.$module_id.'"><img src="img/manage/delete.png" height="30" width="30"></a></td>';
				}
				else
				{
					echo '<td><a href="/?p=manage&op=start_module&id='.$module_id.'"><img src="img/manage/plus.png" height="30" width="30"></a></td>';
					echo '<td>&nbsp;</td>';
					echo '<td><a href="/?p=manage&op=stop_module&id='.$module_id.'"><img src="img/manage/stop.png" height="30" width="30"></a></td>';
					echo '<td>&nbsp;</td>';
					echo '<td><a href="/?p=manage&op=drop_module&id='.$module_id.'"><img src="img/manage/delete.png" height="30" width="30"></a></td>';
				}
				echo '</tr>';
			}
			echo '</table>';
			echo '<hr>';
			if(isset($_POST['submit']))
			{
				$mod = $db->prep_data($_POST['available']);
				//$mod_link = ucfirst($mod);
				$modName = $db->prep_data(ucfirst($mod));
				$query = "INSERT INTO modules (module_name, module_link, module_type, active) VALUES ('$mod', '$modName', '0', '1')";
				$result = $db->query($query);
				if(!$result)
				{
					echo mysqli_error($db);
				}
				else
				{
					$core->redirect_to("/?p=manage&op=modules");
				}
				
			}
			// Add Modules
			echo '<h3>Add a Module</h3>';
			echo '<form action="/?p=manage&op=modules" method="post">';
			echo '<select name="available">';
			$dir = "modules";
			$handle = opendir($dir);
			while($name = readdir($handle)) {
				if(is_dir("$dir/$name")) {
					if($name != '.' && $name != '..' && $name != 'manage' && $name != 'account' && $name != 'error' && $name != 'example_module' && $name != 'blogs') {
						echo '<option value="'.$name.'">'.$name.'</option>';
					}
				}

			}
			closedir($handle);
			echo '</select>';
			echo '&nbsp;<em>Choose the Module.</em>';
			echo '</p>';
			echo '<p><em><strong>NOTE:</strong> It must be up loaded to modules.</em></p>';
			echo '<p><em>Please ensure you upload your admin image to the root img/manage folder, it must be in png format and named the same as your module.</em></p>';
			echo '<input type="submit" name="submit" value="Add Module">';
			echo '</form>';
		}
		
		function drop_module()
		{
			$id = $_GET['id'];
			$db = new database\db;
			$core = new site\core;
			$query = "DELETE FROM modules WHERE id = '$id'";
			$result = $db->query($query);
			$core->redirect_to("/?p=manage&op=modules");
		}
		
		function stop_module()
		{
			$id = $_GET['id'];
			$db = new database\db;
			$core = new site\core;
			$query = "UPDATE modules SET active = '0' WHERE id = '$id'";
			$result = $db->query($query);
			if(!$result)
			{
				echo mysqli_error($db);
			}
			else
			{
				$core->redirect_to("/?p=manage&op=modules");
			}
		}
		
		function start_module()
		{
			$id = $_GET['id'];
			$db = new database\db;
			$core = new site\core;
			$query = "UPDATE modules SET active = '1' WHERE id = '$id'";
			$result = $db->query($query);
			if(!$result)
			{
				echo mysqli_error($db);
			}
			else
			{
				$core->redirect_to("/?p=manage&op=modules");
			}
		}
		
		function blogs()
		{
			$db = new database\db;
			$core = new site\core;
			echo '<p><small><a href="/" hreflang="en">Home</a> >> <a href="/manage">Site Management</a> >> Blogs</small></p>';
			echo '<h3>Blogs</h3>';
			echo '<table border="0" cellpadding="3" cellspacing="3" width="100%">';
			echo '<tr>';
			echo '<td><strong>Title</strong></td>';
			echo '<td>&nbsp;</td>';
			echo '<td><strong>Author</strong></td>';
			echo '<td>&nbsp;</td>';
			echo '<td><strong>View</strong></td>';
			echo '<td>&nbsp;</td>';
			echo '<td><strong>Edit</strong></td>';
			echo '<td>&nbsp;</td>';
			echo '<td><strong>Delete</strong></td>';
			echo '</tr>';
			$query = "SELECT * FROM blogs ORDER BY blog_date ASC";
			$result = $db->query($query);
			while($row = $db->fetch_assoc($result))
			{	$id = $row['id'];
				$slug = $row['slug'];
				echo '<tr>';
				echo '<td>'.$row['title'].'</td>';
				echo '<td>&nbsp;</td>';
				echo '<td>'.$row['author'].'</td>';
				echo '<td>&nbsp;</td>';
				echo '<td><a href="/blog/'.$slug.'"><img src="/img/manage/view.png" height="30" width="30"></a></td>';
				echo '<td>&nbsp;</td>';
				echo '<td><a href="/?p=manage&op=edit_blog&id='.$id.'" hreflang="en"><img src="/img/manage/edit.jpg" height="30" width="30"></a></td>';
				echo '<td>&nbsp;</td>';
				echo '<td><a href="/?p=manage&op=drop_blog&id='.$id.'" hreflang="en"><img src="/img/manage/delete.png" height="30" width="30"></a></td>';
				echo '</tr>';
			}
			echo '</table>';
			echo '<br>';
			echo '<hr>';
			echo '<br>';
			if(isset($_POST['add']))
			{
				$title = $db->prep_data($_POST['title']);
				$slug = $core->slugify($title);
				$intro = $db->prep_data($_POST['intro']);
				$content = $db->prep_data($_POST['contents']);
				$author = $_SESSION['username'];
				$category = $db->prep_data($_POST['category']);
				$allow_comments = $_POST['allow_comments'];
				$query = "INSERT INTO blogs (title, intro, content, author, blog_date, category, slug, views, loves, allow_comments) VALUES ('$title', '$intro', '$content', '$author', NOW(), '$category', '$slug', '0', '0', '$allow_comments')";
				$result = $db->query($query);
				if(!$result)
				{
					echo mysqli_error($db);
				}
				else
				{
					$ht_query = "SELECT * FROM blogs WHERE title = '$title'";
						$ht = $db->query($ht_query);
						if($ht)
						{
							$row = $db->fetch_assoc($ht);
							$blog_id = $row['id'];
							
							// Write to htaccess
							$htaccess = fopen("./.htaccess", "a") or die("Unable to open file!");
							$txt = "\nRewriteRule ^blog/$slug /?p=blogs&op=read&id=$blog_id [L]";
							fwrite($htaccess, $txt);
							fclose($htaccess);
							$core->redirect_to("/?p=manage&op=blogs");
						}
						else
						{
							echo mysqli_error($db);
						}
				}
			}
			else
			{
				echo '<form action="/?p=manage&op=blogs" method="POST">';
				echo '<legend><strong>Add a Blog</strong></legend>';
				echo '<table border="0" cellpadding="3" cellspacing="3" width="100%">';
				echo '<tr>';
				echo '<td><label for="title">Title:</label></td>';
				echo '<td>&nbsp</td>';
				echo '<td><input id="title" type="text" name="title" placeholder="Your Blog title">';
				echo '</tr>';
				echo '<tr>';
				echo '<td valign="top"><label for="intro">Inroduction:</label></td>';
				echo '<td>&nbsp</td>';
				echo '<td><textarea rows="5" cols="30" id="intro" name="intro">The Introduction to your Blog</textarea>';
				echo '</tr>';
				echo '<tr>';
				echo '<td valign="top"><label for="contents">Your Blog:</label></td>';
				echo '<td>&nbsp</td>';
				echo '<td><textarea rows="10" cols="30" id="contents" name="contents">The Contents of your Blog go here minus your introduction.</textarea></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td><label for="category">Category:</label></td>';
				echo '<td>&nbsp</td>';
				echo '<td><input id="category" type="text" name="category" placeholder="Your Blog\'s Category"></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td><label for="allow_comments">Allow Comments:</label></td>';
				echo '<td>&nbsp</td>';
				echo '<td><select name="allow_comments" id="allow_comments"><option values="1">Yes</option><option value="0">No</option></select></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>&nbsp;</td>';
				echo '<td>&nbsp</td>';
				echo '<td><br><input type="submit" id="add" name="add" value="Add Blog">';
				echo '</tr>';
				echo '</table>';
				echo '</form>';
			}
		}
		
		function edit_blog()
		{
			echo '<p><small><a href="/" hreflang="en">Home</a> >> <a href="/manage">Site Management</a> >> <a href="/?p=manage&op=blogs">Blogs</a> >> Edit a Blog</small></p>';
			$id = $_GET['id'];
			$user = $_SESSION['username'];
			$db = new database\db;
			$core = new site\core;
			
			if(isset($_POST['update']))
			{
				$title = $db->prep_data($_POST['title']);
				$intro = $db->prep_data($_POST['intro']);
				$content = $db->prep_data($_POST['content']);
				$category = $db->prep_data($_POST['category']);
				$allow_comments = $_POST['allow_comments'];
				
				$query = "UPDATE blogs SET title = '$title', intro = '$intro', content = '$content', category = '$category', allow_comments = '$allow_comments' WHERE id = '$id'";
				$result = $db->query($query);
				if($result)
				{
					$core->redirect_to("/?p=manage&op=blogs");
				}
				else
				{
					echo mysqli_error($db);
				}
			}
			else
			{
				$query = "SELECT * FROM blogs WHERE id = '$id'";
				$result = $db->query($query);
				$row = $db->fetch_assoc($result);
				echo '<form action="/?p=manage&op=edit_blog&id='.$id.'" method="POST">';
				echo '<h4>Hello '.$user.', your are editing, '.$row['title'].'</h4>';
				echo '<table border="0" cellpadding="3" cellspacing="3" width="100%">';
				echo '<tr>';
				echo '<td><label for="title">Title:</label></td>';
				echo '<td>&nbsp;</td>';
				echo '<td><input id="title" type="text" name="title" value="'.$row['title'].'"></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td valign="top"><label for="intro">Introduction:</label></td>';
				echo '<td>&nbsp;</td>';
				echo '<td><textarea rows="10" cols="30" id="intro" name="intro">'.$row['intro'].'</textarea></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td valign="top"><label for="content">The Content:</label></td>';
				echo '<td>&nbsp;</td>';
				echo '<td><textarea rows="10" cols="30" id="content" name="content">'.$row['content'].'</textarea></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td><label for="category">Category:</label></td>';
				echo '<td>&nbsp;</td>';
				echo '<td><input id="category" type="text" name="category" value="'.$row['category'].'"></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td><label for="allow_comments">Allow Comments:</label></td>';
				echo '<td>&nbsp;</td>';
				echo '<td><select name="allow_comments" id="allow_comments"><option value="1">Yes</option><option values="0">No</option></select></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>&nbsp;</td>';
				echo '<td><br><input type="submit" name="update" value="Update Blog"></td>';
				echo '<td>&nbsp;</td>';
				echo '</tr>';
				echo '</table>';
				echo '</form>';
			}
		}
		
		function drop_blog()
		{
			$id = $_GET['id'];
			$db = new database\db;
			$core = new site\core;
			$query = "DELETE FROM blogs WHERE id = '$id'";
			$result = $db->query($query);
			if($result)
			{
				$core->redirect_to("/?p=manage&op=blogs");
			}
		}
		
		function version()
		{
			echo '<p><small><a href="/" hreflang="en">Home</a> >> <a href="/manage">Site Management</a> >> Version</small></p>';
			echo '<h3>Version</h3>';
			echo '<p>If there is an updated version of the microCMS, it will be shown here.</p>';
			$core = new site\core;
			$version = $core->check_version();
			if(!empty($version)) echo '<div class="accept">'.$version.'</div>';
		}
		
		/*
		 * Dynamic Switch
		 * Core methods are built in
		 * Relies on module status and type
		 */
		$db = new database\db;
		 $query = "SELECT * FROM modules WHERE module_type = 1 && active = 1";
		 $result = $db->query($query);
		 if($result)
		 {
			 $finished = false;
			 while($row = mysqli_fetch_assoc($result))
			 {
				$module = $row['module_link'];
				if ($d === $module)
				{
					include 'modules/'.$module.'/admin/manage.php';
					$finished = true;
					break;
				}
				if ($d === 'modules') {
					modules();
					$finished = true;
					break;
				}
				if ($d === 'start_module') {
					start_module();
					$finished = true;
					break;
				}
				if ($d === 'stop_module') {
					stop_module();
					$finished = true;
					break;
				}
				if ($d === 'drop_module') {
					drop_module();
					$finished = true;
					break;
				}
				if ($d === 'seo') {
					seo();
					$finished = true;
					break;
				}
				if ($d === 'blogs') {
					blogs();
					$finished = true;
					break;
				}
				if ($d === 'drop_blog') {
					drop_blog();
					$finished = true;
					break;
				}
				if ($d === 'edit_blog') {
					edit_blog();
					$finished = true;
					break;
				}
				if ($d === 'version') {
					version();
					$finished = true;
					break;
				}
			 }
			 if (!$finished)
			 {
				all();
			 }
		 }
		echo '</div>';
	}
}
?>