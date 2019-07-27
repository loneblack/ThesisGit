<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
	require_once("db/mysql_connect.php");
    
    $start = $_POST['startDate'];
    $end = $_POST['endDate'];
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
                                        <div id="report">
                                        <div align="right">
                                            <?php 
                                                date_default_timezone_set('Asia/Manila');
                                                $timestamp = time();
                                                echo "\n"; 
                                                echo(date("F d, Y h:i:s A", $timestamp)); 
                                                ?>
                                        </div>
                                            <div align="center">
                                                <h3>Information and Technology Services Office</h3>
                                                <h3>Exception Report</h3>
                                                <h4>
                                                    <?php
                                                    
                                                    echo $start ."---". $end; 
                                                    
                                                    ?>
                                                </h4>
                                            </div>

                                            <div class="panel-body">
                                                <section id="unseen">
                                                    <div class="adv-table">
                                                        <table class="display table table-bordered table-striped" id="tibol">
                                                            <thead>
                                                                <tr>
                                                                    <th>Supplier</th>
                                                                    <th>Asset Category</th>
                                                                    <th>Total Items Bought</th>
                                                                    <th>Total Items Returned to Supplier</th>
                                                                    <th>Percentage of Total Items Returned</th>
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
                                                                        
                                                                        
                                                                        $returned = array();
                                                                        $query="SELECT COUNT(aa.assetStatus) AS `returned` FROM deliverydetails dd
                                                                        JOIN ref_assetcategory rac ON dd.ref_assetCategoryID = rac.assetCategoryID
                                                                        JOIN deliverydetailsassets dda ON dd.deliverydetailsID = dda.deliverydetails_deliverydetailsID
                                                                        JOIN assetaudit aa ON aa.assetID = dda.asset_assetID
                                                                        WHERE aa.assetStatus = '25'
                                                                        GROUP BY rac.name;
                                                                        ";
                                                        
                                                                        
                                                                        $result=mysqli_query($dbc,$query);
                                                                        $count = 0;
                                                                        $total = 0;
                                                                        while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                                                                                $returned[$count] = $row['returned'];
                                                                            $count++;
                                                                        }
                                                                        
                                                                        
                                                                        $queryDept="SELECT s.name AS `supplier`, rac.name AS `asset_cat`, SUM(dd.quantity) AS `requested` FROM deliverydetails dd
                                                                        LEFT JOIN delivery d ON d.id = dd.deliveryID
                                                                        LEFT JOIN procurement p ON d.procurementID = p.procurementID
                                                                        LEFT JOIN supplier s ON p.supplierID = s.supplierID
                                                                        LEFT JOIN ref_assetcategory rac ON dd.ref_assetCategoryID = rac.assetCategoryID
                                                                        LEFT JOIN procurementdetails pd ON p.procurementID = pd.procurementID
                                                                        GROUP BY rac.name;
                                                                        ";
                                                                        
                                                                        $req = array();
                                                                        $ret = 0;
                                                                        
                                                                        $resultDept=mysqli_query($dbc,$queryDept);
                                                                        $count = 0;
                                                                        while($rowDept=mysqli_fetch_array($resultDept,MYSQLI_ASSOC)){
                                                                            echo "<tr>
                                                                                <td>{$rowDept['supplier']}</td>
                                                                                <td>{$rowDept['asset_cat']}</td>
                                                                                <td>{$rowDept['requested']}</td>
                                                                                <td>";
                                                                                echo $returned[$count];
                                                                                
                                                                                echo "</td>";
                                                                                echo "<td align = 'right'>";
                                                                                echo $returned[$count]/$rowDept['requested'] * 100 ."%";
                                                                                
                                                                                "</td>
                                                                                </tr>";
                                                                        }
                                                                        
                                                                    }
                                                                }
															?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                        <div align="center">
                                                        <button class="btn btn-primary" onclick="printContent('report')"><i class="fa fa-print"></i> Print</button>
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
//        function addRowHandlers() {
//            var table = document.getElementById("tibol");
//            var rows = table.getElementsByTagName("tr");
//            for (i = 1; i < rows.length; i++) {
//                var currentRow = table.rows[i];
//                var createClickHandler = function(row) {
//                    return function() {
//                        var cell = row.getElementsByTagName("td")[0];
//                        var idx = cell.textContent;
//                        var cell2 = row.getElementsByTagName("td")[1];
//                        var sdate = cell2.textContent;
//                        var cell3 = row.getElementsByTagName("td")[2];
//                        var edate = cell3.textContent;
//                        window.location.href = "it_inventory_report_detailed.php?id=" + idx + "&sDate=" + sdate + "&eDate=" + edate;
//
//                    };
//                };
//                currentRow.ondblclick = createClickHandler(currentRow);
//            }
//        }
//        window.onload = addRowHandlers();

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