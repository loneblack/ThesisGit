<!DOCTYPE html>

<?php

	$flag=0;
	$key = "Fusion";
	require_once('db/mysql_connect.php');
	
	if (isset($_POST['submit'])){
		
		$message=NULL;
		
		//Firstname 
		$firstname=$_POST['firstname'];
		
		//Lastname
		$lastname=$_POST['lastname'];
		
		//User Type
		$usertype=$_POST['usertype'];
        
        $department=$_POST['department'];
        
        $position=$_POST['position'];
        
        $number=$_POST['number'];
        
        $email=$_POST['email'];
		
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
		
		if(!isset($message)){
			
			$query="INSERT INTO `thesis`.`user`(`username`, `password`, `userType`, `firstName`, `lastName`) VALUES ( AES_ENCRYPT('".$username."', '".$key."'), AES_ENCRYPT('".$password."', '".$key."'), '".$usertype."', AES_ENCRYPT('".$firstname."', '".$key."'), AES_ENCRYPT('".$lastname."', '".$key."'))";
			$result=mysqli_query($dbc,$query);
            
            $query2="SELECT MAX(userid) AS 'id' FROM USER";
            $result2=mysqli_query($dbc,$query2);
            
            while($row=mysqli_fetch_array($result2, MYSQLI_ASSOC)){
                $userID = $row['id'];
            }
            
            
            $query3="INSERT INTO `thesis`.`employee` (`DepartmentID`, `name`, `position`, `contactNo`, `email`, `UserID`) VALUES ('".$department."', '".$firstname." ".$lastname."', '".$position."', '".$number."', '".$email."', '".$userID."');";
            $result3=mysqli_query($dbc,$query3);
			
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
                                    Add A School Year
                                </header>
                                <div class="panel-body">
                                    <div class="form">
                                        <form class="cmxform form-horizontal " id="signupForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<!--
                                            <div class="form-group ">
                                                <label for="firstname" class="control-label col-lg-3">Firstname</label>
                                                <div class="col-lg-6">
                                                    <input class=" form-control" id="firstname" name="firstname" type="text" value="<?php //if (isset($_POST['firstname']) && !$flag) echo $_POST['firstname']; ?>" required />
                                                </div>
                                            </div>
-->
                                            
                                            <div class="form-group ">
                                                <label for="firstname" class="control-label col-lg-3">School Year</label>
                                                <div class="col-lg-6">
                                                    <input class=" form-control" id="firstname" name="firstname" type="text" value="<?php if (isset($_POST['firstname']) && !$flag) echo $_POST['firstname']; ?>" required />
                                                </div>
                                            </div>
                                            
                                            <div class="form-group ">
                                                <label for="firstname" class="control-label col-lg-3">Term 1 Start </label>
                                                <div class="col-lg-6">
                                                    <input class="form-control" placeholder="YYYY-MM-DD" type="text" required />
                                                </div>
                                            </div>
                                            
                                            <div class="form-group ">
                                                <label for="firstname" class="control-label col-lg-3">Term 1 End </label>
                                                <div class="col-lg-6">
                                                    <input class="form-control" placeholder="YYYY-MM-DD" type="text" required />
                                                </div>
                                            </div>
                                            
                                            <div class="form-group ">
                                                <label for="firstname" class="control-label col-lg-3">Term 2 Start </label>
                                                <div class="col-lg-6">
                                                    <input class="form-control" placeholder="YYYY-MM-DD" type="text" required />
                                                </div>
                                            </div>
                                            
                                            <div class="form-group ">
                                                <label for="firstname" class="control-label col-lg-3">Term 2 End </label>
                                                <div class="col-lg-6">
                                                    <input class="form-control" placeholder="YYYY-MM-DD" type="text" required />
                                                </div>
                                            </div>
                                            
                                            <div class="form-group ">
                                                <label for="firstname" class="control-label col-lg-3">Term 3 Start </label>
                                                <div class="col-lg-6">
                                                    <input class="form-control" name="t3s   " placeholder="YYYY-MM-DD" type="text" required />
                                                </div>
                                            </div>
                                            
                                            <div class="form-group ">
                                                <label for="firstname" class="control-label col-lg-3">Term 3 End </label>
                                                <div class="col-lg-6">
                                                    <input class="form-control" name="t3e" placeholder="YYYY-MM-DD" type="text" required />
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">
                                                    <button type="submit" name="submit" class="btn btn-success">Submit</button>
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