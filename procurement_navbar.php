<?php
	require_once('db/mysql_connect.php');
	
	//GET NUMBER OF NEW NOTIFICATIONS
	$queryNumNotif="SELECT Count(*) as `numOfNotif` FROM thesis.notifications where isRead='0' and steps_id='3'";
	$resultNumNotif=mysqli_query($dbc,$queryNumNotif);
	$rowNumNotif=mysqli_fetch_array($resultNumNotif,MYSQLI_ASSOC);
?>
<?php  echo '<aside>
            <div id="sidebar" class="nav-collapse">
                <!-- sidebar menu start-->
                <div class="leftside-navigation">
                    <ul class="sidebar-menu" id="nav-accordion">
                        <li>
                            <a href="procurement_dashboard.php">
                                <i class="fa fa-dashboard"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="procurement_view_canvas.php">
                                <i class="fa fa-money"></i>
                                <span>View Canvas List ';
								if($rowNumNotif['numOfNotif']>'0'){
									echo '<span class="badge badge-light">'.$rowNumNotif['numOfNotif'].'</span>';
								}
								echo '</span>
                            </a>
                        </li>
                        
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-group"></i>
                                <span>Supplier</span>
                            </a>
                            <ul class="sub">
                                <li><a href="procurement_all_supplier.php">All Suppliers</a></li>
                                <li><a href="procurement_add_supplier.php">Add Supplier</a></li>
                            </ul>
                        </li>
                        
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-desktop"></i>
                                <span>Assets</span>
                            </a>
                            <ul class="sub">
                                <li><a href="procurement_all_asset.php">All Assets</a></li>
                                <li><a href="procurement_add_asset.php">Add Asset</a></li>
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