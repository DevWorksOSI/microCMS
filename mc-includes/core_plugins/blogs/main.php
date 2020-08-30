<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
	header("Location: /");
}
else
{
	echo '<div class="container">';
	echo '<div class="row">';
	
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
		echo '<div class="main">';
		$blogs = new site\blogs;
		$db = new database\db;
		$core = new site\core;
		$all_blogs = $blogs->getBlogs();
		if($all_blogs)
		{
		   while($rows = $db->fetch_assoc($all_blogs))
		   {
			$id = $rows['id'];
			//$comment = $blogs->get_commentCount($id);
			//$comments = $db->rows($comment);
			$result=$db->query("SELECT count(*) as total FROM mc_metadata WHERE post_id = '$id'");
			$data=$db->fetch_assoc($result);
			$comments = $data['total'];
			$blog_date = date("l, F d, Y",strtotime($rows['blog_date']));
			$blog_time = date("g:i A",strtotime($rows['blog_date']));
			$timestamp = date("Y-m-d H:i:s", strtotime($rows['blog_date']));
			$link_date = date("m/d/Y", strtotime($rows['blog_date']));
			$slug = $rows['blog_slug'];
			$views = $rows['blog_views'];
			if($views == 1)
			{
			   $tense = 'View';
			}
			else
			{
			   $tense = 'Views';
			}
			if($comments == 1)
			{
			  $comment_tense = 'Comment';
			}
			else
			{
			   $comment_tense = 'Comments';
			}
			$loves = $rows['blog_loves'];
			$uts = strtotime($timestamp);
			$ago = $core->ago($uts);
			echo '<div class="main">';
			echo '<div class="date">'.$blog_date.'</div>';
			echo '<h2>'.$rows['blog_title'].'</h2>';
			echo '<p class="quote">'.$rows['blog_exerpt'].'</p>';
			echo '<p><a href="/posts/'.$link_date.'/'.$slug.'" class="btn btn-info" role="button">Read More</a></p>';
			echo '<p class="posted">Posted by '.$rows['blog_author'].' '.$ago.' at '.$blog_time.', '.$views.' '.$tense.', '.$loves.' <i class="fa fa-heart" style="color:red"></i> and '.$comments.' '.$comment_tense.'</p>';
			echo '<hr>';
			echo '</div>';
		   }
		}
		else
		{
		  echo '<p>No Blogs have been posted yet.</p>';
		}
		echo '</div>';
	}
	
	function read_blog()
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
		$link_date = date("m/d/Y", strtotime($row['blog_date']));
		$views = $row['blog_views'];
		$hearts = $row['blog_loves'];
		$slug = $row['blog_slug'];
		if($hearts == 1)
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
		echo '<div class="main">';
		echo '<div class="date">'.$blog_date.'</div>';
		echo '<h2>'.$row['blog_title'].'</h2>';
		echo '<p class="quote">'.$row['blog_exerpt'].'</p>';
		echo ''.$row['blog_contents'].'';
		echo '<p class="posted">Posted by '.$row['blog_author'].' '.$ago.' at '.$blog_time.', and has been viewed '.$views.' times.</p>';
		echo '<p><a href="/?page=blogs&op=like_blog&amp;id='.$id.'"><i class="fa fa-heart" style="color:red"></i></a> '.$hearts.' '.$tense.'</p>';
		echo '<hr>';
		echo '</div>';
		
		// Update the View Count
		$query = "UPDATE mc_blogs SET blog_views=blog_views+1 WHERE id = '$id'";
		$result = $db->query($query);
		
		if($allow_comments != 0)
		{
		   if(isset($_SESSION['username']))
		   {
		      echo '<h5>Hello '.$_SESSION['username'].', care to comment?</h5>';
		      echo '<br>';
		      echo '<form action = "/?page=blogs&op="do_comment" METHOD = "POST">';
		      echo '<legend><strong>Your Comment</strong></legend>';
		      echo '<textarea rows="4" col="50" name="comment"></textarea>';
		      echo '<br>';
		      echo '<input type="submit" name="do_comment" value="Submit Comment">';
		      echo '</form>';
		   }
		}

		// Comments
		$query = "SELECT * FROM mc_metadata WHERE post_id='$id'";
		$result = $db->query($query);
		if($db->rows($result))
		{
		   while($rows = $db->fetch_array($result))
		   {
		      $user = $rows['who'];
		      
		      // Get the users user name
		      $query = "SELECT * FROM mc_users WHERE id='$user'";
		      $result = $db->query($query);
		      $theUser = $db->fetch_assoc($result); 
		      $who = $theUser['user_nickname'];
		      
		      // Metadata
		      $comment = $rows['content'];
		      $comment_date = date("l, F d, Y",strtotime($rows['post_date']));
		      $comment_time = date("g:i A",strtotime($rows['post_date']));
					
		      echo '<h4>'.$who.'</h4>';
		      echo '<p>Commented on '.$comment_date.' at '.$comment_time.'</p>';
		      echo '<p>'.$comment.'</p>';
		      echo '<hr>';
		   }
		}
		else
		{
		   echo '<h4>This blog has no comments</h4>';
		}
	}
	
	function like_blog()
	{
		$id = $_GET['id'];
		$blogs = new site\blogs;
		$mcdb = new database\db;
		$core = new site\core;
		$query = "UPDATE mc_blogs SET blog_loves=blog_loves+1 WHERE id = '$id'";
	   	$result = $mcdb->query($query);
		if($result)
		{
		   $core->redirect_to("/blogs");
		}
		else
		{
		   echo 'Oops. Something went wrong';
		}
	}
	
	function do_comment()
	{
	  $id = $_GET['id'];
	  $mcdb = new database\db;
	  $core = new site\core;
	  if(isset($_SESSION['username']))
	  {	
	     if(isset($_POST['do_comment']))
	     {
	         // Lets get some basic data from this blog
	         $theBlog = "SELECT * FROM mc_blogs WHERE id='$id'";
	         $rst = $mcdb->query($theBlog);
	         $row = $mcdb->fetach_assoc($rst);
	         $link_date = date("m/d/Y", strtotime($row['blog_date']));
	         $slug = $row['blog_slug'];
	         
	         // Now prep form data
	        $user = $mcdb->prep_data($_SESSION['user_id']);
	        $comment = $mcdb->prep_data($_POST['comment']);
	        $query = "INSERT INTO mc_metadata (type, post_id, who, content, post_date) VALUES (1, '$id', '$user', '$comment', NOW())";
	        $result = $mcdb->query($query);
	        if($result)
	        {
	           $core->redirect_to("/posts/'.$link_date.'/$slug");
	        }
	     }
	  }
	}
	
	
	/*
	 * Switch
	 * Allows function to be used
	 * $d is derived from the Function operatives
	 */
	switch($d) {
		// read
		case 'read':
				read_blog();
				break;
		// like blog
		case 'like_blog':
				like_blog();
				break;
				
		// do comment
		case 'do_comment':
				do_comment();
				break;
		// Main
		default:
			   all();
			   break;
	}
	
	
	echo '</div>';
	echo '</div>';
}
?>
