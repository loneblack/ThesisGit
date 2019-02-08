<link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />

    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

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
                                <span>Requests <span class="badge badge-light">4</span> </span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="it_po_list.php">
                                <i class="fa fa-money"></i>
                                <span>Purchase Orders</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="it_testing_list.php">
                                <i class="fa fa-tasks"></i>
                                <span>Testing</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="it_maintenance_teams.php">
                                <i class="fa fa-clock-o"></i>
                                <span>Maintenance Teams</span>
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
                                <li><a href="it_bulk_checkout.php">Bulk Checkout</a></li>
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
                                <li><a href="it_view_disposal_list.php">For Diposal</a></li>
                                <li><a href="it_mark_for_disposal.php">Mark Assets For Diposal</a></li>
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