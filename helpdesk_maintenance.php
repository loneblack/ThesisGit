<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	
	if(isset($_POST['save'])){
		$building=$_POST['building'];
		$roomtype=$_POST['roomtype'];
		$engineer=$_POST['engineer'];
		
		$mi = new MultipleIterator();
		
		$mi->attachIterator(new ArrayIterator($building));
		$mi->attachIterator(new ArrayIterator($roomtype));
		$mi->attachIterator(new ArrayIterator($engineer));
		
		foreach($mi as $value){
			list($building, $roomtype, $engineer) = $value;
			
			//Check if an engineer assignment is exist
			$queryIsEnAssEx = "SELECT count(*) as `isExist` FROM thesis.engineer_assignment where BuildingID='{$building}' and roomtypeID='{$roomtype}'";
			$resultIsEnAssEx  = mysqli_query($dbc, $queryIsEnAssEx);
			$rowIsEnAssEx = mysqli_fetch_array($resultIsEnAssEx, MYSQLI_ASSOC);
			
			if($rowIsEnAssEx['isExist']=='0' && $engineer!='0'){
				//INSERT TO ENGINEER ASSIGNMENT
				$queryIsEnAss = "INSERT INTO `thesis`.`engineer_assignment` (`BuildingID`, `roomtypeID`, `employeeID`) VALUES ('{$building}', '{$roomtype}', '{$engineer}');";
				$resultIsEnAss  = mysqli_query($dbc, $queryIsEnAss);
			}
			elseif($rowIsEnAssEx['isExist']=='1' && $engineer!='0'){
				//UPDATE TO ENGINEER ASSIGNMENT
				$queryUpEnAss = "UPDATE `thesis`.`engineer_assignment` SET `employeeID`='{$engineer}' WHERE `BuildingID`='{$building}' and `roomtypeID`='{$roomtype}';";
				$resultUpEnAss  = mysqli_query($dbc, $queryUpEnAss);
			}
			elseif($rowIsEnAssEx['isExist']=='1' && $engineer=='0'){
				//DELETE TO ENGINEER ASSIGNMENT
				$queryDelEnAss = "DELETE FROM `thesis`.`engineer_assignment` WHERE `BuildingID`='{$building}' and `roomtypeID`='{$roomtype}';";
				$resultDelEnAss  = mysqli_query($dbc, $queryDelEnAss);
			}
		}
		$_SESSION['submitMessage'] = "Success! The maintenance team list has been updated.";
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
        <?php include 'helpdesk_navbar.php' ?>

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
                            <section class="panel">
                                <header class="panel-heading">
                                    Maintenance Team List
                                </header>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="panel">
                                            <div class="panel-body">
                                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                                    <button class="btn btn-success" type="submit" name="save">Save</button><br><br>
                                                    <div class="adv-table">
                                                        <table class="display table table-bordered table-striped" id="dynamic-table">
                                                            <thead>
                                                                <tr>
                                                                    <th style="display: none">id</th>
                                                                    <th>Building Assignment</th>
                                                                    <th>Room Type</th>
                                                                    <th>Engineer Assigned</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
																<?php
																	//GET LIST OF BUILDINGS AND ROOM TYPES TO BE ASSIGNED TO AN ENGINEER
																	$queryGetListBuil = "SELECT b.BuildingID, b.name, r.id, r.roomtype FROM building b JOIN floorandroom f ON b.BuildingID = f.BuildingID
																																					   JOIN ref_roomtype r ON f.roomtype = r.id
																																					   group by f.roomtype,b.BuildingID 
																																					   order by b.BuildingID asc";
																	$resultGetListBuil = mysqli_query($dbc, $queryGetListBuil);
																	while($rowGetListBuil = mysqli_fetch_array($resultGetListBuil, MYSQLI_ASSOC)){
																		//GET CURRENT ENGINEER OF A GIVEN BUILDING AND ROOMTYPE
																		$queryGetCurEng = "SELECT * FROM thesis.engineer_assignment where BuildingID='{$rowGetListBuil['BuildingID']}' and roomtypeID='{$rowGetListBuil['id']}'";
																		$resultGetCurEng = mysqli_query($dbc, $queryGetCurEng);
																		$rowGetCurEng = mysqli_fetch_array($resultGetCurEng, MYSQLI_ASSOC);
																		echo "<tr>
																			<input type='hidden' name='building[]' value='{$rowGetListBuil['BuildingID']}'>
																			<input type='hidden' name='roomtype[]' value='{$rowGetListBuil['id']}'>
																			<td style='display: none'></td>
																			<td>{$rowGetListBuil['name']}</td>
																			<td>{$rowGetListBuil['roomtype']}</td>
																			<td class='col-lg-5'> 
																			<select class='form-control' name='engineer[]'>
																				<option value='0'>Select Engineer</option>";
																				
																				//GET LIST OF ENGINEERS
																				$queryGetListEng = "SELECT * FROM thesis.employee e join user u on e.UserID=u.UserID where u.userType='4'";
																				$resultGetListEng = mysqli_query($dbc, $queryGetListEng);
																				while($rowGetListEng = mysqli_fetch_array($resultGetListEng, MYSQLI_ASSOC)){
																					if($rowGetCurEng['employeeID']==$rowGetListEng['employeeID']){
																						echo "<option value='{$rowGetListEng['employeeID']}' selected>{$rowGetListEng['name']}</option>";
																					}
																					else{
																						echo "<option value='{$rowGetListEng['employeeID']}'>{$rowGetListEng['name']}</option>";
																					}
																					
																				}
																			echo "
																			</select>
																			</td>
																		</tr>";
																	}
																
																
																
																
																
																?>
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </form>
                                            </div>
                                        </section>
                                    </div>
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

    <script>
       
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