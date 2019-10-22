<!DOCTYPE html>
<html>
<head>
	<base href="<?php echo $base_url;?>">
    <title><?php echo $site_name;?></title>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<meta name="no-email-collection" content="http://www.unspam.com/noemailcollection/">
	<meta name="description" content="<?php echo $description;?>">
	<meta name="keywords" content="<?php echo $keywords;?>">
	<?php
	if($google_code != '')
	{
		echo '<meta name="google-site-verification" content="'.$google_code.'" />';
	}
	if($bing_code != '')
	{
		echo '<meta name="msvalidate.01" content="'.$bing_code.'" />';
	}
	?>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">
	<link rel="stylesheet" href="/themes/<?php echo $theme;?>/css/style.css">
	<link rel="icon" href="/themes/<?php echo $theme;?>/img/favicon.ico">
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button class="navbar-toggle" data-target="#myNavbar" data-toggle="collapse" type="button">
                <span class="icon-bar"></span> <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
				<li><a href="/" hreflang="en"><i aria-hidden="true" class="fa fa-home"></i> <strong>Home</strong></a></li>
				<?php
				$auth = $core->logged_in();
				if($auth == TRUE)
				{
					echo '<li><a href="/logout" hreflang="en"><i aria-hidden="true" class="fa fa-lock"></i> <strong>Log Out</strong></a></li>';
				}
				else
				{
					echo '<li><a href="/login" hreflang="en"><i aria-hidden="true" class="fa fa-lock"></i> <strong>Log In</strong></a></li>';
				}
				// Admin
				if(isset($_SESSION['admin']))
				{
					$admin = $_SESSION['admin'];
					if($admin != FALSE)
					{
						echo '<li><a href="/manage" hreflang="en"><i aria-hidden="true" class="fa fa-cog"></i> <strong>Manage</strong></a></li>';
					}
				}
				?>
			</ul>
        </div>
    </div>
</nav>