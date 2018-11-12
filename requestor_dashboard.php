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
                    Welcome Requestor!
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
                                                    <th>#</th>
                                                    <th>Type of Request</th>
                                                    <th>Date Made</th>
                                                    <th>Date Needed</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>

                                            <tbody>


                                                 <?php
                                                    $count = 1;

                                                    $query = "SELECT *, s.description as'statusName' FROM thesis.request r JOIN ref_status s ON r.status = s.statusID WHERE UserID = {$userID};";
                                                                  
                                                    $result = mysqli_query($dbc, $query);
                                                    
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                      
                                                      echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$row['requestID']}</td>
                                                            <td>{$count}</td>
                                                            <td>Request for Purchase</td>
                                                            <td>{$row['datetime']}</td>
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


                                                        echo "</tr>";

                                                          $count++;
                                                    }
                                                  ?>

                                                  <?php

                                                    $query = "SELECT * FROM thesis.service sr JOIN ref_status st ON sr.status = st.statusID WHERE UserID = {$userID};";
                                                                  
                                                    $result = mysqli_query($dbc, $query);
                                                    
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                      
                                                      echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$row['requestID']}</td>
                                                            <td>{$count}</td>
                                                            <td>Request for Service</td>
                                                            <td>{$row['dateReceived']}</td>
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


                                                        echo "</tr>";

                                                          $count++;
                                                    }
                                                  ?>

                                                  <?php

                                                    $sql = "SELECT * FROM `thesis`.`employee` WHERE UserID = {$userID};";//get the employeeID using userID
                                                    $result = mysqli_query($dbc, $sql);

                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                                        $employeeID = $row['employeeID'];
                                                        
                                                    }

                                                    $query = "SELECT * FROM thesis.request_borrow r JOIN ref_status s on r.statusID = s.statusID AND personresponsibleID = {$employeeID};";
                                                                  
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


                                                        echo "</tr>";

                                                          $count++;
                                                    }

                                                    
                                                  ?>


                                                <tr class="gradeA">
                                                    <td>1</td>
                                                    <td>Request for Service</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-warning">Pending</span></td>
                                                </tr>

                                                <tr class="gradeA">
                                                    <td>2</td>
                                                    <td>Need notHere</td>
                                                    <td>10/9/28</td>
                                                    <td>10/9/288</td>
                                                    <td><span class="label label-success">Completed</span></td>
                                                </tr>

                                                
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Type of Request</th>
                                                    <th>Date Made</th>
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
        $('#ctable').on('dblclick', function() {
            window.location.replace("requestor_view_request.php");
        })
    </script>


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>