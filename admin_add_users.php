<!DOCTYPE html>

<?php
	session_start();
	$key = "Fusion";
	require_once('db/mysql_connect.php');
	
	
	if (isset($_POST['submit'])){
		$flag=0;
		$message=NULL;
		
		//Firstname 
		$firstname=$_POST['firstname'];
		
		//Lastname
		$lastname=$_POST['lastname'];
		
		//Fullname
		$fullname=$firstname." ".$lastname;
		
		//User Type
		$usertype=$_POST['usertype'];
        
		//Dept
        $departments=null;
       
		
		//Position
        $position=$_POST['position'];
        
		//number
        $number=$_POST['number'];
        
		//email
        $email=$_POST['email'];
		
		//offices
		
		$office=$_POST['office'];
		
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
			
			//Add to user
			$query="INSERT INTO `thesis`.`user`(`username`, `password`, `userType`, `firstName`, `lastName`) VALUES ( AES_ENCRYPT('{$username}', '{$key}'), AES_ENCRYPT('{$password}', '{$key}'), '{$usertype}', AES_ENCRYPT('{$firstname}', '{$key}'), AES_ENCRYPT('{$lastname}', '{$key}'))";
			$result=mysqli_query($dbc,$query);
            
			//Get latest user id
            $query2="SELECT * FROM thesis.user order by UserID desc limit 1";
            $result2=mysqli_query($dbc,$query2);
            $row=mysqli_fetch_array($result2, MYSQLI_ASSOC);
               
            //Add to employee
			
			if(empty($office)){
				$query3="INSERT INTO `thesis`.`employee` (`name`, `position`, `contactNo`, `email`, `UserID`) VALUES ('{$fullname}', '{$position}', '{$number}', '{$email}', '{$row['UserID']}')";
				$result3=mysqli_query($dbc,$query3);
			}
            else{
				$query3="INSERT INTO `thesis`.`employee` (`name`, `position`, `contactNo`, `email`, `UserID`, `officeID`) VALUES ('{$fullname}', '{$position}', '{$number}', '{$email}', '{$row['UserID']}', '{$office}')";
				$result3=mysqli_query($dbc,$query3);
			}
			
			//Get latest employee
			$queryLatEmp="SELECT * FROM thesis.employee order by employeeID desc limit 1";
            $resultLatEmp=mysqli_query($dbc,$queryLatEmp);
			$rowLatEmp=mysqli_fetch_array($resultLatEmp, MYSQLI_ASSOC);
			
			if(isset($_POST['departments'])){
				$departments=$_POST['departments'];
				//INSERT INTO department list
				foreach($departments as $department){
					$queryDepList="INSERT INTO `thesis`.`department_list` (`DepartmentID`, `employeeID`) VALUES ('{$department}', '{$rowLatEmp['employeeID']}')";
					$resultDepList=mysqli_query($dbc,$queryDepList);
				}
			}
			
			$_SESSION['submitMessage'] = "Success! The user has been added successfully.";
			$flag=1;
		}
		
		else{
			$_SESSION['submitMessage'] = $message;
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
				<?php
					if(isset($_SESSION['submitMessage'])&&$_SESSION['submitMessage']!="Success! The user has been added successfully."){
						echo "<div class='alert alert-danger'>
                                {$_SESSION['submitMessage']}
							  </div>";
                        unset($_SESSION['submitMessage']);
					}
					elseif (isset($_SESSION['submitMessage'])){
                        echo "<div class='alert alert-success'>
                                {$_SESSION['submitMessage']}
							  </div>";
                        unset($_SESSION['submitMessage']);
                    }
				?>
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
                                                        <option value="8">Student</option>
                                                        <option value="5">Faculty</option>
                                                        <option value="2">IT Office</option>
                                                        <option value="3">Helpdesk</option>
                                                        <option value="6">Procurement</option>
                                                        <option value="4">Engineer</option>
                                                        <!-- did some changes in ref_usertype -->
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-3">Department</label>
                                                <div class="col-lg-6">
                                                    <select multiple name="departments[]" id="e9" style="width:525px" class="populate">
                                                        <optgroup label="Select Department/s">
															<?php
																$queryDept="SELECT * FROM thesis.department";
																$resultDept=mysqli_query($dbc,$queryDept);
																while($rowDept=mysqli_fetch_array($resultDept,MYSQLI_ASSOC)){
																	echo "<option value='{$rowDept['DepartmentID']}'>{$rowDept['name']}</option>";
																}
															?>
                                                            <!--<option value="1">Accounting</option>
                                                            <option value="2">Computer Studies</option>-->
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="lastname" class="control-label col-lg-3">Office</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15" name="office" value="<?php if (isset($_POST['office']) && !$flag) echo $_POST['office']; ?>" required>
														<?php
																$queryOff="SELECT * FROM thesis.offices";
																$resultOff=mysqli_query($dbc,$queryOff);
																while($rowOff=mysqli_fetch_array($resultOff,MYSQLI_ASSOC)){
																	echo "<option value='{$rowOff['officeID']}'>{$rowOff['Name']}</option>";
																}
															
														?>
                                                        <option value='' selected>None</option>
                                                    </select>
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
    <script>
        function getRooms(val) {
            $.ajax({
                type: "POST",
                url: "requestor_getRooms.php",
                data: 'buildingID=' + val,
                success: function(data) {
                    $("#FloorAndRoomID").html(data);

                }
            });
        }
    </script>
</body>

</html>