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
                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="panel">
                                        <header class="panel-heading">
                                            Repair Report
                                        </header>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <section class="panel">
                                                        <form>
                                                            <div class="form-group">
                                                                <label class="col-sm-3 control-label col-lg-3" for="inputSuccess">Select Month</label>
                                                                <div class="col-lg-6">
                                                                    <select class="form-control input-sm m-bot15">
                                                                        <option value="0">Select Month</option>
                                                                        <option value="1">January</option>
                                                                        <option value="2">February</option>
                                                                        <option value="3">March</option>
                                                                        <option value="4">April</option>
                                                                        <option value="5">May</option>
                                                                        <option value="6">June</option>
                                                                        <option value="7">July</option>
                                                                        <option value="8">August</option>
                                                                        <option value="9">September</option>
                                                                        <option value="10">October</option>
                                                                        <option value="11">November</option>
                                                                        <option value="12">December</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn-success">Submit</button>
                                                        </form>
                                                        <div class="panel-body">
                                                            <center>
                                                                <h3>Information Technology Services Office</h3>
                                                            </center>
                                                            <center>
                                                                <h3>Repair Report</h3>
                                                            </center>
                                                            <center>
                                                                <h5>For the Month of January</h5>
                                                            </center>
                                                            <h4>Week 1</h4>
                                                            <div class="adv-table">
                                                                <table class="table table-hover general-table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Name</th>
                                                                            <th>No. of Units Received</th>
                                                                            <th>No. of Units Resolved</th>
                                                                            <th>No. of Units Escalated to Supplier</th>
                                                                            <th>No. of Units Escalated to Another Engineer</th>
                                                                            <th>No. of Units Pending</th>
                                                                            <th>No. of Units Released to User</th>
                                                                            <th>No. of Units Beyond Repair Status</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Lao, Marvin Ricci S.</td>
                                                                            <td>1</td>
                                                                            <td>1</td>
                                                                            <td>1</td>
                                                                            <td>1</td>
                                                                            <td>1</td>
                                                                            <td>1</td>
                                                                            <td>1</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>

                                                            </div>

                                                            <h4>Week 2</h4>
                                                            <div class="adv-table">
                                                                <table class="table table-hover general-table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Name</th>
                                                                            <th>No. of Units Received</th>
                                                                            <th>No. of Units Resolved</th>
                                                                            <th>No. of Units Escalated to Supplier</th>
                                                                            <th>No. of Units Escalated to Another Engineer</th>
                                                                            <th>No. of Units Pending</th>
                                                                            <th>No. of Units Released to User</th>
                                                                            <th>No. of Units Beyond Repair Status</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Lao, Marvin Ricci S.</td>
                                                                            <td>1</td>
                                                                            <td>1</td>
                                                                            <td>1</td>
                                                                            <td>1</td>
                                                                            <td>1</td>
                                                                            <td>1</td>
                                                                            <td>1</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </section>
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

    <script>
        function addRowHandlers() {
            var table = document.getElementById("dynamic-table");
            var rows = table.getElementsByTagName("tr");
            for (i = 1; i < rows.length; i++) {
                var currentRow = table.rows[i];
                var createClickHandler = function(row) {
                    return function() {
                        var cell = row.getElementsByTagName("td")[0];
                        var idx = cell.textContent;

                        window.location.href = "it_inventory_specific.php?=";

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