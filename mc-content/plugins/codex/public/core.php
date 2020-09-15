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

<p><a href="/dev/codex">Codex</a> > <strong>Core</strong> > <a href="/dev/plugins">Plugins</a> > <a href="/dev/themes">Themes</a> > <a href="/dev/roadmap">Road Map</a></p>
<h3>microCMS Codex -> Core</h3>
<p>The microCMS Core is a set of core classes that run the entire site. As of now we have the sites Core Functionality, Settings, Blogs and Data</p>
<p>The Core can be extended by creating new classes in the <code>mc-core</code> directory then linking them to index. With that we must stress that all Core Functionality must be in a class file.
<p><strong>Core Class Example</strong><br>
<?php
$core = '
<?php
/*
Class name: Class Name
Text Domain: classname
Author: Class Author <Author Email>
Author URI: https://yourdomain.org
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Description: Class Description
Requires at least: Since what version of the microCMS was this class created, EX: 1.4
Requires PHP: 7.4.8 (or latest version of PHP)
Version: This classes version, EX: 0.1
*/
	   
namespace site;
class classname
{
   function __construct()
   {
      // Load 
      $this->someThing = something;
   }
	      
   function doSomthing()
   {
      // Do something
      $something = $this->something;
   }
}
?>';
?>
</p>
<p><code>Code:</code><pre><code><?php echo htmlspecialchars($core);?></code></pre></p>
<p>Each Class function can then be included by:
<?php
$include_class = '
use site\classname;
$variable = new classname();
$the_variable = $variable->function;
';
?>
</p>
<p><code>Code:</code><pre><code><?php echo htmlspecialchars($include_class);?></code></pre></p>
<p><strong>Notice:</strong> We strongly discourage using <code>global</code> in any of the core code.</p>
<p>We are brain storming an idea to link all class functions and or variables together in one file.</p>
<p>90% of the microCMS Core functionality is located in <code>mc-core/site</code> and that is where we prefer any site specific core functionality resides, if you are creating something for another reason, but it is <code>core</code> related, please store it in <code>mc-core/your class folder</code>, the <code>autoload</code> will load it automatically when the site is refreshed.</p>
<p>Dirty code will <strong>Never be accepted</strong></p>
