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


                            <section class="panel">
                                <header class="panel-heading">
                                    All Tickets
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
                                                <tr class="gradeA">
                                                    <td>1</td>
                                                    <td>Need Help Here</td>
                                                    <td>Service</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-success">Solved</span></td>
                                                    <td><span class="label label-danger">Closed</span></td>
                                                </tr>

                                                <tr class="gradeA">
                                                    <td>2</td>
                                                    <td>Need Help Here</td>
                                                    <td>Service</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-warning">Un-answered</span></td>
                                                    <td><span class="label label-success">Opened</span></td>
                                                </tr>

                                                <tr class="gradeA">
                                                    <td>3</td>
                                                    <td>Need Help Here</td>
                                                    <td>Repair</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-danger">New Ticket</span></td>
                                                    <td><span class="label label-success">Opened</span></td>
                                                </tr>

                                                <tr class="gradeA">
                                                    <td>4</td>
                                                    <td>Need Help Here</td>
                                                    <td>Asset Testing</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-success">Solved</span></td>
                                                    <td><span class="label label-danger">Closed</span></td>
                                                </tr>

                                                <tr class="gradeA">
                                                    <td>5</td>
                                                    <td>Need Help Here</td>
                                                    <td>Asset Testing</td>
                                                    <td>10/9/18</td>
                                                    <td>10/9/18</td>
                                                    <td><span class="label label-warning">Un-answered</span></td>
                                                    <td><span class="label label-success">Opened</span></td>
                                                </tr>
                                                
                                                <tr class="gradeA">
                                                    <td>5</td>
                                                    <td>Need Help Here</td>
                                                    <td>Repair</td>
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
	
	<script>
		function addRowHandlers() {
			var table = document.getElementById("dynamic-table");
			var rows = table.getElementsByTagName("tr");
			for (i = 1; i < rows.length; i++) {
				var currentRow = table.rows[i];
				var createClickHandler = function(row) {
					return function() {
						var cell = row.getElementsByTagName("td")[6];
						var id = cell.textContent;
						var cell = row.getElementsByTagName("td")[2];
						var idx = cell.textContent;
						alert(idx +" - " + id);
						
						
						if(idx == "Service"){
							if(id == "Closed"){
								window.location.replace("engineer_view_ticket_service_closed.php");
							}
								
							if(id == "Opened"){
								window.location.replace("engineer_view_ticket_service_opened.php");
							}
						}
						
						if(idx == "Asset Testing"){
							if(id == "Opened"){
								window.location.replace("engineer_view_ticket_assettesting_opened.php");
							}
							
							if(id == "Closed"){
								window.location.replace("engineer_view_ticket_assettesting_closed.php");
							}
						}
                        
                        if(idx == "Repair"){
                            if(id == "Opened"){
								window.location.replace("engineer_view_ticket_repair_opened.php");
							}
							
							if(id == "Closed"){
								window.location.replace("engineer_view_ticket_repair_closed.php");
							}
						}
						
					};
				};
				currentRow.onclick = createClickHandler(currentRow);
			}
		}
		window.onload = addRowHandlers();
	</script>

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

  

    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>