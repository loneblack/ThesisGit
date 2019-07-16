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
    <link rel="stylesheet" href="js/morris-chart/morris.css">
    <!--dynamic table-->
    <link href="js/advanced-datatable/css/demo_page.css" rel="stylesheet" />
    <link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/data-tables/DT_bootstrap.css" />

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

                <div class="col-sm-12">
                    <div class="col-sm-12">

                        <div class="row">


                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="panel">
                                        <header class="panel-heading">
                                            Receive Assets from User
                                            <span class="tools pull-right">
                                                <a href="javascript:;" class="fa"></a>
                                            </span>
                                        </header>
                                        <div class="panel-body">

                                            <h4>Requestor: </h4>
                                            <h4>Date: </h4>
                                            <hr>

                                            <div class="adv-table">
                                                <table class="display table table-bordered table-striped" id="dynamic-table">
                                                    <thead>
                                                        <tr>
                                                        <td style='display: none'>ID</td>
                                                        <th>#</th>
                                                        <th>Type of Request</th>
                                                        <th>Date Made</th>
                                                        <td style='display: none'>StatusID</td>
                                                        <th>Status</th>
                                                        <th>Person Requested</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    //view for asset return
                                                    $query = "SELECT * FROM thesis.assetreturn a
                                                                JOIN ref_status rs 
                                                                ON a.statusID = rs.statusID
                                                                JOIN employee e 
                                                                ON a.UserID = e.UserID;";
                                                                  
                                                    $result = mysqli_query($dbc, $query);
                                                    $count = 1;
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                      
                                                      echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$row['assetReturnID']}</td>
                                                            <td>{$count}</td>
                                                            <td>Asset Return</td>
                                                            <td>{$row['dateTime']}</td>
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
                                                    //view for service Unit return
                                                    $query = "SELECT * FROM thesis.serviceunit su
                                                                JOIN employee e 
                                                                ON su.UserID = e.UserID
                                                                WHERE returned != 0;";
                                                                  
                                                    $result = mysqli_query($dbc, $query);
                                                    $count = 1;
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                      
                                                      echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$row['serviceUnitID']}</td>
                                                            <td>{$count}</td>
                                                            <td>Service Unit Return</td>
                                                            <td>{$row['dateReturn']}</td>
                                                            <td style='display: none'>{$row['returned']}</td>";

                                                        if($row['returned'] == '1'){//pending
                                                            echo "<td><span class='label label-warning'>Pending</span></td>";
                                                        }
                                                        if($row['returned'] == '2'){//ongoing
                                                            echo "<td><span class='label label-info'>Ongoing</span></td>";
                                                        }
                                                        if($row['returned'] == '3'){//completed
                                                            echo "<td><span class='label label-success'>Completed</span></td>";
                                                        }

                                                        echo "<td>{$row['name']}</td>";
                                                        echo "</tr>";

                                                          $count++;
                                                    }
                                                    
                                                  
                                                  ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div style="padding-left:10px; padding-bottom:5px">
                                            <button class="btn btn-success">Checkin</button>
                                            <button class="btn btn-danger" onclick="window.history.back()">Back</button>
                                        </div>
                                    </section>
                                </div>
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
            var table = document.getElementById("dynamic-table");
            var rows = table.getElementsByTagName("tr");
            for (i = 1; i < rows.length; i++) {
                var currentRow = table.rows[i];
                var createClickHandler = function(row) {
                    return function() {
                        var cell = row.getElementsByTagName("td")[0];
                        var id = cell.textContent;//id

                        var cell = row.getElementsByTagName("td")[2];
                        var returnType = cell.textContent; //return type

                        if(returnType == "Asset Return"){

                            window.location.href = "it_asset_receive_view.php?id="+id;
                        }
                        if(returnType == "Service Unit Return"){

                            window.location.href = "it_service_unit_receive_view.php?id="+id;
                        }


                    };
                };
                currentRow.onclick = createClickHandler(currentRow);
            }
        }
        window.onload = addRowHandlers();
    </script>

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