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
                    <img src="images/dlsulogo.png" alt="" width="200px" height="40px">
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
                        <div class="col-sm-8">
                            <section class="panel">
                                <header style="padding-bottom:20px" class="panel-heading wht-bg">
                                    <h4 class="gen-case" style="float:right"> <a class="btn btn-success">Open</a></h4>
                                    <h4>Service Request</h3>
                                </header>
                                <div class="panel-body ">

                                    <div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <img src="images/chat-avatar2.jpg" alt="">
                                                <strong>IT Office</strong>
                                                to
                                                <strong>me</strong>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="date"> 10:15AM 02 FEB 2018</p><br><br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="view-mail">
                                        <p>Please do maintenance on buildings Gokongwei and Andrew Rooms G403 and A1709 </p>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="col-sm-4">

                            <section class="panel">
                                <div class="panel-body">
                                    <ul class="nav nav-pills nav-stacked labels-info ">
                                        <li>
                                            <h4>Properties</h4>
                                        </li>
                                    </ul>
                                    <div class="form" style="float:right">
                                        <form class="cmxform form-horizontal " id="signupForm" method="post" action="">
                                            <div class="form-group ">
                                                <div class="form-group ">
                                                    <label for="category" class="control-label col-lg-3">Category</label>
                                                    <div class="col-lg-6">
                                                        <select class="form-control m-bot15" disabled>
                                                            <option>Request</option>
                                                            <option>Repair</option>
                                                            <option selected="selected">Maintenance</option>
                                                            <option>Replacement</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="priority" class="control-label col-lg-3">Priority</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15" disabled>
                                                        <option>Low</option>
                                                        <option>Medium</option>
                                                        <option selected="selected">High</option>
                                                        <option>Urgent</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="assign" class="control-label col-lg-3">Assigned</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15" disabled>
                                                        <option selected="selected">Eng. Marvin Lao</option>
                                                        <option>Eng. Marvin Lao</option>
                                                        <option>Eng. Marvin Lao</option>
                                                        <option>Eng. Marvin Lao</option>
                                                        <option>Eng. Marvin Lao</option>
                                                        <option>Eng. Marvin Lao</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="assign" class="control-label col-lg-3">Status</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15">
                                                        <option selected="selected">Opened</option>
                                                        <option>Closed</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-3">Due Date</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control form-control-inline input-medium default-date-picker" size="10" type="text" value="10-13-2018" disabled />
                                                </div>
                                            </div>

                                        </form>
                                    </div>

                                </div>
                            </section>
                        </div>
                        
                        <section class="panel">
                                <header style="padding-bottom:20px" class="panel-heading wht-bg">
                                    <h4>Assets</h4>
                                </header>
                                <div class="panel-body ">

                                    <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                        <thead>
                                            <tr>
                                                <th>Category</th>
                                                <th>Property Code</th>
                                                <th>Location</th>
                                                <th>To Check</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Computer</td>
                                                <td>PAJDN12344</td>
                                                <td>G403</td>
                                                <td contenteditable="false">Open Mo Lang tapos tingnan mo pag may nag subscribe</td>
                                                <td><input type="text" class="form-control" placeholder="Remarks"></td>
                                            </tr>
                                            
                                            <tr>
                                                <td>Projector</td>
                                                <td>PAJDN696969</td>
                                                <td>A1709</td>
                                                <td contenteditable="false">Open Mo Lang tapos tingnan mo pag may nag subscribe</td>
                                                <td><input type="text" class="form-control" placeholder="Remarks"></td>
                                            </tr>
                                        </tbody>
                                    </table>



                                </div>
                            </section>

                        
                        
                        <div class="col-sm-12">
                            <a href=""><button class="btn btn-success">Submit</button></a>
                            <a href="engineer_all_ticket.php"><button class="btn btn-danger">Back</button></a>
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

    <script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>


    <script src="js/scripts.js"></script>
    <script src="js/advanced-form.js"></script>

</body>

</html>