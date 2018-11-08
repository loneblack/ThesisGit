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
                    Welcome Engineer!
                </a>
            </div>

            <div class="nav notify-row" id="top_menu">

            </div>

        </header>
        <!--header end-->
        <?php include 'engineer_navbar.php' ?>

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
                                            View Maintenance
                                        </header>
                                        <div class="panel-body">
                                            <section id="unseen">
                                                <h3>Location Type: Classroom</h3>
                                                <h4>Description: How to bla bla</h4>
                                                <button class="btn btn-primary" onclick="addTest2(5)">Add Asset</button>
                                                <br>
                                                <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                <thead>
                                                    <tr>
                                                        <th>Asset Type</th>
                                                        <th>To Check</th>
                                                        <th>Add</th>
                                                        <th>Remove</th>
                                                    </tr>
                                                </thead>
                                                     <tbody>
                                                          <tr>
                                                        <td>Computer</td>
                                                        <td contenteditable="true">Open Mo Lang tapos tingnan mo pag may nag subscribe</td>
                                                        <td><button class="btn btn-primary" onclick="addTest(4)"> Add </button></td>
                                                        <td><button class="btn btn-danger" onclick="removeRow(this)"> Remove </button></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mouse</td>
                                                        <td contenteditable="true">Check mo Pag gumagalaw pa ung arrow sa screen</td>
                                                        <td><button class="btn btn-primary" onclick="addTest(3)"> Add </button></td>
                                                        <td><button class="btn btn-danger" onclick="removeRow(this)"> Remove </button></td>
                                                    </tr>
                                                </tbody>
                                                </table>
                                                <button class="btn btn-success" onclick="">Save</button>
                                                <button class="btn btn-danger" onclick="location.href='engineer_maintenance.php'">Back</button>
                
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


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>
    <script type="text/javascript">
        function removeRow(o) {
            var p = o.parentNode.parentNode;
            p.parentNode.removeChild(p);
        }


        function addTest(cavasItemID) {
            var row_index = 0;
            var canvasItemID = cavasItemID;
            var isRenderd = false;

            $("td").click(function() {
                row_index = $(this).parent().index();

            });

            var delayInMilliseconds = 0; //1 second

            setTimeout(function() {

                appendTableRow(row_index, canvasItemID);
            }, delayInMilliseconds);


        }

        var appendTableRow = function(rowCount, canvasItemID) {
            var cnt = 0;
            var tr = "<tr>" +
                "<td></td>" +
                "<td contenteditable='true'><input type='text' class='form-control' placeholder='To Check'></td>" +
                "<td></td>" +
                "<td><button class='btn btn-danger' onclick='removeRow(this)'> Remove </button></td>" +
                "</tr>";
            $('#tableTest tbody tr').eq(rowCount).after(tr);
        }



        function addTest2(cavasItemID) {
            var row_index = 1;
            var canvasItemID = cavasItemID;
            var isRenderd = false;

            $("td").click(function() {
                row_index = $(this).parent().index();

            });

            var delayInMilliseconds = 0; //1 second

            setTimeout(function() {

                appendTableRow2(row_index, canvasItemID);
            }, delayInMilliseconds);



        }

        var appendTableRow2 = function(rowCount, canvasItemID) {
            var cnt = 0;
            var tr = "<tr>" +
                "<td><select class='form-control' id='assetType' required>" +
                "<option>Select Asset Type</option>" +
                "</select></td>" +
                "<td contenteditable='true'><input type='text' class='form-control' placeholder='To Check'></td>" +
                "<td><button class='btn btn-primary' onclick='addTest(this)'> Add </button></td>" +
                "<td><button class='btn btn-danger' onclick='removeRow(this)'> Remove </button></td>" +
                "</tr>";
            $('#tableTest tbody tr').eq(rowCount).after(tr);
        }
    </script>
</body>

</html>