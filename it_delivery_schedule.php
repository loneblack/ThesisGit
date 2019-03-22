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
                                    Scheduled Deliveries
                                </header>
                                <div class="panel-body">
                                    <div class="adv-table" id="ctable">
                                        <table class="display table table-bordered table-striped" id="dynamic-table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Delivered To</th>
                                                    <th>Department</th>
													<th>Building</th>
													<th>Floor</th>
                                                    <th>Type of Delivery</th>
													<th>Delivery Date</th>
                                                </tr>
                                            </thead>

                                            <tbody>
												<tr class='gradeA'>
													<td style='display: none'>1</td>
													<td>1</td>
													<td>John Doe</td>
													<td>Biology</td>
													<td>BGC-Rufino Campus</td>
													<td>201</td>
													<td><span class="label label-success">Complete</span></td>
													<td>11-02-2019</td>
													<td style='display: none'></td>
												</tr>

                                                <tr class='gradeA'>
                                                    <td style='display: none'>1</td>
                                                    <td>2</td>
                                                    <td>ASDSFD</td>
                                                    <td>Philosophy</td>
                                                    <td>St. La Salle Hall (LS)</td>
                                                    <td>305</td>
                                                    <td><span class="label label-warning">Partial</span></td>
                                                    <td>11-03-2019</td>
                                                    <td style='display: none'></td>
                                                </tr>
                                                
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Request ID</th>
                                                    <th>Delivered To</th>
                                                    <th>Department</th>
                                                    <th>Building</th>
                                                    <th>Floor</th>
                                                    <th>Type of Delivery</th>
                                                    <th>Delivery Date</th>
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

    <script>
    function addRowHandlers() {
        var table = document.getElementById("dynamic-table");
        var rows = table.getElementsByTagName("tr");
        for (i = 1; i < rows.length; i++) {
            var currentRow = table.rows[i];
            var createClickHandler = function(row) {
                return function() {
                    var cell = row.getElementsByTagName("td")[0];
                    var id = cell.textContent;

                    window.location.href = "it_view_delivery_details.php";

                };
            };
            currentRow.onclick = createClickHandler(currentRow);
        }
    }
    window.onload = addRowHandlers();
    </script>

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


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>