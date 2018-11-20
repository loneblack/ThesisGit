<!DOCTYPE html>
<?php
	$id=$_GET['id'];
	$requestType=$_GET['requestType'];
	require_once("db/mysql_connect.php");
	
	if(isset($_POST['save'])){
		$responseTime=$_POST['responseTime'];
		$efficiency=$_POST['efficiency'];
		$accuracy=$_POST['accuracy'];
		$courtesy=$_POST['courtesy'];
		$comments=$_POST['comments'];
		
		if($requestType=="Asset Request"){
			$queryAssReq="INSERT INTO `thesis`.`evaluation` (`date`, `responseTime`, `accuracy`, `efficiency`, `courtesy`, `comments`, `requestID`) VALUES (now(),'{$responseTime}','{$accuracy}','{$efficiency}','{$courtesy}','{$comments}','{$id}')";
			$resultAssReq=mysqli_query($dbc,$queryAssReq);
			
			$queryStep="UPDATE `thesis`.`request` SET `status`='3' WHERE `requestID`='{$id}'";
			$resultStep=mysqli_query($dbc,$queryStep);
			
		}
		elseif($requestType=="borrow"){
			//$query="";
			//$result=mysqli_query($dbc,$query);
		}
		elseif($requestType=="Donation"){
			$queryDon="INSERT INTO `thesis`.`evaluation` (`date`, `responseTime`, `accuracy`, `efficiency`, `courtesy`, `comments`, `donationID`) VALUES (now(),'{$responseTime}','{$accuracy}','{$efficiency}','{$courtesy}','{$comments}','{$id}'";
			$resultDon=mysqli_query($dbc,$queryDon);
			
			$queryStep="UPDATE `thesis`.`donation` SET `statusID`='3' WHERE `donationID`='{$id}'";
			$resultStep=mysqli_query($dbc,$queryStep);
		}
		elseif($requestType=="service"){
			//$query="";
			//$result=mysqli_query($dbc,$query);
		}
		
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
        <?php include 'requestor_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        Conforme
                                    </header>
                                    <div class="panel-body">
                                        <div class="form" method="post">
                                            <form class="cmxform form-horizontal " id="signupForm" method="post">

                                                <div class="form-group">
                                                    <label for="responseTime" class="control-label col-lg-3">Response Time</label>
                                                    <div class="col-lg-6">
                                                        <label class="radio"><input type="radio" name="responseTime" value="5" checked>Outstanding</label>
                                                        <label class="radio"><input type="radio" name="responseTime" value="4">Highly Satisfactory</label>
                                                        <label class="radio"><input type="radio" name="responseTime" value="3">Satisfactory</label>
                                                        <label class="radio"><input type="radio" name="responseTime" value="2">Moderately Satisfactory</label>
                                                        <label class="radio"><input type="radio" name="responseTime" value="1">Poor</label>
                                                        <label class="radio"><input type="radio" name="responseTime" value="0">Not applicable</label>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="efficiency" class="control-label col-lg-3">Efficiency</label>
                                                    <div class="col-lg-6">
                                                        <label class="radio"><input type="radio" name="efficiency" value="5" checked>Outstanding</label>
                                                        <label class="radio"><input type="radio" name="efficiency" value="4">Highly Satisfactory</label>
                                                        <label class="radio"><input type="radio" name="efficiency" value="3">Satisfactory</label>
                                                        <label class="radio"><input type="radio" name="efficiency" value="2">Moderately Satisfactory</label>
                                                        <label class="radio"><input type="radio" name="efficiency" value="1">Poor</label>
                                                        <label class="radio"><input type="radio" name="efficiency" value="0">Not applicable</label>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="accuracy" class="control-label col-lg-3">Accuracy</label>
                                                    <div class="col-lg-6">
                                                        <label class="radio"><input type="radio" name="accuracy" value="5" checked>Outstanding</label>
                                                        <label class="radio"><input type="radio" name="accuracy" value="4">Highly Satisfactory</label>
                                                        <label class="radio"><input type="radio" name="accuracy" value="3">Satisfactory</label>
                                                        <label class="radio"><input type="radio" name="accuracy" value="2">Moderately Satisfactory</label>
                                                        <label class="radio"><input type="radio" name="accuracy" value="1">Poor</label>
                                                        <label class="radio"><input type="radio" name="accuracy" value="0">Not applicable</label>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="responseTime" class="control-label col-lg-3">Courtesy</label>
                                                    <div class="col-lg-6">
                                                        <label class="radio"><input type="radio" name="courtesy" value="5" checked>Outstanding</label>
                                                        <label class="radio"><input type="radio" name="courtesy" value="4">Highly Satisfactory</label>
                                                        <label class="radio"><input type="radio" name="courtesy" value="3">Satisfactory</label>
                                                        <label class="radio"><input type="radio" name="courtesy" value="2">Moderately Satisfactory</label>
                                                        <label class="radio"><input type="radio" name="courtesy" value="1">Poor</label>
                                                        <label class="radio"><input type="radio" name="courtesy" value="0">Not applicable</label>
                                                    </div>
                                                </div>

                                                <div class="form-group ">
                                                    <label for="comments" class="control-label col-lg-3">Comments</label>
                                                    <div class="col-lg-6">
                                                        <textarea class="form-control" rows="5" name="comments" style="resize:none"></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-lg-offset-3 col-lg-6">
                                                        <button class="btn btn-primary" type="submit" name="save">Save</button>
                                                        <button class="btn btn-default" type="button">Cancel</button>
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

</body>

</html>