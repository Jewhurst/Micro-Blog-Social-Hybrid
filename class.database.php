<?php
/* THIS IS THE DATABASE THAT WE WILL USE TO MAKE CALLS TO THE DATABASE*/
class dbconnect {
	/*THIS IS THE INITIAL SETUP*/
    private $db; 
	/*
	THIS FUNCTION IS SO YOU CAN USE SINGLE CALLS OUTSIDE THE CLASS SECTION
	EXAMPLE: ON THE INDEX PAGE YOU WILL SEE AN EXAMPLE OF THE SAME EXACT CALL AS 
	BELOW BUT DONE ON THE FLY HARDCODED IN A PAGE	
	*/
    public function __construct()  {
          global $db;
          $this->db = $db;
    }    
	
	
	/*THESE ARE FUNCTIONS YOU CAN USE WITHIN YOUR SITE*/
	public function getSiteOption($optionName){
		try{		
			$stmt = $this->db->prepare("SELECT optionValue FROM site_options WHERE optionName = :optionName");
			$stmt->execute(array(':optionName'=>$optionName));
			$val=$stmt->fetch(PDO::FETCH_ASSOC);
			return $val['optionValue'];			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function getUserInfo($user_id){
		try{		
			$stmt = $this->db->prepare("SELECT * FROM users WHERE id= :user_id");
			$stmt->execute(array(':user_id'=>$user_id));
			$val=$stmt->fetch(PDO::FETCH_ASSOC);
			return $val;			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function getUserAvatar($user_id){
		try{		
			$stmt = $this->db->prepare("SELECT user_avatar FROM users WHERE id= :user_id");
			$stmt->execute(array(':user_id'=>$user_id));
			$val=$stmt->fetch(PDO::FETCH_ASSOC);
			return $val['user_avatar'];			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function getUserRealName($user_id){
		try{		
			$stmt = $this->db->prepare("SELECT userrealname FROM users WHERE id= :user_id");
			$stmt->execute(array(':user_id'=>$user_id));
			$val=$stmt->fetch(PDO::FETCH_ASSOC);
			return $val['userrealname'];			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function getUserUserName($user_id){
		try{		
			$stmt = $this->db->prepare("SELECT username FROM users WHERE id= :user_id");
			$stmt->execute(array(':user_id'=>$user_id));
			$val=$stmt->fetch(PDO::FETCH_ASSOC);
			return $val['username'];			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function getUserFollowerCount($user_id){
		try{		
			$stmt = $this->db->prepare("SELECT followers FROM users WHERE id= :user_id");
			$stmt->execute(array(':user_id'=>$user_id));
			$val=$stmt->fetch(PDO::FETCH_ASSOC);
			return $val['followers'];			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function getUserFollowingCount($user_id){
		try{		
			$stmt = $this->db->prepare("SELECT following FROM users WHERE id= :user_id");
			$stmt->execute(array(':user_id'=>$user_id));
			$val=$stmt->fetch(PDO::FETCH_ASSOC);
			return $val['following'];			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function userGetUserInfo($username){
		try{		
			$stmt = $this->db->prepare("SELECT * FROM users WHERE username=:username");
			$stmt->execute(array(':username'=>$username));
			$val=$stmt->fetch(PDO::FETCH_ASSOC);
			return $val;			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function does_a_follow_b($user_id,$id){
		try{		
			$stmt = $this->db->prepare("SELECT * FROM following WHERE user1_id=:user_id AND user2_id=:id");
			$stmt->execute(array(':user_id'=>$user_id,':id'=>$id));
			//$val=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 0){
				return false;
			}else{
				return true;
			}
			//return $val;			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function didIRepost($user_id,$blotter_id){
		try{		
			$stmt = $this->db->prepare("SELECT * FROM blotters_reposted WHERE user_id=:user_id AND blotter_id=:blotter_id");
			$stmt->execute(array(':user_id'=>$user_id,':blotter_id'=>$blotter_id));
			//$val=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 0){
				return false;
			}else{
				return true;
			}
			//return $val;			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function isUserFollowingMe($user_id,$id){
		try{		
			$stmt = $this->db->prepare("SELECT id FROM following WHERE user1_id=:id AND user2_id=:user_id");
			$stmt->execute(array(':id'=>$id,':user_id'=>$user_id));
			$val=$stmt->fetch(PDO::FETCH_ASSOC);
			return $val;			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function getFollowers($user_id){
		try{		
			$stmt = $this->db->prepare("SELECT user1_id FROM following WHERE user2_id=:user2_id");
			$stmt->execute(array(':user2_id'=>$user_id));
			$val=$stmt->fetchAll();
			return $val;			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function getFollowing($user_id){
		try{		
			$stmt = $this->db->prepare("SELECT user2_id FROM following WHERE user1_id=:user1_id");
			$stmt->execute(array(':user1_id'=>$user_id));
			$val=$stmt->fetchAll();
			return $val;			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function followUser($user_id,$follow_userid){
		try{		
			$stmt1 = $this->db->prepare("SELECT id FROM following WHERE user1_id=:user_id AND user2_id=:follow_userid");
			$stmt1->execute(array(':user_id'=>$user_id,':follow_userid'=>$follow_userid));
			//$val=$stmt1->fetch(PDO::FETCH_ASSOC);
			if($stmt1->rowCount() == 0){
				$stmt2 = $this->db->prepare("INSERT INTO following(user1_id, user2_id) VALUES (:user_id,:follow_userid)");
				$stmt2->execute(array(':user_id'=>$user_id,':follow_userid'=>$follow_userid));
				$stmt3 = $this->db->prepare("UPDATE users SET following = following + 1 WHERE id=:user_id");
				$stmt3->execute(array(':user_id'=>$user_id));
				$stmt4 = $this->db->prepare("UPDATE users SET followers = followers + 1 WHERE id=:follow_userid");
				$stmt4->execute(array(':follow_userid'=>$follow_userid));				
			}
			return true;			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function unfollowUser($user_id,$unfollow_userid){
		try{		
			$stmt1 = $this->db->prepare("SELECT id FROM following WHERE user1_id=:user_id AND user2_id=:unfollow_userid");
			$stmt1->execute(array(':user_id'=>$user_id,':unfollow_userid'=>$unfollow_userid));
			//$val=$stmt1->fetch(PDO::FETCH_ASSOC);
			if($stmt1->rowCount() > 0){
				$stmt2 = $this->db->prepare("DELETE FROM following WHERE user1_id=:user_id AND user2_id=:unfollow_userid");
				$stmt2->execute(array(':user_id'=>$user_id,':unfollow_userid'=>$unfollow_userid));
				$stmt3 = $this->db->prepare("UPDATE users SET following = following - 1 WHERE id=:user_id");
				$stmt3->execute(array(':user_id'=>$user_id));
				$stmt4 = $this->db->prepare("UPDATE users SET followers = followers - 1 WHERE id=:unfollow_userid");
				$stmt4->execute(array(':unfollow_userid'=>$unfollow_userid));				
			}
			return true;			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function getBlotters($user_id){
		try{		
			$stmt = $this->db->prepare("SELECT username, blotter, timestamp FROM blotters WHERE user_id = :user_id OR (user_id IN (SELECT user2_id FROM following WHERE  user1_id = :user_id)) ORDER BY timestamp DESC LIMIT 0, 10 ");
			$stmt->execute(array(':user_id'=>$user_id));
			$val=$stmt->fetch(PDO::FETCH_ASSOC);
			return $val;			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function getBlotterDetails($blotter_id){
		try{		
			$stmt = $this->db->prepare("SELECT * FROM blotters WHERE id = :blotter_id");
			$stmt->execute(array(':blotter_id'=>$blotter_id));
			$val=$stmt->fetch(PDO::FETCH_ASSOC);
			return $val;			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function getBlotterTimesPosted($blotter_id){
		try{		
			$stmt = $this->db->prepare("SELECT times_reposted FROM blotters WHERE id = :blotter_id");
			$stmt->execute(array(':blotter_id'=>$blotter_id));
			$val=$stmt->fetch();
			return $val['times_reposted'];			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function postBlotter($user_id,$blotter,$timestamp){
		try{		
			$stmt = $this->db->prepare("INSERT INTO blotters(user_id,blotter,timestamp) VALUES (:user_id,:blotter,:timestamp)");
			$stmt->execute(array(':user_id'=>$user_id,':blotter'=>$blotter,':timestamp'=>$timestamp));
			
			return $stmt;			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function updateBlottersReposted($user_id,$blotter_source_id,$blotter_id){
		try{		
			$stmt = $this->db->prepare("INSERT INTO blotters_reposted(user_id,blotter_source_id,blotter_id) VALUES (:user_id,:blotter_source_id,:blotter_id)");
			$stmt->execute(array(':user_id'=>$user_id,':blotter_source_id'=>$blotter_source_id,':blotter_id'=>$blotter_id));			
			return $stmt;			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function repostBlotter($user_id,$blotter,$timestamp,$source_id,$source_blotter_id,$is_repost,$repost_time){
		try{		
			
			$stmt = $this->db->prepare("INSERT INTO blotters(
			user_id, 
			blotter, 
			timestamp, 
			source_id, 
			source_blotter_id, 
			is_repost, 
			repost_time
			) VALUES (
			:user_id, 
			:blotter, 
			:timestamp, 
			:source_id, 
			:source_blotter_id, 
			:is_repost, 
			:repost_time
			)");
			
			$stmt->execute(array(
				':user_id'=>$user_id,
				':blotter'=>$blotter,
				':timestamp'=>$timestamp,
				':source_id'=>$source_id,
				':source_blotter_id'=>$source_blotter_id,
				':is_repost'=>$is_repost,
				':repost_time'=>$repost_time
			));
			

			
			
			return $stmt;			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function unrepostBlotter($source_id,$source_blotter_id){
		try{		
			
			$stmt = $this->db->prepare("DELETE FROM blotters WHERE user_id = :source_id AND source_blotter_id = :source_blotter_id AND is_repost = 1");
			if($stmt->execute(array(':source_id'=>$source_id,':source_blotter_id'=>$source_blotter_id))){
				return true;
			}else{
				return false;
			}
						
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function addInvitedFriend($invitee,$invitee_ip,$invited_email,$user_id,$signup_code){
		try{		
			$stmt = $this->db->prepare("INSERT INTO invite_friends (invitee,invitee_ip,invited_email,user_id,signup_code) VALUES (:invitee,:invitee_ip,:invited_email,:user_id,:signup_code)");
			$stmt->execute(array(':invitee'=>$invitee,':invitee_ip'=>$invitee_ip,':invited_email'=>$invited_email,':user_id'=>$user_id,':signup_code'=>$signup_code));
			//$stmt = $this->db->prepare("UPDATE users SET user_signup_code = blotters + 1 WHERE id=:user_id");
			//$stmt->execute(array(':user_id'=>$user_id));
			return $stmt;			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function updateUserBlotterCount($user_id){
		try{		
			$stmt = $this->db->prepare("UPDATE users SET blotters = blotters + 1 WHERE id=:user_id");
			$stmt->execute(array(':user_id'=>$user_id));
			return true;			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function updateUserRepostCount($user_id){
		try{		
			$stmt = $this->db->prepare("UPDATE users SET reposts = reposts + 1 WHERE id=:user_id");
			$stmt->execute(array(':user_id'=>$user_id));
			return true;			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function updateBlotterRepostCount($blotter_id){
		try{		
			$stmt = $this->db->prepare("UPDATE blotters SET times_reposted = times_reposted + 1 WHERE id=:blotter_id");
			$stmt->execute(array(':blotter_id'=>$blotter_id));
			return true;			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
    public function runQuery($sql)  {
         $stmt = $this->db->prepare($sql);
         return $stmt;
   }   

   public function lastID() {
         $stmt = $this->db->lastInsertId();
         return $stmt;
   }

	 public function login($username,$email,$password) {
       try {
          $stmt = $this->db->prepare("SELECT * FROM users WHERE username=:username OR email=:email");
          $stmt->execute(array(':username'=>$username,':email'=>$email));
          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
          if($stmt->rowCount() > 0) {
             if(password_verify($password, $userRow['password'])) {
                $_SESSION['user_id'] = $userRow['id'];
                $_SESSION['username'] = $userRow['username'];
                $_SESSION['loggedin'] = true;
                return true;
             } else {
                return false;
             }
          }
       }
       catch(PDOException $e) {
           echo $e->getMessage();
       }
   }
   

   
    public function register($username='',$email='',$password='',$signup_code='') {
       try {
           $new_password = password_hash($password, PASSWORD_DEFAULT);
		   $stmt = $this->db->prepare("INSERT INTO users(username,email,password,user_avatar,user_signup_code) VALUES(:username,:email, :password,'default.jpg',:signup_code)");
           $stmt->bindparam(":username", $username);
           $stmt->bindparam(":email", $email);
           $stmt->bindparam(":password", $new_password);
           $stmt->bindparam(":signup_code", $signup_code);
           $stmt->execute(); 
           return $stmt; 
       }
       catch(PDOException $e) {
           echo $e->getMessage();
       }    
    }
	
	
	public function checkHashtagExist($htiw){
		
		$stmt = $this->db->prepare('SELECT id,hashtags FROM hashtags WHERE hashtags = :htiw');
		$stmt->execute(array(':htiw' => $htiw));
		$rc = $stmt->rowCount();
		if($rc >= 1){return true;}else{return false;}			
	}
	public function addHashtagCount($htiw,$blotter_id){
		$a = $this->db->prepare('SELECT id FROM hashtags WHERE hashtags = :htiw');
		$a->execute(array(':htiw' => $htiw));
		$val=$a->fetch(PDO::FETCH_ASSOC);
		$stmt = $this->db->prepare('INSERT INTO hashtags_blotter (blotter_id,hashtag_id) VALUES (:blotter_id,:hashtag_id)');
		$stmt->execute(array(':blotter_id' => $blotter_id,':hashtag_id' => $val['id']));
			
	}
	public function addHashtag($htiw){
		$stmt = $this->db->prepare('INSERT INTO hashtags (hashtags,first_used_date) VALUES (:hashtags,:first_used_date)');
		$stmt->execute(array(':hashtags' => $htiw,':first_used_date' => date('Y-m-d H:i:s')));
			
	}
	public function getHashtagBlotters($wid){
		$b = $this->db->prepare('SELECT * FROM blotters WHERE id = :wid');
		$b->execute(array(':wid' => $wid));
		$b_val=$b->fetch(PDO::FETCH_ASSOC);
		return $b_val;
			
	}
	public function getHashtagID($htiw){
		$a = $this->db->prepare('SELECT id FROM hashtags WHERE hashtags = :hashtags');
		$a->execute(array(':hashtags' => $htiw));
		$a_val=$a->fetch(PDO::FETCH_ASSOC);
		return $a_val['id'];
			
	}
	public function getBlotterIDFromHashtagID($htid){
		$a = $this->db->prepare('SELECT blotter_id FROM hashtags_blotter WHERE hashtag_id = :hashtag_id');
		$a->execute(array(':hashtag_id' => $htid));
		$a_val=$a->fetchAll(PDO::FETCH_ASSOC);
		return $a_val;
			
	}
	public function getBlotterFromID($blotter_id){
		$a = $this->db->prepare('SELECT * FROM blotters WHERE id = :blotter_id');
		$a->execute(array(':blotter_id' => $blotter_id));
		$a_val=$a->fetchAll(PDO::FETCH_ASSOC);
		return $a_val;
			
	}
	/* Params
	*
	*	@user_id - id of user that is receiving the alert
	*	@activity_type - type of alert 0 = 		
	*	@source_id - the person sending or causing the alert
	*	@
	*
	*
	*/
	public function alert_info(
				$user_id,
				$activity_type = '0',
				$source_id = '0',
				$parent_id = '0',
				$parent_type = '',
				$alert_msg = '',
				$read_status = '0')
	{		
			if($user_id != $source_id){
				$datetime = date('Y-m-d H:i:s');
				
				$a = $this->db->prepare("SELECT username FROM users WHERE id= :user_id");
				$a->execute(array(':user_id'=>$user_id));
				$aval=$a->fetch(PDO::FETCH_ASSOC);
				$user_name = $aval['username'];
				
				$b = $this->db->prepare("SELECT username FROM users WHERE id= :source_id");
				$b->execute(array(':source_id'=>$source_id));
				$bval=$b->fetch(PDO::FETCH_ASSOC);
				$source_name = $bval['username'];
				//$user_name = getUserUserName($user_id);
				//$source_name = getUserUserName($source_id);
				//$parent_info = $data->getblotterLink($parent_id);
				
			
			
			
          switch ($activity_type) {
            case 1:
					
					$c = $this->db->prepare('INSERT INTO alerts (user_id,activity_type,source_id,parent_id,parent_type,alert_msg,date,read_status) VALUES (:user_id,:activity_type,:source_id,:parent_id,:parent_type,:alert_msg,:date,:read_status)');
					switch($parent_type) {
						case 'mention':

								$msg = '<a href="'.HOME.$source_name.'">'.$source_name.'</a> has mentioned you';								
								if($user_id!=$source_id){
										$c->execute(array(':user_id' => $user_id,':activity_type' => $activity_type,':source_id' => $source_id,':parent_id' => $parent_id,':parent_type' => $parent_type,':alert_msg' => $msg,':date' => $datetime,':read_status' => $read_status));
								}
						 break;
						case 'repost_mention':	
								$d = $this->db->prepare('SELECT * FROM blotters WHERE id = :blotter_id');
								$d->execute(array(':blotter_id' => $parent_id));
								$d_val=$d->fetch(PDO::FETCH_ASSOC);
								$e = $this->db->prepare("SELECT user_avatar FROM users WHERE id= :user_id");
								$e->execute(array(':user_id'=>$d_val['user_id']));
								$e_val=$e->fetch(PDO::FETCH_ASSOC);
								
								$modal = '
									<div class="modal fade" id="repost_mention-'.$parent_id.'"  role="dialog" aria-labelledby="repost_mentionLabel" aria-hidden="true">
									  <div class="modal-dialog" role="document">
										<div class="modal-content">
										  <div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true">&times;</span>
											</button>
											<h4 class="modal-title" id="repost_mentionLabel">Blotter from <b>'.$source_name.'</b> </h4>
										  </div>
										  <div class="modal-body">
											<div class="col-md-3"><img class="img-responsive card-bottom-round1" src="'.$e_val['user_avatar'].'" /></div>
											<div class="col-md-9">'.$d_val['blotter'].'</div>
										  </div>
										  <div class="modal-footer">
											<button type="button" class="btn bgclr-orange" data-dismiss="modal">Close</button>
										  </div>
										</div>
									  </div>
									</div>
								';
								$msg = '<a href="'.HOME.$source_name.'">'.$source_name.'</a> has reposted a <a href="'.HOME.'" data-toggle="modal" data-target="#repost_mention-'.$parent_id.'">blotter</a> you were mentioned in '.$modal;								
								if($user_id!=$source_id){
										$c->execute(array(':user_id' => $user_id,':activity_type' => $activity_type,':source_id' => $source_id,':parent_id' => $parent_id,':parent_type' => $parent_type,':alert_msg' => $msg,':date' => $datetime,':read_status' => $read_status));
								}
						 break;
						case 'message':
								$msg = '<a href="'.HOME.$source_name.'">'.$source_name.'</a> has sent you a <a href="#messages">message</a>!';
								$c->execute(array(':user_id' => $user_id,':activity_type' => $activity_type,':source_id' => $source_id,':parent_id' => $parent_id,':parent_type' => $parent_type,':alert_msg' => $msg,':date' => $datetime,':read_status' => $read_status));
										
						 break;
						case 'follow':
								$msg = '<a href="'.HOME.$source_name.'">'.$source_name.'</a> has followed you!';
								$c->execute(array(':user_id' => $user_id,':activity_type' => $activity_type,':source_id' => $source_id,':parent_id' => $parent_id,':parent_type' => $parent_type,':alert_msg' => $msg,':date' => $datetime,':read_status' => $read_status));
						 break;
						default:
						 break;
					}
					
					 
              break;
            case 0:	
					$a = $this->db->prepare('SELECT * FROM alerts WHERE user_id = :user_id ORDER BY read_status, date DESC');
					$a->execute(array(':user_id' => $user_id)); 
					$a_val=$a->fetchAll(PDO::FETCH_ASSOC);
					return $a_val;					
              break;            
            default:
               
              break;
          }		
		
	}
	}
	
	public function userDeleteAlert($alert_id,$user_id){
		try{		
			$a = $this->db->prepare("DELETE FROM alerts WHERE id = :alert_id AND user_id=:user_id");
			if($a->execute(array(':alert_id' => $alert_id,':user_id'=>$user_id))){
				return true;
			}else{
				return false;
			}
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function userDeleteMessage($message_id,$user_id){
		try{		
			$a = $this->db->prepare("DELETE FROM mailbox_users WHERE message_id = :message_id AND user_id=:user_id");
			if($a->execute(array(':message_id' => $message_id,':user_id'=>$user_id))){
				return true;
			}else{
				return false;
			}
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function getUserAlertCount($user_id){
		try{		
			$a = $this->db->prepare("SELECT user_id FROM alerts WHERE user_id=:user_id AND read_status = 0");
			$a->execute(array(':user_id'=>$user_id));
			return $a->rowCount();			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function getUserMessageCount($user_id){
		try{		
			$a = $this->db->prepare("SELECT user_id FROM mailbox_users WHERE user_id=:user_id AND in_or_out=1 AND read_status=0");
			$a->execute(array(':user_id'=>$user_id));
			return $a->rowCount();			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function getUserMessageID($user_id,$inorout){
		try{		
			$a = $this->db->prepare("SELECT message_id FROM mailbox_users WHERE in_or_out=:inorout AND user_id=:user_id ORDER BY id DESC");
			$a->execute(array(':user_id'=>$user_id,':inorout'=>$inorout));
			$a_val=$a->fetchAll();
			return $a_val;			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function getUserMessageReadStatus($message_id,$user_id){
		try{		
			$a = $this->db->prepare("SELECT read_status FROM mailbox_users WHERE message_id=:message_id AND user_id = :user_id");
			$a->execute(array(':message_id'=>$message_id,':user_id'=>$user_id));
			$a_val=$a->fetch(PDO::FETCH_ASSOC);
			return $a_val['read_status'];			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function getUserMessages($message_id){
		try{		
			$a = $this->db->prepare("SELECT * FROM mailbox_messages WHERE id=:message_id ORDER BY date DESC");
			$a->execute(array(':message_id'=>$message_id));
			$a_val=$a->fetchAll();
			return $a_val;			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
	public function sendUserMessage($sent_to,$sent_from,$message){
		try{	
			$date = date('Y-m-d H:i:s');
			$a = $this->db->prepare("INSERT INTO mailbox_messages (sent_to, sent_from, message, date) VALUES(:sent_to, :sent_from, :message,:date)");
			$a->execute(array(':sent_to'=>$sent_to,':sent_from'=>$sent_from,':message'=>$message,':date'=>$date));
			$a_id = $this->db->lastInsertId();
			
			$b = $this->db->prepare("INSERT INTO mailbox_users (user_id, in_or_out, message_id, read_status) VALUES(:user_id, :in_or_out, :message_id, :read_status)");
			$b->execute(array(':user_id'=>$sent_to,':in_or_out'=>1,':message_id'=>$a_id,':read_status'=> 0));
			
			$c = $this->db->prepare("INSERT INTO mailbox_users (user_id, in_or_out, message_id, read_status) VALUES(:user_id, :in_or_out, :message_id, :read_status)");
			$c->execute(array(':user_id'=>$sent_from,':in_or_out'=>0,':message_id'=>$a_id,':read_status'=> 0));
			return true;			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
}

?>