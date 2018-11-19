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
                            <div class="col-lg-6">
                                <h4>Department:</h4>
                                <h4>Name: </h4>
                                <h4>Contact Number:</h4>
                                <h4>Email:</h4>
                            </div>
                            
                            <div class="col-lg-6">
                                <h4>Building:</h4>
                                <h4>Floor/ Room Number: </h4>
                                <h4>Date Needed:</h4>
                            </div>
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
                                </tbody>
                            </table>
                        </div>

                    
							<form method="post">
								<button type="submit" class="btn btn-success" name="approve" <?php if($row['statusDesc'] != 'Pending') echo "disabled"; ?> ><i class="fa fa-check"></i> Approve</button>
                                &nbsp;
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