<?php //require 'header.php';
	if($_GET){
		foreach ($_GET as $key => $value) {
			switch ($key) {
				case 'static' :			
							switch ($value) {
								case 'no-blotter' :			
									$message = '<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Hold on there!</strong> You need to enter something to blotter.</div>';
									break;
								case 'error' :			
									$message = '<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Hold on there!</strong> Something went wrong.</div>';
									break;
									
									
									
								default :
									break;
							}
				break;
				case 'delete-alert' :
						$delete_alert = $data->userDeleteAlert($value,$user_id);
						if($delete_alert){redirect(2,'#alerts');}else{redirect(1,'#alerts');}
						
				 break;
				case 'delete-message' :
						$delete_message = $data->userDeleteMessage($value,$user_id);
						if($delete_message){redirect(2,'#messages');}else{redirect(1,'#messages');}
						
				 break;
				case 'alert-read-status' :			
							switch ($value) {
								case 1 :	
									$stmt = $db->prepare('UPDATE alerts SET read_status = 1 WHERE id = :alert_id AND user_id=:user_id') ;
									$stmt->execute(array(':alert_id' => $_GET['alert-id'],':user_id'=>$user_id));
									redirect(2,'#alerts');
									break;
								case 0 :	
									$stmt = $db->prepare('UPDATE alerts SET read_status = 0 WHERE id = :alert_id AND user_id=:user_id') ;
									$stmt->execute(array(':alert_id' => $_GET['alert-id'],':user_id'=>$user_id));
									redirect(2,'#alerts');
									break;
								default :
									break;
							}
				break;
				case 'message-read-status' :			
							switch ($value) {
								case 1 :	
									$stmt = $db->prepare('UPDATE mailbox_users SET read_status = 1 WHERE message_id = :message_id AND user_id=:user_id') ;
									$stmt->execute(array(':message_id' => $_GET['message-id'],':user_id'=>$user_id));
									redirect(1,'#messages');
									break;
								case 0 :	
									$stmt = $db->prepare('UPDATE mailbox_users SET read_status = 0 WHERE message_id = :message_id AND user_id=:user_id') ;
									$stmt->execute(array(':message_id' => $_GET['message-id'],':user_id'=>$user_id));
									redirect(1,'#messages');
									break;
								default :
									break;
							}
				break;
				default :
					break;
			}
		}	
	} ?>
	<div class="container1">
	<?php 
	if($user_id){
		$userinfo = $data->getUserInfo($user_id);
		$userrealname = $userinfo['userrealname'];
		$username = $userinfo['username'];
		$blotters = $userinfo['blotters'];
		$followers = $userinfo['followers'];
		$following = $userinfo['following'];
		echo $message;
		?>	
						<!--************************* blotter ************************** -->
		<div class="animated fadeIn">
		<form action="blotter.php" method="POST" >
			<div class="input-group">
			  <textarea type="text" id="profile" rows="2" style="width:99%;" cols="25" class="form-control border-brown" placeholder="Leave your mark..." name="blotter"></textarea>
			  <span class="input-group-btn">
				<input type="submit" id="workroom_submit" name="blotter_submit" style="height:100%;margin-top:-20px;" class="btn bgclr-orange clr-white kaushan" value="<?php echo stringtable("common","blotter"); ?>"></input>
			  </span>
			</div>
			
		</form>
		</div>
		<br>
		<!--////////////////////////////////////////////NAV TABS///////////////////////////////////////////////////////////// -->
		<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->		
		<ul class="nav nav-tabs nav-justified" role="tablist">
		  <li class="nav-item">
			<a class="nav-link active" data-toggle="tab" href="#home" role="tab"><?php echo ICON_BLOTTERS; ?></a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#messages" role="tab"><?php echo ICON_MESSAGES; ?>&nbsp;<?php echo ($data->getUserMessageCount($user_id) > 0?'<sup class="tag tag-default tag-pill tag-info" style="font-size:0.6em;">'.$data->getUserMessageCount($user_id).'</sup>':''); ?></a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#alerts" role="tab"><?php echo ICON_ALERTS; ?>&nbsp;<?php echo ($data->getUserAlertCount($user_id) > 0?'<sup class="tag tag-default tag-pill bgclr-red" style="font-size:0.6em;">'.$data->getUserAlertCount($user_id).'</sup>':''); ?></sup></a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#followers" role="tab"><?php echo ICON_FOLLOWERS; ?>&nbsp;<?php echo ($data->getUserFollowerCount($user_id) > 0?'<sup class="tag tag-default tag-pill tag-info" style="font-size:0.6em;">'.$data->getUserFollowerCount($user_id).'</sup>':''); ?></a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#following" role="tab"><?php echo ICON_FOLLOWING; ?>&nbsp;<?php echo ($data->getUserFollowingCount($user_id) > 0?'<sup class="tag tag-default tag-pill tag-info" style="font-size:0.6em;">'.$data->getUserFollowingCount($user_id).'</sup>':''); ?></a>
		  </li>
		</ul>
				<!--*************************************************** -->
				<!--*************************************************** -->
				<!--*************************************************** -->
				<!--*************************************************** -->
				<!--*************************************************** -->
		<div class="tab-content animated fadeIn">
		
				<!--************************* HOME ************************** -->
	<div class="tab-pane active" id="home" role="tabpanel">
						<br>
<?php

/*
BLOTTER
id
user_id
blotter
timestamp
source_id
source_blotter_id
is_repost
repost_time
times_reposted           

BLOTTER-REPOST	
id
user_id
blotter_source_id
blotter_id
timestamp

FOLLOWING
id
user1_id
user2_id


*/
	$blotters = $db->query("SELECT * FROM blotters WHERE user_id = $user_id AND is_repost = 0 OR (user_id IN (SELECT user2_id FROM following WHERE user1_id='$user_id')) ORDER BY timestamp DESC ");
	while($blotter = $blotters->fetch()){
		$orig_poster_id = 0;
		if($blotter['is_repost'] == 1){
			$orig_poster_id = $blotter['source_id'];
			$repost = $data->getUserInfo($orig_poster_id);		
			$does_blotter_poster_follow_source_user = $data->does_a_follow_b($blotter['user_id'],$orig_poster_id);
			$do_i_follow_source_of_repost = $data->does_a_follow_b($user_id,$orig_poster_id);

		}
		
		$userinfo = $data->getUserInfo($blotter['user_id']);			
		if($user_id != $orig_poster_id && $blotter['is_repost'] == 1 && $do_i_follow_source_of_repost == 0){					

?>
		<div class="card1">
			<div class="row">						
				<div class="col-xs-12">
					<div class="card-block">
						<h5 class="card-title">
							<img class="img-responsive card-bottom-round1" src="<?php echo HOME . "uploads/".$repost['user_avatar']; ?>" style="width:10%;height:10%;"alt="<?php echo $repost['username'];?>" >
							<a style="" href="<?php echo HOME.$repost['username'];?>"><?php echo $repost['username'];?></a><span style="padding-left:25px;font-weight:normal;font-size:0.75em;" class="clr-gray">Reposted by <a style="" class="clr-gray" href="<?php echo HOME.$userinfo['username'];?>"><?php echo $userinfo['username']; ?></a></span>
						</h5>
						<?php 
						$new_blotter = preg_replace('/@(\\w+)/','<a href='.HOME.'$1>$0</a>',$blotter['blotter']);
						$new_blotter = preg_replace('/#(\\w+)/','<a href='.HOME.'hashtag/$1>$0</a>',$new_blotter); 
						?>
					<p class="card-text"><?php echo $new_blotter;?></p>
					</div>
				</div>
			</div>			
		  <div class="card-block card-block-divider">
			<?php if (!$data->didIRepost($user_id,$blotter['source_blotter_id'])){ ?>
			<form action="blotter.php" method="POST" >
				<input type="submit" id="Repost" style="float:right;" name="Repost" value="Repost" class=""></input>				
				<input type="hidden" id="source_id" name="source_id" class="" value="<?php echo $orig_poster_id;?>"></input>	
				<input type="hidden" id="blotter_id" name="blotter_id" class="" value="<?php echo $blotter['source_blotter_id']; ?>"></input>		
			</form>
			<?php }else{ ?>
			<form action="blotter.php" method="POST" >
				<input type="submit" id="Unrepost" style="float:right;" name="Unrepost" value="Unrepost" class=""></input>				
				<input type="hidden" id="source_id" name="source_id" class="" value="<?php echo $user_id;?>"></input>	
				<input type="hidden" id="blotter_id" name="blotter_id" class="" value="<?php echo $blotter['source_blotter_id']; ?>"></input>		
			</form>				
				
		<?php	} ?>
			<span  class="clr-orange" style="float:right;">&nbsp;|</span><a class="clr-orange link" style="float:right;margin-top:2px;" data-toggle="collapse" href="#message-main-<?php echo $blotter['source_blotter_id']; ?>" aria-expanded="false" aria-controls="message-main-<?php echo $blotter['source_blotter_id']; ?>">Message</a>
			<span style="font-size:12px;" class="clr-orange">Reposted <?php echo getTime($blotter['timestamp']);?></span>
			<span style="font-size:12px;" class="clr-orange">&nbsp;&nbsp;Reposted <?php echo $data->getBlotterTimesPosted($blotter['source_blotter_id']); ?> times</span>
			
		  </div>
		  
		  
				  <div class="collapse" id="message-main-<?php echo $blotter['source_blotter_id']; ?>">
					  <div class="card card-block">
						<form action="send-user-message.php" method="POST" role="form" style="">
							<div class="form-group">
							  <label for="message-text" class="form-control-label">Message:</label>
							  <textarea class="form-control" id="message-text" name="message_text" value="<?php echo $_POST['message_text']; ?>"></textarea>
							</div>
							<input type="hidden" style="" name="ref" value="main">
							<input type="hidden" style="" name="sender_id" value="<?php echo $user_id; ?>">
							<input type="hidden" style="margin-bottom:10px;" name="to_id" value="<?php echo $blotter['source_blotter_id']; ?>">
							  
							<?php
							if($msg){
								echo "<div class='alert alert-danger'>".$msg."</div>";
							}
							?>
							<button type="submit" style="" class="btn bgclr-orange clr-white" name="btn" value="send-user-message">Send Message</button>
						  </form>
					  </div>
					</div>
		  
		  
		  
		</div>									
<?php									
	}elseif($blotter['is_repost'] == 0){									
?>						
		<div class="card1">
			<div class="row">				
				<div class="col-xs-12">
					<div class="card-block">
						<h5 class="card-title">
							<img class="img-responsive card-bottom-round1" src="<?php echo HOME . "uploads/".$data->getUserAvatar($blotter['user_id']); ?>" style="width:10%;height:10%;"alt="<?php echo $userinfo['username'];?>" >
							<a style="" href="./<?php echo $userinfo['username'];?>"><?php echo $userinfo['username'];?></a>
						</h5>
						<?php 
						$new_blotter = preg_replace('/@(\\w+)/','<a href=./$1>$0</a>',$blotter['blotter']);
						$new_blotter = preg_replace('/#(\\w+)/','<a href=./hashtag/$1>$0</a>',$new_blotter); 
						?>
					<p class="card-text"><?php echo $new_blotter;?></p>
					</div>
				</div>
			</div>
			
		  <div class="card-block card-block-divider">
		  <?php if ($blotter['user_id'] != $user_id){ ?>
			<form action="blotter.php" method="POST" >
					<input type="submit" id="Repost" style="float:right;"  name="Repost" value="Repost"></input>						
					<input type="hidden" id="source_id" name="source_id" class="btn tag-orange" value="<?php echo $blotter['user_id'];?>"></input>	
					<input type="hidden" id="blotter_id" name="blotter_id" class="btn tag-orange" value="<?php echo $blotter['id']; ?>"></input>						
			</form>
		  <?php } ?>
			<span style="font-size:12px;" class="clr-orange">Posted <?php echo getTime($blotter['timestamp']);?></span>
		  </div>
		</div>						
<?php 
		}
	}
}
?>
	</div>
				<!--************************* MESSAGES ************************** -->		  
		  <div class="tab-pane" id="messages" role="tabpanel"><br>
				<ul class="nav nav-pills nav-justified " role="tablist">
				  <li class="nav-item ">
					<a class="nav-link active" data-toggle="tab" href="#inbox" role="tab"><?php echo ICON_INBOX; ?>&nbsp;Inbox&nbsp;</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#sent" role="tab"><?php echo ICON_OUTBOX; ?>&nbsp;Sent&nbsp;</a>
				  </li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="inbox" role="tabpanel"><br>
					
						<?php
							  $umids = $data->getUserMessageID($user_id,1);
							  if($umids){
							  foreach($umids as $umid){ 
								$message = $data->getUserMessages($umid['message_id']);
								$sent_from_id = $message[0]['sent_from'];
								$sent_from = $data->getUserUserName($sent_from_id);
								$read_status = $data->getUserMessageReadStatus($umid['message_id'],$user_id);
										
						?>
									<div class="card1">
										<div class="row">
											
											<div class="col-xs-12">
												<div class="card-block">
													<h5 class="card-title"><img class="img-responsive card-bottom-round1" src="<?php echo HOME . "uploads/".$data->getUserAvatar($sent_from_id); ?>" style="width:5%;height:5%;"alt="<?php echo $sent_from;?>" >
														<a style="" href="./<?php echo $sent_from;?>"><?php echo $sent_from;?></a>
														<?php 
															$readStatus = ($read_status == 0?'<a href="?message-read-status=1&message-id='.$message[0]['id'].'" title="Mark as read"><span style="color:#5cb85c;">'.ICON_CHECK.'</span> Mark as read</a>':'<a href="?message-read-status=0&message-id='.$message[0]['id'].'" title="Mark as unread"><span style="color:#d9534f;">'.ICON_CHECK.'</span> Mark as unread</a>');
														?>
														<small><small>&nbsp;&nbsp;&nbsp;&nbsp;Received on <?php echo fix_the_date_small($message[0]['date']).' - '.fix_the_time_small($message[0]['date']);?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo$readStatus;?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="?delete-message=<?php echo $message[0]['id'];?>"><?php echo ICON_DELETE;?> Delete</a></small></small>
													</h5>
													<?php $new_message = preg_replace('/@(\\w+)/','<a href=./$1>$0</a>',$message[0]['message']);$new_message = preg_replace('/#(\\w+)/','<a href=./hashtag/$1>$0</a>',$new_message); ?>
												<p class="card-text"><?php echo $new_message;?></p>
												</div>
											</div>
										</div>
										
									</div>
						<?php					
								}	}else{echo '<h6 class="clr-gray">You have no new messages.</h6>';}		
							  ?>
					
					
					</div>
					<div class="tab-pane" id="sent" role="tabpanel"><br>
					<?php
							  $umids = $data->getUserMessageID($user_id,0);
							  if($umids){
							  foreach($umids as $umid){ 
								$message = $data->getUserMessages($umid['message_id']);
								$sent_from_id = $message[0]['sent_from'];
								$sent_from = $data->getUserUserName($sent_from_id);
										
						?>
									<div class="card1">
										<div class="row">
											
											<div class="col-xs-12">
												<div class="card-block">
													<h5 class="card-title"><img class="img-responsive card-bottom-round1" src="<?php echo HOME . "uploads/".$data->getUserAvatar($sent_from_id); ?>" style="width:5%;height:5%;"alt="<?php echo $sent_from;?>" >
														<a style="" href="./<?php echo $sent_from;?>"><?php echo $sent_from;?></a>
														<small><small>Sent on <?php echo fix_the_date_small($message[0]['date']).' - '.fix_the_time_small($message[0]['date']);?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="?delete-message=<?php echo $message[0]['id'];?>"><?php echo ICON_DELETE;?> Delete</a></small></small>
													</h5>
													<?php $new_message = preg_replace('/@(\\w+)/','<a href=./$1>$0</a>',$message[0]['message']);$new_message = preg_replace('/#(\\w+)/','<a href=./hashtag/$1>$0</a>',$new_message); ?>
												<p class="card-text"><?php echo $new_message;?></p>
												</div>
											</div>
										</div>
									</div>
						<?php					
								}	}else{echo '<h6 class="clr-gray">You have no new messages.</h6>';}		
							  ?>
					
					
					</div>
				</div>
	
	
	
			</div>
		  
		  
				<!--************************* alerts ************************** -->
		  <div class="tab-pane" id="alerts" role="tabpanel"><br>
		  <?php
		  $alerts = $data->alert_info($user_id);
		  if($alerts){
			  foreach($alerts as $alert){
						$alert_msg = $alert['alert_msg'];
						$read_status = $alert['read_status'];
						$readStatus = ($alert['read_status'] == 0?'<a href="?alert-read-status=1&alert-id='.$alert['id'].'" title="Mark as read"><span style="color:#5cb85c;">'.ICON_CHECK.'</span></a>':'<a href="?alert-read-status=0&alert-id='.$alert['id'].'" title="Mark as unread"><span style="color:#d9534f;">'.ICON_CHECK.'</span></a>');
						$datetime = $alert['date'];
						echo $alert['alert_msg'].'<span style="float:right;"><small>'.fix_the_date_small($datetime).' '.fix_the_time_small($datetime).' - '.$readStatus.' <a href="?delete-alert='.$alert['id'].'">'.ICON_DELETE.'</a> </small></span>';
						echo '<div class="dropdown-divider"></div>';
				}
			}else{
				?>
				<h6 class="clr-gray">You have no new alerts.</h6>
				<?php
				
			}
		  ?>
		  </div>
				<!--************************* FOLLOWERS ************************** -->		  
		  <div class="tab-pane" id="followers" role="tabpanel"><br>
		  <?php
		  $fus = $data->getFollowers($user_id);
		  foreach($fus as $fu){
					$uid=$fu['user1_id'];
					$ui = $data->getUserInfo($uid); 
					?>
						<div class="card">
					<div class="row">
						<div class="col-xs-2"><img class="img-responsive" src="<?php echo HOME . "uploads/".$ui['user_avatar']; ?>" style="width:100%;"></div>
						<div class="col-xs-10"><div class="card-block">
					<h4 class="card-title"><a style="" href="./<?php echo $ui['username'];?>"><?php echo $ui['username'];?></a></h4>
					<p class="card-text"><?php echo $ui['userbio'];?></p>
				  </div></div>
					</div>
				  <div class="card-block card-block-divider">
					<a class="card-link" data-toggle="collapse" href="#message-<?php echo $ui['id'] ?>" aria-expanded="false" aria-controls="message-<?php echo $ui['id']; ?>">Message</a>
					
				  </div>
				  <div class="collapse" id="message-<?php echo $ui['id']; ?>">
					  <div class="card card-block">
						<form action="send-user-message.php" method="POST" role="form" style="">
							<div class="form-group">
							  <label for="message-text" class="form-control-label">Message:</label>
							  <textarea class="form-control" id="message-text" name="message_text" value="<?php echo $_POST['message_text']; ?>"></textarea>
							</div>
							<input type="hidden" style="" name="ref" value="followtab">
							<input type="hidden" style="margin-bottom:10px;" name="sender_id" value="<?php echo $user_id; ?>">
							<input type="hidden" style="margin-bottom:10px;" name="to_id" value="<?php echo $ui['id']; ?>">
							  
							<?php
							if($msg){
								echo "<div class='alert alert-danger'>".$msg."</div>";
							}
							?>
							<button type="submit" style="" class="btn bgclr-orange clr-white" name="btn" value="send-user-message">Send Message</button>
						  </form>
					  </div>
					</div>
				  
				</div>
				
				
		<?php	}
			
		  ?>
		  </div>
				<!--************************* FOLLOWING ************************** -->		  
		  <div class="tab-pane" id="following" role="tabpanel"><br>
				 <?php
		  $fus = $data->getFollowing($user_id);
		  foreach($fus as $fu){
					$uid=$fu['user2_id'];
					$ui = $data->getUserInfo($uid); 
					?>
						<div class="card">
					<div class="row">
						<div class="col-xs-2"><img class="card-img-top card-bottom-round1" src="<?php echo HOME . "uploads/".$ui['user_avatar']; ?>" style="width:100%;"></div>
						<div class="col-xs-10"><div class="card-block">
					<h4 class="card-title"><a style="" href="./<?php echo $ui['username'];?>"><?php echo $ui['username'];?></a></h4>
					<p class="card-text"><?php echo $ui['userbio'];?></p>
				  </div></div>
					</div>
				  <div class="card-block card-block-divider">
					<a href="#" class="card-link">Card link</a>
					<a href="#" class="card-link">Another link</a>
				  </div>
				</div>
		<?php	}
			
		  ?>
		  </div>	  
		  
				<!--************************* SETTINGS ************************** -->	
		</div>
</div>