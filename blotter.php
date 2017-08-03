<?php 
require 'header.php';
?>
<?php
if($user_id){
	if($_POST['blotter_submit'] && ($_POST['blotter']!="")){
		$blotter = htmlspecialchars($_POST['blotter']);
		$blotter = makeLinks($blotter);
		//$blotter = str_replace('@','',$blotter);
		
		$timestamp = time();
		$userinfo = $data->getUserInfo($user_id);
		$username = $userinfo['username'];
		if($data->postBlotter($user_id,$blotter,$timestamp,$username)){
			$last_id = $data->lastID();
			
			preg_match_all("/(#\w+)/", $blotter, $matches);
			foreach ($matches[1] as $key => $value) {
				$value = str_replace('#','',$value);
				if($data->checkHashtagExist($value)){
						$data->addHashtagCount($value, $last_id);
					}else{
						$data->addHashtag($value);
						$data->addHashtagCount($value, $last_id);
					}
			}
			
			preg_match_all("/(@\w+)/", $blotter, $matches);
			foreach ($matches[1] as $key => $value) {
				$value = str_replace('@','',$value);
				//$source_id = $data->userGetUserInfo($value);
				if($source_id = $data->userGetUserInfo($value)){$alert = $data->alert_info($source_id['id'],'1',$user_id,'0','mention','0');};
				
			}
			if($data->updateUserBlotterCount($user_id)){redirect(1,"/");}
		}
	} elseif($_POST['Repost'] && $_POST['source_id'] && $_POST['blotter_id']){
		
		
			$source_id = $_POST['source_id'];
			$source_blotter_id = $_POST['blotter_id'];
			$bi = $data->getBlotterDetails($source_blotter_id);
			$blotter = htmlspecialchars($bi['blotter']);
			$is_repost = 1;
			//$blotter = str_replace('@','',$blotter);
			$repost_time = $bi['timestamp'];
			$timestamp = time();
			//diag($user_id.'=='.$blotter.'=='.$timestamp.'=='.$source_id.'=='.$source_blotter_id.'=='.$is_repost.'=='.$repost_time);
			if($data->repostBlotter($user_id,$blotter,$timestamp,$source_id,$source_blotter_id,$is_repost,$repost_time)){
				$last_id = $data->lastID();
				preg_match_all("/(@\w+)/", $blotter, $matches);
				foreach ($matches[1] as $key => $value) {
					$value = str_replace('@','',$value);
					if($user_in_repost_id = $data->userGetUserInfo($value)){$alert = $data->alert_info($user_in_repost_id['id'],'1',$user_id, $source_blotter_id,'repost_mention','0');};
					
				}
				$data->updateUserRepostCount($user_id);
				$data->updateBlotterRepostCount($source_blotter_id);
				$data->updateBlottersReposted($user_id,$source_blotter_id,$last_id);
				redirect(1,"/");
			}
		
		
		//redirect(1,"/?static=no-blotter");
		
	}elseif($_POST['Unrepost'] && $_POST['source_id'] && $_POST['blotter_id']){
		
		
			$source_id = $_POST['source_id'];
			$source_blotter_id = $_POST['blotter_id'];	
			if($data->unrepostBlotter($source_id,$source_blotter_id)){
				$last_id = $data->lastID();
				
				$data->updateUserRepostCount($user_id);
				$data->updateBlotterUnrepostCount($source_blotter_id);
				$data->updateBlottersUnreposted($user_id,$source_blotter_id,$last_id);
				redirect(1,"/");
			}
		
		
		//redirect(1,"/?static=no-blotter");
	}
}
?>
