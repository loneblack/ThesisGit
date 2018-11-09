<!DOCTYPE html>
<?php

	require_once('db/mysql_connect.php');
	$assetCategoryID=$_GET['assetCategoryID'];
	
	$query="SELECT * FROM thesis.ref_assetcategory where assetCategoryID='{$assetCategoryID}'";
	$result=mysqli_query($dbc,$query);
	$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
	
	if (isset($_POST['submit'])){
		
		$message=null;
		$query1="SELECT * FROM thesis.ref_assetcategory";
		$result1=mysqli_query($dbc,$query1);
		$assetCategoryName=$_POST['assetCategoryName'];

		while($row1=mysqli_fetch_array($result1,MYSQLI_ASSOC)){
			if(strcasecmp($assetCategoryName, $row1['name'])==0){
				$message="Asset Category already exists";
				echo "<script>alert('{$message}');</script>";
			}
		}
		
		if(!isset($message)){
			$query2="UPDATE `thesis`.`ref_assetcategory` SET `name`='{$assetCategoryName}' WHERE `assetCategoryID`='{$assetCategoryID}'";
			$result2=mysqli_query($dbc,$query2);
			echo "<script>alert('Success');</script>";
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
                    Welcome IT Officer!
                </a>
            </div>

            <div class="nav notify-row" id="top_menu">

            </div>

        </header>
        <!--header end-->
        <?php include 'it_navbar.php' ?>

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
                                        <form class="form-horizontal" role="form" method="post" action="<?php echo $_SERVER['PHP_SELF']."?assetCategoryID=".$assetCategoryID; ?>">

                                            <div class="form-group">
                                                <label for="category" class="col-lg-2 col-sm-2 control-label">Category Name</label>
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control" id="category" placeholder="Category Name" name="assetCategoryName" value="<?php echo $row['name'];  ?>" required>
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