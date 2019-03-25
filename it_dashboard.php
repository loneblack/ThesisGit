<!DOCTYPE html>
<?php
	session_start();
    $userID = $_SESSION['userID'];
    $_SESSION['previousDash'] = "it_dashboard.php";
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
	//FOR MAINTENANCE REPORTS PAGE
	/*$_SESSION['room'] = array();
	$_SESSION['propertyCode'] = array();
	$_SESSION['assetCat'] = array();
	$_SESSION['assetStat'] = array();
	$_SESSION['dateChecked'] = array();
	
	$_SESSION['roomType']='0';
	$_SESSION['yr']='0';
	$_SESSION['mnt']='0';
	$_SESSION['bldg']='0';
	
	$queryGetAllMainData="SELECT far.floorRoom,a.propertyCode,rac.name as `assetCat`,ras.description as `assetStat`,au.date FROM thesis.ticket t join assetaudit au on t.ticketID=au.ticketID 
																																																							  join asset a on au.assetID=a.assetID
																																																							  join assetmodel am on a.assetModel=am.assetModelID
																																																							  join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																																																							  join ref_assetstatus ras on au.assetStatus=ras.id 
																																																							  join assetassignment aa on a.assetID=aa.assetID 
																																																							  join floorandroom far on aa.FloorAndRoomID=far.FloorAndRoomID
																																																where t.serviceType='28' and au.assetStatus!='17'";
	$resultGetAllMainData=mysqli_query($dbc,$queryGetAllMainData);
	while($rowGetAllMainData=mysqli_fetch_array($resultGetAllMainData,MYSQLI_ASSOC)){
		array_push($_SESSION['room'],$rowGetAllMainData['floorRoom']);	
		array_push($_SESSION['propertyCode'],$rowGetAllMainData['propertyCode']);	
		array_push($_SESSION['assetCat'],$rowGetAllMainData['assetCat']);	
		array_push($_SESSION['assetStat'],$rowGetAllMainData['assetStat']);	
		array_push($_SESSION['dateChecked'],$rowGetAllMainData['date']);	
	}*/
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
						 <!--<div class="alert alert-info">
                           <strong>Hello!
                                <?php //echo $_SESSION['dateMaintenance']; ?> is the next Maintenance Day! </strong> Please Click this <a href="it_set_maintenance.php" class="alert-link">link</a> to assign engineers to maintain buildings.
                        </div>-->
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
                                                            <th>Details</th>
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
                                                                    <td>{$row['description']}</td>
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
                                                                    <td>{$rowDon['purpose']}</td>
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
                                                                    <td>{$row['purpose']}</td>
                                                                </tr>";
                                                                
                                                                $count++;
                                                                
                                                            
                                                            }
															//Replacement 
															$queryGetRep="SELECT *,CONCAT(Convert(AES_DECRYPT(u.firstName,'{$key}')USING utf8), ' ', Convert(AES_DECRYPT(u.lastName,'{$key}')USING utf8)) as `Requestor`,rs.description as `statusDesc`,rstp.name as `stepName` FROM thesis.replacement r 
																			JOIN ref_status rs ON r.statusID = rs.statusID
																			JOIN user u on r.userID=u.UserID
																			JOIN ref_steps rstp on r.stepID=rstp.id";
                                                            $resultGetRep=mysqli_query($dbc,$queryGetRep);
                                                            while($rowGetRep=mysqli_fetch_array($resultGetRep,MYSQLI_ASSOC)){
                                                                echo "<tr> 
                                                                    <td style='display: none'>{$rowGetRep['replacementID']}</td>
                                                                    <td>{$count}</td>
                                                                    <td>{$rowGetRep['dateNeeded']}</td>";
																	
																	if($row['statusDesc']=='Pending'){
																		echo "<td><span class='label label-warning label-mini'>{$rowGetRep['statusDesc']}</span></td>";
																	}
																	elseif($row['statusDesc']=='Incomplete'){
																		echo "<td><span class='label label-danger label-mini'>{$rowGetRep['statusDesc']}</span></td>";
																	}
																	elseif($row['statusDesc']=='Completed'){
																		echo "<td><span class='label label-success label-mini'>{$rowGetRep['statusDesc']}</span></td>";
																	}
																	//elseif($row['statusDesc']=='Ongoing'){
																		//echo "<td><span class='label label-default label-mini'>{$row['statusDesc']}</span></td>";
																	//}
																	else{
																		echo "<td><span class='label label-default label-mini'>{$rowGetRep['statusDesc']}</span></td>";
																	}
                                                                    
                                                                echo "
                                                                    <td>Replacement</td>
                                                                    <td>{$rowGetRep['stepName']}</td>
                                                                    <td>{$rowGetRep['Requestor']}</td>
                                                                    <td>{$rowGetRep['dateTiimeLost']}</td>
                                                                    <td>{$rowGetRep['description']}</td>
                                                                </tr>";
                                                                
                                                                $count++;
                                                                
                                                            
                                                            }

                                                            //Service Unit
                                                            $queryServiceUnit = "SELECT *, e.name as 'requestedby', s.name as 'stepname' 
                                                                                    FROM thesis.serviceunit su
                                                                                JOIN service sr
                                                                                    ON sr.id = su.serviceID
                                                                                JOIN ref_status st 
                                                                                    ON su.statusID = st.statusID
                                                                                JOIN ref_steps s 
                                                                                    ON steps = s.id
                                                                                JOIN employee e 
                                                                                    ON e.UserID = su.UserID;";
                                                            

                                                            $resultServiceUnit = mysqli_query($dbc, $queryServiceUnit);
                                                            while($row=mysqli_fetch_array($resultServiceUnit,MYSQLI_ASSOC)){
                                                                
                                                                echo "<tr> 
                                                                    <td style='display: none'>{$row['serviceUnitID']}</td>
                                                                    <td>{$count}</td>
                                                                    <td>{$row['dateNeeded']}</td>";
                                                                    
                                                                    if($row['description']=='Pending'){
                                                                        echo "<td><span class='label label-warning label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                                    elseif($row['description']=='Incomplete'){
                                                                        echo "<td><span class='label label-danger label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                                    elseif($row['description']=='Completed'){
                                                                        echo "<td><span class='label label-success label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                                    //elseif($row['description']=='Ongoing'){
                                                                        //echo "<td><span class='label label-default label-mini'>{$row['description']}</span></td>";
                                                                    //}
                                                                    else{
                                                                        echo "<td><span class='label label-default label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                            
                                                                echo "
                                                                    <td>Service Unit</td>
                                                                    <td>{$row['stepname']}</td>
                                                                    <td>{$row['requestedby']}</td>
                                                                    <td>{$row['dateReceived']}</td>
                                                                    <td>{$row['details']}</td>
                                                                </tr>";
                                                                
                                                                 $count++;
                                                            }

                                                            //Request for Parts
                                                            $queryRequestforParts = "SELECT * , r.id as 'requestPartsID' FROM thesis.requestparts r JOIN service s ON r.serviceID = s.id JOIN ref_status st ON r.statusID = st.statusID JOIN employee e ON e.UserID = r.UserID JOIN ticket t on s.id = t.service_id;";

                                                            $resultRequestforParts = mysqli_query($dbc, $queryRequestforParts);
                                                            while($row=mysqli_fetch_array($resultRequestforParts,MYSQLI_ASSOC)){
                                                                
                                                                echo "<tr> 
                                                                    <td style='display: none'>{$row['requestPartsID']}</td>
                                                                    <td>{$count}</td>
                                                                    <td>{$row['date']}</td>";
                                                                    
                                                                    if($row['description']=='Pending'){
                                                                        echo "<td><span class='label label-warning label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                                    elseif($row['description']=='Incomplete'){
                                                                        echo "<td><span class='label label-danger label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                                    elseif($row['description']=='Completed'){
                                                                        echo "<td><span class='label label-success label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                                    //elseif($row['description']=='Ongoing'){
                                                                        //echo "<td><span class='label label-default label-mini'>{$row['description']}</span></td>";
                                                                    //}
                                                                    else{
                                                                        echo "<td><span class='label label-default label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                            
                                                                echo "
                                                                    <td>Request for Parts</td>
                                                                    <td>Request Pending</td>
                                                                    <td>{$row['name']}</td>
                                                                    <td>{$row['date']}</td>
                                                                    <td>{$row['comment']}</td>
                                                                </tr>";
                                                                
                                                                 $count++;
                                                            }
                                                            //Service repair completed
                                                            $queryRequestforParts = "SELECT *, s.id as 'serviceID' FROM thesis.service s JOIN ref_status st ON s.status = st.statusID JOIN employee e ON e.UserID = s.UserID JOIN ref_steps rs ON s.steps = rs.id WHERE (steps = 30);";

                                                            $resultRequestforParts = mysqli_query($dbc, $queryRequestforParts);
                                                            while($row=mysqli_fetch_array($resultRequestforParts,MYSQLI_ASSOC)){
                                                                
                                                                echo "<tr> 
                                                                    <td style='display: none'>{$row['serviceID']}</td>
                                                                    <td>{$count}</td>
                                                                    <td>{$row['dateNeeded']}</td>";
                                                                    
                                                                    if($row['description']=='Pending'){
                                                                        echo "<td><span class='label label-warning label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                                    elseif($row['description']=='Incomplete'){
                                                                        echo "<td><span class='label label-danger label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                                    elseif($row['description']=='Completed'){
                                                                        echo "<td><span class='label label-success label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                                    //elseif($row['description']=='Ongoing'){
                                                                        //echo "<td><span class='label label-default label-mini'>{$row['description']}</span></td>";
                                                                    //}
                                                                    else{
                                                                        echo "<td><span class='label label-default label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                            
                                                                echo "
                                                                    <td>Service</td>
                                                                    <td>Asset Delivery</td>
                                                                    <td>{$row['name']}</td>
                                                                    <td>{$row['dateReceived']}</td>
                                                                    <td>{$row['comment']}</td>
                                                                </tr>";
                                                                
                                                                 $count++;
                                                            }
                                                            //Service replacement
                                                            $queryRequestforParts = "SELECT *, s.id as 'serviceID' FROM thesis.service s JOIN ref_status st ON s.status = st.statusID JOIN employee e ON e.UserID = s.UserID JOIN ref_steps rs ON s.steps = rs.id WHERE (steps = 32);";

                                                            $resultRequestforParts = mysqli_query($dbc, $queryRequestforParts);
                                                            while($row=mysqli_fetch_array($resultRequestforParts,MYSQLI_ASSOC)){
                                                                
                                                                echo "<tr> 
                                                                    <td style='display: none'>{$row['serviceID']}</td>
                                                                    <td>{$count}</td>
                                                                    <td>{$row['dateNeed']}</td>";
                                                                    
                                                                    if($row['description']=='Pending'){
                                                                        echo "<td><span class='label label-warning label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                                    elseif($row['description']=='Incomplete'){
                                                                        echo "<td><span class='label label-danger label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                                    elseif($row['description']=='Completed'){
                                                                        echo "<td><span class='label label-success label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                                    //elseif($row['description']=='Ongoing'){
                                                                        //echo "<td><span class='label label-default label-mini'>{$row['description']}</span></td>";
                                                                    //}
                                                                    else{
                                                                        echo "<td><span class='label label-default label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                            
                                                                echo "
                                                                    <td>Service</td>
                                                                    <td>Asset Replacement</td>
                                                                    <td>{$row['name']}</td>
                                                                    <td>{$row['dateReceived']}</td>
                                                                    <td>{$row['details']}</td>
                                                                </tr>";
                                                                
                                                                 $count++;
                                                            }
                                                            //Service partial delivery
                                                            $queryRequestforParts = "SELECT *, s.id as 'serviceID' FROM thesis.service s JOIN ref_status st ON s.status = st.statusID JOIN employee e ON e.UserID = s.UserID JOIN ref_steps rs ON s.steps = rs.id WHERE (steps = 31);";

                                                            $resultRequestforParts = mysqli_query($dbc, $queryRequestforParts);
                                                            while($row=mysqli_fetch_array($resultRequestforParts,MYSQLI_ASSOC)){
                                                                
                                                                echo "<tr> 
                                                                    <td style='display: none'>{$row['serviceID']}</td>
                                                                    <td>{$count}</td>
                                                                    <td>{$row['dateNeed']}</td>";
                                                                    
                                                                    if($row['description']=='Pending'){
                                                                        echo "<td><span class='label label-warning label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                                    elseif($row['description']=='Incomplete'){
                                                                        echo "<td><span class='label label-danger label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                                    elseif($row['description']=='Completed'){
                                                                        echo "<td><span class='label label-success label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                                    //elseif($row['description']=='Ongoing'){
                                                                        //echo "<td><span class='label label-default label-mini'>{$row['description']}</span></td>";
                                                                    //}
                                                                    else{
                                                                        echo "<td><span class='label label-default label-mini'>{$row['description']}</span></td>";
                                                                    }
                                                            
                                                                echo "
                                                                    <td>Service</td>
                                                                    <td>Partial Delivery</td>
                                                                    <td>{$row['name']}</td>
                                                                    <td>{$row['dateReceived']}</td>
                                                                    <td>{$row['details']}</td>
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

    <script>
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
   </script>

   <script>
        function addRowHandlers() {
            var table = document.getElementById("dynamic-table");
            var rows = table.getElementsByTagName("tr");
            for (i = 1; i < rows.length; i++) {
                var currentRow = table.rows[i];
                var createClickHandler = function(row) {
                    return function() {
                        var cell = row.getElementsByTagName("td")[0];
                        var ida = cell.textContent; //id
                        var cell = row.getElementsByTagName("td")[3];
                        var id = cell.textContent; //Status
                        var cell = row.getElementsByTagName("td")[4];
                        var idx = cell.textContent; //Request type
                        var cell = row.getElementsByTagName("td")[5];
                        var idDesc = cell.textContent; //Description

                        if (idx == "Repair") {
                            if (id == "Completed" || id == "Incomplete") {
                                window.location.href ="it_view_completed_incomplete_repair.php?requestID=" + ida;
                            }
                            if (id == "Ongoing" || id == "Pending") {
                                window.location.href = "it_view_ongoing_pending_repair.php?requestID=" + ida;
                            }
                        }
                        if (idx == "Asset Request") {
                            if (id == "Ongoing" || id == "Pending") {
                                if (idDesc == "Checking Canvas") {
                                    window.location.href = "it_view_canvas_completed.php?requestID=" + ida;
                                } else if (idDesc == "IT Create Specs") {
                                    window.location.href = "it_view_incomplete_request.php?requestID=" + ida;
                                } else if (idDesc == "Create Purchase Order") {
                                    window.location.href = "it_view_open_po.php?requestID=" + ida;
                                } else if (idDesc == "Signature Verification") {
                                    window.location.href = "it_view_signature.php?requestID=" + ida;
                                }
                            }
                            if (id == "Pending") {
                                if (idDesc == "IT Approval") {
                                    window.location.href = "it_view_approval_open.php?requestID=" + ida;
                                }
                            }
                            if (id == "Completed" || id == "Incomplete") {
                                window.location.href = "it_view_checklist.php";
                            }
                        }
                        if (idx == "Testing") {
                            if (id == "Ongoing" || id == "Pending") {
                                window.location.href = "it_view_incomplete_testing.php";
                            } else if (id == "Completed" || id == "Incomplete") {
                                window.location.href = "it_view_testing.php";
                            }
                        }
                        if (idx == "Donation") {
                            if (id == "Ongoing" || id == "Pending") {
                                window.location.href = "it_view_open_donation_request.php?id=" + ida;
                            }
                            if (id == "Completed" || id == "Incomplete") {
                                window.location.href = "it_view_closed_donation_request.php?id=" + ida;
                            }
                        }
                        if (idx == "Borrow") {
                            if (id == "Ongoing" || id == "Pending") {
                                window.location.href = "it_view_open_service_equipment_request.php?id=" + ida;
                            } else if (id == "Completed" || id == "Incomplete") {
                                window.location.href = "it_view_closed_service_equipment_request.php?id=" + ida;
                            }
                        }
                        if (idx == "Replacement") {
                            if (id == "Ongoing" || id == "Pending") {
                                if(idDesc == "Assigning of New Replacement"){
                                    window.location.href = "it_missing_form.php?id=" + ida;
                                }
                            } else if (id == "Completed" || id == "Incomplete") {
                                
                            }
                        }
                        if (idx == "Service Unit") {
                            if (id == "Pending") {
                                window.location.href = "it_request_service_unit.php?id=" + ida;
                            } else if (id == "Ongoing") {
                                window.location.href = "it_request_service_unit_ongoing.php?id=" + ida;
                            } else if (id == "Closed") {
                                window.location.href = "it_request_service_unit_closed.php?id=" + ida;
                            }
                        }
                        if (idx == "Request for Parts") {
                            if (id == "Pending") {
                                window.location.href = "it_view_repair_request_parts.php?id=" + ida;
                            } else if (id == "Ongoing") {
                                window.location.href = "it_view_repair_request_parts_ongoing.php?id=" + ida;
                            } else if (id == "Closed") {
                                window.location.href = "it_view_repair_request_parts_closed.php?id=" + ida;
                            }
                        }

                    };
                };
                currentRow.onclick = createClickHandler(currentRow);
            }
        }
        window.onload = addRowHandlers();
        window.onload = $('#count').click();
    </script>

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