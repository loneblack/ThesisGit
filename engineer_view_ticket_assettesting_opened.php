<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	$userid=$_SESSION['userID'];
	$ticketID=$_GET['id'];

	$queryx = "SELECT CONCAT(Convert(AES_DECRYPT(u.lastName,'Fusion')USING utf8),' ',Convert(AES_DECRYPT(u.firstName,'Fusion')USING utf8)) as `fullname`,far.floorRoom,t.dueDate FROM thesis.ticket t join assettesting at on t.testingID=at.testingID 
											 join user u on at.PersonRequestedID=u.UserID 
											 join floorandroom far on at.FloorAndRoomID=far.FloorAndRoomID
											 where t.ticketID='{$ticketID}'";
    $resultx = mysqli_query($dbc, $queryx);
	$rowx = mysqli_fetch_array($resultx, MYSQLI_ASSOC);
	
	$query7="SELECT COUNT(atd.asset_assetID) as `numAssets`,at.testingID FROM thesis.assettesting_details atd join assettesting at on atd.assettesting_testingID=at.testingID 
																	  join ticket t on at.testingID=t.testingID
																	  where t.ticketID='{$ticketID}'";
	$result7=mysqli_query($dbc,$query7);
	$row7 = mysqli_fetch_array($result7, MYSQLI_ASSOC);
	
	if(isset($_POST['save'])){
		//For functioning assets
		if(!empty($_POST['funcAsset'])){
			$funcAsset=$_POST['funcAsset'];
			
			//if(sizeof($funcAsset)==$row7['numAssets']){
				
			//}
			
			foreach($funcAsset as $value){
				
				$query5="UPDATE `thesis`.`assettesting_details` SET `check`='1' WHERE `assettesting_testingID`='{$row7['testingID']}' and asset_assetID='{$value}'";
				$result5=mysqli_query($dbc,$query5);
			}
		}
		
		//For defected assets
		if(!empty($_POST['disapprovedAsset'])){
			$disapprovedAsset=$_POST['disapprovedAsset'];
			$comments=$_POST['comments'];
			foreach (array_combine($disapprovedAsset, $comments) as $value1 => $value2){
			
				$query6="UPDATE `thesis`.`assettesting_details` SET `check`='0',`comment`='{$value2}' WHERE `assettesting_testingID`='{$row7['testingID']}' and asset_assetID='{$value1}'";
				$result6=mysqli_query($dbc,$query6);
			}
		}

		$query8="UPDATE `thesis`.`assettesting` SET `statusID`='3' WHERE `testingID`='{$row7['testingID']}'";
		$result8=mysqli_query($dbc,$query8);
		
		
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
        <?php include 'engineer_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

				<form class="cmxform form-horizontal " id="signupForm" method="post" action="">
                <div class="row">
                    <div class="col-sm-12">
						
                        <div class="row">
                            <div class="col-sm-9">
                                <section class="panel">
                                    <header class="panel-heading">
                                        Asset Testing Checklist
                                    </header>
                                    <div class="panel-body">
									
										<div class="panel-body">
											<section>
											<label><h5>Name:</h5></label><input type="text" value="<?php echo $rowx['fullname']; ?>" class="form-control" disabled>
											<br>
										<!--	<label><h5>Office Building: </h5></label><input type="text" class="form-control" disabled> 
											<br> -->
											<label><h5>Room Number: </h5></label><input type="text" value="<?php echo $rowx['floorRoom']; ?>" class="form-control" disabled>
											
											</section>
										</div>

										<section>
											<p>Check those which are functioning as intended.
											If any damage or defect is found, please specify it in the comments.</p>
											<br>
										</section>
										
                                        <section id="unseen">
										
                                            <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                <thead>
                                                    <tr>
														<th></th>
                                                        <!-- <th>Property Code</th> -->
                                                        <th>Brand</th>
                                                        <th>Model</th>
                                                        <th>Comments</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
													<?php
														$query = "SELECT atd.asset_assetID as `assetID`,rb.name as `brand`, am.description as `model` FROM thesis.assettesting_details atd join assettesting at on atd.assettesting_testingID=at.testingID 
																	  join ticket t on at.testingID=t.testingID
																	  join asset a on atd.asset_assetID=a.assetID
																	  join assetmodel am on a.assetModel=am.assetModelID
																	  join ref_brand rb on am.brand=rb.brandID
																	  where t.ticketID='{$ticketID}'";
                                                                  
														$result = mysqli_query($dbc, $query);
                                                    
														while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
															$idDisapp="Disapp_".$row['assetID'];
															echo "<tr><td style='text-align:center'><input type='checkbox' name='funcAsset[]' class='form-check-input myCheck' value='{$row['assetID']}'></td>
																<td style='text-align:center'>{$row['brand']}</td>
																<td style='text-align:center'>{$row['model']}</td>
																<td><input style='text' id='{$row['assetID']}' name='comments[]' class='form-control' required></td>
																<input type='hidden' id='{$idDisapp}' name='disapprovedAsset[]' value='{$row['assetID']}'>
																</tr>";
														}
													
													
													
													
													
													?>
                                                    <!-- <tr>
														<td style="text-align:center"><input type='checkbox' class='form-check-input'></td>
                                                        <td style="text-align:center">TBLT-001</td>
                                                        <td style="text-align:center">Apple Tablet</td>
                                                        <td style="text-align:center">iPad</td>
														<th><input style="text" class="form-control"></th>
                                                        
                                                    </tr>
                                                    <tr >
														<td style="text-align:center"><input type='checkbox' class='form-check-input'></td>
                                                        <td style="text-align:center; width:50px;">PC-0023</td>
                                                        <td style="text-align:center">Windows</td>
                                                        <td style="text-align:center">Windows 10</td>
                                                        <th><input style="text" class="form-control"></th>
                                                    </tr>
													<tr>
                                                        <td style="text-align:center"><input type='checkbox' class='form-check-input'></td>
														<td style="text-align:center">PHN-0312</td>
                                                        <td style="text-align:center">Smartphone</td>
                                                        <td style="text-align:center">Samsung Galaxy J7 Pro</td>
                                                        <th><input style="text" class="form-control"></th>
                                                    </tr> -->
                                                </tbody>
                                            </table>
											
											
											

                                            <div>
												<button onclick="return confirm('Confirm checklist?')" type="submit" name="save" class="btn btn-success" data-dismiss="modal">Save</button> 
												<!-- <button onclick="return confirm('Confirm checklist?')" type="button" class="btn btn-success" data-dismiss="modal">Save</button> -->
                                                <a href="engineer_all_ticket.php"><button type="button" class="btn btn-danger" data-dismiss="modal">Back</button></a>
                                            </div>

                                        </section>
                                    </div>
                                </section>
                            </div>
							
							
							<div class="col-sm-3">
								<section class="panel">
									<div class="panel-body">
										<ul class="nav nav-pills nav-stacked labels-info ">
											<li>
												<h4>Properties</h4>
											</li>
										</ul>
										<div class="form">
											
												<div class="form-group ">
													<div class="form-group ">
														<label style="padding-left:22px" for="category" class="control-label col-lg-4">Category</label>
														<div class="col-lg-8" style="padding-right:30px">
															<select class="form-control m-bot15" name="category" readonly>
																<?php
																	$query2 = "SELECT * FROM thesis.ref_servicetype";
																	$result2 = mysqli_query($dbc, $query2);
																	while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
																		if($row2['id']==25){
																			echo "<option selected value='{$row2['id']}'>{$row2['serviceType']}</option>";
																		}
																		else{
																			echo "<option value='{$row2['id']}'>{$row2['serviceType']}</option>";
																		}
																	}
																
																?>
																<!-- <option selected="selected">Repair</option>
																<option>Repair</option>
																<option>Maintenance</option>
																<option>Replacement</option> -->
															</select>
														</div>
													</div>

													<label for="status" class="control-label col-lg-4">Status</label>
													<div class="col-lg-8">
														<select class="form-control m-bot15" name="status" value="<?php if (isset($_POST['status']) && !$flag) echo $_POST['status']; ?>" >
															<?php
																$query1 = "SELECT * FROM thesis.ref_ticketstatus";
																$result1 = mysqli_query($dbc, $query1);
																while($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)){
																	if($row1['ticketID']==5){
																		echo "<option selected value='{$row1['ticketID']}'>{$row1['status']}</option>";
																	}
																	else{
																		echo "<option value='{$row1['ticketID']}'>{$row1['status']}</option>";
																	}
																}
																
															
															
															
															
															?>
														
														<!--<option>Assigned</option>
															<option>In Progress</option>
															<option selected="selected">Transferred</option>
															<option>Escalated</option>
															<option>Waiting For Parts</option>
															<option>Closed</option> -->
														</select>
													</div>
												</div>

												<div class="form-group ">
													<label for="priority" class="control-label col-lg-4">Priority</label>
													<div class="col-lg-8">
														<select class="form-control m-bot15" name="priority" value="<?php if (isset($_POST['priority']) && !$flag) echo $_POST['priority']; ?>" >
															<option selected value="">Select Priority</option>
															<option value="Low">Low</option>
															<option value="Medium</">Medium</option>
															<option value="High">High</option>
															<option value="Urgent">Urgent</option>
														</select>
													</div>
												</div>

												<div class="form-group ">
													<label for="assign" class="control-label col-lg-4">Escalate To</label>
													<div class="col-lg-8">
														<select class="form-control m-bot15" name="escalate" value="<?php if (isset($_POST['escalate']) && !$flag) echo $_POST['escalate']; ?>" >
															<option selected value="">Select Engineer</option>
															<?php
																$query3="SELECT u.UserID,CONCAT(Convert(AES_DECRYPT(lastName,'Fusion')USING utf8),', ',Convert(AES_DECRYPT(firstName,'Fusion')USING utf8)) as `fullname` FROM thesis.user u join thesis.ref_usertype rut on u.userType=rut.id where rut.description='Engineer' and u.UserID<>'{$userid}'";
																$result3=mysqli_query($dbc,$query3);
																		
																while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC)){
																	echo "<option value='{$row3['UserID']}'>{$row3['fullname']}</option>";
																}										
																
															?>
														</select>
													</div>
												</div>

												<div class="form-group">
													<label class="control-label col-lg-4">Due Date</label>
													<div class="col-lg-8">
														<input class="form-control form-control-inline input-medium default-date-picker" name="dueDate" size="10" type="text" value="<?php echo $rowx['dueDate']; ?>" readonly />
													</div>
												</div>

												<!-- <div class="form-group">
													<label class="control-label col-lg-4">Repair Date *</label>
													<div class="col-lg-8">
														<input class="form-control form-control-inline input-medium default-date-picker" name="repairDate" size="10" type="date" value="<?php if (isset($_POST['repairDate']) && !$flag) echo $_POST['repairDate']; ?>" />
													</div>
												</div> -->
											
										</div>
										
									</div>
								</section>
							</div>
							
                        </div>
                    </div>
                </div>
				</form>
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

    <script type="text/javascript">
        // Shorthand for $( document ).ready()
        $(function() {

        });
		
        function addTest() {
            var row_index = 0;
            var isRenderd = false;

            $("td").click(function() {
                row_index = $(this).parent().index();

            });

            var delayInMilliseconds = 300; //1 second

            setTimeout(function() {

                appendTableRow(row_index);
            }, delayInMilliseconds);



        }

        var appendTableRow = function(rowCount) {
            var cnt = 0
            var tr = "<tr>" +
                "<td style=''></td>" +
                "<td></td>" +
                "<td></td>" +
                "<td>" +
				"<div>" +
				"<label class='form-inline'>" +
				"<input type='checkbox' class='form-check-input' hidden><input style='width:300px' type='text' class='form-control'></label></div>" +
                "</td>" +
				"<td><button class='btn btn-danger' onclick='removeRow(this)'> Remove </button></td>" +
                "</tr>";
            $('#tableTest tbody tr').eq(rowCount).after(tr);
        }
		
		$('.myCheck').change(function(){
			var disapp = "Disapp_" + this.value;
			if($(this).is(':checked')) {
			// Checkbox is checked..
			
				document.getElementById(this.value).required = false;
				document.getElementById(this.value).disabled = true;
				document.getElementById(disapp).disabled=true;
				
			} else {
				// Checkbox is not checked..
				
				document.getElementById(this.value).required = true;
				document.getElementById(this.value).disabled = false;
				document.getElementById(disapp).disabled=false;
				
				
			}
		});
    </script>
	
	
	

</body>

</html>