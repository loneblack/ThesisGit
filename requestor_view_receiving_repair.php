<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require_once("db/mysql_connect.php");

$id = $_GET['id'];
$startDate = "";
$dateNeeded = "";

$sql = "SELECT * FROM thesis.requestor_receiving WHERE id = {$id};";
$result = mysqli_query($dbc, $sql);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

        $borrowID = $row['borrowID'];
        $requestID = $row['requestID'];
        $serviceUnitID = $row['serviceUnitID'];
        $serviceID = $row['serviceID'];

    }

if($borrowID > 0)//have borrow
{
  
    $sql = "SELECT *, r.id as 'receivingID' 
            FROM thesis.requestor_receiving r 
            JOIN request_borrow b ON r.borrowID = b.borrowID 
            JOIN building g ON b.BuildingID = g.BuildingID 
            JOIN floorandroom f ON b.FloorAndRoomID = f.FloorAndRoomID  
            WHERE r.id = '{$id}';";
    $result = mysqli_query($dbc, $sql);

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

        $startDate = $row['startDate'];
        $building = $row['name'];
        $floorRoom = $row['floorRoom'];

    }


}
if($requestID > 0)//have request
{

    $sql = "SELECT *, r.id as 'receivingID' 
            FROM thesis.requestor_receiving r 
            JOIN request t ON r.requestID = t.requestID 
            JOIN building b ON t.BuildingID = b.BuildingID 
            JOIN floorandroom f ON t.FloorAndRoomID = f.FloorAndRoomID 
            WHERE r.id = '{$id}';";
    $result = mysqli_query($dbc, $sql);

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

        $building = $row['name'];
        $floorRoom = $row['floorRoom'];
        $dateNeeded = $row['dateNeeded'];;

    }

}
if($serviceUnitID > 0)//have service unit
{

    $sql = "SELECT *, r.id as 'receivingID' 
            FROM thesis.requestor_receiving r 
            JOIN serviceunit su ON r.serviceUnitID = su.serviceUnitID
            JOIN employee e ON r.UserID = e.UserID
            JOIN floorandroom f ON e.FloorAndRoomID = f.FloorAndRoomID
            JOIN building b ON f.BuildingID = b.BuildingID 
            WHERE r.id = '{$id}';";
    $result = mysqli_query($dbc, $sql);

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

        $building = $row['name'];
        $floorRoom = $row['floorRoom'];
        $dateNeeded = $row['dateNeeded'];;

    }

}
if($serviceID > 0)//have service
{

    $sql = "SELECT *, r.id as 'receivingID' 
            FROM thesis.requestor_receiving r 
            JOIN service s ON r.serviceID = s.id
            JOIN employee e ON r.UserID = e.UserID
            JOIN floorandroom f ON e.FloorAndRoomID = f.FloorAndRoomID
            JOIN building b ON f.BuildingID = b.BuildingID 
            WHERE r.id = '{$id}';";
    $result = mysqli_query($dbc, $sql);

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

        $building = $row['name'];
        $floorRoom = $row['floorRoom'];
        $dateNeeded = $row['dateNeed'];;

    }

}

$sql = "SELECT a.assetID, propertyCode, rb.name as 'brand', rac.name as 'category', itemSpecification, description, received
        FROM thesis.receiving_details r
        JOIN asset a ON r.assetID = a.assetID 
        JOIN assetmodel am on a.assetModel = am.assetModelID
        JOIN ref_brand rb on am.brand = rb.brandID
        JOIN ref_assetcategory rac on am.assetCategory = rac.assetCategoryID
        WHERE r.receivingID = '{$id}';";
$result = mysqli_query($dbc, $sql);

$count = 0;

$requestedID = array();
$requestedPropertyCode = array();
$requestedCategory = array();
$requestedItemSpecification = array();
$requestedBrand = array();
$requestedDescription = array();
$requestedBrand = array();
$requestedCheck = array();

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

        array_push($requestedID, $row['assetID']);
        array_push($requestedCategory, $row['category']);
        array_push($requestedBrand, $row['brand']);
        array_push($requestedDescription, $row['description']);
        array_push($requestedPropertyCode, $row['propertyCode']);
        array_push($requestedItemSpecification, $row['itemSpecification']);

        if($row['received'] == 1){
            array_push($requestedCheck, "checked disabled");
        }
        else {
            array_push($requestedCheck, "");
        }

        $count++;

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
        <?php //include 'requestor_navbar.php' ?>

        <!--main content-->
        <section >
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-12">
                                <section class="panel">
									<?php
										if($borrowID > 0)//have borrow
										{
											echo "<header class='panel-heading'>
														Request To Borrow An Asset
													</header>";
										}
										if($requestID > 0)//have request
										{
											echo "<header class='panel-heading'>
														Request To Purchase An Asset
													</header>";
										}									
									
									?>
                                   
                                    <div class="panel-body">
                                        <div class="form" method="post">
                                            <form class="cmxform form-horizontal " id="signupForm" method="post" action="requestor_view_receiving_DB.php?id=<?php echo $id;?>">
                                                <?php
                                                    if (isset($_SESSION['submitMessage'])){

                                                        echo "<div class='alert alert-success'>
                                                                {$_SESSION['submitMessage']}
                                                              </div>";

                                                        unset($_SESSION['submitMessage']);
                                                    }
                                                ?>
                                                <section>
                                                    <h4>User Location Information</h4>
                                                    <div class="form-group ">
                                                        <h4 class="control-label col-lg-1" style="text-align: left;">Building</h4>
                                                        <h4 class="control-label col-lg-1" style="text-align: left;"><?php echo $building;?></h4>
                                                    </div>
                                                    <div class="form-group">
                                                        <h4 class="control-label col-lg-1" style="text-align: left;">floor & Room</h4>
                                                        <h4 class="control-label col-lg-1" style="text-align: left;"><?php echo $floorRoom;?></h4>
                                                    </div>
                                                    <div class="form-group ">
                                                       <h4 class="control-label col-lg-1" style="text-align: left;">Date Needed</h4>
                                                       <h4 class="control-label col-lg-1" style="text-align: left;"><?php echo $startDate; echo $dateNeeded;?></h4>
                                                    </div>
                                                </section>
                                                <hr>
                                                <section>
                                                    <h4>Requested Services/Materials</h4>
                                                    <table class="table table-bordered table-striped table-condensed table-hover" id="mama">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>PropertyCode</th>
                                                                <th>Category</th>
                                                                <th>Brand</th>
                                                                <th>Model and Specifications</th>
                                                                <th>Comments</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php

                                                            for ($i=0; $i < $count; $i++) { 
                                                                echo
                                                                    '<tr>
                                                                        <td>
                                                                                <input class="form-control" name="assets[]"  type="checkbox" value="'. $requestedID[$i].'"'.$requestedCheck[$i].'/>
                                                                                <input type="hidden" id="hiddenchk1[]"name="assets[]" value="0" >
                                                                        </td>

                                                                        <td style="width:1%">

                                                                            '.$requestedPropertyCode[$i].'                                                                       
                                                                        </td>

                                                                        <td style="width:1%">

                                                                            '.$requestedCategory[$i].'                                                                       
                                                                        </td>

                                                                        <td>

                                                                         '.$requestedBrand[$i].'

                                                                        </td>

                                                                        <td style="padding-top:5px; padding-bottom:5px">
                                                                              '.$requestedDescription[$i].' '.$requestedItemSpecification[$i].'
                                                                        </td>

                                                                        <td style="padding-top:5px; padding-bottom:5px">
                                                                             <input type="text" class="form-control" name="comments[]" id="comments">
                                                                        </td>
                                                                    </tr>';
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>


                                                    <br>
                                                </section>

                                                <div class="form-group">
                                                    <div style="padding-left: 15px">
                                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Submit</button>
                                                        <a href="receiving_dashboard.php"><button class="btn btn-default" type="button">Back</button></a>
                                                    </div>
                                                </div>

                                                <!-- Modal -->
                                                <div id="myModal" class="modal fade" role="dialog">
                                                  <div class="modal-dialog">

                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Confirmation</h4>
                                                      </div>
                                                      <div class="modal-body">
                                                        <p>Are you sure?</p>
                                                      </div>
                                                      <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#myModal">Submit</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                      </div>
                                                    </div>

                                                  </div>
                                                </div>
                                                <!-- Modal End-->
                                            </form>
                                        </div>
                                    </div>
                                </section>
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


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>
    
    <script type="text/javascript">
 
	</script>

</body>

</html>