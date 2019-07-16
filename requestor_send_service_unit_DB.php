<?php
	session_start();
	require_once('db/mysql_connect.php');

	$header =  $_SESSION['previousPage'];
	$userID = $_SESSION['userID'];

	$assets=$_POST['assets'];
	$comments=$_POST['comments'];
	$status=$_POST['status'];
	$serviceUnitID=$_POST['serviceUnitID'];

	$message = "No asset Selected!";
	$_SESSION['submitStatus'] = 0;

	for ($i=0; $i < sizeof($assets); $i++) { 
	   	if($assets[$i] != 0){
	 		array_splice($assets, ($i+1), 1);
	    }
    }

    $notEmpty = 0;
	$count = sizeof($assets);
    
    for ($i=0; $i < $count; $i++) { 
		if($assets[$i] != 0)
		{
			$notEmpty = 1;
		}
	}
		
	
	if($notEmpty == 1){

	
	for ($i=0; $i < $count; $i++) { 
		if($assets[$i] != 0)
		{
			//make an asset return enrty
			$query="UPDATE `thesis`.`serviceunit` SET `returned` = '1', `dateReturn` = now()  WHERE (`serviceUnitID` = '{$serviceUnitID[$i]}');";
			$result=mysqli_query($dbc,$query);

			echo $query;
			//insert data to asset return details
			$querya="UPDATE `thesis`.`serviceunitassets` SET `isWorking` = '{$status[$i]}', `comments` = '{$comments[$i]}' WHERE (`serviceUnitID` = '{$serviceUnitID[$i]}') AND (`assetID` = '{$assets[$i]}');";
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

			$_SESSION['submitStatus'] = 1;
			$message = "Form submitted!";
		}	
		
	}


	}
	$_SESSION['submitMessage'] = $message;
	
	header('Location: '.$header);

?>