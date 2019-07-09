<!DOCTYPE html>
<html lang="en">
<?php
require_once('db/mysql_connect.php');
session_start();
$userID = $_SESSION['userID'];
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
                                            Send Borrowed Assets
                                            <span class="tools pull-right">
                                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                            </span>
                                        </header>
                                        <div class="panel-body">
                                            
                                            <div class="adv-table">
                                                <table class="display table table-bordered table-striped" id="dynamic-table">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Property Code</th>
                                                            <th>Brand</th>
                                                            <th>Model</th>
                                                            <th>Expected Return Date</th>
                                                            <th>Status</th>
                                                            <th>Comments</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                            $count = 1;
                                                            $query="
                                                                SELECT a.propertyCode, rb.name AS 'brand', am.description AS 'model', b.name, f.floorRoom, aa.startdate, aa.enddate, rs.description FROM thesis.assetassignment aa
                                                                JOIN building b ON aa.BuildingID = b.buildingID
                                                                JOIN floorandroom f ON aa.FloorAndRoomID = f.FloorAndRoomID
                                                                JOIN employee e ON aa.personresponsibleID = e.employeeID
                                                                JOIN asset a ON aa.assetID = a.assetID
                                                                JOIN ref_assetstatus rs ON a.assetStatus = rs.id
                                                                JOIN assetmodel am ON a.assetModel = am.assetModelID
                                                                JOIN ref_brand rb ON am.brand = rb.brandID
                                                                WHERE (personresponsibleID = {$userID});";
                                                            $result=mysqli_query($dbc,$query);
                                                            while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                                                                echo "<tr>
                                                                    <td><input type='checkbox'></td>
                                                                    <td>{$row['propertyCode']}</td>
                                                                    <td>{$row['brand']}</td>
                                                                    <td>{$row['model']}</td>
                                                                    <td>{$row['enddate']}</td>
                                                                    <td>{$row['description']}</td>
                                                                    <td>{$row['floorRoom']}</td>
                                                                </tr>";
                                                                $count++;
                                                            }
                                                        
                                                        
                                                        
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div style="padding-left:10px; padding-bottom:5px">
                                            <button class="btn btn-success">Checkin</button>
                                            <a href="it_bulk_checkin.php"><button class="btn btn-danger">Back</button></a>
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