<?php
	session_start();
	require_once('db/mysql_connect.php');

	$header =  $_SESSION['previousPage'];
	$userID = $_SESSION['userID'];

	$assets=$_POST['assets'];
	$comments=$_POST['comments'];

	for ($i=0; $i < sizeof($assets); $i++) { 
	   	if($assets[$i] != 0){
	 		array_splice($assets, ($i+1), 1);
	    }
    }

	
	$count = sizeof($assets);
	
	//make an asset return enrty
	$query="INSERT INTO `thesis`.`assetreturn` (`UserID`, `dateTime`, `statusID`) VALUES ('{$userID}', now(), '1');";
	$result=mysqli_query($dbc,$query);

	//get newly inserted data from table
	$sql = "SELECT * FROM thesis.assetreturn ORDER BY assetReturnID DESC LIMIT 1;";
	$result = mysqli_query($dbc, $sql);
	$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

	$assetReturnID = $row['assetReturnID'];
	
	for ($i=0; $i < $count; $i++) { 
		if($assets != 0)
		{
			$querya="INSERT INTO `thesis`.`assetreturndetails` (`assetReturnID`, `comments`, `assetID`) VALUES ('{$assetReturnID}', '{$comments[$count]}', '{$assets[$count]}');";
			$resulta=mysqli_query($dbc,$querya);
		}
		
	}
	
	$message = "Form submitted!";
	$_SESSION['submitMessage'] = $message;
	
	header('Location: '.$header);

?>