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

                        <div class="row">
                            <div class="col-sm-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        Asset Testing Checklist
                                    </header>
                                    <div class="panel-body">
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
                                                        <th>Product Code</th>
                                                        <th>Item</th>
                                                        <th>Specification</th>
                                                        <th style="width:380px">What to check</th>
                                                        <th>Comments</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
														<td style="text-align:center"><input type='checkbox' class='form-check-input' checked disabled></td>
                                                        <td style="text-align:center">5</td>
                                                        <td style="text-align:center">Apple Tablet</td>
                                                        <td style="text-align:center">iPad</td>
                                                        <td style="text-align:center">Touchscreen</td>
														<th><input style="text" class="form-control" disabled></th>
                                                        
                                                    </tr>
                                                    <tr >
														<td style="text-align:center"><input type='checkbox' class='form-check-input' disabled></td>
                                                        <td style="text-align:center; width:50px;">5</td>
                                                        <td style="text-align:center">Windows</td>
                                                        <td style="text-align:center">Windows 10</td>
                                                        <td style="text-align:center">Task</td>
                                                        <th><input style="text" class="form-control" value="Broken" disabled></th>
                                                    </tr>
													<tr>
                                                        <td style="text-align:center"><input type='checkbox' class='form-check-input' disabled></td>
														<td style="text-align:center">1</td>
                                                        <td style="text-align:center">Smartphone</td>
                                                        <td style="text-align:center">Samsung Galaxy J7 Pro</td>
														<td style="text-align:center">Check touchscreen</td>
                                                        <th><input style="text" class="form-control" value="Lorem ipsum dolor" disabled></th>
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
	

</body>

</html>