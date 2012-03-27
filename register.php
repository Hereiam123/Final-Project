<?php
	//required info
	include('config.php');
	
	
	//connect to the database
	$connection=mysql_connect($databaseHostName,$databaseUserName,$databaseUserPassword)
		or print "connect failed because ".mysql_error();  
		
    mysql_select_db($databaseName,$connection)
		or print "select failed because ".mysql_error();
		
	//username and password from user
	$userName = mysql_real_escape_string($_GET['userName']);
	$password = mysql_real_escape_string($_GET['password']);
	$passwordCheck = mysql_real_escape_string($_GET['passwordAgain']);
	
	
	//get current list of users
	$userQuery = mysql_fetch_row(mysql_query("SELECT * FROM $userTableName WHERE userName='$userName'"));
	
	
	//if username already exists run this
	if(sizeof($userQuery[0]) > 0){
			mysql_close($connection);
			print "
			<table width='100%' border='1' align='center' cellpadding='5' cellspacing='0' bordercolor='#99CC33'>
				<tr bgcolor='pink'> 
					<td colspan='2'><div align='center'><strong>Username already taken!</strong></div></td>
				</tr>
			</table>";
		} 
	else if($passwordCheck!=$password)
	{
			mysql_close($connection);
			print "
			<table width='100%' border='1' align='center' cellpadding='5' cellspacing='0' bordercolor='#99CC33'>
				<tr bgcolor='pink'> 
					<td colspan='2'><div align='center'><strong>Passwords do not match!</strong></div></td>
				</tr>
			</table>";
	}
	// if not match found run this
	else 
	{		
			//add user to database
			$addUser = mysql_query("INSERT INTO `userlist` (`userName`,`userPassword`) VALUES ('$userName','$password')");
			
			//log user in and create cookie to track current user
			setcookie("isLoged", 'yes', time()+2419200);
			setcookie("userName", $userName, time()+2419200);
			
			//disconnect from database
			mysql_close($connection);
			
			//redirect to login page
			header("Location: $loginPage");
			exit();
	}
?>