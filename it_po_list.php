<!DOCTYPE html>
<?php
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
                                    Purchase Order List
                                </header>
                                <div class="panel-body">
                                    <section id="unseen">
                                        <table class="table table-bordered table-striped table-condensed table-hover" id="ctable">
                                            <thead>
                                                <tr>
                                                    <th>Purchase Order #</th>
                                                    <th>Supplier</th>
													<th>Nearest Expected Arrival Date</th>
                                                    <th>Status</th>   
                                                </tr>
                                            </thead>
                                            <tbody>
												<?php
													require_once('db/mysql_connect.php');
													$query="SELECT p.procurementID,s.name as `supplierName`,rs.description as `status` FROM thesis.procurement p join ref_status rs on p.status=rs.statusID
																																								 join employee e on p.preparedBy=e.employeeID
																																								 join supplier s on p.supplierID=s.supplierID";
													$result=mysqli_query($dbc,$query);
													
													while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
														
														//GET NEAREST EXPECTED ARRIVAL DATE
														$queryExpArrDat="SELECT expectedDeliveryDate 
																			FROM thesis.procurementdetails 
																			where procurementID='{$row['procurementID']}' and expectedDeliveryDate>=CURDATE() 
																			order by expectedDeliveryDate asc limit 1;";
														$resultExpArrDat=mysqli_query($dbc,$queryExpArrDat);
														$rowExpArrDat=mysqli_fetch_array($resultExpArrDat,MYSQLI_ASSOC);
														
														echo "<tr id='{$row['procurementID']}'>
															<td>{$row['procurementID']}</td>
															<td>{$row['supplierName']}</td>
															<td>{$rowExpArrDat['expectedDeliveryDate']}</td>";
															
														if($row['status']=="Pending"){
															echo "<td><span class='label label-warning label-mini'>{$row['status']}</span></td>";
														}
														elseif($row['status']=="Completed"){
															echo "<td><span class='label label-success label-mini'>{$row['status']}</span></td>";
														}
														else{
															echo "<td><span class='label label-danger label-mini'>{$row['status']}</span></td>";
														}
														
														echo "
														</tr>";
													}
												
												
												
												
												?>
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
	function addRowHandlers() {
		var table = document.getElementById("ctable");
		var rows = table.getElementsByTagName("tr");
		for (i = 1; i < rows.length; i++) {
			var currentRow = table.rows[i];
			var createClickHandler = function(row) {
				return function() {
					var cell = row.getElementsByTagName("td")[2];
					var status = cell.textContent;
					
					//if(status == "Open"){
						//window.location.href = "it_view_open_po.php";
					//}
					
					//if(status == "Closed"){
						//window.location.replace = "it_view_closed_po.php";
					//}
					
					if(status == "Pending"){
						window.location.href = "it_view_open_po.php?procID=" + row.getAttribute("id");
					}
					
					if(status == "Incomplete"){
						window.location.href = "it_view_incomplete_po.php?procID=" + row.getAttribute("id");
					}
					
					if(status == "Completed"){
						window.location.href = "it_view_closed_po.php?procID=" + row.getAttribute("id");
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