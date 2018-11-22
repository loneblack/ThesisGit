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
        <?php include 'director_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="col-sm-12">

                        <div class="row">
                            <div class="col-sm-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        Request List
                                    </header>
                                    <div class="panel-body">
                                        <div class="adv-table" id="ctable">
                                            <table class="display table table-bordered table-striped" id="dynamic-table">
                                                <thead>
                                                    <tr>
                                                        <th>Title of Request</th>
                                                        <th id = "sortme">Status</th>
                                                        <th>Requestor</th>
                                                        <th class="hidden-phone">Date Needed</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
													
													<?php
														$key = "Fusion";
														require_once('db/mysql_connect.php');
														$query="SELECT r.requestID as `requestID`,r.description as `reqDesc`,rs.description as `statusDesc`,CONCAT(Convert(AES_DECRYPT(firstName,'{$key}')USING utf8), ' ', Convert(AES_DECRYPT(lastName,'{$key}')USING utf8)) as `requestor`, r.dateNeeded as `dateNeeded` FROM thesis.request r 
																		join thesis.ref_status rs on r.status=rs.statusID
																		join thesis.user u on r.UserID=u.UserID ";
														$result=mysqli_query($dbc,$query);
														while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
															
															echo "<tr class='gradeA' id='{$row['requestID']}' >
																	<td>{$row['reqDesc']}</td>";
									
																if($row['statusDesc']=='Disapproved'){
																	echo "<td><span class='badge bg-important'>{$row['statusDesc']}</span></td>";
																}
																elseif($row['statusDesc']=='Pending'){
																	echo "<td><span class='badge bg-warning'>{$row['statusDesc']}</span></td>";
																}
																else{
																	
																	echo "<td><span class='badge bg-success'>Approved</span></td>";
																}
															
															echo"
																<td>{$row['requestor']}</td>
																<td>{$row['dateNeeded']}</td>
																</tr>";
													}
													
													
													
													
													?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Title of Request</th>
                                                        <th>Status</th>
                                                        <th>Requestor</th>
                                                        <th class="hidden-phone">Date Needed</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>

    <!-- WAG BAGUHIN ANG BABA PLS LANG -->

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
				window.location.href = "director_view_request.php?requestid=" + a;
			})
        })	

        $(window).load(function(){


        document.getElementById("sortme").click();
        document.getElementById("sortme").click();

        });

    </script>
    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>