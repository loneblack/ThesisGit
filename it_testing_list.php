<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');




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
                            <section class="panel">
                                <header class="panel-heading">
                                    Testing List
                                </header>
                                <div class="panel-body">
                                    <section id="unseen">
                                        <div class="adv-table">
                                            <table class="table table-bordered table-striped table-condensed table-hover " id="ctable">
                                            <thead>
                                                <tr>
                                                    <th>Testing #</th>
                                                    <th>Status</th>
                                                    <th>Description</th>
                                                    <th>Tested By</th>
                                                    <th>Date Finished</th>
                                                </tr>
                                            </thead>
												<tbody>
												<?php
													$query = "SELECT at.remarks,at.testingID,at.endTestDate,rs.description as `status`,e.name FROM thesis.assettesting at join ref_status rs on at.statusID=rs.statusID
																																						  join ticket t on at.testingID=t.testingID
																																						  join user u on t.assigneeUserID=u.UserID
																																						  join employee e on u.UserID=e.UserID";         
                                                    $result = mysqli_query($dbc, $query);
													while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
														echo "<tr id='{$row['testingID']}'>
															<td>{$row['testingID']}</td>";
															
															if($row['status']=="Completed"){
																echo "<td><span class='label label-success label-mini'>{$row['status']}</span></td>";
															}
															elseif($row['status']=="Incomplete"){
																echo "<td><span class='label label-danger label-mini'>{$row['status']}</span></td>";
															}
															elseif($row['status']=="Finished"){
																echo "<td><span class='label label-primary label-mini'>{$row['status']}</span></td>";	
															}
															else{
																echo "<td><span class='label label-warning label-mini'>{$row['status']}</span></td>";
															}
															
															echo "<td>{$row['remarks']}</td>
															<td>{$row['name']}</td>
															<td>{$row['endTestDate']}</td>
														</tr>";
													}
												
												
												
												
												
												
												
												?>
                                                
                                            </tbody>
                                        </table>
                                        </div>
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
        function addRowHandlers() {
			var table = document.getElementById("ctable");
			var rows = table.getElementsByTagName("tr");
			for (i = 1; i < rows.length; i++) {
				var currentRow = table.rows[i];
				var createClickHandler = function(row) {
					return function() {
						var cell = row.getElementsByTagName("td")[1];
						var id = cell.textContent;
						
						if(id == "Finished"){
							window.location.href = "it_view_testing.php?testingID=" + row.getAttribute("id");
						}
						if(id == "Completed"){
							window.location.href = "it_view_testing_completed.php?testingID=" + row.getAttribute("id");
						}
					};
				};
				currentRow.onclick = createClickHandler(currentRow);
			}
		}
		window.onload = addRowHandlers();
    </script>
    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>