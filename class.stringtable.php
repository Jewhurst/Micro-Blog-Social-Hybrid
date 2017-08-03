<?php
define(LANG,"eng");


	global $lang;
	$lang = array (
	
		"site" => array(
			 "contactme_v1" 	=> array(LANG=>"Let's Talk"),
			 "emailsent" 		=> array(LANG=>"Email Sent"),
		),
		"common" => array(
			  "emailme" 	=> array(LANG=>"Contact Me"),
			  "myacc" 	=> array(LANG=>"MY ACCOUNT"),
			  "menu" 	=> array(LANG=>"Menu"),
			  "alerts" 	=> array(LANG=>"Alerts"),
			  "close" 	=> array(LANG=>"Close"),
			  "go" 		=> array(LANG=>"Go"),
			  "search" 	=> array(LANG=>"Search"),
			  "gohome" 	=> array(LANG=>"Go Home"),
			  "home" 	=> array(LANG=>"Home"),
			  "logout" 	=> array(LANG=>"Logout"),
			  "login" 	=> array(LANG=>"Login"),
			  "register" 	=> array(LANG=>"Register"),
			  "signup" 	=> array(LANG=>"Sign Up"),
			  "follow" 	=> array(LANG=>"Follow"),
			  "unfollow" 	=> array(LANG=>"Unfollow"),
			  "followers" 	=> array(LANG=>"Readers"),
			  "following" 	=> array(LANG=>"Following"),
			  "blotters" 	=> array(LANG=>"Blotters"),
			  "blotter" 	=> array(LANG=>"Blot It"),
		),
		"numToNth" => array(
			1 	=> array(LANG=>"First"),
			2 	=> array(LANG=>"Second"),
			3 	=> array(LANG=>"Third"),
			4 	=> array(LANG=>"Fourth"),
			5 	=> array(LANG=>"Fifth"),
			6 	=> array(LANG=>"Sixth"),
			7 	=> array(LANG=>"Seventh"),
			8 	=> array(LANG=>"Eighth"),
			9 	=> array(LANG=>"Ninth")
		),
	);
	function stringtable($cat,$word,$language = LANG) {
		global $lang;
		$str = $lang[$cat][$word][$language];
		return $str;		
	}
	
	/*
	 echo $lang['common']['close'][LANG];
	 echo stringtable('common','home');
	*/
?>