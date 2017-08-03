<?php
if($_POST['btn']=="submit-invite-form"){ 
	if (isset($_POST['email']) && isset($_POST['invitee'])){
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){$invitee_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];}elseif($_SERVER['REMOTE_ADDR']){$invitee_ip = $_SERVER['REMOTE_ADDR'];}
		//$ipinfo = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
		$email = htmlspecialchars($_POST['email']);
		$invitee = htmlspecialchars($_POST['invitee']);
		$code = random_str(32);
		if(!$user_id){$user_id = 0;}
		try {
				
			 $go = $data->addInvitedFriend($invitee,$invitee_ip,$email,$user_id,$code);
			 if($go) {  
				$message = "Your friend, $invitee, thinks you might like our new social website. It's called BlotterWall. It takes some of the best parts of current social media that you enjoy and blends it with more privacy, new features, and more ways to communicate publicly and privately. We are currently available on the web, soon to be available in mobile apps for Android and iOS.<br><br><a href='//blotterwall.com/register.php?signup=$code&invitee=$user_id'>Sign up now and say hi to $invitee</a><br><br>Thanks!<br><br>BlotterWall Administration";				  
				$subject = $invitee . " wants you to know about BlotterWall";
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
				$headers .= 'From: <info@blotterwall.com>' . "\r\n";
				if(mail($email,$subject,$message,$headers)) {
					 $msg="Email Sent";
					redirect(0);
				} else {
					$msg="Something went wrong";
					redirect(0);
				}
				
			 }
			 
		}
		catch(PDOException $e) {
				echo $e->getMessage();
		}
	}
}
?>
		<div class="card card-inverse bgclr-brown show-768 animated zoomIn" style="">
		  <div class="card-block">
			<h3 class="card-title">Invite a friend</h3>
			<p class="card-text">Share us with your friends</p>
			 <form action="" method="POST" role="form" style="">
			  <input type="text" style="margin-bottom:10px;" class="form-control" placeholder="Your Name" name="invitee" value="<?php echo $_POST['invitee']; ?>">
			  <input type="text" style="margin-bottom:10px;" class="form-control" placeholder="Friend's Email" name="email" value="<?php echo $_POST['email']; ?>">
			<?php
			if($msg){
				echo "<div class='alert alert-danger'>".$msg."</div>";
			}
			?>
			<button type="submit" style="" class="btn bgclr-orange clr-white" name="btn" value="submit-invite-form">Invite Friends</button>
		  </form>
		  </div>
		</div>
		
		<div class="hide-768" style="padding-left:10px;">
		<div class="" style="padding-left:10px;">
		  <div class=""><br>
			<h6 class="card-title text-center">Trending Topics</h6>
				<ul class="list-group">
					<?php $stmt2 = $db->query('SELECT hashtags.*, COUNT(hashtags.id) AS hashtag_id_count FROM hashtags LEFT JOIN hashtags_blotter ON hashtags.id = hashtags_blotter.hashtag_id GROUP BY hashtags.hashtags ORDER BY hashtag_id_count DESC LIMIT 5');
						while($row2 = $stmt2->fetch()){ ?>
				  <li class="list-group-item">
						<span class="tag tag-default tag-pill bgclr-brorange" style="float:right;margin-top:3px;"><a href='/hashtag/<?php echo strtolower($row2['hashtags']);?>' class=" clr-white"><?php echo $row2['hashtag_id_count'];?></a></span>
					<!--i class="fa fa-hashtag" aria-hidden="true"></i--><?php echo $row2['hashtags'];?>
				  </li>
					<?php } ?>
				</ul>			
		  </div>
		  </div>
		</div>

<?php if(isLoggedIn()){ ?> 
<?php 	}else {}; ?>