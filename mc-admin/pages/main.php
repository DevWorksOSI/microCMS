<!-- First Row -->
<div class="row">
  <div class="col">
    <div class="card-columns d-flex justify-content-center">

    <!-- At a Glance -->
       <div class="card">
         <div class="card-header">
           <strong>At a Glance</strong>
         </div>
         <div class="card-body">
           <p class="card-text"><a href="/mc-admin/posts"><strong><?php echo mc_countPosts()?></strong></a> Post
           <br>
           Site Status (Pending)<br>
           <strong><a href="/mc-admin/users"><?php echo mc_countUsers()?></a> Users</strong>
           <br><small>microCMS <i><?php echo mc_version()?></i> Running the <i><?php echo mc_currentTheme()?></i> theme.</small>
          </p>
         </div>
       </div>
       <!-- End At a Glance -->
       
       <!-- Activity -->
       <div class="card">
         <div class="card-header">
           <strong>Activity</strong>
         </div>
         <div class="card-body">
           <p class="card-text">
           <strong>Recently Published</strong><br>
            <?php
			
           $last_posts = mc_lastPosts();
           while($rows = mc_fetchAssoc($last_posts))
           {
             $post_title = $rows['post_title'];
             $post_date = date("M d, Y g:i A",strtotime($rows['post_date']));
             echo '<small>'.$post_date.'  <a href="/mc-admin/posts">'.$post_title.'</a></small><br>';
           }
           ?>
           </p>
         </div>
       </div>
       <!-- End Activity -->
       
    </div>
  </div>
 </div>
 <!-- End First Row -->
 
 <!-- Second Row -->
 
<div class="row">
  <div class="col">
    <div class="card-columns d-flex justify-content-center">

      <!-- Sentry -->
      <div class="card">
        <div class="card-header">
          <strong>Sentry</strong>
        </div>
        <div class="card-body">
          <p class="card-text">
          <a href="/mc-admin/sentry?page=banned"><strong><?php echo mc_countBadguys()?></strong></a> Bad IP's<hr>
          <small><a href="/mc-admin/sentry">PHP Sentry</a> Version <?php echo mc_getSentryVersion()?></small>
          </p>
        </div>
      </div>
      <!-- Sentry-->
       
      <!-- News -->
      <div class="card">
        <div class="card-header">
          <strong>News from microCMS dot Org</strong>
        </div>
        <div class="card-body">
          <p class="card-text">
          <?php
		  $ch = curl_init();
		  curl_setopt($ch, CURLOPT_URL, "https://www.microcms.org/news.php");
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		  $headers = array();
		  $headers[] = "Accept: application/json";
		  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		  $result = curl_exec($ch);
		  if (curl_errno($ch)) {
			  echo 'Error:' . curl_error($ch);
		  }
		  curl_close ($ch);
		  $data = json_decode($result, true);
		  foreach ($data as $news) {
			  echo '<small><a href="'.$news['url'].'" target="_blank">'.$news['title'].'</a><br/>'.$news['intro'].'</small>';
			  echo '<hr>';
		  }
		  ?>
          </p>
        </div>
      </div>
      <!-- End News -->
    <div>
  </div>
</div>
<!-- End Second Row -->      
