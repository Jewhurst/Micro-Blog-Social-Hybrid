<?php //include config
require('header.php');
if($_GET){
	foreach ($_GET as $key => $value) {
		switch ($key) {
			case 'delete-image' :			
				$stmt = $db->prepare('UPDATE users SET user_avatar = "" WHERE id = :user_id') ;
				$stmt->execute(array(':user_id' => $value));				
				redirect(1,'edit-profile.php');
				break;
			case 'upload-image' :
				break;
			default :
				break;
		}
	}	
}
?>

<?php 
	if(isset($_POST['submit-picture-form'])){
		try {
			if($_FILES){	
				$validextensions = array("jpeg", "jpg", "png");
				$temporary = explode(".", $_FILES["file"]["name"]);
				$file_extension = end($temporary);
				if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")) && ($_FILES["file"]["size"] < 10240000) && in_array($file_extension, $validextensions)) {
					if ($_FILES["file"]["error"] > 0) {
					} else {								
							$new_file = file_newname('uploads/',$_FILES["file"]["name"]);
							move_uploaded_file($_FILES["file"]["tmp_name"], 'uploads/' . $new_file);
							$stmt = $db->prepare('UPDATE users SET user_avatar = :user_avatar WHERE id = :user_id') ;
							$stmt->execute(array(':user_avatar' => $new_file,':user_id' => $user_id));	
							redirect(1,"edit-profile.php?status=imageuploaded");
					}
				} 					
			} else {
			}
				
				

			} catch(PDOException $e) {echo $e->getMessage();}
	}

	if(isset($_POST['submit-edit-form'])){
		extract($_POST);
		if($user_id ==''){$error[] = 'You are missing missing a valid id. Relog and try again';}
		if($email ==''){$error[] = 'You are missing missing an email address. Please fix!';}
		
		if(!isset($error)){
		
			try {
				$stmt = $db->prepare('UPDATE users SET username = :username, email = :email, userbio = :userbio, userwebsite = :userwebsite, userrealname = :userrealname, user_is_private = :user_is_private WHERE id = :user_id') ;
				$stmt->execute(array(
					':username' => $username,
					':email' => $email,
					':userbio' => $userbio,
					':userwebsite' => $userwebsite,
					':userrealname' => $userrealname,
					':user_is_private' => $user_is_private,
					':user_id' => $user_id
				));	
				
				redirect(1,"edit-profile.php?status=success");

			} catch(PDOException $e) {echo $e->getMessage();}		
		}		
	}

	try {

		$stmt = $db->prepare('SELECT * FROM users WHERE id = :user_id') ;
		$stmt->execute(array(':user_id' => $user_id));
		$row = $stmt->fetch(); 

	} catch(PDOException $e) {echo $e->getMessage();}

?>

<form action="" method="POST" enctype="multipart/form-data" role="form">
    <h4>Edit your profile</h4>
			
	<div class="card-img-top img-responsive">
		<?php if($row['user_avatar']) { ?>
			
			<center><img id="imagePreview" src="<?php echo($row['user_avatar'] != "" ? HOME . "uploads/" . $row['user_avatar'] :  HOME . "uploads/default.jpg"); ?>" class="card-bottom-round"/></center>
			<a href="<?php echo $_SERVER['PHP_SELF'];?>?delete-image=<?php echo $row['id'];?>" class=""><p class="tag tag-orange">Remove Image</p></a>
			
		
		<?php } else { ?>
			
			<input id="uploadFile" name="file" type='file'><button type="submit" style="width:auto;margin-bottom:5px;" class="btn bgclr-orange clr-white boldme" name="submit-picture-form" value="submit-picture-form">Change Image</button>
			<div id="imagePreview"><center><img id="imagePreview" src="<?php echo($row['user_avatar'] != "" ? HOME . "uploads/" . $row['user_avatar'] :  HOME . "uploads/default.jpg"); ?>" class="card-bottom-round" /></center></div>
		<?php } ?>
	</div>
	
	<input type='hidden' name='user_id' value='<?php echo $row['id'];?>' style="width:50%;">
		
    <div class="input-group" style="margin-bottom:10px;">
      <span class="input-group-addon"><i class="fa fa-user-o" aria-hidden="true"></i></span>
      <input type="text" class="form-control" placeholder="Username" name="username" style="" value="<?php echo $row['username']; ?>">
    </div>
    
	<div class="form-group row" style="margin-bottom:10px;">
      <label for="email" class="col-sm-3 col-form-label text-xs-right boldme">Email:</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="email" placeholder="" name="email" value="<?php echo $row['email']; ?>">
      </div>
    </div>
    
	<div class="form-group row" style="margin-bottom:0px;">
      <label for="password" class="col-sm-3 col-form-label text-xs-right boldme">Password:</label>
      <div class="col-sm-9">
        <p style="margin-top:10px;" class="tag tag-orange">Change</p>
      </div>
    </div>
	<div class="form-group row" style="margin-bottom:10px;">
      <label for="userrealname" class="col-sm-3 col-form-label text-xs-right boldme">Real Name:</label>
      <div class="col-sm-9">
		<input type="text" class="form-control" id="userrealname" placeholder="" name="userrealname" value="<?php echo $row['userrealname']; ?>">
      </div>
    </div>
	<div class="form-group row" style="margin-bottom:10px;">
      <label for="userwebsite" class="col-sm-3 col-form-label text-xs-right boldme">Website:</label>
      <div class="col-sm-9">
		<input type="text" class="form-control" id="userwebsite" placeholder="" name="userwebsite" value="<?php echo $row['userwebsite']; ?>">
      </div>
    </div>
	
	<div class="form-group row" style="margin-bottom:5px;">
	  <label for="user_is_private" class="col-sm-3 col-form-label text-xs-right boldme">Privacy:</label>
	  <div class="col-sm-9">
		<?php 
			if($row['user_is_private'] ==0){ 
				$value="<small>Your account is public.</small>";
				echo '<select name="user_is_private"  style=""><option value="0">Public</option><option value="1">Private</option></select>';
			}else{ 
				$value="<small>Your account is private.</small>";
				echo '<select name="user_is_private"  style=""><option value="1">Private</option><option value="0">Public</option></select>';
			} 
			echo "&nbsp;" . $value;
		?>
      </div>
	</div>
	
				<?php
			echo '';
			?>
	
	<div class="form-group row" style="margin-bottom:10px;">
      <label for="userbio" class="col-sm-3 col-form-label text-xs-right boldme">Bio:</label>
      <div class="col-sm-9">
		<input type="text" class="form-control" id="userbio" placeholder="" name="userbio" value="<?php echo $row['userbio']; ?>">
      </div>
    </div>
	
	
	<div class="form-group row" style="margin-bottom:10px;">
      <label for="userrealname" class="col-sm-3 col-form-label text-xs-right boldme"></label>
      <div class="col-sm-9">
		<button type="submit" style="width:100%;margin-bottom:5px;" class="btn bgclr-orange clr-white boldme" name="submit-edit-form" value="submit-edit-form">UPDATE</button>
      </div>
    </div>
	
	

    <?php
    if($msg){
        echo "<div class='alert alert-danger'>".$msg."</div>";
    }
    ?>
</form>
  
<script type="text/javascript">
	$(function() {
		$("#uploadFile").on("change", function()
		{
			var files = !!this.files ? this.files : [];
			if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
	 
			if (/^image/.test( files[0].type)){ // only image file
				var reader = new FileReader(); // instance of the FileReader
				reader.readAsDataURL(files[0]); // read the local file
	 
				reader.onloadend = function(){ // set image data as background of div
					$("#imagePreview").css("background-image", "url("+this.result+")");
				}
			}
		});
	});
</script>
<?php require 'footer.php'; ?>