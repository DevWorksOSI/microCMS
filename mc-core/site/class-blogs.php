<?php

namespace site;

// We need the database
use database\db;

class blogs
{
	public function get_Blogs()
	{
		$mcdb = new db();
		$query = "SELECT * FROM mc_posts ORDER BY post_date DESC";
		$result = $mcdb->query($query);
		return $result;
	}
	
	public function last_fiveBlogs()
	{
		$db = new db();
		$query = "SELECT * FROM mc_posts ORDER BY post_date DESC LIMIT 5";
		$result = $db->query($query);
		return $result;
	}
	
	public function popular_blogs()
	{
		$db = new db();
		$query = "SELECT * FROM mc_posts ORDER BY post_likes LIMIT 5";
		$result = $db->query($query);
		return $result;
	}
	
	public function getBlog($id)
	{
		$db = new db();
		$query = "SELECT * FROM mc_posts WHERE id = '$id'";
		$result = $db->query($query);
		return $result;
	}
	
	public function get_blogbySlug($slug)
	{
	   $scdb = new db();
	   $query = "SELECT * FROM mc_posts WHERE post_slug = '$slug'";
	   $data = $scdb->query($query);
	   return $data;
	}
	
	public function get_commentCount($id)
	{
		$db = new db();
		$query = "SELECT count(*) as total from mc_metadata WHERE post_id = '$id'";
		$result = $db->query($query);
		$data = $db->fetch_assoc($result);
		$count = $data['total'];
		return $count;
	}
	
	public function get_blogCount()
	{
	   $db = new db();
	   $query = "SELECT count(*) as total from mc_posts";
	   $result = $db->query($query);
	   $data = $db->fetch_assoc($result);
	   $blog_count = $data['total'];
	   return $blog_count;
	}
	
	public function get_lastBlog()
	{
	  $db = new db();
	  $query = "SELECT post_title, post_exerpt, post_slug, post_date FROM mc_posts ORDER BY id DESC LIMIT 1;";
	  $result = $db->query($query);
	  $data = $db->fetch_assoc($result);
	  return $data;
	}
}
?>
