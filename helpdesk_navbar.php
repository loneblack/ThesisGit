<?php
	require_once('db/mysql_connect.php');
	
	$totalNotifs=0;
	
	//GET NUMBER OF NEW NOTIFICATIONS OF PURCHASE REQUESTS
	$queryNumNotif="SELECT Count(*) as `numOfNotif` FROM thesis.notifications where isRead='0' and Delivery_id is not null";
	$resultNumNotif=mysqli_query($dbc,$queryNumNotif);
	$rowNumNotif=mysqli_fetch_array($resultNumNotif,MYSQLI_ASSOC);
	
	//GET NUMBER OF NEW NOTIFICATIONS OF BORROW REQUESTS
	$queryNumBorNotif="SELECT Count(*) as `numOfNotif` FROM thesis.notifications where isRead='0' and borrowID is not null and steps_id='9'";
	$resultNumBorNotif=mysqli_query($dbc,$queryNumBorNotif);
	$rowNumBorNotif=mysqli_fetch_array($resultNumBorNotif,MYSQLI_ASSOC);
	
	//GET NUMBER OF NEW NOTIFICATIONS OF DONATION REQUESTS
	$queryNumDonNotif="SELECT Count(*) as `numOfNotif` FROM thesis.notifications where isRead='0' and donationID is not null and steps_id='9'";
	$resultNumDonNotif=mysqli_query($dbc,$queryNumDonNotif);
	$rowNumDonNotif=mysqli_fetch_array($resultNumDonNotif,MYSQLI_ASSOC);
	
	//GET NUMBER OF NEW NOTIFICATIONS OF REPLACEMENT REQUESTS
	$queryNumReplNotif="SELECT Count(*) as `numOfNotif` FROM thesis.notifications where isRead='0' and replacementID is not null and steps_id='9'";
	$resultNumReplNotif=mysqli_query($dbc,$queryNumReplNotif);
	$rowNumReplNotif=mysqli_fetch_array($resultNumReplNotif,MYSQLI_ASSOC);
	
	//GET NUMBER OF NEW NOTIFICATIONS OF SALVAGE REQUESTS
	$queryNumSalNotif="SELECT Count(*) as `numOfNotif` FROM thesis.notifications where isRead='0' and salvage_id is not null";
	$resultNumSalNotif=mysqli_query($dbc,$queryNumSalNotif);
	$rowNumSalNotif=mysqli_fetch_array($resultNumSalNotif,MYSQLI_ASSOC);
	
	$totalNotifs=$rowNumNotif['numOfNotif']+$rowNumBorNotif['numOfNotif']+$rowNumDonNotif['numOfNotif']+$rowNumReplNotif['numOfNotif']+$rowNumSalNotif['numOfNotif'];
	
	//GET NUMBER OF BUILDING ROOMTYPE FOR MAINTENANCE
	$numBldgRmType=0;
	$queryNumBldgRmType="SELECT b.BuildingID, b.name, r.id, r.roomtype FROM building b JOIN floorandroom f ON b.BuildingID = f.BuildingID
																																					   JOIN ref_roomtype r ON f.roomtype = r.id
																																					   group by f.roomtype,b.BuildingID 
																																					   order by b.BuildingID asc";
	$resultNumBldgRmType=mysqli_query($dbc,$queryNumBldgRmType);
	while($rowNumBldgRmType=mysqli_fetch_array($resultNumBldgRmType,MYSQLI_ASSOC)){
		$numBldgRmType++;
	}
	
	//GET NUMBER OF ASSIGNED BUILDING ROOMTYPE FOR MAINTENANCE
	$queryAssigBldgRm="SELECT count(*) as `numAssigned` FROM thesis.engineer_assignment";
	$resultAssigBldgRm=mysqli_query($dbc,$queryAssigBldgRm);
	$rowAssigBldgRm=mysqli_fetch_array($resultAssigBldgRm,MYSQLI_ASSOC);
	
	$numUnassigBldgRm=$numBldgRmType-$rowAssigBldgRm['numAssigned'];
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
                                <span>Maintenance Teams ';
								if($numUnassigBldgRm>'0'){
									echo '<span class="badge badge-light">'.$numUnassigBldgRm.'</span>';
								}
								echo '</span>
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