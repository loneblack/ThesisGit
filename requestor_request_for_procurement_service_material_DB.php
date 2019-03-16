<?php
    session_start();
    require_once("db/mysql_connect.php");

    $header =  $_SESSION['previousPage'];

    $employeeID = 1;
    $userID = $_SESSION['userID'];
    $buildingID = null;
    $FloorAndRoomID = $_POST['room']; 
	
    //get the location from userID
    //$sql = "SELECT * FROM `thesis`.`employee` WHERE UserID = '{$userID}';";
    //$result = mysqli_query($dbc, $sql);

    //while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        //$FloorAndRoomID = $row['FloorAndRoomID'];
    //}

    // TO DO
    //get the buildingId from the floor and room ID
    $sql = "SELECT * FROM `thesis`.`floorandroom` WHERE FloorAndRoomID = '{$FloorAndRoomID}';";
    $result = mysqli_query($dbc, $sql);

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $buildingID = $row['BuildingID'];
    }
    

    $dateNeeded = $_POST['dateNeeded'];
    $comment = $_POST['comment'];
	//$assetDescription=$_POST['assetDescription'];

    date_default_timezone_set("Asia/Singapore");

    $value = date("Y/m/d");
    $time = date("h:i:sa");
    $date = date('Y-m-d H:i:s', strtotime($value." ".$time));

    $count = $_SESSION['count'];
		
    $id = 0;   

	//if(isset($_POST['isITTeamChooseSpecs'])){
	$sql0 = "INSERT INTO `thesis`.`request` (`description`, `employeeID`, `date`, `FloorAndRoomID`, `BuildingID`, `dateNeeded`, `UserID`, `status`, `step`) VALUES ('{$comment}', '{$employeeID}', '{$date}', '{$FloorAndRoomID}', '{$buildingID}', '{$dateNeeded}', '{$userID}', '1', '22')";//status is set to 1 for pending status
	$result0 = mysqli_query($dbc, $sql0);
		//echo $sql0;
	//}
	//else{
		//$sql0 = "INSERT INTO `thesis`.`request` (`description`, `employeeID`, `date`, `FloorAndRoomID`, `BuildingID`, `dateNeeded`, `UserID`, `status`, `step`, `specs`) VALUES ('{$comment}', '{$employeeID}', '{$date}', '{$FloorAndRoomID}', '{$buildingID}', '{$dateNeeded}', '{$userID}', '1', '22', false)";//status is set to 1 for pending status
		//$result0 = mysqli_query($dbc, $sql0);
		//echo $sql0;
	//}
	
    //get the id of the recently inserted item to request table
    $sql1 = "SELECT * FROM `thesis`.`request` order by requestID DESC LIMIT 1;";
    $result1 = mysqli_query($dbc, $sql1);
    $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
    $id = $row1['requestID'];
    
	//Set Asset Description
	
	//if(isset($assetDescription)){
		//$sqlUpdAssDesc = "UPDATE `thesis`.`request` SET `assetDescription` = '{$assetDescription}' WHERE `requestID` = '{$id}';";
		//$resultUpdAssDesc = mysqli_query($dbc, $sqlUpdAssDesc);
	//}
	
	//INSERT TO NOTIFICATIONS TABLE
	$sqlNotif = "INSERT INTO `thesis`.`notifications` (`requestID`, `steps_id`, `isRead`) VALUES ('{$row1['requestID']}', '{$row1['step']}', false);";
    $resultNotif = mysqli_query($dbc, $sqlNotif);
    
   //insertion to requestdetails table using the id taken earlier
   for ($i=0; $i < $count; $i++) { 

    $quantity = $_POST['quantity'.$i];
    $category = $_POST['category'.$i];
    $description = $_POST['description'.$i];
	$purpose = $_POST['purpose'.$i];
	
	if($category=='0'){
		$sql = "INSERT INTO `thesis`.`requestdetails` (`requestID`, `quantity`, `description`, `purpose`) VALUES ('{$id}', '{$quantity}', '{$description}', '{$purpose}')";
        $result = mysqli_query($dbc, $sql);
	}
	else{
		$sql = "INSERT INTO `thesis`.`requestdetails` (`requestID`, `quantity`, `assetCategory`, `description`, `purpose`) VALUES ('{$id}', '{$quantity}', '{$category}', '{$description}', '{$purpose}')";
        $result = mysqli_query($dbc, $sql);
	}
    
   }
    $message = "Form submitted!";
    $_SESSION['submitMessage'] = $message;
    

  unset($_SESSION['count']);  

  header('Location: '.$header);
?>