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
                                <span>Requests</span>
                            </a>
                        </li>
                        
                        
                        <li class="sub-menu">
                            <a href="helpdesk_category.php">
                                <i class="fa fa-list-ol"></i>
                                <span>Categories</span>
                            </a>
                        </li>
                        
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-dropbox"></i>
                                <span>Asset</span>
                            </a>
                            <ul class="sub">
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