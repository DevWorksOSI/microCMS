<!DOCTYPE html>
<html lang="en">
<head>
<base href="<?php echo BASEURL; ?>">
<meta name="Robots" content="index,follow">
<meta name="Distributor" content="Global">
<meta name="Rating" content="Business">
<meta name="Revisit-After" content="1 days">
<meta name="DESCRIPTION" content="<?php echo DESCRIPTION;?>">
<meta name="KEYWORDS" content="<?php echo KEYWORDS;?>">
<meta name="no-email-collection" content="http://www.unspam.com/noemailcollection/">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">
<link rel="shortcut icon" href="<?php echo BASEURL; ?>/themes/<?php echo THEME;?>/img/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" href="<?php echo BASEURL;?>/themes/<?php echo THEME;?>/css/style.css">
<title><?php echo SITENAME; ?></title>

<!-- FaceBook Specific Page Settings. -->
<meta property="og:url"           content="<?php echo BASEURL; ?>" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="<?php echo SITENAME; ?>" />
<meta property="og:description"   content="<?php echo DESCRIPTION;?>" />
<meta property="og:image"         content="<?php echo BASEURL;?>/img/<?php echo LOGO;?>" />

<!-- Twitter OpenGraph -->
<meta name="twitter:card" content="summary" />
<meta name="twitter:creator" content="<?php echo TWITTER;?>" />
<meta property="twitter:url" content="<?php echo BASEURL;?>/" />
<meta property="twitter:title" content="<?php echo SITENAME;?>" />
<meta property="twitter:description" content="<?php echo DESCRIPTION;?>" />
<meta property="twitter:image" content="<?php echo BASEURL;?>/img/<?php echo LOGO;?>" />

<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=5d9a4806dda9670012df658c&product=inline-share-buttons" async="async"></script>
</head>

<body>
<main>
<div id="wrapper">
  <div id="header" style="background: url(/img/holidays/<?php echo $season->get_image(); ?>) no-repeat center top"></div>
  <p align="center"><small><i><?php echo $season->do_text();?></i></small></p>
  <p align="center">We are currently in Week <?php echo $season->get_week();?> in the year of our Lord, <?php echo date("Y");?></p>
  
  <!-- Navigation -->
    <ul class="nav">
	  <li><a href="/">Home</a></li>
	  <li><a href="/blogs">Blogs</a></li>
	  <li><a href="/donate">Donate</a></li>
	  <li><a href="/microcms">microCMS&trade;</a></li>
	  <li><a href="/sentry">Sentry&trade;</a></li>
	</ul>
<!-- begin Content -->
<div id="content">