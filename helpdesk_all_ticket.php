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
    <link rel="stylesheet" href="js/data-tables/DT_bootstrap.css" />
    <link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />

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
                                    All Ticket
                                    <span class="tools pull-right">
                                        <a href="helpdesk_create_ticket.php" class="fa fa-plus"></a>
                                    </span>
                                </header>
                                <div class="panel-body">
                                    <div class="adv-table" id="ctable">
                                        <table class="display table table-bordered table-striped" id="dynamic-table">
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
											
												<?php
												
													require_once('mysql_connect.php');
													$query="SELECT t.ticketID,t.summary,rst.serviceType,t.lastUpdateDate,t.dueDate,rts.status,t.action FROM thesis.ticket t 
																						join thesis.ref_ticketstatus rts on t.status=rts.ticketID
																						join thesis.ref_servicetype rst on t.serviceType=rst.id";
													$result=mysqli_query($dbc,$query);
												
													while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
														echo "<tr class='gradeA' id='{$row['ticketID']}'>
															<td>{$row['ticketID']}</td>
															<td>{$row['summary']}</td>
															<td>{$row['serviceType']}</td>
															<td>{$row['lastUpdateDate']}</td>
															<td>{$row['dueDate']}</td>";
															
														if($row['action']=='Unanswered'){
															echo "<td><span class='label label-warning'>Unanswered</span></td>";
														}
														elseif($row['action']=='Answered'){
															echo "<td><span class='label label-danger'>Answered</span></td>";
														}	
														else{
															echo "<td><span class='label label-success'>New Ticket</span></td>";
														}

														if($row['status']=='Open'){
															echo "<td><span class='label label-success'>{$row['status']}</span></td>";
														}
														elseif($row['status']=='Closed'){
															echo "<td><span class='label label-danger'>{$row['status']}</span></td>";
														}
														elseif($row['status']=='Assigned'){
															echo "<td><span class='label label-info'>{$row['status']}</span></td>";
														}
														
														elseif($row['status']=='In Progress'||$row['status']=='Waiting for Parts'){
															echo "<td><span class='label label-warning'>{$row['status']}</span></td>";
														}
														elseif($row['status']=='Transferred'){
															echo "<td><span class='label label-primary'>{$row['status']}</span></td>";
														}
														elseif($row['status']=='Escalated'){
															echo "<td><span class='label label-default'>{$row['status']}</span></td>";
														}
														
													}
												
												?>
											
												
											
											
                                                <tr class="gradeA">
                                                    <td>1</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-success">Solved</span></td>
                                                    <td><span class="label label-danger">Closed</span></td>
                                                </tr>

                                                <tr class="gradeA">
                                                    <td>2</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-warning">Un-answered</span></td>
                                                    <td><span class="label label-success">Opened</span></td>
                                                </tr>

                                                <tr class="gradeA">
                                                    <td>3</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-danger">New Ticket</span></td>
                                                    <td><span class="label label-success">Opened</span></td>
                                                </tr>

                                                <tr class="gradeA">
                                                    <td>4</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-success">Solved</span></td>
                                                    <td><span class="label label-danger">Closed</span></td>
                                                </tr>

                                                <tr class="gradeA">
                                                    <td>5</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-warning">Un-answered</span></td>
                                                    <td><span class="label label-success">Opened</span></td>
                                                </tr>

                                                <tr class="gradeA">
                                                    <td>6</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-danger">New Ticket</span></td>
                                                    <td><span class="label label-success">Opened</span></td>
                                                </tr>

                                                <tr class="gradeA">
                                                    <td>7</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-success">Solved</span></td>
                                                    <td><span class="label label-danger">Closed</span></td>
                                                </tr>

                                                <tr class="gradeA">
                                                    <td>8</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-warning">Un-answered</span></td>
                                                    <td><span class="label label-success">Opened</span></td>
                                                </tr>

                                                <tr class="gradeA">
                                                    <td>9</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-danger">New Ticket</span></td>
                                                    <td><span class="label label-success">Opened</span></td>
                                                </tr>

                                                <tr class="gradeA">
                                                    <td>10</td>
                                                    <td>Need Help Here</td>
                                                    <td>Inquiry</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-danger">New Ticket</span></td>
                                                    <td><span class="label label-success">Opened</span></td>
                                                </tr>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th>Category</th>
                                                    <th>Updated</th>
                                                    <th>Date Needed</th>
                                                    <th>Action</th>
                                                    <th class="hidden-phone">Status</th>
                                                </tr>
                                            </tfoot>
                                        </table>
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
    <script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
    <script src="js/dynamic_table_init.js"></script>

    <script>
        $('#ctable').on('click', function() {
			$('.gradeA').on('click', function() {
				var a = this.getAttribute("id");
				window.location.replace("helpdesk_view_ticket.php?ticketID=" + a);
			})
        })
    </script>

    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>