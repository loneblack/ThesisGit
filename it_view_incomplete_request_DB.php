<?php
	session_start();
	require_once('db/mysql_connect.php');

	$header =  $_SESSION['previousPage2'];
	$quantityArray=$_POST['qty'];
	$desc=$_POST['desc'];
	$categoryArray=$_POST['category'];
	$brandArray=$_POST['brand'];
	$modelArray=$_POST['model'];
	$specsArray=$_POST['specs'];
	
	$count = sizeof($modelArray);
	
	$queryx="INSERT INTO `thesis`.`canvas` (`requestID`, `status`) VALUES ('{$_SESSION['requestID']}', '1')";
	$resultx=mysqli_query($dbc,$queryx);
	
	$queryy="SELECT * FROM thesis.canvas order by canvasID desc";
	$resulty=mysqli_query($dbc,$queryy);
	$rowy=mysqli_fetch_array($resulty,MYSQLI_ASSOC);
	
	//auto increment for canvasItemID
	for ($i=0; $i < $count; $i++) { 
		$querya="INSERT INTO `thesis`.`canvasitem` (`canvasID`, `quantity`, `description`, `assetCategory`, `assetModel`) VALUES ('{$rowy['canvasID']}', '{$quantityArray[$i]}', '{$desc[$i]}', '{$categoryArray[$i]}', '{$modelArray[$i]}')";
		$resulta=mysqli_query($dbc,$querya);
	}
	
	$queryz="UPDATE `thesis`.`request` SET `step`='3' WHERE `requestID`='{$_SESSION['requestID']}'";
	$resultz=mysqli_query($dbc,$queryz);
	
	$message = "Form submitted!";
	$_SESSION['submitMessage'] = $message;
	
	header('Location: '.$header);

?>