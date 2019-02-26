<!DOCTYPE html>
<?php
	session_start();
    $userID = $_SESSION['userID'];
	require_once('db/mysql_connect.php');
	$StartDate = strtotime('2018-1-3'); //Start date from which we begin count
	$CurDate = date("Y-m-d"); //Current date.
	$NextDate = date("Y-m-d", strtotime("+2 week", $StartDate)); //Next date = +2 week from start date
	while ($CurDate > $NextDate ) { 
	  $NextDate = date("Y-m-d", strtotime("+2 week", strtotime($NextDate)));
	}
	$_SESSION['dateDisposal']=date("Y-m-d", strtotime($NextDate));
	
	
	//GET DATE FROM SCHOOLYEAR TABLE
	$CurDate = date("Y-m-d"); //Current date.
		
	$check = false;
	//$dateNeeded='2050-12-05 15:09:24';
	$dateNeeded=null;
		
	$querySY="SELECT * FROM thesis.schoolyear order by SchoolYearID asc";
	$resultSY=mysqli_query($dbc,$querySY);
	while($rowSY=mysqli_fetch_array($resultSY, MYSQLI_ASSOC)){
		if($CurDate<$rowSY['Term1End']&&$check==false){
			$dateNeeded=$rowSY['Term1End'];
			$check = true;
		}
		elseif($CurDate<$rowSY['Term2End']&&$check==false){
			$dateNeeded=$rowSY['Term2End'];
			$check = true;
		}
		elseif($CurDate<$rowSY['Term3End']&&$check==false){
			$dateNeeded=$rowSY['Term3End'];
			$check = true;
		}
	}
	$_SESSION['dateMaintenance']=$dateNeeded;
	
?>

<?php
require_once("db/mysql_connect.php");

$query1="SELECT COUNT(*) as 'count' FROM asset WHERE assetStatus = 5;";
$result1=mysqli_query($dbc,$query1);
while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)){ $brokenFixable = $row1['count']; }

$query2="SELECT COUNT(*) as 'count' FROM asset WHERE assetStatus = 1;";
$result2=mysqli_query($dbc,$query2);
while ($row1 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){ $onHand = $row1['count']; }

$query3="SELECT COUNT(*) as 'count' FROM asset WHERE assetStatus = 2;";
$result3=mysqli_query($dbc,$query3);
while ($row1 = mysqli_fetch_array($result3, MYSQLI_ASSOC)){ $deployed = $row1['count']; }

$query4="SELECT COUNT(*) as 'count' FROM asset WHERE assetStatus != 4 AND assetStatus != 6 AND assetStatus != 7 AND assetStatus != 8 AND assetStatus != 15;";
$result4=mysqli_query($dbc,$query4);
while ($row1 = mysqli_fetch_array($result4, MYSQLI_ASSOC)){ $totalAssets = $row1['count']; }
?>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="images/favicon.png">

    <title>DLSU IT Asset Management</title>

    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/morris-chart/morris.css">
    <!--dynamic table-->
    <link href="js/advanced-datatable/css/demo_page.css" rel="stylesheet" />
    <link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/data-tables/DT_bootstrap.css" />

    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
</head>

        <?php
            $count = 1;
            $query = "SELECT e.name AS `naame` FROM employee e JOIN user u ON e.userID = u.userID WHERE e.userID = {$userID};";
            $result = mysqli_query($dbc, $query);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $name = $row['naame'];
        ?>    

<body>

    <section id="container">
        <!--header start-->
        <header class="header fixed-top clearfix">
            <!--logo start-->
            <div class="brand">

                <a href="#" class="logo">
                    <img src="images/dlsulogo.png" alt="" width="200px" height="40px">
                </a>
            </div>

            <div class="nav notify-row" id="top_menu">
                <h4>Welcome! <?php echo $name; ?></h4>
            </div>

        </header>
        <!--header end-->
        <?php include 'it_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="col-sm-12">
                    <div class="col-sm-12">
                        <div class="alert alert-info">
                            <strong>Hello!
                                <?php echo $_SESSION['dateDisposal']; ?> is the next Disposal Day! </strong> Please Click this <a href="it_view_disposal_list.php" class="alert-link">link</a> to input the assets for collection for disposal.
                        </div>
						<div class="alert alert-info">
                            <strong>Hello!
                                <?php echo $_SESSION['dateMaintenance']; ?> is the next Maintenance Day! </strong> Please Click this <a href="it_set_maintenance.php" class="alert-link">link</a> to assign engineers to maintain buildings.
                        </div>
                        <div class="row">

                            <a href="it_inventory.php">
                                <div class="col-md-3">
                                    <div class="mini-stat clearfix">
                                        <span class="mini-stat-icon green"><i class="fa fa-barcode"></i></span>
                                        <div class="mini-stat-info">
                                            <span>
                                                <?php echo $totalAssets;?></span>
                                            Total Assets
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="it_software.php">
                                <div class="col-md-3">
                                    <div class="mini-stat clearfix">
                                        <span class="mini-stat-icon orange"><i class="fa fa-save"></i></span>
                                        <div class="mini-stat-info">
                                            <span>
                                                <?php echo $deployed;?></span>
                                            Deployed
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="it_inventory.php">
                                <div class="col-md-3">
                                    <div class="mini-stat clearfix">
                                        <span class="mini-stat-icon pink"><i class="fa fa-keyboard-o"></i></span>
                                        <div class="mini-stat-info">
                                            <span>
                                                <?php echo $onHand;?></span>
                                            On Hand
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="it_inventory.php">
                                <div class="col-md-3">
                                    <div class="mini-stat clearfix">
                                        <span class="mini-stat-icon green"><i class="fa fa-files-o"></i></span>
                                        <div class="mini-stat-info">
                                            <span>
                                                <?php echo $brokenFixable;?></span>
                                            Broken Fixable
                                        </div>
                                    </div>
                                </div>
                            </a>


                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="panel">
                                        <header class="panel-heading">
                                            Recent Requests
                                            <span class="tools pull-right">
                                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                            </span>
                                        </header>
                                        <div class="panel-body">
                                            <div class="adv-table">
                                                <table class="display table table-bordered table-striped" id="dynamic-table">
                                                    <thead>
                                                        <tr>
                                                            <th style="display: none">id</th>
                                                            <th>#</th>
                                                            <th>Date Needed</th>
                                                            <th>Status</th>
                                                            <th>Request Type</th>
                                                            <th>Description</th>
                                                            <th>Requestor</th>
                                                            <th>Requested Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
															
                                                            $count = 1;
															$key = "Fusion";
															require_once('db/mysql_connect.php');

                                                            //Request Purchase
															$query="SELECT *,r.requestID,rstp.name as `step`,r.recipient,r.date as `requestedDate`,r.dateNeeded,rs.description as `statusDesc`,CONCAT(Convert(AES_DECRYPT(u.firstName,'{$key}')USING utf8), ' ', Convert(AES_DECRYPT(u.lastName,'{$key}')USING utf8)) as `requestor`
                                                                                FROM thesis.request r 
                                                                                join ref_status rs on r.status=rs.statusID
                                                                                join ref_steps rstp on r.step=rstp.id
                                                                                join user u on r.UserID=u.UserID
                                                                                WHERE status !=6 AND r.step !=1;";
															$result=mysqli_query($dbc,$query);
															while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
																echo "<tr> 
                                                                    <td style='display: none'>{$row['requestID']}</td>
                                                                    <td>{$count}</td>
																	<td>{$row['dateNeeded']}</td>";
																	
																	if($row['statusDesc']=='Pending'){
																		echo "<td><span class='label label-warning label-mini'>{$row['statusDesc']}</span></td>";
																	}
																	elseif($row['statusDesc']=='Incomplete'){
																		echo "<td><span class='label label-danger label-mini'>{$row['statusDesc']}</span></td>";
																	}
																	elseif($row['statusDesc']=='Completed'){
																		echo "<td><span class='label label-success label-mini'>{$row['statusDesc']}</span></td>";
																	}
																	//elseif($row['statusDesc']=='Ongoing'){
																		//echo "<td><span class='label label-default label-mini'>{$row['statusDesc']}</span></td>";
																	//}
																	else{
																		echo "<td><span class='label label-default label-mini'>{$row['statusDesc']}</span></td>";
																	}
																	
																echo "
																	<td>Asset Request</td>
																	<td>{$row['step']}</td>
																	<td>{$row['requestor']}</td>
																	<td>{$row['requestedDate']}</td>
																</tr>";
																
																$count++;
																
															}
															//Donation
															$queryDon="SELECT * , rs.description as `statusDesc`,CONCAT(Convert(AES_DECRYPT(u.firstName,'{$key}')USING utf8), ' ', Convert(AES_DECRYPT(u.lastName,'{$key}')USING utf8)) as `requestor`,rstp.name as `step`,d.dateCreated FROM thesis.donation d join ref_status rs on d.statusID=rs.statusID
																																		join ref_steps rstp on d.stepsID=rstp.id
																																		join user u on d.user_UserID=u.UserID";
															$resultDon=mysqli_query($dbc,$queryDon);
															
															while($rowDon=mysqli_fetch_array($resultDon,MYSQLI_ASSOC)){
																echo "<tr>
                                                                    <td style='display: none'>{$rowDon['donationID']}</td>
                                                                    <td>{$count}</td>
																	<td>{$rowDon['dateNeed']}</td>";
																	
																	if($rowDon['statusDesc']=='Pending'){
																		echo "<td><span class='label label-warning label-mini'>{$rowDon['statusDesc']}</span></td>";
																	}
																	elseif($rowDon['statusDesc']=='Incomplete'){
																		echo "<td><span class='label label-danger label-mini'>{$rowDon['statusDesc']}</span></td>";
																	}
																	elseif($rowDon['statusDesc']=='Completed'){
																		echo "<td><span class='label label-success label-mini'>{$rowDon['statusDesc']}</span></td>";
																	}
																	else{
																		echo "<td><span class='label label-default label-mini'>{$rowDon['statusDesc']}</span></td>";
																	}
																	
																echo "
																	<td>Donation</td>
																	<td>{$rowDon['step']}</td>
																	<td>{$rowDon['requestor']}</td>
																	<td>{$rowDon['dateCreated']}</td>
																</tr>";
																$count++;
															}
															//Donation for outsiders
															
															$queryDonOut="SELECT * , rs.description as `statusDesc`,rstp.name as `step`,d.dateCreated,d.contactPerson FROM thesis.donation d join ref_status rs on d.statusID=rs.statusID
																													join ref_steps rstp on d.stepsID=rstp.id 
                                                                                                                                        where d.user_UserID is null and d.statusID!=6";
															$resultDonOut=mysqli_query($dbc,$queryDonOut);
															
															while($rowDonOut=mysqli_fetch_array($resultDonOut,MYSQLI_ASSOC)){
																echo "<tr>
                                                                    <td style='display: none'>{$rowDonOut['donationID']}</td>
                                                                    <td>{$count}</td>
																	<td>{$rowDonOut['dateNeed']}</td>";
																	
																	if($rowDon['statusDesc']=='Pending'){
																		echo "<td><span class='label label-warning label-mini'>{$rowDonOut['statusDesc']}</span></td>";
																	}
																	elseif($rowDon['statusDesc']=='Incomplete'){
																		echo "<td><span class='label label-danger label-mini'>{$rowDonOut['statusDesc']}</span></td>";
																	}
																	elseif($rowDon['statusDesc']=='Completed'){
																		echo "<td><span class='label label-success label-mini'>{$rowDonOut['statusDesc']}</span></td>";
																	}
																	else{
																		echo "<td><span class='label label-default label-mini'>{$rowDonOut['statusDesc']}</span></td>";
																	}
																	
																echo "
																	<td>Donation</td>
																	<td>{$rowDonOut['step']}</td>
																	<td>{$rowDonOut['contactPerson']}</td>
																	<td>{$rowDonOut['dateCreated']}</td>
																</tr>";
																$count++;
															}																		
																																		
															
															 //Borrow
                                                            $query="SELECT *,CONCAT(Convert(AES_DECRYPT(u.firstName,'{$key}')USING utf8), ' ', Convert(AES_DECRYPT(u.lastName,'{$key}')USING utf8)) as `requestor` FROM thesis.request_borrow r 
                                                                      JOIN ref_status s ON r.statusID = s.statusID
                                                                      JOIN ref_steps t ON r.steps = t.id 
																	  join user u on r.personresponsibleID=u.UserID;";
                                                            $result=mysqli_query($dbc,$query);
                                                            while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                                                                echo "<tr> 
                                                                    <td style='display: none'>{$row['borrowID']}</td>
                                                                    <td>{$count}</td>
                                                                    <td>{$row['startDate']}</td>";
                                                                    
                                                                    if($row['description']=='Pending'){
                                                                        echo "<td><span class='label label-warning label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                                    elseif($row['description']=='Incomplete'){
                                                                        echo "<td><span class='label label-danger label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                                    elseif($row['description']=='Completed'){
                                                                        echo "<td><span class='label label-success label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                                    else{
                                                                        echo "<td><span class='label label-default label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                                    
                                                                echo "
                                                                    <td>Borrow</td>
                                                                    <td>{$row['name']}</td>
                                                                    <td>{$row['requestor']}</td>
                                                                    <td>{$row['dateCreated']}</td>
                                                                </tr>";
                                                                
                                                                $count++;
                                                                
                                                            
                                                            }
															?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>

    <!-- WAG GALAWIN PLS LANG -->

    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>

    <!--dynamic table-->
    <script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

    <script src="js/morris-chart/morris.js"></script>
    <script src="js/morris-chart/raphael-min.js"></script>
    <script src="js/morris.init.js"></script>

    <!--dynamic table initialization -->
    <script src="js/dynamic_table_init.js"></script>

</body>

</html>