<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	$_SESSION['requestid']=$_GET['requestid'];
	$query="SELECT rs.description as `statusDesc` FROM thesis.request r join thesis.ref_status rs on r.status=rs.statusID
										   join thesis.user u on r.UserID=u.UserID
										   where r.requestID='{$_SESSION['requestid']}'";
	$result=mysqli_query($dbc,$query);
	$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
	
	if(isset($_POST['approve'])){
		$query="UPDATE `thesis`.`request` SET `status`='2', `step`='2'  WHERE `requestID`='{$_SESSION['requestid']}'";
		$result=mysqli_query($dbc,$query);
		header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/director_view_request.php?requestid={$_SESSION['requestid']}");
	}
	elseif(isset($_POST['disapprove'])){
		$query="UPDATE `thesis`.`request` SET `status`='6' WHERE `requestID`='{$_SESSION['requestid']}'";
		$result=mysqli_query($dbc,$query);
		header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/director_view_request.php?requestid={$_SESSION['requestid']}");
	}
	
?>
<html lang="en">

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
        <?php include 'director_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->
                <a href="director_requests.php"><button class="btn btn-danger" type="button">Back</button></a>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">
                            <h2>Status: <?php 
											if($row['statusDesc']=='Pending'){
												echo "<span class='label label-warning'>{$row['statusDesc']}</span>";
											}
											elseif($row['statusDesc']=='Approved'){
												echo "<span class='label label-success'>{$row['statusDesc']}</span>";
											}
											else{
												echo "<span class='label label-danger'>{$row['statusDesc']}</span>";
											} ?></h2>
                            <center><img src="img/logo.png" width="150" height="150"> </center>
                            <center><b>
                                    <h3>De La Salle University</h3>
                                </b></center>
                            <center><b>
                                    <h5>Information Technology Services</h5>
                                </b></center>
                            <center><b>
                                    <h3>Hardware Software Request Form</h3>
                                </b></center>
                            <br>

                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Quantity</th>
                                        <th>Hardware/ Software Requirements</th>
										<th>Description</th>
                                        <!-- <th>Estimated Cost</th> -->
                                        <!-- <th>Source of Budget</th> -->
                                        <!-- <th>Recommended Supplier</th> -->
                                    </tr>
                                </thead>
                                <tbody>
									<?php
									
										require_once('db/mysql_connect.php');
										$query1="SELECT rd.requestID,rd.quantity,rd.description as `reqDetDesc`,rac.name as `categoryName` FROM thesis.requestdetails rd
															join thesis.ref_assetcategory rac on rd.assetCategory=rac.assetCategoryID
															where rd.requestID='{$_SESSION['requestid']}}'";
										$result1=mysqli_query($dbc,$query1);
										while($row1=mysqli_fetch_array($result1,MYSQLI_ASSOC)){
											echo "<tr>
												<td>{$row1['quantity']}</td>
												<td>{$row1['categoryName']}</td>
												<td>{$row1['reqDetDesc']}</td>
											</tr>";
											
											
											
										}

									?>
									<!--
                                    <tr>
                                        <td>10</td>
                                        <td>Shabu</td>
                                        <td>P 1000.00</td>
                                        <td>Nanay Mo Corp.</td>
                                        <td>CDR King</td>
                                    </tr>

                                    <tr>
                                        <td>10</td>
                                        <td>Microphones</td>
                                        <td>P 1000.00</td>
                                        <td>Sponsor</td>
                                        <td>CDR King</td>
                                    </tr>
									-->
                                </tbody>
                            </table>
                        </div>

                        <br>

                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Course(s) That Will Use The Requirement(s)</th>
                                        <th>Course Offering Per Academic Year</th>
                                        <th>Projected Number of Students Per Section</th>
                                        <th>Projected Number of Sections Per Term</th>
                                        <th>Projected Number of Sections Per Year</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>ITMETHD</td>
                                        <td>3</td>
                                        <td>45</td>
                                        <td>3</td>
                                        <td>12</td>
                                    </tr>
                                </tbody>
                            </table>
							<form method="post">
								<button type="submit" class="btn btn-success" name="approve" <?php if($row['statusDesc'] != 'Pending') echo "disabled"; ?> ><i class="fa fa-check"></i> Approve</button>
								<button type="submit" class="btn btn-danger" name="disapprove" <?php if($row['statusDesc'] != 'Pending') echo "disabled"; ?> ><i class="fa fa-ban"></i> Disapprove</button>
							</form>
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

</body>

</html>