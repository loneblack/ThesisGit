<link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />

    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
<?php
	require_once('db/mysql_connect.php');
	$totalNumReq = 0;
	
	//GET NUMBER OF NEW NOTIFICATIONS OF ASSET PURCHASE REQUESTS
	$queryNumNotif="SELECT Count(*) as `numOfNotif` FROM thesis.notifications where isRead='0' and requestID is not null and steps_id!='3'";
	$resultNumNotif=mysqli_query($dbc,$queryNumNotif);
	$rowNumNotif=mysqli_fetch_array($resultNumNotif,MYSQLI_ASSOC);
	
	//GET NUMBER OF NEW NOTIFICATIONS OF BORROW REQUESTS
	$queryNumBorNotif="SELECT Count(*) as `numOfNotif` FROM thesis.notifications where isRead='0' and borrowID is not null and steps_id='12'";
	$resultNumBorNotif=mysqli_query($dbc,$queryNumBorNotif);
	$rowNumBorNotif=mysqli_fetch_array($resultNumBorNotif,MYSQLI_ASSOC);
	
	//GET NUMBER OF NEW NOTIFICATIONS OF DONATION REQUESTS
	$queryNumDonNotif="SELECT Count(*) as `numOfNotif` FROM thesis.notifications where isRead='0' and donationID is not null and steps_id='1'";
	$resultNumDonNotif=mysqli_query($dbc,$queryNumDonNotif);
	$rowNumDonNotif=mysqli_fetch_array($resultNumDonNotif,MYSQLI_ASSOC);
	
	//GET NUMBER OF NEW NOTIFICATIONS OF REPLACEMENT REQUESTS
	$queryNumReplNotif="SELECT Count(*) as `numOfNotif` FROM thesis.notifications where isRead='0' and replacementID is not null and steps_id='26'";
	$resultNumReplNotif=mysqli_query($dbc,$queryNumReplNotif);
	$rowNumReplNotif=mysqli_fetch_array($resultNumReplNotif,MYSQLI_ASSOC);
	
	$totalNumReq=$rowNumNotif['numOfNotif']+$rowNumBorNotif['numOfNotif']+$rowNumDonNotif['numOfNotif']+$rowNumReplNotif['numOfNotif'];
	
	//GET NUMBER OF NEW NOTIFICATIONS OF PURCHASE ORDERS
	$queryNumNotifPur="SELECT Count(*) as `numOfNotif` FROM thesis.notifications where isRead='0' and procurementID is not null";
	$resultNumNotifPur=mysqli_query($dbc,$queryNumNotifPur);
	$rowNumNotifPur=mysqli_fetch_array($resultNumNotifPur,MYSQLI_ASSOC);
	
	//GET NUMBER OF NEW NOTIFICATIONS OF PURCHASE ORDERS
	$queryNumNotifTest="SELECT Count(*) as `numOfNotif` FROM thesis.notifications where isRead='0' and testingID is not null";
	$resultNumNotifTest=mysqli_query($dbc,$queryNumNotifTest);
	$rowNumNotifTest=mysqli_fetch_array($resultNumNotifTest,MYSQLI_ASSOC);
?>
<?php  echo '<aside>
            <div id="sidebar" class="nav-collapse">
                <!-- sidebar menu start-->
                <div class="leftside-navigation">
                    <ul class="sidebar-menu" id="nav-accordion">
                        <li>
                            <a href="it_dashboard.php">
                                <i class="fa fa-dashboard"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="it_requests.php">
                                <i class="fa fa-envelope-o"></i>
                                <span>Requests '; 
								if($totalNumReq>'0'){
									echo '<span class="badge badge-light">'.$totalNumReq.'</span>';
								}
								echo '</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="it_po_list.php">
                                <i class="fa fa-money"></i>
                                <span>Purchase Orders ';
								if($rowNumNotifPur['numOfNotif']>'0'){
									echo '<span class="badge badge-light">'.$rowNumNotifPur['numOfNotif'].'</span>';
								}
								echo '</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="it_testing_list.php">
                                <i class="fa fa-tasks"></i>
                                <span>Testing ';
								if($rowNumNotifTest['numOfNotif']>'0'){
									echo '<span class="badge badge-light">'.$rowNumNotifTest['numOfNotif'].'</span>';
								}
								echo '</span>
                            </a>
                        </li>
                        
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-dropbox"></i>
                                <span>Inventory</span>
                            </a>
                            <ul class="sub">
                                <li><a href="it_list_all_assets.php">List All Assets</a></li>
                                <li><a href="it_inventory.php">Assets</a></li>
                                <li><a href="it_brands.php">Brands</a></li>
                                <li><a href="it_products.php">Products</a></li>
                                <li><a href="it_categories.php">Categories</a></li>
                                <li><a href="it_build_asset.php">Build Asset</a></li>
                                <li><a href="it_bulk_checkin.php">Bulk Checkin</a></li>
                            </ul>
                        </li>

                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="glyphicon glyphicon-chevron-right"></i>
                                <span>Delivery</span>
                            </a>
                            <ul class="sub">
                                <li><a href="it_delivery_schedule.php">Delivery Schedule</a></li>
                                <!-- <li><a href="it_brands.php">Add New Delivery</a></li> -->
                            </ul>
                        </li>
						
						<li class="sub-menu">
                            <a href="javascript:;">
                                <i class="glyphicon glyphicon-trash"></i>
                                <span>Disposal</span>
                            </a>
                            <ul class="sub">
                                <li><a href="it_view_disposal_list.php">For Disposal</a></li>
                                <li><a href="it_mark_salvage.php">Mark Assets For Salvage</a></li>
                            </ul>
                        </li>
						
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="glyphicon glyphicon-plus"></i>
                                <span>Donation</span>
                            </a>
                            <ul class="sub">
                                <li><a href="it_mark_for_donation.php">Mark Assets for Donation</a></li>
                                <li><a href="it_donation_list.php">Donation List</a></li>
                            </ul>
                        </li>
                        
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-group"></i>
                                <span>Supplier</span>
                            </a>
                            <ul class="sub">
                                <li><a href="it_all_supplier.php">All Suppliers</a></li>
                                <li><a href="it_add_supplier.php">Add Supplier</a></li>
                            </ul>
                        </li>
                        
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa-bar-chart-o"></i>
                                <span>Reports</span>
                            </a>
                            <ul class="sub">
                                <li><a href="it_inventory_report.php">Inventory Report</a></li>
                                <li><a href="it_preventive_maintenance_report.php">Preventive Maintenance Report</a></li>
                                <li><a href="it_repair_report.php">Repair Report</a></li>
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