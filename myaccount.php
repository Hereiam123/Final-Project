<?php
	//required info
	include('config.php');
	
	//get current user
	$user = $_COOKIE["userName"];
	
	//connect to the database
	$connection=mysql_connect($databaseHostName,$databaseUserName,$databaseUserPassword)
		or print "connect failed because ".mysql_error();  
		
    mysql_select_db($databaseName,$connection)
		or print "select failed because ".mysql_error();
	
	//print current user medication info
	$result = mysql_query("SELECT * FROM usermeds WHERE username='$user'");
	
	print '<!DOCTYPE html> 
	<html> 
		<head> 
		<title>MedTrack Meds</title> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0-rc.1/jquery.mobile-1.1.0-rc.1.min.css" />
		<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.1.0-rc.1/jquery.mobile-1.1.0-rc.1.min.js"></script>
	</head> 
	<body> 

	<div data-role="page">

	<div data-role="header">
		<h1>Med List</h1>
	</div>
	
	<div data-role="header">
		<a href="logoff.php" data-role="button" data-mini="true">Log Off</a><h2>Welcome '.$user.'</h2>
	</div>

	<div data-role="content">
	
	<div id="medList">';
	
	while($row = mysql_fetch_array($result)) 
	{
		print "<br/>";
		print "<div class='med'>";
		print "<p> Medication Name: " . $row['medName'] . "</p>";
		print "<p> Amount to Take: " . $row['toTake'] . " pill(s)</p>";
		print "<p> Amount in Bottle: " . $row['perBottle']. " pill(s)</p>";
		print "<a href='' data-role='button' data-icon='delete' data-inline='true' data-mini='true' class='ui-btn-right'>Delete</a>";
		print "</div>";
		print "<br/>";
	}
	
	print '</div>
	<div data-role="collapsible" data-icon="plus">
		<h3>Add Medication</h3>
		<form id="" action="myaccount.php" method="post">
			<label for="medName">Medication Name:</label>
			<input type="text" name="medName" id="medName" data-mini="true" />
			
			<label for="toTake">Number to Take:</label>
			<input type="text" name="toTake" id="toTake" data-mini="true" />
			
			<label for="perBottle">Number in Bottle:</label>
			<input type="text" name="perBottle" id="perBottle" data-mini="true" />
		
			<input type="submit" name="submit" value="Submit" />
		</form>
	</div>
	</div>
	</div>

	</body>
	</html>';
	
	//if user has posted a new medication run thiss	
	if (isset($_POST['submit']))
	{ 		
		//new medication info from user
		$medName = mysql_real_escape_string($_POST['medName']);
		$toTake = mysql_real_escape_string($_POST['toTake']);
		$perBottle = mysql_real_escape_string($_POST['perBottle']);
		
		//add new info to database
		$addMedlist = mysql_query("INSERT INTO $medTableName (userName, medName, toTake, perBottle) VALUES ('$user','$medName', $toTake, $perBottle)");
		header("Location: $loginPage");
	}
?>