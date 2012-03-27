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
	if($userQuery[0] > 0){
	
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
	else {
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

<html>
	<head>
	</head>
	
	<body>
	
		<!--Login Form-->
		<form action="login.php" method="post" name="register" id="register" style="display:inline;">
			<table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#99CC33">
				<tr bgcolor="#99CC99"> 
					<td colspan="2"><div align="center"><strong>Please log in:</strong></div></td>
				</tr>
				<tr> 
					<td width="47%"><strong>Username:</strong></td>
					<td width="53%"><input name="userName" type="text" id="userName"></td>
				</tr>
				<tr> 
					<td><strong>Password:</strong></td>
					<td><input name="password" type="password" id="password"></td>
				</tr>
				<tr> 
					<td colspan="2">
						<input name="Submit" type="submit" id="Submit" value="Sign-In">
					</td>
				</tr>
			</table>
		</form>
	
		<!--Registration Form-->
		<form action="register.php" method="post" name="register" id="register" style="display:inline;">
			  <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#99CC33">
					<tr bgcolor="#99CC99"> 
						<td colspan="2"><div align="center"><strong>Please enter registration information: </strong></div></td>
					</tr>
					<tr> 
						<td width="47%"><strong>Username:</strong></td>
						<td width="53%"><input name="userName" type="text" id="userName"></td>
					</tr>
					<tr> 
						<td><strong>Password:</strong></td>
						<td><input name="password" type="password" id="password"></td>
					</tr>
					<tr>
						<td><strong>Re-enter password: </strong></td>
						<td><input name="password2" type="password" id="password2" /></td>
					</tr>
					<tr> 
						<td colspan="2" class="regsubmit">
							<input name="Submit" type="submit" id="Submit" value="Register">
						</td>
					</tr>
			  </table>
		</form>
		
	</body>
</html>