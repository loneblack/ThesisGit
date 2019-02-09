<?php
	session_start();
	require_once('db/mysql_connect.php');
	
	$header =  $_SESSION['previousPage1'];
	
	$canvasItemID=$_POST['cavasItemID'];
	$supplier=$_POST['supplier'];
	$unitPrice=$_POST['unitPrice'];
	$count = sizeof($canvasItemID);
	$qty=$_POST['qty'];
	
	for ($i=0; $i < $count; $i++) { 
		$querya="INSERT INTO `thesis`.`canvasitemdetails` (`cavasItemID`, `supplier_supplierID`, `price`, `status`, `quantity`) VALUES ('{$canvasItemID[$i]}', '{$supplier[$i]}', '{$unitPrice[$i]}', '1','{$qty[$i]}')";
		$resulta=mysqli_query($dbc,$querya);
	}
		
	$queryReqID="SELECT requestID FROM thesis.canvas where canvasID='{$_SESSION['canvasID']}'";
	$resultReqID=mysqli_query($dbc,$queryReqID);
	$rowReqID=mysqli_fetch_array($resultReqID,MYSQLI_ASSOC);
		
	$queryd="UPDATE `thesis`.`request` SET `step`='6' WHERE `requestID`='{$rowReqID['requestID']}'";
	$resultd=mysqli_query($dbc,$queryd);
		
	$message = "Form submitted!";
	$_SESSION['submitMessage'] = $message;
		
	//$queryb="UPDATE `thesis`.`canvas` SET `status`='6' WHERE `canvasID`='{$canvasID}'";
	//$resultb=mysqli_query($dbc,$queryb);
		
	//$queryc="SELECT requestID FROM thesis.canvas where canvasID='{$canvasID}'";
	//$resultc=mysqli_query($dbc,$queryc);
	//$rowc=mysqli_fetch_array($resultc,MYSQLI_ASSOC);
		
	//$queryd="UPDATE `thesis`.`request` SET `status`='6' WHERE `requestID`='{$rowc['requestID']}'";
	//$resultd=mysqli_query($dbc,$queryd);
	

	header('Location: '.$header);


?>