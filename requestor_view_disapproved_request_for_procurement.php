<!DOCTYPE html>
<html lang="en">
<?php
	session_start();
	require_once("db/mysql_connect.php");
	$_SESSION['count'] = 0;
	$requestID=$_GET['id'];
	//Get Request Data
	$queryReq="SELECT * FROM thesis.request r join floorandroom far on r.FloorAndRoomID=far.FloorAndRoomID where r.requestID='{$requestID}'";
	$resultReq=mysqli_query($dbc,$queryReq);
	$rowReq=mysqli_fetch_array($resultReq,MYSQLI_ASSOC);
	
	//Update notifications
	$queryUpdNotif="UPDATE `thesis`.`notifications` SET `isRead` = true WHERE `requestID` = '{$requestID}' and `steps_id`='28'";
	$resultUpdNotif=mysqli_query($dbc,$queryUpdNotif);
	
	if(isset($_POST['request'])){
		if(!empty($_POST['recommAss'])){
			$recommAss=$_POST['recommAss'];
			
			//Get EmployeeID
			$queryEmpID = "SELECT * FROM `thesis`.`employee` WHERE UserID = {$_SESSION['userID']};"; //get the employeeID using userID
			$resultEmpID = mysqli_query($dbc, $queryEmpID);
			$rowEmpID = mysqli_fetch_array($resultEmpID, MYSQLI_ASSOC);
			
			if(isset($_POST['endDate'])){
				$endDate=$_POST['endDate'];
				
				//insertion to request table
				$sql2 = "INSERT INTO `thesis`.`request_borrow` (`BuildingID`, `FloorAndRoomID`, `startDate`, `endDate`, `personresponsibleID`, `dateCreated`, `purpose`, `statusID`, `steps`) VALUES ('{$rowReq['BuildingID']}', '{$rowReq['FloorAndRoomID']}', '{$rowReq['dateNeeded']}', '{$endDate}', '{$rowEmpID['employeeID']}', now(), '{$rowReq['description']}', '2', '13');";//status is set to 1 for pending status
				$result2 = mysqli_query($dbc, $sql2);
				
				//GET LATEST BORROW
				$queryGetLatBor = "SELECT * FROM thesis.request_borrow order by borrowID desc limit 1";
				$resultGetLatBor = mysqli_query($dbc, $queryGetLatBor);
				$rowGetLatBor = mysqli_fetch_array($resultGetLatBor, MYSQLI_ASSOC);
				
				//insert to assset testing
				$queryTest="INSERT INTO `thesis`.`assettesting` (`statusID`, `PersonRequestedID`, `remarks`, `serviceType`, `borrowID`)
									VALUES ('1', '{$_SESSION['userID']}', 'Borrow', '25', '{$rowGetLatBor['borrowID']}');";
				$resultTest=mysqli_query($dbc,$queryTest);

			}
			else{
				//insertion to request table
				$sql2 = "INSERT INTO `thesis`.`request_borrow` (`BuildingID`, `FloorAndRoomID`, `startDate`, `personresponsibleID`, `dateCreated`, `purpose`, `statusID`, `steps`) VALUES ('{$rowReq['BuildingID']}', '{$rowReq['FloorAndRoomID']}', '{$rowReq['dateNeeded']}', '{$rowEmpID['employeeID']}', now(), '{$rowReq['description']}', '2', '13');";//status is set to 1 for pending status
				$result2 = mysqli_query($dbc, $sql2);
				
				//GET LATEST BORROW
				$queryGetLatBor = "SELECT * FROM thesis.request_borrow order by borrowID desc limit 1";
				$resultGetLatBor = mysqli_query($dbc, $queryGetLatBor);
				$rowGetLatBor = mysqli_fetch_array($resultGetLatBor, MYSQLI_ASSOC);
				
				//insert to assset testing
				$queryTest="INSERT INTO `thesis`.`assettesting` (`statusID`, `PersonRequestedID`, `remarks`, `serviceType`, `borrowID`)
									VALUES ('1', '{$_SESSION['userID']}', 'Borrow', '25', '{$rowGetLatBor['borrowID']}');";
				$resultTest=mysqli_query($dbc,$queryTest);

			}
			
			//GET LATEST ASSET TESTING
			$selectQuery = "SELECT * FROM thesis.assettesting ORDER BY testingID DESC LIMIT 1;";
			$resultQuery = mysqli_query($dbc,$selectQuery);
			$rowQuery = mysqli_fetch_array($resultQuery, MYSQLI_ASSOC);
			
			//GET LATEST BORROW
			$queryGetLatBor = "SELECT * FROM thesis.request_borrow order by borrowID desc limit 1";
			$resultGetLatBor = mysqli_query($dbc, $queryGetLatBor);
			$rowGetLatBor = mysqli_fetch_array($resultGetLatBor, MYSQLI_ASSOC);
			
			
			//Insert into borrow details table part
			foreach($recommAss as $assetBorrow){
				
				//INSERT TO asset testing details
				$queryDetails = "INSERT INTO assettesting_details (`assettesting_testingID`, `asset_assetID`) VALUES ('{$rowQuery['testingID']}', '{$assetBorrow}');";
				$resultDetails = mysqli_query($dbc,$queryDetails);
				
				//GET ASSET CATEGORY
				$queryGetAssCat = "SELECT am.assetCategory FROM thesis.asset a join assetmodel am on a.assetModel=am.assetModelID where a.assetID='{$assetBorrow}'";
				$resultGetAssCat= mysqli_query($dbc, $queryGetAssCat);
				$rowGetAssCat = mysqli_fetch_array($resultGetAssCat, MYSQLI_ASSOC);
				
				//CHECK IF AN ASSET CATEGORY ALREADY EXISTS IN BORROW DETAILS
				$queryIsAssCatEx = "SELECT count(*) as `isExist` FROM thesis.borrow_details where borrowID='{$rowGetLatBor['borrowID']}' and assetCategoryID='{$rowGetAssCat['assetCategory']}'";
				$resultIsAssCatEx= mysqli_query($dbc, $queryIsAssCatEx);
				$rowIsAssCatEx = mysqli_fetch_array($resultIsAssCatEx, MYSQLI_ASSOC);
				
				if($rowIsAssCatEx['isExist']=='0'){
					//INSERT INTO BORROW DETAILS
					$sql6 = "INSERT INTO `thesis`.`borrow_details` (`borrowID`, `quantity`, `assetCategoryID`, `purpose`) 
							VALUES ('{$rowGetLatBor['borrowID']}', '1', '{$rowGetAssCat['assetCategory']}', '{$rowReq['description']}');";
					$result6 = mysqli_query($dbc, $sql6); 
					
					//GET LATEST BORROW DETAILS
					$queryGetLatBorDet = "SELECT * FROM thesis.borrow_details order by borrow_detailscol desc limit 1";
					$resultGetLatBorDet = mysqli_query($dbc, $queryGetLatBorDet);
					$rowGetLatBorDet = mysqli_fetch_array($resultGetLatBorDet, MYSQLI_ASSOC);
					
					//INSERT ASSET INTO BORROWDETAILSITEM
					$queryInsBorDetIt = "INSERT INTO `thesis`.`borrow_details_item` (`borrow_detailsID`, `assetID`) 
										VALUES ('{$rowGetLatBorDet['borrow_detailscol']}', '{$assetBorrow}');";
					$resultInsBorDetIt = mysqli_query($dbc, $queryInsBorDetIt);
					
					//update asset status
					$QAssetStatus = "UPDATE `thesis`.`asset` SET `assetStatus` = '8' WHERE (`assetID` = '{$assetBorrow}');";
					$RAssetStatus = mysqli_query($dbc,$QAssetStatus);
				}
				else{
					//GET BORROW DETAILS DATA
					$queryGetBorDetDat = "SELECT * FROM thesis.borrow_details where borrowID='{$rowGetLatBor['borrowID']}' and assetCategoryID='{$rowGetAssCat['assetCategory']}'";
					$resultGetBorDetDat = mysqli_query($dbc, $queryGetBorDetDat);
					$rowGetBorDetDat = mysqli_fetch_array($resultGetBorDetDat, MYSQLI_ASSOC);
					
					$addedQty=$rowGetBorDetDat['quantity']+1;
					
					//UPDATE BORROW DETAILS
					$sql6 = "UPDATE `thesis`.`borrow_details` SET `quantity` = '{$addedQty}' WHERE `borrow_detailscol` = '{$rowGetBorDetDat['borrow_detailscol']}';";
					$result6 = mysqli_query($dbc, $sql6); 
					
					//INSERT ASSET INTO BORROWDETAILSITEM
					$queryInsBorDetIt = "INSERT INTO `thesis`.`borrow_details_item` (`borrow_detailsID`, `assetID`) 
										VALUES ('{$rowGetBorDetDat['borrow_detailscol']}', '{$assetBorrow}');";
					$resultInsBorDetIt = mysqli_query($dbc, $queryInsBorDetIt);
					
					//update asset status
					$QAssetStatus = "UPDATE `thesis`.`asset` SET `assetStatus` = '8' WHERE (`assetID` = '{$assetBorrow}');";
					$RAssetStatus = mysqli_query($dbc,$QAssetStatus);
				}
				
			}
			//UPDATE STEP TO COMPLETED
			$queryUpdStepComp = "UPDATE `thesis`.`request` SET `step` = '21' WHERE (`requestID` = '{$requestID}');";
			$resultUpdStepComp = mysqli_query($dbc, $queryUpdStepComp);
			
		}
		$message = "Form submitted!";
		$_SESSION['submitMessage'] = $message; 
	}
?>

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
    <link rel="stylesheet" href="js/data-tables/DT_bootstrap.css" />
    <link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />

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
        <?php include 'requestor_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        View Disapproved Purchase Request
                                    </header>
                                    <div class="panel-body">
                                        <div class="form" method="post">
                                            <form class="cmxform form-horizontal " id="signupForm" method="post" action="">
                                                <?php
                                                    if (isset($_SESSION['submitMessage'])){

                                                        echo "<div style='text-align:center' class='alert alert-success'>
                                                                <strong><h3>{$_SESSION['submitMessage']}</h3></strong>
                                                              </div>";

                                                        unset($_SESSION['submitMessage']);
                                                    }
                                                ?>

                                                <section>
                                                    <h2>
                                                        Status: <span class='label label-danger'>Disapproved</span>
                                                    </h2>
                                                    <br>

                                                    <h4>Request Details</h4>
                                                    <div class="form-group ">
                                                        <label for="dateNeeded" class="control-label col-lg-3">Room</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" value="<?php echo $rowReq['floorRoom']; ?>" disabled />
                                                        </div>
                                                    </div>

                                                    <div class="form-group ">
                                                        <label for="dateNeeded" class="control-label col-lg-3">Date needed</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" value="<?php echo $rowReq['dateNeeded']; ?>" disabled />
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="building" class="control-label col-lg-3">Reason of Request</label>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <textarea class="form-control" rows="5" id="comment" name="comment" style="resize: none" disabled><?php echo $rowReq['description']; ?></textarea>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </section>


                                                <section>
                                                    <h4>Requested Services/Materials</h4>
                                                    <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                        <thead>
                                                            <tr>
                                                                <th>Category</th>
																<th>Quantity</th>
                                                                <th>Specifications</th>
                                                                <th>Purpose</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
															<?php
																//Get Request Details data
																$queryReqDet="SELECT *,rac.name as `assetCatName` FROM thesis.requestdetails rd
																				join ref_assetcategory rac on rd.assetCategory=rac.assetCategoryID where rd.requestID='{$requestID}'";
																$resultReqDet=mysqli_query($dbc,$queryReqDet);
																while($rowReqDet=mysqli_fetch_array($resultReqDet,MYSQLI_ASSOC)){
																	echo "<tr>
																	<td>
																		<div class='col-lg-12'>
																			<input class='form-control' type='text' name='category[]' value='{$rowReqDet['assetCatName']}' id='purpose0' disabled>
																		</div>
																	</td>
																	<td>
																		<div class='col-lg-12'>
																			<input class='form-control' type='text' name='qty[]' value='{$rowReqDet['quantity']}' id='purpose0' disabled>
																		</div>
																	</td>

																	<td style='padding-top:5px; padding-bottom:5px'>
																		<div class='col-lg-12'>
																			<input class='form-control' type='text' name='specs[]' value='{$rowReqDet['description']}' id='purpose0' disabled>
																		</div>
																	</td>
																	<td>
																		<div class='col-lg-12'>
																			<input class='form-control' type='text' name='purpose[]' value='{$rowReqDet['purpose']}' id='purpose0' disabled>
																		</div>
																	</td>
																	
																</tr>";
																}
															?>
                                                            
                                                        </tbody>
                                                    </table>


                                                    <br>
                                                </section>




                                                <!--<section>
                                                    <input type="checkbox" name="check" disabled <?php //if($rowReq['specs']==1){
														//echo "checked";
													//} ?>> Check the checkbox if you would like the IT Team to choose the closest specifications to your request in case the suppliers would not have assets that are the same as your specifications. Leave it unchecked if you yourself would like to choose the specifications that are the closest to your specifications.
                                                    <br><br><br>
                                                </section>-->
                                            </form>
                                            <form class="cmxform form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']." ?id=".$requestID; ?>">
                                                <div class="form-group ">
                                                    <label for="dateNeeded" class="control-label col-lg-3">Reason For Disapproval</label>
                                                    <div class="col-lg-6">
                                                        <textarea class="form-control" rows="5" id="reasOfDisapprov" name="reasOfDisapprov" style="resize: none" disabled><?php echo $rowReq['reasonForDisaprroval']; ?></textarea>
                                                    </div>
                                                </div>
                                                <br>
                                                <h4>These are the assets that are the closest or have the exact specifications. Click the checkbox and press the request button in order to make a borrow request.</h4>

                                                <br>
                                                
                                                    <div class="form-group ">
                                                        <label class="control-label col-lg-3">Asset Return date</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" type="date" name="endDate" min="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>" />
                                                        </div>
                                                    </div>                                                

                                                <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Property Code</th>
                                                            <th>Brand</th>
                                                            <th>Model</th>
                                                            <th>Specifications</th>
                                                            <th>Asset Category</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
														<?php
															$queryAssList="SELECT *,rb.name as `brandName`,am.description as `modelName`,rac.name as `assetCatName`,am.itemSpecification as `modelSpec`,ras.description as `assetStat` FROM thesis.recommended_assets rca left join asset a on rca.assetID=a.assetID
																																																																		  left join assetmodel am on a.assetModel=am.assetModelID
																																																																		  left join ref_brand rb on am.brand=rb.brandID
																																																																		  left join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																																																																		  left join ref_assetstatus ras on a.assetStatus=ras.id where rca.requestID='{$requestID}' and a.assetStatus='1'";
															$resultAssList=mysqli_query($dbc,$queryAssList);
															while($rowAssList=mysqli_fetch_array($resultAssList,MYSQLI_ASSOC)){
																echo "<tr>
																	<td><input type='checkbox' name='recommAss[]' value='{$rowAssList['assetID']}'></td>
																	<td>{$rowAssList['propertyCode']}</td>
																	<td>{$rowAssList['brandName']}</td>
																	<td>{$rowAssList['modelName']}</td>
																	<td>{$rowAssList['modelSpec']}</td>
																	<td>{$rowAssList['assetCatName']}</td>
																	<td>{$rowAssList['assetStat']}</td>
																</tr>";
															}
														
														?>
                                                        
                                                    </tbody>
                                                </table>
                                                <button class="btn btn-success" type="submit" name="request">Request</button>
                                                <button class="btn btn-danger" onclick="window.history.back()">Back</button>
                                            </form>
                                        </div>
                                    </div>
                                </section>
                            </div>
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
    <script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
    <script src="js/dynamic_table_init.js"></script>
	
	<!--common script init for all pages-->
    <script src="js/scripts.js"></script>
	
    <script type="text/javascript">
        var count = 1;
        // Shorthand for $( document ).ready()
        $(function() {

        });

        $.ajax({
            type: "POST",
            url: "count.php",
            data: 'count=' + count,
            success: function(data) {
                $("#count").html(data);

            }
        });

        }

        function getRooms(val) {
            $.ajax({
                type: "POST",
                url: "requestor_getRooms.php",
                data: 'buildingID=' + val,
                success: function(data) {
                    $("#FloorAndRoomID").html(data);

                }
            });
        }
    </script>

</body>

</html>