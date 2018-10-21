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
                    Welcome IT Officer!
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
                    <div class="row">
                        <div class="col-sm-12">
                            <section class="panel">
                                <header class="panel-heading">
                                    Request
                                </header>
                                <div class="panel-body">
                                    <section id="unseen">
                                        <div class="row invoice-to">
                                            <div class="col-md-4 col-sm-4 pull-left">
                                                <h4>Status:</h4>
                                                <h2>Canvas Completed</h2>
                                            </div>
                                            <div class="col-md-4 col-sm-5 pull-right">
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-5 inv-label">Request #</div>
                                                    <div class="col-md-8 col-sm-7">221</div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-5 inv-label">Date Needed </div>
                                                    <div class="col-md-8 col-sm-7">21 December 2018</div>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                        <h5>*** Please Check the Checkbox for Procurement to Buy</h5>
                                        <table class="table table-invoice" id="mytable">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th class="text-center" style="width:84px">Quantity</th>
                                                    <th class="text-center">Category</th>
                                                    <th class="text-center">Brand</th>
                                                    <th class="text-center">Model</th>
                                                    <th class="text-center">Specification</th>
                                                    <th>Supplier</th>
                                                    <th>Price</th>
                                                    <th>Comments</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input type="checkbox"></td>
                                                    <td class="text-center">3</td>
                                                    <td class="text-center">Laptop</td>
                                                    <td class="text-center">Acer</td>
                                                    <td class="text-center">Aspire E14</td>
                                                    <td>CDR-King</td>
                                                    <td class="text-center">4 GB RAM, 1 TB Hard Drive, Some Processor, Some graphics card</td>
                                                    <td>P 1,300.00</td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="col-lg-12">
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox"></td>
                                                    <td class="text-center">3</td>
                                                    <td class="text-center">Laptop</td>
                                                    <td class="text-center">Acer</td>
                                                    <td class="text-center">Aspire E14</td>
                                                    <td>CDR-King</td>
                                                    <td class="text-center">4 GB RAM, 1 TB Hard Drive, Some Processor, Some graphics card</td>
                                                    <td>P 1,300.00</td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="col-lg-12">
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox"></td>
                                                    <td class="text-center">3</td>
                                                    <td class="text-center">Laptop</td>
                                                    <td class="text-center">Acer</td>
                                                    <td class="text-center">Aspire E14</td>
                                                    <td>CDR-King</td>
                                                    <td class="text-center">4 GB RAM, 1 TB Hard Drive, Some Processor, Some graphics card</td>
                                                    <td>P 1,300.00</td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="col-lg-12">
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="submit" class="btn btn-success">Submit</button>
                                        <a href="it_requests.php"><button class="btn btn-danger">Back</button></a>
                                    </section>
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

    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>
    <script>
        $(":input").bind('keyup change click', function(e) {

            if ($(this).val() < 0) {
                $(this).val('')
            }

        });
    </script>
</body>

</html>