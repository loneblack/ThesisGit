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
                                        View Testing
                                    </header>
                                    <div class="panel-body">
                                        <div class="text-center invoice-btn">
                                            <button class="btn btn-success">Send</button>
                                        </div>
                                        <section id="unseen">
                                            <div class="row invoice-to">
                                                <div class="col-md-4 col-sm-4 pull-left">
                                                    <h4>Status:</h4>
                                                    <h2>Completed</h2>
                                                </div>
                                                <div class="col-md-4 col-sm-5 pull-right">
                                                    <div class="row">
                                                        <div class="col-md-4 col-sm-5 inv-label">Testing #</div>
                                                        <div class="col-md-8 col-sm-7">233426</div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-4 col-sm-5 inv-label">Date Updated </div>
                                                        <div class="col-md-8 col-sm-7">21 December 2018</div>
                                                    </div>
                                                    <br>


                                                </div>
                                            </div>
                                        
                                        <table class="table table-invoice">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Item Description</th>
                                                    <th class="text-center">Quantity</th>
                                                    <th class="text-center">Comments</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <h4>Windows 10</h4>
                                                        <p>Product Key is 11111111</p>
                                                    </td>
                                                    <td class="text-center">1</td>
                                                    <td class="text-center"></td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>
                                                        <h4>MAC LAPTOP</h4>
                                                        <p>Green Laptop with 4Gb Ram</p>
                                                    </td>
                                                    <td class="text-center">2</td>
                                                    <td class="text-center"></td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>
                                                        <h4>VGA</h4>
                                                        <p>Blue ang ulo</p>
                                                    </td>
                                                    <td class="text-center">1</td>
                                                    <td class="text-center"></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </section>
                                </div>
                            </section>
                        </div>

						<button class="btn btn-info" onclick="window.history.back();" id="back">Back</button>
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

    <script>
        $('#ctable').on('dblclick', function() {
            window.location.href = "it_view_testing.php";
        })
    </script>
    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>