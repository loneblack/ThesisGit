<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	$testingID=$_GET['testingID'];
	
	//GET TESTING DATA
	$queryTesDat="SELECT *,rs.description as `statusDesc` FROM thesis.assettesting at join ref_status rs on at.statusID=rs.statusID where at.testingID='{$testingID}'";
	$resultTesDat=mysqli_query($dbc,$queryTesDat);
	$rowTesDat=mysqli_fetch_array($resultTesDat,MYSQLI_ASSOC);
	
	if(isset($_POST['send'])){
		//Update notifications
		$queryUpdNotif="UPDATE `thesis`.`notifications` SET `isRead` = true WHERE (`testingID` = '{$testingID}');";
		$resultUpdNotif=mysqli_query($dbc,$queryUpdNotif);
		
		if($rowTesDat['remarks']=="Asset Request")
		{
			//GET REQID
			$queryReqID="SELECT ad.requestID FROM thesis.assettesting_details atd join asset a on atd.asset_assetID=a.assetID
																				  join assetdocument ad on a.assetID=ad.assetID where atd.assettesting_testingID='{$testingID}' limit 1";
			$resultReqID=mysqli_query($dbc,$queryReqID);
			$rowReqID=mysqli_fetch_array($resultReqID,MYSQLI_ASSOC);
			
			//UPDATE ASSET TESTING STATUS
			$queryTestStat="UPDATE `thesis`.`assettesting` SET `statusID`='3' WHERE `testingID`='{$testingID}'";
			$resultTestStat=mysqli_query($dbc,$queryTestStat);
			
			//GET PASSED ASSETS
			$assetPass=null;
			$warranty=null;
			if(isset($_POST['assetPass'])){
				$assetPass=$_POST['assetPass'];
			}
			if(isset($_POST['warranty'])){
				$warranty=$_POST['warranty'];
			}
			
			//$query1="SELECT rb.name as `brand`,am.description as `assetModelName`,atd.asset_assetID as `assetID`,atd.comment,a.assetModel,am.assetCategory FROM thesis.assettesting_details atd 
			//																									join asset a on atd.asset_assetID=a.assetID 
			//																									join assetmodel am on a.assetModel=am.assetModelID
			//																									join ref_brand rb on am.brand=rb.brandID
			//																								where atd.assettesting_testingID='{$testingID}' and atd.check='1'";
			//$result1=mysqli_query($dbc,$query1);
			//GET REQUESTDATA
			$queryReqData="SELECT * FROM thesis.request where requestID='{$rowReqID['requestID']}'";
			$resultReqData=mysqli_query($dbc,$queryReqData);
			$rowReqData=mysqli_fetch_array($resultReqData,MYSQLI_ASSOC);

			//GET USERTYPE
			$queryGetUserType="SELECT * FROM thesis.user where UserID='{$rowReqData['UserID']}'";
			$resultGetUserType=mysqli_query($dbc,$queryGetUserType);
			$rowGetUserType=mysqli_fetch_array($resultGetUserType,MYSQLI_ASSOC);
			
			if($rowGetUserType['userType']!='2'){
				//receiving - make receiving table
				$queryReceiving="INSERT INTO `thesis`.`requestor_receiving` (`UserID`, `requestID`, `statusID`) VALUES ('{$rowReqData['UserID']}', '{$rowReqID['requestID']}', '1');";
				$resultReceiving=mysqli_query($dbc,$queryReceiving);

				//get newly inserted receiving data
				$queryGetReceiving="SELECT * FROM `thesis`.`requestor_receiving` where requestID='{$rowReqID['requestID']}' order by id desc limit 1";
				$resultGetReceiving=mysqli_query($dbc,$queryGetReceiving);
				$rowGetReceiving=mysqli_fetch_array($resultGetReceiving,MYSQLI_ASSOC);
				
				//INSERT TO NOTIFICATIONS TABLE
				$sqlNotif = "INSERT INTO `thesis`.`notifications` (`isRead`, `requestor_receiving_id`) VALUES (false, '{$rowGetReceiving['id']}');";
				$resultNotif = mysqli_query($dbc, $sqlNotif);
			}

			//Functioning asset
			if(isset($_POST['assetPass'])&&isset($_POST['warranty'])){
				foreach(array_combine($assetPass, $warranty) as $assPass => $war){
				//GENERATE PROPERTY CODE
				
				//UPDATE ASSET STATUS
				$queryStat="UPDATE `thesis`.`asset` SET `assetStatus`='1' WHERE `assetID`='{$assPass}'";
				$resultStat=mysqli_query($dbc,$queryStat);
				
				//GET INFO OF AN ASSET";
				$queryGetAssInf = "SELECT * FROM thesis.asset a join assetmodel am on a.assetModel=am.assetModelID where a.assetID='{$assPass}'";
				$resultGetAssInf = mysqli_query($dbc,$queryGetAssInf);
				$rowGetAssInf= mysqli_fetch_array($resultGetAssInf,MYSQLI_ASSOC);
				
				//Count Curr Assets based on assetCategory
				$queryCount="SELECT Count(assetID) as `assetPosition` FROM thesis.asset a join assetmodel am on a.assetModel=am.assetModelID
																						  where a.assetID<='{$assPass}' and am.assetCategory='{$rowGetAssInf['assetCategory']}'";
				$resultCount=mysqli_query($dbc,$queryCount);
				$rowCount=mysqli_fetch_array($resultCount,MYSQLI_ASSOC);
				
				//$propertyCode="0".$row1['assetCategory']."-".sprintf('%06d', $rowCount['assetPosition']);
				$propertyCode=sprintf('%03d', $rowGetAssInf['assetCategory'])."-".sprintf('%06d', $rowCount['assetPosition']);
				
				//INSERT Property Code
				$queryProp="UPDATE `thesis`.`asset` SET `propertyCode`='{$propertyCode}' WHERE `assetID`='{$assPass}'";
				$resultProp=mysqli_query($dbc,$queryProp);
				
				if($rowGetUserType['userType']!='2'){
					//INSERT Asset that passed the test to ASSETASSIGNMENT
					$queryAssAss="INSERT INTO `thesis`.`assetassignment` (`assetID`, `BuildingID`, `FloorAndRoomID`, `personresponsibleID`, `statusID`) VALUES ('{$assPass}', '{$rowReqData['BuildingID']}', '{$rowReqData['FloorAndRoomID']}', '{$rowReqData['UserID']}', '2')";
					$resultAssAss=mysqli_query($dbc,$queryAssAss);
					
					//GET LATEST ASSETASSIGNMENT
					$queryGetLatAssAss = "SELECT * FROM thesis.assetassignment order by AssetAssignmentID desc limit 1";
					$resultGetLatAssAss = mysqli_query($dbc,$queryGetLatAssAss);
					$rowGetLatAssAss= mysqli_fetch_array($resultGetLatAssAss,MYSQLI_ASSOC);
					
					//INSERT TO ASSET AUDIT
					$queryAssAud="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `assetAssignmentID`, `assetStatus`) VALUES ('{$_SESSION['userID']}', now(), '{$rowGetLatAssAss['assetID']}', '{$rowGetLatAssAss['AssetAssignmentID']}', '1');";
					$resultAssAud=mysqli_query($dbc,$queryAssAud);
					
					//INSERT TO RECEIVING DETAILS
					$queryReceivingDetails = "INSERT INTO `thesis`.`receiving_details`(`receivingID`, `assetID`, `received`) VALUES('{$rowGetReceiving['id']}', '{$assPass}', false);";
					$resultReceivingDetails = mysqli_query($dbc,$queryReceivingDetails);
				}
				else{
					//INSERT TO ASSET AUDIT
					$queryAssAud="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `assetStatus`) VALUES ('{$_SESSION['userID']}', now(), '{$assPass}', '1');";
					$resultAssAud=mysqli_query($dbc,$queryAssAud);
				}
				
				
				//SET DATE EXPIRED
				$dateExp = new DateTime($rowGetAssInf['dateDelivered']);
				date_modify($dateExp,"+".$war." month");
				$finDateExp=date_format($dateExp,"Y-m-d");
				
				//INSERT Warranty to assets that passed the test 
				$queryInsWar = "INSERT INTO `thesis`.`warranty` (`dateAcquired`, `dateExpired`, `assetID`, `supplierID`) VALUES ('{$rowGetAssInf['dateDelivered']}', '{$finDateExp}', '{$assPass}', '{$rowGetAssInf['supplierID']}')";
				$resultInsWar = mysqli_query($dbc,$queryInsWar);

				}	
			}
			
			//Defect asset 
			
			//GET EMPLOYEEID
			$queryEmp="SELECT * FROM thesis.employee where UserID='{$_SESSION['userID']}'";
			$resultEmp=mysqli_query($dbc,$queryEmp);
			$rowEmp=mysqli_fetch_array($resultEmp,MYSQLI_ASSOC);
			
			//GET EACH SUPPLIER
			$queryg="SELECT a.supplierID,ad.requestID,a.assetModel FROM thesis.assettesting_details atd join asset a on atd.asset_assetID=a.assetID 
												  join assetdocument ad on a.assetID=ad.assetID
												  join assetmodel am on a.assetModel=am.assetModelID
												  where atd.assettesting_testingID='{$testingID}' and atd.check='0'            
												  group by a.supplierID";
			$resultg=mysqli_query($dbc,$queryg);
			
			while($rowg=mysqli_fetch_array($resultg,MYSQLI_ASSOC))
			{
				//GET PO
				$queryGetPO="SELECT d.procurementID FROM thesis.ticket t join delivery d on t.delivery_id=d.id where t.testingID='{$testingID}'";
				$resultGetPO=mysqli_query($dbc,$queryGetPO);
				$rowGetPO=mysqli_fetch_array($resultGetPO,MYSQLI_ASSOC);
				
				//UPDATE PO STATUS
				$querya="UPDATE `thesis`.`procurement` SET `status`='4' WHERE `procurementID`='{$rowGetPO['procurementID']}'";
				$resulta=mysqli_query($dbc,$querya);
				
				//GET ALL DEFECT ASSETS
				$query0="SELECT atd.asset_assetID as `assetID`,am.assetCategory,a.assetModel FROM thesis.assettesting_details atd 
												  join asset a on atd.asset_assetID=a.assetID 
												  join assetmodel am on a.assetModel=am.assetModelID
												  where atd.assettesting_testingID='{$testingID}' and atd.check='0' 
												  ";
				$result0=mysqli_query($dbc,$query0);
				
				while($row0=mysqli_fetch_array($result0,MYSQLI_ASSOC))
				{
					//GET DELIVERY DATA
					$queryGetDelData="SELECT * FROM thesis.delivery d join deliverydetails dd on d.id=dd.DeliveryID where dd.assetModelID='{$row0['assetModel']}' and d.procurementID='{$rowGetPO['procurementID']}' order by d.id desc limit 1";
					$resultGetDelData=mysqli_query($dbc,$queryGetDelData);
					$rowGetDelData=mysqli_fetch_array($resultGetDelData,MYSQLI_ASSOC);
					
					//UPDATE DELIVERY DETAILS DATA
					$queryUpdPOData="UPDATE `thesis`.`deliverydetails` SET `itemsReceived`=itemsReceived-1 where assetModelID='{$row0['assetModel']}' and DeliveryID='{$rowGetDelData['DeliveryID']}'";
					$resultUpdPOData=mysqli_query($dbc,$queryUpdPOData);
				
					//UPDATE ASSET STATUS
					$queryProp="UPDATE `thesis`.`asset` SET `assetStatus`='25' WHERE `assetID`='{$row0['assetID']}'";
					$resultProp=mysqli_query($dbc,$queryProp);
					
					//INSERT TO ASSET AUDIT
					$queryAssAud="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `assetStatus`) VALUES ('{$_SESSION['userID']}', now(), '{$row0['assetID']}', '25');";
					$resultAssAud=mysqli_query($dbc,$queryAssAud);

				}
				
			}
			
			//$queryProc1="";
			//$resultProc1=mysqli_query($dbc,$queryProc1);
			
			//$querya="UPDATE `thesis`.`procurement` SET `status`='3' WHERE `procurementID`='{$procID}'";
			//$resulta=mysqli_query($dbc,$querya);
			
			//UPDATE REQUEST STATUS

			//GET QTY of Assets requested IN REQUESTDETAILS
			$queryReq="SELECT sum(quantity) as `totalQty` FROM thesis.requestdetails where requestID='{$rowReqID['requestID']}'";
			$resultReq=mysqli_query($dbc,$queryReq);
			$rowReq=mysqli_fetch_array($resultReq,MYSQLI_ASSOC);
			
			//GET ALL Assets that passed the test
			$queryPass="SELECT count(ad.assetID) as `passedAsset` FROM thesis.assetdocument ad join asset a on ad.assetID=a.assetID where ad.requestID='{$rowReqID['requestID']}' and a.assetStatus='1'";
			$resultPass=mysqli_query($dbc,$queryPass);
			$rowPass=mysqli_fetch_array($resultPass,MYSQLI_ASSOC);

			if($rowReq['totalQty']==$rowPass['passedAsset'])
			{
				if($rowGetUserType['userType']!='2'){
					$queryComp="UPDATE `thesis`.`request` SET `step`='24' WHERE `requestID`='{$rowReqID['requestID']}'";
					$resultComp=mysqli_query($dbc,$queryComp);
				}
				else{
					$queryComp="UPDATE `thesis`.`request` SET `step`='21', `status`='3' WHERE `requestID`='{$rowReqID['requestID']}'";
					$resultComp=mysqli_query($dbc,$queryComp);
				}
				
			}	

		}
		elseif($rowTesDat['remarks']=="Donation"){
			//UPDATE ASSET TESTING STATUS
			$query8="UPDATE `thesis`.`assettesting` SET `statusID`='3' WHERE `testingID`='{$testingID}'";
			$result8=mysqli_query($dbc,$query8);
			
			$query1="SELECT rb.name as `brand`,am.description as `assetModelName`,atd.asset_assetID as `assetID`,atd.comment,a.assetModel,am.assetCategory FROM thesis.assettesting_details atd join asset a on atd.asset_assetID=a.assetID 
																												join assetmodel am on a.assetModel=am.assetModelID
																												join ref_brand rb on am.brand=rb.brandID
																												where atd.assettesting_testingID='{$testingID}' and atd.check='1'";
			$result1=mysqli_query($dbc,$query1);
			while($row1=mysqli_fetch_array($result1,MYSQLI_ASSOC)){
				//UPDATE ASSET STATUS
				$queryStat="UPDATE `thesis`.`asset` SET `assetStatus`='6' WHERE `assetID`='{$row1['assetID']}'";
				$resultStat=mysqli_query($dbc,$queryStat);
				
				//INSERT TO ASSET AUDIT
				$queryAssAud="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `assetStatus`) VALUES ('{$_SESSION['userID']}', now(), '{$row1['assetID']}', '6');";
				$resultAssAud=mysqli_query($dbc,$queryAssAud);
				
				//GET DONATION REQUEST
				$queryDonDet="SELECT * FROM thesis.donationdetails dd join donationdetails_item ddi on dd.id=ddi.id where ddi.assetID='{$row1['assetID']}' limit 1";
				$resultDonDet=mysqli_query($dbc,$queryDonDet);
				$rowDonDet=mysqli_fetch_array($resultDonDet,MYSQLI_ASSOC);
			
				//GET NUM of Asset testing of a donation request
				$queryNumAss="SELECT Count(DISTINCT at.testingID) as `numAssetTest` from assettesting at join assettesting_details atd on at.testingID=atd.assettesting_testingID
									 join donationdetails_item ddi on atd.asset_assetID=ddi.assetID
                                     join donationdetails dd on ddi.id=dd.id
									 where dd.donationID='{$rowDonDet['donationID']}' limit 1";
				$resultNumAss=mysqli_query($dbc,$queryNumAss);
				$rowNumAss=mysqli_fetch_array($resultNumAss,MYSQLI_ASSOC);
				
				//GET NUM of COMPLETED Asset testing of a donation request
				$queryNumComp="SELECT Count(DISTINCT at.testingID) as `numCompTest` from assettesting at join assettesting_details atd on at.testingID=atd.assettesting_testingID
									 join donationdetails_item ddi on atd.asset_assetID=ddi.assetID
                                     join donationdetails dd on ddi.id=dd.id
									 where dd.donationID='{$rowDonDet['donationID']}' and at.statusID='3' limit 1";
				$resultNumComp=mysqli_query($dbc,$queryNumComp);
				$rowNumComp=mysqli_fetch_array($resultNumComp,MYSQLI_ASSOC);
				
				//GET QTY of Assets requested IN DONATIONDETAILS
				//$queryReq="SELECT sum(quantity) as `totalQty` FROM thesis.donationdetails where donationID='{$rowDonDet['donationID']}' limit 1";
				//$resultReq=mysqli_query($dbc,$queryReq);
				//$rowReq=mysqli_fetch_array($resultReq,MYSQLI_ASSOC);
				
				//GET ALL Assets that passed the test
				//$queryPass="SELECT count(ddi.assetID) as `passedAsset` FROM thesis.donationdetails dd join donationdetails_item ddi on dd.id=ddi.id join asset a on ddi.assetID=a.assetID where dd.donationID='{$rowDonDet['donationID']}' and a.assetStatus='6' limit 1";
				//$resultPass=mysqli_query($dbc,$queryPass);
				//$rowPass=mysqli_fetch_array($resultPass,MYSQLI_ASSOC);
				
				if($rowNumAss['numAssetTest']==$rowNumComp['numCompTest']){
					$queryComp="UPDATE `thesis`.`donation` SET `stepsID`='21', `statusID`='3' WHERE `donationID`='{$rowDonDet['donationID']}'";
					$resultComp=mysqli_query($dbc,$queryComp);
				}
			}
			
			//Get Past ticket data
			$queryPastTick="SELECT * FROM thesis.ticket where testingID='{$testingID}'";
			$resultPastTick=mysqli_query($dbc,$queryPastTick);
			$rowPastTick=mysqli_fetch_array($resultPastTick,MYSQLI_ASSOC);
				
			//For defect asset
				
			//Create ticket for repair
			//$queryTicket="INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `serviceType`) VALUES ('1', '{$rowPastTick['assigneeUserID']}', '{$_SESSION['userID']}', now(), now(), '{$rowPastTick['dueDate']}', 'High', '27');";
			//$resultTicket=mysqli_query($dbc,$queryTicket);
				
			//Get Latest ticket
			//$queryLatTick="SELECT * from `thesis`.`ticket` order by ticketID desc limit 1";
			//$resultLatTick=mysqli_query($dbc,$queryLatTick);
			//$rowLatTick=mysqli_fetch_array($resultLatTick,MYSQLI_ASSOC);
				
			//GET ALL DEFECT ASSETS
			$queryDefAss="SELECT atd.asset_assetID as `assetID`,am.assetCategory,a.assetModel FROM thesis.assettesting_details atd 
												  join asset a on atd.asset_assetID=a.assetID 
												  join assetmodel am on a.assetModel=am.assetModelID
												  where atd.assettesting_testingID='{$testingID}' and atd.check='0'";
			$resultDefAss=mysqli_query($dbc,$queryDefAss);
			while($rowDefAss=mysqli_fetch_array($resultDefAss,MYSQLI_ASSOC)){
				//UPDATE ASSET STATUS
				$queryForRep="UPDATE `thesis`.`asset` SET `assetStatus`='5' WHERE `assetID`='{$rowDefAss['assetID']}'";
				$resultForRep=mysqli_query($dbc,$queryForRep);
				
				//INSERT TO ASSET AUDIT
				$queryAssAud="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `assetStatus`) VALUES ('{$_SESSION['userID']}', now(), '{$rowDefAss['assetID']}', '5');";
				$resultAssAud=mysqli_query($dbc,$queryAssAud);
				
				//INSERT to ticketted asset
				//$queryTickAss="INSERT INTO `thesis`.`ticketedasset` (`ticketID`, `assetID`) VALUES ('{$rowLatTick['ticketID']}', '{$rowDefAss['assetID']}')";
				//$resultTickAss=mysqli_query($dbc,$queryTickAss);
			}
			
		}
		elseif($rowTesDat['remarks']=="Borrow"){

			//GET BORROWID
			$queryReqID="SELECT borrowID FROM thesis.assettesting where testingID='{$testingID}';";
			$resultReqID=mysqli_query($dbc,$queryReqID);
			$rowBorID=mysqli_fetch_array($resultReqID,MYSQLI_ASSOC);

			//UPDATE ASSET TESTING STATUS
			$query8="UPDATE `thesis`.`assettesting` SET `statusID`='3' WHERE `testingID`='{$testingID}'";
			$result8=mysqli_query($dbc,$query8);
			
			//GET BORROWDATA
			$queryBorrowData="SELECT * FROM thesis.request_borrow where borrowID='{$rowBorID['borrowID']}'";
			$resultBorrowData=mysqli_query($dbc,$queryBorrowData);
			$rowBorrowData=mysqli_fetch_array($resultBorrowData,MYSQLI_ASSOC);
			
			//receiving - make receiving table
			$queryReceiving="INSERT INTO `thesis`.`requestor_receiving` (`UserID`, `borrowID`, `statusID`) VALUES ('{$rowBorrowData['personresponsibleID']}', '{$rowBorID['borrowID']}', '1');";
			$resultReceiving=mysqli_query($dbc,$queryReceiving);

			//get newly inserted receiving data
			$queryGetReceeiving="SELECT * FROM `thesis`.`requestor_receiving` where borrowID='{$rowBorID['borrowID']}' order by id desc limit 1";
			$resultGetReceiving=mysqli_query($dbc,$queryGetReceeiving);
			$rowGetReceiving=mysqli_fetch_array($resultGetReceiving,MYSQLI_ASSOC);
			
			//INSERT TO NOTIFICATIONS TABLE
			$sqlNotif = "INSERT INTO `thesis`.`notifications` (`isRead`, `requestor_receiving_id`) VALUES (false, '{$rowGetReceiving['id']}');";
			$resultNotif = mysqli_query($dbc, $sqlNotif);

			//GET PASSED TEST ASSET
			$queryPassTest="SELECT * FROM thesis.assettesting_details where assettesting_testingID='{$testingID}' and `check`='1'";
			$resultPassTest=mysqli_query($dbc,$queryPassTest);
			while($rowPassTest=mysqli_fetch_array($resultPassTest,MYSQLI_ASSOC)){
				//UPDATE ASSET STATUS
				$queryStat="UPDATE `thesis`.`asset` SET `assetStatus`='3' WHERE `assetID`='{$rowPassTest['asset_assetID']}'";
				$resultStat=mysqli_query($dbc,$queryStat);
				
				//GET BORROW DETAILS DATA
				$queryBorDat="SELECT * FROM thesis.borrow_details bd where bd.borrowID='{$rowBorID['borrowID']}'";
				$resultBorDat=mysqli_query($dbc,$queryBorDat);
				$rowBorDat=mysqli_fetch_array($resultBorDat,MYSQLI_ASSOC);

				//INSERT TO BORROWDETAILSITEM
				//$queryInsBor="INSERT INTO `thesis`.`borrow_details_item` (`borrow_detailsID`, `assetID`) VALUES ('{$rowBorDat['borrow_detailscol']}', '{$rowPassTest['asset_assetID']}');";
				//$resultInsBor=mysqli_query($dbc,$queryInsBor);

				//INSERT Asset that passed the test to ASSETASSIGNMENT
				$queryAssAss="INSERT INTO `thesis`.`assetassignment` (`assetID`, `BuildingID`, `FloorAndRoomID`, `personresponsibleID`, `statusID`) VALUES ('{$rowPassTest['asset_assetID']}', '{$rowBorrowData['BuildingID']}', '{$rowBorrowData['FloorAndRoomID']}', '{$rowBorrowData['personresponsibleID']}', '2')";
				$resultAssAss=mysqli_query($dbc,$queryAssAss);
				
				//GET LATEST ASSETASSIGNMENT
				$queryGetLatAssAss = "SELECT * FROM thesis.assetassignment order by AssetAssignmentID desc limit 1";
				$resultGetLatAssAss = mysqli_query($dbc,$queryGetLatAssAss);
				$rowGetLatAssAss= mysqli_fetch_array($resultGetLatAssAss,MYSQLI_ASSOC);
				
				//INSERT TO ASSET AUDIT
				$queryAssAud="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `assetAssignmentID`, `assetStatus`) VALUES ('{$_SESSION['userID']}', now(), '{$rowGetLatAssAss['assetID']}', '{$rowGetLatAssAss['AssetAssignmentID']}', '1');";
				$resultAssAud=mysqli_query($dbc,$queryAssAud);
				
				//INSERT TO RECEIVING DETAILS
				$queryReceivingDetails = "INSERT INTO `thesis`.`receiving_details`(`receivingID`, `assetID`, `received`) VALUES('{$rowGetReceiving['id']}', '{$rowPassTest['asset_assetID']}', false);";
				$resultReceivingDetails = mysqli_query($dbc,$queryReceivingDetails);
			}
			
			//GET FAILED TEST ASSET
			$queryFailTest="SELECT * FROM thesis.assettesting_details where assettesting_testingID='{$testingID}' and `check`='0'";
			$resultFailTest=mysqli_query($dbc,$queryFailTest);
			while($rowFailTest=mysqli_fetch_array($resultFailTest,MYSQLI_ASSOC)){
				//GENERATE REPAIR REQUEST 
				$queryGenRepairReq = "INSERT INTO `thesis`.`service` (`details`, `dateReceived`, `UserID`, `serviceType`, `status`, `steps`, `replacementUnit`)
	                    VALUES ('Repair needed on the following assets', now(), '{$_SESSION['userID']}', '27', '1', '14', '0');";
				$resultGenRepairReq=mysqli_query($dbc,$queryGenRepairReq);
					
				//Get Latest Repair Request
				$queryGetLatRep="SELECT * FROM thesis.service where serviceType='27' order by id desc limit 1";
				$resultGetLatRep=mysqli_query($dbc,$queryGetLatRep);
				$rowGetLatRep=mysqli_fetch_array($resultGetLatRep,MYSQLI_ASSOC);
					 
				//insert asset to service details
				$query = "INSERT INTO `thesis`.`servicedetails` (`serviceID`, `asset`, `replaced`, `problem`) VALUES ('{$rowGetLatRep['id']}', '{$rowFailTest['asset_assetID']}', '0', '{$rowFailTest['comment']}');";
				$resulted = mysqli_query($dbc, $query);
			}

			//GET ALL ASSET TESTING PER BORROWID
			
			//UPDATE BORROW STEP
			$queryComp="UPDATE `thesis`.`request_borrow` SET `steps`='24' WHERE `borrowID`='{$rowTesDat['borrowID']}'";
			$resultComp=mysqli_query($dbc,$queryComp);
			
		}
		
		elseif($rowTesDat['remarks']=="Replacement"){
			//UPDATE ASSET TESTING STATUS
			$query8="UPDATE `thesis`.`assettesting` SET `statusID`='3' WHERE `testingID`='{$testingID}'";
			$result8=mysqli_query($dbc,$query8);
			
			//GET REPLACEMENT DATA
			$queryGetRepDat="SELECT * FROM thesis.assettesting at join replacement r on at.replacementID=r.replacementID where at.testingID='{$testingID}'";
			$resultGetRepDat=mysqli_query($dbc,$queryGetRepDat);
			$rowGetRepDat=mysqli_fetch_array($resultGetRepDat,MYSQLI_ASSOC);
			
			//CHECK IF THE ASSET PASSED THE TEST
			$queryCheckAssPass="SELECT rb.name as `brand`,am.description as `assetModelName`,atd.asset_assetID as `assetID`,atd.comment,a.assetModel,am.assetCategory,atd.check FROM thesis.assettesting_details atd join asset a on atd.asset_assetID=a.assetID 
																												join assetmodel am on a.assetModel=am.assetModelID
																												join ref_brand rb on am.brand=rb.brandID
																												where atd.assettesting_testingID='{$testingID}'";
			$resultCheckAssPass=mysqli_query($dbc,$queryCheckAssPass);
			while($rowCheckAssPass=mysqli_fetch_array($resultCheckAssPass,MYSQLI_ASSOC)){
				//PASSED THE TEST
				if($rowCheckAssPass['check']=='1'){
					//UPDATE ASSET STATUS
					$queryStat="UPDATE `thesis`.`asset` SET `assetStatus`='2' WHERE `assetID`='{$rowCheckAssPass['assetID']}'";
					$resultStat=mysqli_query($dbc,$queryStat);

					//INSERT Asset that passed the test to ASSETASSIGNMENT
					$queryAssAss="INSERT INTO `thesis`.`assetassignment` (`assetID`, `BuildingID`, `FloorAndRoomID`, `statusID`) VALUES ('{$rowCheckAssPass['assetID']}', '{$rowGetRepDat['BuildingID']}', '{$rowGetRepDat['FloorAndRoomID']}', '2')";
					$resultAssAss=mysqli_query($dbc,$queryAssAss);
					
					//GET LATEST ASSETASSIGNMENT
					$queryGetLatAssAss = "SELECT * FROM thesis.assetassignment order by AssetAssignmentID desc limit 1";
					$resultGetLatAssAss = mysqli_query($dbc,$queryGetLatAssAss);
					$rowGetLatAssAss= mysqli_fetch_array($resultGetLatAssAss,MYSQLI_ASSOC);
					
					//INSERT TO ASSET AUDIT
					$queryAssAud="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `assetAssignmentID`, `assetStatus`) VALUES ('{$_SESSION['userID']}', now(), '{$rowGetLatAssAss['assetID']}', '{$rowGetLatAssAss['AssetAssignmentID']}', '2');";
					$resultAssAud=mysqli_query($dbc,$queryAssAud);
					
					//CHANGE STATUS OF ASSET ASSIGNMENT OF THE MISSING ASSET
					$queryChaStatAssAss="UPDATE `thesis`.`assetassignment` SET `statusID` = '3' WHERE `assetID` = '{$rowGetRepDat['lostAssetID']}' AND `statusID` = '2' AND `personresponsibleID` is null";
					$resultChaStatAssAss=mysqli_query($dbc,$queryChaStatAssAss);
					
					//CHANGE REPLACEMENT STATUS TO COMPLETED
					$queryUpdRepStat="UPDATE `thesis`.`replacement` SET `statusID` = '3', `stepID` = '21' WHERE (`replacementID` = '{$rowGetRepDat['replacementID']}');";
					$resultUpdRepStat=mysqli_query($dbc,$queryUpdRepStat);
					
				}
				//FAILED THE TEST
				else{
					//GENERATE REPAIR REQUEST 
					$queryGenRepairReq = "INSERT INTO `thesis`.`service` (`details`, `dateReceived`, `UserID`, `serviceType`, `status`, `steps`, `replacementUnit`)
	                    VALUES ('Repair needed on the following assets', now(), '{$_SESSION['userID']}', '27', '1', '14', '0');";
					$resultGenRepairReq=mysqli_query($dbc,$queryGenRepairReq);
					
					 //Get Latest Repair Request
					$queryGetLatRep="SELECT * FROM thesis.service where serviceType='27' order by id desc limit 1";
					$resultGetLatRep=mysqli_query($dbc,$queryGetLatRep);
					$rowGetLatRep=mysqli_fetch_array($resultGetLatRep,MYSQLI_ASSOC);
					 
					//insert asset to service details
					$query = "INSERT INTO `thesis`.`servicedetails` (`serviceID`, `asset`, `replaced`, `problem`) VALUES ('{$rowGetLatRep['id']}', '{$rowCheckAssPass['assetID']}', '0', '{$rowCheckAssPass['comment']}');";
					$resulted = mysqli_query($dbc, $query);
					
					//CHANGE REPLACEMENT STEP BACK TO Assigning of New Replacement
					$queryUpdRepStat="UPDATE `thesis`.`replacement` SET `stepID` = '26' WHERE (`replacementID` = '{$rowGetRepDat['replacementID']}');";
					$resultUpdRepStat=mysqli_query($dbc,$queryUpdRepStat);
					
					//INSERT TO NOTIFICATIONS TABLE
					$sqlNotif = "INSERT INTO `thesis`.`notifications` (`steps_id`, `isRead`, `replacementID`) VALUES ('26', false, '{$rowGetRepDat['replacementID']}');";
					$resultNotif = mysqli_query($dbc, $sqlNotif);
				}
			}

		}
		
		$message = "Form submitted!";
		$_SESSION['submitMessage'] = $message; 
		
	}
?>
<?php
$id = $_GET['testingID'];


$getDate="SELECT lastUpdateDate FROM ticket WHERE ticketID = '{$id}'";
$dddate=mysqli_query($dbc,$getDate);
$rowDate=mysqli_fetch_array($dddate,MYSQLI_ASSOC);

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
        <?php include 'it_navbar.php' ?>

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
				?>
                <div class="row">
                    <div class="col-sm-12">


                        <div class="col-sm-12">
							<form method="post">
								<section class="panel">
									<header class="panel-heading">
										View Testing
										</header>
										<div class="panel-body">
											<div class="text-center invoice-btn">
											</div>
											<section id="unseen">
												<div class="row invoice-to">
													<div class="col-md-4 col-sm-4 pull-left">
														<h4>Status:</h4>
														<h2><?php 
															if($rowTesDat['statusID']=='7'){
																echo "<span class='label label-primary'>{$rowTesDat['statusDesc']}</span>";
															}
															elseif($rowTesDat['statusID']=='3'){
																echo "<span class='label label-success'>{$rowTesDat['statusDesc']}</span>";
															}
															?></h2>
													</div>
													<div class="col-md-4 col-sm-5 pull-right">
														<div class="row">
															<div class="col-md-4 col-sm-5 inv-label">Testing #</div>
															<div class="col-md-8 col-sm-7"><?php echo $id;?></div>
														</div>
														<br>
														<div class="row">
															<div class="col-md-4 col-sm-5 inv-label">Date Updated </div>
															<div class="col-md-8 col-sm-7"><?php echo $rowDate['lastUpdateDate'];?></div>
														</div>
														<br>


													</div>
												</div>
											
											<table class="table table-invoice">
												<thead>
													<tr>
														<th class="text-center">Asset Status</th>
														<th class="text-center">Property Code</th>
														<th class="text-center">Brand</th>
														<th class="text-center">Model</th>
														<th class="text-center">Category</th>
														<th class="text-center">Comments</th>
                                                        <th class="text-center">Warranty (In Months)</th>
													</tr>
												</thead>
												<tbody>
													
													<?php
														$finDate = 0;
														$query = "SELECT rac.name as `assetCatName`,rb.name as `brand`,am.description as `assetModel`,atd.asset_assetID,atd.check,atd.comment,a.propertyCode FROM thesis.assettesting_details atd join asset a on atd.asset_assetID=a.assetID 
																												join assetmodel am on a.assetModel=am.assetModelID
																												join ref_brand rb on am.brand=rb.brandID 
																												join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID 
																												where assettesting_testingID='{$testingID}'";         
														$result = mysqli_query($dbc, $query);
														while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
															if($rowTesDat['statusID']=='3'){
																//GET WARRANTY INFO
																$queryGetWarInf="SELECT * FROM thesis.assettesting_details atd join asset a on atd.asset_assetID=a.assetID
																										  join warranty w on a.assetID=w.assetID 
																										  where atd.check='1' and atd.assettesting_testingID='{$testingID}' and atd.asset_assetID='{$row['asset_assetID']}'";
																$resultGetWarInf=mysqli_query($dbc,$queryGetWarInf);
																$rowGetWarInf=mysqli_fetch_array($resultGetWarInf,MYSQLI_ASSOC);
																
																//GET DATEDIFF
																$date1=new DateTime($rowGetWarInf['dateAcquired']);
																$date2=new DateTime($rowGetWarInf['dateExpired']);
																$datediff = $date1->diff($date2);
																$finDate = $datediff->format('%y') * 12 + $datediff->format('%m');
															}
															
															echo "<tr>
																	<td class='text-center'>";
																
																if($row['check']=='1'){
																	echo "Working";
																}
																else{
																	echo "Defective";
																}	
															echo "</td>
																	<td class='text-center'>{$row['propertyCode']}</td>
																	<td class='text-center'>{$row['brand']}</td>
																	<td class='text-center'>{$row['assetModel']}</td>
																	<td class='text-center'>{$row['assetCatName']}</td>
																	<td class='text-center'><input type='text' class='form-control' value='";
																if($row['check']=='0'){
																	echo $row['comment'];
																}	
																	
															echo "' disabled></td>
                                                            <td><input class='form-control' type='number' name='warranty[]' min='3' ";
															
															if($rowTesDat['remarks']=="Asset Request" && $rowTesDat['statusID']=='3'){
																echo "value='{$finDate}' disabled ";
															}
															elseif($rowTesDat['remarks']=="Asset Request" && $rowTesDat['statusID']=='7'){
																echo "value='3' ";
															}
															
															if($row['check']=='0'){
																echo "disabled ";
															}
															elseif($rowTesDat['remarks']!="Asset Request"){
																echo "disabled ";
															}
															
															echo "required/></td>";
															
															if($row['check']=='1'){
																echo "<input type='hidden' name='assetPass[]' value='{$row['asset_assetID']}'>";
															}
															echo "</tr>";
														}
														
														
														
													
													?>
                                                    
                                                    
												</tbody> 
											</table>
										</section>
									</div>
								</section>
								<button type="submit" name="send" class="btn btn-success" <?php if($rowTesDat['statusID']=='3'){
																						echo "disabled";
																						} ?> >Send</button>
								<button type="button" class="btn btn-info" onclick="window.history.back();" id="back">Back</button>
							</form>
                        </div>


                    </div>
                </div>
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

    <script>
        function goBack(){
			window.history.back();
		}
    </script>
    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>