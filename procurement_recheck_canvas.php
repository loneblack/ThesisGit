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
                    Welcome Procurement!
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
                    <div class="row">
                        <div class="col-sm-12">
                            <section class="panel">
                                <header class="panel-heading">
                                    Recheck Canvas
                                </header>
                                <div class="panel-body">
                                    <section id="unseen">
                                        <div class="row invoice-to">
                                            <div class="col-md-4 col-sm-4 pull-left">
                                                <h4>Sent To:</h4>
                                                <h2>Procurement</h2>
                                                <h5>Status: Recheck Canvas</h5>
                                            </div>
                                            <div class="col-md-4 col-sm-5 pull-right">
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-5 inv-label">Procurement #</div>
                                                    <div class="col-md-8 col-sm-7">233426</div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-5 inv-label">Date Needed </div>
                                                    <div class="col-md-8 col-sm-7">21 December 2018</div>
                                                </div>
                                                <br>


                                            </div>
                                        </div>
                                        <table class="table table-invoice">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Item Description</th>
                                                    <th class="text-center">Specifications</th>
                                                    <th class="text-center">Quantity</th>
                                                    <th class="text-center">Supplier</th>
                                                    <th class="text-center">Unit Cost</th>
													<th class="text-center">Total Price</th>
                                                </tr>
                                            </thead>
											
                                            <!-- <tbody>
                                                <tr>
                                                    <td><input type="checkbox" disabled></td>
                                                    <td>
                                                        <h4>MAC Laptop</h4>
                                                        <p>The green one please.</p>
                                                    </td>
                                                    <td class="text-center">4Gb RAM</td>
                                                    <td class="text-center">4</td>
                                                    <td class="text-center">ABC Co.</td>
                                                    <td class="text-center">P 4 000.00</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" disabled></td>
                                                    <td>
                                                        <h4>MAC Laptop</h4>
                                                        <p>The green one please.</p>
                                                    </td>
                                                    <td class="text-center">4Gb RAM</td>
                                                    <td class="text-center">4</td>
                                                    <td class="text-center">ABC Co.</td>
                                                    <td class="text-center">P 4 000.00</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" disabled></td>
                                                    <td>
                                                        <h4>MAC Laptop</h4>
                                                        <p>The green one please.</p>
                                                    </td>
                                                    <td class="text-center">4Gb RAM</td>
                                                    <td class="text-center">4</td>
                                                    <td class="text-center">ABC Co.</td>
                                                    <td class="text-center">P 4 000.00</td>
                                                </tr>
                                            </tbody> -->
											
											<tbody>
                                                <?php
												
													$query="SELECT ci.cavasItemID,CONCAT(rb.name, ' ',rac.name) as `itemName`,ci.quantity,am.itemSpecification,ci.description,s.name as `supplierName`,rs.description as `itemStatus`,cid.price,(ci.quantity*cid.price) as `totalPrice`,cid.supplier_supplierID as `supplierID` FROM thesis.canvasitemdetails cid
															join supplier s on cid.supplier_supplierID=s.supplierID
                                                            join ref_status rs on cid.status=rs.statusID
                                                            join canvasitem ci on cid.cavasItemID=ci.cavasItemID
															join assetmodel am on ci.assetModel=am.assetModelID
															join ref_brand rb on am.brand=rb.brandID
															join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID 
															where ci.canvasID='{$canvasID}'";
													$result=mysqli_query($dbc,$query);
													while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
														if($row['itemStatus']=='Approved'){
															echo "<tr><td><input type='checkbox' checked disabled></td>";
														}
														else{
															echo "<tr><td><input type='checkbox' disabled></td>";
														}
														echo "<td>
															<h4>{$row['itemName']}</h4>
															<p>{$row['description']}</p>
															</td>
															<td class='text-center'>{$row['itemSpecification']}</td>
															<td class='text-center'>{$row['quantity']}</td>
															<td class='text-center'>{$row['supplierName']}</td>
															<td class='text-center'>P {$row['price']}</td>
															<td class='text-center'>P {$row['totalPrice']}</td>";
													}
												
												
												
												
												?>
                                            </tbody>
											
                                        </table>
                                        <div class="text-center invoice-btn">
                                            
                                            
                                            
                                            
                                            
<!--                                            START NA NG MODAL DITO-->
                                            <a href="procurement_restart_canvas.php?canvasID=<?php echo $canvasID; ?>" class="btn btn-success btn-lg" ><i class="fa fa-check"></i> Start Canvas </a>

                                            
                                            
                                            
                                            <a href="procurement_view_canvas.php" class="btn btn-danger btn-lg"><i class="fa fa-times"></i> Cancel </a>
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
    <script>
        $(":input").bind('keyup change click', function(e) {
            if ($(this).val() < 0) {
                $(this).val('')
            }
        });
    </script>
</body>

</html>
