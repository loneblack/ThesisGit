<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$userID = $_SESSION['userID'];
require_once("db/mysql_connect.php");

$query1="SELECT COUNT(*) as 'count' FROM thesis.ticket t JOIN ref_ticketstatus s ON t.status = s.ticketID WHERE t.status != 7;";
$result1=mysqli_query($dbc,$query1);
while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)){ $Unresolved = $row1['count']; }

$query2="SELECT COUNT(*) as 'count' FROM thesis.ticket t JOIN ref_ticketstatus s ON t.status = s.ticketID WHERE (t.dueDate < now());";
$result2=mysqli_query($dbc,$query2);
while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){ $Overdue = $row2['count']; }   

$query3="SELECT COUNT(*) as 'count' FROM thesis.ticket t JOIN ref_ticketstatus s ON t.status = s.ticketID WHERE (DATE(t.dueDate) = DATE(now()));";
$result3=mysqli_query($dbc,$query3);
while ($row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC)){ $DueToday = $row3['count']; }   

$query4="SELECT COUNT(*) as 'count' FROM thesis.ticket t JOIN ref_ticketstatus s ON t.status = s.ticketID WHERE t.status = 1;";
$result4=mysqli_query($dbc,$query4);
while ($row4 = mysqli_fetch_array($result4, MYSQLI_ASSOC)){ $Open = $row4['count']; }   

$query5="SELECT COUNT(*) as 'count' FROM thesis.ticket t JOIN ref_ticketstatus s ON t.status = s.ticketID WHERE t.status = 6;";
$result5=mysqli_query($dbc,$query5);
while ($row5 = mysqli_fetch_array($result5, MYSQLI_ASSOC)){ $OnHold = $row5['count']; }   

$query6="SELECT COUNT(*) as 'count' FROM thesis.ticket t JOIN ref_ticketstatus s ON t.status = s.ticketID WHERE t.priority = 'Urgent';";
$result6=mysqli_query($dbc,$query6);
while ($row6 = mysqli_fetch_array($result6, MYSQLI_ASSOC)){ $Urgent = $row6['count']; }                           

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
        <?php include 'helpdesk_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">


                            <div class="row">
                                <a href="#">
                                    <div class="col-md-2">
                                        <div class="mini-stat clearfix">
                                            <span class="mini-stat-icon orange"><i class="fa fa-gavel"></i></span>
                                            <div class="mini-stat-info"><br>
                                                <span><?php echo $Unresolved;?></span>
                                                Unresolved
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="#">
                                    <div class="col-md-2">
                                        <div class="mini-stat clearfix">
                                            <span class="mini-stat-icon orange"><i class="fa fa-clock-o"></i></span>
                                            <div class="mini-stat-info">
                                                <span><?php echo $Overdue;?></span>
                                                Overdue
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="#">
                                    <div class="col-md-2">
                                        <div class="mini-stat clearfix">
                                            <span class="mini-stat-icon pink"><i class="fa fa-clock-o"></i></span>
                                            <div class="mini-stat-info">
                                                <span><?php echo $DueToday;?></span>
                                                Due Today
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="#">
                                    <div class="col-md-2">
                                        <div class="mini-stat clearfix">
                                            <span class="mini-stat-icon green"><i class="fa fa-eye"></i></span>
                                            <div class="mini-stat-info">
                                                <span><?php echo $Open;?></span>
                                                Open
                                            </div>
                                        </div>
                                    </div>
                                </a>


                                <a href="#">
                                    <div class="col-md-2">
                                        <div class="mini-stat clearfix">
                                            <span class="mini-stat-icon orange"><i class="fa fa-times-circle-o"></i></span>
                                            <div class="mini-stat-info">
                                                <span><?php echo $OnHold;?></span>
                                                On Hold
                                            </div>
                                        </div>
                                    </div>
                                </a>


                                <a href="#">
                                    <div class="col-md-2">
                                        <div class="mini-stat clearfix">
                                            <span class="mini-stat-icon orange"><i class="fa fa-exclamation"></i></span>
                                            <div class="mini-stat-info">
                                                <span><?php echo $Urgent;?></span>
                                                Urgent
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>








                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">

                            <section class="panel">
                                <header class="panel-heading">
                                    Recent Tickets
                                </header>
                                <div class="panel-body">
                                    <section id="unseen">
                                        <table class="table table-bordered table-striped table-condensed table-hover" id="dynamic-table">
                                            <thead>
                                                <tr>
                                                    <td style='display: none'>ticketID</td>
                                                    <th>#</th>
                                                    <td style='display: none'>ServiceTypeID</td>
                                                    <th>Category</th>
                                                    <th>Updated</th>
                                                    <th>Date Needed</th>
                                                    <th>Status</th>
                                                    <th>Requested By</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                                <?php
                                                    $count = 1;
                                                
                                                    require_once('db/mysql_connect.php');
                                                    $query="SELECT t.ticketID,t.summary, rst.id,rst.serviceType,t.lastUpdateDate,t.dueDate, dateCreated,rts.status 
                                                            FROM thesis.ticket t 
                                                            JOIN thesis.ref_ticketstatus rts ON t.status=rts.ticketID
                                                            JOIN thesis.ref_servicetype rst ON t.serviceType=rst.id
                                                            ORDER BY dateCreated LIMIT 10;";
                                                    $result=mysqli_query($dbc,$query);
                                                
                                                    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                                                        echo "<tr class='gradeA' id='{$row['ticketID']}'>
                                                            <td style='display: none'>{$row['ticketID']}</td>
                                                            <td>{$row['ticketID']}</td>
                                                            <td>{$row['serviceType']}</td>
                                                            <td style='display: none'>{$row['id']}</td>
                                                            <td>{$row['lastUpdateDate']}</td>
                                                            <td>{$row['dueDate']}</td>";

                                                        if($row['status']=='Open'){
                                                            echo "<td><span class='label label-success'>{$row['status']}</span></td>";
                                                        }
                                                        elseif($row['status']=='Closed'){
                                                            echo "<td><span class='label label-danger'>{$row['status']}</span></td>";
                                                        }
                                                        elseif($row['status']=='Assigned'){
                                                            echo "<td><span class='label label-info'>{$row['status']}</span></td>";
                                                        }
                                                        
                                                        elseif($row['status']=='In Progress'||$row['status']=='Waiting for Parts'){
                                                            echo "<td><span class='label label-warning'>{$row['status']}</span></td>";
                                                        }
                                                        elseif($row['status']=='Transferred'){
                                                            echo "<td><span class='label label-primary'>{$row['status']}</span></td>";
                                                        }
                                                        elseif($row['status']=='Escalated'){
                                                            echo "<td><span class='label label-default'>{$row['status']}</span></td>";
                                                        }
														 echo "<td></td></tr>";
                                                        $count++;
                                                        
                                                    }
                                                
                                                ?>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style='display: none'>ticketID</td>
                                                    <th>#</th>
                                                    <td style='display: none'>ServiceTypeID</td>
                                                    <th>Category</th>
                                                    <th>Updated</th>
                                                    <th>Date Needed</th>
                                                    <th class="hidden-phone">Status</th>
                                                    <th>Requested By</th>
                                                </tr>
                                            </tfoot>
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

                        var cell3 = row.getElementsByTagName("td")[7];
                        var status = cell3.textContent;

                                            
                        if(serviceTypeID == '25'){
                            //asset testing
                            if(status == "Closed"){
                                window.location.href ="helpdesk_view_ticket_assettesting_closed.php?id=" + id;
                            }
                                
                            else{
                                window.location.href = "helpdesk_view_ticket_assettesting_opened.php?id=" + id;
                            }
                        }
                        
                        else if(serviceTypeID == '26'){
                            //refurbishing
                            if(status == "Closed"){
                                window.location.href = "helpdesk_view_ticket_refurbishing_closed.php?id=" + id;
                            }

                            else{
                                window.location.href = "helpdesk_view_ticket_refurbishing_opened.php?id=" + id;
                            }
                            
                        }
                        
                        else if(serviceTypeID == '27'){//dpone
                            //repair
                            if(status == "Closed"){
                                window.location.href = "helpdesk_view_ticket_repair_closed.php?id=" + id;
                            }
                            else{
                                window.location.href = "helpdesk_view_ticket_repair_opened.php?id=" + id;
                            }
                        }
                        else if(serviceTypeID == '28'){
                            //maintenance
                            if(status == "Closed"){
                                window.location.href = "helpdesk_view_ticket_maintenance_closed.php?id=" + id;
                            }
                            else{
                                window.location.href = "helpdesk_view_ticket_maintenance_opened.php?id=" + id;
                            }
                        }
                         else if(serviceTypeID == '29'){
                            //others
                            if(status == "Closed"){
                                window.location.href = "helpdesk_view_ticket_others_closed.php?id=" + id;
                            }
                            else{
                                window.location.href = "helpdesk_view_ticket_others_opened.php?id=" + id;
                            }
                        }
                         else{
                            //service
                            if(status == "Closed"){
                                window.location.href = "helpdesk_view_ticket_service_closed.php?id=" + id;
                            }
                            else{
                                window.location.href = "helpdesk_view_ticket_service_opened.php?id=" + id;
                            }
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