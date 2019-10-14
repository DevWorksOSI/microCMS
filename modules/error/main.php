<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
	header("Location: /");
}
else
{
 echo '<div class="main">';
 echo '<p>Oops! It appears something went wrong..</p>';
 echo '<p>Most likely the page has moved, has been removed or just bad code, please check your links and try again.</p>';
 echo '</div>';
}
?>