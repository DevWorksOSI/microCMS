<?php
/*
Plugin name: Codex
Text Domain: codex
Author: Scott Cilley <scilley@dwosi.us>
Author URI: https://www.dwosi.us
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Description: This is the example module for microCMS
Requires at least: Since 1.5
Requires PHP: 7.4.8
Version: 0.1.0
*/
?>

<p><a href="/dev/codex">Codex</a> > <a href="/dev/core">Core</a> > <a href="/dev/plugins">Plugins</a> > <strong>Themes</strong> > <a href="/dev/roadmap">Road Map</a></p>
<h3>microCMS Codex -> Themes</h3>
<p>Themes are what make a CMS driven site look good and we have plans to make the installation of them quite easy.</p>
<p><strong>Whats required in a theme:</strong>
<br>
<ul>
  <li> <code>css/style.css</code></li>
  <li> <code>images/</code></li>
  <li> <code>js/</code> if needed</li>
  <li> <code>header.php</code></li>
  <li> <code>footer.php</code></li>
  <li> <code>front_page.php</code></li>
  <li> <code>index.php</code> - blank file</li>
</ul>
</p>
<p>The sites primary control looks for <code>front_page.php</code> in the theme directory.</p>
<?php
$theme = '
/*
 Theme Name: Theme Name
 Text Domain: theme-name
 Author: You or Your Company
 Author URI: https://example.com/
 Theme URI: https://example.com/themes/theme-name/
 License: GNU General Public License v2 or later
 License URI: http://www.gnu.org/licenses/gpl-2.0.html
 Requires at least: 1.5
 Requires PHP: 7.4.8
 Version: 1.0
 Description: Your themes description.
*/
';
?>
<p>Your theme must have the following information in <code>css/style.css</code></p>
<p>
<code>Code:</code><pre><code><?php echo htmlspecialchars($theme);?></code></pre>
</p>
<p>Current theme standards include using <strong>Bootstrap</strong>.
