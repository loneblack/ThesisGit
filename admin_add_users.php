<!DOCTYPE html>

<?php

	$flag=0;
	$key = "Fusion";
	require_once('mysql_connect.php');
	
	if (isset($_POST['submit'])){
		
		$message=NULL;
		
		//Firstname 
		$firstname=$_POST['firstname'];
		
		//Lastname
		$lastname=$_POST['lastname'];
		
		//Contact Number
		if (!is_numeric($_POST['number'])) {
            $number=FALSE; 
			$message.="Contact number entered is invalid. ";   
        }
		elseif($_POST['number']<0){
			$number=FALSE;
			$message.="Contact number entered is invalid. ";
		}
		else{
			$number=$_POST['number'];
		}
		
		//User Type
		$usertype=$_POST['usertype'];
		
		//User Name
		
		$checkQuery1 = "SELECT CONVERT(AES_DECRYPT(userName, '{$key}') USING utf8) FROM user WHERE username = AES_ENCRYPT('{$_POST['username']}', '{$key}');";
		$checkResult1 = mysqli_query($dbc, $checkQuery1);
		
		if($checkResult1->num_rows > 0){
			$username=FALSE;
			$message.="Username already exists. ";
		}
		else
			$username=$_POST['username'];
		
		//Password
		if($_POST['password']!=$_POST['confirm_password']){
			$password=FALSE;
			$message.="Passwords entered does not match. ";
		}
		else{
			$password=$_POST['password'];
		}
		
		//Email
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$email=FALSE;
			$message.="Invalid email format. ";
		}
		else
			$email=$_POST['email'];
		
		if(!isset($message)){
			
			$query="INSERT INTO `thesis`.`user`(`username`, `password`, `userType`, `firstName`, `lastName`, `email`, `contactNo`) VALUES ( AES_ENCRYPT('".$username."', '".$key."'), AES_ENCRYPT('".$password."', '".$key."'), '".$usertype."', AES_ENCRYPT('".$firstname."', '".$key."'), AES_ENCRYPT('".$lastname."', '".$key."'), AES_ENCRYPT('".$email."', '".$key."'), AES_ENCRYPT('".$number."', '".$key."'))";
			
			$result=mysqli_query($dbc,$query);
			
			echo "<script type='text/javascript'>alert('Success');</script>"; // Show modal
			$flag=1;
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
                    Welcome Admin!
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
                                    Register A User
                                </header>
                                <div class="panel-body">
                                    <div class="form">
                                        <form class="cmxform form-horizontal " id="signupForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                            <div class="form-group ">
                                                <label for="firstname" class="control-label col-lg-3">Firstname</label>
                                                <div class="col-lg-6">
                                                    <input class=" form-control" id="firstname" name="firstname" type="text" value="<?php if (isset($_POST['firstname']) && !$flag) echo $_POST['firstname']; ?>" required />
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label for="lastname" class="control-label col-lg-3">Lastname</label>
                                                <div class="col-lg-6">
                                                    <input class=" form-control" id="lastname" name="lastname" type="text" value="<?php if (isset($_POST['lastname']) && !$flag) echo $_POST['lastname']; ?>" required />
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label for="lastname" class="control-label col-lg-3">Contact Number</label>
                                                <div class="col-lg-6">
                                                    <input class=" form-control" id="number" name="number" type="number" min="0.00" value="<?php if (isset($_POST['number']) && !$flag) echo $_POST['number']; ?>" required />
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label for="lastname" class="control-label col-lg-3">User Type</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15" name="usertype" value="<?php if (isset($_POST['usertype']) && !$flag) echo $_POST['usertype']; ?>" required>
                                                        <option value="" disabled selected>Select User Type</option>
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
                                                    <input class="form-control " id="username" name="username" type="text" value="<?php if (isset($_POST['username']) && !$flag) echo $_POST['username']; ?>" required />
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label for="password" class="control-label col-lg-3">Password</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control " id="password" name="password" type="password" value="<?php if (isset($_POST['password']) && !$flag) echo $_POST['password']; ?>" required />
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label for="confirm_password" class="control-label col-lg-3">Confirm Password</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control " id="confirm_password" name="confirm_password" type="password" value="<?php if (isset($_POST['confirm_password']) && !$flag) echo $_POST['confirm_password']; ?>" required />
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label for="email" class="control-label col-lg-3">Email (DLSU)</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control " id="email" name="email" type="email" value="<?php if (isset($_POST['email']) && !$flag) echo $_POST['email']; ?>" required />
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
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>

    
    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>