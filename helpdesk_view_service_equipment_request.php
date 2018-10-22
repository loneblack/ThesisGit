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
                                    Service Equipment Request
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
                                
                                <div style="padding-top:55px" class="form" method="post">
									<form class="cmxform form-horizontal " id="signupForm" method="get" action="">
										<div class="form-group ">
											<label for="serviceType" class="control-label col-lg-3">Office/Department/School Organization</label>
											<div class="col-lg-6">
												<select name="serviceType" class="form-control m-bot15" disabled>
													<option>Select</option>
													<?php

												  
													$sql = "SELECT * FROM thesis.offices;";

													$result = mysqli_query($dbc, $sql);

													while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
													{
														
														echo "<option value ={$row['officeID']}>";
														echo "{$row['Name']}</option>";

													}
												   ?>
													
												</select>
											</div>
										</div>
										<div class="form-group ">
											<label for="number" class="control-label col-lg-3">Contact No.</label>
											<div class="col-lg-6">
												<input class="form-control" rows="5" name="details" style="resize:none" type="text" disabled required></input>
											</div>
										</div>
										<div class="form-group ">
											<label for="dateNeeded" class="control-label col-lg-3">Date & time needed</label>
											<div class="col-lg-6">
												<input class="form-control" id="dateNeeded" name="dateNeeded" type="datetime-local" disabled required />
											</div>
										</div>
										<div class="form-group ">
											<label for="endDate" class="control-label col-lg-3">End date & time</label>
											<div class="col-lg-6">
												<input class=" form-control" id="endDate" name="endDate" type="datetime-local" disabled required />
											</div>
										</div>
										<div class="form-group ">
											<label for="purpose" class="control-label col-lg-3">Purpose</label>
											<div class="col-lg-6">
												<input class="form-control" id="purpose" name="purpose" type="text" disabled />
											</div>
										</div>
										<div class="form-group ">
											<label for="building" class="control-label col-lg-3">Building</label>
											<div class="col-lg-6">
												<select name="building" class="form-control m-bot15" onChange="getRooms(this.value)" disabled>
													<option>Select building</option>
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
										<hr>
										<div class="container-fluid">
											<h4>Equipment to be borrowed</h4>
											
											<table style="width:670px" class="table table-bordered table-striped table-condensed table-hover" id="tblCustomers" align="center" cellpadding="0" cellspacing="0" border="1">
												<thead>
													<tr>
														<th style="width:500px">Equipment</th>
														<th style="width:150px">Quantity</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
												<tfoot>
													<tr>
														<td>
															<select class="form-control" id="txtName" disabled>
																<option>Select</option>
															</select>
														</td>
														<td><input class="form-control" type="number" min="1" id="txtCountry" disabled/></td>
													</tr>
												</tfoot>
											</table>
										</div>
										<hr>
										<div class="container-fluid">
											<h4>Endorsement (if applicable)</h4>
											<div class="form-group ">
												<label for="representative" class="control-label col-lg-3">Representative</label>
												<div class="col-lg-6">
													<input class="form-control" id="representative" name="representative" type="text" disabled />
												</div>
											</div>
											<div class="form-group ">
												<label for="idNum" class="control-label col-lg-3">ID Number</label>
												<div class="col-lg-6">
													<input class="form-control" id="idNum" name="idNum" type="text" disabled />
												</div>
											</div>
											<div class="form-group">
												<div style="padding-left:10px">
													<a href="helpdesk_all_request.php"><button style="float:left" class="btn btn-default" type="button">Back</button></a>
												</div>
											</div>
										</div>
									</form>
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