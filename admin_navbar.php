<?php  echo '<aside>
            <div id="sidebar" class="nav-collapse">
                <!-- sidebar menu start-->
                <div class="leftside-navigation">
                    <ul class="sidebar-menu" id="nav-accordion">
                        <li>
                            <a href="admin_dashboard.php">
                                <i class="fa fa-dashboard"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="glyphicon glyphicon-user"></i>
                                <span>Users</span>
                            </a>
                            <ul class="sub">
                                <li><a href="admin_all_users.php">All Users</a></li>
                                <li><a href="admin_add_users.php">Add Users</a></li>
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