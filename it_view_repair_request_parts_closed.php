<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$userID = $_SESSION['userID'];
$id = $_GET['id'];
$_SESSION['previousPage'] = "it_view_repair_request_parts.php?id={$id}";
require_once("db/mysql_connect.php");

$query =  "SELECT * FROM thesis.requestparts r JOIN service s ON r.serviceID = s.id JOIN employee e ON r.UserID = e.UserID JOIN ref_status rs ON r.statusID = rs.statusID WHERE r.id = {$id};";
$result = mysqli_query($dbc, $query);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        
        $date = $row['date'];        
        $name = $row['name'];
        $serviceID = $row['serviceID'];

    }

$assets = array();

$query2 =  "SELECT * FROM thesis.servicedetails WHERE serviceID = {$serviceID};";
$result2 = mysqli_query($dbc, $query2);

while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
    array_push($assets, $row['asset']);
}

//get requested parts
$assetCategoryID = array();
$quantity = array();
$specifications = array();

$query2 =  "SELECT * FROM thesis.requestparts_details WHERE requestPartsID = {$id};";
$result2 = mysqli_query($dbc, $query2);

while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
    array_push($assetCategoryID, $row['assetCategoryID']);
    array_push($quantity, $row['quantity']);
    array_push($specifications, $row['specifications']);
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
                                    <h4 class="gen-case" style="float:right">
                                    </h4>
                                    <h4>Request for Parts (Repair)</h4>
                                </header>
                                <div class="panel-body ">

                                    <div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <img src="images/chat-avatar2.jpg" alt="">
                                                <strong><?php echo $name;?></strong>
                                                to
                                                <strong>me</strong>
                                            </div>
                                            <div class="col-md-4">
                                                <button style="display: none; float:right" class="btn btn-warning">Pending</button>
                                                <button style=" float:right" class="btn btn-success">Completed</button>
                                                <button style="display: none; float:right" class="btn btn-info">Ongoing</button>
                                                <br>
                                                <br>
                                                <h5>Date Created: <?php echo $date;?>
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
                                        <h4>Requested Parts </h4>
                                    </div>

                                    <table class="table table-bordered table table-hover" id="addtable">
                                        <thead>
                                            <tr>
                                                <th width="150">Quantity</th>
                                                <th>Category</th>
                                                <th>Specification</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            for ($i=0; $i < count($quantity); $i++) {

                                            echo 
                                            "<tr>
                                                <td>
                                                    <input class='form-control' value = '{$quantity[$i]}' disabled>
                                                </td>
                                                <td width='300'>";
                                                       
                                                        $sql = "SELECT * FROM thesis.ref_assetcategory WHERE assetCategoryID = '{$assetCategoryID[$i]}';";
                                                        $result = mysqli_query($dbc, $sql);

                                                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                                                        $category = $row['name'];
                                                    
                                                  echo

                                                  "<input class='form-control' value = '{$category}' disabled>
                                                  </td>
                                                <td>
                                                    <input class='form-control' value = '{$specifications[$i]}' disabled>
                                                </td>
                                            </tr>";

                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <input style="display: none" type="number" id="count" name="count">
                                </div>
                            </section>
                            
                            <form method='post' action="it_view_repair_request_parts_DB.php?id=<?php echo $id;?>">
                            <section class="panel">
                                <div class="panel-body">
                                    <div>
                                        <h4>Parts Given</h4>
                                    </div>
                                    
                                    <h5>Only available assets may be given</h5>
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
                                        <tbody>
                                        <?php
                                        $count = 0;
                                        for ($i=0; $i < count($quantity); $i++) {
                                            for ($j=0; $j < $quantity[$i]; $j++) {
                                            

                                            echo
                                                "<tr>
                                                    <td width='300'>
                                                        <select id = '".$count."' class='form-control' onchange='loadDetails(this.value, this.id)' disabled>
                                                        <option value =''>Select</option>";

                                                $sql = "SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', itemSpecification, m.description
                                                        FROM asset a 
                                                            JOIN assetModel m
                                                        ON assetModel = assetModelID
                                                            JOIN ref_brand br
                                                        ON brand = brandID
                                                            JOIN ref_assetcategory c
                                                        ON assetCategory = assetCategoryID
                                                            WHERE assetCategoryID = '{$assetCategoryID[$i]}'
                                                        AND assetStatus = 1;"; //1 for stocked status

                                                $result = mysqli_query($dbc, $sql);
                                                

                                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                {
                                                    echo "<option value ={$row['assetID']}>";
                                                    echo "{$row['propertyCode']}</option>";
                                                }
                                                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                                                           
                                            echo 
                                                        "</select>
                                                    </td>";

                                            $sql = "SELECT * FROM thesis.ref_assetcategory WHERE assetCategoryID = '{$assetCategoryID[$i]}';";
                                            $result = mysqli_query($dbc, $sql);

                                            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                                            $category = $row['name'];

                                            $query="SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', itemSpecification, m.description as'modelDescription'
                                                        FROM asset a 
                                                            JOIN assetModel m
                                                        ON assetModel = assetModelID
                                                            JOIN ref_brand br
                                                        ON brand = brandID
                                                            JOIN ref_assetcategory c
                                                        ON assetCategory = assetCategoryID
                                                            WHERE assetCategoryID = '{$assetCategoryID[$i]}';";
                                            $result=mysqli_query($dbc,$query);

                                            $row=mysqli_fetch_array($result,MYSQLI_ASSOC);


                                            echo
                                                    "<td>
                                                        <input type='text' disabled class='form-control' value = '{$category}'>
                                                    </td>
                                                        <td id='brand".$count."'>
                                                            <input class='form-control' disabled>
                                                        </td>
                                                        <td id='description".$count."'>
                                                            <input class='form-control'  disabled>
                                                        </td>
                                                        <td id='specification".$count."'>
                                                            <input class='form-control'  disabled>
                                                        </td>
                                                        <td id='assetID".$count."' style='display: none'>
                                                            <input class='form-control' name='assets[]'>
                                                        </td>
                                                </tr>";

                                                $count++;
                                            }
                                        }

                                        ?>
                                        </tbody>
                                    </table>
                                    <input style="display: none" type="number" id="count" name="count">
                                </div>
                            </section>
                            
                        </div>
                            <div>
                            <button type="submit" name="submit" id="submit" class="btn btn-success" disabled>Send</button>
                        </form>
                        
                            <button onclick="window.history.back();" type="button" class="btn btn-danger">Back</button>
                            <div style="display:inline; float:right">
                            <button class="btn btn-info" onclick="window.location.href='it_replacement.php'" disabled>Give Replacement</button>
                            <button onclick="window.location.href='it_order_parts.php';" class="btn btn-info" disabled>Order parts</button>
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
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script src="js/jquery-ui-1.9.2.custom.min.js"></script>

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
