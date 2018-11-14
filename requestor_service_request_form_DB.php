<?php
	session_start();
	require_once("db/mysql_connect.php");

	$userID = $_SESSION['userID'];

	$serviceType = $_POST['serviceType'];
	$others = $_POST['others'];
	$details = $_POST['details'];
	$dateNeeded = $_POST['dateNeeded'];
	$endDate = $_POST['endDate'];

	$header =  $_SESSION['previousPage'];

	 date_default_timezone_set("Asia/Singapore");

    $value = date("Y/m/d");
    $time = date("h:i:sa");
    $date = date('Y-m-d H:i:s', strtotime($value." ".$time));

	$sql = "INSERT INTO `thesis`.`service` (`details`, `dateNeed`, `endDate`, `dateReceived`, `UserID`, `serviceType`, `others`, `status`)
	                                VALUES ('{$details}', '{$dateNeeded}', '{$endDate}', '{$date}', '{$userID}', '{$serviceType}', '{$others}', '1');";//status is set to 1 for pending status
	$result = mysqli_query($dbc, $sql);

	$message = "Form submitted!";
	$_SESSION['submitMessage'] = $message;

	header('Location: '.$header);
?>	