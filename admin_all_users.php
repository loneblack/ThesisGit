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
                    Welcome Admin!
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
                        <section class="panel">
                            <header class="panel-heading">
                                All Users
                            </header>
                            <div class="panel-body">
                                <section id="unseen">
                                    <table class="table table-bordered table-striped table-condensed table-hover" id="ctable">
                                        <thead>
                                            <tr>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Contact Number</th>
                                                <th>Username</th>
                                                <th>User Type</th>
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Marvin</td>
                                                <td>Lao</td>
                                                <td>marvin_lao@dlsu.edu.ph</td>
                                                <td>09178328851</td>
                                                <td>admin</td>
                                                <td>Super Admin</td>
                                                <td><a href="admin_edit_user.php"><button type="button" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Edit</button></a></td>
                                            </tr>
                                            <tr>
                                                <td>Marvin</td>
                                                <td>Lao</td>
                                                <td>marvin_lao@dlsu.edu.ph</td>
                                                <td>09178328851</td>
                                                <td>admin</td>
                                                <td>Help Desk</td>
                                                <td><a href="admin_edit_user.php"><button type="button" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Edit</button></a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </section>
                            </div>
                        </section>
                    </div>
                </div>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>

    <!-- WAG BAGUHIN ANG BABA PLS LANG -->

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