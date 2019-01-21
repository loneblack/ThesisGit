<!DOCTYPE html>
<?php 
	session_start();
	require_once('db/mysql_connect.php');
	$id=$_GET['id'];
	
	//Get Asset Cat Name
	$queryAssetCat="SELECT * FROM thesis.ref_assetcategory where assetCategoryID='{$id}' limit 1";
	$resultAssetCat=mysqli_query($dbc, $queryAssetCat);
	$rowAssetCat=mysqli_fetch_array($resultAssetCat, MYSQLI_ASSOC);
	
	
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
        <?php include 'it_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="panel">
                                        <header class="panel-heading">
                                            <?php
												echo $rowAssetCat['name'];
											
											?>

                                        </header>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <section class="panel">
                                                        <div class="panel-body">
                                                            <div class="adv-table">
                                                                <table class="display table table-bordered table-striped" id="dynamic-table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Property Code</th>
                                                                            <th>Brand</th>
                                                                            <th>Model</th>
                                                                            <th>Status</th>
                                                                            <th>Last Updated</th>
                                                                            <th>Location</th>
                                                                            <th>Borrower</th>
                                                                            <th>Checkout/ Checkin</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
																		<?php
																			$queryInvDet="SELECT a.assetID, a.propertyCode,rb.name as `brandName`,am.description as `modelName`,ras.description as `assetStat`,CONCAT(bldg.name,' ',far.floorRoom) AS `location`,e.name as `borrower` FROM thesis.asset a left join assetmodel am on a.assetModel=am.assetModelID
																							 left join ref_brand rb on am.brand=rb.brandID
																							 left join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																							 left join borrow_details_item bdi on a.assetID=bdi.assetID
																							 left join borrow_details bd on bdi.borrow_detailsID=bd.borrow_detailscol
																							 left join request_borrow rbw on bd.borrowID=rbw.borrowID
																							 left join floorandroom far on rbw.FloorAndRoomID=far.FloorAndRoomID
																							 left join building bldg on far.BuildingID=bldg.BuildingID
																							 left join employee e on rbw.personresponsibleID=e.employeeID
																							 left join ref_assetstatus ras on a.assetStatus=ras.id
																							 where am.assetCategory='{$id}'";
																			$resultInvDet=mysqli_query($dbc, $queryInvDet);
																			while($rowInvDet=mysqli_fetch_array($resultInvDet, MYSQLI_ASSOC)){
																				echo "<tr>
																					<td>{$rowInvDet['propertyCode']}</td>
																					<td>{$rowInvDet['brandName']}</td>
																					<td>{$rowInvDet['modelName']}</td>
																					<td>{$rowInvDet['assetStat']}</td>
																					<td></td>
																					<td>{$rowInvDet['location']}</td>
																					<td>{$rowInvDet['borrower']}</td>
																					<td class='text-center'><a href='it_checkin.php?id={$rowInvDet['assetID']}'><button class='btn btn-info'>Checkin</button></a></td>
																				</tr>";
																			}
																		?>
                                                                        <!-- <tr>
                                                                            <td>99994447327</td>
                                                                            <td>Samsung</td>
                                                                            <td>S7 Edge</td>
                                                                            <td>Checked Out</td>
                                                                            <td>12-23-2018 9:00:00 AM</td>
                                                                            <td>Gokongwei 403B</td>
                                                                            <td>Marvin Lao</td>
                                                                            <td class="text-center"><a href="it_checkin.php"><button class="btn btn-info">Checkin</button></a></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>12445447327</td>
                                                                            <td>Samsung</td>
                                                                            <td>S7 Edge</td>
                                                                            <td>In Repair</td>
                                                                            <td>12-23-2018 9:00:00 AM</td>
                                                                            <td>Default</td>
                                                                            <td></td>
                                                                            <td class="text-center"><a href="it_checkout.php"><button class="btn btn-warning" disabled>Checkout</button></a></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>39382707327</td>
                                                                            <td>Huawei</td>
                                                                            <td>Flare S2</td>
                                                                            <td>Checked Out</td>
                                                                            <td>12-23-2018 9:00:00 AM</td>
                                                                            <td>Gokongwei 403B</td>
                                                                            <td>Marvin Lao</td>
                                                                            <td class="text-center"><a href="it_checkin.php"><button class="btn btn-info">Checkin</button></a></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>12394447327</td>
                                                                            <td>Dell</td>
                                                                            <td>RTX-1480</td>
                                                                            <td>Stocked</td>
                                                                            <td>12-23-2018 9:00:00 AM</td>
                                                                            <td>Default</td>
                                                                            <td></td>
                                                                            <td class="text-center"><a href="it_checkout.php"><button class="btn btn-warning">Checkout</button></a></td>
                                                                        </tr> -->
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </section>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>
    
    <script>
		function addRowHandlers() {
			var table = document.getElementById("dynamic-table");
			var rows = table.getElementsByTagName("tr");
			for (i = 1; i < rows.length; i++) {
				var currentRow = table.rows[i];
				var createClickHandler = function(row) {
					return function() {
						var cell = row.getElementsByTagName("td")[0];
						var idx = cell.textContent;
						
                        window.location.href = "it_asset_audit.php?=";
						
					};
				};
				currentRow.ondblclick = createClickHandler(currentRow);
			}
		}
		window.onload = addRowHandlers();
	</script>

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
    
    

</body>

</html>