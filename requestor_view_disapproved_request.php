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
                    Welcome Requestor!
                </a>
            </div>

            <div class="nav notify-row" id="top_menu">

            </div>

        </header>
        <!--header end-->
        <?php include 'requestor_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">
                            <h2>Status: <span class="label label-danger">Disapproved</span></h2>
                            <center><img src="img/logo.png" width="150" height="150"> </center>
                            <center><b>
                                    <h3>De La Salle University</h3>
                                </b></center>
                            <center><b>
                                    <h5>Information Technology Services</h5>
                                </b></center>
                            <center><b>
                                    <h3>Hardware Software Request Form</h3>
                                </b></center>
                            <br>

                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Quantity</th>
                                        <th>Hardware/ Software Requirements</th>
                                        <th>Estimated Cost</th>
                                        <th>Source of Budget</th>
                                        <th>Recommended Supplier</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>10</td>
                                        <td>Shabu</td>
                                        <td>P 1000.00</td>
                                        <td>Nanay Mo Corp.</td>
                                        <td>CDR King</td>
                                    </tr>

                                    <tr>
                                        <td>10</td>
                                        <td>Microphones</td>
                                        <td>P 1000.00</td>
                                        <td>Sponsor</td>
                                        <td>CDR King</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <br>

                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Course(s) That Will Use The Requirement(s)</th>
                                        <th>Course Offering Per Academic Year</th>
                                        <th>Projected Number of Students Per Section</th>
                                        <th>Projected Number of Sections Per Term</th>
                                        <th>Projected Number of Sections Per Year</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>ITMETHD</td>
                                        <td>3</td>
                                        <td>45</td>
                                        <td>3</td>
                                        <td>12</td>
                                    </tr>
                                </tbody>
                            </table>
							<hr border="2">
							<h2>Admin comments</h2>
							<p>No.</p>
							<hr>
							<button type="button" class="btn btn-danger" id="buttonBack">Back</button>
                            
                    </div>
                </div>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>
	
	<script type="text/javascript">
    document.getElementById("buttonBack").onclick = function () {
        location.href = "requestor_requests.php";
    };
	
	document.getElementById("buttonConforme").onclick = function () {
		window.location = "requestor_service_request_form_conforme.php";
    };
	</script>

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