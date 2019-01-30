<!DOCTYPE html>
<?php

require_once('db/mysql_connect.php');
$_SESSION['userid']=$_GET['userid'];

$key = "Fusion";
$flag=0;

$query="Select Convert(AES_DECRYPT(username,'".$key."')USING utf8) as 'username',Convert(AES_DECRYPT(password,'".$key."')USING utf8) as 'password',Convert(AES_DECRYPT(firstName,'".$key."')USING utf8) as 'firstname',Convert(AES_DECRYPT(lastName,'".$key."')USING utf8) as 'lastname', userType from user where UserID='".$_SESSION['userid']."'";
$result=mysqli_query($dbc,$query);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

if (isset($_POST['submit'])){
		
		$message=NULL;
		
		//Firstname 
		$firstname=$_POST['firstname'];
		
		//Lastname
		$lastname=$_POST['lastname'];
		
		//User Type
		$usertype=$_POST['usertype'];
		
		//User Name
		
		//$checkQuery1 = "SELECT CONVERT(AES_DECRYPT(userName, '{$key}') USING utf8) FROM user WHERE username = AES_ENCRYPT('{$_POST['username']}', '{$key}')";
		//$checkResult1 = mysqli_query($dbc, $checkQuery1);
		
		//if($checkResult1->num_rows > 0){
			//$username=FALSE;
			//$message.="Username already exists. ";
		//}
		//else
			$username=$_POST['username'];
		
		//Password
		if($_POST['password']!=$_POST['confirm_password']){
			$password=FALSE;
			$message.="Passwords entered does not match. ";
		}
		else{
			$password=$_POST['password'];
		}
		
		if(!isset($message)){
			echo "<script type='text/javascript'>alert('Success');</script>"; // Show modal
			$query="UPDATE `thesis`.`user` SET username=AES_ENCRYPT('".$username."', '".$key."'), password=AES_ENCRYPT('".$password."', '".$key."'), userType='".$usertype."', firstName=AES_ENCRYPT('".$firstname."', '".$key."'), lastName=AES_ENCRYPT('".$lastname."', '".$key."') WHERE `UserID`='".$_SESSION['userid']."'";
			$result=mysqli_query($dbc,$query);
			$flag=1;
			header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/admin_edit_user.php?userid=".$_SESSION['userid']."");
		}
		
		else{
			echo "<script type='text/javascript'>alert('".$message."');</script>";
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

    <link rel="stylesheet" href="css/bootstrap-switch.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-timepicker/compiled/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datetimepicker/css/datetimepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery-multi-select/css/multi-select.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery-tags-input/jquery.tagsinput.css" />

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
        <?php include 'admin_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="row">
                        <div class="col-lg-12">
                            <section class="panel">
                                <header class="panel-heading">
                                    Edit A User
                                </header>
                                <div class="panel-body">
                                    <div class="form" method="post">
                                        <form class="cmxform form-horizontal " id="signupForm" method="post">
                                            <div class="form-group ">
                                                <label for="firstname" class="control-label col-lg-3">Firstname</label>
                                                <div class="col-lg-6">
                                                    <input class=" form-control" id="firstname" name="firstname" type="text" value="<?php echo $row['firstname'];  ?>" required />
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label for="lastname" class="control-label col-lg-3">Lastname</label>
                                                <div class="col-lg-6">
                                                    <input class=" form-control" id="lastname" name="lastname" type="text" value="<?php echo $row['lastname'];  ?>" required />
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label for="lastname" class="control-label col-lg-3">User Type</label>
                                                <div class="col-lg-6">
												
													<select class="form-control m-bot15" name="usertype" value="<?php echo $row['userType'];  ?>" required>
                                                        <option value="" disabled>Select User Type</option>
                                                        <option value="2">IT Office</option>
                                                        <option value="3">Helpdesk</option>
                                                        <option value="6">Procurement</option>
                                                        <option value="4">Engineer</option>
														<!-- did some changes in ref_usertype -->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label for="username" class="control-label col-lg-3">Username</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control " id="username" name="username" type="text" value="<?php echo $row['username'];  ?>" readonly/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-3">Department</label>
                                                <div class="col-lg-6">
                                                    <select multiple name="e9" id="e9" style="width:525px" class="populate">
                                                        <optgroup label="Select Department/s">
                                                            <option value="1">Accounting</option>
                                                            <option value="2">Computer Studies</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="lastname" class="control-label col-lg-3">Office</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15" name="department" value="" required>
                                                        <option value="" selected>None</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group ">
                                                <label for="password" class="control-label col-lg-3">Password</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control " id="password" name="password" type="password" value="<?php echo $row['password'];  ?>" required />
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label for="confirm_password" class="control-label col-lg-3">Confirm Password</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control " id="confirm_password" name="confirm_password" type="password" value="<?php echo $row['password'];  ?>" required />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-lg-offset-3 col-lg-6">
                                                    <button class="btn btn-primary" type="submit" name="submit">Save</button>
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
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/easypiechart/jquery.easypiechart.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>

    <script src="js/bootstrap-switch.js"></script>

    <script type="text/javascript" src="js/fuelux/js/spinner.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-fileupload/bootstrap-fileupload.js"></script>
    <script type="text/javascript" src="js/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
    <script type="text/javascript" src="js/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
    <script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="js/bootstrap-daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript" src="js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
    <script type="text/javascript" src="js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
    <script type="text/javascript" src="js/jquery-multi-select/js/jquery.multi-select.js"></script>
    <script type="text/javascript" src="js/jquery-multi-select/js/jquery.quicksearch.js"></script>

    <script type="text/javascript" src="js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>

    <script src="js/jquery-tags-input/jquery.tagsinput.js"></script>

    <script src="js/select2/select2.js"></script>
    <script src="js/select-init.js"></script>


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

    <script src="js/toggle-init.js"></script>

    <script src="js/advanced-form.js"></script>
    <!--Easy Pie Chart-->
    <script src="js/easypiechart/jquery.easypiechart.js"></script>
    <!--Sparkline Chart-->
    <script src="js/sparkline/jquery.sparkline.js"></script>
    <!--jQuery Flot Chart-->
    <script src="js/flot-chart/jquery.flot.js"></script>
    <script src="js/flot-chart/jquery.flot.tooltip.min.js"></script>
    <script src="js/flot-chart/jquery.flot.resize.js"></script>
    <script src="js/flot-chart/jquery.flot.pie.resize.js"></script>


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>