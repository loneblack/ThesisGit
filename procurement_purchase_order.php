<!DOCTYPE html>
<?php
	require_once('db/mysql_connect.php');
	session_start();
	$canvasID=$_GET['canvasID'];
	if(isset($_POST['submit'])){
		//UPDATE canvas status
		//$queryb="UPDATE `thesis`.`canvas` SET `status`='3' WHERE `canvasID`='{$canvasID}'";
		//$resultb=mysqli_query($dbc,$queryb);
		
		//UPDATE request status
		$queryc="SELECT requestID FROM thesis.canvas where canvasID='{$canvasID}'";
		$resultc=mysqli_query($dbc,$queryc);
		$rowc=mysqli_fetch_array($resultc,MYSQLI_ASSOC);
		
		//$queryd="UPDATE `thesis`.`request` SET `status`='3' WHERE `requestID`='{$rowc['requestID']}'";
		//$resultd=mysqli_query($dbc,$queryd);
		
		//Get Employee Name
		$queryf="SELECT employeeID FROM thesis.employee where UserID='{$_SESSION['userID']}'";
		$resultf=mysqli_query($dbc,$queryf);
		$rowf=mysqli_fetch_array($resultf,MYSQLI_ASSOC);
		
		//Insert to procurement table
		$queryg="SELECT cid.supplier_supplierID as `supplierID`,s.name as `supplierName`,s.address FROM thesis.canvasitem ci 
							join canvasitemdetails cid on ci.cavasItemID=cid.cavasItemID 
							join supplier s on cid.supplier_supplierID=s.supplierID
							where ci.canvasID='{$canvasID}' 
							group by cid.supplier_supplierID";
		$resultg=mysqli_query($dbc,$queryg);
		
		$queryReqID="SELECT requestID FROM thesis.canvas where canvasID='{$canvasID}'";
		$resultReqID=mysqli_query($dbc,$queryReqID);
		$rowReqID=mysqli_fetch_array($resultReqID,MYSQLI_ASSOC);
		
		while($rowg=mysqli_fetch_array($resultg,MYSQLI_ASSOC)){
			//Get totalSum of approved canvas item
			$querye="SELECT sum(cid.price*ci.quantity) as `totalPrice` FROM thesis.canvas c join canvasitem ci on c.canvasID=ci.canvasID
							  join canvasitemdetails cid on ci.cavasItemID=cid.cavasItemID
                              where c.canvasID='{$canvasID}' and cid.supplier_supplierID='{$rowg['supplierID']}'";
			$resulte=mysqli_query($dbc,$querye);
			$rowe=mysqli_fetch_array($resulte,MYSQLI_ASSOC);
			
			$queryh="INSERT INTO `thesis`.`procurement` (`requestID`, `date`, `totalCost`, `status`, `preparedBy`, `supplierID`) VALUES ('{$rowc['requestID']}', now(), '{$rowe['totalPrice']}', '1', '{$rowf['employeeID']}', '{$rowg['supplierID']}')";
			$resulth=mysqli_query($dbc,$queryh);
			
			$queryx="SELECT * FROM thesis.procurement order by procurementID desc";
			$resultx=mysqli_query($dbc,$queryx);
			$rowx=mysqli_fetch_array($resultx,MYSQLI_ASSOC);
			
			//INSERT TO NOTIFICATIONS TABLE
			$sqlNotif = "INSERT INTO `thesis`.`notifications` (`isRead`, `procurementID`) VALUES (false, '{$rowx['procurementID']}');";
			$resultNotif = mysqli_query($dbc, $sqlNotif);
			
			//Get Canvas Items
			$queryi="SELECT ci.cavasItemID,CONCAT(rb.name, ' ',rac.name) as `itemName`,am.itemSpecification,ci.description,cid.quantity,cid.price,(ci.quantity*cid.price) as `totalPrice`,ci.assetModel,ci.assetCategory,cid.expectedDate FROM thesis.canvasitemdetails cid
				join canvasitem ci on cid.cavasItemID=ci.cavasItemID 
				join assetModel am on ci.assetModel=am.assetModelID
				join ref_brand rb on am.brand=rb.brandID
				join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID 
				where ci.canvasID='{$canvasID}'  and cid.supplier_supplierID='{$rowg['supplierID']}'";
			$resulti=mysqli_query($dbc,$queryi);
			while($rowi=mysqli_fetch_array($resulti,MYSQLI_ASSOC)){
				$queryj="INSERT INTO `thesis`.`procurementdetails` (`procurementID`, `description`, `quantity`, `cost`, `subtotal`, `assetCategoryID`, `assetModelID`, `expectedDeliveryDate`) VALUES ('{$rowx['procurementID']}', '{$rowi['description']}', '{$rowi['quantity']}', '{$rowi['price']}', '{$rowi['totalPrice']}', '{$rowi['assetCategory']}', '{$rowi['assetModel']}', '{$rowi['expectedDate']}')";
				$resultj=mysqli_query($dbc,$queryj);
			}
			
		}
		$queryd="UPDATE `thesis`.`request` SET `step`='7' WHERE `requestID`='{$rowReqID['requestID']}'";
		$resultd=mysqli_query($dbc,$queryd);
		
		$message = "Purchase Order Submitted!";
		$_SESSION['submitMessage'] = $message;
		
		//header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/procurement_view_completed.php?canvasID=".$canvasID);
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
        <?php include 'procurement_navbar.php' ?>

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
					<form method="post">
					<div class='text-center invoice-btn'>
						
							<button type="submit" class="btn btn-success btn-lg" name="submit"><i class='fa fa-check'></i> Send </button>
                            <button class="btn btn-primary btn-lg" onclick="printContent('poform')"><i class="fa fa-print"></i> Print</button>
						
					</div>
					<?php
						
						$query="SELECT cid.supplier_supplierID as `supplierID`,s.name as `supplierName`,s.address FROM thesis.canvasitem ci 
							join canvasitemdetails cid on ci.cavasItemID=cid.cavasItemID 
							join supplier s on cid.supplier_supplierID=s.supplierID
							where ci.canvasID='{$canvasID}'
							group by cid.supplier_supplierID";
						$result=mysqli_query($dbc,$query);
						
						while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
							echo "<div class='row'>
							<div class='col-sm-12'>
								<div class='col-sm-12'>
									<section class='panel'>
										<header class='panel-heading'>
											Purchase Order
										</header>
										<div class='panel-body'>
                                            <h3>Instructions: Print the Purchase Order and let the Approver Sign it.</h3>
											<section id='unseen'>
                                                <div id='poform'>
												<div class='row invoice-to'>
													<div class='col-md-4 col-sm-4 pull-left'>
														<h4>Purchase Order To:</h4>
														<h2>{$row['supplierName']}</h2>
														<h5>Address: {$row['address']}</h5>
													</div>
													<div class='col-md-4 col-sm-5 pull-right'>
														
														
													</div>
												</div>
												<table class='table table-invoice'>
													<thead>
														<tr>
															<th>#</th>
															<th>Item Description</th>
															<th class='text-center'>Unit Cost</th>
															<th class='text-center'>Quantity</th>
															<th class='text-center'>Total</th>
															<th class='text-center'>Expected Delivery Date</th>
														</tr>
													</thead>
													<tbody>";
													
													
													$querya="SELECT cid.expectedDate,ci.cavasItemID,CONCAT(rb.name, ' ',rac.name) as `itemName`,am.itemSpecification,am.description,cid.quantity,cid.price,(ci.quantity*cid.price) as `totalPrice` FROM thesis.canvasitemdetails cid
																join canvasitem ci on cid.cavasItemID=ci.cavasItemID 
																join assetModel am on ci.assetModel=am.assetModelID
																join ref_brand rb on am.brand=rb.brandID
																join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID 
																where ci.canvasID='{$canvasID}' and cid.supplier_supplierID='{$row['supplierID']}'";
													$resulta=mysqli_query($dbc,$querya);
													while($rowa=mysqli_fetch_array($resulta,MYSQLI_ASSOC)){
														echo "<tr>
															<td>{$rowa['cavasItemID']}</td>
															<td>
																<h4>{$rowa['itemName']}</h4>
																<p>{$rowa['description']}</p>
															</td>
															<td class='text-center'>₱ {$rowa['price']}</td>
															<td class='text-center'>{$rowa['quantity']}</td>
															<td class='text-center'>₱ {$rowa['totalPrice']}</td>
															<td class='text-center'>{$rowa['expectedDate']}</td>
														</tr>";
													}
													
													echo "</tbody>
												</table>
                                                </div>
											</section>
										</div>
									</section>
								</div>
							</div>
						</div>";
						}
					
					
					
					?>
					</form>
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
    <script>
        $(":input").bind('keyup change click', function(e) {

            if ($(this).val() < 0) {
                $(this).val('')
            }

        });
        
        function printContent(el){
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
        }
    </script>
</body>

</html>