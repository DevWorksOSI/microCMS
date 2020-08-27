<?php

namespace site;

// We need the database
use database\db;

class blogs
{
	public function getBlogs()
	{
		$db = new db();
		$query = "SELECT * FROM mc_blogs ORDER BY blog_date DESC";
		$result = $db->query($query);
		return $result;
	}
	
	public function last_five_blogs()
	{
		$db = new db();
		$query = "SELECT * FROM mc_blogs ORDER BY blog_date DESC LIMIT 5";
		$result = $db->query($query);
		return $result;
	}
	
	public function popular_blogs()
	{
		$db = new db();
		$query = "SELECT * FROM mc_blogs ORDER BY blog_loves LIMIT 5";
		$result = $db->query($query);
		return $result;
	}
	
	public function getBlog($id)
	{
		$db = new db();
		$query = "SELECT * FROM mc_blogs WHERE id = '$id'";
		$result = $db->query($query);
		return $result;
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
}
?>
