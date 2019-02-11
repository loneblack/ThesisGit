<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	$userid=$_SESSION['userID'];
	$ticketID=$_GET['id'];
		
	//$queryx = "SELECT CONCAT(Convert(AES_DECRYPT(u.lastName,'Fusion')USING utf8),' ',Convert(AES_DECRYPT(u.firstName,'Fusion')USING utf8)) as `fullname`,far.floorRoom,t.dueDate FROM thesis.ticket t join assettesting at on t.testingID=at.testingID 
	//										 join user u on at.PersonRequestedID=u.UserID 
	//										 join floorandroom far on at.FloorAndRoomID=far.FloorAndRoomID
	//										 where t.ticketID='{$ticketID}'";
	//For Users
	$queryx = "SELECT CONCAT(Convert(AES_DECRYPT(u.lastName,'Fusion')USING utf8),' ',Convert(AES_DECRYPT(u.firstName,'Fusion')USING utf8)) as `fullname`,t.dueDate FROM thesis.ticket t join assettesting at on t.testingID=at.testingID 
											 join user u on at.PersonRequestedID=u.UserID 
											 where t.ticketID='{$ticketID}'";
    $resultx = mysqli_query($dbc, $queryx);
	$rowx = mysqli_fetch_array($resultx, MYSQLI_ASSOC);
	
	$queryOut = "SELECT t.dueDate FROM thesis.ticket t join assettesting at on t.testingID=at.testingID 
											 where t.ticketID='{$ticketID}'";
    $resultOut = mysqli_query($dbc, $queryOut);
	$rowOut = mysqli_fetch_array($resultOut, MYSQLI_ASSOC);
	
	$query7="SELECT COUNT(atd.asset_assetID) as `numAssets`,at.testingID,at.remarks FROM thesis.assettesting_details atd join assettesting at on atd.assettesting_testingID=at.testingID 
																	  join ticket t on at.testingID=t.testingID
																	  where t.ticketID='{$ticketID}'";
	$result7=mysqli_query($dbc,$query7);
	$row7 = mysqli_fetch_array($result7, MYSQLI_ASSOC);
	
	if(isset($_POST['save'])){
		$message=null;
		//ASSET Request Code
		if($row7['remarks']=="Asset Request"){
			//For functioning assets
			if(!empty($_POST['funcAsset'])){
				$funcAsset=$_POST['funcAsset'];
				
				foreach($funcAsset as $value){
					$query5="UPDATE `thesis`.`assettesting_details` SET `check`='1' WHERE `assettesting_testingID`='{$row7['testingID']}' and asset_assetID='{$value}'";
					$result5=mysqli_query($dbc,$query5);
				}
			}
			
			if(!empty($_POST['disapprovedAsset'])){
				
				//For defected assets
				$disapprovedAsset=$_POST['disapprovedAsset'];
				$comments=$_POST['comments'];
				
				//CHECK IF THERE'S AN EMPTY COMMENT FOR ESCALATION
				$isThereEmp=false;
				foreach($comments as $isThere){
					if(empty($isThere)){
						$isThereEmp=true;
					}
				}
				//Escalate Code
				if($isThereEmp){
					if(isset($_POST['priority'])&&isset($_POST['escalate'])){
						//GETTESTINGID
						$queryTestID = "SELECT * FROM thesis.ticket where ticketID='{$ticketID}'";
						$resultTestID = mysqli_query($dbc, $queryTestID);
						$rowTestID = mysqli_fetch_array($resultTestID, MYSQLI_ASSOC);
						
						//GET REQUEST DATA
						$queryReqDat="SELECT ad.requestID,r.UserID,r.FloorAndRoomID FROM thesis.assettesting_details atd join asset a on atd.asset_assetID=a.assetID
																							   join assetdocument ad on a.assetID=ad.assetID
																							   join request r on ad.requestID=r.requestID 
																							   where atd.assettesting_testingID='{$rowTestID['testingID']}' limit 1";
						$resultReqDat=mysqli_query($dbc,$queryReqDat);
						$rowReqDat=mysqli_fetch_array($resultReqDat,MYSQLI_ASSOC);
						
						//CREATE ASSETTESTING
						$queryAssTest="INSERT INTO `thesis`.`assettesting` (`statusID`, `PersonRequestedID`, `FloorAndRoomID`, `serviceType`,`remarks`) VALUES ('1', '{$rowReqDat['UserID']}', '{$rowReqDat['FloorAndRoomID']}', '25', 'Asset Request');";
						$resultAssTest=mysqli_query($dbc,$queryAssTest);
						
						//GET LATEST ASSET TEST
						$queryLatAss="SELECT * FROM `thesis`.`assettesting` order by testingID desc limit 1";
						$resultLatAss=mysqli_query($dbc,$queryLatAss);
						$rowLatAss=mysqli_fetch_array($resultLatAss,MYSQLI_ASSOC);
						
						//INSERT TO ASSETTESTDETAILS
						foreach(array_combine($disapprovedAsset, $comments) as $escAsset => $com){
							if(empty($com)){
								$queryAtd="INSERT INTO `thesis`.`assettesting_details` (`assettesting_testingID`, `asset_assetID`) VALUES ('{$rowLatAss['testingID']}', '{$escAsset}')";
								$resultAtd=mysqli_query($dbc,$queryAtd);
								
								//DELETE ASSET TO ASSET TESTING
								$queryDelAss="DELETE FROM `thesis`.`assettesting_details` WHERE `assettesting_testingID`='{$rowTestID['testingID']}' and `asset_assetID`='{$escAsset}'";
								$resultDelAss=mysqli_query($dbc,$queryDelAss);
							}
						}
						
						//CREATE TICKET FOR ESCALATION
						$queryEsc="INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `testingID`, `serviceType`) VALUES ('5', '{$_POST['escalate']}', '{$_SESSION['userID']}', now(), now(), '{$_POST['dueDate']}', '{$_POST['priority']}', '{$rowLatAss['testingID']}', '25')";
						$resultEsc=mysqli_query($dbc,$queryEsc);
						
						//GET LATEST TICKET
						$queryLatTic="SELECT * FROM `thesis`.`ticket` order by ticketID desc limit 1";
						$resultLatTic=mysqli_query($dbc,$queryLatTic);
						$rowLatTic=mysqli_fetch_array($resultLatTic,MYSQLI_ASSOC);
						
						//INSERT TO TICKETEDASSET
						foreach(array_combine($disapprovedAsset, $comments) as $escAsset => $com){
							if(empty($com)){
								$queryTicAss="INSERT INTO `thesis`.`ticketedasset` (`ticketID`, `assetID`) VALUES ('{$rowLatTic['ticketID']}', '{$escAsset}');";
								$resultTicAss=mysqli_query($dbc,$queryTicAss);
								
								//DELETE ASSET TO TICKETEDASSET
								$queryDelTic="DELETE FROM `thesis`.`ticketedasset` WHERE `ticketID`='{$ticketID}' and `assetID`='{$escAsset}'";
								$resultDelTic=mysqli_query($dbc,$queryDelTic);
							}
						}
					}
							
				}
					
				//For defected asset code
				foreach (array_combine($disapprovedAsset, $comments) as $value1 => $value2){
					if(!empty($value2)){
						$query6="UPDATE `thesis`.`assettesting_details` SET `check`='0',`comment`='{$value2}' WHERE `assettesting_testingID`='{$row7['testingID']}' and asset_assetID='{$value1}'";
						$result6=mysqli_query($dbc,$query6);
					}
				}
			}
		}
		//DONATION CODE
		elseif($row7['remarks']=="Donation"){
			//For functioning assets
			if(!empty($_POST['funcAsset'])){
				$funcAsset=$_POST['funcAsset'];
				
				foreach($funcAsset as $value){
					$query5="UPDATE `thesis`.`assettesting_details` SET `check`='1' WHERE `assettesting_testingID`='{$row7['testingID']}' and asset_assetID='{$value}'";
					$result5=mysqli_query($dbc,$query5);
				}
			}
			
			
			if(!empty($_POST['disapprovedAsset'])){
				
				//For defected assets
				$disapprovedAsset=$_POST['disapprovedAsset'];
				$comments=$_POST['comments'];
				
				//CHECK IF THERE'S AN EMPTY COMMENT FOR ESCALATION
				$isThereEmp=false;
				foreach($comments as $isThere){
					if(empty($isThere)){
						$isThereEmp=true;
					}
				}
				//Escalate Code
				if($isThereEmp){
					if(isset($_POST['priority'])&&isset($_POST['escalate'])){
						//GET TESTINGID
						$queryTestID = "SELECT * FROM thesis.ticket where ticketID='{$ticketID}'";
						$resultTestID = mysqli_query($dbc, $queryTestID);
						$rowTestID = mysqli_fetch_array($resultTestID, MYSQLI_ASSOC);
						
						//GET DONATION DATA
						$queryDonDat="SELECT d.donationID,d.user_UserID as `UserID` FROM thesis.assettesting_details atd join asset a on atd.asset_assetID=a.assetID
																							   join donationdetails_item ddi on a.assetID=ddi.assetID
																							   join donationdetails dd on ddi.id=dd.id
																							   join donation d on dd.donationID=d.donationID
																							   where atd.assettesting_testingID='{$rowTestID['testingID']}' limit 1";
						$resultDonDat=mysqli_query($dbc,$queryDonDat);
						$rowDonDat=mysqli_fetch_array($resultDonDat,MYSQLI_ASSOC);
						
						//CREATE ASSETTESTING
						if(isset($rowDonDat['UserID'])){
							$queryAssTest="INSERT INTO `thesis`.`assettesting` (`statusID`, `PersonRequestedID`, `serviceType`,`remarks`) VALUES ('1', '{$rowDonDat['UserID']}', '25','Donation');";
							$resultAssTest=mysqli_query($dbc,$queryAssTest);
						}
						else{
							$queryAssTest="INSERT INTO `thesis`.`assettesting` (`statusID`, `serviceType`,`remarks`) VALUES ('1','25','Donation');";
							$resultAssTest=mysqli_query($dbc,$queryAssTest);
						}
						
						//GET LATEST ASSET TEST
						$queryLatAss="SELECT * FROM `thesis`.`assettesting` order by testingID desc limit 1";
						$resultLatAss=mysqli_query($dbc,$queryLatAss);
						$rowLatAss=mysqli_fetch_array($resultLatAss,MYSQLI_ASSOC);
						
						//INSERT TO ASSETTESTDETAILS
						foreach(array_combine($disapprovedAsset, $comments) as $escAsset => $com){
							if(empty($com)){
								$queryAtd="INSERT INTO `thesis`.`assettesting_details` (`assettesting_testingID`, `asset_assetID`) VALUES ('{$rowLatAss['testingID']}', '{$escAsset}')";
								$resultAtd=mysqli_query($dbc,$queryAtd);
								
								//DELETE ASSET TO ASSET TESTING
								$queryDelAss="DELETE FROM `thesis`.`assettesting_details` WHERE `assettesting_testingID`='{$rowTestID['testingID']}' and `asset_assetID`='{$escAsset}'";
								$resultDelAss=mysqli_query($dbc,$queryDelAss);
							}
						}
						
						//CREATE TICKET FOR ESCALATION
						$queryEsc="INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `testingID`, `serviceType`) VALUES ('5', '{$_POST['escalate']}', '{$_SESSION['userID']}', now(), now(), '{$_POST['dueDate']}', '{$_POST['priority']}', '{$rowLatAss['testingID']}', '25')";
						$resultEsc=mysqli_query($dbc,$queryEsc);
						
						//GET LATEST TICKET
						$queryLatTic="SELECT * FROM `thesis`.`ticket` order by ticketID desc limit 1";
						$resultLatTic=mysqli_query($dbc,$queryLatTic);
						$rowLatTic=mysqli_fetch_array($resultLatTic,MYSQLI_ASSOC);
						
						//INSERT TO TICKETEDASSET
						foreach(array_combine($disapprovedAsset, $comments) as $escAsset => $com){
							if(empty($com)){
								$queryTicAss="INSERT INTO `thesis`.`ticketedasset` (`ticketID`, `assetID`) VALUES ('{$rowLatTic['ticketID']}', '{$escAsset}');";
								$resultTicAss=mysqli_query($dbc,$queryTicAss);
								
								//DELETE ASSET TO TICKETEDASSET
								$queryDelTic="DELETE FROM `thesis`.`ticketedasset` WHERE `ticketID`='{$ticketID}' and `assetID`='{$escAsset}'";
								$resultDelTic=mysqli_query($dbc,$queryDelTic);
							}
						}
					}
							
				}
					
				//For defected asset code
				foreach (array_combine($disapprovedAsset, $comments) as $value1 => $value2){
					if(!empty($value2)){
						$query6="UPDATE `thesis`.`assettesting_details` SET `check`='0',`comment`='{$value2}' WHERE `assettesting_testingID`='{$row7['testingID']}' and asset_assetID='{$value1}'";
						$result6=mysqli_query($dbc,$query6);
					}
				}
			}
			
		}
		
		//Borrow
		elseif($row7['remarks']=="Borrow"){
			//For functioning assets
			if(!empty($_POST['funcAsset'])){
				$funcAsset=$_POST['funcAsset'];
				
				foreach($funcAsset as $value){
					$query5="UPDATE `thesis`.`assettesting_details` SET `check`='1' WHERE `assettesting_testingID`='{$row7['testingID']}' and asset_assetID='{$value}'";
					$result5=mysqli_query($dbc,$query5);
				}
			}
			
			if(!empty($_POST['disapprovedAsset'])){
				
				//For defected assets
				$disapprovedAsset=$_POST['disapprovedAsset'];
				$comments=$_POST['comments'];
				
				//CHECK IF THERE'S AN EMPTY COMMENT FOR ESCALATION
				$isThereEmp=false;
				foreach($comments as $isThere){
					if(empty($isThere)){
						$isThereEmp=true;
					}
				}
				//Escalate Code
				if($isThereEmp){
					if(isset($_POST['priority'])&&isset($_POST['escalate'])){
						//GETTESTINGID
						$queryTestID = "SELECT * FROM thesis.ticket where ticketID='{$ticketID}'";
						$resultTestID = mysqli_query($dbc, $queryTestID);
						$rowTestID = mysqli_fetch_array($resultTestID, MYSQLI_ASSOC);
						
						//GET BORROW ID
						$queryBorID="SELECT * FROM thesis.ticket t join assettesting at on t.testingID=at.testingID where t.ticketID='{$ticketID}'";
						$resultBorID=mysqli_query($dbc,$queryBorID);
						$rowBorID=mysqli_fetch_array($resultBorID,MYSQLI_ASSOC);
						
						//GET BORROW DATA
						$queryBorDat="SELECT * FROM thesis.request_borrow where borrowID='{$rowBorID['borrowID']}'";
						$resultBorDat=mysqli_query($dbc,$queryBorDat);
						$rowBorDat=mysqli_fetch_array($resultBorDat,MYSQLI_ASSOC);
						
						//CREATE ASSETTESTING
						$queryAssTest="INSERT INTO `thesis`.`assettesting` (`statusID`, `PersonRequestedID`, `FloorAndRoomID`, `serviceType`,`remarks`, `borrowID`) VALUES ('1', '{$rowBorDat['personresponsibleID']}', '{$rowBorDat['FloorAndRoomID']}', '25', 'Borrow', '{$rowBorID['borrowID']}');";
						$resultAssTest=mysqli_query($dbc,$queryAssTest);
						
						//GET LATEST ASSET TEST
						$queryLatAss="SELECT * FROM `thesis`.`assettesting` order by testingID desc limit 1";
						$resultLatAss=mysqli_query($dbc,$queryLatAss);
						$rowLatAss=mysqli_fetch_array($resultLatAss,MYSQLI_ASSOC);
						
						//INSERT TO ASSETTESTDETAILS
						foreach(array_combine($disapprovedAsset, $comments) as $escAsset => $com){
							if(empty($com)){
								$queryAtd="INSERT INTO `thesis`.`assettesting_details` (`assettesting_testingID`, `asset_assetID`) VALUES ('{$rowLatAss['testingID']}', '{$escAsset}')";
								$resultAtd=mysqli_query($dbc,$queryAtd);
								
								//DELETE ASSET TO ASSET TESTING
								$queryDelAss="DELETE FROM `thesis`.`assettesting_details` WHERE `assettesting_testingID`='{$rowTestID['testingID']}' and `asset_assetID`='{$escAsset}'";
								$resultDelAss=mysqli_query($dbc,$queryDelAss);
							}
						}
						
						//CREATE TICKET FOR ESCALATION
						$queryEsc="INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `testingID`, `serviceType`) VALUES ('5', '{$_POST['escalate']}', '{$_SESSION['userID']}', now(), now(), '{$_POST['dueDate']}', '{$_POST['priority']}', '{$rowLatAss['testingID']}', '25')";
						$resultEsc=mysqli_query($dbc,$queryEsc);
						
						//GET LATEST TICKET
						$queryLatTic="SELECT * FROM `thesis`.`ticket` order by ticketID desc limit 1";
						$resultLatTic=mysqli_query($dbc,$queryLatTic);
						$rowLatTic=mysqli_fetch_array($resultLatTic,MYSQLI_ASSOC);
						
						//INSERT TO TICKETEDASSET
						foreach(array_combine($disapprovedAsset, $comments) as $escAsset => $com){
							if(empty($com)){
								$queryTicAss="INSERT INTO `thesis`.`ticketedasset` (`ticketID`, `assetID`) VALUES ('{$rowLatTic['ticketID']}', '{$escAsset}');";
								$resultTicAss=mysqli_query($dbc,$queryTicAss);
								
								//DELETE ASSET TO TICKETEDASSET
								$queryDelTic="DELETE FROM `thesis`.`ticketedasset` WHERE `ticketID`='{$ticketID}' and `assetID`='{$escAsset}'";
								$resultDelTic=mysqli_query($dbc,$queryDelTic);
							}
						}
					}
							
				}
					
				//For defected asset code
				foreach (array_combine($disapprovedAsset, $comments) as $value1 => $value2){
					if(!empty($value2)){
						$query6="UPDATE `thesis`.`assettesting_details` SET `check`='0',`comment`='{$value2}' WHERE `assettesting_testingID`='{$row7['testingID']}' and asset_assetID='{$value1}'";
						$result6=mysqli_query($dbc,$query6);
					}
				}
			}
			
			
		}
		
		//UPDATE ASSET TESTING STATUS
		$query8="UPDATE `thesis`.`assettesting` SET `statusID`='2' WHERE `testingID`='{$row7['testingID']}'";
		$result8=mysqli_query($dbc,$query8);
		
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
                                                    </label><input type="text" value="<?php echo $rowx['fullname']; ?>" class="form-control" disabled>
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
                                                            <th>Property Code</th>
                                                            <th style="text-align:center">Brand</th>
                                                            <th style="text-align:center">Model</th>
                                                            <th style="text-align:center">Comments</th>
                                                            <th>Asset Status</th>
                                                            <th>Escalated To</th>
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
															echo "<tr><td style='text-align:center'><input type='checkbox' name='funcAsset[]' class='form-check-input myCheck' value='{$row['assetID']}'></td>
																<td style='text-align:center'>{$row['brand']}</td>
																<td style='text-align:center'>{$row['model']}</td>
																<td><input style='text' id='{$row['assetID']}' name='comments[]' class='form-control comments'></td>
																<input type='hidden' id='{$idDisapp}' name='disapprovedAsset[]' value='{$row['assetID']}'>
																</tr>";
														}
													
													
													
													
													
													?>
                                                        <tr>
                                                            <td style="text-align:center">TBLT-001</td>
                                                            <td style="text-align:center">Apple Tablet</td>
                                                            <td style="text-align:center">iPad</td>
                                                            <td><input style="text" class="form-control"></td>
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
                                                        </tr>
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
                                                        <select class="form-control m-bot15" name="status" value="<?php if (isset($_POST['status']) && !$flag) echo $_POST['status']; ?>">
                                                            <?php
																$query1 = "SELECT * FROM thesis.ref_ticketstatus";
																$result1 = mysqli_query($dbc, $query1);
																while($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)){
																	if($row1['ticketID']==5){
																		echo "<option selected value='{$row1['ticketID']}'>{$row1['status']}</option>";
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
                                                            <option value="Low">Low</option>
                                                            <option value="Medium">Medium</option>
                                                            <option value="High">High</option>
                                                            <option value="Urgent">Urgent</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group ">
                                                    <label for="assign" class="control-label col-lg-4">Escalate To</label>
                                                    <div class="col-lg-8">
                                                        <select class="form-control m-bot15" id="escalate" name="escalate" value="<?php if (isset($_POST['escalate']) && !$flag) echo $_POST['escalate']; ?>">
                                                            <option value="">Select Engineer</option>
                                                            <?php
																$query3="SELECT u.UserID,CONCAT(Convert(AES_DECRYPT(lastName,'Fusion')USING utf8),', ',Convert(AES_DECRYPT(firstName,'Fusion')USING utf8)) as `fullname` FROM thesis.user u join thesis.ref_usertype rut on u.userType=rut.id where rut.description='Engineer' and u.UserID<>'{$userid}'";
																$result3=mysqli_query($dbc,$query3);
																		
																while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC)){
																	echo "<option value='{$row3['UserID']}'>{$row3['fullname']}</option>";
																}										
																
															?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-lg-4">Due Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control form-control-inline input-medium default-date-picker" name="dueDate" size="10" type="datetime" value="<?php if(isset($rowx['dueDate'])){
																																																	echo $rowx['dueDate'];
																																																}
																																																else{
																																																	echo $rowOut['dueDate'];
																																																}?>" readonly />
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

        $('.myCheck').change(function() {
            var disapp = "Disapp_" + this.value;
            if ($(this).is(':checked')) {
                // Checkbox is checked..

                //document.getElementById(this.value).required = false;
                document.getElementById(this.value).disabled = true;
                document.getElementById(disapp).disabled = true;

            } else {
                // Checkbox is not checked..

                //document.getElementById(this.value).required = true;
                document.getElementById(this.value).disabled = false;
                document.getElementById(disapp).disabled = false;


            }
        });

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

        function checkValue() {
            if(document.getElementById("assetStatus").value == "2"){
                document.getElementById("escalateEng").disabled = false;
            } else {
                document.getElementById("escalateEng").disabled = true;
            }
        }
    </script>




</body>

</html>