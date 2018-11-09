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
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datepicker/css/datepicker.css" />

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
                    Welcome Helpdesk!
                </a>
            </div>

            <div class="nav notify-row" id="top_menu">

            </div>

        </header>
        <!--header end-->
        <?php include 'helpdesk_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">

                            <section class="panel">
                                <header class="panel-heading">
                                    Donation Request
                                </header>
                                <div style="padding-top:10px; padding-left:10px; float:left">
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Create Ticket</button>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="myModal" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Create a Ticket</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form">
                                                    <form class="cmxform form-horizontal " id="signupForm" method="post" action="">
                                                        <div class="form-group ">
                                                            <div class="form-group ">
                                                                <label for="category" class="control-label col-lg-3">Category</label>
                                                                <div class="col-lg-6">
                                                                    <select class="form-control m-bot15" name="category" value="" required>

                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <label for="status" class="control-label col-lg-3">Status</label>
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-bot15" name="status" value="" required>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group ">
                                                            <label for="priority" class="control-label col-lg-3">Priority</label>
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-bot15" name="priority" value="" required>
                                                                    <option value='Low'>Low</option>
                                                                    <option value='Medium'>Medium</option>
                                                                    <option value='High'>High</option>
                                                                    <option value='Urgent'>Urgent</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group ">
                                                            <label for="assign" class="control-label col-lg-3">Assigned</label>
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-bot15" name="assigned" value="" required>


                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">Due Date</label>
                                                            <div class="col-lg-6">
                                                                <!-- class="form-control form-control-inline input-medium default-date-picker" -->
                                                                <input class="form-control m-bot15" size="10" name="dueDate" type="datetime-local" value="" required />
                                                            </div>
                                                        </div>

                                                        <button type="submit" class="btn btn-success" name="submit">Update</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--                                MODAL END-->

                                <div class="panel-body">
                                    <br>
                                    <br>
                                    <h5 style="float:right"><button class="btn btn-default">For Testing</button></h5>
                                    <h5><b>Office/ Department/ School Organization: Gaylord Academy</b></h5>
                                    <h5><b>Contact Number: 09178328851</b></h5>
                                    <h5><b>Date Time Needed: 12/23/2018 12:00:00AM</b></h5>
                                    <h5><b>Purpose: To serve our gay community</b></h5>

                                    <div>

                                        <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                            <thead>
                                                <tr>
                                                    <th>Category</th>
                                                    <th>Quantity</th>
                                                    <th>Brand</th>
                                                    <th>Model</th>
                                                    <th>Property Code</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Computer</td>
                                                    <td>3</td>
                                                    <td>
                                                        <select class="form-control" disabled>
                                                            <option>Select Brand</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" disabled>
                                                            <option>Select Model</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" disabled>
                                                            <option>Select Property Code</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <select class="form-control" disabled>
                                                            <option>Select Brand</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" disabled>
                                                            <option>Select Model</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" disabled>
                                                            <option>Select Property Code</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <select class="form-control" disabled>
                                                            <option>Select Brand</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" disabled>
                                                            <option>Select Model</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" disabled>
                                                            <option>Select Property Code</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                        <br>
                                        <button class="btn btn-success">Submit</button>
                                        <button class="btn btn-danger" onClick="location.href='helpdesk_all_ticket.php'">Back</button>
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
        function checkvalue(val) {
            if (val === "25")
                document.getElementById('others').style.display = 'block';
            else
                document.getElementById('others').style.display = 'none';
        }
    </script>

    <!-- WAG GALAWIN PLS LANG -->

    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script src="js/jquery-ui-1.9.2.custom.min.js"></script>

    <script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>


    <script src="js/scripts.js"></script>
    <script src="js/advanced-form.js"></script>

</body>

</html>