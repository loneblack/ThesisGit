<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	$testingID=$_GET['testingID'];
	
	if(isset($_POST['submit'])){
		$category=$_POST['category'];
		$status=$_POST['status'];
		$priority=$_POST['priority'];
		$assigned=$_POST['assigned'];
		$dueDate=$_POST['dueDate'];
		
		$querya="INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `testingID`, `serviceType`) VALUES ('{$status}', '{$assigned}', '{$_SESSION['userID']}', now(), now(), '{$dueDate}', '{$priority}', '{$testingID}', '{$category}')";
		$resulta=mysqli_query($dbc,$querya);
		
		$queryaa="SELECT * FROM `thesis`.`ticket` order by ticketID desc limit 1";
		$resultaa=mysqli_query($dbc,$queryaa);
		$rowaa=mysqli_fetch_array($resultaa,MYSQLI_ASSOC);
		
		$queryaaa="SELECT * FROM thesis.assettesting_details where assettesting_testingID='{$testingID}'";
		$resultaaa=mysqli_query($dbc,$queryaaa);
		while($rowaaa=mysqli_fetch_array($resultaaa,MYSQLI_ASSOC)){
			$queryaaaa="INSERT INTO `thesis`.`ticketedasset` (`ticketID`, `assetID`) VALUES ('{$rowaa['ticketID']}', '{$rowaaa['asset_assetID']}');";
			$resultaaaa=mysqli_query($dbc,$queryaaaa);
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
                                    Asset Testing Request
                                </header>
								<div style="padding-left:30px; padding-top:10px">
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
                                                                <select class="form-control m-bot15" name="status" value="<?php if (isset($_POST['status']) && !$flag) echo $_POST['status']; ?>" required >
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
                                
                                <div class="panel-body">
									
									<div class="panel-body">
										<section>
										<label><h5>Name:</h5></label><input type="text" class="form-control" disabled>
										<br>
										<label><h5>Office Building: </h5></label><input type="text" class="form-control" disabled>
										<br>
										<label><h5>Room Number: </h5></label><input type="text" class="form-control" disabled>
										
										</section>
									</div>

									
									
									<section id="unseen">
									<h3>Checklist</h3>
										<table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
											<thead>
												<tr>
													
													<!-- <th>Property Code</th> -->
													<th>Item</th>
													<th>Specification</th>
													<th>Comments</th>
												</tr>
											</thead>
											<tbody>
												<?php
													
													$query="SELECT am.description as 'item',am.itemSpecification FROM thesis.assettesting_details atd join asset a on atd.asset_assetID=a.assetID
																join assetmodel am on a.assetModel=am.assetModelID
																where atd.assettesting_testingID='{$testingID}'";
													$result=mysqli_query($dbc,$query);
													while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
														echo "<tr>
																<td style='text-align:center'>{$row['item']}</td>
																<td style='text-align:center'>{$row['itemSpecification']}</td>
																<td><input style='text' class='form-control' disabled></td>
															</tr>";
													}
													
												?>
												<!-- <tr>
													<td style="text-align:center">TBLT-001</td>
													<td style="text-align:center">Apple Tablet</td>
													<td style="text-align:center">iPad</td>
													<th><input style="text" class="form-control" disabled></th>
													
												</tr>
												<tr >
													<td style="text-align:center; width:50px;">PC-0023</td>
													<td style="text-align:center">Windows</td>
													<td style="text-align:center">Windows 10</td>
													<th><input style="text" class="form-control" disabled></th>
												</tr>
												<tr>	
													<td style="text-align:center">PHN-0312</td>
													<td style="text-align:center">Smartphone</td>
													<td style="text-align:center">Samsung Galaxy J7 Pro</td>
													<th><input style="text" class="form-control" disabled></th>
												</tr> -->
											</tbody>
										</table>
										
										
										

										<div>
											<a href="helpdesk_all_request.php"><button type="button" class="btn btn-danger" data-dismiss="modal">Back</button></a>
										</div>

									</section>
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
   
    <script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>


    <script src="js/scripts.js"></script>
    <script src="js/advanced-form.js"></script>

</body>

</html>