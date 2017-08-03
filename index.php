<?php require 'header.php';?>
<?php  (isLoggedIn() ? require 'dashboard.php' : require 'home-login.php' ); ?>
<br class="clear">
<?php require 'footer.php';?>