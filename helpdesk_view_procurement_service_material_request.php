<!DOCTYPE html>
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
                                                    <form class="cmxform form-horizontal " id="signupForm" method="post" action="">
                                                        <div class="form-group ">
                                                            <div class="form-group ">
                                                                <label for="category" class="control-label col-lg-3">Category</label>
                                                                <div class="col-lg-6">
                                                                    <select class="form-control m-bot15" name="category" value="" required>

                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <label for="status" class="control-label col-lg-3">Status</label>
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-bot15" name="status" value="" required>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group ">
                                                            <label for="priority" class="control-label col-lg-3">Priority</label>
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-bot15" name="priority" value="" required>
                                                                    <option value='Low'>Low</option>
                                                                    <option value='Medium'>Medium</option>
                                                                    <option value='High'>High</option>
                                                                    <option value='Urgent'>Urgent</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group ">
                                                            <label for="assign" class="control-label col-lg-3">Assigned</label>
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-bot15" name="assigned" value="" required>


                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">Due Date</label>
                                                            <div class="col-lg-6">
                                                                <!-- class="form-control form-control-inline input-medium default-date-picker" -->
                                                                <input class="form-control m-bot15" size="10" name="dueDate" type="datetime-local" value="" required />
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
											<section>
												<h4>Contact Information</h4>

												<div class="form-group ">
													<label for="department" class="control-label col-lg-3">Department</label>
													<div class="col-lg-6">
														<select name="department" class="form-control m-bot15" disabled>
															<option>Select department</option>
															<?php

																
																$sql = "SELECT * FROM thesis.department;";

																$result = mysqli_query($dbc, $sql);

																while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
																{
																	
																	echo "<option value ={$row['DepartmentID']}>";
																	echo "{$row['name']}</option>";

																}
														   ?>
														</select>
													</div>
												</div>
												<div class="form-group ">
													<label for="unitHead" class="control-label col-lg-3">Unit Head/Fund Owner</label>
													<div class="col-lg-6">
														<input class="form-control" rows="5" name="details" style="resize:none" type="text" disabled>
													</div>
												</div>
												<div class="form-group ">
													<label for="contactPerson" class="control-label col-lg-3">Contact Person</label>
													<div class="col-lg-6">
														<input class="form-control" id="contactPerson" name="contactPerson" type="text" disabled />
													</div>
												</div>
												<div class="form-group ">
													<label for="Email" class="control-label col-lg-3">Email (DLSU)</label>
													<div class="col-lg-6">
														<input name="email" id="email" class="form-control" type="email" pattern=".+dlsu.edu.ph" size="30" required disabled />
													</div>
												</div>

												<div class="form-group ">
													<label for="number" class="control-label col-lg-3">Contact Number</label>
													<div class="col-lg-6">
														<input class=" form-control" id="number" name="number" type="text" disabled />
													</div>
												</div>
											</section>
											<hr>
											<section>
												<h4>User Location Information</h4>
												<div class="form-group ">
													<label for="building" class="control-label col-lg-3">Building</label>
													<div class="col-lg-6">
														<select name="buildingID" id="buildingID" class="form-control m-bot15" onChange="getRooms(this.value)" disabled>
															<option>Select department</option>
															<?php

																$sql = "SELECT * FROM thesis.building;";

																$result = mysqli_query($dbc, $sql);

																while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
																{
																	
																	echo "<option value ={$row['BuildingID']}>";
																	echo "{$row['name']}</option>";

																}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label for="floorRoom" class="control-label col-lg-3">Floor & Room</label>
													<div class="col-lg-6">
														<select name="FloorAndRoomID" id="FloorAndRoomID" class="form-control m-bot15" disabled>
															<option valu=''>Select floor & room</option>
														</select>
													</div>
												</div>
												<div class="form-group ">
													<label for="recipient" class="control-label col-lg-3">Recipient</label>
													<div class="col-lg-6">
														<input class="form-control" id="recipient" name="recipient" type="text" disabled />
													</div>
												</div>
												<div class="form-group ">
													<label for="dateNeeded" class="control-label col-lg-3">Date needed</label>
													<div class="col-lg-6">
														<input class="form-control" id="dateNeeded" name="dateNeeded" type="date" disabled />
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
														<tr>
															<td>
																<div class="col-lg-12">
																	<input class="form-control" type="number" id="txtCountry" min="1" step="1" placeholder="Quantity" disabled />
																</div>
															</td>
															<td>
																<div class="col-lg-12">
																	<select class="form-control" id="amount" disabled>
																		<option>Select</option>
																		<?php

																			$sql = "SELECT * FROM thesis.ref_assetcategory;";

																			$result = mysqli_query($dbc, $sql);

																			while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
																			{
																				
																				echo "<option value ={$row['assetCategoryID']}>";
																				echo "{$row['name']}</option>";

																			}
																	   ?>
																	</select>
																</div>
															</td>
															<td style="padding-top:5px; padding-bottom:5px">
																<div class="col-lg-12">
																	<input class="form-control" type="text" id="txtName" placeholder="Item description" disabled />
																</div>
															</td>
														</tr>
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