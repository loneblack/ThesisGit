<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	$testingID=$_GET['testingID'];
	
	
	if(isset($_POST['send'])){
		
		$query1="SELECT rb.name as `brand`,am.description as `assetModel`,atd.asset_assetID as `assetID`,atd.comment,a.assetModel FROM thesis.assettesting_details atd join asset a on atd.asset_assetID=a.assetID 
																												join assetmodel am on a.assetModel=am.assetModelID
																												join ref_brand rb on am.brand=rb.brandID
																												where assettesting_testingID='{$testingID}' and atd.check='1'";
		$result1=mysqli_query($dbc,$query1);
		
		
		//Functioning asset
		while($row1=mysqli_fetch_array($result1,MYSQLI_ASSOC)){
			//INSERT Property Code
			
				
		}
		
		//Defect asset 
		
		//GET EMPLOYEEID
		$queryEmp="SELECT * FROM thesis.employee where UserID='{$_SESSION['userID']}'";
		$resultEmp=mysqli_query($dbc,$queryEmp);
		$rowEmp=mysqli_fetch_array($resultEmp,MYSQLI_ASSOC);
		
		//GET EACH SUPPLIER
		$queryg="SELECT a.supplierID,ad.requestID FROM thesis.assettesting_details atd join asset a on atd.asset_assetID=a.assetID 
											  join assetdocument ad on a.assetID=ad.assetID
											  join assetmodel am on a.assetModel=am.assetModelID
											  where atd.assettesting_testingID='1' and atd.check='0' 
                                              group by a.supplierID";
		$resultg=mysqli_query($dbc,$queryg);
		
		while($rowg=mysqli_fetch_array($resultg,MYSQLI_ASSOC)){
			//CREATE PO
			$query3="INSERT INTO `thesis`.`procurement` (`requestID`, `date`, `status`, `preparedBy`, `supplierID`) VALUES ('{$rowg['requestID']}', now(), '1', '{$rowEmp['employeeID']}', '{$rowg['supplierID']}')";
			$result3=mysqli_query($dbc,$query3);
			
			//GET CREATED Proc ID
			$queryProcID="SELECT * FROM thesis.procurement order by procurementID desc limit 1";
			$resultProcID=mysqli_query($dbc,$queryProcID);
			$rowProcID=mysqli_fetch_array($resultProcID,MYSQLI_ASSOC);
			
			//GET ALL DEFECT ASSETS
			$query0="SELECT atd.asset_assetID, count(atd.asset_assetID) as `qty`, a.unitCost,(count(atd.asset_assetID)*a.unitCost) as `totalCost`,am.assetCategory,a.assetModel FROM thesis.assettesting_details atd 
											  join asset a on atd.asset_assetID=a.assetID 
											  join assetmodel am on a.assetModel=am.assetModelID
											  where atd.assettesting_testingID='{$testingID}' and atd.check='0' and a.supplierID='{$rowg['supplierID']}'
                                              group by a.assetModel";
			$result0=mysqli_query($dbc,$query0);
			while($row0=mysqli_fetch_array($result0,MYSQLI_ASSOC)){
				//INSERT PO DETAILS
				$query2="INSERT INTO `thesis`.`procurementdetails` (`procurementID`, `quantity`, `cost`, `subtotal`, `assetCategoryID`, `assetModelID`) VALUES ('{$rowProcID['procurementID']}', '{$row0['qty']}', '{$row0['unitCost']}', '{$row0['totalCost']}', '{$row0['assetCategory']}', '{$row0['assetModel']}')";
				$result2=mysqli_query($dbc,$query2);
			}
		}
		
		
		
		
		
		
		
		
				
		
		
		
		
		
		
		
		
		
		
		
		//$queryh="INSERT INTO `thesis`.`procurement` (`requestID`, `date`, `totalCost`, `status`, `preparedBy`, `supplierID`) VALUES ('{$rowc['requestID']}', now(), '{$rowe['totalPrice']}', '1', '{$rowf['employeeID']}', '{$rowg['supplierID']}')";
		//$queryj="INSERT INTO `thesis`.`procurementdetails` (`procurementID`, `description`, `quantity`, `cost`, `subtotal`, `assetCategoryID`, `assetModelID`) VALUES ('{$rowx['procurementID']}', '{$rowi['description']}', '{$rowi['quantity']}', '{$rowi['price']}', '{$rowi['totalPrice']}', '{$rowi['assetCategory']}', '{$rowi['assetModel']}')";
		
		//CREATE PO
		if(isset($model)){
			$query3="INSERT INTO `thesis`.`procurement` (`requestID`, `date`, `status`, `preparedBy`, `supplierID`) VALUES ('{$reqid}', now(), '1', '{$rowEmp['employeeID']}', '{$supid}')";
			$result3=mysqli_query($dbc,$query3);
			
			foreach($model as $value){
				
				
				
				
				$query4="INSERT INTO `thesis`.`procurementdetails` (`procurementID`,`quantity`, `cost`, `subtotal`, `assetCategoryID`, `assetModelID`) VALUES ('{}','{$rowi['quantity']}', '{$rowi['price']}', '{$rowi['totalPrice']}', '{$rowi['assetCategory']}', '{$rowi['assetModel']}')";
				$result4=mysqli_query($dbc,$query4);
			}
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
        <?php include 'it_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

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
														<h2>Completed</h2>
													</div>
													<div class="col-md-4 col-sm-5 pull-right">
														<div class="row">
															<div class="col-md-4 col-sm-5 inv-label">Testing #</div>
															<div class="col-md-8 col-sm-7">233426</div>
														</div>
														<br>
														<div class="row">
															<div class="col-md-4 col-sm-5 inv-label">Date Updated </div>
															<div class="col-md-8 col-sm-7">21 December 2018</div>
														</div>
														<br>


													</div>
												</div>
											
											<table class="table table-invoice">
												<thead>
													<tr>
														<th></th>
														<th>Property Code</th>
														<th class="text-center">Brand</th>
														<th>Model</th>
														<th class="text-center">Comments</th>
													</tr>
												</thead>
												<tbody>
													
													<?php
														
														$query = "SELECT rb.name as `brand`,am.description as `assetModel`,atd.asset_assetID,atd.check,atd.comment FROM thesis.assettesting_details atd join asset a on atd.asset_assetID=a.assetID 
																												join assetmodel am on a.assetModel=am.assetModelID
																												join ref_brand rb on am.brand=rb.brandID
																												where assettesting_testingID='{$testingID}'";         
														$result = mysqli_query($dbc, $query);
														while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
															echo "<tr>
																	<td class='text-center'><input type='checkbox' ";
																
																if($row['check']=='1'){
																	echo "checked";
																}
																	
															echo "	disabled></td>
																	<td></td>
																	<td class='text-center'>{$row['brand']}</td>
																	<td>{$row['assetModel']}</td>
																	<td class='text-center'><input type='text' class='form-control' value='";
																if($row['check']=='0'){
																	echo $row['comment'];
																}	
																	
															echo "' disabled></td>
															</tr>";
														}
													
													
													?>
												</tbody> 
												<!-- <tbody>
													<tr>
														<td class="text-center"><input type="checkbox" disabled></td>
														<td>1019212</td>
														<td class="text-center">Samsung</td>
														<td>S8 Edge</td>
														<td class="text-center"><input type="text" class="form-control" disabled></td>
													</tr>
													<tr>
														<td class="text-center"><input type="checkbox" disabled></td>
														<td>1019212</td>
														<td class="text-center">Samsung</td>
														<td>S8 Edge</td>
														<td class="text-center"><input type="text" class="form-control" disabled></td>
													</tr>
												</tbody> -->
											</table>
										</section>
									</div>
								</section>
								<button type="submit" name="send" class="btn btn-success">Send</button>
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