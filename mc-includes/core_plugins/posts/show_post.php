<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
	header("Location: /");
}
else
{
	  ini_set('display_errors', '1');
      ini_set('display_startup_errors', '1');
      error_reporting(E_ALL);
	  $blogs = new site\blogs;
	  $mcdb = new database\db;
      $post = $blogs->get_blogbySlug($slug);
	  $content = $mcdb->fetch_assoc($post);
      $post_title = $content['post_title'];
      $post_exerpt = $content['post_exerpt'];
      $post_content = $content['post_contents'];
      $post_date = date("l, F j, Y",strtotime($content['post_date']));
      $post_author = $content['post_author'];
      $post_id = $content['id'];
      $allow_comments = $content['allow_comments'];
      
      // Schema Specific Information
      $schema_date = date("Y-m-d",strtotime($content['post_date']));
      $schema_slug = $content['post_slug'];
   ?>
   <!-- This file should include mostly HTML with a little PHP to produce any results -->
   <div class="container">

    <div class="row">
      <div class="col">
        <article>
        <h1><?php echo $post_title;?></h1>
      </div>
      <div class="col-xs">
        <hr>
      </div>
    </div>
  
    <div class="row">
      <div class="col">
        <p><?php echo $post_exerpt;?></p>
        <?php echo $post_content;?>
        <p>Posted by <?php echo $post_author;?> on <?php echo $post_date;?></p>
        <div class="social">
          <div id="facebook" class="facebook"><button class="social_button" data-js="facebook-share"><i class="fa fa-facebook" aria-hidden="true"></i></button></div>
          <div id="twitter" class="twitter"><button class="social_button" data-js="twitter-share"><i class="fa fa-twitter" aria-hidden="true"></i></button></div>
          <div id="likePost"><button class="social_button" onclick="postLike();"><i class="fa fa-heart" aria-hidden="true"></i></button></div>
          <div id="response"></div>
        </div>
        </article>
		<hr>
      </div>
    </div>
  </div>
    <script type="text/javascript">
      function postLike() {
         $.ajax({
			 type: 'post',
            url: "like_post(<?php echo $post_id;?>)", //the page containing php script
            success: function(html) {
               $('#response').html("Thanks for that like ;)");
            }
         });
       }
       var facebookShare = document.querySelector('[data-js="facebook-share"]');
       facebookShare.onclick = function(e) {
  e.preventDefault();
  var facebookWindow = window.open('https://www.facebook.com/sharer/sharer.php?u=' + document.URL, 'facebook-popup', 'height=350,width=600');
  if(facebookWindow.focus) { facebookWindow.focus(); }
    return false;
}

var twitterShare = document.querySelector('[data-js="twitter-share"]');

twitterShare.onclick = function(e) {
  e.preventDefault();
  var twitterWindow = window.open('https://twitter.com/share?url=' + document.URL, 'twitter-popup', 'height=350,width=600');
  if(twitterWindow.focus) { twitterWindow.focus(); }
    return false;
  }
  </script>
  <script type=”application/ld+json”>
{
“@context”: “http://schema.org”,
“@type”: “BlogPosting”,
“mainEntityOfPage”:{
“@type”:”WebPage”,
“@id”:”<?php echo $_SERVER['REQUEST_SCHEME'];?>://<?php echo $_SERVER['SERVER_NAME'];?>/posts/<?php echo $schema_slug;?>”
},
“headline”: “<?php echo $post_title;?>”,
“datePublished”: “<?php echo $schema_date;?>”,
“author”: {
“@type”: “Person”,
“name”: “<?php echo $post_author;?>”
},
“description”: “<?php echo $post_exerpt;?>”,
“articleBody”: “<?php echo $post_content;?>”
}
</script>
<?php 
}
