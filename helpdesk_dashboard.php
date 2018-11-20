<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$userID = $_SESSION['userID'];
require_once("db/mysql_connect.php");

$query1="SELECT COUNT(*) as 'count' FROM thesis.ticket t JOIN ref_ticketstatus s ON t.status = s.ticketID WHERE t.status != 7;";
$result1=mysqli_query($dbc,$query1);
while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)){ $Unresolved = $row1['count']; }

$query2="SELECT COUNT(*) as 'count' FROM thesis.ticket t JOIN ref_ticketstatus s ON t.status = s.ticketID WHERE (t.dueDate < now());";
$result2=mysqli_query($dbc,$query2);
while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){ $Overdue = $row2['count']; }   

$query3="SELECT COUNT(*) as 'count' FROM thesis.ticket t JOIN ref_ticketstatus s ON t.status = s.ticketID WHERE (DATE(t.dueDate) = DATE(now()));";
$result3=mysqli_query($dbc,$query3);
while ($row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC)){ $DueToday = $row3['count']; }   

$query4="SELECT COUNT(*) as 'count' FROM thesis.ticket t JOIN ref_ticketstatus s ON t.status = s.ticketID WHERE t.status = 1;";
$result4=mysqli_query($dbc,$query4);
while ($row4 = mysqli_fetch_array($result4, MYSQLI_ASSOC)){ $Open = $row4['count']; }   

$query5="SELECT COUNT(*) as 'count' FROM thesis.ticket t JOIN ref_ticketstatus s ON t.status = s.ticketID WHERE t.status = 6;";
$result5=mysqli_query($dbc,$query5);
while ($row5 = mysqli_fetch_array($result5, MYSQLI_ASSOC)){ $OnHold = $row5['count']; }   

$query6="SELECT COUNT(*) as 'count' FROM thesis.ticket t JOIN ref_ticketstatus s ON t.status = s.ticketID WHERE t.priority = 'Urgent';";
$result6=mysqli_query($dbc,$query6);
while ($row6 = mysqli_fetch_array($result6, MYSQLI_ASSOC)){ $Urgent = $row6['count']; }                           

?>
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
        <?php include 'helpdesk_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">


                            <div class="row">
                                <a href="#">
                                    <div class="col-md-2">
                                        <div class="mini-stat clearfix">
                                            <span class="mini-stat-icon orange"><i class="fa fa-gavel"></i></span>
                                            <div class="mini-stat-info"><br>
                                                <span><?php echo $Unresolved;?></span>
                                                Unresolved
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="#">
                                    <div class="col-md-2">
                                        <div class="mini-stat clearfix">
                                            <span class="mini-stat-icon orange"><i class="fa fa-clock-o"></i></span>
                                            <div class="mini-stat-info">
                                                <span><?php echo $Overdue;?></span>
                                                Overdue
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="#">
                                    <div class="col-md-2">
                                        <div class="mini-stat clearfix">
                                            <span class="mini-stat-icon pink"><i class="fa fa-clock-o"></i></span>
                                            <div class="mini-stat-info">
                                                <span><?php echo $DueToday;?></span>
                                                Due Today
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="#">
                                    <div class="col-md-2">
                                        <div class="mini-stat clearfix">
                                            <span class="mini-stat-icon green"><i class="fa fa-eye"></i></span>
                                            <div class="mini-stat-info">
                                                <span><?php echo $Open;?></span>
                                                Open
                                            </div>
                                        </div>
                                    </div>
                                </a>


                                <a href="#">
                                    <div class="col-md-2">
                                        <div class="mini-stat clearfix">
                                            <span class="mini-stat-icon orange"><i class="fa fa-times-circle-o"></i></span>
                                            <div class="mini-stat-info">
                                                <span><?php echo $OnHold;?></span>
                                                On Hold
                                            </div>
                                        </div>
                                    </div>
                                </a>


                                <a href="#">
                                    <div class="col-md-2">
                                        <div class="mini-stat clearfix">
                                            <span class="mini-stat-icon orange"><i class="fa fa-exclamation"></i></span>
                                            <div class="mini-stat-info">
                                                <span><?php echo $Urgent;?></span>
                                                Urgent
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>








                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">

                            <section class="panel">
                                <header class="panel-heading">
                                    Recent Tickets
                                </header>
                                <div class="panel-body">
                                    <section id="unseen">
                                        <table class="table table-bordered table-striped table-condensed table-hover" id="ctable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th>Category</th>
                                                    <th>Updated</th>
                                                    <th>Date Needed</th>
                                                    <th>Action</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-success">Solved</span></td>
                                                    <td><span class="label label-danger">Closed</span></td>
                                                </tr>

                                                <tr>
                                                    <td>2</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-warning">Un-answered</span></td>
                                                    <td><span class="label label-success">Opened</span></td>
                                                </tr>

                                                <tr>
                                                    <td>3</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-danger">New Ticket</span></td>
                                                    <td><span class="label label-success">Opened</span></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>4</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-success">Solved</span></td>
                                                    <td><span class="label label-danger">Closed</span></td>
                                                </tr>

                                                <tr>
                                                    <td>5</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-warning">Un-answered</span></td>
                                                    <td><span class="label label-success">Opened</span></td>
                                                </tr>

                                                <tr>
                                                    <td>6</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-danger">New Ticket</span></td>
                                                    <td><span class="label label-success">Opened</span></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>7</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-success">Solved</span></td>
                                                    <td><span class="label label-danger">Closed</span></td>
                                                </tr>

                                                <tr>
                                                    <td>8</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-warning">Un-answered</span></td>
                                                    <td><span class="label label-success">Opened</span></td>
                                                </tr>

                                                <tr>
                                                    <td>9</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-danger">New Ticket</span></td>
                                                    <td><span class="label label-success">Opened</span></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>10</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-danger">New Ticket</span></td>
                                                    <td><span class="label label-success">Opened</span></td>
                                                </tr>

                                            </tbody>
                                        </table>
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

    <script>
        $('#ctable').on('dblclick', function() {
            window.location.replace("helpdesk_view_ticket.php");
        })
    </script>

    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>