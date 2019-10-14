<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
	header("Location: /");
}
else
{
  // Update page counts
  $query = "UPDATE site_views SET site_count=site_count+1";
  $result = $db->query($query);
?>


<section>
<div class="main">
	<h2>Welcome to Your New Site</h2>
	<p>Please uderstand that the microCMS Version 2 is still very much in development and is not ready for production.</p>
</div>
<div class="main">
	<h2>Contribute</h2>
	<p>If you wish to contribute to this project, please get in touch via github and request access</p>
</div>
<div class="main">
	<h2>Sentry</h2>
	<p>This domain is secured by a custom security class called Sentry&trade; which will ban anyone from a known threat country, malicius bots, scrapers, harvesters, etc. Be Warned!</p>
</div>
</section>

<?php
}
?>
