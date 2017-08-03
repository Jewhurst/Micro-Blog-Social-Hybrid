<nav class="navbar navbar-light bgclr-orange">
  <a class="navbar-brand" href="<?php echo HOME;?>"><span class="boldme clr-brown  fontx1p3"><img src="<?php echo HOME . UPLOADS;?>blotterwall-logo4.png" width="125px" alt="Blotter Wall" ></a>
  <ul class="nav navbar-nav ">
	<li class="nav-item active">
	  <a class="nav-link " href="<?php echo HOME;?>"><span class="clr-white boldme">Home</span> <span class="sr-only">(current)</span></a>
	</li>
	<li class="nav-item dropdown">
	  <a class="nav-link dropdown-toggle clr-white" href="#" id="supportedContentDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="clr-white boldme">Profile</span></a>
	  <div class="dropdown-menu " aria-labelledby="supportedContentDropdown">
	  <?php echo  (isLoggedIn()?'<a class="dropdown-item" href="'.HOME.'edit-profile.php">Edit Profile</a>':'<a class="dropdown-item" href="'.HOME.'register.php">Register</a>'); ?>
		
		<div class="dropdown-divider"></div>
		<a class="dropdown-item" href="<?php echo (isLoggedIn()?HOME.'logout.php': HOME.'login.php') ;?>"><?php echo (isLoggedIn()?stringtable("common","logout"):stringtable("common","login")) ;?></a>
		<a class="dropdown-item" href="#"></a>
	  </div>
	</li>
  </ul>
  
  
  <form class="form-inline" style="float:right;">
   <div class="input-group">
	  <input type="text" class="form-control" placeholder="Search for...">
	  <span class="input-group-btn">
		<button class="btn bgclr-brown clr-white boldme kaushan" type="button"><?php echo stringtable("common","search"); ?></button>
	  </span>
	</div>
  
  </form>
</nav>
<br class="clear">