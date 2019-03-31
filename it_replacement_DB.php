<?php
	session_start();
	require_once('db/mysql_connect.php');

    $isServiceUnit = $_SESSION['isServiceUnit'];
    unset($_SESSION['isServiceUnit']);

	$header =  $_SESSION['previousPage'];

	$id = $_GET['id']; //service id
	$replacement=$_POST['assets'];
    $toBeReplaced = $_POST['assetID'];

    //check if replacement unit or not
    if($isServiceUnit == 1){

        if ($replacement[0] != 0) {
        $serviceUnitAssetID = $toBeReplaced[0];

        //get data from serviceunit
        $sql = "SELECT * FROM thesis.servicedetails WHERE serviceID = {$id};";
        $result = mysqli_query($dbc, $sql);
        $row=mysqli_fetch_array($result, MYSQLI_ASSOC);

        $assetToBeReplaced = $row['asset'];

        //end service unit
        $sql = "UPDATE `thesis`.`serviceunit` SET `statusID` = '3', `endDate` = 'now()' WHERE (`serviceUnitID` = '{$serviceUnitAssetID}');";
        $result = mysqli_query($dbc, $sql);

        //get data from assignment of to be replaced
        $sql = "SELECT * FROM thesis.assetassignment WHERE assetID = '{$assetToBeReplaced}' AND statusID = '2';";
        $result = mysqli_query($dbc, $sql);
        $row=mysqli_fetch_array($result, MYSQLI_ASSOC);

        $assetassignmentID = $row['AssetAssignmentID'];
        $BuildingID = $row['BuildingID'];
        $FloorAndRoomID = $row['FloorAndRoomID'];
        $endDate = $row['endDate'];
        $personresponsibleID = $row['personresponsibleID'];

        //remove assignment of to be replaced
        $sql = "UPDATE `thesis`.`assetassignment` SET `statusID` = '3' WHERE (`AssetAssignmentID` = '{$assetassignmentID}');";//set status to completed
        $result = mysqli_query($dbc, $sql);

        //get id of new assignment
        $sql = "SELECT * FROM thesis.assetassignment WHERE assetID = '{$replacement[0]}' AND statusID = '2';";
        $result = mysqli_query($dbc, $sql);
        $row=mysqli_fetch_array($result, MYSQLI_ASSOC);

        $assetassignmentID = $row['AssetAssignmentID'];

        //set replaced to 1 in service details
        $sql = "UPDATE thesis.servicedetails SET replaced = 1 WHERE (serviceID = '{$id}') AND (asset = '{$replacement[0]}');";//set status to completed
        $result = mysqli_query($dbc, $sql);

        //insert to asset audit
        $sql = "UPDATE `thesis`.`assetassignment` SET `statusID` = '3' WHERE (`AssetAssignmentID` = '{$assetassignmentID}');";
        $result = mysqli_query($dbc, $sql);

        // add to replacement table
        $sql = "INSERT INTO `thesis`.`replacement` (`lostAssetID`, `replacementAssetID`, `BuildingID`, `FloorAndRoomID`, `userID`, `statusID`, `stepID`, `remarks`) 
                VALUES ('{$toBeReplaced[$i]}', '{$replacement[0]}', '{$BuildingID}', '{$FloorAndRoomID}', '{$personresponsibleID}', '2', '26', 'replacement');";
        $result = mysqli_query($dbc, $sql);

        //get id of newly inserted replacement
        $sql = "SELECT MAX(replacementID) as 'replacementID' FROM `thesis`.`replacement`;";
        $result = mysqli_query($dbc, $sql);
        $row=mysqli_fetch_array($result, MYSQLI_ASSOC);

        $replacementID = $row['replacementID'];

        //insert to receiving
        $sql = "INSERT INTO `thesis`.`requestor_receiving` (`UserID`, `statusID`, `replacementID`) VALUES ('{$personresponsibleID}', '1', '{$replacementID}');";
        $result = mysqli_query($dbc, $sql);

        //get newly inserted data
        $sql = " SELECT * FROM thesis.requestor_receiving WHERE UserID = '{$personresponsibleID}' AND replacementID = '{$replacementID}' AND statusID != 3;";
        $result = mysqli_query($dbc, $sql);
        $row=mysqli_fetch_array($result, MYSQLI_ASSOC);
        $receivingID = $row['id'];

        //insert to receiving details
        $sql = "INSERT INTO `thesis`.`receiving_details` (`receivingID`, `assetID`, `received`) VALUES ('{$receivingID}', '{$replacement[0]}', '0');";
        $result = mysqli_query($dbc, $sql);

        //set replacement asset status to moving
        $sql = "UPDATE `thesis`.`asset` SET `assetStatus` = '3' WHERE (`assetID` = '{$replacement[0]}');";
        $result = mysqli_query($dbc, $sql);
        
        }
    }
    elseif ($isServiceUnit == 0) {
        for ($i=0; $i < count($toBeReplaced); $i++) { 

            if ($replacement[$i] != 0) {

                //get data from assignment of to be replaced
                $sql = "SELECT * FROM thesis.assetassignment WHERE assetID = '{$toBeReplaced[$i]}' AND statusID = '2';";
                $result = mysqli_query($dbc, $sql);
                $row=mysqli_fetch_array($result, MYSQLI_ASSOC);
                echo $sql;
                $assetassignmentID = $row['AssetAssignmentID'];
                $BuildingID = $row['BuildingID'];
                $FloorAndRoomID = $row['FloorAndRoomID'];
                $endDate = $row['endDate'];
                $personresponsibleID = $row['personresponsibleID'];
                
                //remove assignment of to be replaced
                $sql = "UPDATE `thesis`.`assetassignment` SET `statusID` = '3' WHERE (`AssetAssignmentID` = '{$assetassignmentID}');";//set status to completed
                $result = mysqli_query($dbc, $sql);
                echo $sql."<br>";
                //insert new assignment of replacement 
                $sql = "INSERT INTO `thesis`.`assetassignment` (`assetID`, `BuildingID`, `FloorAndRoomID`, `startDate`, `endDate`, `personresponsibleID`, `statusID`)
                        VALUES ('{$replacement[$i]}', '{$BuildingID}', '{$FloorAndRoomID}', now(), '{$endDate}', '{$personresponsibleID}', '2');";//set status to deployed
                $result = mysqli_query($dbc, $sql);
                echo $sql."<br>";
                
                //get id of new assignment
                $sql = "SELECT * FROM thesis.assetassignment WHERE assetID = '{$replacement[$i]}' AND statusID = '2';";
                $result = mysqli_query($dbc, $sql);
                $row=mysqli_fetch_array($result, MYSQLI_ASSOC);

                $assetassignmentID = $row['AssetAssignmentID'];

                //set replaced to 1 in service details
                $sql = "UPDATE thesis.servicedetails SET replaced = 1 WHERE (serviceID = '{$id}') AND (asset = '{$replacement[$i]}');";//set status to completed
                $result = mysqli_query($dbc, $sql);
                echo $sql."<br>";
                //insert to asset audit
                $sql = "UPDATE `thesis`.`assetassignment` SET `statusID` = '3' WHERE (`AssetAssignmentID` = '{$assetassignmentID}');";
                $result = mysqli_query($dbc, $sql);
                echo $sql."<br>";
                // add to replacement table
                $sql = "INSERT INTO `thesis`.`replacement` (`lostAssetID`, `replacementAssetID`, `BuildingID`, `FloorAndRoomID`, `userID`, `statusID`, `stepID`, `remarks`) 
                        VALUES ('{$toBeReplaced[$i]}', '{$replacement[$i]}', '{$BuildingID}', '{$FloorAndRoomID}', '{$personresponsibleID}', '2', '26', 'replacement');";
                $result = mysqli_query($dbc, $sql);
                echo $sql."<br>";
                //get id of newly inserted replacement
                $sql = "SELECT MAX(replacementID) as 'replacementID' FROM `thesis`.`replacement`;";
                $result = mysqli_query($dbc, $sql);
                $row=mysqli_fetch_array($result, MYSQLI_ASSOC);

                $replacementID = $row['replacementID'];

                //add to receiving table if does not exist
                $sql = " SELECT * FROM thesis.requestor_receiving WHERE UserID = '{$personresponsibleID}' AND replacementID = '{$replacementID}' AND statusID != 3;";
                $result = mysqli_query($dbc, $sql);
                echo $sql."<br>";
                if(mysqli_num_rows($result) == 0){
                    $sql = "INSERT INTO `thesis`.`requestor_receiving` (`UserID`, `statusID`, `replacementID`) VALUES ('{$personresponsibleID}', '1', '{$replacementID}');";
                    $result = mysqli_query($dbc, $sql);
                    echo $sql."<br>";
                    $sql = " SELECT * FROM thesis.requestor_receiving WHERE UserID = '{$personresponsibleID}' AND replacementID = '{$replacementID}' AND statusID != 3;";
                    $result = mysqli_query($dbc, $sql);
                    $row=mysqli_fetch_array($result, MYSQLI_ASSOC);
                    echo $sql."<br>";
                    $receivingID = $row['id'];
                }
                else{
                     $row=mysqli_fetch_array($result, MYSQLI_ASSOC);

                     $receivingID = $row['id'];
                }
                //insert to receiving details
                $sql = "INSERT INTO `thesis`.`receiving_details` (`receivingID`, `assetID`, `received`) VALUES ('{$receivingID}', '{$replacement[$i]}', '0');";
                $result = mysqli_query($dbc, $sql);
                echo $sql."<br>";
                //set replacement asset status to moving
                $sql = "UPDATE `thesis`.`asset` SET `assetStatus` = '3' WHERE (`assetID` = '{$replacement[$i]}');";
                $result = mysqli_query($dbc, $sql);
                echo $sql."<br>";
            }
        }
    }
    

	$message = "Form submitted!"; 
	$_SESSION['submitMessage'] = $message;
	
	//header('Location: '.$header);

?>