<!DOCTYPE html>
<?php
	require_once('db/mysql_connect.php');
	$procID=$_GET['procID'];
	
	$queryz="SELECT rs.description as `statusDesc`,p.date,s.name as `supplierName`,s.address FROM thesis.procurement p join supplier s on p.supplierID=s.supplierID
								   join ref_status rs on p.status=rs.statusID where p.procurementID='{$procID}'";
	$resultz=mysqli_query($dbc,$queryz);
	$rowz=mysqli_fetch_array($resultz,MYSQLI_ASSOC);
	
	
	if (isset($_POST['submit'])){
		$isEmpty=true;
		for($i=0;$i<sizeof($_POST['comment']);$i++){
			if(!empty($_POST['comment'][$i])){
				$isEmpty=false;
			}
		}
		
		if($isEmpty){
			$querya="UPDATE `thesis`.`procurement` SET `status`='3' WHERE `procurementID`='{$procID}'";
			$resulta=mysqli_query($dbc,$querya);
			
			//echo "<script>alert('empty');</script>";
		}
		else{
			$comment=$_POST['comment'];
			$assetCategoryIDArr=$_POST['assetCategoryID'];
			$assetModelIDArr=$_POST['assetModelID'];
			
			//UPDATE STATUS
			$querya="UPDATE `thesis`.`procurement` SET `status`='4' WHERE `procurementID`='{$procID}'";
			$resulta=mysqli_query($dbc,$querya);
			
			
			$mi = new MultipleIterator();
			$mi->attachIterator(new ArrayIterator($comment));
			$mi->attachIterator(new ArrayIterator($assetCategoryIDArr));
			$mi->attachIterator(new ArrayIterator($assetModelIDArr));
			
			foreach ($mi as $value) {
				list($comment, $assetCategoryIDArr, $assetModelIDArr) = $value;
				$queryb="UPDATE `thesis`.`procurementdetails` SET `comment`='{$comment}' WHERE `assetCategoryID`='{$assetCategoryIDArr}' and `procurementID`='{$procID}' and `assetModelID`='{$assetModelIDArr}'";
				$resultb=mysqli_query($dbc,$queryb);
				
			}
			
			
			
			//echo "<script>alert('not empty');</script>";
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
														<label class="btn btn-success"><?php echo $rowz['statusDesc']; ?></label>
														
													</div>
                                                </div>
                                                <br>


                                            </div>
                                        </div>
                                        
                                        <h5>*Note: If Items are complete, please leave the comment field blank. If items are incomplete, just place the quantity received in the comment box.</h5>
                                        <form method="post">
										<table class="table table-invoice">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Item Description</th>
                                                    <th class="text-center">Unit Cost</th>
                                                    <th class="text-center">Quantity</th>
                                                    <th class="text-center">Total</th>
                                                    <th>Number of Missing Items</th>

                                                </tr>
                                            </thead>
                                            <tbody>
												
												<?php
													
													$query="SELECT pd.assetModelID as `assetModelID`,CONCAT(rb.name, ' ',rac.name) as `itemName`,pd.cost,pd.quantity,(pd.cost*pd.quantity) as `totalCost`,am.description as `assetModelDesc`,am.assetCategory as `assetCategory` FROM thesis.procurementdetails pd join assetmodel am on pd.assetModelID=am.assetModelID join ref_brand rb on am.brand=rb.brandID
															join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID where pd.procurementID='{$procID}'";
													$result=mysqli_query($dbc,$query);
													while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
														echo "
															<tr>
															<input type='hidden' name='assetCategoryID[]' value='{$row['assetCategory']}'>
															<input type='hidden' name='assetModelID[]' value='{$row['assetModelID']}'>
															<td>{$row['assetModelID']}</td>
															<td>
																<h4>{$row['itemName']}</h4>
																<p>{$row['assetModelDesc']}</p>
															</td>
															<td class='text-center'>{$row['cost']}</td>
															<td class='text-center'>{$row['quantity']}</td>
															<td class='text-center'>P {$row['totalCost']}</td>
															<td>
																<div class='form-group'>
																	<div class='col-sm-12'>
																		<input type='number' min='0' class='form-control' name='comment[]'>
																	</div>
																</div>
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