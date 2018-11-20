<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	
	$key="Fusion";
	$requestID=$_GET['requestID'];
	
	//GET REQ DATA
	
	$queryReq="SELECT *, b.name as `building`,far.floorRoom as `floorAndRoom`,CONCAT(Convert(AES_DECRYPT(u.firstName,'{$key}')USING utf8), ' ', Convert(AES_DECRYPT(u.lastName,'{$key}')USING utf8)) as `requestor`,r.dateNeeded,r.description as `reason` FROM thesis.request r 
					join ref_status rs on r.status=rs.statusID
					join ref_steps rstp on r.step=rstp.id
					join user u on r.UserID=u.UserID
					join building b on r.BuildingID=b.BuildingID
					join floorandroom far on r.FloorAndRoomID=far.FloorAndRoomID
					where r.requestID='{$requestID}'";
	$resultReq=mysqli_query($dbc,$queryReq);			
	$rowReq=mysqli_fetch_array($resultReq,MYSQLI_ASSOC);

	
	if(isset($_POST['submit'])){
		if($_POST['category']=='25'){
			
			$message=null;
			$category=$_POST['category'];
			$status=$_POST['status'];
			$priority=$_POST['priority'];
			$assigned=$_POST['assigned'];
			$currDate=date("Y-m-d H:i:s");
			
			if($rowReq['dateNeeded']<$_POST['dueDate']||$currDate>$_POST['dueDate']){
				$message="Invalid date input.";
			}
			else{
				$dueDate=$_POST['dueDate'];
			}
			
			if(!isset($message)){
				//INSERT ASSET TESTING
				$queryt="INSERT INTO `thesis`.`assettesting` (`statusID`, `PersonRequestedID`, `FloorAndRoomID`, `serviceType`, `remarks`) VALUES ('1', '{$rowReq['UserID']}', '{$rowReq['FloorAndRoomID']}', '25', 'Asset Request');";
				$resultt=mysqli_query($dbc,$queryt);
				
				//GET LATEST ASSET TEST
				
				$query0="SELECT * FROM `thesis`.`assettesting` order by testingID desc limit 1";
				$result0=mysqli_query($dbc,$query0);
				$row0=mysqli_fetch_array($result0,MYSQLI_ASSOC);
				
				//GET Procurement DATA
				$queryProc="SELECT * FROM thesis.procurement where requestID='{$requestID}'";
				$resultProc=mysqli_query($dbc,$queryProc);
				while($rowProc=mysqli_fetch_array($resultProc,MYSQLI_ASSOC)){
					//GET ALL ASSET INTO ASSETDOC
					$querys="SELECT * FROM thesis.assetdocument ad join asset a on ad.assetID=a.assetID where requestID='{$requestID}' and procurementID='{$rowProc['procurementID']}' and a.assetStatus='8'";
					$results=mysqli_query($dbc,$querys);
					while($rows=mysqli_fetch_array($results,MYSQLI_ASSOC)){		
						//Insert to assettesting_details table
						$queryrrr="INSERT INTO `thesis`.`assettesting_details` (`assettesting_testingID`, `asset_assetID`) VALUES ('{$row0['testingID']}', '{$rows['assetID']}')";
						$resultrrr=mysqli_query($dbc,$queryrrr);
					}
				}
				//Create ticket
				$querya="INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `testingID`, `serviceType`) VALUES ('{$status}', '{$assigned}', '{$_SESSION['userID']}', now(), now(), '{$dueDate}', '{$priority}', '{$row0['testingID']}', '{$category}')";
				$resulta=mysqli_query($dbc,$querya);
				
				//Get Latest ticket
				$queryaa="SELECT * FROM `thesis`.`ticket` order by ticketID desc limit 1";
				$resultaa=mysqli_query($dbc,$queryaa);
				$rowaa=mysqli_fetch_array($resultaa,MYSQLI_ASSOC);
				
				//Select Asset testingID
				$queryaaa="SELECT * FROM thesis.assettesting_details where assettesting_testingID='{$row0['testingID']}'";
				$resultaaa=mysqli_query($dbc,$queryaaa);
				while($rowaaa=mysqli_fetch_array($resultaaa,MYSQLI_ASSOC)){
					$queryaaaa="INSERT INTO `thesis`.`ticketedasset` (`ticketID`, `assetID`) VALUES ('{$rowaa['ticketID']}', '{$rowaaa['asset_assetID']}');";
					$resultaaaa=mysqli_query($dbc,$queryaaaa);
				}
			
				$message = "Form submitted!";
				$_SESSION['submitMessage'] = $message;
			}
			else{
				$_SESSION['submitMessage'] = $message;
			}
			
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
                    if (isset($_SESSION['submitMessage']) && $_SESSION['submitMessage']=="Form submitted!"){

                        echo "<div class='alert alert-success'>
                                {$_SESSION['submitMessage']}
							  </div>";
                        unset($_SESSION['submitMessage']);
                    }
					elseif(isset($_SESSION['submitMessage'])){
						 echo "<div class='alert alert-danger'>
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
                                     Request For Procurement of Services and Materials
                                </header>
								<div style="padding-top:10px; padding-left:10px; float:left">
									<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Create Ticket</button>
								</div>
                                <!-- Modal -->
                                <div class="modal fade" id="myModal" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Create a Ticket</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form">
                                                    <form class="cmxform form-horizontal" id="signupForm" method="post">
                                                        <div class="form-group ">
                                                            <div class="form-group ">
                                                                <label for="category" class="control-label col-lg-3">Category</label>
                                                                <div class="col-lg-6">
                                                                    <select class="form-control m-bot15" name="category" value="<?php if (isset($_POST['category']) && !$flag) echo $_POST['category']; ?>" required >
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
																			if($rowb['id']=='1'){
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
                                                                <input class="form-control m-bot15" size="10" name="dueDate" type="datetime-local" value="<?php if (isset($_POST['dueDate']) && !$flag) echo $_POST['dueDate']; ?>" required />
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
                                
                                <div  style="padding-top:55px" class="panel-body">
									<div class="form" method="post">
										<form class="cmxform form-horizontal " id="signupForm" method="get" action="">
											
											<hr>
											<section>
												<h4>User Location Information</h4>
												<div class="form-group ">
													<label for="building" class="control-label col-lg-3">Building</label>
													<div class="col-lg-6">
														<select name="buildingID" id="buildingID" class="form-control m-bot15" onChange="getRooms(this.value)" disabled>
															<option selected><?php echo $rowReq['building']; ?></option>
															
														</select>
													</div>
												</div>
												<div class="form-group">
													<label for="floorRoom" class="control-label col-lg-3">Floor & Room</label>
													<div class="col-lg-6">
														<select name="FloorAndRoomID" id="FloorAndRoomID" class="form-control m-bot15" disabled>
															<option selected><?php echo $rowReq['floorAndRoom']; ?></option>
														</select>
													</div>
												</div>
												<div class="form-group ">
													<label for="recipient" class="control-label col-lg-3">Recipient</label>
													<div class="col-lg-6">
														<input class="form-control" id="recipient" name="recipient" value="<?php echo $rowReq['requestor']; ?>" type="text" disabled />
													</div>
												</div>
												<div class="form-group ">
													<label for="dateNeeded" class="control-label col-lg-3">Date needed</label>
													<div class="col-lg-6">
														<input class="form-control" id="dateNeeded" name="dateNeeded" value="<?php echo $rowReq['dateNeeded']; ?>" type="datetime" disabled />
													</div>
												</div>
											</section>
											<hr>
											<section>
                                                    <h4>Request Details</h4>
                                                    <div class="form-group ">
                                                        <label for="building" class="control-label col-lg-3">Reason of Request</label>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <textarea class="form-control" rows="5" id="comment" name= "comment" style="resize: none" required disabled><?php echo $rowReq['reason']; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </section>
											<hr>
											<section>
												<h4>Requested Services/Materials</h4>
												<table class="table-bordered" align="center" id="tblCustomers" border="1">
													<thead>
														<tr>
															<th>Quantity</th>
															<th style="width:47%">Category dropdown</th>
															<th>Description</th>
															<th></th>
														</tr>
													</thead>

													<tbody>
														<?php
															//Get req details
															$queryReqDet="SELECT * from thesis.requestdetails rd join ref_assetcategory ras on rd.assetCategory=ras.assetCategoryID where rd.requestID='{$requestID}'";
															$resultReqDet=mysqli_query($dbc,$queryReqDet);			
															
															while($rowReqDet=mysqli_fetch_array($resultReqDet,MYSQLI_ASSOC)){
															
															echo "<tr>
																<td>
																	<div class='col-lg-12'>
																		<input class='form-control' type='number' id='txtCountry' min='1' step='1' value='{$rowReqDet['quantity']}' disabled />
																	</div>
																</td>
																<td>
																	<div class='col-lg-12'>
																		<select class='form-control' id='amount' disabled>
																			<option selected>{$rowReqDet['name']}</option>
																		
																		</select>
																	</div>
																</td>
																<td style='padding-top:5px; padding-bottom:5px'>
																	<div class='col-lg-12'>
																		<input class='form-control' type='text' id='txtName' value='{$rowReqDet['description']}' disabled />
																	</div>
																</td>
																</tr>";
														
														
															}
														
														?>
														
													</tbody>
												</table>
												<br>
											</section>

											<div class="form-group">
												<div style="padding-left:10px">
													<a href="helpdesk_all_request.php"><button style="float:left" class="btn btn-default" type="button">Back</button></a>
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
	
	<script>
	function checkvalue(val){
		if(val==="25")
		   document.getElementById('others').style.display='block';
		else
		   document.getElementById('others').style.display='none'; 
	}
	</script>

    <!-- WAG GALAWIN PLS LANG -->

    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script src="js/jquery-ui-1.9.2.custom.min.js"></script>
   
    <script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>


    <script src="js/scripts.js"></script>
    <script src="js/advanced-form.js"></script>

</body>

</html>