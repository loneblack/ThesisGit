<?php
session_start();
require_once('db/mysql_connect.php');

$header = "it_asset_receive_view.php";

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

        //insert to audit

        }
        else
        {

        //update asset status to for Testing (8)

        //store asset Id to array for later 

        //insert to audit
        }


    }
}

//count number of receuved and total assets

//if all is received, close the return

//check the status of asset return if it is ongoing or pending
//store the status id

//if status is pending and if there is action, set asset return to ongoing

//make asset testing request

//insert stored asset ID as testing details

$message = "From Submitted!";

$_SESSION['submitMessage'] = $message;

//header("Location: ".$header);
?>