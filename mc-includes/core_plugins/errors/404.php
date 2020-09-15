<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
   header("Location: /");
}
else
{
?>
<div class="container">
  <div class="row">
    <div class="col">
      <center>
      <p><img src="/mc-includes/core_plugins/errors/images/404.png"></p>
      </center>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <center>
      <h3>The resource that you are looking for could not be found on this site</h3>
      </center>
    </div>
  </div>
</div>
<?php
}
