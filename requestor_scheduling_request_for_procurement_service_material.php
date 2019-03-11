<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require_once("db/mysql_connect.php");

//GET REQUEST RECEIVING ID
$id = $_GET['id'];

//GET REQUEST Information
$queryReqInfo="SELECT * FROM thesis.requestor_receiving rr join request r on rr.requestID=r.requestID 
											where rr.id='{$id}'";
$resultReqInfo=mysqli_query($dbc,$queryReqInfo);
$rowReqInfo=mysqli_fetch_array($resultReqInfo,MYSQLI_ASSOC);

//Update notifications
$queryUpdNotif="UPDATE `thesis`.`notifications` SET `isRead` = true WHERE `requestor_receiving_id` = '{$id}'";
$resultUpdNotif=mysqli_query($dbc,$queryUpdNotif);

$sql = "SELECT  b.name AS 'building', floorRoom, recipient, dateneeded, r.description
            FROM thesis.request r 
        JOIN ref_status s 
            ON r.status = s.statusID
        JOIN building b
            ON r.BuildingID = b.BuildingID
        JOIN floorandroom f
            ON  r.FloorAndRoomID = f.FloorAndRoomID
            WHERE requestID =  {$rowReqInfo['requestID']};";
$result = mysqli_query($dbc, $sql);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

        $description = $row['description'];
        $building = $row['building'];
        $floorRoom = $row['floorRoom'];
        $recipient = $row['recipient'];
        $recipient = $row['recipient'];
        $dateneeded = $row['dateneeded'];
        $description = $row['description'];

    }
	
	if(isset($_POST['save'])){
		$deliverySched=$_POST['deliverySched'];
		
		//UPDATE DELIVERY DATE
		$queryUpdDelDate="UPDATE `thesis`.`requestor_receiving` SET `statusID`='2', `deliveryDate`='{$deliverySched}' WHERE `id`='{$id}'";
		$resultUpdDelDate=mysqli_query($dbc,$queryUpdDelDate);
		
		//CHECK IF ALL DELIVERY REQUEST IS ONGOING BASED ON GIVEN REQUESTID
		$queryCountAllDelReq="SELECT Count(*) as `numDel` FROM thesis.requestor_receiving where requestID='{$rowReqInfo['requestID']}'";
		$resultCountAllDelReq=mysqli_query($dbc,$queryCountAllDelReq);
		$rowCountAllDelReq = mysqli_fetch_array($resultCountAllDelReq, MYSQLI_ASSOC);
		
		$queryCountAllOngDel="SELECT Count(*) as `numDel` FROM thesis.requestor_receiving where requestID='{$rowReqInfo['requestID']}' and statusID='2'";
		$resultCountAllOngDel=mysqli_query($dbc,$queryCountAllOngDel);
		$rowCountAllOngDel = mysqli_fetch_array($resultCountAllOngDel, MYSQLI_ASSOC);
		
		if($rowCountAllDelReq['numDel']==$rowCountAllOngDel['numDel']){
			//UPDATE STEP
			$queryUpdReqStep="UPDATE `thesis`.`request` SET `step` = '25' WHERE (`requestID` = '{$rowReqInfo['requestID']}')";
			$resultUpdReqStep=mysqli_query($dbc,$queryUpdReqStep);
		}
		
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
                                        Request to Purchase an Asset - Scheduling
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
                                                        <h4 class="control-label col-lg-3">floor & Room</h4>
                                                        <h4 class="control-label col-lg-1"><?php echo $floorRoom;?></h4>
                                                    </div>
                                                    <div class="form-group ">
                                                       <h4 class="control-label col-lg-3">Date Needed</h4>
                                                       <h4 class="control-label col-lg-1"><?php echo $dateneeded;?></h4>
                                                    </div>
                                                </section>
                                                <hr>

                                                <section>
                                                    <h4>Request Details</h4>
                                                    <div class="form-group ">
                                                        <h4 class="control-label col-lg-3">Reason Of Request</h4>
                                                        <h4 class="control-label col-lg-1"><?php echo $description;?></h4>
                                                    </div>
                                                </section>

                                                <hr>

                                                <section>
                                                    <h4>Assets For Delivery</h4>
                                                    <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                        <thead>
                                                            <tr>
                                                                <th>Quantity</th>
                                                                <th>Category</th>
                                                                <th>Model Name</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
															//GET data by asset category and description
															$queryGetRecDat = "SELECT count(rd.assetID) as `qty`,am.description as `modelName`,rac.name as `assetCatName` FROM thesis.receiving_details rd left join asset a on rd.assetID=a.assetID
																															left join assetmodel am on a.assetModel=am.assetModelID
																															left join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
                                                                                                                            where rd.receivingID='{$id}'
																															group by a.assetModel";
                                                                  
															$resultGetRecDat = mysqli_query($dbc, $queryGetRecDat);
															while($rowGetRecDat = mysqli_fetch_array($resultGetRecDat, MYSQLI_ASSOC)){
																echo "<tr>
																		<td>
																			<div class='col-lg-12'>
                                                                                <input class='form-control' type='number' value='{$rowGetRecDat['qty']}' disabled />
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <div class='col-lg-12'>
                                                                                <input class='form-control' type='text' value='{$rowGetRecDat['assetCatName']}' disabled/>
                                                                            </div>
                                                                        </td>

                                                                        <td style='padding-top:5px; padding-bottom:5px'>
                                                                            <div class='col-lg-12'>
                                                                                <input class='form-control' type='text' value='{$rowGetRecDat['modelName']}' disabled/>
                                                                            </div>
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
                                                        <input class="form-control" type="datetime-local" name="deliverySched" required>
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