<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	$procID=$_GET['procID'];
	
	//GET PROCUREMENT DATA
	$queryProcDat="SELECT p.supplierID,rs.description as `statusDesc`,p.date,s.name as `supplierName`,s.address FROM thesis.procurement p join supplier s on p.supplierID=s.supplierID
								   join ref_status rs on p.status=rs.statusID where p.procurementID='{$procID}'";
	$resultProcDat=mysqli_query($dbc,$queryProcDat);
	$rowProcDat=mysqli_fetch_array($resultProcDat,MYSQLI_ASSOC);
	
	
	if (isset($_POST['submit'])){
		$overallQty=0;
		
		$dateReceived=$_POST['dateReceived'];
		$qtyReceived=$_POST['qtyReceived'];
		$assetCategoryIDArr=$_POST['assetCategoryID'];
		$assetModelIDArr=$_POST['assetModelID'];
		$qtyOrdered=$_POST['qtyOrdered'];
		$costs=$_POST['costs'];
		
		//GET REQUEST DATA
		$queryReqDat="SELECT p.requestID,r.UserID,r.FloorAndRoomID FROM thesis.procurement p join request r on p.requestID=r.requestID where p.procurementID='{$procID}'";
		$resultReqDat=mysqli_query($dbc,$queryReqDat);
		$rowReqDat=mysqli_fetch_array($resultReqDat,MYSQLI_ASSOC);
		
		//INSERT INTO DELIVERY TABLE
		$queryDeliv="INSERT INTO `thesis`.`delivery` (`procurementID`) VALUES ('{$procID}')";
		$resultDeliv=mysqli_query($dbc,$queryDeliv);
		
		//GET LATEST DELIVERY DATA
		$queryLatDeliv="SELECT * FROM thesis.delivery order by id desc limit 1";
		$resultLatDeliv=mysqli_query($dbc,$queryLatDeliv);
		$rowLatDeliv=mysqli_fetch_array($resultLatDeliv,MYSQLI_ASSOC);
		
		for($i=0;$i<sizeOf($assetModelIDArr);$i++){
			//INSERT INTO DELIVERY DETAILS TABLE
			$queryDelivDet="INSERT INTO `thesis`.`deliverydetails` (`DeliveryID`, `quantity`, `ref_assetCategoryID`, `assetModelID`, `itemsReceived`, `deliveryDate`) VALUES ('{$rowLatDeliv['id']}', '{$qtyOrdered[$i]}', '{$assetCategoryIDArr[$i]}', '{$assetModelIDArr[$i]}', '{$qtyReceived[$i]}', '{$dateReceived[$i]}')";
			$resultDelivDet=mysqli_query($dbc,$queryDelivDet);
		}
		//GET LATEST DELIVERYDETAILS DATA
		$queryLatDelDet="SELECT * FROM thesis.deliverydetails where DeliveryID='{$rowLatDeliv['id']}'";
		$resultLatDelDet=mysqli_query($dbc,$queryLatDelDet);
		while($rowLatDelDet=mysqli_fetch_array($resultLatDelDet,MYSQLI_ASSOC)){
			//INSERT TO ASSET TABLE
			for($i=0;$i<$rowLatDelDet['itemsReceived'];$i++){
				$queryInsAss="INSERT INTO `thesis`.`asset` (`supplierID`, `assetModel`, `assetStatus`) VALUES ('{$rowProcDat['supplierID']}', '{$rowLatDelDet['assetModelID']}', '8')";
				$resultInsAss=mysqli_query($dbc,$queryInsAss);
				
				//SELECT LATEST ASSET	
				$queryLatAss="SELECT * FROM thesis.asset order by assetID desc limit 1";
				$resultLatAss=mysqli_query($dbc,$queryLatAss);
				$rowLatAss=mysqli_fetch_array($resultLatAss,MYSQLI_ASSOC);
				
				//Insert to assetdocument table	
				$queryasd="INSERT INTO `thesis`.`assetdocument` (`assetID`, `requestID`, `procurementID`) VALUES ('{$rowLatAss['assetID']}', '{$rowReqDat['requestID']}', '{$procID}')";
				$resultasd=mysqli_query($dbc,$queryasd);
				
			}
			
		}
		
		//Check if a specific procurement order is complete
		$queryIsProcComp="SELECT SUM(quantity) as `qtyOrdered`,SUM(itemsReceived) as `qtyReceived` FROM thesis.deliverydetails where DeliveryID='{$rowLatDeliv['id']}'";
		$resultIsProcComp=mysqli_query($dbc,$queryIsProcComp);
		$rowIsProcComp=mysqli_fetch_array($resultIsProcComp,MYSQLI_ASSOC);
		
		if($rowIsProcComp['qtyOrdered']==$rowIsProcComp['qtyReceived']){
			$querya="UPDATE `thesis`.`procurement` SET `status`='3' WHERE `procurementID`='{$procID}'";
			$resulta=mysqli_query($dbc,$querya);
		}
		else{
			$querya="UPDATE `thesis`.`procurement` SET `status`='4' WHERE `procurementID`='{$procID}'";
			$resulta=mysqli_query($dbc,$querya);
		}
		
		//Check if all the procurement order is complete
		$queryStep="SELECT count(*) as `isComplete` FROM thesis.procurement where requestID='{$rowaa['requestID']}' and status!=3";
		$resultStep=mysqli_query($dbc,$queryStep);
		$rowStep=mysqli_fetch_array($resultStep,MYSQLI_ASSOC);
		
		if($rowStep['isComplete']==0){
			$queryUpd="UPDATE `thesis`.`request` SET `step`='9' WHERE `requestID`='{$rowaa['requestID']}'";
			$resultUpd=mysqli_query($dbc,$queryUpd);
		}
		else{
			$queryUpd="UPDATE `thesis`.`request` SET `step`='8' WHERE `requestID`='{$rowaa['requestID']}'";
			$resultUpd=mysqli_query($dbc,$queryUpd);
		}
		
		$message = "Form Submitted!";
		$_SESSION['submitMessage'] = $message;
		
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
        <?php include 'it_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->
				<?php
                    if (isset($_SESSION['submitMessage'])){

                        echo "<div class='alert alert-success'>
                                {$_SESSION['submitMessage']}
							  </div>";
                        unset($_SESSION['submitMessage']);
                    }
				?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">

                            <section class="panel">
                                <header class="panel-heading">
                                    Purchase Order
                                </header>
                                <div class="panel-body">
                                    <section id="unseen">
                                        <div class="row invoice-to">
                                            <div class="col-md-4 col-sm-4 pull-left">
                                                <h4>Receive Order From:</h4>
                                                <h2><?php echo $rowProcDat['supplierName']; ?></h2>
                                                <h5>Address: <?php echo $rowProcDat['address']; ?></h5>
                                            </div>
                                            <div class="col-md-4 col-sm-5 pull-right">
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-5 inv-label">Purchase Order #</div>
                                                    <div class="col-md-8 col-sm-7"><?php echo $procID; ?></div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-5 inv-label">Date </div>
                                                    <div class="col-md-8 col-sm-7"><?php echo $rowProcDat['date']; ?></div>
													<br>
													<br>
													
													<div style="padding-left:15px">
														<strong>Status:</strong>
														&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														<?php
															if($rowProcDat['statusDesc']=="Completed"){
																echo "<label class='btn btn-success'>{$rowProcDat['statusDesc']}</label>";
															
															}
															elseif($rowProcDat['statusDesc']=="Incomplete"){
																echo "<label class='btn btn-danger'>{$rowProcDat['statusDesc']}</label>";
															}
															else{
																echo "<label class='btn btn-warning'>{$rowProcDat['statusDesc']}</label>";
															}
														
														
														?>
														
														
													</div>
                                                </div>
                                                <br>


                                            </div>
                                        </div>
                                        
                                        <!--<h5>*Note: If Items are complete, please leave the comment field blank. If items are incomplete, just place the quantity received in the comment box.</h5>-->
                                        <form method="post">
										<table class="table table-invoice">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Item Description</th>
                                                    <th class="text-center">Unit Cost</th>
                                                    <th class="text-center">Qty Ordered</th>
                                                    <th class="text-center">Total</th>
													<th class="text-center">Expected Delivery Date</th>
													<th class="text-center">Date Received</th>
                                                    <th>Qty Received</th>

                                                </tr>
                                            </thead>
                                            <tbody>
												
												<?php
													
													$query="SELECT pd.assetModelID as `assetModelID`,CONCAT(rb.name, ' ',rac.name) as `itemName`,pd.cost,pd.quantity,(pd.cost*pd.quantity) as `totalCost`,am.description as `assetModelDesc`,am.assetCategory as `assetCategory`,pd.expectedDeliveryDate FROM thesis.procurementdetails pd join assetmodel am on pd.assetModelID=am.assetModelID join ref_brand rb on am.brand=rb.brandID
															join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID where pd.procurementID='{$procID}'";
													$result=mysqli_query($dbc,$query);
													while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
														echo "
															<tr>
															<input type='hidden' name='assetCategoryID[]' value='{$row['assetCategory']}'>
															<input type='hidden' name='assetModelID[]' value='{$row['assetModelID']}'>
															<input type='hidden' name='qtyOrdered[]' value='{$row['quantity']}'>
															<input type='hidden' name='costs[]' value='{$row['cost']}'>
															<td>{$row['assetModelID']}</td>
															<td>
																<h4>{$row['itemName']}</h4>
																<p>{$row['assetModelDesc']}</p>
															</td>
															<td class='text-center'>{$row['cost']}</td>
															<td class='text-center'>{$row['quantity']}</td>
															<td class='text-center'>P {$row['totalCost']}</td>
															<td class='text-center'>{$row['expectedDeliveryDate']}</td>
															<td class='text-center'><input class='form-control' name='dateReceived[]' type='date' required></td>
															<td>
															<input type='number' min='0' max='{$row['quantity']}' class='form-control' name='qtyReceived[]' required>
															</td>
															</tr>";
													}
												
												
												
												
												?>
												
											
                                                <!-- <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <h4>Windows 10</h4>
                                                        <p>Product Key is 11111111</p>
                                                    </td>
                                                    <td class="text-center">1</td>
                                                    <td class="text-center">4</td>
                                                    <td class="text-center">P 1300.00</td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>
                                                        <h4>MAC LAPTOP</h4>
                                                        <p>Green Laptop with 4Gb Ram</p>
                                                    </td>
                                                    <td class="text-center">2</td>
                                                    <td class="text-center">5</td>
                                                    <td class="text-center">P 1300.00</td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>
                                                        <h4>VGA</h4>
                                                        <p>Blue ang ulo</p>
                                                    </td>
                                                    <td class="text-center">1</td>
                                                    <td class="text-center">9</td>
                                                    <td class="text-center">P 1300.00</td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
												-->

                                            </tbody>
                                        </table>
                                        <div class="text-center invoice-btn">
											<button type="submit" name="submit" class="btn btn-success btn-lg" data-dismiss="modal"><i class="fa fa-external-link"></i> Submit </button>
                                            <a href="it_po_list.php" class="btn btn-danger btn-lg"><i class="fa fa-times-circle-o"></i> Back </a>
                                        </div>
										</form>
                                    </section>
                                </div>
                            </section>
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


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>