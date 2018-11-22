<!DOCTYPE html>
<?php

	require_once('db/mysql_connect.php');
	$assetCategoryID=$_GET['assetCategoryID'];
	
	$query="SELECT ac.name, i.floorLevel, i.ceilingLevel FROM ref_assetcategory ac
	JOIN inventory i ON ac.assetCategoryID = i.assetCategoryID where ac.assetCategoryID='{$assetCategoryID}'";
	$result=mysqli_query($dbc,$query);
	$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
	
	if (isset($_POST['submit'])){
		
		$message=null;
		$query1="SELECT * FROM thesis.ref_assetcategory";
		$result1=mysqli_query($dbc,$query1);
		
        $floorLevel = $_POST['floorLevel'];
        $ceilingLevel = $_POST['ceilingLevel'];
        
		if(!isset($message)){
			$query2="UPDATE inventory SET floorLevel = '{$floorLevel}', ceilingLevel = '{$ceilingLevel}' WHERE `assetCategoryID`='{$assetCategoryID}'";
			$result2=mysqli_query($dbc,$query2);
			echo "<script>alert('Success');</script>";
            header("Location: http://".$_SERVER['HTTP_HOST']. dirname($_SERVER['PHP_SELF'])."/it_edit_category.php?assetCategoryID=".$assetCategoryID);
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
                                        <form class="form-horizontal" role="form" method="post">

                                            <div class="form-group">
                                                <label for="category" class="col-lg-2 col-sm-2 control-label">Category Name</label>
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control" id="category" placeholder="Category Name" name="assetCategoryName" value="<?php echo $row['name'];  ?>" disabled>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="category" class="col-lg-2 col-sm-2 control-label">Floor Level</label>
                                                <div class="col-lg-10">
                                                    <input type="number" class="form-control" id="floorLevel" placeholder="Floor Level" name="floorLevel" value="<?php echo $row['floorLevel'];  ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="category" class="col-lg-2 col-sm-2 control-label">Ceiling Level</label>
                                                <div class="col-lg-10">
                                                    <input type="number" class="form-control" id="ceilingLevel" placeholder="Ceiling Level" name="ceilingLevel" value="<?php echo $row['ceilingLevel'];  ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">
                                                    <button type="submit" class="btn btn-success" name="submit">Submit</button>
                                                    <a href="it_categories.php"><button type="button" class="btn btn-danger" name="submit">Back</button></a>
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