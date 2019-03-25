<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require_once("db/mysql_connect.php");

//GET REQUEST RECEIVING ID
$id = $_GET['id'];

//GET Borrow Information
$queryReqInfo="SELECT * FROM thesis.requestor_receiving rr join service s on rr.serviceID=s.id 
											where rr.id='{$id}'";

$resultReqInfo=mysqli_query($dbc,$queryReqInfo);
$rowReqInfo=mysqli_fetch_array($resultReqInfo,MYSQLI_ASSOC);

//Update notifications
$queryUpdNotif="UPDATE `thesis`.`notifications` SET `isRead` = true WHERE `requestor_receiving_id` = '{$id}'";
$resultUpdNotif=mysqli_query($dbc,$queryUpdNotif);

$sql = "SELECT *, b.name as 'building' FROM thesis.service s 
        JOIN employee e on s.UserID = e.UserID 
        JOIN floorandroom f on e.FloorAndRoomID = f.FloorAndRoomID 
        JOIN building b ON f.BuildingID = b.BuildingID 
        WHERE s.id = '{$rowReqInfo['serviceID']}';";
$result = mysqli_query($dbc, $sql);

$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

$building = $row['building'];
$floorRoom = $row['floorRoom'];
$dateNeed = $row['dateNeed'];
$endDate = $row['endDate'];
$details = $row['details'];
        
    
	
if(isset($_POST['save'])){
	$deliverySched=$_POST['deliverySched'];
		
	//UPDATE DELIVERY DATE
	$queryUpdDelDate="UPDATE `thesis`.`requestor_receiving` SET `statusID`='2', `deliveryDate`='{$deliverySched}' WHERE `id`='{$id}'";
	$resultUpdDelDate=mysqli_query($dbc,$queryUpdDelDate);
	
	//INSERT TO NOTIFICATIONS TABLE
	$sqlNotif = "INSERT INTO `thesis`.`notifications` (`isRead`, `requestor_receiving_id`) VALUES (false, '{$id}');";
	$resultNotif = mysqli_query($dbc, $sqlNotif);
	

	$queryUpdReqStep="UPDATE `thesis`.`service` SET `steps` = '25' WHERE (`id` = '{$rowReqInfo['serviceID']}')";
	$resultUpdReqStep=mysqli_query($dbc,$queryUpdReqStep);
		
	$message = "Form submitted!";
	$_SESSION['submitMessage'] = $message; 
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
        <?php include 'requestor_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->
				<?php
                    if (isset($_SESSION['submitMessage']) && $_SESSION['submitMessage']=="Form submitted!"){
                        echo "<div class='alert alert-success'>
                                {$_SESSION['submitMessage']}
							  </div>";
                        unset($_SESSION['submitMessage']);
                    }
				?>
                <div class="row">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        Request for Repair - Scheduling
                                    </header>
                                    <div class="panel-body">
                                        <div class="form" method="post">
                                            <form class="cmxform form-horizontal " id="signupForm" method="post" action="<?php echo $_SERVER['PHP_SELF']."?id=".$id; ?>">
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
                                                        <h4 class="control-label col-lg-3">Building</h4>
                                                        <h4 class="control-label col-lg-1"><?php echo $building;?></h4>
                                                    </div>
                                                    <div class="form-group">
                                                        <h4 class="control-label col-lg-3">Floor & Room</h4>
                                                        <h4 class="control-label col-lg-1"><?php echo $floorRoom;?></h4>
                                                    </div>
													<div class="form-group ">
                                                        <h4 class="control-label col-lg-3">Date & time needed</h4>
                                                        <h4 class="control-label col-lg-1"><?php echo $dateNeed;?></h4>
                                                    </div>
                                                    <div class="form-group">
                                                        <h4 class="control-label col-lg-3">Asset Return date & time</h4>
                                                        <h4 class="control-label col-lg-1"><?php echo $endDate;?></h4>
                                                    </div>
                                                   
                                                </section>
                                                <hr>

                                                <section>
                                                    <h4>Request Details</h4>
                                                    <div class="form-group ">
                                                        <h4 class="control-label col-lg-3">Reason Of Request</h4>
                                                        <h4 class="control-label col-lg-1"><?php echo $details;?></h4>
                                                    </div>
                                                </section>

                                                <hr>

                                                <section>
                                                    <h4>Assets For Delivery</h4>
                                                    <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                        <thead>
                                                            <tr>
                                                                <th>Property Code</th>
                                                                <th>Brand</th>
                                                                <th>Category</th>
                                                                <th>Model and Specification</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
															//GET data by asset category and description
															$queryGetRecDat = "SELECT *, b.name as 'brandName', ac.name as 'assetCategoryName' FROM thesis.servicedetails s
                                                                                JOIN asset a ON s.asset = a.assetID
                                                                                JOIN assetmodel m ON a.assetModel = m.assetModelID
                                                                                JOIN ref_brand b on m.brand = b.brandID
                                                                                JOIN ref_assetcategory ac ON m.assetCategory = ac.assetCategoryID
                                                                                WHERE serviceID = '{$rowReqInfo['serviceID']}';";
                                                                  
															$resultGetRecDat = mysqli_query($dbc, $queryGetRecDat);
															while($rowGetRecDat = mysqli_fetch_array($resultGetRecDat, MYSQLI_ASSOC)){
																echo "<tr>
																		<td>
                                                                                {$rowGetRecDat['propertyCode']}
                                                                        </td>

                                                                        <td>
                                                                                {$rowGetRecDat['brandName']}
                                                                        </td>

                                                                        <td style='padding-top:5px; padding-bottom:5px'>
                                                                                {$rowGetRecDat['assetCategoryName']}
                                                                        </td>

																        <td style='padding-top:5px; padding-bottom:5px'>
                                                                                {$rowGetRecDat['itemSpecification']}
                                                                        </td>
																
																</tr>";
															}
															
															
                                                           
                                                            ?>
                                                        </tbody>
                                                    </table>


                                                    <br>
                                                </section>

                                                <hr>
                                                <section>
                                                    <div class="col-lg-3">
                                                        <h4>Delivery Scheduling</h4>
                                                        <input class="form-control" type="datetime-local" name="deliverySched" value="<?php 
																																		echo date('Y-m-d\TH:i');
																																		?>" min="<?php 
																																					echo date('Y-m-d\TH:i');
																																					?>" required>
                                                    </div>
                                                </section>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>

                                                <div class="form-group">
                                                    <div class=" col-lg-6">
														<button class="btn btn-primary" type="submit" name="save">Save</button>
                                                        <a href="requestor_dashboard.php"><button class="btn btn-default" type="button">Back</button></a>
                                                    </div>
                                                </div>

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
