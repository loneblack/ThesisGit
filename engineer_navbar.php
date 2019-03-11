<?php
	require_once('db/mysql_connect.php');
	
	$totalNotifs=0;
	
	//GET NUMBER OF NEW NOTIFICATIONS OF TICKETS
	$queryNumNotif="SELECT Count(*) as `numOfNotif` FROM thesis.notifications n join ticket t on n.ticketID=t.ticketID where n.isRead='0' and n.ticketID is not null and t.assigneeUserID='{$_SESSION['userID']}'";
	$resultNumNotif=mysqli_query($dbc,$queryNumNotif);
	$rowNumNotif=mysqli_fetch_array($resultNumNotif,MYSQLI_ASSOC);
	
	$totalNotifs=$rowNumNotif['numOfNotif'];
?>

<?php  echo '<aside>
            <div id="sidebar" class="nav-collapse">
                <!-- sidebar menu start-->
                <div class="leftside-navigation">
                    <ul class="sidebar-menu" id="nav-accordion">
                        <li>
                            <a href="engineer_dashboard.php">
                                <i class="fa fa-dashboard"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="engineer_all_ticket.php">
                                <i class="fa fa-envelope-o"></i>
                                <span>Tickets ';
								if($rowNumNotif['numOfNotif']>'0'){
									echo '<span class="badge badge-light">'.$rowNumNotif['numOfNotif'].'</span>';
								}
								echo '</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="engineer_maintenance.php">
                                <i class="fa fa-cogs"></i>
                                <span>Maintenance</span>
                            </a>
                        </li>
                        
                        
                        <li>
                            <a href="logout.php">
                                <i class="glyphicon glyphicon-log-out"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- sidebar menu end-->
            </div>
        </aside>' ?>