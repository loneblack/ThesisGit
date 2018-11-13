<!DOCTYPE html>
<?php
	$flag=0;
	require_once('mysql_connect.php');
	
	if (isset($_POST['submit'])){
		$message=NULL;
		
		//Company Name
		$companyName=$_POST['companyName'];
		
		//Contact Person
		$contactPerson=$_POST['contactPerson'];
		
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
		
		//Email
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$email=FALSE;
			$message.="Invalid email format. ";
		}
		else
			$email=$_POST['email'];
		
		//Address
		$address=$_POST['address'];
		
		if(!isset($message)){
			$query="INSERT INTO `thesis`.`supplier` (`name`, `contactNo`, `email`, `contactPerson`, `address`) VALUES ('{$companyName}', '{$number}', '{$email}', '{$contactPerson}', '{$address}')";
			$result=mysqli_query($dbc,$query);
			
			echo "<script type='text/javascript'>alert('Success');</script>"; // Show modal
			$flag=1;
		}
		else{
			echo "<script type='text/javascript'>alert('{$message}');</script>";
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
        <?php include 'procurement_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-lg-12">
                            <section class="panel">
                                <header class="panel-heading">
                                    Add A Supplier
                                </header>
                                <div class="panel-body">
                                    <div class="form" method="post">
                                        <form class="cmxform form-horizontal " id="signupForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                            <div class="form-group ">
                                                <label for="companyName" class="control-label col-lg-3">Company Name</label>
                                                <div class="col-lg-6">
                                                    <input class=" form-control" id="companyName" name="companyName" type="text" value="<?php if (isset($_POST['companyName']) && !$flag) echo $_POST['companyName']; ?>" required />
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="contactPerson" class="control-label col-lg-3">Contact Person</label>
                                                <div class="col-lg-6">
                                                    <input class=" form-control" id="contactPerson" name="contactPerson" type="text" value="<?php if (isset($_POST['contactPerson']) && !$flag) echo $_POST['contactPerson']; ?>" required />
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="lastname" class="control-label col-lg-3">Contact Number</label>
                                                <div class="col-lg-6">
                                                    <input class=" form-control" id="number" name="number" type="number" min="0.00" value="<?php if (isset($_POST['number']) && !$flag) echo $_POST['number']; ?>" required />
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="email" class="control-label col-lg-3">Email (DLSU)</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control " id="email" name="email" type="email" value="<?php if (isset($_POST['email']) && !$flag) echo $_POST['email']; ?>" required />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Address</label>
                                                <div class="col-sm-6" name="address" id="address">
                                                    <textarea class="form-control" rows="6" name="address" required><?php if (isset($_POST['address']) && !$flag) echo $_POST['address']; ?></textarea>
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