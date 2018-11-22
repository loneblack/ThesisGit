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
                                    Request List
                                </header>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="panel">
                                            <div class="panel-body">
                                                <div class="adv-table">
                                                    <table class="display table table-bordered table-striped" id="dynamic-table">
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
															
															$key = "Fusion";
															require_once('db/mysql_connect.php');

                                                            //Request Purchase
															$query="SELECT r.requestID,rstp.name as `step`,r.recipient,r.date as `requestedDate`,r.dateNeeded,rs.description as `statusDesc`,CONCAT(Convert(AES_DECRYPT(u.firstName,'{$key}')USING utf8), ' ', Convert(AES_DECRYPT(u.lastName,'{$key}')USING utf8)) as `requestor` FROM thesis.request r 
                                                                                join ref_status rs on r.status=rs.statusID
                                                                                join ref_steps rstp on r.step=rstp.id
                                                                                join user u on r.UserID=u.UserID
                                                                                WHERE status !=6;";
															$result=mysqli_query($dbc,$query);
															while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
																echo "<tr id='{$row['requestID']}'>
																	<td>{$row['dateNeeded']}</td>";
																	
																	if($row['statusDesc']=='Pending'){
																		echo "<td><span class='label label-warning label-mini'>{$row['statusDesc']}</span></td>";
																	}
																	elseif($row['statusDesc']=='Incomplete'){
																		echo "<td><span class='label label-danger label-mini'>{$row['statusDesc']}</span></td>";
																	}
																	elseif($row['statusDesc']=='Completed'){
																		echo "<td><span class='label label-success label-mini'>{$row['statusDesc']}</span></td>";
																	}
																	//elseif($row['statusDesc']=='Ongoing'){
																		//echo "<td><span class='label label-default label-mini'>{$row['statusDesc']}</span></td>";
																	//}
																	else{
																		echo "<td><span class='label label-default label-mini'>{$row['statusDesc']}</span></td>";
																	}
																	
																echo "
																	<td>Asset Request</td>
																	<td>{$row['step']}</td>
																	<td>{$row['requestor']}</td>
																	<td>{$row['requestedDate']}</td>
																</tr>";
																
																
																
															}
															//Donation
															$queryDon="SELECT * , rs.description as `statusDesc`,CONCAT(Convert(AES_DECRYPT(u.firstName,'{$key}')USING utf8), ' ', Convert(AES_DECRYPT(u.lastName,'{$key}')USING utf8)) as `requestor`,rstp.name as `step` FROM thesis.donation d join ref_status rs on d.statusID=rs.statusID
																																		join ref_steps rstp on d.stepsID=rstp.id
																																		join user u on d.user_UserID=u.UserID";
															$resultDon=mysqli_query($dbc,$queryDon);
															
															while($rowDon=mysqli_fetch_array($resultDon,MYSQLI_ASSOC)){
																echo "<tr id='{$rowDon['donationID']}'>
																	<td>{$rowDon['dateNeed']}</td>";
																	
																	if($rowDon['statusDesc']=='Pending'){
																		echo "<td><span class='label label-warning label-mini'>{$rowDon['statusDesc']}</span></td>";
																	}
																	elseif($rowDon['statusDesc']=='Incomplete'){
																		echo "<td><span class='label label-danger label-mini'>{$rowDon['statusDesc']}</span></td>";
																	}
																	elseif($rowDon['statusDesc']=='Completed'){
																		echo "<td><span class='label label-success label-mini'>{$rowDon['statusDesc']}</span></td>";
																	}
																	//elseif($row['statusDesc']=='Ongoing'){
																		//echo "<td><span class='label label-default label-mini'>{$row['statusDesc']}</span></td>";
																	//}
																	else{
																		echo "<td><span class='label label-default label-mini'>{$rowDon['statusDesc']}</span></td>";
																	}
																	
																echo "
																	<td>Donation</td>
																	<td>{$rowDon['step']}</td>
																	<td>{$rowDon['requestor']}</td>
																	<td>{$rowDon['dateNeed']}</td>
																</tr>";
																
																
																
															}
															//ADD BORROW REQUEST
															?>
                                                        </tbody>
                                                    </table>
                                                </div>
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
        function addRowHandlers() {
            var table = document.getElementById("dynamic-table");
            var rows = table.getElementsByTagName("tr");
            for (i = 1; i < rows.length; i++) {
                var currentRow = table.rows[i];
                var createClickHandler = function(row) {
                    return function() {
                        var cell = row.getElementsByTagName("td")[1];
                        var id = cell.textContent; //Status
                        var cell = row.getElementsByTagName("td")[2];
                        var idx = cell.textContent; //Request type
                        var cell = row.getElementsByTagName("td")[3];
                        var idDesc = cell.textContent; //Description
                        alert(id + " - " + idx + " - " + idDesc);
                        if (idx == "Repair") {
                            if (id == "Completed" || id == "Incomplete") {
                                window.location.href ="it_view_completed_incomplete_repair.php?requestID=" + row.getAttribute("id");
                            }
                            if (id == "Ongoing" || id == "Pending") {
                                window.location.href = "it_view_ongoing_pending_repair.php?requestID=" + row.getAttribute("id");
                            }
                        }
                        if (idx == "Asset Request") {
                            if (id == "Ongoing" || id == "Pending") {
                                if (idDesc == "Checking Canvas") {
                                    window.location.href = "it_view_canvas_completed.php?requestID=" + row.getAttribute("id");
                                } else if (idDesc == "IT Create Specs") {
                                    window.location.href = "it_view_incomplete_request.php?requestID=" + row.getAttribute("id");
                                } else if (idDesc == "Replacement needed") {
                                    window.location.href = "it_view_open_po.php?requestID=" + row.getAttribute("id");
                                } else if (idDesc == "Conforme pending") {
                                    window.location.href = "it_view_checklist.php";
                                }
                            }
                            if (id == "Completed" || id == "Incomplete") {
                                window.location.href = "it_view_checklist.php";
                            }
                        }
                        if (idx == "Testing") {
                            if (id == "Ongoing" || id == "Pending") {
                                window.location.href = "it_view_incomplete_testing.php";
                            } else if (id == "Completed" || id == "Incomplete") {
                                window.location.href = "it_view_testing.php";
                            }
                        }
                        if (idx == "Service Request") {
                            window.location.href = "it_view_service_request_form.php";
                        }
                        if (idx == "Donation") {
                            if (id == "Ongoing" || id == "Pending") {
                                window.location.href = "it_view_open_donation_request.php?id=" + row.getAttribute("id");
                            }
                            if (id == "Completed" || id == "Incomplete") {
                                window.location.href = "it_view_closed_donation_request.php?id=" + row.getAttribute("id");
                            }
                        }
                        if (idx == "Borrow") {
                            if (id == "Ongoing" || id == "Pending") {
                                window.location.href = "it_view_open_service_equipment_request.php";
                            } else if (id == "Completed" || id == "Incomplete") {
                                window.location.href = "it_view_closed_service_equipment_request.php";
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
    <script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
    <script src="js/dynamic_table_init.js"></script>



    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>