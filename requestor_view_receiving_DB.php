<?php
	session_start();
	require_once("db/mysql_connect.php");

	$userID = $_SESSION['userID'];

	$receivingID = $_GET['id'];

	date_default_timezone_set("Asia/Singapore");

    $value = date("Y/m/d");
    $time = date("h:i:sa");
    $date = date('Y-m-d H:i:s', strtotime($value." ".$time));

   	//Updating of received assets
    if (isset($_POST['assets'])) {
    	//insert assets to service details from select box
		foreach ($_POST['assets'] as $assets){

			$sql1 = "SELECT * FROM thesis.receiving_details WHERE receivingID = '{$receivingID}' AND assetID = '{$assets}';";
			$result1 = mysqli_query($dbc, $sql1);
			$row = mysqli_fetch_array($result1, MYSQLI_ASSOC);

			$receivingDetailsID = $row['id'];
			
	    	$sql = "UPDATE `thesis`.`receiving_details` SET `received` = '1' WHERE (`id` = '{$receivingDetailsID}');";
			$result = mysqli_query($dbc, $sql);
			
			//UPDATE ASSET STATUS
			$queryStat="UPDATE `thesis`.`asset` SET `assetStatus`='2' WHERE `assetID`='{$assets}'";
			$resultStat=mysqli_query($dbc,$queryStat);
			
			//INSERT TO ASSET AUDIT
			$queryAssAud="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `assetStatus`) VALUES ('{$_SESSION['userID']}', now(), '{$assets}', '2');";
			$resultAssAud=mysqli_query($dbc,$queryAssAud);
			
		}
    }

    //if all checked change status to done
    //check total asset entries
   	$sqlTotal = "SELECT COUNT(*) as 'total' FROM thesis.receiving_details WHERE receivingID = '{$receivingID}';";
   	$resultTotal = mysqli_query($dbc, $sqlTotal);
	$rowTotal = mysqli_fetch_array($resultTotal, MYSQLI_ASSOC);

	//check received assets
	$sqlReceived = "SELECT COUNT(*) as 'received' FROM thesis.receiving_details WHERE receivingID = '{$receivingID}' AND received = 1;";
	$resultReceived = mysqli_query($dbc, $sqlReceived);
	$rowReceived = mysqli_fetch_array($resultReceived, MYSQLI_ASSOC);

	if($rowReceived['received'] == $rowTotal['total']){//change statuse to done

		$sqlstatus = "UPDATE `thesis`.`requestor_receiving` SET `statusID` = '3' WHERE (`id` = '{$receivingID}');";
		$resultstatus = mysqli_query($dbc, $sqlstatus);
		
	}
	if(($rowReceived['received'] < $rowTotal['total']) && ($rowReceived['received'] != $rowTotal['total'])){//if partial delivery

		$sqlstatus = "UPDATE `thesis`.`requestor_receiving` SET `statusID` = '4' WHERE (`id` = '{$receivingID}');";
		$resultstatus = mysqli_query($dbc, $sqlstatus);
	}

    //update the request/borrow to done
    //get the borrowID/requestID
    $sql = "SELECT * FROM thesis.requestor_receiving WHERE id = {$receivingID};";
	$result = mysqli_query($dbc, $sql);

	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

	        $borrowID = $row['borrowID'];
	        $requestID = $row['requestID'];
	        $serviceUnitID = $row['serviceUnitID'];
	    }

	if($borrowID > 0)//have borrow
	{
	  	
	    $sql = "UPDATE `thesis`.`request_borrow` SET `statusID` = '3', `steps` = '21' WHERE (`borrowID` = '{$borrowID}');";
	    $result = mysqli_query($dbc, $sql);
	}
	if($requestID > 0)//have request
	{

	    $sql = "UPDATE `thesis`.`request` SET `status` = '3', `step` = '21' WHERE (`requestID` = '{$requestID}');";
	    $result = mysqli_query($dbc, $sql);
	}
	if($serviceUnitID > 0)//have service unit
	{

	    $sql = "UPDATE `thesis`.`serviceUnit` SET `status` = '3' WHERE (`serviceUnitID` = '{$serviceUnitID}');";
	    $result = mysqli_query($dbc, $sql);
	}

    $header = "requestor_view_receiving.php?id=".$receivingID;
	$message = "Form submitted!";
	$_SESSION['submitMessage'] = $message;

	header('Location: '.$header);
?>	