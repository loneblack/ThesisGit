<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	date_default_timezone_set('Asia/Manila');
    $userID = $_SESSION['userID'];
	
	if(isset($_POST['dispose'])){
		$CurDate = date("Y-m-d");
		$message = "Form submitted!";
        if(!empty($_POST['markSalvage'])){
            
            $queryForDon1="INSERT INTO salvage (userID, ref_status_statusID, dateCreated) VALUES ({$userID}, 1, '{$CurDate}');";
            $resultForDon1=mysqli_query($dbc,$queryForDon1);
            
            $query  = "SELECT MAX(id) AS `lastID` FROM salvage;";
            $result = mysqli_query($dbc,$query);
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			
			//INSERT TO NOTIFICATIONS TABLE
			$sqlNotif = "INSERT INTO `thesis`.`notifications` (`isRead`, `salvage_id`) VALUES (false, '{$row['lastID']}');";
			$resultNotif = mysqli_query($dbc, $sqlNotif);
            
            $salvagee=$_POST['markSalvage'];
            foreach($salvagee as $salvageee){
                $queryForDon="INSERT INTO salvage_details (salvageID, asset_assetID) VALUES ({$row['lastID']}, {$salvageee});";
                $resultForDon=mysqli_query($dbc,$queryForDon);
                
                $queryForDo1n="UPDATE `thesis`.`asset` SET `assetStatus`='8' WHERE `assetID`='{$salvageee}'";
			    $resultForDo1n=mysqli_query($dbc,$queryForDo1n);
				
				//INSERT TO ASSET AUDIT
				$queryAssAud="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `assetStatus`) VALUES ('{$_SESSION['userID']}', now(), '{$salvageee}', '8');";
				$resultAssAud=mysqli_query($dbc,$queryAssAud);
            }
            $message = "Form submitted!";
            $_SESSION['submitMessage'] = $message; 
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
                
                <?php
                    if (isset($_SESSION['submitMessage'])){

                        echo "<div class='alert alert-success'>
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
                                        <form method="post" id="formSend" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                            <header class="panel-heading">
                                                Assign Service Unit
                                                <span class="tools pull-right">
                                                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                                                </span>
                                            </header>
                                            <div class="panel-body">
                                                <div class="adv-table">
                                                    
                                                    <table class="display table table-bordered table-striped" id="dynamic-table">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Property Code</th>
                                                                <th>Asset Category</th>
                                                                <th>Brand</th>
                                                                <th>Model</th>
                                                                <th>Specifications</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
															//GET For Disposed ASSET 
															$queryAsset="SELECT a.assetID, rac.name, a.propertyCode, ras.description  FROM asset a 
                                                                        JOIN assetmodel am ON a.assetmodel = am.assetmodelID 
                                                                        JOIN ref_assetstatus ras ON a.assetStatus = ras.id
                                                                        JOIN ref_assetcategory rac ON am.assetCategory = rac.assetCategoryID 
                                                                        WHERE a.assetStatus = 10 AND (rac.assetCategoryID = 13 OR rac.assetCategoryID = 40 OR rac.assetCategoryID = 46);";
															$resultAsset=mysqli_query($dbc,$queryAsset);
															while($rowAsset=mysqli_fetch_array($resultAsset,MYSQLI_ASSOC)){
																echo "<tr class='gradeX'>
																	<td style='width:7px; text-align:center'><input type='checkbox' class='form-check-input' name='markSalvage[]' id='exampleCheck1' value='{$rowAsset['assetID']}'></td>
																	<td>{$rowAsset['name']}</td>
																	<td>{$rowAsset['propertyCode']}</td>
																	<td><label class='label label-danger'>{$rowAsset['description']}</label></td>
																	
																</tr>";
															}
														
														
														
														
														
														?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div style="padding-left:10px; padding-bottom:10px">
                                                <button type="submit" name="dispose" class="btn btn-success">Submit</button>
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