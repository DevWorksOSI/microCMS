<!-- End Content -->

<hr noshade>
<div id="footer">
  <div class="copyright">
    <p>&copy; <?php echo date("Y");?> <?php echo SITENAME;?>, All Rights Reserved!</p>
  </div>
  <div class="links">
  <?php
  // Social Media
  if(FACEBOOK != "")
  {
	  echo '<a href="https://www.facebook.com/'.FACEBOOK.'" target="_blank"><img src="img/social_media/facebook.png" alt="'.SITENAME.' on Facebook"/></a>&nbsp;';
  }
  if(TWITTER != "")
  {
	  echo '<a href="https://www.twitter.com/'.TWITTER.'" target="_blank"><img src="img/social_media/twitter.png" alt="'.SITENAME.' on Twitter"/></a>&nbsp;';
  }
  
  // Sentry Image
  if(file_exists("app/sentry/security.php"))
  {
      echo '<img src="/img/security/sentry.png" height="30" width="80" alt="This site is protected by Sentry" />&nbsp;';
  }
  if($core->is_ssl() == true)
  {
	  echo '<img src="/themes/'.THEME.'/img/ssl.png" height="30" width="80" alt="This site is Secure!" />&nbsp;';
  }
  
  // Sindication
  if(RSS == 1)
  {
	  echo '<a href="/rss" /><img src="img1/rss.png" alt="'.SITENAME.' News Feed"/></a>&nbsp;';
  }
  ?>
   </div>
<?php

 $query = "SELECT * FROM site_views";
$result = $db->query($query);
$row = $db->fetch_assoc($result);
$count = $row['site_count'];
echo '<center><small>This site has been viewed '.$count.' times</small></center>';

?>
</div>
</div>
</main>
  
</body>
</html>