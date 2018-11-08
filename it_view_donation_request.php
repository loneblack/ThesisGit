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
    <link rel="stylesheet" href="js/morris-chart/morris.css">
    <!--dynamic table-->
    <link href="js/advanced-datatable/css/demo_page.css" rel="stylesheet" />
    <link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/data-tables/DT_bootstrap.css" />

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
                    Welcome IT Officer!
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

                <div class="col-sm-12">
                    <div class="col-sm-12">

                        <div class="row">




                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="panel">
                                        <header class="panel-heading">
                                            View Donation Request
                                        </header>
                                        <div class="panel-body">
                                            <h5><b>Office/ Department/ School Organization: Gaylord Academy</b></h5>
                                            <h5><b>Contact Number: 09178328851</b></h5>
                                            <h5><b>Date Time Needed: 12/23/2018 12:00:00AM</b></h5>
                                            <h5><b>Purpose: To serve our gay community</b></h5>

                                            <div>

                                                <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                    <thead>
                                                        <tr>
                                                            <th>Category</th>
                                                            <th>Brand</th>
                                                            <th>Model</th>
                                                            <th>Property Code</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Computer</td>
                                                            <td><input type="text" class="form-control" placeholder="dapat naguupdate automatically to at ung next pag may naselect sa select" readonly></td>
                                                            <td><input type="text" class="form-control" readonly></td>
                                                            <td>
                                                                <select class="form-control">
                                                                    <option>Select Property Code</option>
                                                                </select>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                                
                                                <button class="btn btn-success">Send</button>
                                                <button class="btn btn-danger" onclick="location.href='it_requests.php'">Back</button>
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

    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>

    <!--dynamic table-->
    <script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

    <script src="js/morris-chart/morris.js"></script>
    <script src="js/morris-chart/raphael-min.js"></script>
    <script src="js/morris.init.js"></script>

    <!--dynamic table initialization -->
    <script src="js/dynamic_table_init.js"></script>

</body>

</html>