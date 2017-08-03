<?php
require 'header.php';
?>
	<?php
	
	if($_GET['username']){
		$username = strtolower($_GET['username']);
		
		if($ugui = $data->userGetUserInfo($username)){
			//$row=$ugui->fetch(PDO::FETCH_ASSOC);
			$id = $ugui['id'];
			$userinfo = $data->getUserInfo($ugui['id']);
			$username = $userinfo['username'];
			$blotters = $ugui['blotters'];
			$followers = $ugui['followers'];
			$following = $ugui['following'];
			$userrealname = $ugui['userrealname'];
			$userbio = $ugui['userbio'];
			$ava=$data->getUserAvatar($ugui['id']);
			if($user_id){
				if($user_id!=$id){					
					if($data->does_a_follow_b($user_id,$id)){	
						$button_subunsub = 'unsub.php?userid='.$id.'&username='.$username;
						$button_text = stringtable("common","unfollow");
					}else{ 
						$button_subunsub = 'sub.php?userid='.$id.'&username='.$username;
						$button_text = stringtable("common","follow");
					} 
				} else { 					
						$button_subunsub = HOME;
						$button_text = stringtable("common","gohome");
				}	
			}else{ 				
						$button_subunsub = HOME . 'register.php';
						$button_text = stringtable("common","signup");					
			} 
			
			if($ugui_3 = $data->isUserFollowingMe($user_id,$id)){
				$isSub2me = ' - <span class="clr-brorange">Follows You</span><br>';
			}
	?>
			
			
			<div class="animated fadeIn">
  <img class="card-img-top img-responsive" src="<?php echo HOME . 'uploads/'.$data->getUserAvatar($ugui['id']);?>" alt="" style="width:100%;">
  <div class="card-block">
    <h4 class="card-title"><?php echo '@'.$username;?>&nbsp;<small class="clr-brorange"><?php echo $userrealname;?></small><span style="font-size:0.6em;float:right;"><i class="fa fa-commenting   fa-lg " aria-hidden="true"></i></a>&nbsp;<a href='#'><?php echo $blotters;?></a>&nbsp;&nbsp;&nbsp;
		 <i class="fa fa-user-plus fa-lg" aria-hidden="true"></i>&nbsp;<a href='#'><?php echo $following;?></a>&nbsp;&nbsp;&nbsp;
		 <i class="fa fa-users  fa-lg" aria-hidden="true"></i>&nbsp;<a href='#'><?php echo $followers;?></a>&nbsp;&nbsp;&nbsp;
		 <a href="<?php echo $button_subunsub; ?>" class="tag tag-orange"><?php echo $button_text; ?></a></span></h4>
    <p class="card-text"><?php echo $userbio;?></p>
		<div class="dropdown-divider"></div> 
  </div>
</div>
		
		<?php 
				$blotters = $db->query("SELECT user_id, blotter, timestamp FROM blotters WHERE user_id = $id ORDER BY timestamp DESC limit 0,10");
			while($blotter = $blotters->fetch(PDO::FETCH_ASSOC)){
					$userinfo = $data->getUserInfo($blotter['user_id']);
					$username = $userinfo['username'];	
				?>
			<div class="animated bounceInUp">
			<h5>
				<img src="<?php echo HOME . "uploads/".$data->getUserAvatar($blotter['user_id']); ?>" style="width:35px;"alt="<?php echo $blotter['username'];?>"/>
				
				<a style="" href="./<?php echo $username;?>"><?php echo $username;?></a>
				<span style='font-size:10px;float:right;'><?php echo getTime($blotter['timestamp']);?></span></h5>
			<?php 	$new_blotter = preg_replace('/@(\\w+)/','<a href=./$1>$0</a>',$blotter['blotter']);
						$new_blotter = preg_replace('/#(\\w+)/','<a href=./hashtag/$1>$0</a>',$new_blotter); 
				?>
							<p style="font-size:13px; margin-top:-3px;"><?php echo $new_blotter;?></p>
			  <p><a class="" href="#" role="button">Share this &raquo;</a></p>
				<div class="dropdown-divider"></div></div>
			
				<?php
			}
		}
		else{
			echo "<div class='alert alert-danger'>Sorry, this profile doesn't exist.</div>";
			echo "<a href='.' style='width:300px;' class='btn btn-info'>Go Home</a>";
		}
	}
	require 'footer.php';
	?>
