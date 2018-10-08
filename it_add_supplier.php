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

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">
                            <section class="panel">
                                <header class="panel-heading">
                                    Add A Supplier
                                </header>
                                <div class="panel-body">
                                    <div class="form" method="post">
                                        <form class="cmxform form-horizontal " id="signupForm" method="get" action="">
                                            <div class="form-group ">
                                                <label for="companyName" class="control-label col-lg-3">Company Name</label>
                                                <div class="col-lg-6">
                                                    <input class=" form-control" id="companyName" name="companyName" type="text" />
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="contactPerson" class="control-label col-lg-3">Contact Person</label>
                                                <div class="col-lg-6">
                                                    <input class=" form-control" id="contactPerson" name="contactPerson" type="text" />
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="lastname" class="control-label col-lg-3">Contact Number</label>
                                                <div class="col-lg-6">
                                                    <input class=" form-control" id="number" name="number" type="number" min="0.00" />
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="email" class="control-label col-lg-3">Email (DLSU)</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control " id="email" name="email" type="email" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Address</label>
                                                <div class="col-sm-6" name="address" id="address">
                                                    <textarea class="form-control" rows="6"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-lg-offset-3 col-lg-6">
                                                    <button class="btn btn-primary" type="submit">Save</button>
                                                    <button class="btn btn-default" type="button">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
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


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>