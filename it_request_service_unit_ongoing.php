<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$userID = $_SESSION['userID'];
$id = $_GET['id'];
$_SESSION['previousPage'] = "it_request_service_unit?id={$id}";
require_once("db/mysql_connect.php");


$query =  "SELECT * FROM thesis.service s JOIN employee e ON s.UserID = e.UserID JOIN ref_status rs ON s.status = rs.statusID JOIN serviceunit su ON su.serviceID = s.id WHERE su.serviceUnitID = {$id};";
$result = mysqli_query($dbc, $query);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        
    }

$assets = array();
$assetCategoryID = array();

$query2 =  "SELECT *, s.assetID as 'IDasset' FROM thesis.serviceunitdetails s JOIN asset a ON s.assetID = a.assetID JOIN assetmodel am ON a.assetModel = am.assetModelID WHERE serviceUnitID = {$id};";
$result2 = mysqli_query($dbc, $query2);

while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
    array_push($assets, $row['IDasset']);
    array_push($assetCategoryID, $row['assetCategory']);
}
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
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datepicker/css/datepicker.css" />

    <link rel="stylesheet" type="text/css" href="js/select2/select2.css" />

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
                            <br>
                            <br>
                            <section class="panel">
                                <header style="padding-bottom:20px" class="panel-heading wht-bg">
                                    <?php
                                        if (isset($_SESSION['submitMessage'])){

                                            echo "<div style='text-align:center' class='alert alert-success'><h5><strong>
                                                    {$_SESSION['submitMessage']}
                                                  </strong></h5></div>";

                                            unset($_SESSION['submitMessage']);
                                        }
                                    ?>
                                    <h4 class="gen-case" style="float:right">
                                    </h4>
                                    <h4>Request For Service Unit</h4>
                                </header>
                                <div class="panel-body ">

                                    <div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <img src="images/chat-avatar2.jpg" alt="">
                                                <strong>Helpdesk</strong>
                                                to
                                                <strong>me</strong>
                                            </div>
                                            <div class="col-md-4">
                                                <button style="float:right" class="btn btn-info">Ongoing</button>
                                                <br>
                                                <br>
                                                <br>
                                                <h5>Date Created:
                                                </h5>
                                            </div>
                                            <div class="col-md-8">
                                                <h5>Comments:
                                                </h5>
                                            </div>
                                            <div class="cp;-col-md-4"></div>
                                        </div>
                                    </div>
                                    <div class="view-mail">
                                        <p>
                                        </p>
                                    </div>
                                </div>
                            </section>

                            <section class="panel">
                                <div class="panel-body">
                                    <h4>Assets to be Repaired</h4>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Property Code</th>
                                                <th>Asset/ Software Name</th>
                                                <th>Building</th>
                                                <th>Room</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                                    
                                        for ($i=0; $i < count($assets); $i++) { 

                                            
                                            $query3 =  "SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', c.name as 'category', itemSpecification, s.id, m.description, b.name as 'building', f.floorroom
                                                    FROM asset a 
                                                        JOIN assetModel m
                                                    ON assetModel = assetModelID
                                                        JOIN ref_brand br
                                                    ON brand = brandID
                                                        JOIN ref_assetcategory c
                                                    ON assetCategory = assetCategoryID
                                                        JOIN ref_assetstatus s
                                                    ON a.assetStatus = s.id
                                                        JOIN assetassignment aa
                                                    ON a.assetID = aa.assetID
                                                        JOIN building b
                                                    ON aa.BuildingID = b.BuildingID
                                                        JOIN floorandroom f
                                                    ON aa.FloorAndRoomID = f.FloorAndRoomID 
                                                        WHERE a.assetID = {$assets[$i]};";

                                            $result3 = mysqli_query($dbc, $query3);  

                                            while ($row = mysqli_fetch_array($result3, MYSQLI_ASSOC)){

                                               echo "
                                                <tr>
                                                <td>{$row['propertyCode']}</td>
                                                <td>{$row['brand']} {$row['category']} {$row['description']}</td>
                                                <td>{$row['building']}</td>
                                                <td>{$row['floorroom']}</td>
                                                <td style = 'display: none'><input type='number' name='assetID[]' value ='{$row['assetID']}'></td>
                                                </tr>";
                                            }  

                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>

                        </div>

                        <div class="col-sm-12">
                            <section class="panel">
                                <div class="panel-body ">
                                    <div>
                                        <h4>Service Unit to Be Given</h4>
                                    </div>

                                    <table class="table table-bordered table table-hover" id="addtable">
                                        <thead>
                                            <tr>
                                                <th style="display: none">AssetID</th>
                                                <th width="150">Property Code</th>
                                                <th>Category</th>
                                                <th>Brand</th>
                                                <th>Model</th>
                                                <th>Specification</th>
                                            </tr>
                                        </thead>
                                        <form method ="post" action="it_request_service_unit_DB.php?=<?php echo $id;?>">
                                        <tbody>
                                        <?php

                                            $query3 = " SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', c.name as 'category', itemSpecification,  m.description 
                                                            FROM thesis.serviceunitassets sa
                                                        JOIN asset a 
                                                            ON a.assetID = sa.assetID
                                                        JOIN assetModel m
                                                            ON assetModel = assetModelID
                                                        JOIN ref_brand br
                                                            ON brand = brandID
                                                        JOIN ref_assetcategory c
                                                            ON assetCategory = assetCategoryID
                                                        WHERE id = {$id};";
                                            $result3 = mysqli_query($dbc, $query3);  

                                            while ($row = mysqli_fetch_array($result3, MYSQLI_ASSOC)){

                                               echo "
                                                <tr>
                                                <td>{$row['propertyCode']}</td>
                                                <td>{$row['category']}</td>
                                                <td>{$row['brand']}</td>
                                                <td>{$row['description']}</td>
                                                <td>{$row['itemSpecification']}</td>
                                                </tr>";
                                            }  
                                        ?>
                                        </tbody>
                                    </table>
                                    <input style="display: none" type="number" id="count" name="count">
                                </div>
                            </section>
                            </form>
                            <a href="it_dashboard.php"><button type="button" class="btn btn-danger">Back</button></a>
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
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script src="js/jquery-ui-1.9.2.custom.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>
    <script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
    <script src="js/dynamic_table_init.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/advanced-form.js"></script>

</body>

</html>
