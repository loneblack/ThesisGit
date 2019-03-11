<?php
	require_once('db/mysql_connect.php');
	
	$totalNotifs=0;
	
	//GET NUMBER OF NEW NOTIFICATIONS OF PURCHASE REQUESTS
	$queryNumNotif="SELECT Count(*) as `numOfNotif` FROM thesis.notifications where isRead='0' and Delivery_id is not null";
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
                            <a href="helpdesk_dashboard.php">
                                <i class="fa fa-dashboard"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        
                        
                        <li class="sub-menu">
                            <a href="helpdesk_all_ticket.php">
                                <i class="fa fa-ticket"></i>
                                <span>Tickets</span>
                            </a>
                        </li>
                        
                        <li class="sub-menu">
                            <a href="helpdesk_all_request.php">
                                <i class="fa fa-question"></i>
                                <span>Requests ';
								if($totalNotifs>'0'){
									echo '<span class="badge badge-light">'.$totalNotifs.'</span>';
								}
								echo '</span>
                            </a>
                        </li>
                        
                        <li class="sub-menu">
                            <a href="helpdesk_maintenance.php">
                                <i class="fa fa-wrench"></i>
                                <span>Maintenance Teams</span>
                            </a>
                        </li>
                        
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-dropbox"></i>
                                <span>Asset</span>
                            </a>
                            <ul class="sub">
                                <li><a href="helpdesk_inventory.php">Inventory</a></li>
                                <li><a href="helpdesk_bulk_checkin.php">Checkin</a></li>
                                <li><a href="helpdesk_bulk_checkout.php">Checkout</a></li>
                            </ul>
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