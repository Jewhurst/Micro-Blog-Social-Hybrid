<?php


			if($_POST['login-btn']=="login-submit"){
				if (isset($_POST['username']) && isset($_POST['password'])){
					$username = htmlspecialchars($_POST['username']);
					$email = htmlspecialchars($_POST['username']);
					$password = htmlspecialchars($_POST['password']);
					if($data->login($username,$email,$password)){
						?>
						<script>
				location.reload();
			</script>
						
						<?php            
					}else{
						$msgresult = "Invalid Login Credentials";
					}
				}
			}
			?>
			<center>
			<h3><?php echo $data->getSiteOption("site_name"); ?></h3>
			  <form role="form" action="" method="POST" style="width:300px;">
				<div class="input-group" style="margin-bottom:10px;">
				  <span class="input-group-addon"><i class="fa fa-user-o" aria-hidden="true"></i></span>
				  <input type="text" class="form-control" placeholder="Username" name="username">
				</div>
				<input type="password" style="margin-bottom:10px;" class="form-control" placeholder="Password" name="password">
				<?php
				if($msgresult){
					echo "<div class='alert alert-danger'>".$msgresult."</div>";
				}
				?>
				<div class="btn-group">
				  <a href="register.php" style="width:150px;" class="btn btn-success">Register</a>
				  <button type="submit" style="width:150px;" class="btn btn-info" name="login-btn" value="login-submit">Log In</button>
				</div>
			  </form>
			  </center>