<!DOCTYPE html>
<html>
<head>
<?php do_header() ?>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="mc-content/themes/microcms/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/">microCMS</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item <?php active('/');?>">
        <a class="nav-link" href="/">Home</a>
      </li>
	  <li class="nav-item <?php active('/posts');?>">
        <a class="nav-link" href="/posts">Blogs</a>
      </li>
    </ul>
  </div>
</nav>
