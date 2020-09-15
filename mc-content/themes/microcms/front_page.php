<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
	header("Location: /");
}
else
{
?>
<main role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron top_jumbotron">
        <div class="container">
          <h1 class="display-3">Meet the microCMS</h1>
          <p>microCMS is open source software that you can use to create a functional personal or professional website or blog</p>
          <!--<p><a class="btn-dark btn-lg" href="#" role="button">Learn more &raquo;</a></p>-->
        </div>
      </div>

      <div class="container">
        <!-- Example row of columns -->
        <div class="row">
          <div class="col-md-4">
            <h2><i class="fa fa-hourglass-start" aria-hidden="true"></i> Getting Started</h2>
            <p>The microCMS is currently undergoing a complete rebuild, once we have a release candidate, it will be available for download.</p>
			<p>If you are interested in getting involved with the deveopment of this project, please click Getting Involved</p>
            <p><a class="btn btn-dark" href="/get-involved" role="button">Getting Involved &raquo;</a></p>
          </div>
          <div class="col-md-4">
            <h2><i class="fa fa-info" aria-hidden="true"></i> Features</h2>
			<p><strong>Powerful features and the freedom to build in order to extend it</strong></p>
			<ul>
			<li> Themeable</li>
			<li> SEO Friendly</li>
			<li> Pluggable</li>
			<li> Easy to Use</li>
			<li> Small Footprint</li>
			</ul>
            <p><a class="btn btn-dark" href="/about" role="button">View details &raquo;</a></p>
          </div>
          <div class="col-md-4">
            <h2><i class="fa fa-code"></i> Development</h2>
            <p>Version 1.5.1, with Odin as a Code Name, is still under development. We will announce here when a Beta Version is available for testing.</p>
			<p>Yes we have a thing for the Norse Gods and Goddesses, all version will have a Code Name as such</p>
            <p><a class="btn btn-dark" href="/development" role="button">View details &raquo;</a></p>
          </div>
        </div>

        <hr>

      </div> <!-- /container -->
	  
	  <div class="jumbotron middle_jumbotron">
        <div class="container">
          <h1 class="display-3">Get the microCMS</h1>
          <p>When we have a Beta Version available, a button will appear to get it. Feedback is always welcome.</p>
          <!--<p><a class="btn btn-dark btn-lg" href="#" role="button">Learn more &raquo;</a></p>-->
        </div>
      </div>
	  
	  <div class="container">
        <!-- Example row of columns -->
        <div class="row">
          <div class="col-md-4">
            <h2>Latest News</h2>
			<?php
			$lastPost = mc_getLastPost();
			$data = mc_fetchAssoc($lastPost);
			$post_title = $data['post_title'];
			$post_intro = $data['post_exerpt'];
			$post_slug = $data['post_slug'];
			?>
            <p><strong><?php echo $post_title;?></strong><br><?php echo $post_intro;?></p>
            <p><a class="btn btn-dark" href="/posts/<?php echo $post_slug;?>" role="button">Read &raquo;</a></p>
          </div>
          <div class="col-md-4">
            <h2>Events</h2>
			<p>Coming Soon!</p>
            <!--<p><a class="btn btn-dark" href="#" role="button">View details &raquo;</a></p>-->
          </div>
        </div>
	  </div>

        <hr>

    </main>	
<?php
}
?>
