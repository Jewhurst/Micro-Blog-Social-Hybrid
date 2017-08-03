<?php
require 'header.php';
if($user_id){
	$red = $data->getUserUserName($_GET['invitee']);
	redirect(1,'/'.$red);
	}
?><?php
if($_POST['btn']=="submit-register-form"){
	if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])){
			$email = htmlspecialchars($_POST['email']);
			//if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
			if($_GET['signup'] != ""){
				$signup_code = $_GET['signup'];
			} else { $signup_code= "";}
			$username = htmlspecialchars($_POST['username']);
		    $password = htmlspecialchars($_POST['password']);
		    try {
		         $stmt = $db->prepare("SELECT username,email FROM users WHERE username=:username OR email=:email");
		         $stmt->execute(array(':username'=>$username, ':email'=>$email));
		         $row=$stmt->fetch(PDO::FETCH_ASSOC);	    

		         if($row['username']==$username) {
		            $msg = "NAME IS TAKEN";
		        }
		         else if($row['email']==$email) {
		            $msg= "EMAIL IN USE";
		         } else {
		            if($data->register($username,$email,$password,$signup_code)) {
		                //$data->redirect(0,'login.php');  
					   	$message = "     

					      Hello $username,
					      <br /><br />
					      Welcome to BlotterWall! 
					      <br /><br />
					      Thanks!";

					      
					   	$subject = "Confirm Registration";
					   	$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						$headers .= 'From: <info@blotterwall.com.org>' . "\r\n";
					   	if(mail($email,$subject,$message,$headers)) {
							 $msg="Email Sent";
							 $red = $data->getUserUserName($_GET['invitee']);
					   		redirect(1,'/'.$red);

					   	} else {
					   		$msg="Email failed to send";
					   		redirect(1,'register.php?fail=true');
					   	}
					  	
		            }
		         }
			}
			catch(PDOException $e) {
			        echo $e->getMessage();
			}

	//}	else {



	//	$msg= "for fucks sake";

	//}
}
	/*
  if($_POST['username']!="" && $_POST['password']!="" && $_POST['confirm-password']!=""){
    if($_POST['password']==$_POST['confirm-password']){
      //include 'connect.php';
      $username = strtolower($_POST['username']);
      $query = mysql_query("SELECT username
                            FROM users
                            WHERE username='$username'
                            ");
      mysql_close($conn);
      if(!(mysql_num_rows($query)>=1)){
          $password = md5($_POST['password']);
          include 'connect.php';
          mysql_query("INSERT INTO users(username, password)
                       VALUES ('$username', '$password')
                      ");
          mysql_close($conn);
          echo "<div class='alert alert-success'>Your account has been created!</div>";
          echo "<a href='.' style='width:300px;' class='btn btn-info'>Go Home</a>";
          echo "</form>";
          echo "<br>";
          echo "<div class='jumbotron' style='padding:3px;'>
                  <div class='container'>
                    <h5>Made by <a href='http://simarsingh.com'>Simar</a></h5>
                    <h5>This is Open Source - Fork it on <i class='fa fa-github'></i> <a href='https://github.com/iSimar/Twitter-Like-System-PHP'>GitHub</a></h5>
                  </div>
                </div>";
          echo "</body>";
          echo "</html>";
          exit;

      }
      else{
        $error_msg="Username already exists please try again";
      }
    }
    else{ 
      $error_msg="Passwords did not match";
    }
  }
  else{
      $error_msg="All fields must be filled out";
  }*/
  
  
}
?>
  <form action="" method="POST" role="form" style="width:300px;">
    <h4>Register For An Account</h4>

    <div class="input-group" style="margin-bottom:10px;">
      <span class="input-group-addon"><i class="fa fa-user-o" aria-hidden="true"></i></span>
      <input type="text" class="form-control" placeholder="Username" name="username" value="<?php echo $_POST['username']; ?>">
    </div>
      <input type="text" style="margin-bottom:10px;" class="form-control" placeholder="Email" name="email" value="<?php echo $_POST['email']; ?>">
    <input type="password" style="margin-bottom:10px;" class="form-control" placeholder="Password" name="password">
    <?php
    if($msg){
        echo "<div class='alert alert-danger'>".$msg."</div>";
    }
    ?>
    <button type="submit" style="width:300px; margin-bottom:5px;" class="btn btn-success" name="btn" value="submit-register-form">Register</button>
    <a href="." style="width:300px;" class="btn btn-info">Go Home</a>
  </form>
  <br>
<?php
require 'footer.php';
?>
