<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
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

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">


                            <section class="panel">
                                <header class="panel-heading">
                                    All Requests
                                    <span class="tools pull-right">
                                        <a href="helpdesk_create_ticket.php" class="fa fa-plus"></a>
                                    </span>
                                </header>
                                <div class="panel-body">
                                    <div class="adv-table" id="ctable">
                                        <table class="display table table-bordered table-striped" id="dynamic-table">
                                            <thead>
                                                <tr>
                                                    <th style="display: none"></th>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th>Type of Request</th>
                                                    <th>Date Needed</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
												<?php 
                                                    $count = 1;
													//GET REQUEST FOR Procurement Service Material
													$queryReqProc="SELECT *,rs.description as `statusDesc` FROM thesis.request r join ref_status rs on r.status=rs.statusID where r.step='9'";
													$resultReqProc=mysqli_query($dbc,$queryReqProc);
													while($rowReqProc=mysqli_fetch_array($resultReqProc,MYSQLI_ASSOC)){
														echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$rowReqProc['requestID']}</td>
															<td>{$count}</td>
															<td>{$rowReqProc['description']}</td>
															<td>Procurement of Service and Material</td>
															<td>{$rowReqProc['dateNeeded']}</td>";
															if($rowReqProc['statusDesc']=="Pending"){ echo "<td><label class='label label-warning'>{$rowReqProc['statusDesc']}</label></td>"; }
															if($rowReqProc['statusDesc']=="Ongoing"){ echo "<td><label class='label label-primary'>{$rowReqProc['statusDesc']}</label></td>"; }
															if($rowReqProc['statusDesc']=="Incomplete"){ echo "<td><label class='label label-danger'>{$rowReqProc['statusDesc']}</label></td>"; }
															if($rowReqProc['statusDesc']=="Complete"){ echo "<td><label class='label label-success'>{$rowReqProc['statusDesc']}</label></td>"; }
															
															echo"</tr>";

                                                        $count++;
													}
												?>
												
												<?php 
													
													//GET DONATION REQUEST
													$queryDon="SELECT *,rs.description as `statusDesc` FROM thesis.donation d join ref_status rs on d.statusID=rs.statusID where d.stepsID='9' ";
													$resultDon=mysqli_query($dbc,$queryDon);
													while($rowDon=mysqli_fetch_array($resultDon,MYSQLI_ASSOC)){
														echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$rowDon['donationID']}</td>
															<td>{$count}</td>
															<td>{$rowDon['purpose']}</td>
															<td>Donation</td>
															<td>{$rowDon['dateNeed']}</td>";
															if($rowDon['statusDesc']=="Pending"){ echo "<td><label class='label label-warning'>{$rowDon['statusDesc']}</label></td>"; }
															if($rowDon['statusDesc']=="Ongoing"){ echo "<td><label class='label label-primary'>{$rowDon['statusDesc']}</label></td>"; }
															if($rowDon['statusDesc']=="Incomplete"){ echo "<td><label class='label label-danger'>{$rowDon['statusDesc']}</label></td>"; }
															if($rowDon['statusDesc']=="Complete"){ echo "<td><label class='label label-success'>{$rowDon['statusDesc']}</label></td>"; }
															echo "</tr>";

                                                            $count++;
													}
													
												?>	
												<?php
                                                    //view for service
                                                    $query = "SELECT *, sr.id as 'serviceID' FROM thesis.service sr   
                                                              JOIN ref_status st ON sr.status = st.statusID 
                                                              JOIN ref_steps s ON steps = s.id;";
                                                                  
                                                    $result = mysqli_query($dbc, $query);
                                                    
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                      
                                                      echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$row['serviceID']}</td>
                                                            <td>{$count}</td>
                                                            <td>{$row['summary']}</td>
                                                            <td>";

                                                       if($row['serviceType']=='27') echo "Repair";
                                                       else echo "Service";

                                                        echo
                                                            "</td>
                                                            <td>{$row['dateNeed']}</td>";

                                                        if($row['description']=="Pending"){ echo "<td><label class='label label-warning'>{$row['description']}</label></td>"; }
                                                        if($row['description']=="Ongoing"){ echo "<td><label class='label label-primary'>{$row['description']}</label></td>"; }
                                                        if($row['description']=="Incomplete"){ echo "<td><label class='label label-danger'>{$row['description']}</label></td>"; }
                                                        if($row['description']=="Complete"){ echo "<td><label class='label label-success'>{$row['description']}</label></td>"; }

                                                        echo "</tr>";

                                                          $count++;
                                                    }
                                                  ?>

                                                  <?php
                                                    //view for borrow
                                                    $query = "SELECT * FROM thesis.request_borrow r 
                                                              JOIN ref_status s ON r.statusID = s.statusID
                                                              JOIN ref_steps t ON r.steps = t.id
                                                              WHERE steps = 13;";
                                                                  
                                                    $result = mysqli_query($dbc, $query);
                                                    
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                      
                                                      echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$row['borrowID']}</td>
                                                            <td>{$count}</td>
                                                            <td>{$row['purpose']}</td>
                                                            <td>Borrow</td>
                                                            <td>{$row['startDate']}</td>";


                                                        if($row['description']=="Pending"){ echo "<td><label class='label label-warning'>{$row['description']}</label></td>"; }
                                                        if($row['description']=="Ongoing"){ echo "<td><label class='label label-primary'>{$row['description']}</label></td>"; }
                                                        if($row['description']=="Incomplete"){ echo "<td><label class='label label-danger'>{$row['description']}</label></td>"; }
                                                        if($row['description']=="Complete"){ echo "<td><label class='label label-success'>{$row['description']}</label></td>"; }

                                                        echo "</tr>";

                                                          $count++;
                                                    }
                                                  ?>
                                                <?php 
                                                    
                                                    //GET ASSET TESTING REQUEST
                                                    $queryTest="SELECT * FROM thesis.assettesting a 
                                                                JOIN request_borrow b
                                                                ON a.borrowID = b.borrowID
                                                                JOIN ref_status s
                                                                ON a.statusID = s.statusID
                                                                ORDER BY testingID DESC LIMIT 1;";
                                                    $resultTest=mysqli_query($dbc,$queryTest);
                                                    while($rowStep=mysqli_fetch_array($resultTest,MYSQLI_ASSOC)){
                                                        echo "<tr class='gradeA'>
                                                                <td style='display: none'>{$rowStep['testingID']}</td>
                                                                <td>{$count}</td>
                                                                <td>{$rowStep['purpose']}</td>
                                                                <td>Asset Testing</td>
                                                                <td>{$rowStep['startDate']}</td>";

                                                        if($rowStep['description']=="Pending"){ echo "<td><label class='label label-warning'>{$rowStep['description']}</label></td>"; }
                                                        if($rowStep['description']=="Ongoing"){ echo "<td><label class='label label-primary'>{$rowStep['description']}</label></td>"; }
                                                        if($rowStep['description']=="Incomplete"){ echo "<td><label class='label label-danger'>{$rowStep['description']}</label></td>"; }
                                                        if($rowStep['description']=="Complete"){ echo "<td><label class='label label-success'>{$rowStep['description']}</label></td>"; }
                                                                
                                                        echo "</tr>";
                                                        }

                                                ?>
											
                                            <tfoot>
                                                <tr>
                                                    <th style="display: none"></th>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th>Type of Request</th>
                                                    <th>Date Needed</th>
                                                    <th>Status</th>
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

    <script>
		function addRowHandlers() {
			var table = document.getElementById("dynamic-table");
			var rows = table.getElementsByTagName("tr");
			for (i = 1; i < rows.length; i++) {
				var currentRow = table.rows[i];
				var createClickHandler = function(row) {
					return function() {
						var cell = row.getElementsByTagName("td")[3];
						var idx = cell.textContent;
						
						var cell1 = row.getElementsByTagName("td")[0];
						var id = cell1.textContent;
						
						if(idx == "Asset Testing"){
							window.location.href = "helpdesk_view_assettesting_open.php?testingID=" + id;
						}
						
						if(idx == "Donation"){
							window.location.href = "helpdesk_view_donation_request.php?donationID=" + id;
						}
                        
                        if(idx == "Procurement of Service and Material"){
                            window.location.href = "helpdesk_view_procurement_service_material_request.php?requestID=" + id;
						}
						
						if(idx == "Borrow"){
							window.location.href = "helpdesk_view_service_equipment_request.php?id=" + id;
						}
						
						if(idx == "Service"){
							window.location.href="helpdesk_view_service_request.php?id="+id;
						}
						
						if(idx == "Repair"){
							window.location.href = "helpdesk_view_repair.php?id="+id;
						}
						
					};
				};
				currentRow.onclick = createClickHandler(currentRow);
			}
		}
		window.onload = addRowHandlers();
	</script>

    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>