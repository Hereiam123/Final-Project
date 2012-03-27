<?php
	//required info
	include('config.php');
	
	//get current user
	$user = $_COOKIE["userName"];
	
	//welcome message
	print "welcome back $user";
	
	
	//connect to the database
	$connection=mysql_connect($databaseHostName,$databaseUserName,$databaseUserPassword)
		or print "connect failed because ".mysql_error();  
		
    mysql_select_db($databaseName,$connection)
		or print "select failed because ".mysql_error();

		
	//if user has posted a new medication run thiss	
	if (isset($_POST['Add'])){ 		
		
		//new medication info from user
		$medName = mysql_real_escape_string($_POST['medName']);
		$toTake = mysql_real_escape_string($_POST['toTake']);
		$perBottle = mysql_real_escape_string($_POST['perBottle']);
		
		//add new info to database
		$addMedlist = mysql_query("INSERT INTO $medTableName (userName, medName, toTake, perBottle) VALUES ('$user','$medName', $toTake, $perBottle)");
	}
	
	//print current user medication info
	$result = mysql_query("SELECT * FROM usermeds WHERE username='$user'");
	
	print "<table border='1'>
			<tr>
				<th>Med</th>
				<th>To Take</th>
				<th>Per Bottle</th>
			</tr>";

	while($row = mysql_fetch_array($result)) {
		print "<tr>";
		print "<td>" . $row['medName'] . "</td>";
		print "<td>" . $row['toTake'] . "</td>";
		print "<td>" . $row['perBottle'] . "</td>";
		print "</tr>";
	}
	
	print "</table>";
?>
<html>
	<head>
	</head>
	
	<body>
	
		<!--Add Medication Form-->
		<a href="logoff.php">log off</a>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="register" id="register" style="display:inline;">
			<table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#99CC33">
				<tr bgcolor="#99CC99"> 
					<td colspan="2"><div align="center"><strong>Please log in:</strong></div></td>
				</tr>
				<tr> 
					<td width="47%"><strong>MedName:</strong></td>
					<td width="53%"><input name="medName" type="text" id="userName"></td>
				</tr>
				<tr> 
					<td width="47%"><strong>PerBottle:</strong></td>
					<td width="53%"><input name="perBottle" type="text" id="userName"></td>
				</tr>
				<tr> 
					<td width="47%"><strong>To Take:</strong></td>
					<td width="53%"><input name="toTake" type="text" id="userName"></td>
				</tr>
				<tr> 
					<td width="47%"><strong>How Often:</strong></td>
					<td width="53%"><input name="often" type="text" id="userName"></td>
				</tr>
				<tr> 
					<td colspan="2">
						<input name="Add" type="submit" id="Submit" value="Add">
					</td>
				</tr>
			</table>
		</form>
		
	</body>
</html>