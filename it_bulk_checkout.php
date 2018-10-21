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

    <link rel="stylesheet" href="css/bootstrap-switch.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-timepicker/compiled/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datetimepicker/css/datetimepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery-multi-select/css/multi-select.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery-tags-input/jquery.tagsinput.css" />

    <link rel="stylesheet" type="text/css" href="js/select2/select2.css" />

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
                    <div class="col-sm-12">
                        <div class="col-sm-12">


                            <section class="panel">
                                <header class="panel-heading">
                                    Bulk Checkout Asset
                                </header>
                                <div class="panel-body">
                                    <div class="position-center">
                                        <form class="form-horizontal" role="form">

                                            <div class="form-group">
                                                <label for="brand" class="col-lg-2 col-sm-2 control-label">Checkout To</label>
                                                <ul class="nav nav-stacked nav-justified">
                                                    <li class="active"><a href="#User" data-toggle="tab">User</a></li>
                                                    <li><a href="#Location" data-toggle="tab">Location</a></li>
                                                </ul>

                                                <div class="tab-content">
                                                    <div class="tab-pane fade in active" id="User">
                                                        <label for="model" class="col-lg-2 col-sm-2 control-label"></label>
                                                        <div class="col-lg-5">
                                                            <select class="form-control m-bot15">
                                                                <option>Select User</option>
                                                                <option>Marvin Lao</option>
                                                                <option>Pimentel Boi</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade" id="Location">
                                                        <label for="model" class="col-lg-2 col-sm-2 control-label"></label>
                                                        <div class="col-lg-5 m-bot15">
                                                            <select class="form-control">
                                                                <option>Select Location</option>
                                                                <option>Andrew</option>
                                                                <option>Goks</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <label class="control-label col-lg-2 col-sm-2">Checkout Date</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control form-control-inline input-medium default-date-picker" size="10" type="text" value="" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-2 col-sm-2">Expected Checkin Date</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control form-control-inline input-medium default-date-picker" size="10" type="text" value="" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label">Notes</label>
                                                <div class="col-lg-10">
                                                    <textarea class="form-control" rows="5" id="notes" placeholder="Notes"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label">Select Asset</label>
                                                <div class="col-lg-6">
                                                    <select multiple name="e9" id="e9" style="width:300px" class="populate">
                                                        <optgroup label="Individual Assets">
                                                            <option value="AK">(123456) - Dell VGA Adapter</option>
                                                            <option value="HI">(324234) - Apple HMDI</option>
                                                        </optgroup>
                                                        <optgroup label="Combined Assets">
                                                            <option value="CA">(123324) - ROG Gaming Series</option>
                                                            <option value="NV">(543232) - Nevada</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">
                                                    <button type="submit" class="btn btn-success">Checkout</button>
                                                    <button type="submit" class="btn btn-danger">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
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

    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script src="js/jquery-ui-1.9.2.custom.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/easypiechart/jquery.easypiechart.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>

    <script src="js/bootstrap-switch.js"></script>

    <script type="text/javascript" src="js/fuelux/js/spinner.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-fileupload/bootstrap-fileupload.js"></script>
    <script type="text/javascript" src="js/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
    <script type="text/javascript" src="js/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
    <script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="js/bootstrap-daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript" src="js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
    <script type="text/javascript" src="js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
    <script type="text/javascript" src="js/jquery-multi-select/js/jquery.multi-select.js"></script>
    <script type="text/javascript" src="js/jquery-multi-select/js/jquery.quicksearch.js"></script>

    <script type="text/javascript" src="js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>

    <script src="js/jquery-tags-input/jquery.tagsinput.js"></script>

    <script src="js/select2/select2.js"></script>
    <script src="js/select-init.js"></script>


    <script src="js/scripts.js"></script>

    <script src="js/toggle-init.js"></script>

    <script src="js/advanced-form.js"></script>

</body>

</html>