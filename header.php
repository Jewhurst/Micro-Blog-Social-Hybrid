<?php 
	require 'global.php'; 
	if(!isset($_SESSION)) { session_start();}
	if (!defined('SITE_TITLE')) {define('SITE_TITLE',$data->getSiteOption("site_name"));}
	$username = $_SESSION['username'];
	define("USERID",$_SESSION['user_id']);
	//$user_id = $_SESSION['user_id'];
	$user_id = USERID;
	$pageurl = getPageURL();
	if(isLoggedIn()){
		$user_id = $_SESSION['user_id'];
	} else {	
		//$user_id = $_SESSION['user_id'];	
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<link rel="icon" type="image/png" href="<?php echo HOME; ?>img/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo HOME; ?>images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo HOME; ?>images/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo HOME; ?>images/favicon-16x16.png">
	
    <title><?php echo SITE_TITLE; ?></title>

	<link rel="stylesheet" href="<?php echo HOME; ?>css/animate.css">
	<link rel="stylesheet" href="<?php echo HOME; ?>css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo HOME; ?>css/custom.css">
	<link rel="stylesheet" href="<?php echo HOME; ?>css/phpstyles.php">
	<link rel="stylesheet" href="<?php echo HOME; ?>css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
	<script src="//cdn.ckeditor.com/4.5.10/standard/ckeditor.js"></script>
	<script src=" http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.5.min.js"></script>
	<style>

		/*@media only screen and (min-width : 768px) {html, body{overflow-y:hidden;}}*/
		@media only screen and (max-width : 768px) {html, body{overflow-y:auto;}}
	</style>
</head>
<body>
<div class="container">
		<?php require 'header-nav.php';?>
		
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 " style="">
			<?php require 'left-sidebar.php'; ?>
		</div>
		<div class="col-md-9 col-lg-9 col-sm-12 col-xs-12 rightcol" style="">