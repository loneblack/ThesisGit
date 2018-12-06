<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	date_default_timezone_set('Asia/Manila');
	
	if(isset($_POST['dispose'])){
		$CurDate = date("Y-m-d");
		$dateTimestamp1 = strtotime($CurDate);
		$dateTimestamp2 = strtotime($_SESSION['dateDisposal']);
		$message = "Form submitted!";
		
		//if($dateTimestamp1==$dateTimestamp2){
			if(!empty($_POST['forDis'])){
				//Update For Disposed asset status
				$forDisposal=$_POST['forDis'];
				foreach($forDisposal as $forDis){
					$queryForDisp="UPDATE `thesis`.`asset` SET `assetStatus`='7' WHERE `assetID`='{$forDis}';";
					$resultForDisp=mysqli_query($dbc,$queryForDisp);
				}
							
				$_SESSION['submitMessage'] = $message; 
			}
			else{
				$message = "There are no assets selected to be disposed";
				$_SESSION['submitMessage'] = $message;
			}
		//}
		//else{
			//$message = "It is still not on disposal date!";
			//$_SESSION['submitMessage'] = $message;
		//}
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
    <link rel="stylesheet" href="js/morris-chart/morris.css">
    <!--dynamic table-->
    <link href="js/advanced-datatable/css/demo_page.css" rel="stylesheet" />
    <link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/data-tables/DT_bootstrap.css" />

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
                    if (isset($_SESSION['submitMessage']) && $_SESSION['submitMessage']=="Form submitted!"){

                        echo "<div class='alert alert-success'>
                                {$_SESSION['submitMessage']}
							  </div>";
                        unset($_SESSION['submitMessage']);
                    }
					elseif(isset($_SESSION['submitMessage'])){
						 echo "<div class='alert alert-danger'>
                                {$_SESSION['submitMessage']}
							  </div>";
						 unset($_SESSION['submitMessage']);
					}
				?>
                <div class="col-sm-12">
                    <div class="col-sm-12">
                        
                        <div class="row">


                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="panel">
									<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <header class="panel-heading">
                                            Disposal List
                                            <span class="tools pull-right">
                                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                            </span>
                                        </header>
                                        <div class="panel-body">
                                            <div class="adv-table">
                                                <h3>Next Disposal Date is On: <?php echo $_SESSION['dateDisposal']; ?></h3>
                                                <table class="display table table-bordered table-striped" id="dynamic-table">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Item</th>
                                                            <th>Property Code</th>
                                                            <th>Model</th>
                                                            <th class="hidden-phone">Comments</th>
                                                            <th class="hidden-phone">Brand</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
														<?php
															//GET For Disposed ASSET 
															$queryAsset="SELECT a.assetID,rac.name as `assetCat`,rb.name as `brandName`,am.description as `assetModel`,ras.description as `assetStat`,a.propertyCode FROM thesis.asset a join assetmodel am on a.assetModel=am.assetModelID
																		  join ref_assetstatus ras on a.assetStatus=ras.id
																		  join ref_brand rb on am.brand=rb.brandID
																		  join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID where a.assetStatus='11'";
															$resultAsset=mysqli_query($dbc,$queryAsset);
															while($rowAsset=mysqli_fetch_array($resultAsset,MYSQLI_ASSOC)){
																echo "<tr class='gradeX'>
																	<td style='width:7px; text-align:center'><input type='checkbox' class='form-check-input' name='forDis[]' id='exampleCheck1' value='{$rowAsset['assetID']}'></td>
																	<td>{$rowAsset['assetCat']}</td>
																	<td>{$rowAsset['propertyCode']}</td>
																	<td>{$rowAsset['assetModel']}</td>
																	<td><label class='label label-danger'>{$rowAsset['assetStat']}</label></td>
																	<td>{$rowAsset['brandName']}</td>
																</tr>";
															}
														
														
														
														
														
														?>
                                                        <!-- <tr class="gradeX">
                                                            <td style="width:7px; text-align:center"><input type="checkbox" class="form-check-input" id="exampleCheck1"></td>
                                                            <td>Checked In</td>
                                                            <td>Win 95+</td>
                                                            <td>Mr. Allan Peter</td>
                                                            <td>Registered to PC</td>
                                                            <td>Yes</td>
                                                        </tr> -->
                                                        
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th></th>
                                                            <th>Item</th>
                                                            <th>Property Code</th>
                                                            <th>Model</th>
                                                            <th class="hidden-phone">Comments</th>
                                                            <th class="hidden-phone">Brand</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div style="padding-left:10px; padding-bottom:10px">
                                            <button type="submit" name="dispose" onclick="Confirm()" class="btn btn-info">Dispose</button>
											<button type="button" onclick="window.history.back()" class="btn btn-secondary">Back</button>
                                        </div>
										</form>
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

    <!-- WAG GALAWIN PLS LANG -->

    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>

    <!--dynamic table-->
    <script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

    <script src="js/morris-chart/morris.js"></script>
    <script src="js/morris-chart/raphael-min.js"></script>
    <script src="js/morris.init.js"></script>

    <!--dynamic table initialization -->
    <script src="js/dynamic_table_init.js"></script>

</body>

</html>