<?php
// Insertion to ticket
    
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

            $assetStatus = $_POST['assetStatus'.$counter];
            $queryAssetStatus="UPDATE `thesis`.`asset` SET `assetStatus` = '{$assetStatus}' WHERE (`assetID` = '{$asset}');";
            $resultAssetStatus=mysqli_query($dbc,$queryAssetStatus);
            $counter++;
        }

        //Update Comment and assignee
        $comment=$_POST['comment'];
        $assigneeUserID = $_POST['escalateUserID'];
        $queryUpdate="UPDATE `thesis`.`ticket` SET `assigneeUserID` = '{$assigneeUserID}',`comment` = '{$comment}' WHERE (`ticketID` = '{$id}');";
        $resultUpdate=mysqli_query($dbc,$queryUpdate);
        
        
        //Request for parts code
        if(!empty($_POST['quantity0'])){
            $i = 0;
            while($i <= $count){

                $cat = $_POST['category'.$i];
                $qty = $_POST['quantity'.$i];
                $specs = $_POST['specification'.$i];

                $queryReqPart="INSERT INTO `thesis`.`requestparts` ( `serviceID`, `assetModelID`, `quantity`, `specifications`, `received`) VALUES ('{$serviceID}', '{$cat}' ,'{$qty}' ,'{$specs}', '0')";
                $resultReqPart=mysqli_query($dbc,$queryReqPart);

                $i++;
            }

                $querya="UPDATE `thesis`.`ticket` 
                SET `status` = '6',
                WHERE (`ticketID` = '{$id}');";
                $resulta=mysqli_query($dbc,$querya);  
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
        
        $message = "Ticket Updated!".$count;
        $_SESSION['submitMessage'] = $message;
        }
        
    //}
    
?>