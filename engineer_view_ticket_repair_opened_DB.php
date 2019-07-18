<?php
// Insertion to ticket
    session_start();
    require_once("db/mysql_connect.php");

    $closed = 0;

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
            $requestedBY = $row['requestedBy'];

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

            $queryAssetAudit="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `ticketID`, `assetStatus`) VALUES ('{$userID}', now(), '{$assets}', '{$id}', '{$assetStatus}');";
            $resultAssetAudit=mysqli_query($dbc,$queryAssetAudit);

            // check if asset is refurbishable
            $queryCheckRefurbishable = "SELECT * FROM thesis.asset a JOIN assetmodel am ON a.assetModel = am.assetModelID WHERE a.assetID = '{$asset}';";
            $resultCheckRefurbishable = mysqli_query($dbc, $queryCheckRefurbishable);
            $rowCheckRefurbishable = mysqli_fetch_array($resultCheckRefurbishable, MYSQLI_ASSOC);

            if($assetStatus == 4){//if broken not fixable

                //if asset is refurbishable. set status for refurbish
                if($rowCheckRefurbishable['assetCategory'] == '13' || $rowCheckRefurbishable['assetCategory'] == '40' || $rowCheckRefurbishable['assetCategory'] == '46' ){
                    $queryAssetStatus="UPDATE `thesis`.`asset` SET `assetStatus` = '10' WHERE (`assetID` = '{$asset}');";
                    $resultAssetStatus=mysqli_query($dbc,$queryAssetStatus);

                    $queryAssetAudit="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `ticketID`, `assetStatus`) VALUES ('{$userID}', now(), '{$assets}', '{$id}', '10');";
                    $resultAssetAudit=mysqli_query($dbc,$queryAssetAudit);
                }
                else{

                    $queryAssetStatus="UPDATE `thesis`.`asset` SET `assetStatus` = '11' WHERE (`assetID` = '{$asset}');";
                    $resultAssetStatus=mysqli_query($dbc,$queryAssetStatus);

                    $queryAssetAudit="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `ticketID`, `assetStatus`) VALUES ('{$userID}', now(), '{$assets}', '{$id}', '11');";
                    $resultAssetAudit=mysqli_query($dbc,$queryAssetAudit);
                }

                //end asset assignment 
                //set replacement asset
            }

            if($assetStatus == 22 || $assetStatus == 23 || $assetStatus == 4 || $assetStatus == 24){
                //set checked in ticketed asset
                $queryTicketedAsset="UPDATE `thesis`.`ticketedasset` SET `checked` = '1' WHERE (`assetID` = '{$asset}');";
                $resultTicketedAsset=mysqli_query($dbc,$queryTicketedAsset);
            }
            $counter++;
        }

        $destinations=$_POST['destinationID'];
        $actions=$_POST['actionID'];        
        $assets=$_POST['assets'];
        $sources=$_POST['sourceID'];
        $size = count($assets);

        for ($i=0; $i < $size; $i++) { 
            //0 for none
            if($actions[$i] == 1){//added

                $getComputer = "SELECT * FROM thesis.computer WHERE assetID = {$destinations[$i]};";
                $resultComputer=mysqli_query($dbc,$getComputer);
                $rowComputer = mysqli_fetch_array($resultComputer, MYSQLI_ASSOC);

                $queryAddComponent = "INSERT INTO thesis.computercomponent VALUES ('{$assets[$i]}', '{$destinations[$i]}');";
                $resultAddComponent=mysqli_query($dbc,$queryAddComponent);

                $queryUpdateAssetStatus = "UPDATE `thesis`.`asset` SET `assetStatus` = '19' WHERE (`assetID` = '{$assets[$i]}');";
                $resultUpdateAssetStatus=mysqli_query($dbc,$queryUpdateAssetStatus);

            }
            else if($actions[$i] == 2){//remmoved

                $queryUpdateAssetStatus = "UPDATE `thesis`.`asset` SET `assetStatus` = '4' WHERE (`assetID` = '{$assets[$i]}');";
                $resultUpdateAssetStatus=mysqli_query($dbc,$queryUpdateAssetStatus);

                $queryRemoveComponent = "DELETE FROM thesis.computercomponent WHERE assetID = '{$assets[$i]}';";
                $resultRemoveComponent=mysqli_query($dbc,$queryRemoveComponent);

            }

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
                $queryReqPart="INSERT INTO `thesis`.`requestParts` ( `serviceID`, `statusID`, `date`, `UserID`) VALUES ('{$serviceID}', '1', DATE_ADD(NOW(), INTERVAL 1 DAY), '{$userID}');";
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
        

        //get quantity received of requested assets and total requested assets
        $queryRequestParts="SELECT count(id) as `requested`, count(IF(received = 1, id, null)) as `received` FROM thesis.requestparts_details where id = '{$id}'";
        $resultRequestParts=mysqli_query($dbc,$queryRequestParts);
        $rowRequestParts=mysqli_fetch_array($resultRequestParts,MYSQLI_ASSOC);
        
        //Update requested parts to complete if all parts are received;
        if($rowRequestParts['requested']==$rowRequestParts['received']){

            $queryUpdateRequestParts = "UPDATE `thesis`.`requestparts` SET `statusID` = '3' WHERE (`id` = '{$id}');";
            $resultUpdateRequestParts=mysqli_query($dbc,$queryUpdateRequestParts);

            //assign requested parts to User
            
        }

        //Check if all assets are repaired

        //GET QTY of Assets of a Ticket
        $queryTicketed="SELECT count(ticketID) as `numAssets`, count(IF(checked = 1, ticketID, null)) as `checkedAssets` FROM thesis.ticketedasset where ticketID='{$id}'";
        $resultTicketed=mysqli_query($dbc,$queryTicketed);
        $rowTicketed=mysqli_fetch_array($resultTicketed,MYSQLI_ASSOC);
        
        //GET QTY of Assets of a SERVICE
        $queryService="SELECT  count(ticketID) as `numAssets`
                        , count(IF(checked = 1 AND assetStatus = 10, ta.ticketID, null)) as `refurbish`
                        , count(IF(checked = 1 AND assetStatus = 11, ta.ticketID, null)) as `disposal`
                        , count(IF(checked = 1 AND assetStatus = 22, ta.ticketID, null)) as `false`
                        , count(IF(checked = 1 AND assetStatus = 23, ta.ticketID, null)) as `repaired`
                        , count(IF(checked = 1 AND assetStatus = 24, ta.ticketID, null)) as `replacement`
                FROM thesis.ticketedasset ta JOIN asset a ON ta.assetID = a.assetID where ticketID='{$id}';";
        $resultService=mysqli_query($dbc,$queryService);
        $rowService=mysqli_fetch_array($resultService,MYSQLI_ASSOC);


        $arrayRefurbish = array();
        $arrayDisposal = array();
        $arrayFalse= array();
        $arrayRepaired = array();
        $arrayRepalcement = array();
        $queryArray = "SELECT * FROM thesis.ticketedasset ta JOIN asset a ON ta.assetID = a.assetID where ticketID='{$id}';";
        $resultArray=mysqli_query($dbc,$queryArray);
        while ($rowArray=mysqli_fetch_array($resultArray,MYSQLI_ASSOC)){

            if($rowArray['assetStatus'] == 10){
                array_push($arrayRefurbish, $rowArray['assetID']);
            }
            if($rowArray['assetStatus'] == 11){
                array_push($arrayDisposal, $rowArray['assetID']);
            }
            if($rowArray['assetStatus'] == 22){
                array_push($arrayFalse, $rowArray['assetID']);
            }
            if($rowArray['assetStatus'] == 23){
                array_push($arrayRepaired, $rowArray['assetID']);
            }
            if($rowArray['assetStatus'] == 24){
                array_push($arrayRepalcement, $rowArray['assetID']);
            }
        }


        
        //UPDATE TICKET STATUS 
        
        if($rowTicketed['numAssets']==$rowTicketed['checkedAssets']){

            $queryTickUp="UPDATE `thesis`.`ticket` SET `status`='7',`dateClosed` = '{$currDate}' WHERE `ticketID`='{$id}'";
            $resultTickUp=mysqli_query($dbc,$queryTickUp);

            $closed = 1;

            //if all assets are repaired
            if($rowService['numAssets']==$rowService['repaired']){
                 
                $queryComp="UPDATE `thesis`.`service` SET `steps`='30' WHERE `id`='{$rowServID['service_id']}'";
                $resultComp=mysqli_query($dbc,$queryComp);

                //receiving - make receiving table
                $queryReceiving="INSERT INTO `thesis`.`requestor_receiving` (`UserID`, `serviceID`, `statusID`) VALUES ('{$requestedBY}', '{$serviceID}', '1');";
                $resultReceiving=mysqli_query($dbc,$queryReceiving);

                //get newly inserted receiving data
                $queryGetReceiving="SELECT * FROM `thesis`.`requestor_receiving` where serviceID='{$serviceID}' order by id desc limit 1";
                $resultGetReceiving=mysqli_query($dbc,$queryGetReceiving);
                $rowGetReceiving=mysqli_fetch_array($resultGetReceiving,MYSQLI_ASSOC);

                $assets=$_POST['assetID'];
                foreach ($assets as $asset) {
                    //receiving - make receiving details table
                    $queryReceiving="INSERT INTO `thesis`.`receiving_details` (`receivingID`, `assetID`, `received`) VALUES ('{$rowGetReceiving['id']}', '{$asset}', '0');";
                    $resultReceiving=mysqli_query($dbc,$queryReceiving);

                }
               
                //INSERT TO NOTIFICATIONS TABLE
                $sqlNotif = "INSERT INTO `thesis`.`notifications` (`isRead`, `service_id`) VALUES (false, '{$serviceID}');";
                $resultNotif = mysqli_query($dbc, $sqlNotif);
            }
            //all assets for replacement
            elseif($rowService['numAssets']==($rowService['replacement'])){
                $queryComp="UPDATE `thesis`.`service` SET `steps`='32', `dateNeed` = DATE_ADD(NOW(), INTERVAL 3 DAY) WHERE `id`='{$rowServID['service_id']}'";
                $resultComp=mysqli_query($dbc,$queryComp);

                echo $queryComp;
            }

            //if all false report
            elseif($rowService['numAssets']==$rowService['false']){ //go to evaluation 
                
                $queryComp="UPDATE `thesis`.`service` SET `endDate` = now(), `status` = '3' WHERE (`id` = '{$rowServID['service_id']}');";
                $resultComp=mysqli_query($dbc,$queryComp);

                $assets=$_POST['assetID'];
                foreach ($assets as $asset) {
                    $queryComp="UPDATE `thesis`.`asset` SET `assetStatus` = '2' WHERE (`assetID` = '{$asset}');";
                    $resultComp=mysqli_query($dbc,$queryComp);

                    $queryAssetAudit="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `ticketID`, `assetStatus`) VALUES ('{$userID}', now(), '{$asset}', '{$id}', '{$assetStatus}');";
                    $resultAssetAudit=mysqli_query($dbc,$queryAssetAudit);
                }
            }
            //if there are atleast 1 repaired/false report
            elseif(count($arrayRepaired) > 0 || count($arrayFalse) > 0 ){

                //send repaired/ false report back to user for receiving

                //receiving - make receiving table
                $queryReceiving="INSERT INTO `thesis`.`requestor_receiving` (`UserID`, `serviceID`, `statusID`) VALUES ('{$requestedBY}', '{$serviceID}', '1');";
                $resultReceiving=mysqli_query($dbc,$queryReceiving);

                //get newly inserted receiving data
                $queryGetReceiving="SELECT * FROM `thesis`.`requestor_receiving` where serviceID='{$serviceID}' order by id desc limit 1";
                $resultGetReceiving=mysqli_query($dbc,$queryGetReceiving);
                $rowGetReceiving=mysqli_fetch_array($resultGetReceiving,MYSQLI_ASSOC);

                foreach ($arrayRepaired as $asset) {
                    //receiving - make receiving details table
                    $queryReceiving="INSERT INTO `thesis`.`receiving_details` (`receivingID`, `assetID`, `received`) VALUES ('{$rowGetReceiving['id']}', '{$asset}', '0');";
                    $resultReceiving=mysqli_query($dbc,$queryReceiving);

                }
                foreach ($arrayFalse as $asset) {
                    //receiving - make receiving details table
                    $queryReceiving="INSERT INTO `thesis`.`receiving_details` (`receivingID`, `assetID`, `received`) VALUES ('{$rowGetReceiving['id']}', '{$asset}', '0');";
                    $resultReceiving=mysqli_query($dbc,$queryReceiving);

                }


            //set status to partially repaired
            $queryComp="UPDATE `thesis`.`service` SET `steps`='31' WHERE `id`='{$rowServID['service_id']}'";
            $resultComp=mysqli_query($dbc,$queryComp);
            }

            //if there are broken not fixable assets (for disposal/ for refurbish)
            //create replacement for those broken assets
            if(count($arrayDisposal) > 0 || count($arrayRefurbish) > 0 ){

                foreach ($$arrayDisposal as $asset) {
                   $sqlReplacement = "INSERT INTO `thesis`.`replacement` (`lostAssetID`, `BuildingID`, `FloorAndRoomID`, `dateTiimeLost`, `userID`, `statusID`, `stepID`) 
                    VALUES ('{$asset}', 'ITroom', 'ITroom', now(), '{requestedBY}', '1', '14');";
                    $resultReplacement=mysqli_query($dbc,$queryReplacement);
                }
                foreach ($$arrayRefurbish as $asset) {
                   $sqlReplacement = "INSERT INTO `thesis`.`replacement` (`lostAssetID`, `BuildingID`, `FloorAndRoomID`, `dateTiimeLost`, `userID`, `statusID`, `stepID`) 
                    VALUES ('{$asset}', 'ITroom', 'ITroom', now(), '{requestedBY}', '1', '14');";
                    $resultReplacement=mysqli_query($dbc,$queryReplacement);
                }
                

            }


        }
        
        $message = "Ticket Updated!";
        $_SESSION['submitMessage'] = $message;


        }

        $header = $_SESSION['previousPage'];
        if($closed == 1){
            $header = "engineer_view_ticket_repair_closed.php?id=".$id;
        }
        header('Location: '.$header);
    
?>