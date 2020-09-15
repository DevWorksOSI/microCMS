<?php
/*
Plugin name: Post Plugin
Text Domain: posts
Author: Scott Cilley <scilley@microcms.org>
Author URI: https://www.microcms.org
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Description: This is the core post plugin for the microCMS
Requires at least: Since 1.5
Requires PHP: 7.4.8
Version: 0.1.0
*/
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
   header("Location: /");
}
else
{
?>
   <!-- This file should include mostly HTML with a little PHP to produce any results -->
   <div class="container">
     <div class="row">
       <h1>Blogs</h1>
     </div>
     <div class="col-xs">
       <hr>
     </div>
     <div class="row">
       <div class="col">
         <?php
         $posts = mc_getblogs();
         while($contents = mc_fetchAssoc($posts))
         {
            $id = $contents['id'];
            $post_title = $contents['post_title'];
            $post_exerpt = $contents['post_exerpt'];
            $post_author = $contents['post_author'];
            $post_date = date("l, F d, Y",strtotime($contents['post_date']));
            $post_likes = $contents['post_likes'];
            $post_slug = $contents['post_slug'];
            
            // Get Comment Count
            $comment_count = mc_countComments($id);
         ?>
             <h2><?php echo $post_title;?></h2>
             <p><?php echo $post_exerpt;?></p>
             <p>Posted By <?php echo $post_author;?> on <?php echo $post_date;?>, with <?php echo $post_likes;?> <i class="fa fa-heart" style="color:red"></i> and <?php echo $comment_count;?> <i class="fa fa-comment" aria-hidden="true"></i>
             </p>
             <p><a href="/posts/<?php echo $post_slug;?>"><button class="btn btn-dark">Read More..</button></a>
         <?php 
         }
         ?>
     </div>
   </div>
 </div>
<hr>
<?php
}
