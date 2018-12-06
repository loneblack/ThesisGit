<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	
	if(isset($_POST['dispose'])){
		//GET DATE FROM SCHOOLYEAR TABLE
		$CurDate = date("Y-m-d"); //Current date.
		
		$check = false;
		//$dateNeeded='2050-12-05 15:09:24';
		$dateNeeded=null;
		
		$message = "Form submitted!";
		
		$querySY="SELECT * FROM thesis.schoolyear order by SchoolYearID asc";
		$resultSY=mysqli_query($dbc,$querySY);
		while($rowSY=mysqli_fetch_array($resultSY, MYSQLI_ASSOC)){
			if($CurDate<$rowSY['Term1End']&&$check==false){
				$dateNeeded=$rowSY['Term1End'];
				$check = true;
			}
			elseif($CurDate<$rowSY['Term2End']&&$check==false){
				$dateNeeded=$rowSY['Term2End'];
				$check = true;
			}
			elseif($CurDate<$rowSY['Term3End']&&$check==false){
				$dateNeeded=$rowSY['Term3End'];
				$check = true;
			}
		}
		
		if(!empty($_POST['forMain'])){
			//INSERT TO SERVICE TABLE
			$queryServ = "INSERT INTO `thesis`.`service` (`summary`, `details`, `dateNeed`, `endDate`, `dateReceived`, `UserID`, `serviceType`, `others`, `status`, `steps`)
											VALUES ('For Maintenance', 'For Maintenance', '{$dateNeeded}', '{$dateNeeded}', '{$CurDate}', '{$_SESSION['userID']}', '28', '', '1', '14');";//status is set to 1 for pending status

			$resultServ = mysqli_query($dbc, $queryServ);
			
			//GET LATEST SERVICE
			$queryLatServ = "SELECT * FROM thesis.service order by id desc limit 1";
			$resultLatServ = mysqli_query($dbc, $queryLatServ);
			$rowLatServ = mysqli_fetch_array($resultLatServ, MYSQLI_ASSOC);
			
			//INSERT TO SERVICEDETAILS TABLE
			$forMaintenance=$_POST['forMain'];
			foreach($forMaintenance as $forMain){
				
				//GET ASSETS FROM ASSETASSIGNMENT BASED ON GIVEN BUILDING
				$queryBuildAss="SELECT * FROM thesis.assetassignment where BuildingID='{$forMain}'";
				$resultBuildAss=mysqli_query($dbc,$queryBuildAss);
				
				while($rowBuildAss=mysqli_fetch_array($resultBuildAss, MYSQLI_ASSOC)){
					$queryForMain="INSERT INTO `thesis`.`servicedetails` (`serviceID`, `asset`) VALUES ('{$rowLatServ['id']}', '{$rowBuildAss['assetID']}');";
					$resultForMain=mysqli_query($dbc,$queryForMain);
				
					//set asset status to for maintenance(17)
					$query2 = "UPDATE `thesis`.`asset` SET `assetStatus` = '17' WHERE (`assetID` = '{$rowBuildAss['assetID']}');";
					$resulted2 = mysqli_query($dbc, $query2);
				}
			}
									
			$_SESSION['submitMessage'] = $message; 
		}
		else{
			$message = "There are no buildings selected to be maintenance";
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
                                            Maintenance List
                                            <span class="tools pull-right">
                                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                            </span>
                                        </header>
                                        <div class="panel-body">
                                            <div class="adv-table">
                                                <h3>Maintenance Date is On: <?php echo $_SESSION['dateMaintenance']; ?></h3>
                                                <h5><b>** Check Buildings to Perform Maintenance then click Confirm button</b></h5>
                                                <table class="display table table-bordered table-striped" id="dynamic-table">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Building</th>
                                                            <th>Number of Assets</th>
                                                        </tr>
                                                    </thead>
													<tbody>
                                                        <?php
															//GET For Maintenance Data
															$queryMaint="SELECT aa.BuildingID, b.name as `buildingName`, count(*) as `numAssets` FROM thesis.assetassignment aa join building b on aa.BuildingID=b.BuildingID group by aa.BuildingID";
															$resultMaint=mysqli_query($dbc,$queryMaint);
															while($rowMaint=mysqli_fetch_array($resultMaint,MYSQLI_ASSOC)){
																echo "<tr>
																	<td class='center'><input type='checkbox' name='forMain[]' value='{$rowMaint['BuildingID']}'></td>
																	<td>{$rowMaint['buildingName']}</td>
																	<td>{$rowMaint['numAssets']}</td>
																</tr>";
															}
														?>
                                                    </tbody>
													
                                                    <!-- <tbody>
                                                        <tr>
                                                            <td class="center"><input type="checkbox"></td>
                                                            <td>Gokongwei Building</td>
                                                            <td>100</td>
                                                        </tr>
                                                    </tbody> -->
                                                    <tfoot>
                                                        <tr>
                                                            <th></th>
                                                            <th>Building</th>
                                                            <th>Number of Assets</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div style="padding-left:10px; padding-bottom:10px">
                                            <button type="submit" name="dispose" class="btn btn-info">Confirm</button>
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