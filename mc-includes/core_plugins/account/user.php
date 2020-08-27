<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
	header("Location: /");
}
else
{
   if($logged_in == FALSE)
   {
      $core->redirect_to('/login');
   }
   else
   {
      echo '<div class="main">';
      echo '<h2>Your Account</h2>';
      echo '</div>';
   }
}
