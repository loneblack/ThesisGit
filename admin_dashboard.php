<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">

    <title>DLSU IT Asset Management</title>

    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="js/jquery-ui/jquery-ui-1.10.1.custom.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="js/jvector-map/jquery-jvectormap-1.2.2.css" rel="stylesheet">
    <link href="css/clndr.css" rel="stylesheet">
    <!--clock css-->
    <link href="js/css3clock/css/style.css" rel="stylesheet">
    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="js/morris-chart/morris.css">
    <!-- Custom styles for this template -->
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
        <?php include 'admin_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">



                            <div class="row">
                                <div class="col-md-8">
                                    <div class="event-calendar clearfix">
                                        <div class="col-lg-7 calendar-block">
                                            <div class="cal1 ">
                                            </div>
                                        </div>
                                        <div class="col-lg-5 event-list-block">
                                            <div class="cal-day">
                                                <span>Today</span>
                                                Friday
                                            </div>
                                            <ul class="event-list">
                                                <li>Create Account for Austin Pimentel @ 3:30 <a href="#" class="event-close"><i class="ico-close2"></i></a></li>
                                                <li>Destroy Fred Purisima's Account @ 4:30 <a href="#" class="event-close"><i class="ico-close2"></i></a></li>
                                                <li>Block Access Johannes' Account @ 5:45 <a href="#" class="event-close"><i class="ico-close2"></i></a></li>
                                                <li>Make Marvin King @ 7:00 <a href="#" class="event-close"><i class="ico-close2"></i></a></li>

                                            </ul>
                                            <input type="text" class="form-control evnt-input" placeholder="NOTES">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">

                                    <section class="panel">
                                        <div class="panel-body">
                                            <div class="top-stats-panel">
                                                <div class="daily-visit">
                                                    <h4 class="widget-h">Daily Logins</h4>
                                                    <div id="daily-visit-chart" style="width:100%; height: 380px; display: block">

                                                    </div>
                                                    <ul class="chart-meta clearfix">
                                                        <li class="pull-left visit-chart-value">10</li>
                                                        <li class="pull-right visit-chart-title"><i class="fa fa-arrow-up"></i> 15%</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </section>


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

    <!-- WAG GALAWIN PLS LANG -->

    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="js/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>
    <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
    <script src="js/skycons/skycons.js"></script>
    <script src="js/jquery.scrollTo/jquery.scrollTo.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="js/calendar/clndr.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js"></script>
    <script src="js/calendar/moment-2.2.1.js"></script>
    <script src="js/evnt.calendar.init.js"></script>
    <!--jQuery Flot Chart-->
    <script src="js/flot-chart/jquery.flot.js"></script>
    <script src="js/flot-chart/jquery.flot.tooltip.min.js"></script>
    <script src="js/flot-chart/jquery.flot.resize.js"></script>
    <script src="js/flot-chart/jquery.flot.pie.resize.js"></script>
    <script src="js/flot-chart/jquery.flot.animator.min.js"></script>
    <script src="js/flot-chart/jquery.flot.growraf.js"></script>
    <script src="js/dashboard.js"></script>
    <script src="js/jquery.customSelect.min.js"></script>
    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>