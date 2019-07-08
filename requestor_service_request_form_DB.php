<?php
	session_start();
	require_once("db/mysql_connect.php");

	$userID = $_SESSION['userID'];

	$header =  $_SESSION['previousPage'];

	date_default_timezone_set("Asia/Singapore");

    $value = date("Y/m/d");
    $time = date("h:i:sa");
    $date = date('Y-m-d H:i:s', strtotime($value." ".$time));

    $assets = $_POST['assets'];
    $serviceUnitAssets = $_POST['serviceUnit'];
    $problem = $_POST['problem'];

    for ($i=0; $i < sizeof($assets); $i++) { 
    	if($assets[$i] != 0){
    		array_splice($assets, ($i+1), 1);
    	}
    }
    for ($i=0; $i < sizeof($serviceUnitAssets); $i++) { 
    	if($serviceUnitAssets[$i] != 0){
    		array_splice($serviceUnitAssets, ($i+1), 1);
    	}
    }
    
    $noServiceUnitAssets = 0;

    for ($i=0; $i < sizeof($serviceUnitAssets); $i++) { 


    	if($serviceUnitAssets[$i] == 0 && $assets[$i] != 0){
    		$noServiceUnitAssets = 1;

    	}

    	echo $i." - ";
    	echo $serviceUnitAssets[$i]." - ";
    	echo $assets[$i]." - ";
    	echo $noServiceUnitAssets."|";
    }

    echo "<br>";
    print_r($serviceUnitAssets);
    echo "<br>";
    print_r($assets);
    echo "<br>";
    echo $noServiceUnitAssets."<br>";


    if($noServiceUnitAssets == 1){//insertion of assets without service unit
	    //insertion to service table
		$sql = "INSERT INTO `thesis`.`service` (`details`, `dateReceived`, `UserID`, `serviceType`, `status`, `steps`, `replacementUnit`)
			                                VALUES ('{$details}', '{$date}', '{$userID}', '27', '1', '14', '0');";//status is set to 1 for pending status
			
		$result = mysqli_query($dbc, $sql);

		echo $sql." - no service unit <br>";

		//get the id of previously inserted service  
		$sql1 = "SELECT MAX(id) as 'id' FROM thesis.service;";//status is set to 1 for pending status
		$result1 = mysqli_query($dbc, $sql1);
		$row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
	    
	    $id = $row['id'];

    for ($i=0; $i < sizeof($assets); $i++) {

    	if($serviceUnitAssets[$i] == 0 &&  $assets[$i] != 0) {

				$query = "INSERT INTO `thesis`.`servicedetails` (`serviceID`, `asset`, `replaced`, `problem`) VALUES ('{$id}', '{$assets[$i]}', '0', '{$problem[$i]}');";
				$resulted = mysqli_query($dbc, $query);
				echo $sql." - no service unit details <br>";


				//set asset status to for repair(9)
				$query2 = "UPDATE `thesis`.`asset` SET `assetStatus` = '9' WHERE (`assetID` = '{$assets[$i]}');";
				$resulted2 = mysqli_query($dbc, $query2);
    		}
				
	    }
    }
    for ($i=0; $i < sizeof($serviceUnitAssets); $i++) { //insertion of assets with service unit

    	if($serviceUnitAssets[$i] != 0){

    	//insertion to service table
		$sql = "INSERT INTO `thesis`.`service` (`details`, `dateReceived`, `UserID`, `serviceType`, `status`, `steps`, `replacementUnit`)
	                                VALUES ('{$problem[$i]}', '{$date}', '{$userID}', '27', '1', '14', '1');";//status is set to 1 for pending status

		$result = mysqli_query($dbc, $sql);
		echo $sql." - service unit <br>";

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
    	$query = "INSERT INTO `thesis`.`servicedetails` (`serviceID`, `asset`, `replaced`, `problem`) VALUES ('{$id}', '{$serviceUnitAssets[$i]}', '0', '{$problem[$i]}');";
    	$resulted = mysqli_query($dbc, $query);

    	echo $query." - service unit details<br>";
    	//set asset status to for repair(9)
		$query2 = "UPDATE `thesis`.`asset` SET `assetStatus` = '9' WHERE (`assetID` = '{$serviceUnitAssets[$i]}');";
		$resulted2 = mysqli_query($dbc, $query2);

		//Insert assets to serviceUnit Details also
		$insertServiceUnitDetails = "INSERT INTO serviceUnitDetails (serviceUnitID, assetID, received) VALUES ('{$serviceUnitID}', '{$serviceUnitAssets[$i]}', '0');";
		$resulted4 = mysqli_query($dbc, $insertServiceUnitDetails);
    	}
    }

	$message = "Form submitted!";
	$_SESSION['submitMessage'] = $message;

	header('Location: '.$header);
?>	