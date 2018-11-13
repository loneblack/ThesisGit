<!DOCTYPE html>
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
                    <div class="row">
                        <div class="col-sm-12">
                            <section class="panel">
                                <header class="panel-heading">
                                    Canvas Request
                                </header>
                                <div class="panel-body">
                                    <section id="unseen">
                                        <div class="row invoice-to">
                                            <div class="col-md-4 col-sm-4 pull-left">
                                                <h4>Sent To:</h4>
                                                <h2>Procurement</h2>
                                                <h5>Status: For Canvas</h5>
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
                                                    <th>#</th>
                                                    <th>Item Description</th>
                                                    <th class="text-center">Specifications</th>
                                                    <th class="text-center">Quantity</th>
                                                </tr>
                                            </thead>
											
                                            <!-- 
												<tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <h4>MAC Laptop</h4>
                                                        <p>The green one please.</p>
                                                    </td>
                                                    <td class="text-center">4Gb RAM</td>
                                                    <td class="text-center">4</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>
                                                        <h4>MAC Laptop</h4>
                                                        <p>The green one please.</p>
                                                    </td>
                                                    <td class="text-center">4Gb RAM</td>
                                                    <td class="text-center">4</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>
                                                        <h4>MAC Laptop</h4>
                                                        <p>The green one please.</p>
                                                    </td>
                                                    <td class="text-center">4Gb RAM</td>
                                                    <td class="text-center">4</td>
                                                </tr>
                                            </tbody> -->
											<tbody>
												<?php
													require_once('db/mysql_connect.php');
													$canvasID=$_GET['canvasID'];
													$query="SELECT ci.cavasItemID,CONCAT(rb.name, ' ',rac.name) as `itemName`,ci.quantity,am.itemSpecification,ci.description FROM thesis.canvasitem ci 
															join assetmodel am on ci.assetModel=am.assetModelID
															join ref_brand rb on am.brand=rb.brandID
															join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID 
															where ci.canvasID='{$canvasID}'";
													$result=mysqli_query($dbc,$query);
													while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
														echo "<tr>
															<td>{$row['cavasItemID']}</td>
															<td>
																<h4>{$row['itemName']}</h4>
																<p>{$row['description']}</p>
															</td>
															<td class='text-center'>{$row['itemSpecification']}</td>
															<td class='text-center'>{$row['quantity']}</td>
														</tr>";
													}
												
												
												
												
												?>
											
											
											
											</tbody>
                                        </table>
                                        <div class="text-center invoice-btn">
                                            
                                            
                                            
                                            
                                            
<!--                                            START NA NG MODAL DITO-->
                                            <a href="procurement_start_canvas.php?canvasID=<?php echo $canvasID; ?>" class="btn btn-success btn-lg" ><i class="fa fa-check"></i> Start Canvas </a>

                                            <div class="modal" id="canvasModal">
                                                <div class="modal-dialog" style="width:1000px">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Creating Canvas</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                            <table class="table table-bordered table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:50px;">Quantity</th>
                                                                        <th>Item</th>
                                                                        <th>Specification</th>
                                                                        <th>Supplier</th>
                                                                        <th>Unit Price in Php</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="width:50px;">5</td>
                                                                        <td>MAC Laptop</td>
                                                                        <td>IPAD</td>
                                                                        <td>
                                                                            <select class="form-control" id="exampleFormControlSelect1" required>
                                                                                <option>Select Supplier</option>
                                                                                <option>ABC Corp.</option>
                                                                                <option>Philippine Sports Commission</option>
                                                                                <option>CDR-King</option>
                                                                                <option>Huawei</option>
                                                                                <option>Samsung</option>
                                                                            </select>
                                                                        </td>
                                                                        <td><input type="number" class="form-control" min="0.00" required></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:50px;">5</td>
                                                                        <td>Windows</td>
                                                                        <td>Windows 10</td>
                                                                        <td>
                                                                            <select class="form-control" id="exampleFormControlSelect1" required>
                                                                                <option>Select Supplier</option>
                                                                                <option>ABC Corp.</option>
                                                                                <option>Philippine Sports Commission</option>
                                                                                <option>CDR-King</option>
                                                                                <option>Huawei</option>
                                                                                <option>Samsung</option>
                                                                            </select>
                                                                        </td>
                                                                        <td><input type="number" class="form-control" min="0.00" required></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:50px;">5</td>
                                                                        <td>Desktop</td>
                                                                        <td>MAC PC</td>
                                                                        <td>
                                                                            <select class="form-control" id="exampleFormControlSelect1" required>
                                                                                <option>Select Supplier</option>
                                                                                <option>ABC Corp.</option>
                                                                                <option>Philippine Sports Commission</option>
                                                                                <option>CDR-King</option>
                                                                                <option>Huawei</option>
                                                                                <option>Samsung</option>
                                                                            </select>
                                                                        </td>
                                                                        <td><input type="number" class="form-control" min="0.00" required></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:50px;">5</td>
                                                                        <td>Projector</td>
                                                                        <td>Epson 101</td>
                                                                        <td>
                                                                            <select class="form-control" id="exampleFormControlSelect1" required>
                                                                                <option>Select Supplier</option>
                                                                                <option>ABC Corp.</option>
                                                                                <option>Philippine Sports Commission</option>
                                                                                <option>CDR-King</option>
                                                                                <option>Huawei</option>
                                                                                <option>Samsung</option>
                                                                            </select>
                                                                        </td>
                                                                        <td><input type="number" class="form-control" min="0.00" required></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-success" data-dismiss="modal">Send</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            
<!--                                            END NG MODAL-->
                                            
                                            
                                            
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