<?php
session_unset();
session_destroy();
$core->redirect_to("/");
?>