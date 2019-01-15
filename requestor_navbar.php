<?php  echo '<aside>
            <div id="sidebar" class="nav-collapse">
                <!-- sidebar menu start-->
                <div class="leftside-navigation">
                    <ul class="sidebar-menu" id="nav-accordion">
                        <li>
                            <a href="requestor_dashboard.php">
                                <i class="fa fa-dashboard"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        
                        
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="glyphicon glyphicon-envelope"></i>
                                <span>Create New Request</span>
                            </a>
                            <ul class="sub">
                                <li><a href="requestor_service_request_form.php">Repair</a></li>
                                <li><a href="requestor_request_for_procurement_service_material.php">Request to Purchase an Asset</a></li>
								<li><a href="requestor_service_equipment_request.php">Borrow an Asset</a></li>
                            </ul>
                        </li>
					   
                       <li>
                            <a href="requestor_assets.php">
                                <i class="fa fa-archive"></i>
                                <span>My Assets</span>
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