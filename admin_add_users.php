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
        
        $building=$_POST['building'];
        
        $room=$_POST['room'];
        
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
            
            $query4="INSERT INTO `thesis`.`floorandroom` (`BuildingID`, `floorRoom`) VALUES ('".$building."', '".$room."');";
            $result4=mysqli_query($dbc,$query4);
            
            $query5 = "SELECT MAX(FloorAndRoomID) AS `max` FROM floorandroom;";
            $result5 =mysqli_query($dbc,$query5);
            $frID = mysqli_fetch_array($result5, MYSQLI_ASSOC);
            
            $query3="INSERT INTO `thesis`.`employee` (`DepartmentID`, `name`, `position`, `contactNo`, `email`, `UserID`,`FloorAndRoomID`) VALUES ('".$department."', '".$firstname." ".$lastname."', '".$position."', '".$number."', '".$email."', '".$userID."', '".$frID['max']."');";
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
                                                <label for="lastname" class="control-label col-lg-3">User Type</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15" name="usertype" value="<?php if (isset($_POST['usertype']) && !$flag) echo $_POST['usertype']; ?>" required>
                                                        <option value="" disabled selected>Select User Type</option>
                                                        <option value="1">Student</option>
                                                        <option value="2">IT Office</option>
                                                        <option value="3">Helpdesk</option>
                                                        <option value="6">Procurement</option>
                                                        <option value="4">Engineer</option>
														<!-- did some changes in ref_usertype -->
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group ">
                                                <label for="lastname" class="control-label col-lg-3">Department</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15" name="department" value="<?php if (isset($_POST['department']) && !$flag) echo $_POST['department']; ?>" required>
                                                        <option value="" disabled selected>Select Department</option>
                                                        <?php
																		
																		$sql = "SELECT * FROM thesis.department;";

                                                                        $result = mysqli_query($dbc, $sql);

                                                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                                        {   
                                                                            echo "<option value ={$row['DepartmentID']}>";
                                                                            echo "{$row['name']}</option>";
                                                                        }
																	?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group ">
                                                <label for="lastname" class="control-label col-lg-3">Building</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15" name="building" value="<?php if (isset($_POST['building']) && !$flag) echo $_POST['building']; ?>" required>
                                                        <option value="" disabled selected>Select Building</option>
                                                        <?php
																		
																		$sql = "SELECT * FROM thesis.building;";

                                                                        $result = mysqli_query($dbc, $sql);

                                                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                                        {   
                                                                            echo "<option value ={$row['BuildingID']}>";
                                                                            echo "{$row['name']}</option>";
                                                                        }
												        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group ">
                                                <label for="lastname" class="control-label col-lg-3">Room</label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" id="room" name="room" value="<?php if (isset($_POST['room']) && !$flag) echo $_POST['room']; ?>" required>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group ">
                                                <label for="lastname" class="control-label col-lg-3">Position</label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" id="position" name="position" value="<?php if (isset($_POST['position']) && !$flag) echo $_POST['position']; ?>" required>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group ">
                                                <label for="lastname" class="control-label col-lg-3">Contact Number</label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" id="number" name="number" value="<?php if (isset($_POST['number']) && !$flag) echo $_POST['number']; ?>" required>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group ">
                                                <label for="lastname" class="control-label col-lg-3">Email</label>
                                                <div class="col-lg-6">
                                                    <input type="email" class="form-control" id="email" name="email" value="<?php if (isset($_POST['email']) && !$flag) echo $_POST['email']; ?>" required>
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