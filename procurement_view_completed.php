<!DOCTYPE html>
<?php
	require_once('db/mysql_connect.php');
	$canvasID=$_GET['canvasID'];
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

                <div class="row">
				<div class="text-center invoice-btn">
                                            <h2>Procurement Completed</h2>
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
											Completed
										</header>
										<div class='panel-body'>
											<section id='unseen'>
												<div class='row invoice-to'>
													<div class='col-md-4 col-sm-4 pull-left'>
														<h4>Purchase Order To:</h4>
														<h2>{$row['supplierName']}</h2>
														<h5>Address: {$row['address']}</h5>
													</div>
													<div class='col-md-4 col-sm-5 pull-right'>
														<div class='row'>
															<div class='col-md-4 col-sm-5 inv-label'>Purchase Order #</div>
															<div class='col-md-8 col-sm-7'>233426</div>
														</div>
														<br>
														<div class='row'>
															<div class='col-md-4 col-sm-5 inv-label'>Date </div>
															<div class='col-md-8 col-sm-7'>21 December 2018</div>
														</div>
														<br>


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
														</tr>
													</thead>
													<tbody>";
													
													
													$querya="SELECT ci.cavasItemID,CONCAT(rb.name, ' ',rac.name) as `itemName`,am.itemSpecification,ci.description,ci.quantity,cid.price,(ci.quantity*cid.price) as `totalPrice` FROM thesis.canvasitemdetails cid
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
														</tr>";
													}
													
													echo "</tbody>
												</table>
											</section>
										</div>
									</section>
								</div>
							</div>
						</div>";
						}
					
					
					
					?>
				
				<!--
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        Completed
                                    </header>
                                    <div class="panel-body">
                                        <div class="text-center invoice-btn">
                                            <h2>Procurement Completed</h2>
                                        </div>
                                        <section id="unseen">
                                            <div class="row invoice-to">
                                                <div class="col-md-4 col-sm-4 pull-left">
                                                    <h4>Purchase Order To:</h4>
                                                    <h2>CDR Kingina Company</h2>
                                                    <h5>Address: 554 Dimaunahan Street, Quezon City</h5>
                                                </div>
                                                <div class="col-md-4 col-sm-5 pull-right">
                                                    <div class="row">
                                                        <div class="col-md-4 col-sm-5 inv-label">Purchase Order #</div>
                                                        <div class="col-md-8 col-sm-7">233426</div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-4 col-sm-5 inv-label">Date </div>
                                                        <div class="col-md-8 col-sm-7">21 December 2018</div>
                                                    </div>
                                                    <br>


                                                </div>
                                            </div>
                                            <table class="table table-invoice">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Item Description</th>
                                                        <th class="text-center">Unit Cost</th>
                                                        <th class="text-center">Quantity</th>
                                                        <th class="text-center">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>
                                                            <h4>Windows 10</h4>
                                                            <p>Product Key is 11111111</p>
                                                        </td>
                                                        <td class="text-center">1</td>
                                                        <td class="text-center">4</td>
                                                        <td class="text-center">P 1300.00</td>
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
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </section>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>

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
                                                    <h4>Purchase Order To:</h4>
                                                    <h2>ABC Company</h2>
                                                    <h5>Address: 554 Dimaunahan Street, Quezon City</h5>
                                                </div>
                                                <div class="col-md-4 col-sm-5 pull-right">
                                                    <div class="row">
                                                        <div class="col-md-4 col-sm-5 inv-label">Purchase Order #</div>
                                                        <div class="col-md-8 col-sm-7">233426</div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-4 col-sm-5 inv-label">Date </div>
                                                        <div class="col-md-8 col-sm-7">21 December 2018</div>
                                                    </div>
                                                    <br>


                                                </div>
                                            </div>
                                            <table class="table table-invoice">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Item Description</th>
                                                        <th class="text-center">Unit Cost</th>
                                                        <th class="text-center">Quantity</th>
                                                        <th class="text-center">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>
                                                            <h4>Windows 10</h4>
                                                            <p>Product Key is 11111111</p>
                                                        </td>
                                                        <td class="text-center">1</td>
                                                        <td class="text-center">4</td>
                                                        <td class="text-center">P 1300.00</td>
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
                                                    </tr>

                                                </tbody>
                                            </table>

                                        </section>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div> -->
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
    </script>
</body>

</html>