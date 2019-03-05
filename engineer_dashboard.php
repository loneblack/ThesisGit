<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$userID = $_SESSION['userID'];
require_once("db/mysql_connect.php");

$query1="SELECT COUNT(*) as 'count' FROM thesis.ticket t JOIN ref_ticketstatus s ON t.status = s.ticketID WHERE t.status != 7 AND assigneeUserID = {$userID};";
$result1=mysqli_query($dbc,$query1);
while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)){ $Unresolved = $row1['count']; }

$query2="SELECT COUNT(*) as 'count' FROM thesis.ticket t JOIN ref_ticketstatus s ON t.status = s.ticketID WHERE (t.dueDate < now()) AND assigneeUserID = {$userID};";
$result2=mysqli_query($dbc,$query2);
while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){ $Overdue = $row2['count']; }   

$query3="SELECT COUNT(*) as 'count' FROM thesis.ticket t JOIN ref_ticketstatus s ON t.status = s.ticketID WHERE (DATE(t.dueDate) = DATE(now())) AND assigneeUserID = {$userID};";
$result3=mysqli_query($dbc,$query3);
while ($row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC)){ $DueToday = $row3['count']; }   

$query4="SELECT COUNT(*) as 'count' FROM thesis.ticket t JOIN ref_ticketstatus s ON t.status = s.ticketID WHERE t.status = 1 AND assigneeUserID = {$userID};";
$result4=mysqli_query($dbc,$query4);
while ($row4 = mysqli_fetch_array($result4, MYSQLI_ASSOC)){ $Open = $row4['count']; }   

$query5="SELECT COUNT(*) as 'count' FROM thesis.ticket t JOIN ref_ticketstatus s ON t.status = s.ticketID WHERE t.status = 6 AND assigneeUserID = {$userID};";
$result5=mysqli_query($dbc,$query5);
while ($row5 = mysqli_fetch_array($result5, MYSQLI_ASSOC)){ $OnHold = $row5['count']; }   

$query6="SELECT COUNT(*) as 'count' FROM thesis.ticket t JOIN ref_ticketstatus s ON t.status = s.ticketID WHERE t.priority = 'Urgent' AND assigneeUserID = {$userID};";
$result6=mysqli_query($dbc,$query6);
while ($row6 = mysqli_fetch_array($result6, MYSQLI_ASSOC)){ $Urgent = $row6['count']; }     

//CREATION OF TICKET EVERY 2 WEEKS OF FRIDAY 
$StartDate = strtotime('2019-1-4'); //Start date from which we begin count
$CurDate = date("Y-m-d"); //Current date.
$NextDate = date("Y-m-d", strtotime("+2 week", $StartDate)); //Next date = +2 week from start date
while ($CurDate > $NextDate ) { 
	$NextDate = date("Y-m-d", strtotime("+2 week", strtotime($NextDate)));
}
$everyTwoWeeks=date("Y-m-d", strtotime($NextDate)); 

if($everyTwoWeeks==$CurDate){
	//Check if there's already a maintenance ticket created at a given time
	$queryCheck="SELECT count(*) as 'isExist' FROM thesis.ticket t join engineer_assignment ea on t.assignmentID=ea.assignmentID where date(t.dateCreated) = '{$everyTwoWeeks}' and t.serviceType='28' and t.assigneeUserID='{$_SESSION['userID']}' and (ea.roomtypeID='3' or ea.roomtypeID='4')";
	$resultCheck=mysqli_query($dbc,$queryCheck);
	$rowCheck = mysqli_fetch_array($resultCheck, MYSQLI_ASSOC);

	if($rowCheck['isExist']=='0'){
		//CREATE MAINTENANCE TICKET FOR LAB AND CLASSROOM
		
		//GET EMPLOYEE ID
		$queryEmpID="SELECT * FROM thesis.employee where UserID='{$_SESSION['userID']}'";
		$resultEmpID=mysqli_query($dbc,$queryEmpID);
		$rowEmpID= mysqli_fetch_array($resultEmpID, MYSQLI_ASSOC);
		
		//GET ALL ENGINEER ASSIGNMENT FOR A GIVEN ENGINEER
		$queryEngAssMain="SELECT * FROM thesis.engineer_assignment where employeeID='{$rowEmpID['employeeID']}' and (roomtypeID='3' or roomtypeID='4')";
		$resultEngAssMain=mysqli_query($dbc,$queryEngAssMain);
		while ($rowEngAssMain = mysqli_fetch_array($resultEngAssMain, MYSQLI_ASSOC)){
			//CREATE MAINTENANCE TICKET
			$queryCreMainTicket="INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`,  `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `serviceType`, `assignmentID`, `requestedBy`) VALUES ('2', '{$_SESSION['userID']}', '{$everyTwoWeeks}', '{$everyTwoWeeks}', '{$everyTwoWeeks}', 'High', '28', '{$rowEngAssMain['assignmentID']}', '3')";
			$resultCreMainTicket=mysqli_query($dbc,$queryCreMainTicket);
			
			//GET LATEST MAINTENANCE TICKET
			$queryLatMainTicket="SELECT * FROM thesis.ticket order by ticketID desc limit 1";
			$resultLatMainTicket=mysqli_query($dbc,$queryLatMainTicket);
			$rowLatMainTicket= mysqli_fetch_array($resultLatMainTicket, MYSQLI_ASSOC);
			
			//GET ALL FLOORROOM OF A GIVEN BUILDING
			$queryGetAllFlrRm="SELECT * FROM thesis.floorandroom where BuildingID='{$rowEngAssMain['BuildingID']}' and (roomtype='3' or roomtype='4')";
			$resultGetAllFlrRm=mysqli_query($dbc,$queryGetAllFlrRm);
			while ($rowGetAllFlrRm = mysqli_fetch_array($resultGetAllFlrRm, MYSQLI_ASSOC)){
				//GET ALL ASSETS ASSIGNED ON A GIVEN FLOORROOM
				$queryAssAssFlrRoom="SELECT * FROM thesis.assetassignment aa join asset a on aa.assetID=a.assetID where aa.personresponsibleID is null and aa.FloorAndRoomID='{$rowGetAllFlrRm['FloorAndRoomID']}' and a.assetStatus='2'";
				$resultAssAssFlrRoom=mysqli_query($dbc,$queryAssAssFlrRoom);
				while ($rowAssAssFlrRoom = mysqli_fetch_array($resultAssAssFlrRoom, MYSQLI_ASSOC)){
					//INSERT TO TICKETTED ASSETS
					$queryInsTickAss="INSERT INTO `thesis`.`ticketedasset` (`ticketID`, `assetID`, `checked`) VALUES ('{$rowLatMainTicket['ticketID']}', '{$rowAssAssFlrRoom['assetID']}', false);";
					$resultInsTickAss=mysqli_query($dbc,$queryInsTickAss);
					
					//UPDATE ASSET STATUS TO FOR MAINTENANCE
					$queryStat="UPDATE `thesis`.`asset` SET `assetStatus`='17' WHERE `assetID`='{$rowAssAssFlrRoom['assetID']}'";
					$resultStat=mysqli_query($dbc,$queryStat);
				}
			}	
		}     
	}
}

//CREATION OF TICKET EVERY LAST DAY OF THE MONTH
$lastDayThisMonth = date("Y-m-t");

if($lastDayThisMonth==$CurDate){
	//Check if there's already a maintenance ticket created at a given time
	$queryCheck="SELECT count(*) as 'isExist' FROM thesis.ticket t join engineer_assignment ea on t.assignmentID=ea.assignmentID where date(t.dateCreated) = '{$lastDayThisMonth}' and t.serviceType='28' and t.assigneeUserID='{$_SESSION['userID']}' and (ea.roomtypeID='1')";
	$resultCheck=mysqli_query($dbc,$queryCheck);
	$rowCheck = mysqli_fetch_array($resultCheck, MYSQLI_ASSOC);

	if($rowCheck['isExist']=='0'){
		//CREATE MAINTENANCE TICKET FOR OFFICES
		
		//GET EMPLOYEE ID
		$queryEmpID="SELECT * FROM thesis.employee where UserID='{$_SESSION['userID']}'";
		$resultEmpID=mysqli_query($dbc,$queryEmpID);
		$rowEmpID= mysqli_fetch_array($resultEmpID, MYSQLI_ASSOC);
		
		//GET ALL ENGINEER ASSIGNMENT FOR A GIVEN ENGINEER
		$queryEngAssMain="SELECT * FROM thesis.engineer_assignment where employeeID='{$rowEmpID['employeeID']}' and (roomtypeID='1')";
		$resultEngAssMain=mysqli_query($dbc,$queryEngAssMain);
		while ($rowEngAssMain = mysqli_fetch_array($resultEngAssMain, MYSQLI_ASSOC)){
			//CREATE MAINTENANCE TICKET
			$queryCreMainTicket="INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`,  `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `serviceType`, `assignmentID`, `requestedBy`) VALUES ('2', '{$_SESSION['userID']}', '{$lastDayThisMonth}', '{$lastDayThisMonth}', '{$lastDayThisMonth}', 'High', '28', '{$rowEngAssMain['assignmentID']}', '3')";
			$resultCreMainTicket=mysqli_query($dbc,$queryCreMainTicket);
			
			//GET LATEST MAINTENANCE TICKET
			$queryLatMainTicket="SELECT * FROM thesis.ticket order by ticketID desc limit 1";
			$resultLatMainTicket=mysqli_query($dbc,$queryLatMainTicket);
			$rowLatMainTicket= mysqli_fetch_array($resultLatMainTicket, MYSQLI_ASSOC);
			
			//GET ALL FLOORROOM OF A GIVEN BUILDING
			$queryGetAllFlrRm="SELECT * FROM thesis.floorandroom where BuildingID='{$rowEngAssMain['BuildingID']}' and (roomtype='1')";
			$resultGetAllFlrRm=mysqli_query($dbc,$queryGetAllFlrRm);
			while ($rowGetAllFlrRm = mysqli_fetch_array($resultGetAllFlrRm, MYSQLI_ASSOC)){
				//GET ALL ASSETS ASSIGNED ON A GIVEN FLOORROOM
				$queryAssAssFlrRoom="SELECT * FROM thesis.assetassignment aa join asset a on aa.assetID=a.assetID where aa.personresponsibleID is null and aa.FloorAndRoomID='{$rowGetAllFlrRm['FloorAndRoomID']}' and a.assetStatus='2'";
				$resultAssAssFlrRoom=mysqli_query($dbc,$queryAssAssFlrRoom);
				while ($rowAssAssFlrRoom = mysqli_fetch_array($resultAssAssFlrRoom, MYSQLI_ASSOC)){
					//INSERT TO TICKETTED ASSETS
					$queryInsTickAss="INSERT INTO `thesis`.`ticketedasset` (`ticketID`, `assetID`, `checked`) VALUES ('{$rowLatMainTicket['ticketID']}', '{$rowAssAssFlrRoom['assetID']}', false);";
					$resultInsTickAss=mysqli_query($dbc,$queryInsTickAss);
				}
			}
		}     
	}	
}

//CREATION OF TICKET EVERY END OF TERM
$check = false;
$endOfTermDate=null;
		
$querySY="SELECT * FROM thesis.schoolyear order by SchoolYearID asc";
$resultSY=mysqli_query($dbc,$querySY);
while($rowSY=mysqli_fetch_array($resultSY, MYSQLI_ASSOC)){
	if($CurDate>=$rowSY['Term1End']&&$check==false){
		$endOfTermDate=$rowSY['Term1End'];
		$check = true;
	}
	elseif($CurDate>=$rowSY['Term2End']&&$check==false){
		$endOfTermDate=$rowSY['Term2End'];
		$check = true;
	}
	elseif($CurDate>=$rowSY['Term3End']&&$check==false){
		$endOfTermDate=$rowSY['Term3End'];
		$check = true;
	}
}

if($CurDate==$endOfTermDate){
	//Check if there's already a maintenance ticket created at a given time
	$queryCheck="SELECT count(*) as 'isExist' FROM thesis.ticket t join engineer_assignment ea on t.assignmentID=ea.assignmentID where date(t.dateCreated) = '{$lastDayThisMonth}' and t.serviceType='28' and t.assigneeUserID='{$_SESSION['userID']}' and (ea.roomtypeID='2')";
	$resultCheck=mysqli_query($dbc,$queryCheck);
	$rowCheck = mysqli_fetch_array($resultCheck, MYSQLI_ASSOC);

	if($rowCheck['isExist']=='0'){
		//CREATE MAINTENANCE TICKET FOR OFFICES
		
		//GET EMPLOYEE ID
		$queryEmpID="SELECT * FROM thesis.employee where UserID='{$_SESSION['userID']}'";
		$resultEmpID=mysqli_query($dbc,$queryEmpID);
		$rowEmpID= mysqli_fetch_array($resultEmpID, MYSQLI_ASSOC);
		
		//GET ALL ENGINEER ASSIGNMENT FOR A GIVEN ENGINEER
		$queryEngAssMain="SELECT * FROM thesis.engineer_assignment where employeeID='{$rowEmpID['employeeID']}' and (roomtypeID='2')";
		$resultEngAssMain=mysqli_query($dbc,$queryEngAssMain);
		while ($rowEngAssMain = mysqli_fetch_array($resultEngAssMain, MYSQLI_ASSOC)){
			//CREATE MAINTENANCE TICKET
			$queryCreMainTicket="INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`,  `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `serviceType`, `assignmentID`, `requestedBy`) VALUES ('2', '{$_SESSION['userID']}', '{$lastDayThisMonth}', '{$lastDayThisMonth}', '{$lastDayThisMonth}', 'High', '28', '{$rowEngAssMain['assignmentID']}', '3')";
			$resultCreMainTicket=mysqli_query($dbc,$queryCreMainTicket);
			
			//GET LATEST MAINTENANCE TICKET
			$queryLatMainTicket="SELECT * FROM thesis.ticket order by ticketID desc limit 1";
			$resultLatMainTicket=mysqli_query($dbc,$queryLatMainTicket);
			$rowLatMainTicket= mysqli_fetch_array($resultLatMainTicket, MYSQLI_ASSOC);
			
			//GET ALL FLOORROOM OF A GIVEN BUILDING
			$queryGetAllFlrRm="SELECT * FROM thesis.floorandroom where BuildingID='{$rowEngAssMain['BuildingID']}' and (roomtype='2')";
			$resultGetAllFlrRm=mysqli_query($dbc,$queryGetAllFlrRm);
			while ($rowGetAllFlrRm = mysqli_fetch_array($resultGetAllFlrRm, MYSQLI_ASSOC)){
				//GET ALL ASSETS ASSIGNED ON A GIVEN FLOORROOM
				$queryAssAssFlrRoom="SELECT * FROM thesis.assetassignment aa join asset a on aa.assetID=a.assetID where aa.personresponsibleID is null and aa.FloorAndRoomID='{$rowGetAllFlrRm['FloorAndRoomID']}' and a.assetStatus='2'";
				$resultAssAssFlrRoom=mysqli_query($dbc,$queryAssAssFlrRoom);
				while ($rowAssAssFlrRoom = mysqli_fetch_array($resultAssAssFlrRoom, MYSQLI_ASSOC)){
					//INSERT TO TICKETTED ASSETS
					$queryInsTickAss="INSERT INTO `thesis`.`ticketedasset` (`ticketID`, `assetID`, `checked`) VALUES ('{$rowLatMainTicket['ticketID']}', '{$rowAssAssFlrRoom['assetID']}', false);";
					$resultInsTickAss=mysqli_query($dbc,$queryInsTickAss);
				}
			}
		}     
	}	
}

?>
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
        <?php include 'engineer_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">


                            <div class="row">
                                <a href="#">
                                    <div class="col-md-2">
                                        <div class="mini-stat clearfix">
                                            <span class="mini-stat-icon orange"><i class="fa fa-gavel"></i></span>
                                            <div class="mini-stat-info"><br>
                                                <span><?php echo $Unresolved;?></span>
                                                Unresolved
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="#">
                                    <div class="col-md-2">
                                        <div class="mini-stat clearfix">
                                            <span class="mini-stat-icon orange"><i class="fa fa-clock-o"></i></span>
                                            <div class="mini-stat-info">
                                                <span><?php echo $Overdue;?></span>
                                                Overdue
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="#">
                                    <div class="col-md-2">
                                        <div class="mini-stat clearfix">
                                            <span class="mini-stat-icon pink"><i class="fa fa-clock-o"></i></span>
                                            <div class="mini-stat-info">
                                                <span><?php echo $DueToday;?></span>
                                                Due Today
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="#">
                                    <div class="col-md-2">
                                        <div class="mini-stat clearfix">
                                            <span class="mini-stat-icon green"><i class="fa fa-eye"></i></span>
                                            <div class="mini-stat-info">
                                                <span><?php echo $Open;?></span>
                                                Open
                                            </div>
                                        </div>
                                    </div>
                                </a>


                                <a href="#">
                                    <div class="col-md-2">
                                        <div class="mini-stat clearfix">
                                            <span class="mini-stat-icon orange"><i class="fa fa-times-circle-o"></i></span>
                                            <div class="mini-stat-info">
                                                <span><?php echo $OnHold;?></span>
                                                On Hold
                                            </div>
                                        </div>
                                    </div>
                                </a>


                                <a href="#">
                                    <div class="col-md-2">
                                        <div class="mini-stat clearfix">
                                            <span class="mini-stat-icon orange"><i class="fa fa-exclamation"></i></span>
                                            <div class="mini-stat-info">
                                                <span><?php echo $Urgent;?></span>
                                                Urgent
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>








                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">

                            <section class="panel">
                                <header class="panel-heading">
                                    Recent Tickets
                                </header>
                                <div class="panel-body">
                                    <section id="unseen">
                                        <table class="table table-bordered table-striped table-condensed table-hover" id="dynamic-table">
                                            <thead>
                                                <tr>
                                                    <td style='display: none'>ID</td>
                                                    <th>#</th>
                                                    <td style='display: none'>ServiceTypeID</td>
                                                    <th>Category</th>
                                                    <th>Updated</th>
                                                    <th>Date Needed</th>
                                                    <th>Priority</th>
                                                    <th>Status</th>
                                                    <th>Requested By</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                 <?php
                                                    $count = 1;

                                                    $query = "SELECT name, t.requestedBy, t.ticketID, (convert(aes_decrypt(au.firstName, 'Fusion') using utf8)) AS 'firstName' ,(convert(aes_decrypt(au.lastName, 'Fusion')using utf8)) AS 'lastName', lastUpdateDate, dateCreated, dateClosed, dueDate, priority,summary,
                                                             t.description, t.serviceType as 'serviceTypeID', st.serviceType,t.status as 'statusID', s.status
                                                            FROM thesis.ticket t
                                                            JOIN user au
                                                                ON t.assigneeUserID = au.UserID
                                                            JOIN ref_ticketstatus s
                                                                ON t.status = s.ticketID
                                                            JOIN ref_servicetype st
                                                                ON t.serviceType = st.id
                                                            JOIN employee e 
                                                                ON t.requestedBy = e.UserID
                                                            WHERE au.UserID = {$userID}
                                                            ORDER BY dateCreated DESC LIMIT 10;";
                                                                  
                                                    $result = mysqli_query($dbc, $query);
                                                    
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                      
                                                      echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$row['ticketID']}</td>
                                                            <td>{$count}</td>
                                                            <td style='display: none'>{$row['serviceTypeID']}</td>
                                                            <td>{$row['serviceType']}</td>
                                                            <td>{$row['lastUpdateDate']}</td>
                                                            <td>{$row['dueDate']}</td>";

                                                        if($row['priority'] == "High" || $row['priority'] == "Urgent"){
                                                            echo "<td><span class='label label-danger'>{$row['priority']}</span></td>";
                                                        }
                                                        if($row['priority'] == "Medium"){
                                                            echo "<td><span class='label label-warning'>{$row['priority']}</span></td>";
                                                        }
                                                        if($row['priority'] == "Low"){
                                                            echo "<td><span class='label label-success'>{$row['priority']}</span></td>";
                                                        }
                                                        

                                                        if($row['statusID'] == "1"){
                                                            echo "<td><span class='label label-success'>{$row['status']}</span></td>";
                                                        }
                                                        if($row['statusID'] == "2"){
                                                            echo "<td><span class='label label-default'>{$row['status']}</span></td>";
                                                        }
                                                        if($row['statusID'] == "3"){
                                                            echo "<td><span class='label label-primary'>{$row['status']}</span></td>";
                                                        }
                                                        if($row['statusID'] == "4" || $row['statusID'] == "5"){
                                                            echo "<td><span class='label label-info'>{$row['status']}</span></td>";
                                                        }
                                                        if($row['statusID'] == "6"){
                                                            echo "<td><span class='label label-warning'>{$row['status']}</span></td>";
                                                        }
                                                        if($row['statusID'] == "7"){
                                                            echo "<td><span class='label label-danger'>{$row['status']}</span></td>";
                                                        }
                                                    
                                                        echo "<td>{$row['name']}</td></tr>";

                                                          $count++;
                                                    }
                                                  ?>
                                            </tbody>
                                        </table>
                                    </section>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>

    <!-- WAG GALAWIN PLS LANG -->

    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>

    <script>
       function addRowHandlers() {
            var table = document.getElementById("dynamic-table");
            var rows = table.getElementsByTagName("tr");
            for (i = 1; i < rows.length; i++) {
                var currentRow = table.rows[i];
                var createClickHandler = function(row) {
                    return function() {
                        var cell1 = row.getElementsByTagName("td")[0];
                        var id = cell1.textContent;

                        var cell2 = row.getElementsByTagName("td")[2];
                        var serviceTypeID = cell2.textContent;

                        var cell3 = row.getElementsByTagName("td")[7];
                        var status = cell2.textContent;
                                            
                        if(serviceTypeID == '25'){
                            //asset testing
                            if(status == "Closed"){
                                window.location.href = "engineer_view_ticket_assettesting_closed.php?id=" + id;
                            }
                                
                            else{
                                window.location.href = "engineer_view_ticket_assettesting_opened.php?id=" + id;
                            }
                        }
                        
                        else if(serviceTypeID == '26'){
                            //refurbishing
                            if(status == "Closed"){
                                window.location.href = "engineer_view_ticket_refurbishing_closed.php?id=" + id;
                            }

                            else{
                                window.location.href = "engineer_view_ticket_refurbishing_opened.php?id=" + id;
                            }
                            
                        }
                        
                        else if(serviceTypeID == '27'){
                            //repair
                            if(status == "Closed"){
                                window.location.href = "engineer_view_ticket_repair_closed.php?id=" + id;
                            }
                            else{
                                window.location.href = "engineer_view_ticket_repair_opened.php?id=" + id;
                            }
                        }
                        else if(serviceTypeID == '28'){
                            //maintenance
                            if(status == "Closed"){
                                window.location.href = "engineer_view_ticket_maintenance_closed.php?id=" + id;
                            }
                            else{
                                window.location.href = "engineer_view_ticket_maintenance_opened.php?id=" + id;
                            }
                        }
                         else if(serviceTypeID == '29'){
                            //others
                            if(status == "Closed"){
                                window.location.href = "engineer_view_ticket_others_closed.php?id=" + id;
                            }
                            else{
                                window.location.href = "engineer_view_ticket_others_opened.php?id=" + id;
                            }
                        }
                         else{
                            //service
                            if(status == "Closed"){
                                window.location.href = "engineer_view_ticket_service_closed.php?id=" + id;
                            }
                            else{
                                window.location.href = "engineer_view_ticket_service_opened.php?id=" + id;
                            }
                        }
                        
                    };
                };
                currentRow.onclick = createClickHandler(currentRow);
            }
        }
        window.onload = addRowHandlers();
    </script>

    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>