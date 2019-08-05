<?php
	session_start();
	require_once("db/mysql_connect.php");

	$userID = $_SESSION['userID'];

	$receivingID = $_GET['id'];

	date_default_timezone_set("Asia/Singapore");

    $value = date("Y/m/d");
    $time = date("h:i:sa");
    $date = date('Y-m-d H:i:s', strtotime($value." ".$time));

    $assets = $_POST['assets'];
    $select = $_POST['select'];

    $brokenAssets = array();

	print_r($assets);
	print_r($select);    
    for ($i=0; $i < sizeof($select); $i++) { 
    	if($select[$i] != 0){
    		array_splice($select, ($i+1), 1);
    	}
    }

   	//Updating of received assets
	//insert assets to service details from select box
	for ($i=0; $i <sizeof($assets) ; $i++) { 

		$sql1 = "SELECT * FROM thesis.receiving_details WHERE receivingID = '{$receivingID}' AND assetID = '{$assets[$i]}';";
		$result1 = mysqli_query($dbc, $sql1);
		$row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
		echo $sql1;
		$receivingDetailsID = $row['id'];
		echo $receivingDetailsID;
		if($select[$i] == 1){
			
			$sql = "UPDATE `thesis`.`receiving_details` SET
		    	 `received` = '1'
		    	  WHERE (`id` = '{$receivingDetailsID}');";
			$result = mysqli_query($dbc, $sql);

			echo $sql;
			//UPDATE ASSET STATUS
			$queryStat="UPDATE `thesis`.`asset` SET `assetStatus`='2' WHERE `assetID`='{$assets[$i]}'";
			$resultStat=mysqli_query($dbc,$queryStat);
			
			//INSERT TO ASSET AUDIT
			$queryAssAud="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `assetStatus`) VALUES ('{$_SESSION['userID']}', now(), '{$assets[$i]}', '2');";
			$resultAssAud=mysqli_query($dbc,$queryAssAud);
		}
		if($select[$i] == 2)
		{//set received to broken and set asset status to broken
			$sql = "UPDATE `thesis`.`receiving_details` SET
		    	 `received` = '2'
		    	  WHERE (`id` = '{$receivingDetailsID}');";
			$result = mysqli_query($dbc, $sql);
			
			//UPDATE ASSET STATUS
			$queryStat="UPDATE `thesis`.`asset` SET `assetStatus`='5' WHERE `assetID`='{$assets[$i]}'";
			$resultStat=mysqli_query($dbc,$queryStat);
			
			//INSERT TO ASSET AUDIT
			$queryAssAud="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `assetStatus`) VALUES ('{$_SESSION['userID']}', now(), '{$assets[$i]}', '5');";
			$resultAssAud=mysqli_query($dbc,$queryAssAud);


			//store assets to array for creating a repair request
			array_push($brokenAssets, $assets[$i]);
		}
	}

	if(count($brokenAssets) > 0){

	//add repair request for broken assets
	$sqlService = "INSERT INTO `thesis`.`service` (`details`, `dateNeed`, `UserID`, `serviceType`, `status`, `steps`, `replacementUnit`) 
					VALUES ('Broken upon receiving', now(), '{$userID}', '27', '1', '14', '0');";
	$resultService=mysqli_query($dbc,$sqlService);

	echo $sqlService;
	//get newly inserted data from service
	$sqlServiceInsert = "SELECT * FROM `thesis`.`service` ORDER BY id DESC LIMIT 1;";
   	$resultServiceInsert = mysqli_query($dbc, $sqlServiceInsert);
	$rowServiceInsert = mysqli_fetch_array($resultServiceInsert, MYSQLI_ASSOC);

	$serviceID = $rowServiceInsert['id'];

		for ($i=0; $i < count($brokenAssets); $i++) { 
			$sqlServiceDetails = "INSERT INTO `thesis`.`servicedetails` (`serviceID`, `asset`, `replaced`, `problem`) VALUES ('{$serviceID}', '$brokenAssets[$i]', '0', 'broken upon receiving');";
			$resultServiceDetails = mysqli_query($dbc,$sqlServiceDetails);
			echo $sqlServiceDetails;
		}

	}

    //if all checked change status to done
    //check total asset entries
   	$sqlTotal = "SELECT COUNT(*) as 'total' FROM thesis.receiving_details WHERE receivingID = '{$receivingID}';";
   	$resultTotal = mysqli_query($dbc, $sqlTotal);
	$rowTotal = mysqli_fetch_array($resultTotal, MYSQLI_ASSOC);

	//check received assets
	$sqlReceived = "SELECT COUNT(*) as 'received' FROM thesis.receiving_details WHERE receivingID = '{$receivingID}' AND (received = 1 OR received = 2);";
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
	        $replacementID = $row['replacementID'];
	        $serviceID = $row['serviceID'];
	    }

	if($borrowID > 0)//have borrow
	{
	  	
	    $sql = "UPDATE `thesis`.`request_borrow` SET `statusID` = '3', `steps` = '21' WHERE (`borrowID` = '{$borrowID}');";
	    $result = mysqli_query($dbc, $sql);
	}
	else if($requestID > 0)//have request
	{

	    $sql = "UPDATE `thesis`.`request` SET `status` = '3', `step` = '21' WHERE (`requestID` = '{$requestID}');";
	    $result = mysqli_query($dbc, $sql);
	}
	else if($serviceUnitID > 0)//have service unit
	{

	    $sql = "UPDATE `thesis`.`serviceUnit` SET `statusID` = '3', `startDate` = now(), `received` = '1' WHERE (`serviceUnitID` = '{$serviceUnitID}');";
	    $result = mysqli_query($dbc, $sql);
	    echo $sql;
	}
	else if($replacementID > 0)//have replement
	{

	   $sql = "UPDATE `thesis`.`replacement` SET `status` = '3', `setpID` = 21 WHERE (`replacementID` = '{$replacementID}');";
	   $result = mysqli_query($dbc, $sql);
	}
	else if($receivingID > 0)//have replement
	{

	   $sql = "UPDATE `thesis`.`service` SET `status` = '3', `steps` = 21 WHERE (`id` = '{$serviceID}');";
	   $result = mysqli_query($dbc, $sql);
	   echo $sql;
	}

    $header = $_SESSION['previousPage'].$receivingID;
	$message = "Form submitted!";
	$_SESSION['submitMessage'] = $message;

	header('Location: '.$header);
?>	