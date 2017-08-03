<?php
require 'header.php';


if($_GET['hashtag']!=""){
	$hashtag = $_GET['hashtag'];
	echo '<div style="font-size:20px;"><h3>Blotters with <b><i class="fa fa-hashtag" aria-hidden="true"></i>'.$hashtag.'</b></h3></div><div class="dropdown-divider"></div> ';
	$htid = $data->getHashtagID($hashtag);
	$wids = $data->getBlotterIDFromHashtagID($htid);
	foreach($wids as $wid){
		$blotter = $data->getHashtagBlotters($wid['blotter_id']);	
		?>
		<div class="card1">
			<div class="row">				
				<div class="col-xs-12">
					<div class="card-block">
						<h5 class="card-title">
							<img class="img-responsive card-bottom-round1" src="<?php echo HOME . "uploads/".$data->getUserAvatar($blotter['user_id']); ?>" style="width:10%;height:10%;"alt="<?php echo $data->getUserUserName($blotter['user_id']);?>" >
							<a style="" href="<?php echo HOME.$data->getUserUserName($blotter['user_id']);?>"><?php echo $data->getUserUserName($blotter['user_id']);?></a>
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
		  <?php if ($blotter['user_id'] != $user_id){ ?>
			<form action="<?php echo HOME; ?>blotter.php" method="POST" >
					<input type="submit" id="Repost" style="float:right;"  name="Repost" value="Repost"></input>						
					<input type="hidden" id="source_id" name="source_id" class="btn tag-orange" value="<?php echo $blotter['user_id'];?>"></input>	
					<input type="hidden" id="blotter_id" name="blotter_id" class="btn tag-orange" value="<?php echo $blotter['id']; ?>"></input>						
			</form>
		  <?php } ?>
			
			<?php if($blotter['times_reposted'] > 0){ ?><span style="font-size:12px;" class="clr-orange">&nbsp;&nbsp;Reposted <?php echo $data->getBlotterTimesPosted($blotter['id']); ?> times </span><?php } ?>
			<span style="font-size:12px;" class="clr-orange">Posted <?php echo getTime($blotter['timestamp']);?></span>
		  </div>
		</div>			
		<?php
	}
}
else{
	echo "<div class='alert alert-danger'>Sorry, invalid hashtag.</div>";
	echo "<a href='.' style='width:300px;' class='btn btn-info'>Go Home</a>";
}

require 'footer.php';
?>

