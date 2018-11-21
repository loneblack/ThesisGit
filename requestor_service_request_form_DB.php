<?php
	session_start();
	require_once("db/mysql_connect.php");

	$userID = $_SESSION['userID'];

	$serviceType = $_POST['serviceType'];
	$others = $_POST['others'];
	$summary = $_POST['summary'];
	$details = $_POST['details'];
	$dateNeeded = $_POST['dateNeeded'];
	$endDate = $_POST['endDate'];

	$header =  $_SESSION['previousPage'];

	date_default_timezone_set("Asia/Singapore");

    $value = date("Y/m/d");
    $time = date("h:i:sa");
    $date = date('Y-m-d H:i:s', strtotime($value." ".$time));

    //insertion to service table
	$sql = "INSERT INTO `thesis`.`service` (`summary`, `details`, `dateNeed`, `endDate`, `dateReceived`, `UserID`, `serviceType`, `others`, `status`, `steps`)
	                                VALUES ('{$summary}', '{$details}', '{$dateNeeded}', '{$endDate}', '{$date}', '{$userID}', '{$serviceType}', '{$others}', '1', '14');";//status is set to 1 for pending status

	$result = mysqli_query($dbc, $sql);

	echo $sql;

	//get the id of previously inserted service
	$sql1 = "SELECT MAX(id) as 'id' FROM thesis.service;";//status is set to 1 for pending status

	$result1 = mysqli_query($dbc, $sql1);

	while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)){
        $id = $row['id'];
    }

    if (isset($_POST['assets'])) {
    	//insert assets to service details from select box
		foreach ($_POST['assets'] as $assets){
			
	    	$query = "INSERT INTO `thesis`.`servicedetails` (`serviceID`, `asset`) VALUES ('{$id}', '{$assets}');";
	    	$resulted = mysqli_query($dbc, $query);

	    	//set asset status to for repair(9)
			$query2 = "UPDATE `thesis`.`asset` SET `assetStatus` = '9' WHERE (`assetID` = '{$assets}');";
			$resulted2 = mysqli_query($dbc, $query2);

		}
    }

	$result1 = mysqli_query($dbc, $sql1);
	$message = "Form submitted!";
	$_SESSION['submitMessage'] = $message;

	header('Location: '.$header);
?>	