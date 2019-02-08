<!DOCTYPE html>
<?php 
	session_start();
	require_once('db/mysql_connect.php');
	$_SESSION['forReplenish']=array();
	if(isset($_POST['replenish'])){
		
		if(!empty($_POST['forReplenish'])){
			foreach($_POST['forReplenish'] as $forReplenish){
				array_push($_SESSION['forReplenish'],$forReplenish);
			}
			header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/it_replenish.php");
			
		}
	}

?>
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
                                            Stock List

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
                                                                                <th>Specifications</th>
                                                                                <th>Category</th>
                                                                                <th>Status</th>
                                                                                <th>Checked Out To</th>
                                                                                <th>Location</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
																            <tr>
                                                                                <td>PC-0001</td>
                                                                                <td>Dell</td>
                                                                                <td>AMT 20202</td>
                                                                                <td>GPU 8700</td>
                                                                                <td>Desktop</td>
                                                                                <td>On-Hand</td>
                                                                                <td></td>
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
                        window.location.href = ".php?id=" + idx;

                    };
                };
                currentRow.ondblclick = createClickHandler(currentRow);
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