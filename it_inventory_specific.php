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
                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="panel">
                                        <header class="panel-heading">
                                            PANGALAN NG NACLICK NA ASSET

                                        </header>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <section class="panel">
                                                        <div class="panel-body">
                                                            <div class="adv-table">
                                                                <table class="display table table-bordered table-striped" id="dynamic-table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Property Code</th>
                                                                            <th>Brand</th>
                                                                            <th>Model</th>
                                                                            <th>Status</th>
                                                                            <th>Last Updated</th>
                                                                            <th>Location</th>
                                                                            <th>Borrower</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>99994447327</td>
                                                                            <td>Samsung</td>
                                                                            <td>S7 Edge</td>
                                                                            <td>Checked Out</td>
                                                                            <td>12-23-2018 9:00:00 AM</td>
                                                                            <td>Gokongwei 403B</td>
                                                                            <td>Marvin Lao</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>12445447327</td>
                                                                            <td>Samsung</td>
                                                                            <td>S7 Edge</td>
                                                                            <td>In Repair</td>
                                                                            <td>12-23-2018 9:00:00 AM</td>
                                                                            <td>Default</td>
                                                                            <td></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>39382707327</td>
                                                                            <td>Huawei</td>
                                                                            <td>Flare S2</td>
                                                                            <td>Checked Out</td>
                                                                            <td>12-23-2018 9:00:00 AM</td>
                                                                            <td>Gokongwei 403B</td>
                                                                            <td>Marvin Lao</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>12394447327</td>
                                                                            <td>Dell</td>
                                                                            <td>RTX-1480</td>
                                                                            <td>Stocked</td>
                                                                            <td>12-23-2018 9:00:00 AM</td>
                                                                            <td>Default</td>
                                                                            <td></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </section>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
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
						var cell = row.getElementsByTagName("td")[0];
						var idx = cell.textContent;
						
                        window.location.replace("it_asset_audit.php?=");
						
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