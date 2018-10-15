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
                    Welcome Procurement!
                </a>
            </div>

            <div class="nav notify-row" id="top_menu">

            </div>

        </header>
        <!--header end-->
        <?php include 'procurement_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->


                <div class="row">
                    <div class="col-sm-12">

                        <div class="row">
                            <div class="col-sm-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        Start Canvas
                                    </header>
                                    <div class="panel-body">
                                        <section id="unseen">
                                            <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                <thead>
                                                    <tr>
                                                        <th>Quantity</th>
                                                        <th>Item</th>
                                                        <th>Specification</th>
                                                        <th>Supplier</th>
                                                        <th>Unit Price in Php</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="width:50px;">5</td>
                                                        <td>MAC Laptop</td>
                                                        <td>IPAD</td>
                                                        <td>
                                                            <select class="form-control" id="exampleFormControlSelect1" required>
                                                                <option>Select Supplier</option>
                                                                <option>ABC Corp.</option>
                                                                <option>Philippine Sports Commission</option>
                                                                <option>CDR-King</option>
                                                                <option>Huawei</option>
                                                                <option>Samsung</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="number" class="form-control" min="0.00" required></td>
                                                        <td><button class="btn btn-primary" onclick="addTest(4)"> Add </button></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:50px;">5</td>
                                                        <td>Windows</td>
                                                        <td>Windows 10</td>
                                                        <td>
                                                            <select class="form-control" id="exampleFormControlSelect1" required>
                                                                <option>Select Supplier</option>
                                                                <option>ABC Corp.</option>
                                                                <option>Philippine Sports Commission</option>
                                                                <option>CDR-King</option>
                                                                <option>Huawei</option>
                                                                <option>Samsung</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="number" class="form-control" min="0.00" required></td>
                                                        <td><button class="btn btn-primary" onclick="addTest(3)"> Add </button></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:50px;">5</td>
                                                        <td>Desktop</td>
                                                        <td>MAC PC</td>
                                                        <td>
                                                            <select class="form-control" id="exampleFormControlSelect1" required>
                                                                <option>Select Supplier</option>
                                                                <option>ABC Corp.</option>
                                                                <option>Philippine Sports Commission</option>
                                                                <option>CDR-King</option>
                                                                <option>Huawei</option>
                                                                <option>Samsung</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="number" class="form-control" min="0.00" required></td>
                                                        <td><button class="btn btn-primary" onclick="addTest(2)"> Add </button></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:50px;">5</td>
                                                        <td>Projector</td>
                                                        <td>Epson 101</td>
                                                        <td>
                                                            <select class="form-control" id="exampleFormControlSelect1" required>
                                                                <option>Select Supplier</option>
                                                                <option>ABC Corp.</option>
                                                                <option>Philippine Sports Commission</option>
                                                                <option>CDR-King</option>
                                                                <option>Huawei</option>
                                                                <option>Samsung</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="number" class="form-control" min="0.00" required></td>
                                                        <td><button class="btn btn-primary" onclick="addTest(1)"> Add </button></td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <div>
                                                <button type="button" class="btn btn-success" data-dismiss="modal">Send</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                            </div>

                                        </section>
                                    </div>
                                </section>
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


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

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
                "<td style='width:50px;'></td>" +
                "<td></td>" +
                "<td></td>" +
                "<td>" +
                "<select class='form-control' id='exampleFormControlSelect1' required>" +
                " <option>Select Supplier</option>" +
                "<option>ABC Corp.</option>" +
                "<option>Philippine Sports Commission</option>" +
                "<option>CDR-King</option>" +
                "<option>Huawei</option>" +
                "<option>Samsung</option>" +
                "</select>" +
                "</td>" +
                "<td><input type='number' class='form-control' min='0.00' required></td>" +
                "</tr>";
            $('#tableTest tbody tr').eq(rowCount).after(tr);
        }
    </script>


</body>

</html>