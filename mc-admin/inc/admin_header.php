<?php
$db = new database\db;
// We need some information from the mc_users table
$uid = $_SESSION['user_id'];
$query = "SELECT display_name FROM mc_users WHERE id = $uid";
$result = $db->query($query);
$user = $db->fetch_assoc($result);
$display_name = $user['display_name'];
?>
<div class="row">

  <div class="admin_top_left">
    <img src="/mc-includes/images/microcms.png" height="20" width="20"> <i class="fa fa-home" aria-hidden="true"></i>  <a href="<?php echo $base_url;?>"><?php echo $site_name;?></a>
  </div>
    
  <div class="admin_top_right">
  <?php
  if(!empty($error_message))
  {
     echo '<div class="error_response">'.$error_message.'</div>';
  }
  if(!empty($success_message))
  {
     echo '<div class="success_response">'.$success_message.'</div>';
  }
  ?>
    <small>Howdy, <?php echo $display_name;?></small>
  </div>  
  </div>
</div>
