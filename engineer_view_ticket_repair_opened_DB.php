<?php
// Insertion to ticket
    session_start();
    require_once("db/mysql_connect.php");

    $id = $_GET['id'];
    $userID = $_SESSION['userID'];

    $query =  "SELECT *, t.status AS 'status', s.status AS 'statusDescription' FROM thesis.ticket t JOIN ref_ticketstatus s ON t.status = s.ticketID  WHERE t.ticketID = {$id};";
    $result = mysqli_query($dbc, $query);

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            
            $dateCreated = $row['dateCreated'];
            $dueDate = $row['dueDate'];
            $summary = $row['summary'];
            $details = $row['details'];
            $status = $row['status'];
            $statusDescription = $row['statusDescription'];
            $description = $row['description'];
            $priority = $row['priority'];
            $others = $row['others'];
            $assigneeUserID = $row['assigneeUserID'];
            $comment = $row['comment'];
            $serviceID = $row['service_id'];


        }
    $assets = array();

    $query2 =  "SELECT * FROM thesis.ticketedasset WHERE ticketID = {$id};";
    $result2 = mysqli_query($dbc, $query2);

    while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
        array_push($assets, $row['assetID']);
    }
    
    if(isset($_POST['submit'])){
        
        $count = $_POST['count'];
        if(empty($_POST['count'])){
            $count = 0;
        }
        $status=$_POST['status'];
        $priority=$_POST['priority'];
        $currDate=date("Y-m-d H:i:s");
        
        
        //GET SERVICEID
        $queryServID="SELECT * FROM thesis.ticket where ticketID='{$id}'";
        $resultServID=mysqli_query($dbc,$queryServID);
        $rowServID=mysqli_fetch_array($resultServID,MYSQLI_ASSOC);


        //Updating asset status
        $counter = 0;
        $assets=$_POST['assetID'];
        foreach($assets as $asset){

            //update asset status
            $assetStatus = $_POST['assetStatus'.$counter];
            $queryAssetStatus="UPDATE `thesis`.`asset` SET `assetStatus` = '{$assetStatus}' WHERE (`assetID` = '{$asset}');";
            $resultAssetStatus=mysqli_query($dbc,$queryAssetStatus);

            if($assetStatus == 22 || $assetStatus == 23 || $assetStatus == 4){
                //set checked in ticketed asset
                $queryTicketedAsset="UPDATE `thesis`.`ticketedasset` SET `checked` = '1' WHERE (`assetID` = '{$asset}');";
                $resultTicketedAsset=mysqli_query($dbc,$queryTicketedAsset);
            }
            $counter++;
        }

        //Update Comment and assignee
        $comment=$_POST['comment'];
        $assigneeUserID = $_POST['escalateUserID'];
        $queryUpdate="UPDATE `thesis`.`ticket` SET `assigneeUserID` = '{$assigneeUserID}',`comment` = '{$comment}' WHERE (`ticketID` = '{$id}');";
        $resultUpdate=mysqli_query($dbc,$queryUpdate);
        


        //Request for parts code
        if(!empty($_POST['quantity0'])){

            //Check if existing
            $queryGetRequestID="SELECT * FROM `thesis`.`requestParts` WHERE `serviceID`='{$serviceID}';";
            $resultGetRequestID=mysqli_query($dbc,$queryGetRequestID);

            if (mysqli_num_rows($resultGetRequestID)==0) {
                //Insert new request parts
                $queryReqPart="INSERT INTO `thesis`.`requestParts` ( `serviceID`, `statusID`, `date`, `UserID`) VALUES ('{$serviceID}', '1', now(), '{$userID}');";
                //status ID set to 1 for perding status
                $resultReqPart=mysqli_query($dbc,$queryReqPart);
            }
            
            //GET request parts id
            $queryGetRequestID="SELECT * FROM `thesis`.`requestParts` WHERE `serviceID`='{$serviceID}';";
            $resultGetRequestID=mysqli_query($dbc,$queryGetRequestID);
            $rowGetRequestID=mysqli_fetch_array($resultGetRequestID,MYSQLI_ASSOC);

            $requestID = $rowGetRequestID['id'];

            $i = 0;
            while($i <= $count){//Insert into request parts details

                $cat = $_POST['category'.$i];
                $qty = $_POST['quantity'.$i];
                $specs = $_POST['specification'.$i];

                $queryReqPartDetails="INSERT INTO `thesis`.`requestParts_details` ( `requestPartsID`, `assetCategoryID`, `quantity`, `specifications`, `received`) VALUES ('{$requestID}', '{$cat}' ,'{$qty}' ,'{$specs}', '0');";
                $resultReqParDetailst=mysqli_query($dbc,$queryReqPartDetails);

                $i++;
            }

                $querya="UPDATE `thesis`.`ticket` 
                SET `status` = '6',
                WHERE (`ticketID` = '{$id}');";
                $resulta=mysqli_query($dbc,$querya);  
        }

        //Updating of received assets
        if (isset($_POST['detailsID'])) {
            //insert assets to service details from select box

            foreach (array_combine($_POST['detailsID'], $_POST['deliveryStatus']) as $detail => $status){

                $sql1 = "UPDATE `thesis`.`requestparts_details` SET `received` = '{$status}' WHERE (`id` = '{$detail}');";
                $result1 = mysqli_query($dbc, $sql1);
            }
        }
        
        //Check if all assets are repaired
        
        //GET QTY of Assets of a Ticket
        $queryTicketed="SELECT count(ticketID) as `numAssets`, count(IF(checked = 1, ticketID, null)) as `repairedAssets` FROM thesis.ticketedasset where ticketID='{$id}'";
        $resultTicketed=mysqli_query($dbc,$queryTicketed);
        $rowTicketed=mysqli_fetch_array($resultTicketed,MYSQLI_ASSOC);
        
        //GET QTY of Assets of a SERVICE
        $queryService="SELECT count(ta.ticketID) as `numAssets`, count(IF(checked = 1, ta.ticketID, null)) as `repairedAssets` FROM thesis.ticketedasset ta join ticket t on ta.ticketID=t.ticketID where t.service_id='{$rowServID['service_id']}'";
        $resultService=mysqli_query($dbc,$queryService);
        $rowService=mysqli_fetch_array($resultService,MYSQLI_ASSOC);
        
        //UPDATE SERVICE STATUS (STILL NEEDS TO BE FIXED)
        if($rowService['numAssets']==$rowService['repairedAssets']){
            $queryComp="UPDATE `thesis`.`service` SET `steps`='11' WHERE `id`='{$rowServID['service_id']}'";
            $resultComp=mysqli_query($dbc,$queryComp);
        }
        
        //UPDATE TICKET STATUS 
        if($rowTicketed['numAssets']==$rowTicketed['repairedAssets']){
            $queryTickUp="UPDATE `thesis`.`ticket` SET `status`='7',`dateClosed` = '{$currDate}' WHERE `ticketID`='{$id}'";
            $resultTickUp=mysqli_query($dbc,$queryTickUp);
        }
        
        $message = "Ticket Updated!";
        $_SESSION['submitMessage'] = $message;


        }

        $header = $_SESSION['previousPage'];
        //header('Location: '.$header);
    
?>