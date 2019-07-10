<?php
	require_once('db/mysql_connect.php');
	$totalNotifs=0;
	
	//GET NOTIFICATIONS FOR Delivery REQUESTOR
	$queryNumNotifDel="SELECT Count(*) as `numOfNotif` FROM thesis.notifications n join requestor_receiving rr on n.requestor_receiving_id=rr.id
															join request r on rr.requestID=r.requestID 
															
                                                            where n.isRead='0' and n.requestor_receiving_id is not null and r.UserID='{$_SESSION['userID']}' and rr.statusID='1'";
	$resultNumNotifDel=mysqli_query($dbc,$queryNumNotifDel);
	$rowNumNotifDel=mysqli_fetch_array($resultNumNotifDel,MYSQLI_ASSOC);
	
	//GET NOTIF FOR Delivery Borrow Request
	$queryNumNotifBorDel="SELECT Count(*) as `numOfNotif` FROM thesis.notifications n join requestor_receiving rr on n.requestor_receiving_id=rr.id
															join request_borrow rb on rr.borrowID=rb.borrowID 
															
                                                            where n.isRead='0' and n.requestor_receiving_id is not null and rb.personresponsibleID='{$_SESSION['userID']}' and rr.statusID='1'";
	$resultNumNotifBorDel=mysqli_query($dbc,$queryNumNotifBorDel);
	$rowNumNotifBorDel=mysqli_fetch_array($resultNumNotifBorDel,MYSQLI_ASSOC);
	
	//GET NOTIF FOR Asset Request
	$queryNumNotif="SELECT Count(*) as `numOfNotif` FROM thesis.notifications n join request r on n.requestID=r.requestID where n.isRead='0' and r.UserID='{$_SESSION['userID']}' and n.requestID is not null and (n.steps_id='28' or n.steps_id='29')";
	$resultNumNotif=mysqli_query($dbc,$queryNumNotif);
	$rowNumNotif=mysqli_fetch_array($resultNumNotif,MYSQLI_ASSOC);
	
	$totalNotifs=$rowNumNotifDel['numOfNotif']+$rowNumNotif['numOfNotif']+$rowNumNotifBorDel['numOfNotif'];
	
?>
<?php  echo '<aside>
            <div id="sidebar" class="nav-collapse">
                <!-- sidebar menu start-->
                <div class="leftside-navigation">
                    <ul class="sidebar-menu" id="nav-accordion">
                        <li>
                            <a href="requestor_dashboard.php">
                                <i class="fa fa-dashboard"></i>
                                <span>Dashboard ';
								if($totalNotifs>'0'){
									echo '<span class="badge badge-light">'.$totalNotifs.'</span>';
								}
								echo '</span>
                            </a>
                        </li>
                        
                        
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="glyphicon glyphicon-envelope"></i>
                                <span>Create New Request</span>
                            </a>
                            <ul class="sub">
                                <li><a href="requestor_service_request_form.php">Report Your Broken Asset</a></li>
                                <li><a href="requestor_request_for_procurement_service_material.php">Request to Purchase an Asset</a></li>
								<li><a href="requestor_service_equipment_request.php">Borrow an Asset</a></li>
                            </ul>
                        </li>
                        
                        <li class="sub-menu">
                            <a href="requestor_assets.php">
                                <i class="fa fa-archive"></i>
                                <span>My Assets</span>
                            </a>
                            <ul class="sub">
                                <li><a href="requestor_assets.php">Asset List</a></li>
                                <li><a href="requestor_asset_delivery.php">Asset Delivery</a></li>
                                <li><a href="requestor_send_asset.php">Send Assets</a></li>
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