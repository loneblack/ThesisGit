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
                                    Asset Testing Request
                                </header>
                                
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
													
													<th>Property Code</th>
													<th>Item</th>
													<th>Specification</th>
													<th>Comments</th>
												</tr>
											</thead>
											<tbody>
												<tr>
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
												</tr>
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