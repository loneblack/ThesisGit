<!DOCTYPE html>
<?php
	require_once('db/mysql_connect.php');
	session_start();
	$key = "Fusion";
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

    <?php
            $count = 1;
            $query = "SELECT e.name AS `naame` FROM employee e WHERE e.UserID = {$_SESSION['userID']};";
            $result = mysqli_query($dbc, $query);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $name = $row['naame'];
        ?>

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
                <h4>Welcome!
                    <?php echo $name; ?>
                </h4>
            </div>

        </header>
        <!--header end-->
        <?php include 'procurement_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <section class="panel">
                    <header class="panel-heading">
                        Recent Canvas
                    </header>
                    <div class="panel-body">
                        <section id="unseen">
                            <div class="adv-table" id="ctable">
                                <table class="display table table-bordered table-striped" id="dynamic-table">
                                    <thead>
                                        <tr>
                                            <th>Date Needed</th>
                                            <th>Status</th>
                                            <th>Description</th>
                                            <th>Requestor</th>
                                            <th>Requested Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
													
														
														$query="SELECT c.canvasID,r.dateNeeded,rs.description as `status`,r.description,r.recipient,r.date as `requestedDate`,rstp.name as `step`,Convert(AES_DECRYPT(firstName,'".$key."')USING utf8) as 'firstname',Convert(AES_DECRYPT(lastName,'".$key."')USING utf8) as 'lastname' FROM thesis.canvas c 
																   join ref_status rs on c.status=rs.statusID
                                                                   join request r on c.requestID=r.requestID
																   join ref_steps rstp on r.step=rstp.id
																   join user u on r.UserID=u.UserID LIMIT 10";
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
															
															if($row['status']=='Incomplete'){
																echo "<td><span class='label label-danger label-mini'>{$row['status']}</span></td>";
															}
															elseif($row['step']=='Canvasing'){
																echo "<td><span class='label label-warning label-mini'>Canvasing</span></td>";
															}
															elseif($row['step']=='Create Purchase Order'){
																echo "<td><span class='label label-primary label-mini'>Create Purchase Order</span></td>";
															}
															elseif($row['step']=='Re-Canvas'){
																echo "<td><span class='label label-danger label-mini'>Re-Canvas</span></td>";
															}
															else{
																echo "<td><span class='label label-success label-mini'>Completed</span></td>";
															}	
															
															
																
															echo "<td>{$row['description']}</td>
																<td>".$row['firstname']." ".$row['lastname']."</td>
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

                <div class="row">
                    <div class="col-sm-12">
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
        history.pushState(null, null, location.href);
        window.onpopstate = function() {
            history.go(1);
        };
    </script>

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

                        if (id == "Create Purchase Order") {
                            window.location.href = "procurement_purchase_order.php?canvasID=" + row.getAttribute("id");
                        } else if (id == "Canvasing") {
                            window.location.href = "procurement_view_request.php?canvasID=" + row.getAttribute("id");
                        } else if (id == "Completed") {
                            window.location.href = "procurement_view_completed.php?canvasID=" + row.getAttribute("id");
                        } else if (id == "Re-Canvas") {
                            window.location.href = "procurement_recheck_canvas.php?canvasID=" + row.getAttribute("id");
                        }

                        if (id == "Ready for PO") {
                            window.location.href = "procurement_purchase_order.php?canvasID=" + row.getAttribute("id");
                        } else if (id == "Pending") {
                            window.location.href = "procurement_view_request.php?canvasID=" + row.getAttribute("id");
                        } else if (id == "Completed") {
                            window.location.href = "procurement_view_completed.php?canvasID=" + row.getAttribute("id");
                        }
                    };
                };
                currentRow.onclick = createClickHandler(currentRow);
            }
        }
        window.onload = addRowHandlers();
    </script>

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