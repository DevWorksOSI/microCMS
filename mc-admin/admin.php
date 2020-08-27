<?php
/*
admin.php
@package microCMS
@sub_package admin
Description: Administrative functional dashboard for the microCMS
*/
/*
include 'mc-core/loader.php';
//Function operatives
 if (isset($_GET['page']))
 {
	 $d = $_GET['page'];
 } 
elseif (isset($_POST['page']))
{ // Forms
	 $d = $_POST['page'];
}
 else
 {
	 $d = NULL;
 }
 
$query = "SELECT * FROM mc_plugins WHERE plugin_type = 1";
$result = $db->query($query);
$finished = false;
while($row = $db->fetch_assoc($result))
{
    $plugin = $row['plugin_slug'];
	
    if ($d === $plugin)
	{
        include 'mc-content/plugins/'.$plugin.'/admin/'.$plugin.'-admin.php';
        $finished = true;
        break;
    }
	if ($d === 'error')
	{
		include 'mc-includes/core_plugins/error/error.php';
		$finished = true;
		break;
	}
	if ($d === 'login')
	{
		include 'mc-includes/core_plugins/account/login.php';
		$finished = true;
		break;
	}
	if ($d === 'logout')
	{
		include 'mc-includes/core_plugins/account/logout.php';
		$finished = true;
		break;
	}
	if ($d === 'signup')
	{
		include 'mc-includes/core_plugins/account/signup.php';
		$finished = true;
		break;
	}
	if ($d === 'blogs')
	{
		include 'mc-includes/core_plugins/blogs/main.php';
		$finished = true;
		break;
	}
}

if (!$finished)
{
    //include 'mc-content/themes/'.$theme.'/front_page.php';
    echo 'Admin';
}
*/
?>
<!DOCTYPE html>
<html>
<head>
<title>microCMS Administration</title>
<link rel="stylesheet" href="../mc-includes/css/admin.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
  <div class="row">
    <div class="col left">
      Links
    </div>
    <div class="col middle">
      Pages
    </div>
  </div>
</body>
</html>
