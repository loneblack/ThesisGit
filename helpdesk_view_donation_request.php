<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	
	$key="Fusion";
	$donationID=$_GET['donationID'];
	
	//GET Donation Data
	
	$queryDon="SELECT * FROM thesis.donation where donationID='{$donationID}'";
	$resultDon=mysqli_query($dbc,$queryDon);			
	$rowDon=mysqli_fetch_array($resultDon,MYSQLI_ASSOC);
	
	if(isset($_POST['submit'])){
		//Update notifications
		$queryUpdNotif="UPDATE `thesis`.`notifications` SET `isRead` = true WHERE `donationID` = '{$donationID}' and `steps_id`='9'";
		$resultUpdNotif=mysqli_query($dbc,$queryUpdNotif);
		$message=null;
		
		$category=$_POST['category'];
		$status=$_POST['status'];
		$priority=$_POST['priority'];
		$assigned=$_POST['assigned'];
		$currDate=date("Y-m-d H:i:s");
		$dueDate=$_POST['dueDate'];
	
		//CREATE ASSET TEST
		$queryt="INSERT INTO `thesis`.`assettesting` (`statusID`, `PersonRequestedID`, `serviceType`, `remarks`) VALUES ('1', '{$rowDon['user_UserID']}', '25', 'Donation');";
		$resultt=mysqli_query($dbc,$queryt);
				
		//GET LATEST ASSET TEST
		$query0="SELECT * FROM `thesis`.`assettesting` order by testingID desc limit 1";
		$result0=mysqli_query($dbc,$query0);
		$row0=mysqli_fetch_array($result0,MYSQLI_ASSOC);
				
		//UPDATE ASSET STATUS / GET Donation data
		$queryDonDet="SELECT *,ddi.assetID as `asset` FROM thesis.donationdetails dd join donationdetails_item ddi on dd.id=ddi.id where dd.donationID='{$donationID}'";
		$resultDonDet=mysqli_query($dbc,$queryDonDet);
		while($rowDonDet=mysqli_fetch_array($resultDonDet,MYSQLI_ASSOC)){
			$queryAsset="UPDATE `thesis`.`asset` SET `assetStatus`='8' WHERE `assetID`='{$rowDonDet['asset']}'";
			$resultAsset=mysqli_query($dbc,$queryAsset);
					
			//Insert to assettesting_details table
			$queryAssTest="INSERT INTO `thesis`.`assettesting_details` (`assettesting_testingID`, `asset_assetID`) VALUES ('{$row0['testingID']}', '{$rowDonDet['assetID']}')";
			$resultAssTest=mysqli_query($dbc,$queryAssTest);
			
		}
				
		//Create ticket
		$querya="INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `testingID`, `serviceType`, `requestedBy`) VALUES ('{$status}', '{$assigned}', '{$_SESSION['userID']}', now(), now(), '{$dueDate}', '{$priority}', '{$row0['testingID']}', '{$category}', '{$rowDon['user_UserID']}')";
		$resulta=mysqli_query($dbc,$querya);
				
		//Get Latest ticket
		$queryaa="SELECT * FROM `thesis`.`ticket` order by ticketID desc limit 1";
		$resultaa=mysqli_query($dbc,$queryaa);
		$rowaa=mysqli_fetch_array($resultaa,MYSQLI_ASSOC);
		
		//INSERT TO NOTIFICATIONS TABLE
		$sqlNotif = "INSERT INTO `thesis`.`notifications` (`isRead`, `ticketID`) VALUES (false, '{$rowaa['ticketID']}');";
		$resultNotif = mysqli_query($dbc, $sqlNotif);
		
		//Select Asset testingID
		$queryaaa="SELECT * FROM thesis.assettesting_details where assettesting_testingID='{$row0['testingID']}'";
		$resultaaa=mysqli_query($dbc,$queryaaa);
		while($rowaaa=mysqli_fetch_array($resultaaa,MYSQLI_ASSOC)){
			$queryaaaa="INSERT INTO `thesis`.`ticketedasset` (`ticketID`, `assetID`) VALUES ('{$rowaa['ticketID']}', '{$rowaaa['asset_assetID']}');";
			$resultaaaa=mysqli_query($dbc,$queryaaaa);
			
			//INSERT TO ASSET AUDIT
			$queryAssAud="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `ticketID`, `assetStatus`) VALUES ('{$_SESSION['userID']}', now(), '{$rowaaa['asset_assetID']}', '{$rowaa['ticketID']}', '8');";
			$resultAssAud=mysqli_query($dbc,$queryAssAud);
		}

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
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datepicker/css/datepicker.css" />

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
				<?php
                    if (isset($_SESSION['submitMessage'])){

                        echo "<div class='alert alert-success'>
                                {$_SESSION['submitMessage']}
							  </div>";
                        unset($_SESSION['submitMessage']);
                    }
				?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">

                            <section class="panel">
                                <header class="panel-heading">
                                    Donation Request
                                </header>
                                <div style="padding-top:10px; padding-left:10px; float:left">
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Send For Testing</button>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="myModal" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Send For Testing</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form">
                                                    <form class="cmxform form-horizontal" id="signupForm" method="post">
                                                        <div class="form-group ">
                                                            <div class="form-group ">
                                                                <label for="category" class="control-label col-lg-3">Category</label>
                                                                <div class="col-lg-6">
                                                                    <select class="form-control m-bot15" name="category" value="<?php if (isset($_POST['category']) && !$flag) echo $_POST['category']; ?>" required readonly>
																		<?php
																			
																			$querya="SELECT * FROM thesis.ref_servicetype";
																			$resulta=mysqli_query($dbc,$querya);
																			while($rowa=mysqli_fetch_array($resulta,MYSQLI_ASSOC)){
																				if($rowa['id']=='25'){
																					echo "<option value='{$rowa['id']}' selected>{$rowa['serviceType']}</option>";
																				}
																				else{
																					echo "<option value='{$rowa['id']}'>{$rowa['serviceType']}</option>";
																				}
																			}
																		
																		?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <label for="status" class="control-label col-lg-3">Status</label>
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-bot15" name="status" value="<?php if (isset($_POST['status']) && !$flag) echo $_POST['status']; ?>" required readonly>
																	<?php
																			
																		$queryb="SELECT * FROM thesis.ref_ticketstatus";
																		$resultb=mysqli_query($dbc,$queryb);
																		while($rowb=mysqli_fetch_array($resultb,MYSQLI_ASSOC)){
																			if($rowb['ticketID']=='2'){
																				echo "<option value='{$rowb['ticketID']}' selected>{$rowb['status']}</option>";
																			}
																			else{
																				echo "<option value='{$rowb['ticketID']}'>{$rowb['status']}</option>";
																			}
																		}
																		
																	?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group ">
                                                            <label for="priority" class="control-label col-lg-3">Priority</label>
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-bot15" name="priority" value="<?php if (isset($_POST['priority']) && !$flag) echo $_POST['priority']; ?>" required>
                                                                    <option value='Low'>Low</option>
                                                                    <option value='Medium'>Medium</option>
                                                                    <option value='High' selected>High</option>
                                                                    <option value='Urgent'>Urgent</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group ">
                                                            <label for="assign" class="control-label col-lg-3">Assigned</label>
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-bot15" name="assigned" value="<?php if (isset($_POST['assigned']) && !$flag) echo $_POST['assigned']; ?>" required>
																	<?php
																		$query3="SELECT u.UserID,CONCAT(Convert(AES_DECRYPT(lastName,'Fusion')USING utf8),', ',Convert(AES_DECRYPT(firstName,'Fusion')USING utf8)) as `fullname` FROM thesis.user u join thesis.ref_usertype rut on u.userType=rut.id where rut.description='Engineer'";
																		$result3=mysqli_query($dbc,$query3);
																		
																		while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC)){
																			echo "<option value='{$row3['UserID']}'>{$row3['fullname']}</option>";
																		}										
																	
																	?>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">Due Date</label>
                                                            <div class="col-lg-6">
                                                                <!-- class="form-control form-control-inline input-medium default-date-picker" -->
                                                                <input class="form-control m-bot15" size="10" name="dueDate" type="date" value="<?php if (isset($_POST['dueDate']) && !$flag) echo $_POST['dueDate']; ?>" required />
                                                            </div>
                                                        </div>
																
                                                        <button type="submit" class="btn btn-success" name="submit">Update</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--                                MODAL END-->

                                <div class="panel-body">
                                    <br>
                                    <br>
                                    <h5 style="float:right"><button class="btn btn-default">For Testing</button></h5>
                                    <h5><b>Office/ Department/ School Organization: <?php 
																							if(isset($rowDon['organizationID'])){
																								$queryOrg="SELECT * FROM thesis.organization where id='{$rowDon['organizationID']}'";
																								$resultOrg=mysqli_query($dbc,$queryOrg);
																								$rowOrg=mysqli_fetch_array($resultOrg, MYSQLI_ASSOC);
																								echo $rowOrg['name'];
																							}
																							elseif(isset($rowDon['DepartmentID'])){
																								$queryDep="SELECT * FROM thesis.department where DepartmentID='{$rowDon['DepartmentID']}'";
																								$resultDep=mysqli_query($dbc,$queryDep);
																								$rowDep=mysqli_fetch_array($resultDep, MYSQLI_ASSOC);
																								echo $rowDep['name'];
																							}
																							elseif(isset($rowDon['officeID'])){
																								$queryOff="SELECT * FROM thesis.offices where officeID='{$rowDon['officeID']}'";
																								$resultOff=mysqli_query($dbc,$queryOff);
																								$rowOff=mysqli_fetch_array($resultOff, MYSQLI_ASSOC);
																								echo $rowOff['Name'];
																							}
																							else{
																								echo $rowDon['schoolName'];
																							}
																							?> </b></h5>
                                    <h5><b>Contact Person: <?php echo $rowDon['contactPerson']; ?></b></h5>
                                    <h5><b>Contact Number: <?php echo $rowDon['contactNumber']; ?></b></h5>
                                    <h5><b>Date Time Needed: <?php echo $rowDon['dateNeed']; ?></b></h5>
                                    <h5><b>Purpose: <?php echo $rowDon['purpose']; ?></b></h5>

                                    <div>

                                        <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                            <thead>
                                                <tr>
                                                    <th>Category</th>
                                                <!--    <th>Quantity</th> -->
                                                    <th>Brand</th>
                                                    <th>Model</th>
                                                    <th>Property Code</th>
                                                </tr>
                                            </thead>
                                            <tbody>
												
												
												<?php
												$queryDonDet="SELECT rb.name as `brandName`, am.description as `assetModelName`,a.propertyCode,dd.quantity,rac.name as `assetCatName` FROM thesis.donationdetails dd join ref_assetcategory rac on dd.assetCategoryID=rac.assetCategoryID
																									  join donationdetails_item ddi on dd.id=ddi.id
                                                                                                      join asset a on ddi.assetID=a.assetID
																									  join assetmodel am on a.assetModel=am.assetModelID
																									  join ref_brand rb on am.brand=rb.brandID
																									  where dd.donationID='{$donationID}'
																									  order by dd.assetCategoryID asc";
												$resultDonDet=mysqli_query($dbc,$queryDonDet);
												while($rowDonDet=mysqli_fetch_array($resultDonDet,MYSQLI_ASSOC)){
													echo "<tr>
                                                    <td>{$rowDonDet['assetCatName']}</td>
                                                    <td>
                                                        <select class='form-control' disabled>
                                                            <option selected>{$rowDonDet['brandName']}</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class='form-control' disabled>
                                                            <option selected>{$rowDonDet['assetModelName']}</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class='form-control' disabled>
                                                            <option selected>{$rowDonDet['propertyCode']}</option>
                                                        </select>
                                                    </td>
                                                </tr>";
												}
												
												
												
												?>
                                               
                                            </tbody>
                                        </table>

                                        <br>
                                        <button class="btn btn-success">Submit</button>
                                        <button class="btn btn-danger" onClick="location.href='helpdesk_all_ticket.php'">Back</button>
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

    <script>
        function checkvalue(val) {
            if (val === "25")
                document.getElementById('others').style.display = 'block';
            else
                document.getElementById('others').style.display = 'none';
        }
    </script>

    <!-- WAG GALAWIN PLS LANG -->

    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script src="js/jquery-ui-1.9.2.custom.min.js"></script>
	<script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>


    <script src="js/scripts.js"></script>
    <script src="js/advanced-form.js"></script>

</body>

</html>