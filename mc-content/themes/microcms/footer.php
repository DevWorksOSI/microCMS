<div class="jumbotron bottom_jumbotron">
  <div class="container-fluid">
      <p>&copy; <?php echo date("Y");?> <?php echo $site_name;?></p>
	  <p>
	  <?php
	  if($facebook != '' and $facebook != 'NULL')
	  {
		  echo '<a href="https://www.facebook.com/'.$facebook.'" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>&nbsp;';
	  }
	   if($twitter != '' and $twitter != 'NULL')
	  {
		  echo '<a href="https://www.twitter.com/'.$twitter.'" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>&nbsp;';
	  }
	  if($instagram != '' and $instagram != 'NULL')
	  {
		  echo '<a href="https://www.instgram.com/'.$instagram.'" target="_blank"><i class="fa fa-instgram" aria-hidden="true"></i></a>&nbsp;';
	  }
	  if($youtube != '' and $youtube != 'NULL')
	  {
		  echo '<a href="https://www.youtube.com/channel/'.$youtube.'" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a>&nbsp;';
	  }
	  ?>
	  </p>
  </div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="mc-content/themes/microcms/js/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="mc-content/themes/microcms/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a4b113fce5.js" crossorigin="anonymous"></script>
</body>
</html>