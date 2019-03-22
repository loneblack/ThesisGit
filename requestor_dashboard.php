<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$userID = $_SESSION['userID'];
require_once("db/mysql_connect.php");
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
    <link rel="stylesheet" href="js/data-tables/DT_bootstrap.css" />
    <link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />

    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <script src = "http://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src = "http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</head>

        <?php
            $count = 1;
            $query = "SELECT e.name AS `naame` FROM employee e JOIN user u ON e.userID = u.userID WHERE e.userID = {$userID};";
            $result = mysqli_query($dbc, $query);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $name = $row['naame'];
        ?>    
    
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
                <h4>Welcome! <?php echo $name; ?></h4>
            </div>

        </header>
        <!--header end-->
        <?php include 'requestor_navbar.php' ?>

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
                                </header>
                                <div class="panel-body">
                                    <div class="adv-table" id="ctable">
                                        <table class="display table table-bordered table-striped" id="dynamic-table">
                                            <thead>
                                                <tr>
                                                    <td style='display: none'>ID</td>
                                                    <th>#</th>
                                                    <th>Type of Request</th>
                                                    <th>Date Made</th>
                                                    <th>Date Needed</th>
                                                    <td style='display: none'>StatusID</td>
                                                    <th>Status</th>
                                                    <th>Details</th>
                                                    <!-- <th>Description</th> -->
                                                </tr>
                                            </thead>

                                            <tbody>


                                                
                                                 <?php
                                                    // view for purchase request
                                                    $count = 1;

                                                    $query = "SELECT *, r.description as 'details', s.description as `statusName`,rs.name as `step`
                                                              FROM thesis.request r
                                                              JOIN ref_status s ON r.status = s.statusID
														      JOIN ref_steps rs on r.step=rs.id
															  WHERE UserID = {$userID};";
                                                                  
                                                    $result = mysqli_query($dbc, $query);
                                                    
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                      
                                                      echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$row['requestID']}</td>
                                                            <td>{$count}</td>
                                                            <td>Asset Request</td>
                                                            <td>{$row['date']}</td>
                                                            <td>{$row['dateNeeded']}</td>
                                                            <td style='display: none'>{$row['statusID']}</td>";

                                                        if($row['statusID'] == '1'){//pending
                                                            echo "<td><span class='label label-warning'>{$row['statusName']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '2'){//ongoing
                                                            echo "<td><span class='label label-info'>{$row['step']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '3'){//completed
                                                            echo "<td><span class='label label-success'>{$row['statusName']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '6'){//disapproved
															echo "<td><span class='label label-danger'>{$row['step']}</span></td>";
                                                        }
														echo "<td>{$row['details']}</td>";

                                                        $count++;
                                                    }
                                                  ?>

                                                  <?php
                                                    //view for service
                                                    $query = "SELECT *, sr.id as'serviceID' FROM thesis.service sr   
                                                              JOIN ref_status st ON sr.status = st.statusID 
                                                              JOIN ref_steps s ON steps = s.id
                                                              WHERE UserID = {$userID};";
                                                                  
                                                    $result = mysqli_query($dbc, $query);
                                                    
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                      
                                                        echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$row['serviceID']}</td>
                                                            <td>{$count}</td>";
                                                            
                                                        if($row['serviceType']=='27') echo "<td>Repair</td>";
                                                        else echo "<td>Service</td>";
                                                        echo "<td>{$row['dateReceived']}</td>
                                                            <td>{$row['dateNeed']}</td>
                                                            <td style='display: none'>{$row['statusID']}</td>";

                                                        if($row['statusID'] == '1'){//pending
                                                            echo "<td><span class='label label-warning'>{$row['description']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '2'){//ongoing
                                                            echo "<td><span class='label label-info'>{$row['name']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '3'){//completed
                                                            echo "<td><span class='label label-success'>{$row['description']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '4'){//disapproved
                                                            echo "<td><span class='label label-danger'>{$row['description']}</span></td>";
                                                        }

                                                        echo "<td>{$row['details']}</td>";
                                                        echo "</tr>";

                                                          $count++;
                                                    }
                                                  ?>

                                                  <?php
                                                    // view for borrow
                                                    $sql = "SELECT * FROM `thesis`.`employee` WHERE UserID = {$userID};";//get the employeeID using userID
                                                    $result = mysqli_query($dbc, $sql);

                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                                        $employeeID = $row['employeeID'];
                                                        
                                                    }

                                                    $query = "SELECT * FROM thesis.request_borrow r 
                                                              JOIN ref_status s ON r.statusID = s.statusID
                                                              JOIN ref_steps t ON r.steps = t.id
                                                              AND personresponsibleID = {$employeeID};";
                                                                  
                                                    $result = mysqli_query($dbc, $query);
                                                    
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                      
                                                      echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$row['borrowID']}</td>
                                                            <td>{$count}</td>
                                                            <td>Borrow</td>
                                                            <td>{$row['dateCreated']}</td>
                                                            <td>{$row['startDate']}</td>
                                                            <td style='display: none'>{$row['statusID']}</td>";

                                                        if($row['statusID'] == '1'){//pending
                                                            echo "<td><span class='label label-warning'>{$row['description']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '2'){//ongoing
                                                            echo "<td><span class='label label-info'>{$row['name']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '3'){//completed
                                                            echo "<td><span class='label label-success'>{$row['description']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '6'){//disapproved
                                                            echo "<td><span class='label label-danger'>{$row['description']}</span></td>";
                                                        }


                                                        echo "<td>{$row['purpose']}</td>";
                                                        echo "</tr>";

                                                        $count++;
                                                    }

                                                    
                                                  ?>
                                                  <?php
                                                    // view for donation
                                                  
                                                    $sql = "SELECT * FROM `thesis`.`employee` WHERE UserID = {$userID};";//get the employeeID using userID
                                                    $result = mysqli_query($dbc, $sql);

                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                                        $employeeID = $row['employeeID'];
                                                        
                                                    }

                                                    $query = "SELECT * FROM thesis.donation d 
                                                              JOIN ref_status s ON d.statusID = s.statusID
                                                              JOIN ref_steps ON stepsID = id 
                                                              WHERE user_UserID = {$userID}";
                                                                  
                                                    $result = mysqli_query($dbc, $query);
                                                    
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                      
                                                      echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$row['donationID']}</td>
                                                            <td>{$count}</td>
                                                            <td>Donation</td>
                                                            <td>{$row['dateNeed']}</td>
                                                            <td>{$row['dateNeed']}</td>
                                                            <td style='display: none'>{$row['statusID']}</td>";

                                                        if($row['statusID'] == '1'){//pending
                                                            echo "<td><span class='label label-warning'>{$row['description']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '2'){//ongoing
                                                            echo "<td><span class='label label-info'>{$row['name']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '3'){//completed
                                                            echo "<td><span class='label label-success'>{$row['description']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '4'){//disapproved
                                                            echo "<td><span class='label label-danger'>{$row['description']}</span></td>";
                                                        }


                                                        echo "<td></td>";
                                                        echo "</tr>";

                                                          $count++;
                                                    }

                                                  ?>
												  <?php
													//GET ALL REQUEST SCHEDULE FOR DELIVERY (REQUEST TO PURCHASE AN ASSET)
													$query = "SELECT rr.id,r.date,r.dateNeeded,s.description,rr.statusID FROM thesis.requestor_receiving rr join request r on rr.requestID=r.requestID
																				  join ref_status s ON rr.statusID = s.statusID
																				  where rr.borrowID is null and rr.statusID!='3' and r.UserID='{$_SESSION['userID']}'";
                                                                  
                                                    $result = mysqli_query($dbc, $query);
                                                    
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                      
                                                      echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$row['id']}</td>
                                                            <td>{$count}</td>
                                                            <td>Delivery Request for Asset Purchase</td>
                                                            <td>{$row['date']}</td>
                                                            <td>{$row['dateNeeded']}</td>
                                                            <td style='display: none'>{$row['statusID']}</td>";

                                                        if($row['statusID'] == '1'){//pending
                                                            echo "<td><span class='label label-warning'>Schedule For Delivery</span></td>";
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

														echo "<td></td>";
                                                        //echo "<td>{$row['name']}</td>";
                                                        echo "</tr>";

                                                          $count++;
                                                    }
													
												  
												  ?>

													<?php
													//GET ALL REQUEST SCHEDULE FOR DELIVERY (REQUEST TO BORROW)
													$query = "SELECT rr.id,rb.dateCreated,rb.startDate,s.description,rr.statusID FROM thesis.requestor_receiving rr join request_borrow rb on rr.borrowID=rb.borrowID
																				  join ref_status s ON rr.statusID = s.statusID 
																				  where rr.requestID is null and rr.statusID!='3'";
                                                                  
                                                    $result = mysqli_query($dbc, $query);
                                                    
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                      
                                                      echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$row['id']}</td>
                                                            <td>{$count}</td>
                                                            <td>Delivery Request for Borrow</td>
                                                            <td>{$row['dateCreated']}</td>
                                                            <td>{$row['startDate']}</td>
                                                            <td style='display: none'>{$row['statusID']}</td>";

                                                        if($row['statusID'] == '1'){//pending
                                                            echo "<td><span class='label label-warning'>Schedule For Delivery</span></td>";
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

														echo "<td></td>";
                                                        //echo "<td>{$row['name']}</td>";
                                                        echo "</tr>";

                                                          $count++;
                                                    }
													
												  
												  ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style='display: none'>ID</td>
                                                    <th>#</th>
                                                    <th>Type of Request</th>
                                                    <th>Date Made</th>
                                                    <th>Date Needed</th>
                                                    <td style='display: none'>StatusID</td>
                                                    <th>Status</th>
                                                    <th>Details</th>
                                                    <!-- <th>Description</th> -->
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

                   var cell1 = row.getElementsByTagName("td")[0];
                    var id = cell1.textContent;

                    var cell = row.getElementsByTagName("td")[2];
                    var requestType = cell.textContent;
                    
					var cell2 = row.getElementsByTagName("td")[6];
                    var step = cell2.textContent;
					
                    if(requestType == 'Asset Request'){
						if(step == "Conforme Pending"){
							window.location.href = "requestor_service_request_form_conforme.php?id=" + id +"&requestType=" + requestType;
						}
						else if(step == "IT Office Disapproved Request"){
							window.location.href = "requestor_view_disapproved_request_for_procurement.php?id=" + id;
						}
						else{
							window.location.href = "requestor_view_request_for_procurement_service_material.php?id=" + id;
						}
                    }

                    else if(requestType == "Borrow"){
						if(step == "Conforme Pending"){
							window.location.href = "requestor_service_request_form_conforme.php?id=" + id +"&requestType=" + requestType;
						}
						else{
							window.location.href = "requestor_view_service_equipment_request.php?id=" + id;
						}
                    }
                    
                    else if(requestType == "Donation"){
                        if(step == "Conforme Pending"){
							window.location.href = "requestor_service_request_form_conforme.php?id=" + id +"&requestType=" + requestType;
						}
						else{
							window.location.href = "requestor_view_donation_request.php?id=" + id;
						}
                    }

                    else if(requestType == "Service" || requestType == "Repair"){
						if(step == "Conforme Pending"){
							window.location.href = "requestor_service_request_form_conforme.php?id=" + id +"&requestType=" + requestType;
						}
						else{
							window.location.href = "requestor_view_service_request.php?id=" + id;
						}
                        
                    }
					else if(requestType == "Delivery Request for Asset Purchase"){
						if(step == "Schedule For Delivery"){
							window.location.href = "requestor_scheduling_request_for_procurement_service_material.php?id=" + id;
						}
					}
                    else if(requestType == "Delivery Request for Borrow"){
						if(step == "Schedule For Delivery"){
							window.location.href = "requestor_scheduling_request_for_borrow.php?id=" + id;
						}
					}
                };
            };
            currentRow.onclick = createClickHandler(currentRow);
        }
    }
    window.onload = addRowHandlers();
    </script>

    <script>
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
   </script>

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