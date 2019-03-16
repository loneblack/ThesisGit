<?php 
	require_once('db/mysql_connect.php');
	
	//GET NUMBER OF NEW NOTIFICATIONS OF ASSET PURCHASE REQUESTS
	$queryNumNotif="SELECT Count(*) as `numOfNotif` FROM thesis.notifications where isRead='0' and requestID is not null and steps_id='23'";
	$resultNumNotif=mysqli_query($dbc,$queryNumNotif);
	$rowNumNotif=mysqli_fetch_array($resultNumNotif,MYSQLI_ASSOC);

?>
<?php  echo '<aside>
            <div id="sidebar" class="nav-collapse">
                <!-- sidebar menu start-->
                <div class="leftside-navigation">
                    <ul class="sidebar-menu" id="nav-accordion">                        
                        <li>
                            <a href="director_requests.php">
                                <i class="fa fa-dashboard"></i>
                                <span>Home ';
								if($rowNumNotif['numOfNotif']>'0'){
									echo '<span class="badge badge-light">'.$rowNumNotif['numOfNotif'].'</span>';
								}
								echo '</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="director_donation.php">
                                <i class="fa fa-money"></i>
                                <span>Donation Form</span>
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