<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="images/favicon.png">

    <title>Horizontal menu page</title>

    <!--Core CSS -->
    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
    <link href="css/outside_form.css" rel="stylesheet" />

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body class="full-width">

    <section id="container" class="hr-menu">
        <!--header start-->

        <section id="main-content">
            <section class="wrapper">
                <div class="panel-body">
                    <div class="container">
                        <form id="contact" action="" method="post">
                            <h3>Request For Donation</h3>
                            <fieldset>
                                <input placeholder="Office/Department/School Organization" type="text" tabindex="1" required autofocus>
                            </fieldset>
                            <fieldset>
                                <input placeholder="Contact Person" type="text" tabindex="1" required autofocus>
                            </fieldset>
                            <fieldset>
                                <input placeholder="Contact No." type="text" tabindex="2" required>
                            </fieldset>
                            <fieldset>
                                <input placeholder="Date and Time Needed" type="tel" tabindex="3" required>
                            </fieldset>
                            <fieldset>
                                <input placeholder="Purpose" type="url" tabindex="4" required>
                            </fieldset>
                            <fieldset>
                                <textarea placeholder="Input item and quantity for donation" tabindex="5" required></textarea>
                            </fieldset>
                            <fieldset>
                                <button class="btn btn-success">Submit</button>
                                <button class="btn btn-danger" onclick="window.location.href='login.php'">Back</button>
                            </fieldset>
                            
                        </form>
                    </div>

                </div>
            </section>
        </section>
    </section>

    <!-- Placed js at the end of the document so the pages load faster -->

    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/hover-dropdown.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>
    <!--Easy Pie Chart-->
    <script src="js/easypiechart/jquery.easypiechart.js"></script>
    <!--Sparkline Chart-->
    <script src="js/sparkline/jquery.sparkline.js"></script>
    <!--jQuery Flot Chart-->
    <script src="js/flot-chart/jquery.flot.js"></script>
    <script src="js/flot-chart/jquery.flot.tooltip.min.js"></script>
    <script src="js/flot-chart/jquery.flot.resize.js"></script>
    <script src="js/flot-chart/jquery.flot.pie.resize.js"></script>


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>