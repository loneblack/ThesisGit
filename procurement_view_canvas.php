<!DOCTYPE html>
<!--Notes
1. Add
INSERT INTO `thesis`.`ref_status` (`statusID`, `description`) VALUES ('7', 'Re-check Canvas');
INSERT INTO `thesis`.`ref_status` (`statusID`, `description`) VALUES ('8', 'Ready for PO');
INSERT INTO `thesis`.`ref_status` (`statusID`, `description`) VALUES ('9', 'For Canvas');

 -->
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
        <?php include 'procurement_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        Canvas List
                                    </header>
                                    <div class="panel-body">
                                        <section id="unseen">
                                            <div class="adv-table">
                                            <table class="table table-bordered table-striped table-condensed table-hover " id="ctable">
                                                <thead>
                                                    <tr>
                                                        <th>Date Needed</th>
                                                        <th>Status</th>
                                                        <th>Description</th>
                                                        <th >Requestor</th>
                                                        <th>Requested Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><a href="procurement_view_request.php">12/23/2018</a></td>
                                                        <td><span class="label label-success label-mini">Completed</span></td>
                                                        <td>We Need 500 more laptops PLSSS!!</td>
                                                        <td>Marvin Lao</td>
                                                        <td>1/1/2018</td>
                                                    </tr>
                                                    <tr>
                                                        <td><a href="procurement_view_request.php">12/23/2018</a></td>
                                                        <td><span class="label label-danger label-mini">Re-check Canvas</span></td>
                                                        <td>We Need 500 more laptops PLSSS!!</td>
                                                        <td>Marvin Lao</td>
                                                        <td>1/1/2018</td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td><a href="procurement_view_request.php">12/23/2018</a></td>
                                                        <td><span class="label label-primary label-mini">Ready for PO</span></td>
                                                        <td>We Need 500 more laptops PLSSS!!</td>
                                                        <td>Marvin Lao</td>
                                                        <td>1/1/2018</td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td><a href="procurement_view_request.php">12/23/2018</a></td>
                                                        <td><span class="label label-warning label-mini">For Canvas</span></td>
                                                        <td>We Need 500 more laptops PLSSS!!</td>
                                                        <td>Marvin Lao</td>
                                                        <td>1/1/2018</td>
                                                    </tr>
                                                    
													<?php
													
														require_once('db/mysql_connect.php');
														$query="SELECT c.canvasID,r.dateNeeded,rs.description as `status`,r.description,r.recipient,r.date as `requestedDate` FROM thesis.canvas c 
																   join ref_status rs on c.status=rs.statusID
                                                                   join request r on c.requestID=r.requestID";
														$result=mysqli_query($dbc,$query);
														
														while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
															echo "<tr id='{$row['canvasID']}'>
																<td>{$row['dateNeeded']}</td>";
																
															//if($row['status']=='Completed'){
																//echo "<td><span class='label label-success label-mini'>{$row['status']}</span></td>";
															//}
															//elseif($row['status']=='Re-check Canvas'){
																//echo "<td><span class='label label-danger label-mini'>{$row['status']}</span></td>";
															//}
															//elseif($row['status']=='For Canvas'){
																//echo "<td><span class='label label-warning label-mini'>{$row['status']}</span></td>";
															//}
															//else{
																//echo "<td><span class='label label-primary label-mini'>{$row['status']}</span></td>";
															//}
															
															if($row['status']=='Completed'){
																echo "<td><span class='label label-success label-mini'>{$row['status']}</span></td>";
															}
															elseif($row['status']=='Incomplete'){
																echo "<td><span class='label label-danger label-mini'>{$row['status']}</span></td>";
															}
															elseif($row['status']=='Pending'){
																echo "<td><span class='label label-warning label-mini'>{$row['status']}</span></td>";
															}
															else{
																echo "<td><span class='label label-primary label-mini'>{$row['status']}</span></td>";
															}
															
																
															echo "<td>{$row['description']}</td>
																<td>{$row['recipient']}</td>
																<td>{$row['requestedDate']}</td>
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
						
						//if(id == "Ready for PO"){
							//window.location.replace("procurement_purchase_order.php?canvasID="+ row.getAttribute("id"));
						//}
                        //else if(id == "For Canvas"){
                            //window.location.replace("procurement_view_request.php?canvasID="+ row.getAttribute("id"));
                        //}
						//else if(id == "Completed"){
                           // window.location.replace("procurement_view_completed.php?canvasID="+ row.getAttribute("id"));
                        //}
						
						if(id == "Ready for PO"){
							window.location.replace("procurement_purchase_order.php?canvasID="+ row.getAttribute("id"));
						}
                        else if(id == "Pending"){
                            window.location.replace("procurement_view_request.php?canvasID="+ row.getAttribute("id"));
                        }
						else if(id == "Completed"){
                            window.location.replace("procurement_view_completed.php?canvasID="+ row.getAttribute("id"));
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