<!DOCTYPE html>
<?php
	require_once('db/mysql_connect.php');
	
	if (isset($_POST['submit'])){
		
		$flag=0;
		$message=null;
		
		$brand=$_POST['brand'];
		$modelName=$_POST['modelName'];
		$version=$_POST['version'];
		$category=$_POST['category'];
		$specs=$_POST['specs'];
		
		$query1="SELECT count(*) as `isExist` FROM thesis.assetmodel where brand='{$brand}' and assetCategory='{$category}' and itemSpecification='{$specs}' and softwareName='{$version}' and description='{$modelName}'";
		$result1=mysqli_query($dbc,$query1);
		$row1=mysqli_fetch_array($result1,MYSQLI_ASSOC);
		
		if($row1['isExist']!=0){
			$message="Product already exists";
			echo "<script>alert('{$message}');</script>";
		}
		
		
		if(!isset($message)){
			$query2="INSERT INTO `thesis`.`assetmodel` (`brand`, `assetCategory`, `itemSpecification`, `softwareName`, `description`) VALUES ('{$brand}', '{$category}', '{$specs}', '{$version}', '{$modelName}')";
			$result2=mysqli_query($dbc,$query2);
			echo "<script>alert('Success');</script>";
			$flag=1;
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
                                    Add A Product
                                </header>
                                <div class="panel-body">
                                    <div class="position-center">
										
										<form class="form-horizontal" role="form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">

                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label">Brand</label>
                                                <div class="col-lg-10">
                                                    <select class="form-control m-bot15" name="brand" value="<?php if (isset($_POST['brand']) && !$flag) echo $_POST['brand']; ?>" required>
                                                        <option value="">Select Brand</option>
														<?php
														
															$query1="SELECT * FROM thesis.ref_brand";
															$result1=mysqli_query($dbc,$query1);
															while($row1=mysqli_fetch_array($result1,MYSQLI_ASSOC)){
																echo "<option value='{$row1['brandID']}'>{$row1['name']}</option>";
															}
														
														
														?>
                                                        
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="model" class="col-lg-2 col-sm-2 control-label">Model Name</label>
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control" id="model" placeholder="Model Name" name="modelName" value="<?php if (isset($_POST['modelName']) && !$flag) echo $_POST['modelName']; ?>" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Version</label>
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control" id="version" placeholder="Version" name="version" value="<?php if (isset($_POST['version']) && !$flag) echo $_POST['version']; ?>" required> 
												</div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label">Category</label>
                                                <div class="col-lg-10">
                                                    <select class="form-control m-bot15" name="category" value="<?php if (isset($_POST['category']) && !$flag) echo $_POST['category']; ?>" required>
                                                        <option value="">Select Category</option>
														<?php
														
															$query2="SELECT * FROM thesis.ref_assetcategory";
															$result2=mysqli_query($dbc,$query2);
															while($row2=mysqli_fetch_array($result2,MYSQLI_ASSOC)){
																echo "<option value='{$row2['assetCategoryID']}'>{$row2['name']}</option>";
															}
														
														
														?>
                                                    </select>
                                                </div>
                                            </div>
											
											<div class="form-group">
                                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Specification</label>
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control" id="specs" placeholder="Specification" name="specs" value="<?php if (isset($_POST['specs']) && !$flag) echo $_POST['specs']; ?>" required> 
												</div>
                                            </div>


                                            <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">
                                                    <button type="submit" name="submit" class="btn btn-success">Submit</button>
                                                </div>
                                            </div>
                                        </form>
										
										
                                        <!-- <form class="form-horizontal" role="form">

                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label">Brand</label>
                                                <div class="col-lg-10">
                                                    <select class="form-control m-bot15">
                                                        <option>Select Brand</option>
                                                        <option>Samsung</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="model" class="col-lg-2 col-sm-2 control-label">Model Name</label>
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control" id="model" placeholder="Model Name">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Version</label>
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control" id="version" placeholder="Version"> </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label">Category</label>
                                                <div class="col-lg-10">
                                                    <select class="form-control m-bot15">
                                                        <option>Select Category</option>
                                                        <option>LCD</option>
                                                        <option>Laptop</option>
                                                        <option>Software</option>
                                                        <option>VGA</option>
                                                        <option>HDMI</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">
                                                    <button type="submit" class="btn btn-success">Submit</button>
                                                </div>
                                            </div>
                                        </form> -->
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


    <script src="js/scripts.js"></script>

    <script src="js/toggle-init.js"></script>

    <script src="js/advanced-form.js"></script>

</body>

</html>