<!DOCTYPE html>
<?php
	session_start();
	$departmentID=$_GET['id'];
	require_once('db/mysql_connect.php');
	
	//Get Past Data of a given ID
	$queryEditDep="SELECT * FROM thesis.department where DepartmentID='{$departmentID}'";
	$resultEditDep=mysqli_query($dbc,$queryEditDep);
	$rowEditDep=mysqli_fetch_array($resultEditDep,MYSQLI_ASSOC);
	
	if (isset($_POST['submit'])){
		$message=NULL;
		
		//Check if department already exists
		//$queryDepIsEx="SELECT count(*) as `isExist` FROM thesis.department where name='{$_POST['department']}'";
		//$resultDepIsEx=mysqli_query($dbc,$queryDepIsEx);
		//$rowDepIsEx=mysqli_fetch_array($resultDepIsEx,MYSQLI_ASSOC);
		
		//$department=null;
		
		//if($rowDepIsEx['isExist']=='0'){
			$department=$_POST['department'];
		//}
		//else{
			//$message.="Department already exists. ";
		//}
		
		$rooms=$_POST['rooms'];
		
		if(!isset($message)){
			$queryDep="UPDATE `thesis`.`department` SET `name`='{$department}' WHERE `DepartmentID`='{$departmentID}'";
			$resultDep=mysqli_query($dbc,$queryDep);
			
			//Delete all rooms for a given deptID
			$queryDelDepRooms="Delete FROM thesis.departmentownsroom where DepartmentID='{$departmentID}'";
			$resultDelDepRooms=mysqli_query($dbc,$queryDelDepRooms);
			
			foreach($rooms as $room){
				//Get BuildingID
				$queryBuildID="SELECT * FROM thesis.floorandroom where FloorAndRoomID='{$room}'";
				$resultBuildID=mysqli_query($dbc,$queryBuildID);
				$rowBuildID=mysqli_fetch_array($resultBuildID,MYSQLI_ASSOC);
				
				$queryRoom="INSERT INTO `thesis`.`departmentownsroom` (`BuildingID`, `FloorAndRoomID`, `DepartmentID`) VALUES ('{$rowBuildID['BuildingID']}', '{$room}', '{$departmentID}');";
				$resultRoom=mysqli_query($dbc,$queryRoom);
			}
			$_SESSION['submitMessage'] = "Success! The department has been edited successfully.";
		}
		else{
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

    <link rel="stylesheet" href="css/bootstrap-switch.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-timepicker/compiled/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datetimepicker/css/datetimepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery-multi-select/css/multi-select.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery-tags-input/jquery.tagsinput.css" />

    <link rel="stylesheet" type="text/css" href="js/select2/select2.css" />

    <!-- Custom styles for this template -->
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
        <?php include 'admin_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->
				<?php
					if(isset($_SESSION['submitMessage'])&&$_SESSION['submitMessage']!="Success! The department has been edited successfully."){
						echo "<div class='alert alert-danger'>
                                {$_SESSION['submitMessage']}
							  </div>";
                        unset($_SESSION['submitMessage']);
					}
					elseif (isset($_SESSION['submitMessage'])){
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
                                            Edit Department
                                        </header>
                                        <div class="panel-body">
                                            <div class="form">
                                                <form class="cmxform form-horizontal " id="signupForm" method="post" action="<?php echo $_SERVER['PHP_SELF']."?id=".$departmentID; ?>">

                                                    <div class="form-group ">
                                                        <label class="control-label col-lg-3">Department Name</label>
                                                        <div class="col-lg-6">
                                                            <input class=" form-control" id="departmentname" name="department" type="text" value="<?php echo $rowEditDep['name']; ?>" required />
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-lg-3">Rooms</label>
                                                        <div class="col-lg-6">
                                                            <select multiple name="rooms[]" id="e9" style="width:505px" class="populate" required>
                                                                <?php
																	//Get Building
																	$queryBuild="SELECT * FROM thesis.building";
																	$resultBuild=mysqli_query($dbc,$queryBuild);
																	while($rowBuild=mysqli_fetch_array($resultBuild,MYSQLI_ASSOC)){
																		echo "<optgroup label='{$rowBuild['name']}'>";
																		
																		//Get Rooms of a Building
																		$queryRoom="SELECT * FROM thesis.floorandroom where BuildingID='{$rowBuild['BuildingID']}'";
																		$resultRoom=mysqli_query($dbc,$queryRoom);
																		while($rowRoom=mysqli_fetch_array($resultRoom,MYSQLI_ASSOC)){
																			
																			//Check if option is already selected
																			$queryRoomSel="SELECT Count(*) as `isExist` FROM thesis.departmentownsroom where DepartmentID='{$departmentID}' and FloorAndRoomID='{$rowRoom['FloorAndRoomID']}'";
																			$resultRoomSel=mysqli_query($dbc,$queryRoomSel);
																			$rowRoomSel=mysqli_fetch_array($resultRoomSel,MYSQLI_ASSOC);
																			
																			if($rowRoomSel['isExist']==1){
																				echo "<option selected value='{$rowRoom['FloorAndRoomID']}'>{$rowRoom['floorRoom']}</option>";
																			}
																			else{
																				echo "<option value='{$rowRoom['FloorAndRoomID']}'>{$rowRoom['floorRoom']}</option>";
																			}
																			
																		}
																		echo "</optgroup>";
																		
																	}															
																?>
																<!--<optgroup label="Andrew">
                                                                    <option value="1">A1001</option>
                                                                    <option value="2">A1010 (Faculty Room)</option>
                                                                </optgroup>
                                                                <optgroup label="Gokongwei">
                                                                    <option value="3">G101</option>
                                                                    <option value="4">G201</option>
                                                                    <option value="5">G301</option>
                                                                    <option value="6">G401</option>
                                                                </optgroup>-->
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-lg-offset-2 col-lg-10">
                                                            <button type="submit" name="submit" class="btn btn-success">Submit</button>
                                                            <button class="btn btn-default"  onclick="window.history.back();" type="button">Cancel</button>
                                                        </div>
                                                    </div>
                                                </form>
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

    <!-- WAG GALAWIN PLS LANG -->

    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script src="js/jquery-ui-1.9.2.custom.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/easypiechart/jquery.easypiechart.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>

    <script src="js/bootstrap-switch.js"></script>

    <script type="text/javascript" src="js/fuelux/js/spinner.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-fileupload/bootstrap-fileupload.js"></script>
    <script type="text/javascript" src="js/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
    <script type="text/javascript" src="js/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
    <script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="js/bootstrap-daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript" src="js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
    <script type="text/javascript" src="js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
    <script type="text/javascript" src="js/jquery-multi-select/js/jquery.multi-select.js"></script>
    <script type="text/javascript" src="js/jquery-multi-select/js/jquery.quicksearch.js"></script>

    <script type="text/javascript" src="js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>

    <script src="js/jquery-tags-input/jquery.tagsinput.js"></script>

    <script src="js/select2/select2.js"></script>
    <script src="js/select-init.js"></script>


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

    <script src="js/toggle-init.js"></script>

    <script src="js/advanced-form.js"></script>
    <!--Easy Pie Chart-->
    <script src="js/easypiechart/jquery.easypiechart.js"></script>
    <!--Sparkline Chart-->
    <script src="js/sparkline/jquery.sparkline.js"></script>
    <!--jQuery Flot Chart-->
    <script src="js/flot-chart/jquery.flot.js"></script>
    <script src="js/flot-chart/jquery.flot.tooltip.min.js"></script>
    <script src="js/flot-chart/jquery.flot.resize.js"></script>
    <script src="js/flot-chart/jquery.flot.pie.resize.js"></script>

</body>

</html>