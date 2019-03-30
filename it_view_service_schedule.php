<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$userID = $_SESSION['userID'];
require_once("db/mysql_connect.php");
$id = $_GET['id'];   
$_SESSION['previousPage'] = "it_view_service_replacement.php?id=".$id;

$query =  "SELECT *, s.userID as 'usr' FROM thesis.requestparts r JOIN service s ON r.serviceID = s.id WHERE r.id = {$id};";
$result = mysqli_query($dbc, $query);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        
        $replacementUnit = $row['replacementUnit'];
        $serviceID = $row['serviceID'];    
        $userID = $row['usr'];
        
    }
$query =  "SELECT *, b.name as 'building' FROM thesis.employee e JOIN floorandroom f ON e.FloorAndRoomID = f.FloorAndRoomID JOIN building b ON f.BuildingID = b.BuildingID WHERE e.UserID = '{$userID}';";
$result = mysqli_query($dbc, $query);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        
        $building = $row['building'];
        $floorroom = $row['floorRoom'];   

    }
$assetCategories = array();
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

                <form method='post' action="it_replacement_DB.php?id=<?phph echo $serviceID;?>">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">
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
                                    
                                    <h4>View Service Details</h4>
                                </header>
                                <div class="panel-body">
                                    <h4>Requestor Assets to be scheduled for delivery</h4>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Property Code</th>
                                                <th>Asset</th>
                                                <th>Building</th>
                                                <th>Room</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $_SESSION['isServiceUnit'] = 0;
                                            
                                            $sql = "SELECT *, c.name as'category', b.name as'brand' FROM thesis.servicedetails sd 
                                                        JOIN asset a 
                                                    ON sd.asset = a.assetID
                                                        JOIN assetModel m
                                                    ON assetModel = assetModelID
                                                        JOIN ref_brand b
                                                    ON brand = brandID
                                                        JOIN ref_assetcategory c
                                                    ON assetCategory = assetCategoryID
                                                        JOIN ref_assetstatus s
                                                    ON a.assetStatus = s.id
                                                        WHERE serviceID = '{$id}'
                                                    AND replaced != 1;";

                                            $result = mysqli_query($dbc, $sql);
                                            
                                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

                                            echo "<tr>
                                                <td>{$row['propertyCode']}</td>
                                                <td>{$row['brand']} {$row['category']} {$row['itemSpecification']}</td>
                                                <td>{$building}</td>
                                                <td>{$floorroom}</td>
                                                <td style = 'display: none'><input type='number' name='assetID[]' value ='{$row['assetID']}'></td>
                                                </tr>";

                                            array_push($assetCategories, $row['assetCategory']);
                                            }
                                            
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>

                        </div>


                        <div class="col-sm-3">

                            
                        </div>

                        <div class="col-sm-12">
                            <button type="button" class="btn btn-danger" onclick="window.history.back();">Back</button>
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
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>

    <script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
        var count = 0;

        function removeRow(o) {
            var p = o.parentNode.parentNode;
            p.parentNode.removeChild(p);
        }

        function addTest(cavasItemID) {
            var row_index = 0;
            var canvasItemID = cavasItemID;
            var isRenderd = false;

            $("td").click(function() {
                row_index = $(this).parent().index();

            });

            var delayInMilliseconds = 0; //1 second

            setTimeout(function() {

                appendTableRow(row_index, canvasItemID);
            }, delayInMilliseconds);

        }
        function loadDetails(val, id){
            
            $.ajax({
            type:"POST",
            url:"loadDetails1.php",
            data: 'assetID='+val,
            success: function(data){
                $("#brand"+id).html(data);

                }
            });
            $.ajax({
            type:"POST",
            url:"loadDetails2.php",
            data: 'assetID='+val,
            success: function(data){
                $("#description"+id).html(data);

                }
            });
            $.ajax({
            type:"POST",
            url:"loadDetails3.php",
            data: 'assetID='+val,
            success: function(data){
                $("#specification"+id).html(data);

                }
            });
            $.ajax({
            type:"POST",
            url:"loadDetails4.php",
            data: 'assetID='+val,
            success: function(data){
                $("#assetID"+id).html(data);

                }
            });
        }
    </script>

    <script src="js/scripts.js"></script>
    <script src="js/advanced-form.js"></script>

</body>

</html>
