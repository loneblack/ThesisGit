<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
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
                                            Asset Audit Report
                                        </header>
                                        <div align="right">
                                            <button class="btn btn-primary" onclick="printContent('report')"><i class="fa fa-print"></i> Print</button>
                                        </div>

                                        <div id="report">
                                            <div align="center">
                                                <h3>Information and Technology Services Office</h3>
                                                <h3>Asset Audit Report</h3>
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
                                                        <table class="display table table-bordered table-striped" id="">
                                                            <thead>
                                                                <tr>
                                                                    <th class="hidden"></th>
                                                                    <th>Action</th>
                                                                    <th>Date</th>
                                                                    <th>Asset Category</th>
                                                                    <th>Property Code</th>
                                                                    <th>Brand</th>
                                                                    <th>Model</th>
                                                                    <th>Building</th>
                                                                    <th>Room Number</th>
                                                                    <th>Office/ Department</th>
                                                                    <th>User's Name</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                            
                                                                if(isset($_POST['startDate']) && isset($_POST['endDate'])){
                                                                    if($_POST['startDate'] > $_POST['endDate']){
                                                                        $message = "The End Date Must be Bigger than the Start Date";
                                                                        echo "<script type='text/javascript'>alert('$message');</script>";
                                                                    }
                                                                    
                                                                    else{
                                                                        $sDate = $_POST['startDate'];
                                                                        $eDate = $_POST['endDate'];
                                                                        
                                                                        $queryDept="SELECT aa.id AS assetID, ras.description AS assetStatus, aa.date, a.propertyCode, rac.name AS assetCategory, rb.name AS brand,
                                                                        am.description AS model, b.name AS building, far.floorRoom, d.name AS department, e.name AS employee FROM assetaudit aa
                                                                        JOIN ref_assetStatus ras ON aa.assetStatus = ras.id
                                                                        JOIN asset a ON aa.assetID = a.assetID
                                                                        JOIN assetmodel am ON a.assetModel = am.assetModelID
                                                                        JOIN ref_assetcategory rac ON am.assetCategory = rac.assetCategoryID
                                                                        JOIN ref_brand rb ON am.brand = rb.brandID
                                                                        JOIN assetassignment assass ON a.assetID = assass.assetID
                                                                        JOIN building b ON assass.BuildingID = b.BuildingID
                                                                        JOIN floorandroom far ON assass.FloorAndRoomID = far.FloorAndRoomID
                                                                        LEFT JOIN department d ON assass.DepartmentID = d.DepartmentID
                                                                        JOIN employee e ON assass.personresponsibleID = e.UserID WHERE aa.date BETWEEN '{$sDate}' AND '{$eDate}';";

                                                                        $resultDept=mysqli_query($dbc,$queryDept);
                                                                        while($rowDept=mysqli_fetch_array($resultDept,MYSQLI_ASSOC)){
                                                                            echo "<tr>
                                                                                <td class='hidden'>{$rowDept['assetID']}</td>
                                                                                <td>{$rowDept['assetStatus']}</td>
                                                                                <td>{$rowDept['date']}</td>
                                                                                <td>{$rowDept['assetCategory']}</td>
                                                                                <td>{$rowDept['propertyCode']}</td>
                                                                                <td>{$rowDept['brand']}</td>
                                                                                <td>{$rowDept['model']}</td>
                                                                                <td>{$rowDept['building']}</td>
                                                                                <td>{$rowDept['floorRoom']}</td>
                                                                                <td>{$rowDept['department']}</td>
                                                                                <td>{$rowDept['employee']}</td>
                                                                                </tr>";
                                                                        }
                                                                    }
                                                                }
                                                            
                                                                if(empty($_POST['startDate']) && empty($_POST['endDate'])){
                                                                    $queryDept="SELECT aa.id AS assetID, ras.description AS assetStatus, aa.date, a.propertyCode, rac.name AS assetCategory, rb.name AS brand,
                                                                        am.description AS model, b.name AS building, far.floorRoom, d.name AS department, e.name AS employee FROM assetaudit aa
                                                                        JOIN ref_assetStatus ras ON aa.assetStatus = ras.id
                                                                        JOIN asset a ON aa.assetID = a.assetID
                                                                        JOIN assetmodel am ON a.assetModel = am.assetModelID
                                                                        JOIN ref_assetcategory rac ON am.assetCategory = rac.assetCategoryID
                                                                        JOIN ref_brand rb ON am.brand = rb.brandID
                                                                        JOIN assetassignment assass ON a.assetID = assass.assetID
                                                                        JOIN building b ON assass.BuildingID = b.BuildingID
                                                                        JOIN floorandroom far ON assass.FloorAndRoomID = far.FloorAndRoomID
                                                                        LEFT JOIN department d ON assass.DepartmentID = d.DepartmentID
                                                                        JOIN employee e ON assass.personresponsibleID = e.UserID;";

                                                                        $resultDept=mysqli_query($dbc,$queryDept);
                                                                        while($rowDept=mysqli_fetch_array($resultDept,MYSQLI_ASSOC)){
                                                                            echo "<tr>
                                                                                <td class='hidden'>{$rowDept['assetID']}</td>
                                                                                <td>{$rowDept['assetStatus']}</td>
                                                                                <td>{$rowDept['date']}</td>
                                                                                <td>{$rowDept['assetCategory']}</td>
                                                                                <td>{$rowDept['propertyCode']}</td>
                                                                                <td>{$rowDept['brand']}</td>
                                                                                <td>{$rowDept['model']}</td>
                                                                                <td>{$rowDept['building']}</td>
                                                                                <td>{$rowDept['floorRoom']}</td>
                                                                                <td>{$rowDept['department']}</td>
                                                                                <td>{$rowDept['employee']}</td>
                                                                                </tr>";
                                                                        }
                                                                }
                                                                
                                                            
                                                                if(isset($_POST['startDate']) && empty($_POST['endDate'])){
                                                                    
                                                                        $sDate = $_POST['startDate'];
                                                                        
                                                                        $queryDept="SELECT aa.id AS assetID, ras.description AS assetStatus, aa.date, a.propertyCode, rac.name AS assetCategory, rb.name AS brand,
                                                                        am.description AS model, b.name AS building, far.floorRoom, d.name AS department, e.name AS employee FROM assetaudit aa
                                                                        JOIN ref_assetStatus ras ON aa.assetStatus = ras.id
                                                                        JOIN asset a ON aa.assetID = a.assetID
                                                                        JOIN assetmodel am ON a.assetModel = am.assetModelID
                                                                        JOIN ref_assetcategory rac ON am.assetCategory = rac.assetCategoryID
                                                                        JOIN ref_brand rb ON am.brand = rb.brandID
                                                                        JOIN assetassignment assass ON a.assetID = assass.assetID
                                                                        JOIN building b ON assass.BuildingID = b.BuildingID
                                                                        JOIN floorandroom far ON assass.FloorAndRoomID = far.FloorAndRoomID
                                                                        LEFT JOIN department d ON assass.DepartmentID = d.DepartmentID
                                                                        JOIN employee e ON assass.personresponsibleID = e.UserID WHERE aa.date BETWEEN '{$sDate}' AND '3000-1-1';";

                                                                        $resultDept=mysqli_query($dbc,$queryDept);
                                                                        while($rowDept=mysqli_fetch_array($resultDept,MYSQLI_ASSOC)){
                                                                            echo "<tr>
                                                                                <td class='hidden'>{$rowDept['assetID']}</td>
                                                                                <td>{$rowDept['assetStatus']}</td>
                                                                                <td>{$rowDept['date']}</td>
                                                                                <td>{$rowDept['assetCategory']}</td>
                                                                                <td>{$rowDept['propertyCode']}</td>
                                                                                <td>{$rowDept['brand']}</td>
                                                                                <td>{$rowDept['model']}</td>
                                                                                <td>{$rowDept['building']}</td>
                                                                                <td>{$rowDept['floorRoom']}</td>
                                                                                <td>{$rowDept['department']}</td>
                                                                                <td>{$rowDept['employee']}</td>
                                                                                </tr>";
                                                                    }
                                                                }
                                                            
                                                                if(empty($_POST['startDate']) && isset($_POST['endDate'])){
                                                                    
                                                                        $eDate = $_POST['endDate'];
                                                                        
                                                                        $queryDept="SELECT aa.id AS assetID, ras.description AS assetStatus, aa.date, a.propertyCode, rac.name AS assetCategory, rb.name AS brand,
                                                                        am.description AS model, b.name AS building, far.floorRoom, d.name AS department, e.name AS employee FROM assetaudit aa
                                                                        JOIN ref_assetStatus ras ON aa.assetStatus = ras.id
                                                                        JOIN asset a ON aa.assetID = a.assetID
                                                                        JOIN assetmodel am ON a.assetModel = am.assetModelID
                                                                        JOIN ref_assetcategory rac ON am.assetCategory = rac.assetCategoryID
                                                                        JOIN ref_brand rb ON am.brand = rb.brandID
                                                                        JOIN assetassignment assass ON a.assetID = assass.assetID
                                                                        JOIN building b ON assass.BuildingID = b.BuildingID
                                                                        JOIN floorandroom far ON assass.FloorAndRoomID = far.FloorAndRoomID
                                                                        LEFT JOIN department d ON assass.DepartmentID = d.DepartmentID
                                                                        JOIN employee e ON assass.personresponsibleID = e.UserID WHERE aa.date BETWEEN '1000-1-1' AND '{$eDate}';";

                                                                        $resultDept=mysqli_query($dbc,$queryDept);
                                                                        while($rowDept=mysqli_fetch_array($resultDept,MYSQLI_ASSOC)){
                                                                            echo "<tr>
                                                                                <td class='hidden'>{$rowDept['assetID']}</td>
                                                                                <td>{$rowDept['assetStatus']}</td>
                                                                                <td>{$rowDept['date']}</td>
                                                                                <td>{$rowDept['assetCategory']}</td>
                                                                                <td>{$rowDept['propertyCode']}</td>
                                                                                <td>{$rowDept['brand']}</td>
                                                                                <td>{$rowDept['model']}</td>
                                                                                <td>{$rowDept['building']}</td>
                                                                                <td>{$rowDept['floorRoom']}</td>
                                                                                <td>{$rowDept['department']}</td>
                                                                                <td>{$rowDept['employee']}</td>
                                                                                </tr>";
                                                                    }
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
        $('#dynamic-table').on('click', function() {
            $('.brandID').on('click', function() {
                var a = this.getAttribute("id");
                window.location.href = "it_edit_brand.php?brandID=" + a;
            })
        })

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