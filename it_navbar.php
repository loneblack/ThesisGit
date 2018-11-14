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
                                <span>Requests</span>
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
                            <a href="it_view_deployed_assets.php">
                                <i class="glyphicon glyphicon-asterisk"></i>
                                <span>View Deployed Assets</span>
                            </a>
                        </li>
                        
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-dropbox"></i>
                                <span>Inventory</span>
                            </a>
                            <ul class="sub">
                                <li><a href="it_inventory.php">Assets</a></li>
                                <li><a href="it_software.php">All Softwares</a></li>
                                <li><a href="it_brands.php">Brands</a></li>
                                <li><a href="it_products.php">Products</a></li>
                                <li><a href="it_categories.php">Categories</a></li>
                                <li><a href="it_build_asset.php">Build Asset</a></li>
                                <li><a href="it_bulk_checkout.php">Bulk Checkout</a></li>
                                <li><a href="it_inventory_report.php">Report</a></li>
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
                                <li><a href="it_view_donation_list.php">For Donation</a></li>
                                <li><a href="it_mark_for_donation.php">Mark Assets For Donation</a></li>
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