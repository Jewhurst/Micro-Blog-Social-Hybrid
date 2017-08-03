<?php
//Edit the following fields in order to establish a connection with MySQL
//********************************************************************************
$dbhost	= "localhost"; //Leave this as 'localhost' once uploaded on a server
$dbuser	= "USERNAME"; //Username that is allowed to access the database
$dbpass	= "PASSWORD"; //Password
$dbname	= "NAME-OF-THE-DATABASE"; //Name of the database
//********************************************************************************
$database_host = "localhost";
$database_user = "blotterwalldb";
$database_pass = "f{T+#P(4G_a[";
$database_name = "blotterwalldb";
try {
	$db = new PDO("mysql:host={$database_host};dbname={$database_name}",$database_user,$database_pass);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch( PDOexception $e) {
	echo $e->getMessage();
}
$data = new dbconnect($db);
?>