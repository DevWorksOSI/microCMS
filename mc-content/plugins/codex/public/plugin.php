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

<p><a href="/dev/codex">Codex</a> > <a href="/dev/core">Core</a> > <strong>Plugins</strong> > <a href="/dev/themes">Themes</a> > <a href="/dev/roadmap">Road Map</a></p>
<h3>microCMS Codex -> Plugins</h3>
<p>Plugins for the microCMS are quite simply modules that extend the microCMS in many ways. This page in itself is a plugin. We have yet to decide if we are going to require plugins to be class driven and have languages, etc. </p>
<p>Supose you are creating a new plugin, below is a template of what is required in the main file (<code>your-plugin/your-plugin.php</code>)</p>
<?php
$plugin = '
<?php
/*
Plugin name: Plugin Name
Text Domain: plugin-name
Author: Plugin Author <Author Email>
Author URI: https://yourdomain.org
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Description: Plugin Description
Requires at least: Since what version of the microCMS was this class created, EX: 1.4
Requires PHP: 7.4.8 (or latest version of PHP)
Version: This plugins version, EX: 0.1
*/
	   
function public_page()
{
   // Load you Public pages
}
	   
function admin_page()
{
   // Load your Admin Pages
}
	   
// etc...
';
?>
<p><code>Code:</code><pre><code><?php echo htmlspecialchars($plugin);?></code></pre></p>
<p><strong>Notice:</strong> Your plugin-name must be the same name as the folder that it resides in using <code>plugin-name</code> as an example, so your folder will be called <code>plugin-name</code> and the main plugin file will be called <code>plugin-name.php</code> respectively. You may store your plugins admin pages in an <code>admin</code> folder and your public pages in a <code>public</code> folder, then link them in your main plugin file using:<br>
<?php
$include_file = "
function public_page()
{
   include 'mc-content/plugins/your-plugin/public/template-name.php';
}
	   
function sdmin_page()
{
   include 'mc-content/plugins/your-plugin/admin/template-name.php';
}
";
?>
<code>Code:</code><pre><code><?php echo htmlspecialchars($include_file);?></code></pre>
</p>
<p>This example, is the preffered way of building plugins for the microCMS.</p>
<p>An example of this Plugin, working on a micoCMS driven site, click <a href="/dev/example"><strong>Here</strong></a></p>
<p>If you are going to be using mysql data for your plugin, you first must check if the table exist, if it doesnt, create it. Creating tables with PHP is not within the scope of this codex. Google is your friend.</p>
<p>If you are planning on coding html into your plugin, please follow Boostrap standards.</p>
<p>As of now, we do not have any special css or script load functions for you to use, these are in the planning phase.</p>
