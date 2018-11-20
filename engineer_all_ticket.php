<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$userID = $_SESSION['userID'];
require_once("db/mysql_connect.php");
?>

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
                                                    <th>Priority</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                 <?php
                                                    $count = 1;

                                                    $query = "SELECT t.ticketID, (convert(aes_decrypt(au.firstName, 'Fusion') using utf8)) AS 'firstName' ,(convert(aes_decrypt(au.lastName, 'Fusion')using utf8)) AS 'lastName', lastUpdateDate, dateCreated, dateClosed, dueDate, priority,summary,
                                                             t.description, t.serviceType as 'serviceTypeID', st.serviceType,t.status as 'statusID', s.status
                                                            FROM thesis.ticket t
                                                            JOIN user au
                                                                ON t.assigneeUserID = au.UserID
                                                            JOIN ref_ticketstatus s
                                                                ON t.status = s.ticketID
                                                            JOIN ref_servicetype st
                                                                ON t.serviceType = st.id
                                                            WHERE au.UserID = {$userID};";
                                                                  
                                                    $result = mysqli_query($dbc, $query);
                                                    
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                      
                                                      echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$row['ticketID']}</td>
                                                            <td>{$count}</td>
                                                            <td>{$row['summary']}</td>
                                                            <td style='display: none'>{$row['serviceTypeID']}</td>
                                                            <td>{$row['serviceType']}</td>
                                                            <td>{$row['lastUpdateDate']}</td>
                                                            <td>{$row['dueDate']}</td>";

                                                        if($row['priority'] == "High" || $row['priority'] == "Urgent"){
                                                            echo "<td><span class='label label-danger'>{$row['priority']}</span></td>";
                                                        }
                                                        if($row['priority'] == "Medium"){
                                                            echo "<td><span class='label label-warning'>{$row['priority']}</span></td>";
                                                        }
                                                        if($row['priority'] == "Low"){
                                                            echo "<td><span class='label label-success'>{$row['priority']}</span></td>";
                                                        }
														

                                                        if($row['statusID'] == "1"){
                                                            echo "<td><span class='label label-success'>{$row['status']}</span></td>";
                                                        }
                                                        if($row['statusID'] == "2"){
                                                            echo "<td><span class='label label-default'>{$row['status']}</span></td>";
                                                        }
                                                        if($row['statusID'] == "3"){
                                                            echo "<td><span class='label label-primary'>{$row['status']}</span></td>";
                                                        }
                                                        if($row['statusID'] == "4" || $row['statusID'] == "5"){
                                                            echo "<td><span class='label label-info'>{$row['status']}</span></td>";
                                                        }
                                                        if($row['statusID'] == "6"){
                                                            echo "<td><span class='label label-warning'>{$row['status']}</span></td>";
                                                        }
                                                        if($row['statusID'] == "7"){
                                                            echo "<td><span class='label label-danger'>{$row['status']}</span></td>";
                                                        }
                                                    
                                                        echo "</tr>";

                                                          $count++;
                                                    }
                                                  ?>
                                        
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
						var cell1 = row.getElementsByTagName("td")[0];
						var id = cell1.textContent;

                        var cell2 = row.getElementsByTagName("td")[3];
                        var serviceTypeID = cell2.textContent;

                        var cell3 = row.getElementsByTagName("td")[8];
                        var status = cell2.textContent;
											
						if(serviceTypeID == '25'){
                            //asset testing
							if(status == "Closed"){
								window.location.replace("engineer_view_ticket_assettesting_closed.php?id=" + id);
							}
								
							else{
								window.location.replace("engineer_view_ticket_assettesting_opened.php?id=" + id);
							}
						}
						
						else if(serviceTypeID == '26'){
                            //refurbishing
							if(status == "Closed"){
								window.location.replace("engineer_view_ticket_refurbishing_closed.php?id=" + id);
							}

                            else{
                                window.location.replace("engineer_view_ticket_refurbishing_opened.php?id=" + id);
                            }
                            
						}
                        
                        else if(serviceTypeID == '27'){
                            //repair
                            if(status == "Closed"){
                                window.location.replace("engineer_view_ticket_repair_closed.php?id=" + id);
                            }
                            else{
								window.location.replace("engineer_view_ticket_repair_opened.php?id=" + id);
							}
						}
                        else if(serviceTypeID == '28'){
                            //maintenance
                            if(status == "Closed"){
                                window.location.replace("engineer_view_ticket_maintenance_closed.php?id=" + id);
                            }
                            else{
                                window.location.replace("engineer_view_ticket_maintenance_opened.php?id=" + id);
                            }
                        }
                         else if(serviceTypeID == '29'){
                            //others
                            if(status == "Closed"){
                                window.location.replace("engineer_view_ticket_others_closed.php?id=" + id);
                            }
                            else{
                                window.location.replace("engineer_view_ticket_others_opened.php?id=" + id);
                            }
                        }
                         else{
                            //service
                            if(status == "Closed"){
                                window.location.replace("engineer_view_ticket_service_closed.php?id=" + id);
                            }
                            else{
                                window.location.replace("engineer_view_ticket_service_opened.php?id=" + id);
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