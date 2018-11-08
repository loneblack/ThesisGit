<!DOCTYPE html>
<?php
	require_once('db/mysql_connect.php');
	$procID=$_GET['procID'];
	
	$queryz="SELECT rs.description as `statusDesc`,p.date,s.name as `supplierName`,s.address FROM thesis.procurement p join supplier s on p.supplierID=s.supplierID
								   join ref_status rs on p.status=rs.statusID where p.procurementID='{$procID}'";
	$resultz=mysqli_query($dbc,$queryz);
	$rowz=mysqli_fetch_array($resultz,MYSQLI_ASSOC);
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
                    Welcome IT Officer!
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

                            <section class="panel">
                                <header class="panel-heading">
                                    Purchase Order
                                </header>
                                <div class="panel-body">
                                    <section id="unseen">
                                        <div class="row invoice-to">
                                            <div class="col-md-4 col-sm-4 pull-left">
                                                <h4>Purchase Order To:</h4>
                                                <h2><?php echo $rowz['supplierName']; ?></h2>
                                                <h5>Address: <?php echo $rowz['address']; ?></h5>
                                            </div>
                                            <div class="col-md-4 col-sm-5 pull-right">
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-5 inv-label">Purchase Order #</div>
                                                    <div class="col-md-8 col-sm-7"><?php echo $procID; ?></div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-5 inv-label">Date </div>
                                                    <div class="col-md-8 col-sm-7"><?php echo $rowz['date']; ?></div>
													<br>
													<br>
													
													<div style="padding-left:15px">
														<strong>Status:</strong>
														&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														<label class="btn btn-danger"><?php echo $rowz['statusDesc']; ?></label>
													</div>
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
                                                    <!-- <th>Comments</th> -->

                                                </tr>
                                            </thead>
                                            <tbody>
											
												<?php
													$query="SELECT pd.assetModelID as `assetModelID`,CONCAT(rb.name, ' ',rac.name) as `itemName`,pd.cost,pd.quantity,(pd.cost*pd.quantity) as `totalCost`,am.description as `assetModelDesc`,am.assetCategory as `assetCategory` FROM thesis.procurementdetails pd join assetmodel am on pd.assetModelID=am.assetModelID join ref_brand rb on am.brand=rb.brandID
															join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID where pd.procurementID='{$procID}'";
													$result=mysqli_query($dbc,$query);
													while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
														echo "<tr>
																<td>{$row['assetModelID']}</td>
																<td>
																	<h4>{$row['itemName']}</h4>
																	<p>{$row['assetModelDesc']}</p>
																</td>
																<td class='text-center'>{$row['cost']}</td>
																<td class='text-center'>{$row['quantity']}</td>
																<td class='text-center'>P {$row['totalCost']}</td>
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
                                                                <input type="text" class="form-control" value="1" disabled>
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
                                                                <input type="text" class="form-control" disabled>
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
                                                                <input type="text" class="form-control" disabled>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr> -->

                                            </tbody>
                                        </table>
                                        <div class="text-center invoice-btn">
                                            <a href="it_po_list.php" class="btn btn-danger btn-lg"><i class="fa fa-times-circle-o"></i> Back </a>
                                        </div>
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