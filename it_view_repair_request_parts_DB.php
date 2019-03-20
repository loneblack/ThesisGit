<?php
	session_start();
	require_once('db/mysql_connect.php');

	$header =  $_SESSION['previousPage'];

	$id = $_GET['id'];
	$assets=$_POST['assets'];


	$sql = "UPDATE `thesis`.`requestparts` SET `statusID` = '2' WHERE (`id` = '{$id}');";
    $result = mysqli_query($dbc, $sql);

    foreach($assets as $asset){
    	$sql = "INSERT INTO `thesis`.`requestparts_assets` VALUES ('{$id}', '{$asset}');";
    	$result = mysqli_query($dbc, $sql);

    	$sql = "UPDATE `thesis`.`asset` SET `assetStatus` = '3' WHERE (`assetID` = '{$asset}');";
    	$result = mysqli_query($dbc, $sql);

    	echo $sql;
    }

	$message = "Form submitted!";
	$_SESSION['submitMessage'] = $message;
	
	header('Location: '.$header);

?>