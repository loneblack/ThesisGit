<!DOCTYPE html>
<html lang="en">

<?php 
    session_start();
    require_once('db/mysql_connect.php');
    
    if (isset($_POST['submit'])){
		$flag=0;
		$message=NULL;
        
        $user = $_POST['user'];
        
        $assets=null;
       
        $checkinDate = $_POST['checkinDate'];
		
		if(!isset($message)){
			
			//Add to user
			$query="INSERT INTO `thesis`.`user`(`username`, `password`, `userType`, `firstName`, `lastName`) VALUES ( AES_ENCRYPT('{$username}', '{$key}'), AES_ENCRYPT('{$password}', '{$key}'), '{$usertype}', AES_ENCRYPT('{$firstname}', '{$key}'), AES_ENCRYPT('{$lastname}', '{$key}'))";
			$result=mysqli_query($dbc,$query);
            
			//Get latest user id
            $query2="SELECT * FROM thesis.user order by UserID desc limit 1";
            $result2=mysqli_query($dbc,$query2);
            $row=mysqli_fetch_array($result2, MYSQLI_ASSOC);
               
            //Add to employee
			
			
			$query3="INSERT INTO `thesis`.`employee` (`name`, `position`, `contactNo`, `email`, `UserID`) VALUES ('{$fullname}', '{$position}', '{$number}', '{$email}', '{$row['UserID']}')";
			$result3=mysqli_query($dbc,$query3);
		
			
			//Get latest employee
			$queryLatEmp="SELECT * FROM thesis.employee order by employeeID desc limit 1";
            $resultLatEmp=mysqli_query($dbc,$queryLatEmp);
			$rowLatEmp=mysqli_fetch_array($resultLatEmp, MYSQLI_ASSOC);
			
			if(isset($_POST['assets'])){
				$assets=$_POST['assets'];
				//INSERT INTO department list
				foreach($assets as $asset){
					$queryDepList="INSERT INTO `thesis`.`department_list` (`DepartmentID`, `employeeID`) VALUES ('{$department}', '{$rowLatEmp['employeeID']}')";
					$resultDepList=mysqli_query($dbc,$queryDepList);
				}
			}
			
			$_SESSION['submitMessage'] = "Checkout of Asset Success!";
			$flag=1;
		}
		
		else{
			$_SESSION['submitMessage'] = $message;
		}
		
		
	}
    
?>


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
                                    Checkout Asset
                                </header>
                                <div class="panel-body">
                                    <div class="position-center">
                                        <form class="form-horizontal" role="form" id="checkoutForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                                            <div class="form-group">
                                                <label for="brand" class="col-lg-2 col-sm-2 control-label">Checkout To</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control" name="user" value="<?php if (isset($_POST['user']) and !$flag) echo $_POST['name']; ?>" required>
                                                            <optgroup label="Faculty/ Staff">
                                                                <?php 
                                                                        $query="SELECT u.userID, u.id AS `idnum`, e.name FROM user u 
                                                                        JOIN employee e ON e.employeeID = u.userID
                                                                        WHERE u.userType = 5;";
                                                                        $result=mysqli_query($dbc,$query);

                                                                        while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                                                                            echo "<option value='{$row['userID']}'>({$row['idnum']}) -  {$row['name']} </option>";
                                                                        }
                                                                ?>
                                                            </optgroup>
                                                        
                                                            <optgroup label="Students">
                                                                <?php 
                                                                        $querya="SELECT u.userID, u.id AS `idnum`, e.name FROM user u 
                                                                        JOIN employee e ON e.employeeID = u.userID
                                                                        WHERE u.userType = 8;";
                                                                        $resulta=mysqli_query($dbc,$querya);

                                                                        while($rowa=mysqli_fetch_array($resulta,MYSQLI_ASSOC)){
                                                                            echo "<option value='{$rowa['userID']}'>({$rowa['idnum']}) -  {$rowa['name']} </option>";
                                                                        }
                                                                ?>
                                                            </optgroup>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-2 col-sm-2">Expected Checkin Date</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control form-control-inline" size="10" type="date" min="<?php echo date('Y-m-d'); ?>" name="checkinDate" value="<?php if (isset($_POST['checkinDate']) and !$flag) echo $_POST['checkinDate']; ?>" required />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label">Select Asset</label>
                                                <div class="col-lg-6">
                                                    <select multiple name="e9" id="e9" style="width:300px" class="populate" name="asset[]">


                                                        <optgroup label="HDMI Cable">
                                                            <option value="" class="hidden"></option>
                                                            <?php 
                                                                $query1="SELECT a.assetID, a.propertyCode, rb.name AS `brand`, am.description AS `model` FROM asset a 
                                                                LEFT JOIN assetmodel am ON a.assetModel = am.assetModelID
                                                                LEFT JOIN ref_brand rb ON am.brand = rb.brandID
                                                                LEFT JOIN ref_assetcategory rac ON am.assetCategory = rac.assetCategoryID
                                                                LEFT JOIN ref_assetstatus ras ON a.assetStatus = ras.id
                                                                WHERE rac.name = 'HDMI Cable' AND ras.id = 1;";
                                                                $result1=mysqli_query($dbc,$query1);

                                                                while($rowCab=mysqli_fetch_array($result1,MYSQLI_ASSOC)){
                                                                    echo "<option value='{$rowCab['assetID']}'>{$rowCab['propertyCode']} -  {$rowCab['brand']} {$rowCab['model']}</option>";
                                                                }
                                                            ?>
                                                        </optgroup>


                                                        <optgroup label="Extension">
                                                            <option value="" class="hidden"></option>
                                                            <?php 
                                                                $query2="SELECT a.assetID, a.propertyCode, rb.name AS `brand`, am.description AS `model` FROM asset a 
                                                                LEFT JOIN assetmodel am ON a.assetModel = am.assetModelID
                                                                LEFT JOIN ref_brand rb ON am.brand = rb.brandID
                                                                LEFT JOIN ref_assetcategory rac ON am.assetCategory = rac.assetCategoryID
                                                                LEFT JOIN ref_assetstatus ras ON a.assetStatus = ras.id
                                                                WHERE rac.name = 'Extension' AND ras.id = 1;";
                                                                $result2=mysqli_query($dbc,$query2);

                                                                while($rowExt=mysqli_fetch_array($result2,MYSQLI_ASSOC)){
                                                                    echo "<option value='{$rowExt['assetID']}'>{$rowExt['propertyCode']} -  {$rowExt['brand']} {$rowExt['model']}</option>";
                                                                }
                                                            ?>
                                                        </optgroup>


                                                        <optgroup label="Laptop">
                                                            <option value="" class="hidden"></option>
                                                            <?php 
                                                                $query3="SELECT a.assetID, a.propertyCode, rb.name AS `brand`, am.description AS `model` FROM asset a 
                                                                LEFT JOIN assetmodel am ON a.assetModel = am.assetModelID
                                                                LEFT JOIN ref_brand rb ON am.brand = rb.brandID
                                                                LEFT JOIN ref_assetcategory rac ON am.assetCategory = rac.assetCategoryID
                                                                LEFT JOIN ref_assetstatus ras ON a.assetStatus = ras.id
                                                                WHERE rac.name = 'Laptop' AND ras.id = 1;";
                                                                $result3=mysqli_query($dbc,$query3);

                                                                while($rowLap=mysqli_fetch_array($result3,MYSQLI_ASSOC)){
                                                                    echo "<option value='{$rowLap['assetID']}'>{$rowLap['propertyCode']} -  {$rowLap['brand']} {$rowLap['model']}</option>";
                                                                }
                                                            ?>
                                                        </optgroup>

                                                        <optgroup label="Projector">
                                                            <option value="" class="hidden"></option>
                                                            <?php 
                                                                $query5="SELECT a.assetID, a.propertyCode, rb.name AS `brand`, am.description AS `model` FROM asset a 
                                                                LEFT JOIN assetmodel am ON a.assetModel = am.assetModelID
                                                                LEFT JOIN ref_brand rb ON am.brand = rb.brandID
                                                                LEFT JOIN ref_assetcategory rac ON am.assetCategory = rac.assetCategoryID
                                                                LEFT JOIN ref_assetstatus ras ON a.assetStatus = ras.id
                                                                WHERE rac.name = 'Projector' AND ras.id = 1;";
                                                                $result5=mysqli_query($dbc,$query5);

                                                                while($rowPro=mysqli_fetch_array($result5,MYSQLI_ASSOC)){
                                                                    echo "<option value='{$rowPro['assetID']}'>{$rowPro['propertyCode']} -  {$rowPro['brand']} {$rowPro['model']}</option>";
                                                                }
                                                            ?>
                                                        </optgroup>


                                                        <optgroup label="VGA">
                                                            <option value="" class="hidden"></option>
                                                            <?php 
                                                                $query4="SELECT a.assetID, a.propertyCode, rb.name AS `brand`, am.description AS `model` FROM asset a 
                                                                LEFT JOIN assetmodel am ON a.assetModel = am.assetModelID
                                                                LEFT JOIN ref_brand rb ON am.brand = rb.brandID
                                                                LEFT JOIN ref_assetcategory rac ON am.assetCategory = rac.assetCategoryID
                                                                LEFT JOIN ref_assetstatus ras ON a.assetStatus = ras.id
                                                                WHERE rac.name = 'VGA Cable' AND ras.id = 1;";
                                                                $result4=mysqli_query($dbc,$query4);

                                                                while($rowvga=mysqli_fetch_array($result4,MYSQLI_ASSOC)){
                                                                    echo "<option value='{$rowvga['assetID']}'>{$rowvga['propertyCode']} -  {$rowvga['brand']} {$rowvga['model']}</option>";
                                                                }
                                                            ?>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">
                                                    <button type="submit" class="btn btn-success">Checkout</button>
                                                    <button class="btn btn-danger">Cancel</button>
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


    <script src="js/scripts.js"></script>

    <script src="js/toggle-init.js"></script>

    <script src="js/advanced-form.js"></script>

</body>

</html>