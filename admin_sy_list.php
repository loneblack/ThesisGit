<!DOCTYPE html>
<?php
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
        <?php include 'admin_navbar.php' ?>

        <!--main content-->
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
                                            School Year
                                            <span class="tools pull-right">
                                                <a class="fa fa-plus" href="admin_add_sy.php"></a>
                                            </span>
                                        </header>
                                        <div class="panel-body">
                                            <section id="unseen">
                                                <div class="adv-table">
                                                    <table class="display table table-bordered table-striped" id="dynamic-table">
                                                        <thead>
                                                            <tr>
                                                                <th>School Year</th>
                                                                <th>Term 1</th>
                                                                <th>Term 2</th>
                                                                <th>Term 3</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
															$query="SELECT * FROM thesis.schoolyear order by SchoolYearID;";
															$result=mysqli_query($dbc,$query);
															while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
																
																//Format dates
																$stterm1 = new DateTime($row['Term1Start']);
																$stterm2 = new DateTime($row['Term2Start']);
																$stterm3 = new DateTime($row['Term3Start']);
																$enterm1 = new DateTime($row['Term1End']);
																$enterm2 = new DateTime($row['Term2End']);
																$enterm3 = new DateTime($row['Term3End']);
																
																$stterm1 = date_format($stterm1,"F j, Y");
																$stterm2 = date_format($stterm2,"F j, Y");
																$stterm3 = date_format($stterm3,"F j, Y");
																$enterm1 = date_format($enterm1,"F j, Y");
																$enterm2 = date_format($enterm2,"F j, Y");
																$enterm3 = date_format($enterm3,"F j, Y");
																
																echo "<tr class='SchoolYearID' id='{$row['SchoolYearID']}'>
																	<td>{$row['SchoolYear']}</td>
																	<td>{$stterm1} - {$enterm1}</td>
																	<td>{$stterm2} - {$enterm2}</td>
																	<td>{$stterm3} - {$enterm3}</td>
																</tr>";
															}
														?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </section>
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


    <script>
        $('#dynamic-table').on('click', function() {
            $('.brandID').on('click', function() {
                var a = this.getAttribute("id");
                window.location.href = "it_edit_brand.php?brandID=" + a;
            })
        })
    </script>

</body>

</html>