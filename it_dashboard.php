<!DOCTYPE html>
<?php
	session_start();
	$StartDate = strtotime('2018-1-3'); //Start date from which we begin count
	$CurDate = date("Y-m-d"); //Current date.
	$NextDate = date("Y-m-d", strtotime("+2 week", $StartDate)); //Next date = +2 week from start date
	while ($CurDate > $NextDate ) { 
	  $NextDate = date("Y-m-d", strtotime("+2 week", strtotime($NextDate)));
	}
	$_SESSION['dateDisposal']=date("Y-m-d", strtotime($NextDate));
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

                <div class="col-sm-12">
                    <div class="col-sm-12">
                        <div class="alert alert-info">
                            <strong>Hello! <?php echo $_SESSION['dateDisposal']; ?> is the next Disposal Day! </strong> Please Click this  <a href="it_view_disposal_list.php" class="alert-link">link</a> to input the assets for collection for disposal.
                        </div>
                        <div class="row">

                            <a href="it_inventory.php">
                                <div class="col-md-3">
                                    <div class="mini-stat clearfix">
                                        <span class="mini-stat-icon green"><i class="fa fa-barcode"></i></span>
                                        <div class="mini-stat-info">
                                            <span>32,000</span>
                                            Total Assets
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="it_software.php">
                                <div class="col-md-3">
                                    <div class="mini-stat clearfix">
                                        <span class="mini-stat-icon orange"><i class="fa fa-save"></i></span>
                                        <div class="mini-stat-info">
                                            <span>22,450</span>
                                            Deployed
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="it_inventory.php">
                                <div class="col-md-3">
                                    <div class="mini-stat clearfix">
                                        <span class="mini-stat-icon pink"><i class="fa fa-keyboard-o"></i></span>
                                        <div class="mini-stat-info">
                                            <span>34,320</span>
                                            On Hand
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="it_inventory.php">
                                <div class="col-md-3">
                                    <div class="mini-stat clearfix">
                                        <span class="mini-stat-icon green"><i class="fa fa-files-o"></i></span>
                                        <div class="mini-stat-info">
                                            <span>32720</span>
                                            Broken Fixable
                                        </div>
                                    </div>
                                </div>
                            </a>


                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="panel">
                                        <header class="panel-heading">
                                            Recent Activities
                                            <span class="tools pull-right">
                                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                            </span>
                                        </header>
                                        <div class="panel-body">
                                            <div class="adv-table">
                                                <table class="display table table-bordered table-striped" id="dynamic-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Action</th>
                                                            <th>Item</th>
                                                            <th class="hidden-phone">To</th>
                                                            <th class="hidden-phone">Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="gradeX">
                                                            <td>October 15, 2018 9:53PM</td>
                                                            <td>Checked In</td>
                                                            <td>Win 95+</td>
                                                            <td>Mr. Allan Peter</td>
                                                            <td>Registered to PC</td>
                                                        </tr>
                                                        <tr class="gradeX">
                                                            <td>October 15, 2018 9:53PM</td>
                                                            <td>Checked In</td>
                                                            <td>Win 95+</td>
                                                            <td>Mr. Allan Peter</td>
                                                            <td>Registered to PC</td>
                                                        </tr>
                                                        <tr class="gradeX">
                                                            <td>October 15, 2018 9:53PM</td>
                                                            <td>Checked In</td>
                                                            <td>Win 95+</td>
                                                            <td>Mr. Allan Peter</td>
                                                            <td>Registered to PC</td>
                                                        </tr>
                                                        <tr class="gradeX">
                                                            <td>October 15, 2018 9:53PM</td>
                                                            <td>Checked In</td>
                                                            <td>Win 95+</td>
                                                            <td>Mr. Allan Peter</td>
                                                            <td>Registered to PC</td>
                                                        </tr>
                                                        <tr class="gradeX">
                                                            <td>October 15, 2018 9:53PM</td>
                                                            <td>Checked In</td>
                                                            <td>Win 95+</td>
                                                            <td>Mr. Allan Peter</td>
                                                            <td>Registered to PC</td>
                                                        </tr>
                                                        <tr class="gradeX">
                                                            <td>October 15, 2018 9:53PM</td>
                                                            <td>Checked In</td>
                                                            <td>Win 95+</td>
                                                            <td>Mr. Allan Peter</td>
                                                            <td>Registered to PC</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Action</th>
                                                            <th>Item</th>
                                                            <th class="hidden-phone">To</th>
                                                            <th class="hidden-phone">Remarks</th>
                                                        </tr>
                                                    </tfoot>
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