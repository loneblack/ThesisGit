<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	$requestID=$_GET['requestid'];
	$query="SELECT rs.description as `statusDesc` FROM thesis.request r join thesis.ref_status rs on r.status=rs.statusID
										   join thesis.user u on r.UserID=u.UserID
										   where r.requestID='{$requestID}'";
	$result=mysqli_query($dbc,$query);
	$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

	if(isset($_POST['approve'])){
		$filetmp=$_FILES["fileToUpload"]["tmp_name"];
		$filename=$_FILES["fileToUpload"]["name"];
		$filetype=$_FILES["fileToUpload"]["type"];
		
		$filepath = "uploads/".$filename;
		
		move_uploaded_file($filetmp,$filepath);
		
		$query="UPDATE `thesis`.`request` SET `status`='1', `step`='27'  WHERE `requestID`='{$requestID}'";
		$result=mysqli_query($dbc,$query);
		
		// Upload file to server
		
		// Insert image file name into database
		$queryInsImage="UPDATE `thesis`.`request` SET `signature` = '".$filename."' WHERE `requestID` = '{$requestID}';";
		$resultInsImage=mysqli_query($dbc,$queryInsImage);
		$message = "Form submitted!";
		$_SESSION['submitMessage'] = $message; 
		//header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/director_view_request.php?requestid={$requestID}");
	}
	elseif(isset($_POST['disapprove'])){
		$query="UPDATE `thesis`.`request` SET `status`='6', `step`='20' WHERE `requestID`='{$requestID}'";
		$result=mysqli_query($dbc,$query);
		$message = "Form submitted!";
		$_SESSION['submitMessage'] = $message; 
		//header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/director_view_request.php?requestid={$requestID}");
	}
	
    $sql="SELECT *, e.name as 'myName', b.name as 'building'
            FROM thesis.request r 
            JOIN employee e ON r.UserID = e.UserID 
            JOIN building b ON r.BuildingID = b.BuildingID
            JOIN floorandroom f ON r.FloorAndRoomID = f.FloorAndRoomID
            WHERE requestID = '{$requestID}';";

    $output=mysqli_query($dbc,$sql);
    $column=mysqli_fetch_array($output,MYSQLI_ASSOC);
	
    $myName = $column['myName'];
    $contactNo = $column['contactNo'];
    $email = $column['email'];
    $building = $column['building'];
    $floorRoom = $column['floorRoom'];
    $dateNeeded = $column['dateNeeded'];

   
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
    
        <?php
            $count = 1;
            $queryGetUser = "SELECT e.name AS `name` FROM employee e JOIN user u ON e.userID = u.userID WHERE e.userID = '{$_SESSION['userID']}';";
            $resultGetUser = mysqli_query($dbc, $queryGetUser);
            $rowGetUser = mysqli_fetch_array($resultGetUser, MYSQLI_ASSOC);
            $name = $rowGetUser['name'];
        ?>

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
                <h4>Welcome! <?php echo $name; ?></h4>
            </div>

        </header>
        <!--header end-->
        <?php include 'director_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->
				<?php
                    if (isset($_SESSION['submitMessage'])){

                        echo "<div class='alert alert-success'>
                                {$_SESSION['submitMessage']}
							  </div>";
                        unset($_SESSION['submitMessage']);
                    }
				?>
                <a href="director_requests.php"><button class="btn btn-danger" type="button">Back</button></a>

                <div class="row">
                    <div class="col-sm-12">
						<form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']." ?requestid=".$requestID; ?>">
                        <div class="col-sm-12">
                            <h2>Status:
                                <?php 
									if($row['statusDesc']=='Pending'){
										echo "<span class='label label-warning'>{$row['statusDesc']}</span>";
									}
									elseif($row['statusDesc']=='Disapproved'){
										echo "<span class='label label-danger'>{$row['statusDesc']}</span>";
									}
									else{
										echo "<span class='label label-success'>Approved</span>";
									} ?>
                            </h2>
                            <br><br>
                            <div class="col-lg-6">
                                <h4><strong>Name:</strong>
                                    <?php echo $myName; ?>
                                </h4>
                                <h4><strong>Contact Number:</strong>
                                    <?php echo $contactNo; ?>
                                </h4>
                                <h4><strong>Email:</strong>
                                    <?php echo $email; ?>
                                </h4>
                            </div>

                            <div class="col-lg-6">
                                <h4><strong>Building:</strong>
                                    <?php echo $building; ?>
                                </h4>
                                <h4><strong>Floor/ Room Number:</strong>
                                    <?php echo $floorRoom; ?>
                                </h4>
                                <h4><strong>Date Needed:</strong>
                                    <?php echo $dateNeeded; ?>
                                </h4>
                            </div>

                            <br><br><br><br><br><br><br><br>
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Quantity</th>
                                        <th>Hardware/ Software Requirements</th>
                                        <th>Description</th>
										<th>Purpose</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
									
										require_once('db/mysql_connect.php');
										$query1="SELECT rd.purpose,rd.requestID,rd.quantity,rd.description as `reqDetDesc`,rac.name as `categoryName` FROM thesis.requestdetails rd
															join thesis.ref_assetcategory rac on rd.assetCategory=rac.assetCategoryID
															where rd.requestID='{$requestID}}'";
										$result1=mysqli_query($dbc,$query1);
										while($row1=mysqli_fetch_array($result1,MYSQLI_ASSOC)){
											echo "<tr>
												<td>{$row1['quantity']}</td>
												<td>{$row1['categoryName']}</td>
												<td>{$row1['reqDetDesc']}</td>
												<td>{$row1['purpose']}</td>
											</tr>";
	
										}

									?>
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-lg-4">
                                    <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*" >
                                </div>
                            </div>
                            
                            <br><br>
                            
                            <div class="row">
                                <div class="col-lg-2">
                                    <label>Reason For Disapproval</label>
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="reason" class="form-control">
                                </div>
                            </div>
							<div class="row">
                            <br>    
                            </div>
							<?php
							
							if(isset($column['itReasonDissaproval'])){
								echo "<div class='row'>
									<div class='col-lg-2'>
										<label>IT Office's Reason For Disapproval</label>
									</div>
									<div class='col-lg-6'>
										<input type='text' value='{$column['itReasonDissaproval']}' class='form-control' disabled>
									</div>
								</div>";
							}
							
							
							?>
							
							<div class="row">
                            <br>    
                            </div>
							<div class="row">
                                <div class="col-xs-4">
                                </div>
                                <div class="col-xs-4"> 
                                    <button type="submit" class="btn btn-success" name="approve" ><i class="fa fa-check"></i> Approve</button>
                                        &nbsp;&nbsp;
                                    <button type="submit" class="btn btn-danger" name="disapprove" ><i class="fa fa-ban"></i> Disapprove</button> 
                                </div>
                                <div class="col-xs-4">
                                </div>
                            </div>
							
                        </div>
                        <br>
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