<!DOCTYPE html>
<?php

	require_once('mysql_connect.php');
	$_SESSION['categoryid']=$_GET['categoryid'];
	
	$query="SELECT * FROM thesis.ref_servicetype where id='{$_SESSION['categoryid']}'";
	$result=mysqli_query($dbc,$query);
	$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
	
	if (isset($_POST['submit'])){
		
		$categoryName=$_POST['categoryName'];
		$description=$_POST['description'];

		$query1="UPDATE `thesis`.`ref_servicetype` SET `serviceType`='{$categoryName}', `description`='{$description}' WHERE `id`='{$_SESSION['categoryid']}'";
		$result1=mysqli_query($dbc,$query1);
			
		echo "<script type='text/javascript'>alert('Success');</script>"; // Show modal
		$flag=1;
		
		$query="SELECT * FROM thesis.ref_servicetype where id='{$_SESSION['categoryid']}'";
		$result=mysqli_query($dbc,$query);
		$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
		
		//header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/helpdesk_edit_category.php?categoryid={$_SESSION['categoryid']}");
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
                    Welcome Helpdesk!
                </a>
            </div>

            <div class="nav notify-row" id="top_menu">

            </div>

        </header>
        <!--header end-->
        <?php include 'helpdesk_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">


                            <section class="panel">
                                <header class="panel-heading">
                                    Edit Category
                                </header>
                                <div class="panel-body">
                                    <div class="position-center">
                                        <form class="form-horizontal" role="form" method="post" action="<?php echo $_SERVER['PHP_SELF']."?categoryid={$_SESSION['categoryid']}"; ?>">

                                            <div class="form-group">
                                                <label for="name" class="col-lg-2 col-sm-2 control-label">Name</label>
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control" id="name" name="categoryName" value="<?php echo $row['serviceType'];  ?>" required>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="ccomment" class="col-lg-2 col-sm-2 control-label">Description</label>
                                                <div class="col-lg-10">
                                                    <textarea class="form-control " id="description" name="description" required><?php echo $row['description']; ?></textarea>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">
                                                    <button type="submit" class="btn btn-success" name="submit">Submit</button>
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