<?php

$settings = new site\settings;
$site_url = $settings->site_url;
$site_name = $settings->site_name;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta content="Default page" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="img/assets/favicon.ico">
</head>

<body>
<nav class="header header-inverse">
  <div class="container-fluid">
    <div class="header">
      <a href="https://www.microcms.org/" rel="nofollow"><img src="img/assets/microcms.png" height="40" width="40" alt=""></a>
      <a href="<?php echo $site_url;?>" rel="nofollow"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $site_name; ?></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
        <a href="#">User</a>  
    </div>
  </div>
 </div>
</nav>
