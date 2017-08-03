<?php 
require 'header.php';
?>
<?php
if($_GET['userid']  && $_GET['username']){
	if($_GET['userid']!=$user_id){
		$follow_userid = $_GET['userid'];
		$follow_username = $_GET['username'];
		if($fu = $data->followUser($user_id,$follow_userid)){$data->alert_info($follow_userid,1,$user_id,0,'follow');}
		redirect(1,HOME . $follow_username);
	}
}
?>