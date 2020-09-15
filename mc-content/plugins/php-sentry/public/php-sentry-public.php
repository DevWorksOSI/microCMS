<?php
/*
Plugin name: PHP Sentry
Text Domain: php-sentry
Author: Scott Cilley <scilley@dwosi.us>
Author URI: https://www.dwosi.us
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Description: This is the Sentry Security Plugin for the microCMS, it also adds to your core functionality.
Requires at least: Since 1.5
Requires PHP: 7.4.8
Version: 1.4.0
*/
// Get the count of banned IP's
$query = "SELECT * FROM mc_bannedip";
$result = mc_query($query);
$banned = mc_fetchRows($result);
?> 
<!-- This file should have html mixed with a little PHP to produce whatever content that you want. -->
<link rel="stylesheet" href="mc-content/plugins/php-sentry/public/css/style.css">
<div class="container">
  <div class="sentry">
    <article>
    <h2>Sentry</h2>
    <p><center><img src="mc-content/plugins/php-sentry/public/images/sentry.png"></center></p>
    <p>Sentry is a Site Security System, that digs deep and finds the bad actors, bans them and sends them somewhere else.</p>
    <p>Harnessing the power of <strong>HTTPBL</strong> and its own security functions, it keeps this domain nice and safe.</p>
    <h3>Status</h3>
    <p>PHP Sentry&trade; has caught <?php echo $banned;?> bad actors so far.</p>
    </article>
  </div>
</div>
