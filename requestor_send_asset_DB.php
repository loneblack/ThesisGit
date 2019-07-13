<?php
	session_start();
	require_once('db/mysql_connect.php');

	$header =  $_SESSION['previousPage'];
	$userID = $_SESSION['userID'];

	$assets=$_POST['assets'];
	$comments=$_POST['comments'];
	$status=$_POST['status'];

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
		if($assets[$i] != 0)
		{
			//insert data to asset return details
			$querya="INSERT INTO `thesis`.`assetreturndetails` (`assetReturnID`, `comments`, `assetID`, `isWorking`) VALUES ('{$assetReturnID}', '{$comments[$i]}', '{$assets[$i]}', '{$status[$i]}');";
			$resulta=mysqli_query($dbc,$querya);
			echo $querya;

			//set asset status to moving
			$querya="UPDATE `thesis`.`asset` SET `assetStatus` = '3' WHERE (`assetID` = '{$assets[$i]}');";
			$resulta=mysqli_query($dbc,$querya);
			echo $querya;

			//insert to audit
			$querya="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `assetStatus`) VALUES ('9', now(), '{$assets[$i]}', '3');";
			$resulta=mysqli_query($dbc,$querya);
			echo $querya;
		}
		
	}
	
	$message = "Form submitted!";
	$_SESSION['submitMessage'] = $message;
	
	header('Location: '.$header);

?>