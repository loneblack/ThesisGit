<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require_once("db/mysql_connect.php");

$id = $_GET['id'];

$sql = "SELECT  b.name AS 'building', floorRoom, recipient, dateneeded, r.description
            FROM thesis.request r 
        JOIN ref_status s 
            ON r.status = s.statusID
        JOIN building b
            ON r.BuildingID = b.BuildingID
        JOIN floorandroom f
            ON  r.FloorAndRoomID = f.FloorAndRoomID
            WHERE requestID =  {$id};";
$result = mysqli_query($dbc, $sql);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

        $description = $row['description'];
        $building = $row['building'];
        $floorRoom = $row['floorRoom'];
        $recipient = $row['recipient'];
        $recipient = $row['recipient'];
        $dateneeded = $row['dateneeded'];
        $description = $row['description'];

    }

$sql = "SELECT * FROM thesis.requestdetails JOIN ref_assetcategory ON assetCategory = assetCategoryID WHERE requestID  =  {$id};";
$result = mysqli_query($dbc, $sql);

$count = 0;

$requestedQuantity = array();
$requestedCategory = array();
$requestedDescription = array();

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

        array_push($requestedQuantity, $row['quantity']);
        array_push($requestedDescription, $row['description']);
        array_push($requestedCategory, $row['name']);

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
                                        Request To Purchase An Asset
                                    </header>
                                    <div class="panel-body">
                                        <div class="form" method="post">
                                            <form class="cmxform form-horizontal " id="signupForm" method="post" action="requestor_request_for_procurement_service_material_DB.php">
                                                <?php
                                                    if (isset($_SESSION['submitMessage'])){

                                                        echo "<div class='alert alert-success'>
                                                                {$_SESSION['submitMessage']}
                                                              </div>";

                                                        unset($_SESSION['submitMessage']);
                                                    }
                                                ?>
                                                <section>
                                                    <h4>User Location Information</h4>
                                                    <div class="form-group ">
                                                        <h4 class="control-label col-lg-3">Building</h4>
                                                        <h4 class="control-label col-lg-1"><?php echo $building;?></h4>
                                                    </div>
                                                    <div class="form-group">
                                                        <h4 class="control-label col-lg-3">floor & Room</h4>
                                                        <h4 class="control-label col-lg-1"><?php echo $floorRoom;?></h4>
                                                    </div>
                                                    <div class="form-group ">
                                                       <h4 class="control-label col-lg-3">Date Needed</h4>
                                                       <h4 class="control-label col-lg-1"><?php echo $dateneeded;?></h4>
                                                    </div>
                                                </section>
                                                <hr>

                                                <section>
                                                    <h4>Request Details</h4>
                                                    <div class="form-group ">
                                                        <h4 class="control-label col-lg-3">Reason Of Request</h4>
                                                        <h4 class="control-label col-lg-1"><?php echo $description;?></h4>
                                                    </div>
                                                </section>

                                                <hr>

                                                <section>
                                                    <h4>Requested Services/Materials</h4>
                                                    <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                        <thead>
                                                            <tr>
                                                                <th>Quantity</th>
                                                                <th>Category</th>
                                                                <th>Description</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            for ($i=0; $i < $count; $i++) { 
                                                                echo
                                                                    '<tr>
                                                                        <td>
                                                                            <div class="col-lg-12">
                                                                                <input class="form-control" type="number" value="'. $requestedQuantity[$i].'" disabled />
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <div class="col-lg-12">
                                                                                <select class="form-control"  disabled>
                                                                                    <option value ="">'.$requestedCategory[$i].'</option>
                                                                                </select>
                                                                            </div>
                                                                        </td>

                                                                        <td style="padding-top:5px; padding-bottom:5px">
                                                                            <div class="col-lg-12">
                                                                                <input class="form-control" type="text" value="'.$requestedDescription[$i].'" disabled/>
                                                                            </div>
                                                                        </td>
                                                                    </tr>';
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>


                                                    <br>
                                                </section>
												<?php
													//Check if Request Status is Requestor Schedule Delivery Date
													
													$queryChStat = "SELECT * FROM thesis.request where requestID='{$id}';";
																			  
													$resultChStat = mysqli_query($dbc, $queryChStat);
													$rowChStat=mysqli_fetch_array($resultChStat, MYSQLI_ASSOC);
													
													if($rowChStat['step']=='24'||$rowChStat['step']=='25'){
														echo "<section>
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
														
															//GET ALL REQUEST SCHEDULE FOR DELIVERY (REQUEST TO PURCHASE AN ASSET)
															$query = "SELECT rr.id,r.date,r.dateNeeded,s.description,rr.statusID FROM thesis.requestor_receiving rr join request r on rr.requestID=r.requestID
																							  join ref_status s ON rr.statusID = s.statusID
																							  where rr.borrowID is null and rr.statusID!='3' and r.UserID='{$_SESSION['userID']}' and rr.requestID='{$id}'";
																			  
															$result = mysqli_query($dbc, $query);
                                                            
															while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
															{
															  
															  echo "<tr class='gradeA'>
																	<td style='display: none'>{$row['id']}</td>
																	<td>{$count}</td>
																	
																	<td>{$row['date']}</td>
																	<td>{$row['dateNeeded']}</td>
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
															</section>";
													}
												
												
												?>
                                                <div class="form-group">
                                                    <div class="col-lg-offset-3 col-lg-6">
                                                        <a href="requestor_dashboard.php"><button class="btn btn-default" type="button">Back</button></a>
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
						window.location.href = "requestor_scheduling_request_for_procurement_service_material.php?id=" + id;
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