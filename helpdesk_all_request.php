<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	$key = "Fusion";
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
                                                    <th>Description</th>
                                                    <th>Type of Request</th>
                                                    <th>Date Needed</th>
                                                    <th>Status</th>
                                                    <th>Requested By</th>
                                                </tr>
                                            </thead>
                                            <tbody>
												<?php 
                                                    $count = 1;
													
													
													//PENDING STATUS 
													
													//GET PENDING DELIVERY DATA
													$queryDeliv="SELECT d.id as `deliveryID`,r.requestID,r.description,r.dateNeeded,rs.description as `statusDesc`,e.name as `empName` FROM thesis.delivery d join procurement p on d.procurementID=p.procurementID
																																join request r on p.requestID=r.requestID
																																join ref_status rs on r.status=rs.statusID 
																																join user u on r.UserID=u.UserID 
																																join employee e on u.UserID= e.UserID
																																where d.status='Delivered'";
													$resultDeliv=mysqli_query($dbc,$queryDeliv);
													while($rowDeliv=mysqli_fetch_array($resultDeliv,MYSQLI_ASSOC)){
														echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$rowDeliv['deliveryID']}</td>
															<td>{$count}</td>
															<td>{$rowDeliv['description']}</td>
															<td>Procurement of Service and Material</td>
															<td>{$rowDeliv['dateNeeded']}</td>";
															echo "<td><label class='label label-warning'>Pending</label></td>"; 
															echo"<td>{$rowDeliv['empName']}</td>";
															echo"</tr>";

                                                        $count++;
													}
													
													//PENDING DONATION REQUEST
													$queryDon="SELECT *,rs.description as `statusDesc`,e.name as `empName` FROM thesis.donation d join ref_status rs on d.statusID=rs.statusID JOIN employee e ON d.user_UserID = e.UserID where d.stepsID='9' ";
													$resultDon=mysqli_query($dbc,$queryDon);
													while($rowDon=mysqli_fetch_array($resultDon,MYSQLI_ASSOC)){
														echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$rowDon['donationID']}</td>
															<td>{$count}</td>
															<td>{$rowDon['purpose']}</td>
															<td>Donation</td>
															<td>{$rowDon['dateNeed']}</td>";
															echo "<td><label class='label label-warning'>Pending</label></td>"; 
															echo "
															<td>{$rowDon['empName']}</td>
															</tr>";

                                                            $count++;
													}
													
													//PENDING BORROW 
                                                    $queryTest="SELECT * FROM  request_borrow b
                                                                JOIN ref_status s
                                                                ON b.statusID = s.statusID
                                                                JOIN employee e ON e.UserID = b.personresponsibleID where b.steps='9' 
                                                                ORDER BY borrowID DESC;";
                                                    $resultTest=mysqli_query($dbc,$queryTest);
                                                    while($rowStep=mysqli_fetch_array($resultTest,MYSQLI_ASSOC)){
                                                        echo "<tr class='gradeA'>
                                                                <td style='display: none'>{$rowStep['borrowID']}</td>
                                                                <td>{$count}</td>
                                                                <td>Borrow these items</td>
                                                                <td>Borrow</td>
                                                                <td>{$rowStep['startDate']}</td>";
																echo "<td><label class='label label-warning'>Pending</label></td>"; 
																echo "<td>{$rowStep['name']}</td>"; 
																echo "</tr>";
                                                    }
													
													//COMPLETED 
													
													//GET COMPLETED DELIVERY DATA
													$queryDeliv="SELECT d.id as `deliveryID`,r.requestID,r.description,r.dateNeeded,rs.description as `statusDesc`,e.name as `empName` FROM thesis.delivery d join procurement p on d.procurementID=p.procurementID
																																join request r on p.requestID=r.requestID
																																join ref_status rs on r.status=rs.statusID 
																																join user u on r.UserID=u.UserID 
																																join employee e on u.UserID= e.UserID
																																where d.status='For Testing'";
													$resultDeliv=mysqli_query($dbc,$queryDeliv);
													while($rowDeliv=mysqli_fetch_array($resultDeliv,MYSQLI_ASSOC)){
														echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$rowDeliv['deliveryID']}</td>
															<td>{$count}</td>
															<td>{$rowDeliv['description']}</td>
															<td>Procurement of Service and Material</td>
															<td>{$rowDeliv['dateNeeded']}</td>";
															echo "<td><label class='label label-success'>Completed</label></td>"; 
															echo"<td>{$rowDeliv['empName']}</td>";
															echo"</tr>";

                                                        $count++;
													}
													
													//COMPLETED DONATION REQUEST
													$queryDon="SELECT *,rs.description as `statusDesc`,e.name as `empName` FROM thesis.donation d join ref_status rs on d.statusID=rs.statusID JOIN employee e ON d.user_UserID = e.UserID where d.stepsID!='9' ";
													$resultDon=mysqli_query($dbc,$queryDon);
													while($rowDon=mysqli_fetch_array($resultDon,MYSQLI_ASSOC)){
														echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$rowDon['donationID']}</td>
															<td>{$count}</td>
															<td>{$rowDon['purpose']}</td>
															<td>Donation</td>
															<td>{$rowDon['dateNeed']}</td>";
															echo "<td><label class='label label-success'>Completed</label></td>"; 
															echo "
															<td>{$rowDon['empName']}</td>
															</tr>";

                                                            $count++;
													}
													
													//COMPLETED BORROW 
                                                    $queryTest="SELECT * FROM  request_borrow b
                                                                JOIN ref_status s
                                                                ON b.statusID = s.statusID
                                                                JOIN employee e ON e.UserID = b.personresponsibleID where b.steps='13' or b.statusID='3' 
                                                                ORDER BY borrowID DESC;";
                                                    $resultTest=mysqli_query($dbc,$queryTest);
                                                    while($rowStep=mysqli_fetch_array($resultTest,MYSQLI_ASSOC)){
                                                        echo "<tr class='gradeA'>
                                                                <td style='display: none'>{$rowStep['borrowID']}</td>
                                                                <td>{$count}</td>
                                                                <td>Borrow these items</td>
                                                                <td>Borrow</td>
                                                                <td>{$rowStep['startDate']}</td>";
																echo "<td><label class='label label-success'>Completed</label></td>"; 
																echo "<td>{$rowStep['name']}</td>"; 
																echo "</tr>";
                                                    }
												?>
												
												
												<?php
                                                    //view for service
                                                    $query = "SELECT *, sr.id as 'serviceID' , e.name as 'requestedby'
                                                              FROM thesis.service sr   
                                                              JOIN ref_status st ON sr.status = st.statusID 
                                                              JOIN ref_steps s ON steps = s.id
                                                              JOIN employee e ON e.UserID = sr.UserID;";
                                                                  
                                                    $result = mysqli_query($dbc, $query);
                                                    
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                      
                                                      echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$row['serviceID']}</td>
                                                            <td>{$count}</td>
                                                            <td>Repair these items</td>
                                                            <td>";

                                                       if($row['serviceType']=='27') echo "Repair";
													   elseif($row['serviceType']=='28') echo "Maintenance";
                                                       else echo "Service";

                                                        echo
                                                            "</td>
                                                            <td>";
															echo date('Y-m-d', strtotime($row['dateReceived']. ' + 7 days'));
															
															echo"</td>";

                                                        if($row['description']=="Pending"){ echo "<td><label class='label label-warning'>{$row['description']}</label></td>"; }
                                                        if($row['description']=="Ongoing"){ echo "<td><label class='label label-primary'>{$row['description']}</label></td>"; }
                                                        if($row['description']=="Incomplete"){ echo "<td><label class='label label-danger'>{$row['description']}</label></td>"; }
                                                        if($row['description']=="Completed"){ echo "<td><label class='label label-success'>{$row['description']}</label></td>"; }
                                                        echo "<td>{$row['name']}</td>";
                                                        echo "</tr>";

                                                          $count++;
                                                    }
                                                  ?>
                                                
												
												<?php 
													
													//GET REPLACEMENT REQUEST
													$queryGetRep="SELECT *,CONCAT(Convert(AES_DECRYPT(u.firstName,'{$key}')USING utf8), ' ', Convert(AES_DECRYPT(u.lastName,'{$key}')USING utf8)) as `Requestor`,rs.description as `statusDesc`,rstp.name as `stepName` FROM thesis.replacement r 
																			JOIN ref_status rs ON r.statusID = rs.statusID
																			JOIN user u on r.userID=u.UserID
																			JOIN ref_steps rstp on r.stepID=rstp.id
																			where r.stepID='9'";
                                                    $resultGetRep=mysqli_query($dbc,$queryGetRep);
                                                    while($rowGetRep=mysqli_fetch_array($resultGetRep,MYSQLI_ASSOC)){
														echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$rowGetRep['replacementID']}</td>
															<td>{$count}</td>
															<td>{$rowGetRep['remarks']}</td>
															<td>Replacement</td>
															<td>{$rowGetRep['dateNeeded']}</td>";
															if($rowGetRep['statusDesc']=="Pending"){ echo "<td><label class='label label-warning'>{$rowGetRep['statusDesc']}</label></td>"; }
															if($rowGetRep['statusDesc']=="Ongoing"){ echo "<td><label class='label label-primary'>{$rowGetRep['statusDesc']}</label></td>"; }
															if($rowGetRep['statusDesc']=="Incomplete"){ echo "<td><label class='label label-danger'>{$rowGetRep['statusDesc']}</label></td>"; }
															if($rowGetRep['statusDesc']=="Completed"){ echo "<td><label class='label label-success'>{$rowGetRep['statusDesc']}</label></td>"; }
															echo "
															<td>{$rowGetRep['Requestor']}</td>
															</tr>";

                                                            $count++;
													}
													
												?>	
                                                
                                                
                                                <?php
													
                                                    //view for salvage
                                                    $query69 = "SELECT s.id, rs.description, e.name,s.dateCreated FROM salvage s 
                                                                JOIN ref_status rs ON s.ref_status_statusID = rs.statusID
                                                                JOIN user u ON s.userID = u.userID
                                                                JOIN employee e ON u.userID = e.userID;";
                                                                  
                                                    $result69 = mysqli_query($dbc, $query69);
                                                    
													
                                                    while ($row = mysqli_fetch_array($result69, MYSQLI_ASSOC))
                                                    {
                                                     
                                                      echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$row['id']}</td>
                                                            <td>{$count}</td>
                                                            <td>Salvage These Items</td>
                                                            <td>";
                                                        
                                                        echo "Salvage";

                                                        echo
                                                            "</td>
                                                            <td>";
															echo date('Y-m-d',strtotime($row['dateCreated']. ' + 14 days'));
															echo "</td>";

                                                        if($row['description']=="Pending"){ echo "<td><label class='label label-warning'>{$row['description']}</label></td>"; }
                                                        if($row['description']=="Ongoing"){ echo "<td><label class='label label-primary'>{$row['description']}</label></td>"; }
                                                        if($row['description']=="Incomplete"){ echo "<td><label class='label label-danger'>{$row['description']}</label></td>"; }
                                                        if($row['description']=="Completed"){ echo "<td><label class='label label-success'>{$row['description']}</label></td>"; }
                                                        echo "<td>{$row['name']}</td>";
                                                        echo "</tr>";

                                                          $count++;
                                                    }
                                                  ?>
                                                
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
                            window.location.href = "helpdesk_view_procurement_service_material_request.php?deliveryID=" + id;
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
						
						if(idx == "Maintenance"){
							window.location.href = "helpdesk_view_ticket_maintenance_opened.php?id="+id;
						}
						
						if(idx == "Replacement"){
							window.location.href = "helpdesk_view_replacement_request.php?id="+id;
						}
                        if(idx == "Salvage"){
							window.location.href = "helpdesk_view_salvage_open.php?id="+id;
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