<!DOCTYPE html>
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
                    Welcome it officer!
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
                                    Request List
                                </header>
                                <div class="panel-body">
                                    <section id="unseen">
                                        <table class="table table-bordered table-striped table-condensed table-hover" id="ctable">
                                            <thead>
                                                <tr>
                                                    <th>Date Needed</th>
                                                    <th>Status</th>
													<th>Request Type</th>
                                                    <th>Description</th>
                                                    <th>Requestor</th>
                                                    <th>Requested Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
												<?php
												
													require_once('db/mysql_connect.php');
													$query="SELECT r.requestID,r.description as `requestDesc`,r.recipient,r.datetime as `requestedDate`,r.dateNeeded,rs.description as `statusDesc` FROM thesis.request r 
																		join ref_status rs on r.status=rs.statusID";
													$result=mysqli_query($dbc,$query);
													while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
														echo "<tr id='{$row['requestID']}'>
															<td>{$row['dateNeeded']}</td>";
															
															
															if($row['statusDesc']=='Completed'){
																echo "<td><span class='label label-success label-mini'>{$row['statusDesc']}</span></td>";
															}
															
															elseif($row['statusDesc']=='Canvas Completed'){
																echo "<td><span class='label label-info'>{$row['statusDesc']}</span></td>";
															}
															elseif($row['statusDesc']=='Incomplete'){
																echo "<td><span class='label label-danger label-mini'>{$row['statusDesc']}</span></td>";
															}
															else{
																echo "<td><span class='label label-default'>{$row['statusDesc']}</span></td>";
															}
															
															
														echo "
															<td>{$row['requestDesc']}</td>
															<td>{$row['recipient']}</td>
															<td>{$row['requestedDate']}</td>
														</tr>";
														
														
														
													}
												?>
                                                <tr>
                                                    <td>12/23/2018</td>
                                                    <td><span class="label label-success label-mini">Completed</span></td>
													<td>Donation</td>
                                                    <td>We ed 500 more laptops PLSSS!!</td>
                                                    <td>Marvin Lao</td>
                                                    <td>1/1/2018</td>
                                                </tr>
												<tr>
                                                    <td>12/23/2018</td>
                                                    <td><span class="label label-danger label-mini">Incomplete</span></td>
													<td>Donation</td>
                                                    <td>We need 500 more laptops PLSSS!!</td>
                                                    <td>Marvin Lao</td>
                                                    <td>1/1/2018</td>
                                                </tr>
												<tr>
                                                    <td>12/23/2018</td>
                                                    <td><span class="label label-default label-mini">Ongoing</span></td>
													<td>Donation</td>
                                                    <td>We need 500 more laptops PLSSS!!</td>
                                                    <td>Marvin Lao</td>
                                                    <td>1/1/2018</td>
                                                </tr>
												<tr>
                                                    <td>12/23/2018</td>
                                                    <td><span class="label label-warning label-mini">Pending</span></td>
													<td>Donation</td>
                                                    <td>We need 500 more laptops PLSSS!!</td>
                                                    <td>Marvin Lao</td>
                                                    <td>1/1/2018</td>
                                                </tr>
                                                <tr>
                                                    <td>12/23/2018</td>
                                                    <td><span class="label label-danger label-mini">Incomplete</span></td>
													<td>Asset Request</td>
                                                    <td>Replacement needed</td>
                                                    <td>requestor</td>
                                                    <td>1/1/2018</td>
                                                </tr>
												<tr>
                                                    <td>12/23/2018</td>
                                                    <td><span class="label label-default label-mini">Ongoing</span></td>
													<td>Asset Request</td>
                                                    <td>Items received</td>
                                                    <td>requestor</td>
                                                    <td>1/1/2018</td>
                                                </tr>
												<tr>
                                                    <td>12/23/2018</td>
                                                    <td><span class="label label-default label-mini">Ongoing</span></td>
													<td>Asset Request</td>
                                                    <td>Testing checklist needed</td>
                                                    <td>requestor</td>
                                                    <td>1/1/2018</td>
                                                </tr>
												<tr>
                                                    <td>12/23/2018</td>
                                                    <td><span class="label label-default label-mini">Ongoing</span></td>
													<td>Asset Request</td>
                                                    <td>Replacement needed</td>
                                                    <td>requestor</td>
                                                    <td>1/1/2018</td>
                                                </tr>
												<tr>
                                                    <td>12/23/2018</td>
                                                    <td><span class="label label-default label-mini">Ongoing</span></td>
													<td>Asset Request</td>
                                                    <td>Conforme pending</td>
                                                    <td>requestor</td>
                                                    <td>1/1/2018</td>
                                                </tr>
												<tr>
                                                    <td>12/23/2018</td>
                                                    <td><span class="label label-success label-mini">Completed</span></td>
													<td>Asset Request</td>
                                                    <td></td>
                                                    <td>requestor</td>
                                                    <td>1/1/2018</td>
                                                </tr>
												<tr>
                                                    <td>12/23/2018</td>
                                                    <td><span class="label label-success label-mini">Completed</span></td>
													<td>Asset Request</td>
                                                    <td></td>
                                                    <td>requestor</td>
                                                    <td>1/1/2018</td>
                                                </tr>
												<tr>
                                                    <td>12/23/2018</td>
                                                    <td><span class="label label-warning label-mini">Pending</span></td>
													<td>Asset Request</td>
                                                    <td>We need 500 more laptops PLSSS!!</td>
                                                    <td>requestor</td>
                                                    <td>1/1/2018</td>
                                                </tr>
												<tr>
                                                    <td>12/23/2018</td>
                                                    <td><span class="label label-warning label-mini">Pending</span></td>
													<td>Asset Request</td>
                                                    <td>Canvas completed</td>
                                                    <td>requestor</td>
                                                    <td>1/1/2018</td>
                                                </tr>
												<tr>
                                                    <td>12/23/2018</td>
                                                    <td><span class="label label-warning label-mini">Pending</span></td>
													<td>Asset Request</td>
                                                    <td>Purchase order completed</td>
                                                    <td>requestor</td>
                                                    <td>1/1/2018</td>
                                                </tr>
												<tr>
                                                    <td>12/23/2018</td>
                                                    <td><span class="label label-warning label-mini">Pending</span></td>
													<td>Testing</td>
                                                    <td>We need 500 more laptops PLSSS!!</td>
                                                    <td>Jane Doe</td>
                                                    <td>1/1/2018</td>
                                                </tr>
												<tr>
                                                    <td>12/23/2018</td>
                                                    <td><span class="label label-default">Ongoing</span></td>
													<td>Testing</td>
                                                    <td>Being tested</td>
                                                    <td>Jane Doe</td>
                                                    <td>1/1/2018</td>
                                                </tr>
												<tr>
                                                    <td>12/23/2018</td>
                                                    <td><span class="label label-success">Completed</span></td>
													<td>Testing</td>
                                                    <td>Being tested</td>
                                                    <td>Jane Doe</td>
                                                    <td>1/1/2018</td>
                                                </tr>
                                                <tr>
                                                    <td>12/23/2018</td>
                                                    <td><span class="label label-danger">Incomplete</span></td>
													<td>Testing</td>
                                                    <td>Burrow these please</td>
                                                    <td>John Doe</td>
                                                    <td>1/1/2018</td>
                                                </tr>
												<tr>
													<td>12/25/2019</td>
													<td><span class="label label-success">Completed</span></td>
													<td>Repair</td>
													<td>Need more equipment</td>
													<td>Requestor person</td>
													<td>12/32/8102</td>
												</tr>
												<tr>
													<td>12/25/2019</td>
													<td><span class="label label-default">Ongoing</span></td>
													<td>Repair</td>
													<td>Need more equipment</td>
													<td>Requestor person</td>
													<td>12/32/8102</td>
												</tr>
												<tr>
													<td>12/25/2019</td>
													<td><span class="label label-default">Ongoing</span></td>
													<td>Repair</td>
													<td></td>
													<td>Requestor person</td>
													<td>12/32/8102</td>
												</tr>
												<tr>
													<td>12/25/2019</td>
													<td><span class="label label-warning">Pending</span></td>
													<td>Repair</td>
													<td>Need more equipment</td>
													<td>Requestor person</td>
													<td>12/32/8102</td>
												</tr>
												<tr>
													<td>12/25/2019</td>
													<td><span class="label label-warning">Pending</span></td>
													<td>Repair</td>
													<td></td>
													<td>Requestor person</td>
													<td>12/32/8102</td>
												</tr>
												<tr>
													<td>12/25/2019</td>
													<td><span class="label label-danger">Incomplete</span></td>
													<td>Repair</td>
													<td>Need more equipment</td>
													<td>Requestor person</td>
													<td>12/32/8102</td>
												</tr>
												<tr>
													<td>12/25/2019</td>
													<td><span class="label label-danger">Incomplete</span></td>
													<td>Repair</td>
													<td></td>
													<td>Requestor person</td>
													<td>12/32/8102</td>
												</tr>
                                                <tr>
													<td>12/25/2019</td>
													<td><span class="label label-danger">Incomplete</span></td>
													<td>Service Request</td>
													<td>Need more equipment</td>
													<td>bicycle</td>
													<td>12/32/8102</td>
												</tr>
												<tr>
													<td>12/25/2019</td>
													<td><span class="label label-success">Completed</span></td>
													<td>Service Request</td>
													<td>Need more equipment</td>
													<td>bicycle</td>
													<td>12/32/8102</td>
												</tr>
												<tr>
													<td>12/25/2019</td>
													<td><span class="label label-warning">Pending</span></td>
													<td>Service Request</td>
													<td>Need more equipment</td>
													<td>bicycle</td>
													<td>12/32/8102</td>
												</tr>
												<tr>
													<td>12/25/2019</td>
													<td><span class="label label-default">Ongoing</span></td>
													<td>Service Request</td>
													<td>Need more equipment</td>
													<td>bicycle</td>
													<td>12/32/8102</td>
												</tr>
												
												<tr>
													<td>12/25/2019</td>
													<td><span class="label label-default">Ongoing</span></td>
													<td>Borrow</td>
													<td></td>
													<td>Yes</td>
													<td>12/32/8102</td>
												</tr>
												<tr>
													<td>12/25/2019</td>
													<td><span class="label label-danger">Incomplete</span></td>
													<td>Borrow</td>
													<td>Need more equipment</td>
													<td>Yes</td>
													<td>12/32/8102</td>
												</tr>
												<tr>
													<td>12/25/2019</td>
													<td><span class="label label-success">Completed</span></td>
													<td>Borrow</td>
													<td>Need more equipment</td>
													<td>Yes</td>
													<td>12/32/8102</td>
												</tr>
												<tr>
													<td>12/25/2019</td>
													<td><span class="label label-warning">Pending</span></td>
													<td>Borrow</td>
													<td>Need more equipment</td>
													<td>Yes</td>
													<td>12/32/8102</td>
												</tr>
                                            </tbody>
                                        </table>
                                    </section>

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
		function addRowHandlers() {
			var table = document.getElementById("ctable");
			var rows = table.getElementsByTagName("tr");
			for (i = 1; i < rows.length; i++) {
				var currentRow = table.rows[i];
				var createClickHandler = function(row) {
					return function() {
						var cell = row.getElementsByTagName("td")[1];
						var id = cell.textContent;						//Status
						var cell = row.getElementsByTagName("td")[2];
						var idx = cell.textContent;						//Request type
						var cell = row.getElementsByTagName("td")[3];
						var idDesc = cell.textContent;					//Description
						alert(id + " - " + idx + " - " + idDesc);
						
						if(idx == "Repair"){															
							if(id == "Completed" || id == "Incomplete"){								
								window.location.replace("it_view_completed_incomplete_repair.php?requestID=" + row.getAttribute("id"));
							}
							if(id == "Ongoing" || id == "Pending"){										
								window.location.replace("it_view_ongoing_pending_repair.php?requestID=" + row.getAttribute("id"));
							}
							
						}
                        
						if(idx == "Asset Request"){
							if(id == "Ongoing" || id == "Pending"){
								if(idDesc == "Canvas completed"){
									window.location.replace("it_view_canvas_completed.php");
								}
								
								else if(idDesc == "Items received"){
									window.location.replace("it_view_open_po.php");
								}
								
								else if(idDesc == "Replacement needed"){
									window.location.replace("it_all_supplier.php");
								}
								
								else if(idDesc == "Conforme pending"){
									window.location.replace("it_view_checklist.php");
								}
							}
							
							if(id == "Completed" || id == "Incomplete"){
								window.location.replace("it_view_checklist.php");
							}
						}
						
						if(idx == "Testing"){
							if(id == "Ongoing" || id == "Pending"){
								window.location.replace("it_view_incomplete_testing.php");
							}
							
							else if(id == "Completed" || id == "Incomplete"){
								window.location.replace("it_view_testing.php");
							}
						}
						
						if(idx == "Service Request"){
							window.location.replace("it_view_service_request_form.php");
						}
						
						if(idx == "Donation"){
                            if(id == "Ongoing" || id == "Pending"){
                                window.location.replace("it_view_open_donation_request.php");
                            }
                            
                            if(id == "Completed" || id == "Incomplete"){
                                window.location.replace("it_view_closed_donation_request.php");
                            }
                        }
						
						if(idx == "Borrow"){
							if(id == "Ongoing" || id == "Pending"){
								window.location.replace("it_view_open_service_equipment_request.php");
							}
							
							else if(id == "Completed" || id == "Incomplete"){
								window.location.replace("it_view_closed_service_equipment_request.php");
							}
						}
					};
				};
				currentRow.onclick = createClickHandler(currentRow);
			}
		}
		window.onload = addRowHandlers();
	</script>

    <!-- WAG GALAWIN PLS LANG -->

    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>

    
    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>