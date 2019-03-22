<!DOCTYPE html>
<?php

session_start();
require_once("db/mysql_connect.php");

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
                            
                            <section class="panel">
                                <header class="panel-heading">
                                    Scheduled Deliveries
                                </header>
                                <div class="panel-body">
                                    <div class="adv-table" id="ctable">
                                        <table class="display table table-bordered table-striped" id="dynamic-table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Delivered To</th>
													<th>Building</th>
													<th>Floor</th>
													<th>Delivery Date</th>
													<th>Delivery Status</th>
                                                </tr>
                                            </thead>

                                            <tbody>
												<?php
													//GET ALL ONGOING DELIVERY Request
													
													//ASSET REQUEST SIDE
													$queryDelReq = "SELECT rr.statusID,rr.id as `reqRecID`,e.name as `deliveredTo`,b.name as `building`,far.floorRoom,rr.deliveryDate,rs.description as `statusDesc` FROM thesis.requestor_receiving rr join user u on rr.UserID=u.UserID
																												join employee e on u.UserID=e.UserID 
																												join request r on rr.requestID=r.requestID
                                                                                                                join building b on r.BuildingID=b.BuildingID
                                                                                                                join floorandroom far on r.FloorAndRoomID=far.FloorAndRoomID
																												join ref_status rs on rr.statusID=rs.statusID
																												where rr.statusID!='1'";         
													$resultDelReq = mysqli_query($dbc, $queryDelReq);
													while($rowDelReq = mysqli_fetch_array($resultDelReq, MYSQLI_ASSOC)){
														echo "<tr class='gradeA'>
															<td style='display: none'>{$rowDelReq['reqRecID']}</td>
															<td>{$rowDelReq['reqRecID']}</td>
															<td>{$rowDelReq['deliveredTo']}</td>
															<td>{$rowDelReq['building']}</td>
															<td>{$rowDelReq['floorRoom']}</td>
															<td>{$rowDelReq['deliveryDate']}</td>";
															
															if($rowDelReq['statusID'] == '2'){//ongoing
																echo "<td><span class='label label-info'>{$rowDelReq['statusDesc']}</span></td>";
															}
															if($rowDelReq['statusID'] == '3'){//completed
																echo "<td><span class='label label-success'>{$rowDelReq['statusDesc']}</span></td>";
															}
															if($rowDelReq['statusID'] == '4'){//incompleted
																echo "<td><span class='label label-danger'>{$rowDelReq['statusDesc']}</span></td>";
															}
															echo "<td style='display: none'></td>
														</tr>";
													}
													
													//BORROW REQUEST SIDE
													$queryDelReq1 = "SELECT rr.id as `reqRecID`,e.name as `deliveredTo`,b.name as `building`,far.floorRoom,rr.deliveryDate FROM thesis.requestor_receiving rr join user u on rr.UserID=u.UserID
																												join employee e on u.UserID=e.UserID 
																												join request_borrow rb on rr.borrowID=rb.borrowID
                                                                                                                join building b on rb.BuildingID=b.BuildingID
                                                                                                                join floorandroom far on rb.FloorAndRoomID=far.FloorAndRoomID
																												where rr.statusID!='1'";         
													$resultDelReq1 = mysqli_query($dbc, $queryDelReq1);
													while($rowDelReq1 = mysqli_fetch_array($resultDelReq1, MYSQLI_ASSOC)){
														echo "<tr class='gradeA'>
															<td style='display: none'>{$rowDelReq1['reqRecID']}</td>
															<td>{$rowDelReq1['reqRecID']}</td>
															<td>{$rowDelReq1['deliveredTo']}</td>
															<td>{$rowDelReq1['building']}</td>
															<td>{$rowDelReq1['floorRoom']}</td>
															<td>{$rowDelReq1['deliveryDate']}</td>";
															if($rowDelReq['statusID'] == '2'){//ongoing
																echo "<td><span class='label label-info'>{$rowDelReq['statusDesc']}</span></td>";
															}
															if($rowDelReq['statusID'] == '3'){//completed
																echo "<td><span class='label label-success'>{$rowDelReq['statusDesc']}</span></td>";
															}
															if($rowDelReq['statusID'] == '4'){//incompleted
																echo "<td><span class='label label-danger'>{$rowDelReq['statusDesc']}</span></td>";
															}
															echo "<td style='display: none'></td>
														</tr>";
													}
												?>
												
                  
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Delivered To</th>
                                                    <th>Building</th>
                                                    <th>Floor</th>
                                                    <th>Delivery Date</th>
													<th>Delivery Status</th>
                                                </tr>
                                            </tfoot>
                                        </table>
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

    <!-- WAG GALAWIN PLS LANG -->

    <script>
    function addRowHandlers() {
        var table = document.getElementById("dynamic-table");
        var rows = table.getElementsByTagName("tr");
        for (i = 1; i < rows.length; i++) {
            var currentRow = table.rows[i];
            var createClickHandler = function(row) {
                return function() {
                    var cell = row.getElementsByTagName("td")[0];
                    var id = cell.textContent;

                    window.location.href = "it_view_delivery_details.php?id="+id;

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