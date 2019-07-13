<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
	require_once("db/mysql_connect.php");
    
    $id = $_GET['id'];
    $start = $_GET['sDate'];
    $end = $_GET['eDate'];
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

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="panel">
                                        <header class="panel-heading">
                                            Detailed Asset Audit Report
                                        </header>
                                        <div align="right" style="padding-right:0.5%; padding-top:0.5%">
                                            <button class="btn btn-primary" onclick="printContent('report')"><i class="fa fa-print"></i> Print 
                                            </button>
                                        </div>

                                        <div id="report">
                                            <div align="center">
                                                <h3>Information and Technology Services Office</h3>
                                                <h3>Detailed Asset Audit Report</h3>
                                                <h4>
                                                    <?php 
                                                date_default_timezone_set('Asia/Manila');
                                                $timestamp = time();
                                                echo "\n"; 
                                                echo(date("F d, Y h:i:s A", $timestamp)); 
                                                ?>
                                                </h4>
                                            </div>

                                            <div class="panel-body">
                                                <section id="unseen">
                                                    <div class="adv-table">
                                                        <table class="display table table-bordered table-striped" id="tibol">
                                                            <thead>
                                                                <tr>
                                                                    <th>Date</th>
                                                                    <th>Property Code</th>
                                                                    <th>Brand</th>
                                                                    <th>Model</th>
                                                                    <th>Status</th>
                                                                    <th>Action Made</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                
                                                                $queryDept="SELECT aa.date, a.propertyCode, rb.name,  am.description AS `specs`, ras.description, e.name AS `employee` FROM thesis.assetaudit aa
                                                                JOIN asset a ON aa.assetID = a.assetID
                                                                JOIN assetmodel am ON a.assetModel = am.assetModelID
                                                                JOIN ref_assetstatus ras ON aa.assetStatus = ras.id
                                                                JOIN ref_brand rb ON am.brand = rb.brandID
                                                                JOIN employee e ON aa.UserID = e.UserID
                                                                WHERE am.assetCategory = {$id} AND (aa.date >= '{$start}' AND aa.date <= '{$end}');";

                                                                $resultDept=mysqli_query($dbc,$queryDept);
                                                                while($rowDept=mysqli_fetch_array($resultDept,MYSQLI_ASSOC)){
                                                                    echo "<tr>
                                                                        <td>{$rowDept['date']}</td>
                                                                        <td>{$rowDept['propertyCode']}</td>
                                                                        <td>{$rowDept['name']}</td>
                                                                        <td>{$rowDept['specs']}</td>
                                                                        <td>{$rowDept['description']}</td>
                                                                        <td>{$rowDept['employee']}</td>
                                                                        </tr>";
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </section>
                                            </div>
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

    <!--Core js-->
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


    <script>
        /*
        function addRowHandlers() {
            var table = document.getElementById("tibol");
            var rows = table.getElementsByTagName("tr");
            for (i = 1; i < rows.length; i++) {
                var currentRow = table.rows[i];
                var createClickHandler = function(row) {
                    return function() {
                        var cell = row.getElementsByTagName("td")[0];
                        var idx = cell.textContent;
                        window.location.href = "it_inventory_report_detailed.php?id=" + idx;

                    };
                };
                currentRow.ondblclick = createClickHandler(currentRow);
            }
        }
        window.onload = addRowHandlers();
        */

        function myFunction() {
            window.print();
        }
        
        function printContent(el){
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
        }
    </script>

</body>

</html>