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
                                <li><a href="requestor_service_request_form.php">Service</a></li>
                                <li><a href="requestor_donation_request_form.php">Donation</a></li>
                                <li><a href="requestor_request_for_procurement_service_material.php">Procurement of Service or Material</a></li>
								<li><a href="requestor_service_equipment_request.php">Service Equipment Request</a></li>
                            </ul>
                        </li>
						
						<li class="sub-menu">
                            <a href="requestor_requests.php">
                                <i class="glyphicon glyphicon-tasks"></i>
                                <span>View Requests</span>
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