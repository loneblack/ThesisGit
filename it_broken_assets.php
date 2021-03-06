<!DOCTYPE html>
<?php 
	session_start();
	require_once('db/mysql_connect.php');
	$_SESSION['forReplenish']=array();
	if(isset($_POST['replenish'])){
		
		if(!empty($_POST['forReplenish'])){
			foreach($_POST['forReplenish'] as $forReplenish){
				array_push($_SESSION['forReplenish'],$forReplenish);
			}
			header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/it_replenish.php");
			
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
                                            Broken Assets With Valid Warranty

                                        </header>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <section class="panel">
                                                        <div class="panel-body">
                                                        <form method="post">
                                                                <div class="adv-table">
                                                                    <table class="display table table-bordered table-striped" id="dynamic-table">
                                                                        <thead>
                                                                            <tr>
																				<th style='display: none'></th>
                                                                                <th></th>
                                                                                <th>Property Code</th>
                                                                                <th>Asset Category</th>
                                                                                <th>Brand</th>
                                                                                <th>Model</th>
                                                                                <th>Expiration Date</th>
                                                                                <th>Supplier</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
																			<?php
																				$queryInv="SELECT i.assetCategoryID,rac.name as `assetCat`,i.floorLevel,i.ceilingLevel, count(IF(a.assetStatus = 1, a.assetID, null)) as `stockOnHand`,count(IF(a.assetStatus = 2, a.assetID, null)) as `borrowed`, count(IF(a.assetStatus = 2 or a.assetStatus = 1, a.assetID, null)) as `totalQty` FROM thesis.inventory i left join ref_assetcategory rac on i.assetCategoryID=rac.assetCategoryID
																							 left join assetmodel am on i.assetCategoryID=am.assetCategory
																							 left join asset a on am.assetModelID=a.assetModel
																							 group by i.assetCategoryID";
																				$resultInv=mysqli_query($dbc, $queryInv);
																				while($rowInv=mysqli_fetch_array($resultInv, MYSQLI_ASSOC)){
																					echo "<tr>
																						<td style='display: none'>{$rowInv['assetCategoryID']}</td>
																						<td style='text-align:center'><input type='checkbox' name='forReplenish[]' value='{$rowInv['assetCategoryID']}' ></td>
																						<td>{$rowInv['assetCat']}</td>
																						<td>{$rowInv['floorLevel']}</td>
																						<td>{$rowInv['ceilingLevel']}</td>
																						<td>{$rowInv['stockOnHand']}</td>
																						<td>{$rowInv['borrowed']}</td>
																						<td>{$rowInv['totalQty']}</td>
																					</tr>";
																				}
																			?>
                                                                            <!-- <tr>
                                                                                <td style="text-align:center"><input type="checkbox"></td>
                                                                                <td>Computer</td>
                                                                                <td>5</td>
                                                                                <td>50</td>
                                                                                <td>23</td>
                                                                                <td>20</td>
                                                                                <td>43</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align:center"><input type="checkbox"></td>
                                                                                <td>Laptop</td>
                                                                                <td>6</td>
                                                                                <td>
                                                                                    <font color="orange">10</font>
                                                                                </td>
                                                                                <td>24</td>
                                                                                <td>21</td>
                                                                                <td>44</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align:center"><input type="checkbox"></td>
                                                                                <td>VGA</td>
                                                                                <td>6</td>
                                                                                <td>
                                                                                    <font color="red">6</font>
                                                                                </td>
                                                                                <td>24</td>
                                                                                <td>21</td>
                                                                                <td>44</td>
                                                                            </tr> -->
                                                                        </tbody>
                                                                    </table>

                                                                </div>
                                                           
                                                        </div>
                                                        <button type="submit" name="replenish" class="btn btn-success">Send</button>
														</form>
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
                        window.location.href = "it_inventory_specific.php?id=" + idx;

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