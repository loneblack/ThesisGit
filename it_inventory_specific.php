<!DOCTYPE html>
<?php 
	session_start();
	require_once('db/mysql_connect.php');
	$id=$_GET['id'];
	
	//Get Asset Cat Name
	$queryAssetCat="SELECT * FROM thesis.ref_assetcategory where assetCategoryID='{$id}' limit 1";
	$resultAssetCat=mysqli_query($dbc, $queryAssetCat);
	$rowAssetCat=mysqli_fetch_array($resultAssetCat, MYSQLI_ASSOC);


    if(isset($_POST['submit'])){	
        
        if($_POST['fLevel'] < $_POST['cLevel']){
            $queryProp="UPDATE `thesis`.`inventory` SET `floorLevel` = '{$_POST['fLevel']}', `ceilingLevel` = '{$_POST['cLevel']}' WHERE (`InventoryID` = '{$id}');";
            $resultProp=mysqli_query($dbc,$queryProp);
            
            $_SESSION['submitMessage'] = "Success! Floor Level and Ceiling Level Updated.";
        }
        
        else{
            $_SESSION['submitMessage'] = "Failed! Floor Level Should be Less than Ceiling Level.";
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
                                                            <?php 
                                                                $queryCount="SELECT floorLevel, ceilingLevel FROM Inventory WHERE assetCategoryID = {$id};";
                                                                $resultCount=mysqli_query($dbc,$queryCount);
                                                                $rowCount=mysqli_fetch_array($resultCount,MYSQLI_ASSOC);
                                                            
                                                            ?>

                                                            <form class="form-group" method="POST" action="">

                                                                <div class="form-group">
                                                                    <label>Floor Level</label>
                                                                    <input type="number" class="form-control" id="fLevel" name= "fLevel" placeholder="Enter Floor Level" value="<?php echo "{$rowCount['floorLevel']}" ?>" step="0" required>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label>Ceiling Level</label>
                                                                    <input type="number" class="form-control" id="cLevel" name= "cLevel" placeholder="Enter Ceiling Level" value="<?php echo "{$rowCount['ceilingLevel']}" ?>" step="0" required>
                                                                </div>
                                                                
                                                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                                                <a href="it_inventory.php"><button type="button" class="btn btn-danger">Back</button></a>


                                                            </form>



                                                            <div class="adv-table">
                                                                <table class="display table table-bordered table-striped" id="dynamic-table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="hidden"></th>
                                                                            <th>Property Code</th>
                                                                            <th>Brand</th>
                                                                            <th>Model</th>
                                                                            <th>Specifications</th>
                                                                            <th>Category</th>
                                                                            <th>Status</th>
                                                                            <th>Checked Out To</th>
                                                                            <th>Building</th>
                                                                            <th>Floor and Room</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
													$query="SELECT a.assetID, a.propertyCode, rb.name AS `brand`, am.description AS `model`, am.itemSpecification, rac.name AS `category`, ras.description, e.name AS `employee`, b.name AS `building`, fr.floorRoom FROM asset a 
                                                    LEFT JOIN assetmodel am ON a.assetModel = am.assetModelID
                                                    LEFT JOIN ref_brand rb ON am.brand = rb.brandID
                                                    LEFT JOIN ref_assetcategory rac ON am.assetCategory = rac.assetCategoryID
                                                    LEFT JOIN ref_assetstatus ras ON a.assetStatus = ras.id
                                                    LEFT JOIN assetassignment aa ON a.assetID = aa.assetID
                                                    LEFT JOIN employee e ON aa.personresponsibleID = e.employeeID
                                                    LEFT JOIN building b ON aa.BuildingID = b.BuildingID
                                                    LEFT JOIN floorandroom fr ON aa.FloorAndRoomID = fr.FloorAndRoomID WHERE rac.assetCategoryID = {$id};";
													$result=mysqli_query($dbc,$query);
													
													while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
														echo "<tr>
															<td class='hidden' id='{$row['assetID']}'></td>
															<td>{$row['propertyCode']}</td>
															<td>{$row['brand']}</td>
                                                            <td>{$row['model']}</td>
                                                            <td>{$row['itemSpecification']}</td>
                                                            <td>{$row['category']}</td>
                                                            <td>{$row['description']}</td>
                                                            <td>{$row['employee']}</td>
                                                            <td>{$row['building']}</td>
                                                            <td>{$row['floorRoom']}</td>
                                                            </tr>";
													}
												
												
												
												
												?>
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