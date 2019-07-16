<?php
session_start();
require_once('db/mysql_connect.php');

$id = $_POST['id'];
$header = "it_service_unit_receive_view.php?id=".$id;

$userID = $_SESSION['userID'];
$assets = $_POST['assets'];
$isWorking = $_POST['isWorking'];
$comments = $_POST['comments'];
$received = $_POST['received'];

$action = 0;

for ($i=0; $i < sizeof($assets); $i++) { 
     if($assets[$i] != 0){
         array_splice($assets, ($i+1), 1);
     }
 }

 print_r($assets);
 print_r($isWorking);
 print_r($comments);
 print_r($received);

 $forTesting = array();

for ($i=0; $i < count($assets); $i++) { 
 
    //if asset is received (checked)
    if($assets[$i] != 0){

        //update asset retrun id
        $sql = "UPDATE `thesis`.`serviceunitassets` SET `received` = '1' WHERE (`serviceUnitID` = '{$id}') AND (`assetID` = '{$assets[$i]}');";
        $result = mysqli_query($dbc,$sql);

        //get requestor user id
        $sql = "SELECT * FROM thesis.serviceunit WHERE serviceUnitID = '{$id}';";
        $result = mysqli_query($dbc,$sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $userID = $row['UserID'];

        //end asset service unit return
        $sql = "UPDATE `thesis`.`serviceunit` SET `endDate` = now(), `returned` = '3' WHERE (`serviceUnitID` = '{$id}');";
        $result = mysqli_query($dbc,$sql);

        $action = 1;

        //if asset is working
        if($isWorking[$i] == 1){

        //update asset status to stocked (1)
        $sql = "UPDATE `thesis`.`asset` SET `assetStatus` = '1' WHERE (`assetID` = '{$assets[$i]}');";
        $result = mysqli_query($dbc,$sql);

        //insert to audit
        $sql = "INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `assetStatus`) VALUES ('{$userID}', now(), '{$assets[$i]}', '1');";
        $result = mysqli_query($dbc,$sql);
        }
        else // if asset is damaged
        {

        //update asset status to for Testing (8)
        $sql = "UPDATE `thesis`.`asset` SET `assetStatus` = '8' WHERE (`assetID` = '{$assets[$i]}');";
        $result = mysqli_query($dbc,$sql);

        //store asset Id to array for later 
        array_push($forTesting, $assets[$i]);

        //insert to audit
        $sql = "INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `assetStatus`) VALUES ('{$userID}', now(), '{$assets[$i]}', '8');";
        $result = mysqli_query($dbc,$sql);
        }


    }
}

$count = count($forTesting);

//make asset testing request if there are broken asset
if($count > 0){


    $sql = "INSERT INTO `thesis`.`assettesting` (`statusID`, `startTestDate`, `endTestDate`, `PersonRequestedID`, `FloorAndRoomID`, `serviceType`) VALUES ('1', now(), date_add(now(), interval 7 day), '{$userID}', '59', '25');";
    $result = mysqli_query($dbc,$sql);
    echo $sql;

    //get newly inserted data to table
    $sql = "SELECT * FROM thesis.assettesting ORDER BY testingID DESC LIMIT 1;";
    $result = mysqli_query($dbc,$sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $testingID = $row['testingID'];
    for ($i=0; $i < $count; $i++) { 
    //insert stored asset ID as testing details
    $queryAtd="INSERT INTO `thesis`.`assettesting_details` (`assettesting_testingID`, `asset_assetID`) VALUES ('{$testingID}', '{$forTesting[$i]}')";
    $resultAtd=mysqli_query($dbc,$queryAtd);    

    echo $queryAtd;
    }
}

$message = "From Submitted!";

$_SESSION['submitMessage'] = $message;

header("Location: ".$header);
?>