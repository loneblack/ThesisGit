<?php
	session_start();
	require_once("db/mysql_connect.php");

	$serviceType = $_POST['serviceType'];
	$others = $_POST['others'];
	$details = $_POST['details'];
	$dateNeeded = $_POST['dateNeeded'];
	$endDate = $_POST['endDate'];

	$header =  $_SESSION['previousPage'];

	$sql = "INSERT INTO `thesis`.`service` (`details`, `dateNeed`, `endDate`, `UserID`, `serviceType`, `others`, `status`)
	                                VALUES ('{$details}', '{$dateNeeded}', '{$endDate}', '1', '{$serviceType}', '{$others}', '10');";//status is set to 10 for pending status
	$result0 = mysqli_query($dbc, $sql);

	$message = "Form submitted!";
	$_SESSION['submitMessage'] = $message;

	header('Location: '.$header);
?>