<?php
echo '<div class="row">';
echo '<div class="col">';
//Function operatives
	 if (isset($_GET['page']))
	 {
		 $p = $_GET['page'];
	 } 
	elseif (isset($_POST['page']))
	{ // Forms
		 $p = $_POST['page'];
	}
	 else
	 {
		 $p = NULL;
	 }
	 function posts()
	 {
	 ?>
	  <h2>Posts</h2>
	  <p>Post Management</p>
	  <p><a href="/mc-admin/posts?page=add"><button type="button" class="btn btn-dark" id="post">Add Post</button></a></p>
	  <div id="response"></div>
	  <script type="text/javascript">
      function drop_post(id) {
         $.ajax({
			 type: 'post',
            url:"/mc-admin/posts?page=drop&id=id", //the page containing php script
            success: function(html) {
               $('#response').html("Success");
            }
        });
       }
	  
	  </script>
	  <table border="0" width="100%" cellpadding="5" cellspacing="5">
	  <tr>
	  <td><strong>Post Title</strong></td>
	  <td><strong>Author</strong></td>
	  <td><strong>Post Date</strong></td>
	  <td></td>
	  </tr>
	  <?php
	  $query = "SELECT * FROM mc_posts ORDER BY id DESC";
	  $result = mc_query($query);
	  while($data = mc_fetchAssoc($result))
	  {
		  $post_id = $data['id'];
		  $post_title = $data['post_title'];
		  $post_author = $data['post_author'];
		  $post_date = date("l, F d, Y",strtotime($data['post_date']));
		  $post_slug = $data['post_slug'];
		  echo '<tr>';
		  echo '<td><a href="/posts/'.$post_slug.'">'.$post_title.'</a></td>';
		  echo '<td>'.$post_author.'</td>';
		  echo '<td>'.$post_date.'</td>';
		  echo '<td><a href="/mc-admin/posts?page=edit&post_id='.$post_id.'"><button type="button" class="btn btn-dark" id="edit">Edit</button></a> <a href="/mc-admin/posts?page=drop&post_id='.$post_id.'"><button type="button" class="btn btn-dark" id="drop">Delete</button></a></td>';
		  echo '</tr>';
	  }
	  ?>
	  </table>
	  <p><strong>To Do:</strong>
	  <br>
	  - Edit
	  </p>
	<?php
	 }
	 
	 function add()
	 {
		 if(isset($_POST['submit']))
		 {
		    $uid = $_SESSION['user_id'];
			$query = "SELECT * FROM mc_users WHERE id = '$uid'";
			$result = mc_query($query);
			$data = mc_fetchAssoc($result);
			$post_author = $data['display_name'];
			print_r($post_author);
			
			$post_title = mc_prepData($_POST['post_title']);
			$post_intro = mc_prepData($_POST['exerpt']);
			$post_content = mc_prepData($_POST['content']);
			$allow = mc_prepData($_POST['allow']);
			$post_slug = mc_slugify($post_title);
			$query = "INSERT INTO mc_posts (post_title, post_exerpt, post_contents, post_author, post_date, allow_comments, post_slug, post_likes) VALUES ('$post_title', '$post_intro', '$post_content', '$post_author', NOW(), '$allow', '$post_slug', 0)";
			$result = mc_query($query);
			if(!$result)
			{
				echo '<h2>Error</h2>';
			}
			else
			{
			   redirect("/mc-admin/posts");
			}
		 }
		 else
		 {
		echo '
		 <div class="col">
	  <form action="/mc-admin/posts?page=add" method="post">
	  <div id="response"></div>
		<h2>Add a New Post</h2>
		  <div class="row">
			<div class="col">
			  <h4>Your Title</h4>
			  <p>The title of your Post</p>
			  <input type="text" id="post_title" name="post_title" placeholder="Post Title">
			</div>
		  </div>
		  <hr>
		  <div class="row">
			<div class="col">
			  <h4>Your Introduction</h4>
			  <p>Your Introduction to your Post</p>
			  <textarea id="exerpt" name="exerpt" rows="5" cols="70">Please limit your Introduction to 150 Characters or less.</textarea>
			</div>
		  </div>
		  <hr>
		  <div class="row">
			<div class="col">
			  <h4>Your Blog Content</h4>
			  <p>The Main Content of your Post</p>
			  <textarea id="content" name="content" rows="20" cols="70">Please tell your story here</textarea>
			</div>
		  </div>
		  <hr>
		  <div class="row">
			<div class="col">
			  <strong>Allow Comments</strong>
			  <p>Allow comments on this Post?</p>
			  <input type="radio" id="allow" name="allow" value="0"> No  <input type="radio" id="allow" name="allow" value="1"> Yes 
			</div>
		  </div>
		  <hr>
		  <div class="row">
			<div class="col">
			  <h4>Post It</h4>
			  <p>Please proof read your work, less work make less haste.</p>
			  <input type="submit" name="submit" id="submit" value="Post It..">
			  <p></p>
			</div>
		  </div>
		  </form>
		  <hr>
		  <div class="row">
			<div class="col">
			  <h4>HTML Reference</h4>
			  <p>
			  <xmp>
			  <p>Your Text</p> - Paragraph
			  <strong>Your text here</strong> - Bold Font
			  <h1>Your Title</h1> - Title Font, <h2> <h3> can be used as well.
			  <tt>Title text</tt> - Title Text
			  <article>Your Article Contents</article> - When used with CSS, it formats your blog or post to look good.
			  <img src=""></img> - Include a remote or local hosted image.
			  <section></section> - The <section> tag defines a section in a document.
			  <main></main> - Specify the main content of the document
			  </xmp>
			  A Complete <strong>HTML</strong> reference is available at <a href="https://www.w3schools.com/tags/default.asp" target="_blank">W3Schools.com</a>
			  </p>
			</div>
		  </div>
		  
		</div>
		';
		 }
	 }
	 
	 function drop()
	 {
		 ini_set('display_errors', '1');
		 ini_set('display_startup_errors', '1');
		 error_reporting(E_ALL);
		 if(isset($_GET['post_id']))
		 {
		    $id = $_GET['post_id'];	
		    $query = "DELETE FROM mc_posts WHERE id = $id";
		    $result = mc_query($query);
			if($result)
		    {
				$query = "DELETE FROM mc_metadata WHERE post_id = $id";
				$result = mc_query($query);
			   redirect("/mc-admin/posts");
			}
			else
			{
				echo '<h2>Error</h2>';
			    echo '<p>Post was not dropped.</p>';
			}
		 }
		 else
		 {
			 echo '<h2>Error</h2>';
			 echo '<p>No Valid Post ID was received.</p>';
		 }
	 }
	 function edit()
	 {
		echo '<h2>Posts</h2>';
	    echo '<p>Post Management</p>';
		echo '<p>Edit</p>';
	 }
	 
	 /*
	 * Switch
	 * Allows function to be used
	 * $d is derived from the Function operatives
	 */
	 switch($p)
	 {
	   case 'add':
		  add();
		  break;
	   case 'drop':
		  drop();
		  break;
	   case 'edit':
		  edit();
		  break;
		  
	   default:
		  posts();
		  break;
	 }
echo '</div>';
echo '</div>';