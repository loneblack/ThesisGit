<?php
session_start();
require_once('db/mysql_connect.php');

$header = "it_asset_receive_view.php";
$userID = $_SESSION['userID'];

$id = $_POST['id'];
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
    if($assets['$i'] != 0){

        //update asset retrun id
        $sql = "UPDATE `thesis`.`assetreturndetails` SET `received` = '1' WHERE (`assetReturnID` = '{$id}') AND (`assetID` = '{$assets[$i]}');";
        $result = mysqli_query($dbc,$sql);

        $action = 1;

        //if asset is working
        if($isWorking[$i] == 1){

        //update asset status to stocked (1)
        $sql = "UPDATE `thesis`.`asset` SET `assetStatus` = '1' WHERE (`assetID` = '1');";
        $result = mysqli_query($dbc,$sql);

        //insert to audit
        $sql = "INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `assetStatus`) VALUES ('{$userID}', now(), '{$assets[$i]}', '1');";
        $result = mysqli_query($dbc,$sql);
        }
        else // if asset is damaged
        {

        //update asset status to for Testing (8)
        $sql = "UPDATE `thesis`.`asset` SET `assetStatus` = '8' WHERE (`assetID` = '1');";
        $result = mysqli_query($dbc,$sql);

        //store asset Id to array for later 
        array_push($forTesting, $assets[$i]);

        //insert to audit
        $sql = "INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `assetStatus`) VALUES ('{$userID}', now(), '{$assets[$i]}', '8');";
        $result = mysqli_query($dbc,$sql);
        }


    }
}

//count number of received and total assets
$sql = "SELECT *, SUM(received) as 'totalReceived', COUNT(assetID) as 'totalCount' FROM thesis.assetreturndetails WHERE assetReturnID = '{$id}';";
$result = mysqli_query($dbc,$sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$totalCount = $row['totalCount'];
$totalReceived = $row['totalReceived'];

//if all is received, close assetreturn table
if ($totalReceived == $totalCount) {
   $sql = "UPDATE `thesis`.`assetreturn` SET `statusID` = '3' WHERE (`assetReturnID` = '{$id}');";
   $result = mysqli_query($dbc,$sql);
}

//check the status of assetreturn if it is ongoing or pending or closed
//store the status id
$sql = " SELECT * FROM thesis.assetreturn WHERE assetReturnID = '{$id}';";
$result = mysqli_query($dbc,$sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$status = $row['statusID'];

//if status is pending and if there is action, set asset return to ongoing
if($status == '1' && $action == 1)
{
    $sql = "UPDATE `thesis`.`assetreturn` SET `statusID` = '2' WHERE (`assetReturnID` = '{$id}');";
    $result = mysqli_query($dbc,$sql);
}

$count = count($forTesting);

//make asset testing request if there are broken asset
if($count > 0){

    

    for ($i=0; $i < $count; $i++) { 
    //insert stored asset ID as testing details

    }
}

$message = "From Submitted!";

$_SESSION['submitMessage'] = $message;

//header("Location: ".$header);
?>