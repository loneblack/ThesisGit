<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');




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
        <?php include 'it_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="col-sm-12">


                        <div class="col-sm-12">
                            <section class="panel">
                                <header class="panel-heading">
                                    Replace Missing Items
                                </header>
                                <div class="panel-body">
                                    <section id="unseen">
                                        <h4>Items Missing</h4>
                                        <div class="adv-table">
                                            <table class="table table-bordered table-striped table-condensed table-hover " id="">
                                                <thead>
                                                    <tr>
                                                        <th>Property Code</th>
                                                        <th>Brand</th>
                                                        <th>Model</th>
                                                        <th>Specifications</th>
                                                        <th>Location</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <h4>Items Replacing Missing Items</h4>
                                        <div class="adv-table">
                                            <table class="table table-bordered table-striped table-condensed table-hover " id="">
                                                <thead>
                                                    <tr>
                                                        <th>Property Code</th>
                                                        <th>Brand</th>
                                                        <th>Model</th>
                                                        <th>Specifications</th>
                                                        <th>Location</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <button class="btn btn-success">Submit</button>
                                        <button class="btn btn-danger">Back</button>
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
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>
    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>