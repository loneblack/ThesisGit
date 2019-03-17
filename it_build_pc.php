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


                        <section class="panel">
                            <header class="panel-heading">
                                Build A Desktop or Thin Client
                            </header>
                            <div class="panel-body">
                                <div class="position-center">
                                    <form class="form-horizontal" role="form" method="POST" action="">

                                        <div class="form-group">
                                            <label class="col-lg-2 col-sm-2 control-label">Asset Category</label>
                                            <div class="col-lg-10">
                                                <select class="form-control m-bot15">
                                                    <option name="assetCat" id="assetCat">Select Asset Category</option>
                                                    <option value="13">Desktop</option>
                                                    <option value="46">Thin Client</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="btn-group">
                                            <button class="btn btn-primary" onclick="addTest(5)"> Add </button>
                                        </div>

                                        <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                            <thead>
                                                <tr>
                                                    <th>Property Code</th>
                                                    <th>Asset Category</th>
                                                    <th>Brand</th>
                                                    <th>Model</th>
                                                    <th>Specifications</th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td>Monitor</td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td></td>
                                                    <td>Keyboard</td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td></td>
                                                    <td>Mouse</td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td></td>
                                                    <td>RAM</td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td></td>
                                                    <td>HDD</td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td></td>
                                                    <td>Graphics Card</td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td></td>
                                                    <td>Processor</td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td></td>
                                                    <td>Motherboard</td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td></td>
                                                    <td>Power Supply</td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td><input type="text" class="form-control" readonly></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>



                                        <div class="clearfix">
                                            <div class="btn-group">
                                                <button class="btn btn-success">
                                                    <i class="fa fa-check"></i> Submit
                                                </button>
                                            </div>
                                            <div class="btn-group">
                                                <button class="btn btn-danger" onClick="window.location.href = 'it_all_compound_assets.php'">
                                                    Back
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </section>



                    </div>
                </div>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>

    <!-- WAG GALAWIN PLS LANG -->

    <!--Core js-->
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>

    <script type="text/javascript" src="js/data-tables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>

    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

    <!--script for this page only-->
    <script src="js/table-editable.js"></script>

    <!-- END JAVASCRIPTS -->
    <script>
        jQuery(document).ready(function() {
            EditableTable.init();
        });
    </script>

    <script type="text/javascript">
        // Shorthand for $( document ).ready()
        $(function() {

        });




        function addTest() {
            var row_index = 0;
            var isRenderd = false;

            $("td").click(function() {
                row_index = $(this).parent().index();

            });

            var delayInMilliseconds = 300; //1 second

            setTimeout(function() {

                appendTableRow(row_index);
            }, delayInMilliseconds);



        }

        var appendTableRow = function(rowCount) {
            var cnt = 0
            var tr = "<tr>" +
                "<td><input type='number' class='form-control' min='0.00' required></td>" +
                "<td>" +
                "<select class='form-control' id='exampleFormControlSelect1' required>" +
                " <option>Select Brand</option>" +
                "<option>Samsung</option>" +
                "<option>Huawei" +
                "<option>LG</option>" +
                "</select>" +
                "</td>" +
                "<td>" +
                "<select class='form-control' id='exampleFormControlSelect1' required>" +
                " <option>Select Model</option>" +
                "<option>S9</option>" +
                "<option>Iphone X" +
                "<option>Nova 2</option>" +
                "</select>" +
                "</td>" +
                "<td><button class='btn btn-danger' onclick='deleteTest(this)'> Delete </button></td>" +
                "</tr>";
            $('#tableTest tbody tr').eq(rowCount).after(tr);
        }

        function deleteTest(r) {
            var i = r.parentNode.parentNode.rowIndex;
            document.getElementById("tableTest").deleteRow(i);
        }
    </script>

</body>

</html>