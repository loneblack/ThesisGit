<!DOCTYPE html>
<html lang="en">
<?php
require_once('db/mysql_connect.php');
session_start();
$userID = $_SESSION['userID'];
$_SESSION['previousPage'] = "requestor_send_service_unit.php";
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
        <?php include 'requestor_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->
                <div>
                <?php
                    if (isset($_SESSION['submitMessage'])){

                        if($_SESSION['submitStatus'] == 1){
                            $alert = "success";
                        }
                        else{
                            $alert = "danger";
                        }
                        echo "<div style='text-align:center' class='alert alert-".$alert."'>
                                <strong><h3>{$_SESSION['submitMessage']}</h3></strong>
                              </div>";

                        unset($_SESSION['submitMessage']);
                    }
                ?>
                </div>
                <div class="col-sm-12">
                    <div class="col-sm-12">

                        <div class="row">


                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="panel">

                                                <form method="post" action="requestor_send_service_unit_DB.php">
                                        <header class="panel-heading">
                                            Send Borrowed Service Units
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
                                                            <th>Specifications</th>
                                                            <th>Status</th>
                                                            <th>Comments</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                            $query="
                                                                SELECT *, rb.name as 'brandName'  
                                                                FROM thesis.serviceunit su
                                                                JOIN serviceunitassets sua ON sua.serviceUnitID = su.serviceUnitID
                                                                JOIN asset a ON sua.assetID = a.assetID
                                                                JOIN assetmodel am ON a.assetModel = am.assetModelID
                                                                JOIN ref_brand rb ON am.brand = rb.brandID
                                                                WHERE (`UserID` = '{$userID}')
                                                                AND (`su`.`received` = '1')
                                                                AND (`returned` = '0');";
                                                            $result=mysqli_query($dbc,$query);
                                                            while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                                                                echo "<tr>
                                                                    <td><input type='checkbox' name='assets[]' class='form-control' value ='{$row['assetID']}'>
                                                                        <input type='hidden' name='assets[]' value ='0'</td>
                                                                        <input type='hidden' name='serviceUnitID[]' value ='{$row['serviceUnitID']}'</td>
                                                                    <td>{$row['propertyCode']}</td>
                                                                    <td>{$row['brandName']}</td>
                                                                    <td>{$row['itemSpecification']}</td>    
                                                                    <td>
                                                                        <select class='form-control' name='status[]'>
                                                                            <option value = '1'>Working</option>
                                                                            <option value = '0'>Damaged</option>
                                                                        </select>
                                                                    </td>
                                                                    <td><input style='width:100%' type='text' class='form-control' name='comments[]'></td>
                                                                </tr>";
                                                            }
                                                        
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div style="padding-left:10px; padding-bottom:5px">
                                            <button type= "submit" class="btn btn-success">Send</button>
                                            <button type = "button" class="btn btn-danger" onclick="window.history.back();">Back</button>
                                        </div>
                                                </form>
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