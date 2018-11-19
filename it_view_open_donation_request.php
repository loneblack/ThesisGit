<!DOCTYPE html>
<?php
	session_start();
	require_once("db/mysql_connect.php");
	$donationID=$_GET['id'];
	$query="SELECT * FROM thesis.donation where donationID='{$donationID}' limit 1";
	$result=mysqli_query($dbc,$query);
	$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	if(isset($_POST['approve'])){
		$assetCategoryID=$_POST['assetCategoryID'];
		$propCode=$_POST['propCode'];
		
		//Update status
		$queryApp="UPDATE `thesis`.`donation` SET `statusID`='2',`stepsID`='9' WHERE `donationID`='1'";
		$resultApp=mysqli_query($dbc,$queryApp);
		
		//Get donation data
		$queryDonDat="SELECT * FROM thesis.donation where `donationID`='{$donationID}'";
		$resultDonDat=mysqli_query($dbc,$queryDonDat);
		$rowDonDat=mysqli_fetch_array($resultDonDat, MYSQLI_ASSOC);
		
		//Create asset testing
		$queryAssT="INSERT INTO `thesis`.`assettesting` (`statusID`, `PersonRequestedID`, `serviceType`) VALUES ('1', '{$rowDonDat['user_UserID']}', '25');";
		$resultAssT=mysqli_query($dbc,$queryAssT);
		
		//GET asset testing data
		$queryAssTData="SELECT * FROM thesis.assettesting order by testingID desc limit 1";
		$resultAssTData=mysqli_query($dbc,$queryAssTData);
		$rowAssTData=mysqli_fetch_array($resultAssTData, MYSQLI_ASSOC);
		
		foreach(array_combine($assetCategoryID, $propCode) as $assetCatId => $asset){
			//Update donation details
			$queryDonDet1="UPDATE `thesis`.`donationdetails` SET `assetID`='{$asset}' WHERE `donationID`='{$donationID}' and assetCategoryID='{$assetCatId}'";
			$resultDonDet1=mysqli_query($dbc,$queryDonDet1);
			
			//INSERT to Asset testing details
			$queryAssTDet="INSERT INTO `thesis`.`assettesting_details` (`assettesting_testingID`, `asset_assetID`) VALUES ('{$rowAssTData['testingID']}', '{$asset}');";
			$resultAssTDet=mysqli_query($dbc,$queryAssTDet);	
		}
		
		$message = "Form submitted!";
		$_SESSION['submitMessage'] = $message; 
		
	}
	if(isset($_POST['disapprove'])){
		
		//Update status
		$queryDisapp="UPDATE `thesis`.`donation` SET `reason`='{$_POST['reason']}', `statusID`='5' WHERE `donationID`='{$donationID}'";
		$resultDisapp=mysqli_query($dbc,$queryDisapp);
		
		$message = "Form submitted!";
		$_SESSION['submitMessage'] = $message; 
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
    <link rel="stylesheet" href="js/morris-chart/morris.css">
    <!--dynamic table-->
    <link href="js/advanced-datatable/css/demo_page.css" rel="stylesheet" />
    <link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/data-tables/DT_bootstrap.css" />

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
				<?php
                    if (isset($_SESSION['submitMessage'])){

                        echo "<div class='alert alert-success'>
                                {$_SESSION['submitMessage']}
							  </div>";
                        unset($_SESSION['submitMessage']);
                    }
				?>
                <div class="col-sm-12">
                    <div class="col-sm-12">
						<form method="post">
						<div class="row">
                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="panel">
                                        <header class="panel-heading">
                                            View Donation Request
                                        </header>
                                        <div class="panel-body">
                                            <button class="btn btn-danger" onclick="location.href='it_requests.php'">Back</button>
                                            <h5><b>Office/ Department/ School Organization: <?php 
																							if(isset($row['organizationID'])){
																								$queryOrg="SELECT * FROM thesis.organization where id='{$row['organizationID']}'";
																								$resultOrg=mysqli_query($dbc,$queryOrg);
																								$rowOrg=mysqli_fetch_array($resultOrg, MYSQLI_ASSOC);
																								echo $rowOrg['name'];
																							}
																							elseif(isset($row['DepartmentID'])){
																								$queryDep="SELECT * FROM thesis.department where DepartmentID='{$row['DepartmentID']}'";
																								$resultDep=mysqli_query($dbc,$queryDep);
																								$rowDep=mysqli_fetch_array($resultDep, MYSQLI_ASSOC);
																								echo $rowDep['name'];
																							}
																							elseif(isset($row['officeID'])){
																								$queryOff="SELECT * FROM thesis.offices where officeID='{$row['officeID']}'";
																								$resultOff=mysqli_query($dbc,$queryOff);
																								$rowOff=mysqli_fetch_array($resultOff, MYSQLI_ASSOC);
																								echo $rowOff['Name'];
																							}
																							?></b></h5>
                                            <h5><b>Contact Number: <?php echo $row['contactNumber']; ?></b></h5>
                                            <h5><b>Date Time Needed: <?php echo $row['dateNeed']; ?></b></h5>
                                            <h5><b>Purpose: <?php echo $row['purpose']; ?></b></h5>

                                            <div>

                                                <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                    <thead>
                                                        <tr>
                                                            <th>Category</th>
                                                            <th>Quantity</th>
                                                            <th>Brand</th>
                                                            <th>Model</th>
                                                            <th>Property Code</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
														<?php
															//GET DONATIONDETAILS
															$queryDonDet = "SELECT *,rac.name as `assetCatName` FROM thesis.donationdetails dd join ref_assetcategory rac on dd.assetCategoryID=rac.assetCategoryID where donationID='{$donationID}'";
															$resultDonDet = mysqli_query($dbc, $queryDonDet);
															$count=0;
															while($rowDonDet=mysqli_fetch_array($resultDonDet, MYSQLI_ASSOC)){
																echo 
																"<tr>
																	<input type='hidden' name='assetCategoryID[]' value='{$rowDonDet['assetCategoryID']}'>
																	<td>{$rowDonDet['assetCatName']}</td>
																	<td>{$rowDonDet['quantity']}</td>
																	<td>
																<select class='form-control donreq' id='brand".$count."' required onchange='getModel({$count},{$rowDonDet['assetCategoryID']})'>
																		<option value=''>Select Brand</option>";
																
																//GET BRAND
																$queryBrand = "SELECT * FROM thesis.ref_brand";
																$resultBrand = mysqli_query($dbc, $queryBrand);
																while($rowBrand=mysqli_fetch_array($resultBrand, MYSQLI_ASSOC)){
																	echo "<option value='{$rowBrand['brandID']}'>{$rowBrand['name']}</option>";
																}
																
																
																
																echo "</select>
																	</td>
																	<td>
																	<select class='form-control donreq' id='model".$count."' required onchange='getPropCode({$count})'>
																		<option value=''>Select Model</option>";
																
																echo "</select>
																	</td>
																	<td>
																	<select class='form-control donreq' id='propCode".$count."' name='propCode[]' required>
																		<option value=''>Select Property Code</option>";
																		
																echo "</select>
																	</td>
																</tr>";
																$count++;
															}
														?>
                                                    </tbody>
                                                </table>
                                                
                                                <br>
                                                <div class="form-group">
                                                    <label for="comment">Please Fill Reason if Disapproved</label>
                                                    <textarea class="form-control" rows="5" id="comment" name="reason" style="resize:none"></textarea>
                                                </div>

                                                <button class="btn btn-success" type="submit" id="approve" name="approve">Approve</button>
                                                <button class="btn btn-danger" type="submit" id="disapprove" name="disapprove">Disapprove</button>
                                            </div>

                                        </div>
                                    </section>
                                </div>
                            </div>


                        </div>
						</form>
                        <!-- <div class="row">
                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="panel">
                                        <header class="panel-heading">
                                            View Donation Request
                                        </header>
                                        <div class="panel-body">
                                            <button class="btn btn-danger" onclick="location.href='it_requests.php'">Back</button>
                                            <h5><b>Office/ Department/ School Organization: Gaylord Academy</b></h5>
                                            <h5><b>Contact Number: 09178328851</b></h5>
                                            <h5><b>Date Time Needed: 12/23/2018 12:00:00AM</b></h5>
                                            <h5><b>Purpose: To serve our gay community</b></h5>

                                            <div>

                                                <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                    <thead>
                                                        <tr>
                                                            <th>Category</th>
                                                            <th>Quantity</th>
                                                            <th>Brand</th>
                                                            <th>Model</th>
                                                            <th>Property Code</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Computer</td>
                                                            <td>3</td>
                                                            <td>
                                                                <select class="form-control">
                                                                    <option>Select Brand</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control">
                                                                    <option>Select Model</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control">
                                                                    <option>Select Property Code</option>
                                                                </select>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td>
                                                                <select class="form-control">
                                                                    <option>Select Brand</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control">
                                                                    <option>Select Model</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control">
                                                                    <option>Select Property Code</option>
                                                                </select>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td>
                                                                <select class="form-control">
                                                                    <option>Select Brand</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control">
                                                                    <option>Select Model</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control">
                                                                    <option>Select Property Code</option>
                                                                </select>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                                
                                                <br>
                                                <div class="form-group">
                                                    <label for="comment">Please Fill Reason if Disapproved</label>
                                                    <textarea class="form-control" rows="5" id="comment" style="resize:none"></textarea>
                                                </div>

                                                <button class="btn btn-success">Approve</button>
                                                <button class="btn btn-danger">Disapprove</button>
                                            </div>

                                        </div>
                                    </section>
                                </div>
                            </div>


                        </div> -->
                    </div>
                </div>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>

    <!-- WAG GALAWIN PLS LANG -->

    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>

    <!--dynamic table-->
    <script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

    <script src="js/morris-chart/morris.js"></script>
    <script src="js/morris-chart/raphael-min.js"></script>
    <script src="js/morris.init.js"></script>

    <!--dynamic table initialization -->
    <script src="js/dynamic_table_init.js"></script>
	
	<script type="text/javascript">
		function getModel(count,assetCat){
			
			var code1 = "brand" + count;
			var code3 = "model" + count;
			var brand=document.getElementById(code1).value;
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById(code3).innerHTML = this.responseText;
			}
			};
			xmlhttp.open("GET", "model_ajax.php?category=" + assetCat + "&brand=" + brand, true);
			xmlhttp.send();
							
		}
		
		function getPropCode(count){
			
			var code3 = "model" + count;
			var code4 = "propCode" + count;
			var model=document.getElementById(code3).value;
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById(code4).innerHTML = this.responseText;
				}
			};
			xmlhttp.open("GET", "propcode_ajax.php?model=" + model, true);
			xmlhttp.send();
							
		}
		
		$('#disapprove').click(function () {
			document.getElementById("comment").required = true;
			for(var i=0;i<document.getElementsByClassName("donreq").length;i++){
				document.getElementsByClassName("donreq")[i].required = false;
			}
			
		});
		$('#approve').click(function () {
			document.getElementById("comment").required = false;
			for(var i=0;i<document.getElementsByClassName("donreq").length;i++){
				document.getElementsByClassName("donreq")[i].required = true;
			}
		});
	</script>

</body>

</html>