<?php
require 'header.php';
unset($_SESSION['username']);
unset($_SESSION['uid']);
unset($_SESSION['loggedin']);

session_destroy();
redirect(1,"index.php");
?>