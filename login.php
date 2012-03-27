<?php
	//required info
	include('config.php');
	
	
	//connect to the database
	$connection=mysql_connect($databaseHostName,$databaseUserName,$databaseUserPassword)
		or print "connect failed because ".mysql_error();  
		
    mysql_select_db($databaseName,$connection)
		or print "select failed because ".mysql_error();
		
		
	//username and password from user	
	$userName = mysql_real_escape_string($_POST['userName']);
	$password = mysql_real_escape_string($_POST['password']);

	
	//compare user input to database
	$userQuery = mysql_fetch_row(mysql_query("SELECT * FROM $userTableName WHERE userName='$userName' AND userPassword='$password'"));
	
	
	//if a match is found run this
	if(sizeof($userQuery[0]) > 0)
	{
			//disconnect from database
			mysql_close($connection);
			
			//create cookie to track current user
			setcookie("isLoged", 'yes', time()+2419200);
			setcookie("userName", $userName, time()+2419200);

			// Redirect to login page
			header("Location: $loginPage");
			exit();
	} 	
	//if no match found run this
	else 
	{
			print "
			<table width='100%' border='1' align='center' cellpadding='5' cellspacing='0' bordercolor='#99CC33'>
				<tr bgcolor='pink'> 
					<td colspan='2'><div align='center'><strong>Invalid username and/or password!</strong></div></td>
				</tr>
			</table>";
	}
	
	//disconnect from database
	mysql_close($connection);
?>