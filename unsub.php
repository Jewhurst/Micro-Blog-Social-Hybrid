<?php 
require 'header.php';
?>
<?php
if($_GET['userid']  && $_GET['username']){
	if($_GET['userid']!=$user_id){
		$unfollow_userid = $_GET['userid'];
		$unfollow_username = $_GET['username'];
		$fu = $data->unfollowUser($user_id,$unfollow_userid);
		redirect(1,HOME . $unfollow_username);
	}
}

?>