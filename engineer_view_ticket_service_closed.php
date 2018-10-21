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
                        <div class="col-sm-8">
                            <section class="panel">
                                <header style="padding-bottom:20px"class="panel-heading wht-bg">
                                    <h4 class="gen-case" style="float:right"> <a class="btn btn-danger">Closed</a></h4>
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
                                        <p>HI would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. </p>
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
                                    <div class="form">
                                        <form class="cmxform form-horizontal " id="signupForm" method="post" action="">
                                            <div class="form-group ">
                                                <div class="form-group ">
                                                <label for="category" class="control-label col-lg-3">Category</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15" disabled>
                                                        <option selected="selected">Request</option>
                                                        <option>Repair</option>
                                                        <option>Maintenance</option>
                                                        <option>Replacement</option>
                                                    </select>
                                                </div>
                                            </div>
                                                
                                                <label for="status" class="control-label col-lg-3">Status</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15" disabled>
                                                        <option>New</option>
                                                        <option>Pending</option>
                                                        <option>In Progress</option>
                                                        <option selected="selected">Solved</option>
                                                        <option>Closed</option>
                                                    </select>
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

                                            <div class="form-group">
                                                <label class="control-label col-lg-3">Due Date</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control form-control-inline input-medium default-date-picker" size="10" type="text" value="10-13-2018" disabled/>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </section>
                        </div>
		
						<div class="col-sm-12">
                            <section class="panel">
                                <div class="panel-body ">

                                    <div>
                                        <h4>Comments (if needed)</h4>
                                    </div>
                                    <div class="view-mail">
										<textarea class="form-control" style="resize:none" rows="5" readonly>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque blandit diam eget massa fringilla pellentesque ac non ante. Etiam imperdiet euismod maximus. Aenean auctor, ipsum at pellentesque varius, nunc diam volutpat purus, quis dictum mauris lacus ut nunc. Quisque turpis justo, vehicula sit amet tempor eu, fringilla sit amet nisl. Ut vel est nunc. Phasellus nec feugiat arcu. Aliquam lobortis posuere elit. Sed facilisis dui a felis finibus congue. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Etiam tincidunt metus felis, eget finibus sapien porta ut.</textarea>
                                    </div>
                                </div>
                            </section>
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