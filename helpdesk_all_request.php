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
    <link rel="stylesheet" href="js/data-tables/DT_bootstrap.css" />
    <link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />

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
                                    All Requests
                                    <span class="tools pull-right">
                                        <a href="helpdesk_create_ticket.php" class="fa fa-plus"></a>
                                    </span>
                                </header>
                                <div class="panel-body">
                                    <div class="adv-table" id="ctable">
                                        <table class="display table table-bordered table-striped" id="dynamic-table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th>Type of Request</th>
                                                    <th>Date Needed</th>
                                                </tr>
                                            </thead>
                                            <tbody>
											
                                                <tr class="gradeA">
                                                    <td>1</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                </tr>

                                                <tr class="gradeA">
                                                    <td>2</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                </tr>

                                                <tr class="gradeA">
                                                    <td>3</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                </tr>

                                                <tr class="gradeA">
                                                    <td>4</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                </tr>

                                                <tr class="gradeA">
                                                    <td>5</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                </tr>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th>Type of Request</th>
                                                    <th>Date Needed</th>
                                                </tr>
                                            </tfoot>
                                        </table>
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

    <!-- WAG GALAWIN PLS LANG -->

    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>
    <script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
    <script src="js/dynamic_table_init.js"></script>

    <script>
        $('#ctable').on('dblclick', function() {
            window.location.replace("helpdesk_view_request.php");
        })
    </script>

    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>