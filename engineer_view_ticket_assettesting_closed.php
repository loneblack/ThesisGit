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
                    Welcome Engineer!
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
											<label>Name: </label><input type="text" class="form-control" disabled>
											<br>
											<label>Office Building: </label><input type="text" class="form-control" disabled>
											<br>
											<label>Room Number: </label><input type="text" class="form-control" disabled>
											
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
                                                        <th>Property Code</th>
                                                        <th>Item</th>
                                                        <th>Specification</th>
                                                        <th>Comments</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
														<td style="text-align:center"><input type='checkbox' class='form-check-input' disabled></td>
                                                        <td style="text-align:center">TBLT-001</td>
                                                        <td style="text-align:center">Apple Tablet</td>
                                                        <td style="text-align:center">iPad</td>
														<th><input style="text" class="form-control" disabled></th>
                                                        
                                                    </tr>
                                                    <tr >
														<td style="text-align:center"><input type='checkbox' class='form-check-input' disabled></td>
                                                        <td style="text-align:center; width:50px;">PC-0023</td>
                                                        <td style="text-align:center">Windows</td>
                                                        <td style="text-align:center">Windows 10</td>
                                                        <th><input style="text" class="form-control" disabled></th>
                                                    </tr>
													<tr>
                                                        <td style="text-align:center"><input type='checkbox' class='form-check-input' disabled></td>
														<td style="text-align:center">PHN-0312</td>
                                                        <td style="text-align:center">Smartphone</td>
                                                        <td style="text-align:center">Samsung Galaxy J7 Pro</td>
                                                        <th><input style="text" class="form-control" disabled></th>
                                                    </tr>
                                                </tbody>
                                            </table>
											
											
											

                                            <div>
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
											<form class="cmxform form-horizontal " id="signupForm" method="post" action="">
												<div class="form-group ">
													<div class="form-group ">
														<label style="padding-left:22px" for="category" class="control-label col-lg-4">Category</label>
														<div class="col-lg-8" style="padding-right:30px">
															<select class="form-control m-bot15" disabled>
																<option selected="selected">Repair</option>
																<option>Repair</option>
																<option>Maintenance</option>
																<option>Replacement</option>
															</select>
														</div>
													</div>

													<label for="status" class="control-label col-lg-4">Status</label>
													<div class="col-lg-8">
														<select class="form-control m-bot15" disabled>
															<option>Assigned</option>
															<option>In Progress</option>
															<option selected="selected">Transferred</option>
															<option>Escalated</option>
															<option>Waiting For Parts</option>
															<option>Closed</option>
														</select>
													</div>
												</div>

												<div class="form-group ">
													<label for="priority" class="control-label col-lg-4">Priority</label>
													<div class="col-lg-8">
														<select class="form-control m-bot15" disabled>
															<option selected="selected">Low</option>
															<option>Medium</option>
															<option>High</option>
															<option>Urgent</option>
														</select>
													</div>
												</div>

												<div class="form-group ">
													<label for="assign" class="control-label col-lg-4">Escalate To</label>
													<div class="col-lg-8">
														<select class="form-control m-bot15" disabled>
															<option selected="selected">Eng. Marvin Lao</option>
															<option>Eng. Marvin Lao</option>
															<option>Eng. Marvin Lao</option>
															<option>Eng. Marvin Lao</option>
															<option>Eng. Marvin Lao</option>
															<option>Eng. Marvin Lao</option>
														</select>
													</div>
												</div>

												<div class="form-group">
													<label class="control-label col-lg-4">Due Date</label>
													<div class="col-lg-8">
														<input class="form-control form-control-inline input-medium default-date-picker" size="10" type="text" value="10-13-2018" disabled />
													</div>
												</div>

												<div class="form-group">
													<label class="control-label col-lg-4">Repair Date *</label>
													<div class="col-lg-8">
														<input class="form-control form-control-inline input-medium default-date-picker" size="10" type="text" value="10-13-2018" disabled required />
													</div>
												</div>
											</form>
										</div>

									</div>
								</section>
							</div>
							
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
    </script>
	
	
	

</body>

</html>