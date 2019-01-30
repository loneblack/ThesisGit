<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require_once("db/mysql_connect.php");
/*
$id = $_GET['id'];

$sql = "SELECT *, o.Name AS 'office', d.name AS 'department', z.name AS 'organization', b.name AS 'building' 
        FROM thesis.request_borrow r 
        JOIN ref_status s ON r.statusID = s.statusID 
        LEFT JOIN offices o ON r.officeID = o.officeID 
        LEFT JOIN department d ON r.DepartmentID = d.DepartmentID
        LEFT JOIN organization z ON r.organizationID = z.id
        JOIN building b ON r.BuildingID = b.BuildingID 
        JOIN floorandroom f ON r.FloorAndRoomID = f.FloorAndRoomID
        JOIN employee e ON personresponsibleID = e.UserID
        WHERE borrowID = {$id};";

$result = mysqli_query($dbc, $sql);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

        $office = $row['office'];
        $department = $row['department'];
        $organization = $row['organization'];
        $startDate = $row['startDate'];
        $endDate = $row['endDate'];
        $purpose = $row['purpose'];
        $building = $row['building'];
        $floorRoom = $row['floorRoom'];
        $personrepresentativeID = $row['personrepresentativeID'];
        $personrepresentative = $row['personrepresentative'];
        $contactNo = $row['contactNo'];


    }

$sql = "SELECT * FROM thesis.borrow_details d JOIN ref_assetcategory c ON d.assetCategoryID = c.assetCategoryID WHERE borrowID = {$id};";
$result = mysqli_query($dbc, $sql);

$count = 0;

$requestedQuantity = array();
$requestedCategory = array();

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

        array_push($requestedQuantity, $row['quantity']);
        array_push($requestedCategory, $row['name']);

        $count++;

    }
?>
<?php
// Insertion to ticket
    
    if(isset($_POST['submit'])){
		
		//GET ASSET TEST DATA
		$queryAssTest="SELECT * FROM thesis.assettesting where borrowID='{$id}'";
		$resultAssTest=mysqli_query($dbc,$queryAssTest);
		$rowAssTest=mysqli_fetch_array($resultAssTest, MYSQLI_ASSOC);
        
        $message=null;
        $status=$_POST['status'];
        $priority=$_POST['priority'];
        $assigned=$_POST['assigned'];
        $currDate=date("Y-m-d H:i:s");

        if(!isset($message)){

            if($assigned=='0'){
                $querya="INSERT INTO `thesis`.`ticket` (`status`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `serviceType`, `summary`, `description`, `details`) VALUES ('{$status}', '{$_SESSION['userID']}', now(), now(), '{$startDate}', '{$priority}', '25', 'Test the selected assets for borrow', 'Test the selected assets for borrow', 'Test the selected assets for borrow')";
                $resulta=mysqli_query($dbc,$querya);
            }
            else{
                $querya="INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `serviceType`, `summary`, `description`, `details`) VALUES ('{$status}', '{$assigned}', '{$_SESSION['userID']}', now(), now(), '{$startDate}', '{$priority}', '25', 'Test the selected assets for borrow', 'Test the selected assets for borrow', 'Test the selected assets for borrow')";
                $resulta=mysqli_query($dbc,$querya);
            }
        
            $queryaa="SELECT * FROM `thesis`.`ticket` order by ticketID desc limit 1";
            $resultaa=mysqli_query($dbc,$queryaa);
            $rowaa=mysqli_fetch_array($resultaa,MYSQLI_ASSOC);
			
			//ADD TEST ID
			$queryTestID="UPDATE `thesis`.`ticket` SET `testingID`='{$rowAssTest['testingID']}' WHERE `ticketID`='{$rowaa['ticketID']}'";
            $resultTestID=mysqli_query($dbc,$queryTestID);
			
			//GET ASSET TEST DETAILS
			$queryAssTestDet="SELECT * FROM thesis.assettesting_details where assettesting_testingID='{$rowAssTest['testingID']}'";
            $resultAssTestDet=mysqli_query($dbc,$queryAssTestDet);
			
            while ($rowAssTestDet = mysqli_fetch_array($resultAssTestDet, MYSQLI_ASSOC)){

                $queryaaaa="INSERT INTO `thesis`.`ticketedasset` (`ticketID`, `assetID`, `checked`) VALUES ('{$rowaa['ticketID']}', '{$rowAssTestDet['asset_assetID']}', '0');";
                $resultaaaa=mysqli_query($dbc,$queryaaaa);
            }

            $sql = "UPDATE `thesis`.`service` SET `status` = '2' WHERE (`id` = '{$id}');";
            $output = mysqli_query($dbc, $sql);
        
            $message = "Ticket Created";
            $_SESSION['submitMessage'] = $message;
        }
        
    }
    */
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

                            <section class="panel">
                                <header class="panel-heading">
                                    Delivery Details
                                </header>
                                
                                <div style="padding-top:55px" class="form" method="post">
									<form class="cmxform form-horizontal " id="signupForm" method="get" action="">
										<div class="form-group ">
											<label for="deliveryDate" class="control-label col-lg-3"> Date Needed</label>
											<div class="col-lg-6">
												<input type="date" name="deliveryDate" class="form-control m-bot15" disabled>
											</div>
										</div>
										<hr>
										<div class="container-fluid">
											<h4>Equipment to be delivered</h4>
											
											<table style="width:670px" class="table table-bordered table-striped table-condensed table-hover" id="tblCustomers" align="center" cellpadding="0" cellspacing="0" border="1">
												<thead>
													<tr>
                                                        <th style="width:50px"></th>
                                                        <th style="width:140px">Property Code</th>
														<th style="width:150px">Item</th>
														<th style="width:150px">Model</th>
                                                        <th style="width:130px">Brand</th>
                                                        <th style="width:150px">Status</th>
                                                        <th style="width:130px">Date Delivered</th>
													</tr>
												</thead>
												<tbody>
                                                    <tr>
                                                        <td style="text-align:center"><input type="checkbox"></td>
                                                        <td>CP-001</td>
                                                        <td>Cellphone</td>
                                                        <td>Galaxy J7 Pro</td>
                                                        <td>Samsung</td>
                                                        <td><span class="label label-danger">Not Yet Delivered</span>
                                                        <th>N/A</th>
                                                    </tr>
												</tbody>
											</table>
										</div>
									</form>
								</div>
                                <div style="padding-left:10px; padding-bottom:10px">
                                    <button type="submit" name="submit" id="submit" class="btn btn-success" data-dismiss="modal">Deliver</button> 
                                    <a ><button onclick="window.history.back()" type="button" class="btn btn-default" data-dismiss="modal">Back</button></a>
                                </div>
                            </section>

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


    <script src="js/scripts.js"></script>
    <script src="js/advanced-form.js"></script>

</body>

</html>