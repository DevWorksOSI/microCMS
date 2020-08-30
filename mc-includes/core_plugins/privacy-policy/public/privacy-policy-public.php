<?php
/*
Plugin name: Privacy Policy
Text Domain: privacy-policy
Author: Scott Cilley <scilley@dwosi.us>
Author URI: https://www.dwosi.us
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Description: This is the Privacy Policy Plugin for the microCMS, it is templated for all microCMS driven sites to use.
Requires at least: Since 1.5
Requires PHP: 7.4.8
Version: 0.1.0
*/
$settings = new site\settings;
$urlParts = parse_url($settings->base_url);
$domain = preg_replace('/^www\./', '', $urlParts['host']);
?> 
<!-- This file should have html mixed with a little PHP to produce whatever content that you want. -->
<link rel="stylesheet" href="mc-includes/core_plugins/privacy-policy/public/css/style.css">
<div class="container">
  <div id="privacy-policy">
    <div class="content">
      <h1>Privacy Policy</h1>
      <p>This website is operated by <?php echo $settings->site_name;?>. (“We”) are committed to protecting and preserving the privacy of our visitors when visiting our site or communicating electronically with us.</p>
      <p>This policy sets out how we process any personal data we collect from you or that you provide to us through our website. We confirm that we will keep your information secure and that we will comply fully with all applicable Data Protection legislation and regulations. Please read the following carefully to understand what happens to personal data that you choose to provide to us, or that we collect from you when you visit this site. By visiting <?php echo $settings->base_url;?> (our website) you are accepting and consenting to the practices described in this policy.</p>
    </div>
    <div class="content">
      <h3>Types of information we may collect from you</h3>
      <p>We may collect, store and use the following kinds of personal information about individuals who visit and use our website:</p>
      <p>
       <h4>Information you supply to us.</h4> You may supply us with information about you by filling in forms on our website. This includes information you provide when you submit a contact/enquiry form. The information you give us may include your name, address, e-mail address and phone number.
       </p>
       <p>
       <h4>Information our website automatically collects about you.</h4> With regard to each of your visits to our website we may automatically collect information including the following:
       <ul>
         <li> <strong>technical information</strong>, including a truncated and anonymised version of your Internet protocol (IP) address, browser type and version, operating system and platform;</li>
         <li> <strong>information about your visit</strong>, including what pages you visit, how long you are on the site, how you got to the site (including date and time); page response times, length of visit, what you click on, documents downloaded and download errors.</li>
       </ul>
       </p>
       <h4>Cookies</h4>
       <p>Our website uses cookies to distinguish you from other users of our website. This helps us to provide you with a good experience when you browse our website and also allows us to improve our site. 
       </p>
       <h4>How we may use the information we collect</h4>
       <p>
       We use the information in the following ways:
       </p>
       <p>
       <strong>Information you supply to us.</strong> We will use this information:
       <ul>
         <li> to provide you with information and/or services that you request from us;</li>
       </ul>
       <strong>Information we automatically collect about you.</strong> We will use this information:
       <ul>
         <li> to administer our site including troubleshooting and statistical purposes;</li>
         <li> to improve our site to ensure that content is presented in the most effective manner for you and for your computer;</li>
         <li> security and debugging as part of our efforts to keep our site safe and secure.</li>
       </ul>
       </p>
       <p>This information is collected anonymously and is not linked to information that identifies you as an individual.</p>
       <h4>Disclosure of your information</h4>
       <p>We do not rent, sell or share personal information about you with other people or non-affiliated companies.</p>
       <p>We will use all reasonable efforts to ensure that your personal data is not disclosed to regional/national institutions and authorities, unless required by law or other regulations.</p>
       <p>Unfortunately, the transmission of information via the internet is not completely secure. Although we will do our best to protect your personal data, we cannot guarantee the security of your data transmitted to our site; any transmission is at your own risk. Once we have received your information, we will use strict procedures and security features to try to prevent unauthorised access.</p>
       <h4>Third party links</h4>
       <p>Our site may, from time to time, contain links to and from the third party websites. If you follow a link to any of these websites, please note that these websites have their own privacy policies and that we do not accept any responsibility or liability for these policies. Please check these policies before you submit any personal data to these websites.</p>
       <h4>Your rights – access to your personal data</h4>
       <p>You have the right to ensure that your personal data is being processed lawfully. Your subject access right can be exercised in accordance with data protection laws and regulations.</p>
       <h4>Changes to our privacy policy</h4>
       <p>Any changes we may make to our privacy policy in the future will be posted on this page and, where appropriate, notified to you by e-mail. Please check back frequently to see any updates or changes to our privacy policy.</p>
       <h4>Contact</h4>
       <p>Questions, comments and requests regarding this privacy policy are welcomed and should be addressed to privacy@<?php echo $domain;?>.
     </div>
</div>
