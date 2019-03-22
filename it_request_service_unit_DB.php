<?php
	session_start();
	require_once('db/mysql_connect.php');

	$header =  $_SESSION['previousPage'];

	$id = $_GET['id'];
	$assets=$_POST['assets'];

    //update service unit status
    $sql = "UPDATE `thesis`.`serviceUnit` SET `statusID` = '2' WHERE (`serviceUnitID` = '{$id}');";
    $result = mysqli_query($dbc, $sql);

    //get requestor user id using service id
    $sql = "SELECT * FROM `thesis`.`serviceUnit`;";
    $result = mysqli_query($dbc, $sql);
    $row=mysqli_fetch_array($result, MYSQLI_ASSOC);

    $UserID = $row['UserID'];
    //insert to delivery

    //insert to requestor receiving 
    $sql = "INSERT INTO `thesis`.`requestor_receiving` (`UserID`, `serviceUnitID`, `statusID`) VALUES ('{$UserID}', '{$id}', '2');";
    $result = mysqli_query($dbc, $sql);

    //get newly inserted id from service
    $sql = "SELECT *, MAX(id) as 'id' FROM thesis.requestor_receiving;";
    $result = mysqli_query($dbc, $sql);
    $row=mysqli_fetch_array($result, MYSQLI_ASSOC);

    $receivingID = $row['id'];

    foreach($assets as $asset){
    	$sql = "INSERT INTO `thesis`.`serviceunitassets` (`serviceUnitID`, `assetID`, `received`) VALUES ('{$id}', '{$asset}', '0');";
    	$result = mysqli_query($dbc, $sql);


    	$sql = "INSERT INTO `thesis`.`receiving_details` (`receivingID`, `assetID`, `received`) VALUES ('{$receivingID}', '{$asset}', '0');";
    	$result = mysqli_query($dbc, $sql);
            echo $sql;
    	$sql = "UPDATE `thesis`.`asset` SET `assetStatus` = '3' WHERE (`assetID` = '{$asset}');";
    	$result = mysqli_query($dbc, $sql);

    }
	

	$message = "Form submitted!"; 
	$_SESSION['submitMessage'] = $message;
	
	header('Location: '.$header);

?>