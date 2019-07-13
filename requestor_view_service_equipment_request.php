<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require_once("db/mysql_connect.php");

$id = $_GET['id'];

$sql = "SELECT *, o.Name AS 'office', d.name AS 'department', z.name AS 'organization', b.name AS 'building' 
        FROM thesis.request_borrow r 
        JOIN ref_status s ON r.statusID = s.statusID 
        LEFT JOIN offices o ON r.officeID = o.officeID 
        LEFT JOIN department d ON r.DepartmentID = d.DepartmentID
        LEFT JOIN organization z ON r.organizationID = z.id
        JOIN building b ON r.BuildingID = b.BuildingID 
        JOIN floorandroom f ON r.FloorAndRoomID = f.FloorAndRoomID 
        WHERE borrowID = {$id};";

$result = mysqli_query($dbc, $sql);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

        $office = $row['office'];
        $department = $row['department'];
        $organization = $row['organization'];
        $startDate = $row['startDate'];
        $endDate = $row['endDate'];
        $purpose = $row['purpose'];
        $building = $row['building'];
        $floorRoom = $row['floorRoom'];
        $personrepresentativeID = $row['personrepresentativeID'];
        $personrepresentative = $row['personrepresentative'];

    }

$sql = "SELECT * FROM thesis.borrow_details d JOIN ref_assetcategory c ON d.assetCategoryID = c.assetCategoryID WHERE borrowID = {$id};";
$result = mysqli_query($dbc, $sql);

$count = 0;

$requestedQuantity = array();
$requestedCategory = array();
$itemSpecs = array();

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

        array_push($requestedQuantity, $row['quantity']);
        array_push($requestedCategory, $row['name']);
		array_push($itemSpecs, $row['purpose']);
		
        $count++;

    }
?>
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
        <?php include 'requestor_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        Service Equipment Request
                                    </header>
                                    <div class="panel-body">
                                        <div class="form" method="post">
                                            <form class="cmxform form-horizontal " id="signupForm" method="post" action="requestor_service_equipment_request_DB.php">
                                                <!--<div class="form-group ">
                                                    <h5 class="control-label col-lg-3">Office/ Department/ School Organization</h5>
                                                    <h5 class="control-label col-lg-2"><?php //echo $office.$department.$organization; ?></h5>
                                                </div>-->
                                                <div class="form-group ">
                                                    <h5 class="control-label col-lg-3">Date & Time Needed</h5>
                                                    <h5 class="control-label col-lg-2"><?php echo $startDate; ?></h5>
                                                </div>
                                                <div class="form-group ">
                                                    <h5 class="control-label col-lg-3">End Date & Time</h5>
                                                    <h5 class="control-label col-lg-2"><?php echo$endDate ; ?></h5>
                                                </div>
                                                <div class="form-group ">
                                                    <h5 class="control-label col-lg-3">Reason For Borrowing</h5>
                                                    <h5 class="control-label col-lg-2"><?php echo $purpose; ?></h5>
                                                </div>
                                                <div class="form-group ">
                                                    <h5 class="control-label col-lg-3">Building</h5>
                                                    <h5 class="control-label col-lg-2"><?php echo $building; ?></h5>
                                                </div>
                                                <div class="form-group">
                                                    <h5 class="control-label col-lg-3">Floor & Room</h5>
                                                    <h5 class="control-label col-lg-2"><?php echo $floorRoom; ?></h5>
                                                </div>
                                                <hr>
                                                <div class="container-fluid">
                                                    <h4>Equipment to be borrowed</h4>

                                                    <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                        <thead>
                                                            <tr>
                                                                <th>Equipment</th>
                                                                <th>Quantity</th>
																<th>Item Description/ Proposed Specs</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        for ($i=0; $i < $count; $i++) { 

                                                            echo 
                                                            "<tr>
                                                                <td>
                                                                    <select class='form-control' disabled >
                                                                        <option>{$requestedCategory[$i]}</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class='form-control m-bot15' disabled required>              
                                                                        <option>{$requestedQuantity[$i]}</option>
                                                                    </select>
                                                                </td>
                                                               <td><input class='form-control' type='text' name='purpose0' id='purpose0' value='{$itemSpecs[$i]}' disabled></td>
                                                            </tr>";
                                                         }

                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>
												<hr>
												<?php
													//If status is disapproved
													$queryGetStatus="SELECT * FROM thesis.request_borrow where borrowID='{$id}'";
													$resultGetStatus = mysqli_query($dbc, $queryGetStatus);
													$rowGetStatus=mysqli_fetch_array($resultGetStatus, MYSQLI_ASSOC);
													
													if($rowGetStatus['statusID']=='6'){
														echo "<div class='container-fluid'>
																<h4>Reason For Disapproval</h4>
																<textarea class='form-control' rows='5' id='reasOfDisapprov' name='reasOfDisapprov' style='resize: none' disabled>{$rowGetStatus['reasForDisapprov']}</textarea>
															</div>";
													}

												?>
												<hr>
                                                <!--
                                                <hr>
                                                <div class="container-fluid">
                                                    <h4>Endorsement</h4>
                                                    <div class="form-group ">
                                                        <h5 class="control-label col-lg-3">Representative</h5>
                                                        <h5 class="control-label col-lg-1"><?php echo $personrepresentative; ?></h5>
                                                    </div>
                                                    <div class="form-group ">
                                                        <h5 class="control-label col-lg-3">ID Number</h5>
                                                        <h5 class="control-label col-lg-1"><?php echo $personrepresentativeID; ?></h5>
                                                    </div> -->
													
													<?php
													//Check if Request Status is Requestor Schedule Delivery Date
													
													$queryChStat = "SELECT * FROM thesis.request_borrow where borrowID='{$id}';";
																			  
													$resultChStat = mysqli_query($dbc, $queryChStat);
													$rowChStat=mysqli_fetch_array($resultChStat, MYSQLI_ASSOC);
													
													if($rowChStat['steps']=='24'||$rowChStat['steps']=='25'){
														echo "<div class='container-fluid'>
															  <h4>Schedule for Delivery</h4>
															  <table class='table table-bordered table-striped table-condensed table-hover' id='schedDel'>
																<thead>
																	<tr>
																		<td style='display: none'>ID</td>
																		<th>#</th>
																		
																		<th>Date Made</th>
																		<th>Date Needed</th>
																		<td style='display: none'>StatusID</td>
																		<th>Status</th>
																		
																		<!-- <th>Description</th> -->
																	</tr>
																</thead>
																<tbody>";
														
															//GET ALL REQUEST SCHEDULE FOR DELIVERY (REQUEST TO BORROW)
															$query = "SELECT rr.id,rb.dateCreated,rb.startDate,s.description,rr.statusID FROM thesis.requestor_receiving rr join request_borrow rb on rr.borrowID=rb.borrowID
																						  join ref_status s ON rr.statusID = s.statusID 
																						  where rr.requestID is null and rr.statusID!='3' and rb.personresponsibleID='{$_SESSION['userID']}' and rr.borrowID='{$id}'";
																		  
															$result = mysqli_query($dbc, $query);
                                                            
															while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
															{
															  
															  echo "<tr class='gradeA'>
																	<td style='display: none'>{$row['id']}</td>
																	<td>{$count}</td>
																	
																	<td>{$row['dateCreated']}</td>
																	<td>{$row['startDate']}</td>
																	<td style='display: none'>{$row['statusID']}</td>";

																if($row['statusID'] == '1'){//pending
																	echo "<td><span class='label label-warning'>{$row['description']}</span></td>";
																}
																if($row['statusID'] == '2'){//ongoing
																	echo "<td><span class='label label-info'>{$row['description']}</span></td>";
																}
																if($row['statusID'] == '3'){//completed
																	echo "<td><span class='label label-success'>{$row['description']}</span></td>";
																}
																if($row['statusID'] == '4'){//disapproved
																	echo "<td><span class='label label-danger'>{$row['description']}</span></td>";
																}

																//echo "<td></td>";
																//echo "<td>{$row['name']}</td>";
																echo "</tr>";

																  $count++;
															}
														
														
														
														echo " </tbody>
																</table>


																<br>
															</div>";
													}
												
												
												?>
													
													
                                                    <div class="form-group">
                                                        <div class="col-lg-6" style="padding-left: 30px">
                                                            <a href="requestor_dashboard.php"><button class="btn btn-default" type="button">Back</button></a>
                                                        </div>
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
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>

   
    <!-- WAG GALAWIN PLS LANG -->
	
	<script>
		function addRowHandlers() {
        var table = document.getElementById("schedDel");
        var rows = table.getElementsByTagName("tr");
        for (i = 1; i < rows.length; i++) {
            var currentRow = table.rows[i];
            var createClickHandler = function(row) {
                return function() {
					var cell1 = row.getElementsByTagName("td")[0];
                    var id = cell1.textContent;
					
					var cell2 = row.getElementsByTagName("td")[5];
                    var step = cell2.textContent;
					
					if(step == "Pending"){
						window.location.href = "requestor_scheduling_request_for_borrow.php?id=" + id;
					}
					
					
                };
            };
            currentRow.onclick = createClickHandler(currentRow);
        }
    }
    window.onload = addRowHandlers();
	
	
	</script>
	
    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>
    <script type="text/javascript">
    </script>

</body>

</html>