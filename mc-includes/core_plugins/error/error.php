<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
	header("Location: /");
}
else
{
   //Function operatives
   if (isset($_GET['op']))
   {
      $d = $_GET['op'];
   } 
   else
   {
      $d = NULL;
   }
   echo '<div class="container">';
   echo '<div class="row">';
   echo '<div class="col">';
   echo '<div class="error_response">';
   
   function general_error()
   {
      echo '<h1>Error</h1>';
      echo '<h2>An unknown error has occured</h2>';
   }
 
   function error_404()
   {
      echo '<h1>Error 404</h1>';
      echo '<h2>Not Found</h2>';
      echo '<p>The resource that you are looking for does not exist on this site.</p>';
   }
   
   switch ($d)
   {
      case 'error_404':
      error_404();
      break;
      default:
	general_error();
	break;
   }
   echo '</div>';
   echo '</div>';
   echo '</div>';
   echo '</div>';
}
?>
