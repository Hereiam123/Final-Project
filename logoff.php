<?php
	//required info
	include('config.php');
	
	//delete current user cookie
	setcookie("isLoged", '' ,time()-3600);
	setcookie("userName",'' , time()-3600);

	//redirect to logout page
	header("Location: $logoutPage");
	exit();
?>