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
                        <div class="col-sm-9">
                            <section class="panel">
                                <header class="panel-heading wht-bg">
                                    <h4 class="gen-case"> <a class="btn btn-success">Opened</a>
                                        <a class="btn btn-warning">Un-Assigned</a>
                                    </h4>
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
                                        <p>Hello I would like to repair my shit. Hello I would like to repair my shit. Hello I would like to repair my shit. Hello I would like to repair my shit. Hello I would like to repair my shit. Hello I would like to repair my shit. Hello I would like to repair my shit. Hello I would like to repair my shit. Hello I would like to repair my shit. Hello I would like to repair my shit. Hello I would like to repair my shit. Hello I would like to repair my shit. Hello I would like to repair my shit. Hello I would like to repair my shit. Hello I would like to repair my shit. Hello I would like to repair my shit. Hello I would like to repair my shit. Hello I would like to repair my shit. Hello I would like to repair my shit. Hello I would like to repair my shit. </p>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="col-sm-3">

                            <section class="panel">
                                <div class="panel-body">
                                    <ul class="nav nav-pills nav-stacked labels-info ">
                                        <li>
                                            <h4>Properties</h4>
                                        </li>
                                    </ul>
                                    <div class="form">
                                        <form class="cmxform form-horizontal " id="signupForm" method="post" action="">
                                            <div class="form-group ">
                                                <label for="status" class="control-label col-lg-3">Status</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15">
                                                        <option>New</option>
                                                        <option>Pending</option>
                                                        <option>In Progress</option>
                                                        <option>Solved</option>
                                                        <option>Closed</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group ">
                                                <label for="priority" class="control-label col-lg-3">Priority</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15">
                                                        <option>Low</option>
                                                        <option>Medium</option>
                                                        <option>High</option>
                                                        <option>Urgent</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group ">
                                                <label for="assign" class="control-label col-lg-3">Assigned</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15">
                                                        <option>Admin</option>
                                                        <option>IT Office</option>
                                                        <option>Helpdesk</option>
                                                        <option>Procurement</option>
                                                        <option>Engineer</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <button class="btn btn-success">Update</button>
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
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>

    <script>
        $('#ctable').on('dblclick', function() {
            window.location.replace("helpdesk_view_ticket.php");
        })
    </script>

    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>