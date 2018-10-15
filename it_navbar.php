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
                            <a href="it_inventory.php">
                                <i class="fa fa-dropbox"></i>
                                <span>Assets</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="it_software.php">
                                <i class="fa fa-cloud-download"></i>
                                <span>Software Assets</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="it_asset_checklist_list.php">
                                <i class="fa fa-list"></i>
                                <span>Checklist List</span>
                            </a>
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