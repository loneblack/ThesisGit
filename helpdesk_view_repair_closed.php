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
                                    Repair Request
                                </header>
                                <div style="padding-top:55px" class="panel-body">
									<div class="form" method="post">
										<form class="cmxform form-horizontal " id="servicerequest" method="post" action="requestor_service_request_form_DB.php">
											
												<header style="padding-bottom:20px" class="panel-heading wht-bg">
													<h4 class="gen-case" style="float:right"> <a class="btn btn-danger">Closed</a></h4>
													<h4>Repair Request</h3>
												</header>
												<div class="panel-body ">

													<div>
														<div class="row">
															<div class="col-md-8">
																<img src="images/chat-avatar2.jpg" alt="">
																<strong>IT Office</strong>
																to
																<strong>me</strong>
															</div>
															<div class="col-md-4">
																<p class="date"> 10:15AM 02 FEB 2018</p><br><br>
															</div>
														</div>
													</div>
													<div class="view-mail">
														<p>HI would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. </p>
													</div>
												</div>
							</section>
							
							
										<section class="panel">
											<div class="panel-body ">
												<table class="table table-hover">
													<thead>
														<tr>
															
															<th>Asset/ Software Name</th>
															<th>Property Code</th>
															<th>Building</th>
															<th>Room</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>PC</td>
															<td>123456</td>
															<td>Br. Andrew</td>
															<td>A 1702</td>
														</tr>
													</tbody>
												</table>
											</div>
										</section>
										
										<div class="form-control">
											<a href="engineer_all_ticket.php"><button class="btn btn-danger">Back</button></a>
										</div>
										
							
										</form>
									</div>
								</div>
                            

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