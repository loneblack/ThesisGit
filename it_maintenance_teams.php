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
                                    Maintenance Team List
                                </header>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="panel">
                                            <div class="panel-body">
                                                <button class="btn btn-success" type="submit">Save</button>
                                                <div class="adv-table">
                                                    <table class="display table table-bordered table-striped" id="dynamic-table">
                                                        <thead>
                                                            <tr>
                                                                <th style="display: none">id</th>
                                                                <th>Building</th>
                                                                <th>Engineer 1</th>
                                                                <th>Engineer 2</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Gokongwei</td>
                                                                <td>
                                                                    <select class="form-control">
                                                                        <option>Select Engineer</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control">
                                                                        <option>Select Engineer</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </section>
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

    <script>
        function addRowHandlers() {
            var table = document.getElementById("dynamic-table");
            var rows = table.getElementsByTagName("tr");
            for (i = 1; i < rows.length; i++) {
                var currentRow = table.rows[i];
                var createClickHandler = function(row) {
                    return function() {
                        var cell = row.getElementsByTagName("td")[0];
                        var ida = cell.textContent; //id
                        var cell = row.getElementsByTagName("td")[3];
                        var id = cell.textContent; //Status
                        var cell = row.getElementsByTagName("td")[4];
                        var idx = cell.textContent; //Request type
                        var cell = row.getElementsByTagName("td")[5];
                        var idDesc = cell.textContent; //Description

                        if (idx == "Repair") {
                            if (id == "Completed" || id == "Incomplete") {
                                window.location.href ="it_view_completed_incomplete_repair.php?requestID=" + ida;
                            }
                            if (id == "Ongoing" || id == "Pending") {
                                window.location.href = "it_view_ongoing_pending_repair.php?requestID=" + ida;
                            }
                        }
                        if (idx == "Asset Request") {
                            if (id == "Ongoing" || id == "Pending") {
                                if (idDesc == "Checking Canvas") {
                                    window.location.href = "it_view_canvas_completed.php?requestID=" + ida;
                                } else if (idDesc == "IT Create Specs") {
                                    window.location.href = "it_view_incomplete_request.php?requestID=" + ida;
                                } else if (idDesc == "Replacement needed") {
                                    window.location.href = "it_view_open_po.php?requestID=" + ida;
                                } else if (idDesc == "Conforme pending") {
                                    window.location.href = "it_view_checklist.php";
                                }
                            }
                            if (id == "Completed" || id == "Incomplete") {
                                window.location.href = "it_view_checklist.php";
                            }
                        }
                        if (idx == "Testing") {
                            if (id == "Ongoing" || id == "Pending") {
                                window.location.href = "it_view_incomplete_testing.php";
                            } else if (id == "Completed" || id == "Incomplete") {
                                window.location.href = "it_view_testing.php";
                            }
                        }
                        if (idx == "Donation") {
                            if (id == "Ongoing" || id == "Pending") {
                                window.location.href = "it_view_open_donation_request.php?id=" + ida;
                            }
                            if (id == "Completed" || id == "Incomplete") {
                                window.location.href = "it_view_closed_donation_request.php?id=" + ida;
                            }
                        }
                        if (idx == "Borrow") {
                            if (id == "Ongoing" || id == "Pending") {
                                window.location.href = "it_view_open_service_equipment_request.php?id=" + ida;
                            } else if (id == "Completed" || id == "Incomplete") {
                                window.location.href = "it_view_closed_service_equipment_request.php?id=" + ida;
                            }
                        }
                    };
                };
                currentRow.onclick = createClickHandler(currentRow);
            }
        }
        window.onload = addRowHandlers();
    </script>

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



    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>