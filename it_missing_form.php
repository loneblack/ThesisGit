<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	$replacementID=$_GET['id'];
	
	if(isset($_POST['submit'])){
		$replacedAsset=$_POST['replacedAsset'];
		
		//Update replacement table
		$queryUpdRepTab="UPDATE `thesis`.`replacement` SET `statusID`='2',`stepID`='9', `replacementAssetID`='{$replacedAsset}' WHERE `replacementID`='{$replacementID}'";
		$resultUpdRepTab=mysqli_query($dbc,$queryUpdRepTab);
		
		$message = "Form submitted!";
		$_SESSION['submitMessage'] = $message; 
		
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
				 <?php
                    if (isset($_SESSION['submitMessage'])){
                        echo "<div style='text-align:center' class='alert alert-success'>
								<strong><h3>{$_SESSION['submitMessage']}</h3></strong>
                            </div>";
						unset($_SESSION['submitMessage']);
                    }
                ?>
                <div class="row">
                    <div class="col-sm-12">


                        <div class="col-sm-12">
                            <section class="panel">
                                <header class="panel-heading">
                                    Replace Missing Items
                                </header>
                                <div class="panel-body">
									<form method="post" action="<?php echo $_SERVER['PHP_SELF']." ?id=".$replacementID; ?>">
                                    <section id="unseen">
                                        <h4>Items Missing</h4>
                                        <div class="adv-table">
                                            <table class="table table-bordered table-striped table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Property Code</th>
                                                        <th>Brand</th>
                                                        <th>Model</th>
                                                        <th>Specifications</th>
                                                        <th>Location</th>
                                                        <th>Comments</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
													<?php
														//GET ITEMS MISSING 
														$queryGetItMis="SELECT am.assetCategory,a.propertyCode,rb.name as `brandName`,rac.name as `assetCatName`,am.itemSpecification,am.description as `modelName`,b.name as `buildingName`,far.floorRoom,r.remarks FROM thesis.replacement r join asset a on r.lostAssetID=a.assetID
																		   join assetmodel am on a.assetModel=am.assetModelID
																		   join ref_brand rb on am.brand=rb.brandID
																		   join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																		   join floorandroom far on r.FloorAndRoomID=far.FloorAndRoomID
																		   join building b on r.BuildingID=b.BuildingID
																		   where r.replacementID='{$replacementID}'";
                                                        $resultGetItMis=mysqli_query($dbc,$queryGetItMis);
                                                        while($rowGetItMis=mysqli_fetch_array($resultGetItMis,MYSQLI_ASSOC)){
															echo "<tr>
																	  <td>{$rowGetItMis['propertyCode']}</td>
																	  <td>{$rowGetItMis['brandName']}</td>
																	  <td>{$rowGetItMis['modelName']}</td>
																	  <td>{$rowGetItMis['itemSpecification']}</td>
																	  <td>".$rowGetItMis['buildingName']." ".$rowGetItMis['floorRoom']."</td>
																	  <td>{$rowGetItMis['remarks']}</td>
																  </tr>";
														}
													?>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <h4>Items Replacing Missing Items</h4>
                                        <div class="adv-table">
                                            <table class="table table-bordered table-striped table-condensed table-hover " id="">
                                                <thead>
                                                    <tr>
														<th></th>
                                                        <th>Property Code</th>
                                                        <th>Brand</th>
                                                        <th>Model</th>
                                                        <th>Specifications</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
													<?php
														
														//GET ASSET CATEGORY
														$queryGetAssCat="SELECT * FROM thesis.replacement r join asset a on r.lostAssetID=a.assetID
																		   join assetmodel am on a.assetModel=am.assetModelID
																		   where r.replacementID='{$replacementID}'";
                                                        $resultGetAssCat=mysqli_query($dbc,$queryGetAssCat);
														$rowGetAssCat=mysqli_fetch_array($resultGetAssCat,MYSQLI_ASSOC);
														
														//GET ASSETS BASED ON THE ASSET CATEGORY OF THE LOST ASSET
														$queryGetAllAss="SELECT *,rb.name as `brandName`,am.description as `modelName`,rac.name as `assetCatName`,am.itemSpecification as `modelSpec`,ras.description as `assetStat` FROM thesis.asset a left join assetmodel am on a.assetModel=am.assetModelID
																			left join ref_brand rb on am.brand=rb.brandID
																			left join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																			left join ref_assetstatus ras on a.assetStatus=ras.id 
																			where am.assetCategory='{$rowGetAssCat['assetCategory']}' and a.assetStatus='1'";
                                                        $resultGetAllAss=mysqli_query($dbc,$queryGetAllAss);
                                                        while($rowGetAllAss=mysqli_fetch_array($resultGetAllAss,MYSQLI_ASSOC)){
															echo "<tr>
																	<td><input type='radio' name='replacedAsset' required value='{$rowGetAllAss['assetID']}'></td>
																	<td>{$rowGetAllAss['propertyCode']}</td>
																	<td>{$rowGetAllAss['brandName']}</td>
																	<td>{$rowGetAllAss['modelName']}</td>
																	<td>{$rowGetAllAss['itemSpecification']}</td>
																  </tr>";
														}	
													?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-success">Submit</button>
                                        <button class="btn btn-danger">Back</button>
                                    </section>
									</form>
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