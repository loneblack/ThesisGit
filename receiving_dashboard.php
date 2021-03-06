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
                <div style="text-align: right; padding-bottom: 10px; padding-right:10px">
                    <button class="btn btn-primary" onclick="window.location.href='LoginReceive.php'">
                        Logout
                    </button> 
                </div>
            </div>

            </header>
            <!--header end-->
            <?php //include 'requestor_navbar.php' ?>

        <!--main content-->
        <section>
            <section class="wrapper">
                <!-- page start-->

                <div >
                    <div>
                        <div>
                            
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
                                                    <td style='display: none'>StatusID</td>
                                                    <th>Status</th>
                                                    <!-- <th>Description</th> -->
                                                </tr>
                                            </thead>

                                            <tbody>
  
                                                 <?php
                                                    $count = 1;
                                                    // view for purchase request

                                                    $query = "SELECT *, r.id as 'receivingID' FROM thesis.requestor_receiving r JOIN request b ON r.requestID = b.requestID JOIN ref_status s ON r.statusID = s.statusID WHERE r.statusID != 3 and r.UserID='{$userID}' AND deliveryDate IS NOT NULL;";
                                                                  
                                                    $result = mysqli_query($dbc, $query);
                                                    
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                      
                                                      echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$row['requestID']}</td>
                                                            <td style='display: none'>{$row['receivingID']}</td>
                                                            <td>{$count}</td>
                                                            <td>Asset Request</td>
                                                            <td style='display: none'>{$row['statusID']}</td>";

                                                        if($row['statusID'] == '1'){//pending
                                                            echo "<td><span class='label label-warning'>{$row['description']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '2'){//ongoing
                                                            echo "<td><span class='label label-info'>{$row['description']}</span></td>";
                                                        }
														if($row['statusID'] == '4'){
															echo "<td><span class='label label-danger'>{$row['description']}</span></td>";
														}
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

                                                    $query = "SELECT *, r.id as 'receivingID' FROM thesis.requestor_receiving r JOIN request_borrow b ON r.borrowID = b.borrowID JOIN ref_status s ON r.statusID = s.statusID WHERE r.statusID != 3 and b.personresponsibleID='{$userID}'AND deliveryDate IS NOT NULL;";
                                                                  
                                                    $result = mysqli_query($dbc, $query);
                                                    
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                      
                                                      echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$row['borrowID']}</td>
                                                            <td style='display: none'>{$row['receivingID']}</td>
                                                            <td>{$count}</td>
                                                            <td>Borrow</td>
                                                            <td style='display: none'>{$row['statusID']}</td>";

                                                        if($row['statusID'] == '1'){//pending
                                                            echo "<td><span class='label label-warning'>{$row['description']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '2'){//ongoing
                                                            echo "<td><span class='label label-info'>{$row['description']}</span></td>";
                                                        }
														if($row['statusID'] == '4'){
															echo "<td><span class='label label-danger'>{$row['description']}</span></td>";
														}


                                                        //echo "<td>{$row['name']}</td>";
                                                        echo "</tr>";

                                                        $count++;
                                                    }

                                                    
                                                  ?>
                                                  <?php
                                                    // view for service unit
                                                    $query = "SELECT *, r.id as 'receivingID' FROM thesis.requestor_receiving r JOIN serviceunit su ON r.serviceUnitID = su.serviceUnitID JOIN ref_status s ON r.statusID = s.statusID WHERE r.statusID != 3;";
                                                                  
                                                    $result = mysqli_query($dbc, $query);
                                                    
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                      
                                                      echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$row['serviceUnitID']}</td>
                                                            <td style='display: none'>{$row['receivingID']}</td>
                                                            <td>{$count}</td>
                                                            <td>Service Unit</td>
                                                            <td style='display: none'>{$row['statusID']}</td>";

                                                        if($row['statusID'] == '1'){//pending
                                                            echo "<td><span class='label label-warning'>{$row['description']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '2'){//ongoing
                                                            echo "<td><span class='label label-info'>{$row['description']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '4'){
                                                            echo "<td><span class='label label-danger'>{$row['description']}</span></td>";
                                                        }


                                                        //echo "<td>{$row['name']}</td>";
                                                        echo "</tr>";

                                                        $count++;
                                                    }

                                                    
                                                  ?>
                                                  <?php
                                                    // view for repair
                                                    $query = "SELECT *, r.id as 'receivingID' FROM thesis.requestor_receiving r JOIN service s ON r.serviceID = s.id JOIN ref_status rs ON r.statusID = rs.statusID WHERE r.statusID != 3 AND deliveryDate IS NOT NULL;";
                                                                  
                                                    $result = mysqli_query($dbc, $query);
                                                    
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                      
                                                      echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$row['serviceUnitID']}</td>
                                                            <td style='display: none'>{$row['receivingID']}</td>
                                                            <td>{$count}</td>
                                                            <td>Repair</td>
                                                            <td style='display: none'>{$row['statusID']}</td>";

                                                        if($row['statusID'] == '1'){//pending
                                                            echo "<td><span class='label label-warning'>{$row['description']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '2'){//ongoing
                                                            echo "<td><span class='label label-info'>{$row['description']}</span></td>";
                                                        }
                                                        if($row['statusID'] == '4'){
                                                            echo "<td><span class='label label-danger'>{$row['description']}</span></td>";
                                                        }


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
                                                    <td style='display: none'>StatusID</td>
                                                    <th>Status</th>
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
                    var id1 = cell1.textContent;

                    var cell = row.getElementsByTagName("td")[1];
                    var id2 = cell.textContent;

                    var cell = row.getElementsByTagName("td")[3];
                    var id3 = cell.textContent;

                    if(id3 == "Repair"){

                         window.location.href = "requestor_view_receiving_repair.php?id=" + id2;

                    }
                    else{

                        window.location.href = "requestor_view_receiving.php?id=" + id2;
                        
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