<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	$userid=$_SESSION['userID'];
	$ticketID=$_GET['id'];
	
	//PHP function to check if asset is for escalate 
	function isEscalate($array){ 
		if($array=='2') 
			return TRUE; 
		else 
			return FALSE;  
	} 
	
	//GET ALL TICKET DATA
	$queryOut = "SELECT *,t.dueDate,t.priority,e.name as `empName` FROM thesis.ticket t join assettesting at on t.testingID=at.testingID 
											join user u on t.requestedBy=u.UserID
											join employee e on u.UserID=e.UserID
											where t.ticketID='{$ticketID}'";
    $resultOut = mysqli_query($dbc, $queryOut);
	$rowOut = mysqli_fetch_array($resultOut, MYSQLI_ASSOC);
	
	//GET ALL ASSET TESTING DATA
	$query7="SELECT COUNT(atd.asset_assetID) as `numAssets`,at.testingID,at.remarks FROM thesis.assettesting_details atd join assettesting at on atd.assettesting_testingID=at.testingID 
																	  join ticket t on at.testingID=t.testingID
																	  where t.ticketID='{$ticketID}'";
	$result7=mysqli_query($dbc,$query7);
	$row7 = mysqli_fetch_array($result7, MYSQLI_ASSOC);
	
	//Update notifications
	$queryUpdNotif="UPDATE `thesis`.`notifications` SET `isRead` = true WHERE (`ticketID` = '{$ticketID}');";
	$resultUpdNotif=mysqli_query($dbc,$queryUpdNotif);
	
	if(isset($_POST['save'])){
		$testStat=$_POST['testStat'];
		$listOfTestAss=$_POST['listOfTestAss'];
			
		//Check the dropdown for asset status
		for($i=0;$i<sizeOf($testStat);$i++){
			//For functioning assets
			if($testStat[$i]=='1'){
				$query5="UPDATE `thesis`.`assettesting_details` SET `check`='1' WHERE `assettesting_testingID`='{$row7['testingID']}' and asset_assetID='{$listOfTestAss[$i]}'";
				$result5=mysqli_query($dbc,$query5);
				
				//INSERT TO ASSET AUDIT
				$queryAssAud="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `ticketID`, `assetStatus`) VALUES ('{$_SESSION['userID']}', now(), '{$listOfTestAss[$i]}', '{$ticketID}', '8');";
				$resultAssAud=mysqli_query($dbc,$queryAssAud);
			}
			//For defected assets
			elseif($testStat[$i]=='3'){
				$query5="UPDATE `thesis`.`assettesting_details` SET `check`='0' WHERE `assettesting_testingID`='{$row7['testingID']}' and asset_assetID='{$listOfTestAss[$i]}'";
				$result5=mysqli_query($dbc,$query5);

				//INSERT TO ASSET AUDIT
				$queryAssAud="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `ticketID`, `assetStatus`) VALUES ('{$_SESSION['userID']}', now(), '{$listOfTestAss[$i]}', '{$ticketID}', '8');";
				$resultAssAud=mysqli_query($dbc,$queryAssAud);
			}
		}
		
		//For escalation code
		if(isset($_POST['escEngineer'])){
			$escEngineer=$_POST['escEngineer'];
			$escEngineerUniq=array_unique($escEngineer);
				
			//GETTESTINGID
			$queryTestID = "SELECT * FROM thesis.ticket where ticketID='{$ticketID}'";
			$resultTestID = mysqli_query($dbc, $queryTestID);
			$rowTestID = mysqli_fetch_array($resultTestID, MYSQLI_ASSOC);
			
			if($row7['remarks']=="Asset Request"){
				//GET REQUEST DATA
				$queryReqDat="SELECT ad.requestID,r.UserID,r.FloorAndRoomID FROM thesis.assettesting_details atd join asset a on atd.asset_assetID=a.assetID
																						   join assetdocument ad on a.assetID=ad.assetID
																						   join request r on ad.requestID=r.requestID 
																						   where atd.assettesting_testingID='{$rowTestID['testingID']}' limit 1";
				$resultReqDat=mysqli_query($dbc,$queryReqDat);
				$rowReqDat=mysqli_fetch_array($resultReqDat,MYSQLI_ASSOC);
				foreach($escEngineerUniq as $escEng){
					//CREATE ASSETTESTING
					$queryAssTest="INSERT INTO `thesis`.`assettesting` (`statusID`, `PersonRequestedID`, `FloorAndRoomID`, `serviceType`,`remarks`) VALUES ('1', '{$rowReqDat['UserID']}', '{$rowReqDat['FloorAndRoomID']}', '25', 'Asset Request');";
					$resultAssTest=mysqli_query($dbc,$queryAssTest);
						
					//GET LATEST ASSET TEST
					$queryLatAss="SELECT * FROM `thesis`.`assettesting` order by testingID desc limit 1";
					$resultLatAss=mysqli_query($dbc,$queryLatAss);
					$rowLatAss=mysqli_fetch_array($resultLatAss,MYSQLI_ASSOC);
					
					//CREATE TICKET FOR ESCALATION
					$queryEsc="INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `testingID`, `serviceType`, `requestedBy`) VALUES ('5', '{$escEng}', '{$_SESSION['userID']}', now(), now(), '{$_POST['dueDate']}', '{$rowOut['priority']}', '{$rowLatAss['testingID']}', '25', '{$rowOut['requestedBy']}')";
					$resultEsc=mysqli_query($dbc,$queryEsc);
					
					//GET LATEST TICKET
					$queryLatTic="SELECT * FROM `thesis`.`ticket` order by ticketID desc limit 1";
					$resultLatTic=mysqli_query($dbc,$queryLatTic);
					$rowLatTic=mysqli_fetch_array($resultLatTic,MYSQLI_ASSOC);
					
					//INSERT TO NOTIFICATIONS TABLE
					$sqlNotif = "INSERT INTO `thesis`.`notifications` (`isRead`, `ticketID`) VALUES (false, '{$rowLatTic['ticketID']}');";
					$resultNotif = mysqli_query($dbc, $sqlNotif);
					
					foreach (array_combine($_POST['forEscAsset'], $escEngineer) as $forEscAss => $escEngi){
						if($escEngi==$escEng){
							//INSERT TO ASSETTESTDETAILS
							$queryAtd="INSERT INTO `thesis`.`assettesting_details` (`assettesting_testingID`, `asset_assetID`) VALUES ('{$rowLatAss['testingID']}', '{$forEscAss}')";
							$resultAtd=mysqli_query($dbc,$queryAtd);
								
							//DELETE ASSET TO ASSET TESTING
							$queryDelAss="DELETE FROM `thesis`.`assettesting_details` WHERE `assettesting_testingID`='{$rowTestID['testingID']}' and `asset_assetID`='{$forEscAss}'";
							$resultDelAss=mysqli_query($dbc,$queryDelAss);
							
							//INSERT TO TICKETEDASSET
							$queryTicAss="INSERT INTO `thesis`.`ticketedasset` (`ticketID`, `assetID`) VALUES ('{$rowLatTic['ticketID']}', '{$forEscAss}');";
							$resultTicAss=mysqli_query($dbc,$queryTicAss);
							
							//INSERT TO ASSET AUDIT
							$queryAssAud="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `ticketID`, `assetStatus`) VALUES ('{$_SESSION['userID']}', now(), '{$forEscAss}', '{$rowLatTic['ticketID']}', '8');";
							$resultAssAud=mysqli_query($dbc,$queryAssAud);
							
							//DELETE ASSET TO TICKETEDASSET
							$queryDelTic="DELETE FROM `thesis`.`ticketedasset` WHERE `ticketID`='{$ticketID}' and `assetID`='{$forEscAss}'";
							$resultDelTic=mysqli_query($dbc,$queryDelTic);
						}
					}
					
				}
			}
			elseif($row7['remarks']=="Donation"){
				//GET DONATION DATA
				$queryDonDat="SELECT d.donationID FROM thesis.assettesting_details atd join asset a on atd.asset_assetID=a.assetID
																					   join donationdetails_item ddi on a.assetID=ddi.assetID
																					   join donationdetails dd on ddi.id=dd.id
																					   join donation d on dd.donationID=d.donationID
																					   where atd.assettesting_testingID='{$rowTestID['testingID']}' limit 1";
				$resultDonDat=mysqli_query($dbc,$queryDonDat);
				$rowDonDat=mysqli_fetch_array($resultDonDat,MYSQLI_ASSOC);
				
				foreach($escEngineerUniq as $escEng){
					//CREATE ASSETTESTING
					$queryAssTest="INSERT INTO `thesis`.`assettesting` (`statusID`, `serviceType`,`remarks`) VALUES ('1','25','Donation');";
					$resultAssTest=mysqli_query($dbc,$queryAssTest);
						
					//GET LATEST ASSET TEST
					$queryLatAss="SELECT * FROM `thesis`.`assettesting` order by testingID desc limit 1";
					$resultLatAss=mysqli_query($dbc,$queryLatAss);
					$rowLatAss=mysqli_fetch_array($resultLatAss,MYSQLI_ASSOC);
					
					//CREATE TICKET FOR ESCALATION
					$queryEsc="INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `testingID`, `serviceType`, `requestedBy`) VALUES ('5', '{$escEng}', '{$_SESSION['userID']}', now(), now(), '{$_POST['dueDate']}', '{$rowOut['priority']}', '{$rowLatAss['testingID']}', '25', '{$rowOut['requestedBy']}')";
					$resultEsc=mysqli_query($dbc,$queryEsc);
						
					//GET LATEST TICKET
					$queryLatTic="SELECT * FROM `thesis`.`ticket` order by ticketID desc limit 1";
					$resultLatTic=mysqli_query($dbc,$queryLatTic);
					$rowLatTic=mysqli_fetch_array($resultLatTic,MYSQLI_ASSOC);
					
					//INSERT TO NOTIFICATIONS TABLE
					$sqlNotif = "INSERT INTO `thesis`.`notifications` (`isRead`, `ticketID`) VALUES (false, '{$rowLatTic['ticketID']}');";
					$resultNotif = mysqli_query($dbc, $sqlNotif);
					
					foreach (array_combine($_POST['forEscAsset'], $escEngineer) as $forEscAss => $escEngi){
						if($escEngi==$escEng){
							//INSERT TO ASSETTESTDETAILS
							$queryAtd="INSERT INTO `thesis`.`assettesting_details` (`assettesting_testingID`, `asset_assetID`) VALUES ('{$rowLatAss['testingID']}', '{$forEscAss}')";
							$resultAtd=mysqli_query($dbc,$queryAtd);
								
							//DELETE ASSET TO ASSET TESTING
							$queryDelAss="DELETE FROM `thesis`.`assettesting_details` WHERE `assettesting_testingID`='{$rowTestID['testingID']}' and `asset_assetID`='{$forEscAss}'";
							$resultDelAss=mysqli_query($dbc,$queryDelAss);
							
							//INSERT TO TICKETEDASSET
							$queryTicAss="INSERT INTO `thesis`.`ticketedasset` (`ticketID`, `assetID`) VALUES ('{$rowLatTic['ticketID']}', '{$forEscAss}');";
							$resultTicAss=mysqli_query($dbc,$queryTicAss);
							
							//INSERT TO ASSET AUDIT
							$queryAssAud="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `ticketID`, `assetStatus`) VALUES ('{$_SESSION['userID']}', now(), '{$forEscAss}', '{$rowLatTic['ticketID']}', '8');";
							$resultAssAud=mysqli_query($dbc,$queryAssAud);
							
							//DELETE ASSET TO TICKETEDASSET
							$queryDelTic="DELETE FROM `thesis`.`ticketedasset` WHERE `ticketID`='{$ticketID}' and `assetID`='{$forEscAss}'";
							$resultDelTic=mysqli_query($dbc,$queryDelTic);
						}
					}
					
				}
			}
			elseif($row7['remarks']=="Borrow"){
				//GET BORROW ID
				$queryBorID="SELECT * FROM thesis.ticket t join assettesting at on t.testingID=at.testingID where t.ticketID='{$ticketID}'";
				$resultBorID=mysqli_query($dbc,$queryBorID);
				$rowBorID=mysqli_fetch_array($resultBorID,MYSQLI_ASSOC);
						
				//GET BORROW DATA
				$queryBorDat="SELECT * FROM thesis.request_borrow where borrowID='{$rowBorID['borrowID']}'";
				$resultBorDat=mysqli_query($dbc,$queryBorDat);
				$rowBorDat=mysqli_fetch_array($resultBorDat,MYSQLI_ASSOC);
				
				foreach($escEngineerUniq as $escEng){
					//CREATE ASSETTESTING
					$queryAssTest="INSERT INTO `thesis`.`assettesting` (`statusID`, `PersonRequestedID`, `FloorAndRoomID`, `serviceType`,`remarks`, `borrowID`) VALUES ('1', '{$rowBorDat['personresponsibleID']}', '{$rowBorDat['FloorAndRoomID']}', '25', 'Borrow', '{$rowBorID['borrowID']}');";
					$resultAssTest=mysqli_query($dbc,$queryAssTest);
						
					//GET LATEST ASSET TEST
					$queryLatAss="SELECT * FROM `thesis`.`assettesting` order by testingID desc limit 1";
					$resultLatAss=mysqli_query($dbc,$queryLatAss);
					$rowLatAss=mysqli_fetch_array($resultLatAss,MYSQLI_ASSOC);
					
					//CREATE TICKET FOR ESCALATION
					$queryEsc="INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `testingID`, `serviceType`, `requestedBy`) VALUES ('5', '{$escEng}', '{$_SESSION['userID']}', now(), now(), '{$_POST['dueDate']}', '{$rowOut['priority']}', '{$rowLatAss['testingID']}', '25', '{$rowOut['requestedBy']}')";
					$resultEsc=mysqli_query($dbc,$queryEsc);
						
					//GET LATEST TICKET
					$queryLatTic="SELECT * FROM `thesis`.`ticket` order by ticketID desc limit 1";
					$resultLatTic=mysqli_query($dbc,$queryLatTic);
					$rowLatTic=mysqli_fetch_array($resultLatTic,MYSQLI_ASSOC);
					
					//INSERT TO NOTIFICATIONS TABLE
					$sqlNotif = "INSERT INTO `thesis`.`notifications` (`isRead`, `ticketID`) VALUES (false, '{$rowLatTic['ticketID']}');";
					$resultNotif = mysqli_query($dbc, $sqlNotif);
					
					foreach (array_combine($_POST['forEscAsset'], $escEngineer) as $forEscAss => $escEngi){
						if($escEngi==$escEng){
							//INSERT TO ASSETTESTDETAILS
							$queryAtd="INSERT INTO `thesis`.`assettesting_details` (`assettesting_testingID`, `asset_assetID`) VALUES ('{$rowLatAss['testingID']}', '{$forEscAss}')";
							$resultAtd=mysqli_query($dbc,$queryAtd);
								
							//DELETE ASSET TO ASSET TESTING
							$queryDelAss="DELETE FROM `thesis`.`assettesting_details` WHERE `assettesting_testingID`='{$rowTestID['testingID']}' and `asset_assetID`='{$forEscAss}'";
							$resultDelAss=mysqli_query($dbc,$queryDelAss);
							
							//INSERT TO TICKETEDASSET
							$queryTicAss="INSERT INTO `thesis`.`ticketedasset` (`ticketID`, `assetID`) VALUES ('{$rowLatTic['ticketID']}', '{$forEscAss}');";
							$resultTicAss=mysqli_query($dbc,$queryTicAss);
							
							//INSERT TO ASSET AUDIT
							$queryAssAud="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `ticketID`, `assetStatus`) VALUES ('{$_SESSION['userID']}', now(), '{$forEscAss}', '{$rowLatTic['ticketID']}', '8');";
							$resultAssAud=mysqli_query($dbc,$queryAssAud);
							
							//DELETE ASSET TO TICKETEDASSET
							$queryDelTic="DELETE FROM `thesis`.`ticketedasset` WHERE `ticketID`='{$ticketID}' and `assetID`='{$forEscAss}'";
							$resultDelTic=mysqli_query($dbc,$queryDelTic);
						}
					}
					
				}
			}
			elseif($row7['remarks']=="Replacement"){
				//GET Replacement DATA
				$queryRepDat="SELECT * FROM thesis.assettesting at join replacement r on at.replacementID=r.replacementID where at.testingID='{$rowTestID['testingID']}'";
				$resultRepDat=mysqli_query($dbc,$queryRepDat);
				$rowRepDat=mysqli_fetch_array($resultRepDat,MYSQLI_ASSOC);
				
				foreach($escEngineerUniq as $escEng){
					//CREATE ASSETTESTING
					$queryAssTest="INSERT INTO `thesis`.`assettesting` (`statusID`, `PersonRequestedID`, `serviceType`, `remarks`, `replacementID`) VALUES ('1', '{$_SESSION['userID']}', '25', 'Replacement', '{$rowRepDat['replacementID']}');";
					$resultAssTest=mysqli_query($dbc,$queryAssTest);
						
					//GET LATEST ASSET TEST
					$queryLatAss="SELECT * FROM `thesis`.`assettesting` order by testingID desc limit 1";
					$resultLatAss=mysqli_query($dbc,$queryLatAss);
					$rowLatAss=mysqli_fetch_array($resultLatAss,MYSQLI_ASSOC);
					
					//CREATE TICKET FOR ESCALATION
					$queryEsc="INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `testingID`, `serviceType`, `requestedBy`) VALUES ('5', '{$escEng}', '{$_SESSION['userID']}', now(), now(), '{$_POST['dueDate']}', '{$rowOut['priority']}', '{$rowLatAss['testingID']}', '25', '{$rowOut['requestedBy']}')";
					$resultEsc=mysqli_query($dbc,$queryEsc);
						
					//GET LATEST TICKET
					$queryLatTic="SELECT * FROM `thesis`.`ticket` order by ticketID desc limit 1";
					$resultLatTic=mysqli_query($dbc,$queryLatTic);
					$rowLatTic=mysqli_fetch_array($resultLatTic,MYSQLI_ASSOC);
					
					//INSERT TO NOTIFICATIONS TABLE
					$sqlNotif = "INSERT INTO `thesis`.`notifications` (`isRead`, `ticketID`) VALUES (false, '{$rowLatTic['ticketID']}');";
					$resultNotif = mysqli_query($dbc, $sqlNotif);
					
					foreach (array_combine($_POST['forEscAsset'], $escEngineer) as $forEscAss => $escEngi){
						if($escEngi==$escEng){
							//INSERT TO ASSETTESTDETAILS
							$queryAtd="INSERT INTO `thesis`.`assettesting_details` (`assettesting_testingID`, `asset_assetID`) VALUES ('{$rowLatAss['testingID']}', '{$forEscAss}')";
							$resultAtd=mysqli_query($dbc,$queryAtd);
								
							//DELETE ASSET TO ASSET TESTING
							$queryDelAss="DELETE FROM `thesis`.`assettesting_details` WHERE `assettesting_testingID`='{$rowTestID['testingID']}' and `asset_assetID`='{$forEscAss}'";
							$resultDelAss=mysqli_query($dbc,$queryDelAss);
							
							//INSERT TO TICKETEDASSET
							$queryTicAss="INSERT INTO `thesis`.`ticketedasset` (`ticketID`, `assetID`) VALUES ('{$rowLatTic['ticketID']}', '{$forEscAss}');";
							$resultTicAss=mysqli_query($dbc,$queryTicAss);
							
							//INSERT TO ASSET AUDIT
							$queryAssAud="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `ticketID`, `assetStatus`) VALUES ('{$_SESSION['userID']}', now(), '{$forEscAss}', '{$rowLatTic['ticketID']}', '8');";
							$resultAssAud=mysqli_query($dbc,$queryAssAud);
							
							//DELETE ASSET TO TICKETEDASSET
							$queryDelTic="DELETE FROM `thesis`.`ticketedasset` WHERE `ticketID`='{$ticketID}' and `assetID`='{$forEscAss}'";
							$resultDelTic=mysqli_query($dbc,$queryDelTic);
						}
					}
					
				}
			}
			//Check if final asset testing details is empty
			$queryAssTestIsEx="SELECT count(*) as `isExist` FROM thesis.assettesting_details where assettesting_testingID='{$rowTestID['testingID']}'";
			$resultAssTestIsEx=mysqli_query($dbc,$queryAssTestIsEx);
			$rowAssTestIsEx=mysqli_fetch_array($resultAssTestIsEx,MYSQLI_ASSOC);
				
			if($rowAssTestIsEx['isExist']=='0'){
				//Set Asset testing id in ticket to null
				$querySetAssTestID="UPDATE `thesis`.`ticket` SET `testingID` = null WHERE (`ticketID` = '{$ticketID}');";
				$resultSetAssTestID=mysqli_query($dbc,$querySetAssTestID);
					
				//Delete Asset TESTING
				$queryDelAssTest="Delete FROM thesis.assettesting where testingID='{$rowTestID['testingID']}'";
				$resultDelAssTest=mysqli_query($dbc,$queryDelAssTest);
			}
		}
		
		//GET NEW ASSET TESTING DATA
		$queryNewAssTest="SELECT * FROM thesis.ticket where ticketID='{$ticketID}'";
		$resultNewAssTest=mysqli_query($dbc,$queryNewAssTest);
		$rowNewAssTest = mysqli_fetch_array($resultNewAssTest, MYSQLI_ASSOC);
		
		if(isset($rowNewAssTest['testingID'])){
			//UPDATE ASSET TESTING STATUS
			$query8="UPDATE `thesis`.`assettesting` SET `statusID`='7', `endTestDate`=now() WHERE `testingID`='{$rowNewAssTest['testingID']}'";
			$result8=mysqli_query($dbc,$query8);
		
			//INSERT TO NOTIFICATIONS TABLE
			$sqlNotif = "INSERT INTO `thesis`.`notifications` (`isRead`, `testingID`) VALUES (false, '{$rowNewAssTest['testingID']}');";
			$resultNotif = mysqli_query($dbc, $sqlNotif);
		}
		
		//UPDATE TICKET STATUS TO CLOSED
		$queryTicStat="UPDATE `thesis`.`ticket` SET `status`='7', `dateClosed`=now() WHERE `ticketID`='{$ticketID}'";
		$resultTicStat=mysqli_query($dbc,$queryTicStat);
		
		if(!isset($message)){
			$message = "Form submitted!";
			$_SESSION['submitMessage'] = $message; 
		}
		
	}
	
	
	
?>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="images/favicon.png">

    <title>DLSU IT Asset Management</title>

    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />

    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
</head>

<body>

    <section id="container">
        <!--header start-->
        <header class="header fixed-top clearfix">
            <!--logo start-->
            <div class="brand">

                <a href="#" class="logo">
                    <img src="images/dlsulogo.png" alt="" width="200px" height="40px">
                </a>
            </div>

            <div class="nav notify-row" id="top_menu">

            </div>

        </header>
        <!--header end-->
        <?php include 'engineer_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->
                <?php
                    if (isset($_SESSION['submitMessage']) && $_SESSION['submitMessage']=="Form submitted!"){

                        echo "<div class='alert alert-success'>
                                {$_SESSION['submitMessage']}
							  </div>";
                        unset($_SESSION['submitMessage']);
                    }
					elseif(isset($_SESSION['submitMessage'])){
						 echo "<div class='alert alert-danger'>
                                {$_SESSION['submitMessage']}
							  </div>";
						 unset($_SESSION['submitMessage']);
					}
				?>
                <form class="cmxform form-horizontal " id="signupForm" method="post" action="">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="row">
                                <div class="col-sm-9">
                                    <section class="panel">
                                        <header class="panel-heading">
                                            Asset Testing Checklist
                                        </header>
                                        <div class="panel-body">

                                            <div class="panel-body">
                                                <section>
                                                    <label>
                                                        <h5>Name:</h5>
                                                    </label><input type="text" value="<?php echo $rowOut['empName']; ?>" class="form-control" disabled>
                                                    <br>
                                                    <!--	<label><h5>Office Building: </h5></label><input type="text" class="form-control" disabled> 
											<br> -->
                                                    <!--	<label><h5>Room Number: </h5></label><input type="text" value="<?php //echo $rowx['floorRoom']; ?>" class="form-control" disabled> -->

                                                </section>
                                            </div>

                                            <section>
                                                <br>
                                            </section>

                                            <section id="unseen">

                                                <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align:center">Brand</th>
                                                            <th style="text-align:center">Model</th>
                                                            <th>Asset Status</th>
                                                            <th>Escalated To</th>
															<th style="text-align:center">Comments</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
														$query = "SELECT atd.asset_assetID as `assetID`,rb.name as `brand`, am.description as `model` FROM thesis.assettesting_details atd join assettesting at on atd.assettesting_testingID=at.testingID 
																	  join ticket t on at.testingID=t.testingID
																	  join asset a on atd.asset_assetID=a.assetID
																	  join assetmodel am on a.assetModel=am.assetModelID
																	  join ref_brand rb on am.brand=rb.brandID
																	  where t.ticketID='{$ticketID}'";
                                                                  
														$result = mysqli_query($dbc, $query);
                                                    
														while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
															$idDisapp="Disapp_".$row['assetID'];
															$idWorking="Working_".$row['assetID'];
															$idForEsc="ForEsc_".$row['assetID'];
															$idEscEng="escalateEng_".$row['assetID'];
															echo "<tr>
																<td style='text-align:center'>{$row['brand']}</td>
																<td style='text-align:center'>{$row['model']}</td>
																<td>
																	<select id='assetStatus_".$row['assetID']."' name='testStat[]' class='form-control' onchange='checkValue(\"{$row['assetID']}\")' required>
																		<option value=''>Select Asset Status</option>
																		<option value='1'>Working</option>
																		<option value='2'>Escalated To</option>
																		<option value='3'>Defective</option>
																	</select>
																</td>
																<td>
																	<select class='form-control' id='{$idEscEng}' name='escEngineer[]' required disabled>
																		<option value=''>Select Engineer</option>";
																		//GET List Of Engineers
																		$queryListEng = "SELECT * FROM thesis.employee e join user u on e.UserID=u.UserID where u.userType='4'";
																		$resultListEng = mysqli_query($dbc, $queryListEng);
																		while ($rowListEng = mysqli_fetch_array($resultListEng, MYSQLI_ASSOC)){
																			if($_SESSION['userID']!=$rowListEng['UserID']){
																				echo "<option value='{$rowListEng['UserID']}'>{$rowListEng['name']}</option>";
																			}
																		}

																
																echo "</select>
																</td>
																<td><input style='text' id='{$row['assetID']}' name='comments[]' class='form-control comments'></td>
																<input type='hidden' id='{$idDisapp}' name='disapprovedAsset[]' value='{$row['assetID']}'>
																<input type='hidden' id='{$idWorking}' name='workingAsset[]' value='{$row['assetID']}'>
																<input type='hidden' id='{$idForEsc}' name='forEscAsset[]' value='{$row['assetID']}'>
																<input type='hidden' name='listOfTestAss[]' value='{$row['assetID']}'>
																</tr>";
														}
													
													
													
													
													
													?>
                                                        <!-- <tr>
                                                           
                                                            <td style="text-align:center">Apple Tablet</td>
                                                            <td style="text-align:center">iPad</td>
                                                            
                                                            <td>
                                                                <select id="assetStatus" class="form-control" onchange="checkValue()">
                                                                    <option value="0">Select Asset Status</option>
                                                                    <option value="1">Working</option>
                                                                    <option value="2">Escalated To</option>
                                                                    <option value="3">Defective</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control" id="escalateEng" disabled>
                                                                    <option value="0">Select Engineer</option>
                                                                </select>
                                                            </td>
															<td><input style="text" class="form-control"></td>
                                                        </tr> -->
                                                    </tbody>
                                                </table>




                                                <div>
                                                    <button onclick="return confirm('Confirm checklist?')" type="submit" name="save" id="save" class="btn btn-success" data-dismiss="modal">Save</button>
                                                    <!-- <button onclick="return confirm('Confirm checklist?')" type="button" class="btn btn-success" data-dismiss="modal">Save</button> -->
                                                    <a href="engineer_all_ticket.php"><button type="button" class="btn btn-danger" data-dismiss="modal">Back</button></a>
                                                </div>

                                            </section>
                                        </div>
                                    </section>
                                </div>


                                <div class="col-sm-3">
                                    <section class="panel">
                                        <div class="panel-body">
                                            <ul class="nav nav-pills nav-stacked labels-info ">
                                                <li>
                                                    <h4>Properties</h4>
                                                </li>
                                            </ul>
                                            <div class="form">

                                                <div class="form-group ">
                                                    <div class="form-group ">
                                                        <label style="padding-left:22px" for="category" class="control-label col-lg-4">Category</label>
                                                        <div class="col-lg-8" style="padding-right:30px">
                                                            <select class="form-control m-bot15" name="category" disabled>
                                                                <?php
																	$query2 = "SELECT * FROM thesis.ref_servicetype";
																	$result2 = mysqli_query($dbc, $query2);
																	while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
																		if($row2['id']==25){
																			echo "<option selected value='{$row2['id']}'>{$row2['serviceType']}</option>";
																		}
																		else{
																			echo "<option value='{$row2['id']}'>{$row2['serviceType']}</option>";
																		}
																	}
																
																?>
                                                                <!-- <option selected="selected">Repair</option>
																<option>Repair</option>
																<option>Maintenance</option>
																<option>Replacement</option> -->
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <label for="status" class="control-label col-lg-4">Status</label>
                                                    <div class="col-lg-8">
                                                        <select class="form-control m-bot15" name="status" value="<?php if (isset($_POST['status']) && !$flag) echo $_POST['status']; ?>" disabled>
                                                            <?php
																$query1 = "SELECT * FROM thesis.ref_ticketstatus";
																$result1 = mysqli_query($dbc, $query1);
																while($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)){
																	if($row1['ticketID']==2){
																		echo "<option disabled selected value='{$row1['ticketID']}' >{$row1['status']}</option>";
																	}
																	else{
																		echo "<option value='{$row1['ticketID']}'>{$row1['status']}</option>";
																	}
																}

															
															?>

                                                            <!--<option>Assigned</option>
															<option>In Progress</option>
															<option selected="selected">Transferred</option>
															<option>Escalated</option>
															<option>Waiting For Parts</option>
															<option>Closed</option> -->
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group ">
                                                    <label for="priority" class="control-label col-lg-4">Priority</label>
                                                    <div class="col-lg-8">
                                                        <select class="form-control m-bot15" id="priority" name="priority" value="<?php if (isset($_POST['priority']) && !$flag) echo $_POST['priority']; ?>" disabled>
                                                            <option value="">Select Priority</option>
															<?php
																if($rowOut['priority']=='Low'){
																	echo "  <option value='Low' selected>Low</option>
																			<option value='Medium'>Medium</option>
																			<option value='High'>High</option>
																			<option value='Urgent'>Urgent</option>";
																}
																elseif($rowOut['priority']=='Medium'){
																	echo "  <option value='Low'>Low</option>
																			<option value='Medium' selected>Medium</option>
																			<option value='High'>High</option>
																			<option value='Urgent'>Urgent</option>";
																}
																elseif($rowOut['priority']=='High'){
																	echo "  <option value='Low'>Low</option>
																			<option value='Medium'>Medium</option>
																			<option value='High' selected>High</option>
																			<option value='Urgent'>Urgent</option>";
																}
																elseif($rowOut['priority']=='Urgent'){
																	echo "  <option value='Low' selected>Low</option>
																			<option value='Medium'>Medium</option>
																			<option value='High'>High</option>
																			<option value='Urgent' selected>Urgent</option>";
																}
															?>
                                                            
                                                        </select>
                                                    </div>
                                                </div>

                                                

                                                <div class="form-group">
                                                    <label class="control-label col-lg-4">Due Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control form-control-inline input-medium default-date-picker" name="dueDate" size="10" type="datetime" value="<?php echo $rowOut['dueDate']; ?>" readonly />
                                                    </div>
                                                </div>

                                                <!-- <div class="form-group">
													<label class="control-label col-lg-4">Repair Date *</label>
													<div class="col-lg-8">
														<input class="form-control form-control-inline input-medium default-date-picker" name="repairDate" size="10" type="date" value="<?php if (isset($_POST['repairDate']) && !$flag) echo $_POST['repairDate']; ?>" />
													</div>
												</div> -->

                                            </div>

                                        </div>
                                    </section>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>

    <!-- WAG GALAWIN PLS LANG -->


    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

    <script type="text/javascript">
        // Shorthand for $( document ).ready()
        $(function() {

        });

        function addTest() {
            var row_index = 0;
            var isRenderd = false;

            $("td").click(function() {
                row_index = $(this).parent().index();

            });

            var delayInMilliseconds = 300; //1 second

            setTimeout(function() {

                appendTableRow(row_index);
            }, delayInMilliseconds);



        }

        var appendTableRow = function(rowCount) {
            var cnt = 0
            var tr = "<tr>" +
                "<td style=''></td>" +
                "<td></td>" +
                "<td></td>" +
                "<td>" +
                "<div>" +
                "<label class='form-inline'>" +
                "<input type='checkbox' class='form-check-input' hidden><input style='width:300px' type='text' class='form-control'></label></div>" +
                "</td>" +
                "<td><button class='btn btn-danger' onclick='removeRow(this)'> Remove </button></td>" +
                "</tr>";
            $('#tableTest tbody tr').eq(rowCount).after(tr);
        }

        //$('.myCheck').change(function() {
            //var disapp = "Disapp_" + this.value;
            //if ($(this).is(':checked')) {
                // Checkbox is checked..

                //document.getElementById(this.value).required = false;
                //document.getElementById(this.value).disabled = true;
                //document.getElementById(disapp).disabled = true;

            //} else {
                // Checkbox is not checked..

                //document.getElementById(this.value).required = true;
              //  document.getElementById(this.value).disabled = false;
                //document.getElementById(disapp).disabled = false;


            //}
        //});
		
		function checkValue(x) {
			
			var disapp = "Disapp_" + x;
			var working = "Working_" + x
			var forEsc = "ForEsc_" + x;
			var escEng = "escalateEng_" + x;
			var selectID = "assetStatus_" + x;
			
			//Working stat
			if(document.getElementById(selectID).value == "1"){
				//comments
				document.getElementById(x).disabled = true;
				
				//for asset stat
				document.getElementById(forEsc).disabled = true;
                
				//for esc engineer
				document.getElementById(escEng).disabled = true;
			}
			//Escalate stat
            else if(document.getElementById(selectID).value == "2"){
				//comments
				document.getElementById(x).disabled = true;
				
				//for asset stat
				document.getElementById(forEsc).disabled = false;
				
				//for esc engineer
				document.getElementById(escEng).disabled = false;
				
            }
			else{
				//comments
				document.getElementById(x).disabled = false;
				
				//for asset stat
				document.getElementById(forEsc).disabled = true;
				
				//for esc engineer
				document.getElementById(escEng).disabled = true;
				
            }
        }
		
        $('#save').click(function() {
            var isExist = false;
            for (var i = 0; i < document.getElementsByClassName("comments").length; i++) {
                if (document.getElementsByClassName("comments")[i].value == '' && !document.getElementsByClassName("comments")[i].disabled) {
                    isExist = true;
                }
            }
            if (isExist) {
                document.getElementById("priority").required = true;
                document.getElementById("escalate").required = true;
            } else {
                document.getElementById("priority").required = false;
                document.getElementById("escalate").required = false;
            }
        });

        //$('select').on('change', function() {
        //alert( this.value );
        //});

        
    </script>




</body>

</html>