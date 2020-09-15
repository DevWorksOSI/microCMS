<?php
//Function operatives
 if (isset($_GET['page']))
 {
	 $d = $_GET['page'];
 } 
elseif (isset($_POST['page']))
{ // Forms
	 $d = $_POST['page'];
}
 else
 {
	 $d = NULL;
 }
 function sentry_admin()
 {
?>
  <h2>Sentry</h2>
  <p><small><strong>Sentry</strong> -> <a href="/mc-admin/sentry?page=add">Add an IP</a> -> 
  <a href="/mc-admin/sentry?page=update">Check for Updates</a> -> 
  <a href="/mc-admin/sentry?page=banned">What's Banned</a></small></p>
  <p><i>The microCMS Minuteman, standing tall, ever diligent and always on duty.</i></p>
  <div class="row">
    <div class="col">
	  <h3>Snap Shot</h3>
	</div>
  </div>
  <div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">On This Site</h5>
        <p class="card-text">Show how many are banned and possibly the most popular country</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Version and News</h5>
        <p class="card-text">Once the News API is complete, a channel will be created for PHP Sentry</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
  </div>
</div>
  
  
<?php
 }
 function add()
 {
	 echo '<h2>Sentry</h2>';
	 echo '<p><small><a href="/mc-admin/sentry">Sentry</a> -> <strong>Add an IP</strong> -> <a href="/mc-admin/sentry?page=update">Check for Updates</a> -> <a href="/mc-admin/sentry?page=banned">What\'s Banned</a></small></p>';
     echo '<p>Ban an IP Address..</p>';
	 if(isset($_POST['submit']))
	 {
		 $ip = $_POST['ip'];
		 $numbers = preg_split( "/\./", $ip);
		 include("../mc-includes/lib/ip_files/".$numbers[0].".php");
		 $code=($numbers[0] * 16777216) + ($numbers[1] * 65536) + ($numbers[2] * 256) + ($numbers[3]);
		 foreach($ranges as $key => $value)
		{
			if($key<=$code)
			{
				if($ranges[$key][0]>=$code){$country=$ranges[$key][1];break;}
            }
		}
		 $query = "INSERT INTO mc_bannedip (ip, bann_date, source, country) VALUES ('$ip', NOW(), 'Manual', '$country')";
		 $result = mc_query($query);
		 if($result)
		 {   
		    echo '<h3>Success</h3>';
			echo '<p>Thank you for helping us keep your site and the net safe!</p>';
		 }
		 else
		 {
			 echo '<h3>Error</h3>';
			 echo '<p>Something bad happened..</p>';
		 }
	 }
	 else
	 {
		 echo '<form action="/mc-admin/sentry?page=add" method="post">';
		 echo '<input type="text" name="ip" id="ip" placeholder="IP Address">';
		 echo '<input type="submit" name="submit" id="submit" value="Ban It Now!">';
		 echo '</form>';
	 }
 }
 
 function check_update()
 {
	 echo '<h2>Sentry</h2>';
	 echo '<p><small><a href="/mc-admin/sentry">Sentry</a> -> <a href="/mc-admin/sentry?page=add">Add an IP</a> -> <strong>Check for Updates</strong> -> <a href="/mc-admin/sentry?page=banned">What\'s Banned</a></small></p>';
     echo '<p>Updates</p>';
 }
 
 function banned()
 {
	 echo '<div class="row">';
	 echo '<div class="col">';
	 echo '<h2>Sentry</h2>';
	 echo '<p><small><a href="/mc-admin/sentry">Sentry</a> -> <a href="/mc-admin/sentry?page=add">Add an IP</a> -> <a href="/mc-admin/sentry?page=update">Check for Updates</a> -> <strong>What\'s Banned</strong></small></p>';
	 echo '<p>Below you will find a composit list of all of the IP\'s that your site has banned.</p>';
	 echo '</div>';
	 echo '</div>';
	 echo '<div class="row">';
	 echo '<div class="col">';
     $query = "SELECT * from mc_bannedip";
	 $result = mc_query($query);
	 $banned_count = mc_fetchRows($result);
	 if($banned_count == 0)
	 {
		 echo '<p>No IP\'s have been banned yet!</p>';
	 }
	 else
	 {
		 echo '<p><strong>Banned IP Count:</strong> '.$banned_count.'</p>';
		 echo '<hr>';
		 //$data = mc_fetchArray($result);
		 //foreach(array($data) as $retard)
		 echo '<p><strong>Current Banned Ip Addresses</strong></p>';
		 echo '<div class="sentry-banned">';
		 echo '<ol>';
		 while($data = mc_fetchAssoc($result))
		 {
		    $ip_address = $data['ip'];
			$country = $data['country'];
			$image = ''.$country.'.svg';
			echo '<li> <img src="img/country/'.$image.'" height="30" width="30" alt="A bad actor - '.$country.'"></img> '.$ip_address.'</li>';
			//echo ' - Originating from '.$country.'';
		 }
		 echo '</ol>';
		 echo '</div>';
		 echo '</div>';
	 }
	 echo '</div>';
	 echo '</div>';
 }
/*
 * Switch
 * Allows function to be used
 * $d is derived from the Function operatives
 */
switch($d) {
   case 'add':
      add();
      break;
   case 'update':
      check_update();
      break;
   case 'banned':
      banned();
      break;

   default:
      sentry_admin();
      break;
}
