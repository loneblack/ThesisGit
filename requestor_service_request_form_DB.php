<?php
	session_start();
	require_once("db/mysql_connect.php");

	$userID = $_SESSION['userID'];

	$details = $_POST['details'];

	$header =  $_SESSION['previousPage'];

	date_default_timezone_set("Asia/Singapore");

    $value = date("Y/m/d");
    $time = date("h:i:sa");
    $date = date('Y-m-d H:i:s', strtotime($value." ".$time));

    $assets = $_POST['assets'];
    $serviceUnitAssets = $_POST['serviceUnit'];
    if (count($serviceUnitAssets) != 0){
    	$noServiceUnitAssets = array_diff($assets,$serviceUnitAssets);
	}else{
		$noServiceUnitAssets = $assets;
	}


    if(count($noServiceUnitAssets) > 0){//insertion of assets without service unit
	    //insertion to service table
		$sql = "INSERT INTO `thesis`.`service` (`details`, `dateReceived`, `UserID`, `serviceType`, `status`, `steps`, `replacementUnit`)
			                                VALUES ('{$details}', '{$date}', '{$userID}', '27', '1', '14', '0');";//status is set to 1 for pending status

		$result = mysqli_query($dbc, $sql);

		//get the id of previously inserted service  
		$sql1 = "SELECT MAX(id) as 'id' FROM thesis.service;";//status is set to 1 for pending status
		$result1 = mysqli_query($dbc, $sql1);
		$row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
	    
	    $id = $row['id'];

		foreach ($noServiceUnitAssets as $assets){
				
			$query = "INSERT INTO `thesis`.`servicedetails` (`serviceID`, `asset`, `replaced`) VALUES ('{$id}', '{$assets}', '0');";
			$resulted = mysqli_query($dbc, $query);

			//set asset status to for repair(9)
			$query2 = "UPDATE `thesis`.`asset` SET `assetStatus` = '9' WHERE (`assetID` = '{$assets}');";
			$resulted2 = mysqli_query($dbc, $query2);
	    }
    }
    foreach ($serviceUnitAssets as $assets) {//insertion of assets with service unit
    	//insertion to service table
		$sql = "INSERT INTO `thesis`.`service` (`details`, `dateReceived`, `UserID`, `serviceType`, `status`, `steps`, `replacementUnit`)
	                                VALUES ('{$details}', '{$date}', '{$userID}', '27', '1', '14', '1');";//status is set to 1 for pending status

		$result = mysqli_query($dbc, $sql);

		//get the id of previously inserted service  
		$sql1 = "SELECT MAX(id) as 'id' FROM thesis.service;";//status is set to 1 for pending status
		$result1 = mysqli_query($dbc, $sql1);
		$row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
	    
	    $id = $row['id'];

	    //insert to serviceUnit
    	$sql = "INSERT INTO `thesis`.`serviceUnit` (`serviceID`, `statusID`, `UserID`, `dateNeeded`)
	                                VALUES ('{$id}', '1', '{$userID}', DATE_ADD(NOW(), INTERVAL 3 DAY));";//status is set to 1 for pending status

		$result = mysqli_query($dbc, $sql);

		//get newly inserted service unit
	    $sql1 = "SELECT MAX(serviceUnitID) as 'serviceUnitID' FROM thesis.serviceUnit;"; //status is set to 1 for pending status
		$result1 = mysqli_query($dbc, $sql1);
		$row = mysqli_fetch_array($result1, MYSQLI_ASSOC);

	    $serviceUnitID = $row['serviceUnitID'];
	    
	    //insert to service details
    	$query = "INSERT INTO `thesis`.`servicedetails` (`serviceID`, `asset`, `replaced`) VALUES ('{$id}', '{$assets}', '0');";
    	$resulted = mysqli_query($dbc, $query);

    	//set asset status to for repair(9)
		$query2 = "UPDATE `thesis`.`asset` SET `assetStatus` = '9' WHERE (`assetID` = '{$assets}');";
		$resulted2 = mysqli_query($dbc, $query2);

		//Insert assets to serviceUnit Details also
		$insertServiceUnitDetails = "INSERT INTO serviceUnitDetails (serviceUnitID, assetID, received) VALUES ('{$serviceUnitID}', '{$assets}', '0');";
		$resulted4 = mysqli_query($dbc, $insertServiceUnitDetails);
    }

	$message = "Form submitted!";
	$_SESSION['submitMessage'] = $message;

	header('Location: '.$header);
?>	