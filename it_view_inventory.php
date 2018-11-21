<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />

    <!--dynamic table-->
    <link href="js/advanced-datatable/css/demo_page.css" rel="stylesheet" />
    <link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/data-tables/DT_bootstrap.css" />

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
        <?php include 'it_navbar.php' ?>
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12">

                                    <section class="panel">
                                    <header class="panel-heading">
                                        DITO ANG ASSETS AS AN INDIVIDUAL AT HINDI CNCOMBINE FOR EXAMPLE CHARGER
                                    </header>
                                    <div class="panel-body">
                                        <div class="adv-table">
                                            <table class="display table table-bordered table-striped" id="dynamic-table">
                                                <thead>
                                                    <tr>
                                                        <th>Property Code</th>
                                                        <th>Brand</th>
                                                        <th>Model</th>
                                                        <th class="hidden-phone">Category</th>
                                                        <th class="hidden-phone">Checked-out To</th>
                                                        <th>Location</th>
                                                        <th>Checkin/ Checkout</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="gradeA">
                                                        <td>1726312368</td>
                                                        <td>Dell</td>
                                                        <td>GT19291</td>
                                                        <td class="center hidden-phone">Laptop</td>
                                                        <td class="center hidden-phone">Austin Pementel</td>
                                                        <td>Andrew 1105</td>
                                                        <td class="center"><a href="it_checkin.php"><button type="button" class="btn btn-info">Checkin</button></a></td>
                                                    </tr>
                                                    <tr class="gradeA">
                                                        <td>838423479</td>
                                                        <td>Samsung</td>
                                                        <td>Curve 55"</td>
                                                        <td class="center hidden-phone">Television</td>
                                                        <td class="center hidden-phone">Marvin Lao</td>
                                                        <td>Goks Lobby</td>
                                                        <td class="center"><a href="it_checkin.php"><button type="button" class="btn btn-info">Checkin</button></a></td>
                                                    </tr>
                                                    <tr class="gradeA">
                                                        <td>123123123</td>
                                                        <td>Samsung</td>
                                                        <td>Galaxy S9</td>
                                                        <td class="center hidden-phone">Smartphone</td>
                                                        <td class="center hidden-phone"></td>
                                                        <td></td>
                                                        <td class="center"><a href="it_checkout.php"><button type="button" class="btn btn-danger">Checkout</button></a></td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <th>Property Code</th>
                                                        <th>Brand</th>
                                                        <th>Model</th>
                                                        <th class="hidden-phone">Category</th>
                                                        <th class="hidden-phone">Checked-out To</th>
                                                        <th>Location</th>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
            </section>








            <section class="panel">
                <header class="panel-heading">
                    Place Product name that is combinable here
                </header>
                <div class="panel-body">
                    <div class="adv-table">
                        <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                            <thead>
                                <tr>
                                    <th>PC Property Code</th>
                                    <th class="hidden-phone">Mouse</th>
                                    <th class="hidden-phone">Keyboard</th>
                                    <th class="hidden-phone">Hardrive</th>
                                    <th class="hidden-phone">Monitor</th>
                                    <th>Check-out</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="gradeA">
                                    <td class="center">972573</td>
                                    <td class="hidden-phone">Acer</td>
                                    <td class="hidden-phone">Acer</td>
                                    <td class="hidden-phone">Seagate</td>
                                    <td class="hidden-phone">Samsung LCD 40"</td>
                                    <td>Arvin Lao</td>
                                </tr>

                                <tr class="gradeA">
                                    <td class="center">972573</td>
                                    <td class="hidden-phone">Acer</td>
                                    <td class="hidden-phone">Acer</td>
                                    <td class="hidden-phone">Seagate</td>
                                    <td class="hidden-phone">Samsung LCD 40"</td>
                                    <td></td>
                                </tr>

                                <tr class="gradeA">
                                    <td class="center">972573</td>
                                    <td class="hidden-phone">Acer</td>
                                    <td class="hidden-phone">Acer</td>
                                    <td class="hidden-phone">Seagate</td>
                                    <td class="hidden-phone">Samsung LCD 40"</td>
                                    <td>Marvin Lao</td>
                                </tr>
                                <tr class="gradeA">
                                    <td class="center">972573</td>
                                    <td class="hidden-phone">Acer</td>
                                    <td class="hidden-phone">Acer</td>
                                    <td class="hidden-phone">Seagate</td>
                                    <td class="hidden-phone">Samsung LCD 40"</td>
                                    <td></td>
                                </tr>

                            </tbody>
                        </table>

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
    </section>
    <!-- WAG GALAWIN PLS LANG -->


    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>
    <script>
        $('#ctable').on('dblclick', function() {
            window.location.href = "it_view_inventory.php";
        })
    </script>


    <!--dynamic table-->
    <script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

    <!--dynamic table initialization -->
    <script src="js/dynamic_table_init.js"></script>


</body>

</html>