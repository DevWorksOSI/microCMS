<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
	header("Location: /");
}
else
{
	echo '<div class="container">';
	
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
		echo '<p><small><a href="/" hreflang="en">Home</a> >> Blogs</small></p>';
		echo '<h3>Blogs</h3>';
		$blogs = new site\blogs;
		$db = new database\db;
		$core = new site\core;
		$all_blogs = $blogs->getBlogs();
		while($rows = $db->fetch_assoc($all_blogs))
		{
			$id = $rows['id'];
			//$comment = $blogs->get_commentCount($id);
			//$comments = $db->rows($comment);
			$result=$db->query("SELECT count(*) as total FROM blog_comments WHERE blog_id = '$id'");
			$data=$db->fetch_assoc($result);
			$comments = $data['total'];
			$blog_date = date("l, F d, Y",strtotime($rows['blog_date']));
			$blog_time = date("g:i A",strtotime($rows['blog_date']));
			$timestamp = date("Y-m-d H:i:s", strtotime($rows['blog_date']));
			$slug = $rows['slug'];
			$views = $rows['views'];
			if($views <= 1)
			{
				$tense = 'View';
			}
			else
			{
				$tense = 'Viwes';
			}
			$loves = $rows['loves'];
			$uts = strtotime($timestamp);
			$ago = $core->ago($uts);
			echo '<div class="post">';
			echo '<div class="date">'.$blog_date.'</div>';
			echo '<h2>'.$rows['title'].'</h2>';
			echo '<p class="quote">'.$rows['intro'].'</p>';
			echo '<p><a href="/blog/'.$slug.'" class="btn btn-info" role="button">Read More</a></p>';
			echo '<p class="posted">Posted by '.$rows['author'].' '.$ago.' at '.$blog_time.', '.$views.' '.$tense.' and '.$loves.'. <i class="fa fa-heart" style="color:red"></i></p>';
			echo '<hr>';
			echo '</div>';
		}
		
	}
	
	function read()
	{
		$id = (int) $_GET['id'];
		$blogs = new site\blogs;
		$db = new database\db;
		$core = new site\core;
		$this_blog = $blogs->getBlog($id);
		$row = $db->fetch_assoc($this_blog);
		$id = $row['id'];
		$blog_date = date("l, F d, Y",strtotime($row['blog_date']));
		$blog_time = date("g:i A",strtotime($row['blog_date']));
		$timestamp = date("Y-m-d H:i:s", strtotime($row['blog_date']));
		$views = $row['views'];
		$hearts = $row['loves'];
		$slug = $row['slug'];
		if($hearts != 2)
		{
			$tense = 'Like';
		}
		else
		{
			$tense = 'Likes';
		}
		$uts = strtotime($timestamp);
		$ago = $core->ago($uts);
		$allow_comments = $row['allow_comments'];
		echo '<div class="post">';
		echo '<div class="date">'.$blog_date.'</div>';
		echo '<h2>'.$row['title'].'</h2>';
		echo '<p class="quote">'.$row['intro'].'</p>';
		echo ''.$row['content'].'';
		echo '<p class="posted">Posted by '.$row['author'].' '.$ago.' at '.$blog_time.', and has been viewed '.$views.' times.</p>';
		echo '<p><a href="/?p=blogs&op=love&id='.$id.'"><i class="fa fa-heart" style="color:red"></i></a> '.$hearts.' '.$tense.'</p>';
		echo '<hr>';
		echo '</div>';
		
		// Update the View Count
		$query = "UPDATE blogs SET views=views+1 WHERE id = '$id'";
		$result = $db->query($query);
		
		if($allow_comments != 0)
		{
			if(isset($_SESSION['username']))
			{
				if(isset($_POST['do_comment']))
				{
					$user = $db->prep_data($_SESSION['username']);
					$comment = $db->prep_data($_POST['comment']);
					$query = "INSERT INTO blog_comments (blog_id, user, comment, comment_date) VALUES ('$id', '$user', '$comment', NOW())";
					$result = $db->query($query);
					if($result)
					{
						$core->redirect_to("/blog/$slug");
					}
				}
				else
				{
					echo '<h5>Hello '.$_SESSION['username'].', care to comment?</h5>';
					echo '<br>';
					echo '<form action = "/blog/'.$slug.'" METHOD = "POST">';
					echo '<legend><strong>Your Comment</strong></legend>';
					echo '<textarea rows="4" col="50" name="comment"></textarea>';
					echo'<br>';
					echo '<input type="submit" name="do_comment" value="Submit Comment">';
					echo '</form>';
				}
			}
			// Comments
			$query = "SELECT * FROM blog_comments WHERE blog_id = '$id'";
			$result = $db->query($query);
			if(!$db->rows($result))
			{
				echo '<h4>This blog has no comments</h4>';
			}
			else
			{
				while ($rows = $db->fetch_assoc($result))
				{
					$user = $rows['user'];
					$comment = $rows['comment'];
					$comment_date = date("l, F d, Y",strtotime($rows['comment_date']));
					$comment_time = date("g:i A",strtotime($rows['comment_date']));
					
					echo '<h4>'.$user.'</h4>';
					echo '<p>Commented on '.$comment_date.' at '.$comment_time.'</p>';
					echo '<p>'.$comment.'</p>';
					echo '<hr>';
				}
			}
		}
		else
		{
			echo '<h5>Comments have been disabled for this blog.</h5>';
		}
	}
	
	function love()
	{
		$id = $_GET['id'];
		$db = new database\db;
		$core = new site\core;
		$query = "UPDATE blogs SET loves=loves+1 WHERE id = '$id'";
		$result = $db->query($query);
		$core->redirect_to("/blogs");
	}
	
	
	/*
	 * Switch
	 * Allows function to be used
	 * $d is derived from the Function operatives
	 */
	switch($d) {
		// read
		case 'read':
				read();
				break;
		// love
		case 'love':
				love();
				break;
		// Main
		default:
			   all();
			   break;
	}
	
	
	echo '</div>';
}
?>