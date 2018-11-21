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
        <?php include 'requestor_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="col-sm-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Request List
                            </header>
                            <div class="panel-body">
                                <section id="unseen">
                                    <table class="table table-bordered table-striped table-condensed table-hover" id="ctable">
                                        <thead>
                                            <tr>
                                                <th>Title of Request</th>
                                                <th>Status</th>
                                                <th>Date Needed</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Need More PC</td>
                                                <td><span class="badge bg-important">Disapproved</span></td>
                                                <td>12/23/1997</td>
                                            </tr>
                                        </tbody>
                                        
                                        <tbody>
                                            <tr>
                                                <td>Need More PC</td>
                                                <td><span class="badge bg-success">Approved</span></td>
                                                <td>1/3/2018</td>
                                            </tr>
                                        </tbody>
                                        
                                        
                                        <tbody>
                                            <tr>
                                                <td>Need More PC</td>
                                                <td><span class="badge bg-warning">Pending</span></td>
                                                <td>1/3/2018</td>
                                            </tr>
                                        </tbody>
                                        
                                        
                                    </table>
                                </section>
                            </div>
                        </section>
                    </div>
                </div>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>
	
	<script>
		function addRowHandlers() {
			var table = document.getElementById("ctable");
			var rows = table.getElementsByTagName("tr");
			for (i = 1; i < rows.length; i++) {
				var currentRow = table.rows[i];
				var createClickHandler = function(row) {
					return function() {
						var cell = row.getElementsByTagName("td")[1];
						var id = cell.textContent;
						
						if(id == "Approved"){
							window.location.href = "requestor_view_approved_request.php";
						}
						
						if(id == "Pending"){
							window.location.href = "requestor_view_pending_request.php";
						}
						
						if(id == "Disapproved"){
							window.location.href = "requestor_view_disapproved_request.php";
						}
					};
				};
				currentRow.onclick = createClickHandler(currentRow);
			}
		}
		window.onload = addRowHandlers();
	</script>

    <!-- WAG BAGUHIN ANG BABA PLS LANG -->

    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>