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
                                                    <th>Description</th>
                                                </tr>
                                            </thead>

                                            <tbody>


                                                
                                                 <?php
                                                    // view for purchase request
                                                    $count = 1;

                                                    $query = "SELECT *, s.description as `statusName`,rs.name as `step`
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
                                                            echo "<td><span class='label label-info'>{$row['statusName']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '3'){//completed
                                                            echo "<td><span class='label label-success'>{$row['statusName']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '4'){//disapproved
                                                            echo "<td><span class='label label-danger'>{$row['statusName']}</span></td>";
                                                        }
														echo "<td>{$row['step']}</td>";

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
                                                            echo "<td><span class='label label-info'>{$row['description']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '3'){//completed
                                                            echo "<td><span class='label label-success'>{$row['description']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '4'){//disapproved
                                                            echo "<td><span class='label label-danger'>{$row['description']}</span></td>";
                                                        }

                                                        echo "<td>{$row['name']}</td>";
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
                                                            echo "<td><span class='label label-info'>{$row['description']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '3'){//completed
                                                            echo "<td><span class='label label-success'>{$row['description']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '4'){//disapproved
                                                            echo "<td><span class='label label-danger'>{$row['description']}</span></td>";
                                                        }


                                                        echo "<td>{$row['steps']}</td>";
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
                                                            echo "<td><span class='label label-info'>{$row['description']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '3'){//completed
                                                            echo "<td><span class='label label-success'>{$row['description']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '4'){//disapproved
                                                            echo "<td><span class='label label-danger'>{$row['description']}</span></td>";
                                                        }


                                                        echo "<td>{$row['name']}</td>";
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
                                                    <th>Description</th>
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
                    
					var cell2 = row.getElementsByTagName("td")[7];
                    var step = cell2.textContent;
					
                    if(requestType == 'Asset Request'){
						if(step == "Conforme Pending"){
							window.location.href = "requestor_service_request_form_conforme.php?id=" + id +"&requestType=" + requestType;
						}
						else{
							window.location.href = "requestor_view_request_for_procurement_service_material.php?id=" + id;
						}
                    }

                    else if(requestType == "Borrow"){
                        window.location.href = "requestor_view_service_equipment_request.php?id=" + id;
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
                        window.location.href = "requestor_view_service_request.php?id=" + id;
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
    <script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
    <script src="js/dynamic_table_init.js"></script>


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>