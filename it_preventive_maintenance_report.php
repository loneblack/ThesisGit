<!DOCTYPE html>
<?php
	require_once('db/mysql_connect.php');
	session_start();
	
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
    <link rel="stylesheet" href="js/data-tables/DT_bootstrap.css" />
    <link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />

    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
</head>

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

            </div>

        </header>
        <!--header end-->
        <?php include 'it_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="panel">
                                        <header class="panel-heading">
                                            Preventive Maintenance Report

                                        </header>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <section class="panel">
                                                        <form method="POST" action="">
                                                            <div class="form-group">
                                                                <div align="right">
                                                                    <button class="btn btn-primary" onclick="printContent('report')"><i class="fa fa-print"></i> Print</button>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label class="col-sm-6 control-label col-lg-6" for="inputSuccess">Start Date</label>
                                                                        <input type="date" name="startDate" id="startDate" class="form-control input-sm m-bot15" onChange="checkDate();">
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label class="col-sm-6 control-label col-lg-6" for="inputSuccess">End Date</label>
                                                                        <input type="date" name="endDate" id="endDate" class="form-control input-sm m-bot15">
                                                                    </div>
                                                                </div>
                                                                <div class="row" align="center">
                                                                    <div class="col-lg-12">
                                                                        <button type="submit" name="submit" class="btn btn-primary">Filter</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>

                                                        <div id="report">
                                                            <div class="panel-body">
                                                                <center>
                                                                    <h3>Information Technology Services Office</h3>
                                                                </center>
                                                                <center>
                                                                    <h3>Preventive Maintenance Report</h3>
                                                                </center>
                                                                <center>
                                                                    <h5>
                                                                        <?php 
																		date_default_timezone_set('Asia/Manila');
																		$timestamp = time();
																		echo "\n"; 
																		echo(date("F d, Y h:i:s A", $timestamp)); 
																		?>
                                                                    </h5>
                                                                </center>
                                                                <div class="adv-table" id="adv-table">
                                                                    <table class='display table table-bordered table-striped' id='prevMaint'>
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Building</th>
                                                                                <th>Asset Category</th>
                                                                                <th>Beginning Date Functional</th>
                                                                                <th>Broken</th>
                                                                                <th>Missing</th>
                                                                                <th>End Date Functional</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id='maintenance'>
                                                                            <?php
																			if(isset($_POST['submit'])){
																				if(!empty($_POST['startDate']) && !empty($_POST['endDate'])){
																						$startDate=$_POST['startDate'];
																						$endDate=$_POST['endDate'];
																						
																						//GET ALL DATE FROM START DATE TO END DATE
																						$queryGetAllMainData="SELECT b.BuildingID,rac.assetCategoryID,b.name AS `building`, rac.name AS `ac`,
																						COUNT(IF(au.assetStatus = 2 AND au.date <= '{$endDate}' AND au.date>= '{$startDate}', a.assetmodel, null)) + COUNT(IF(au.assetStatus = 18, a.assetmodel, null)) + COUNT(IF(au.assetStatus = 4 OR au.assetStatus = 5 or au.assetStatus =  9, a.assetmodel, null)) AS `start`,
                                                                                        COUNT(IF(au.assetStatus = 4 OR au.assetStatus = 5 or au.assetStatus =  9, a.assetmodel, null)) AS `broken`,
                                                                                        COUNT(IF(au.assetStatus = 18, a.assetmodel, null)) AS `missing`,
                                                                                        COUNT(IF(au.assetStatus = 2 AND au.date <= '{$endDate}' AND au.date>= '{$startDate}', a.assetmodel, null)) AS `end`
                                                                                        FROM ticket t
                                                                                        JOIN assetaudit au ON t.ticketID = au.ticketID
                                                                                        JOIN asset a ON au.assetID=a.assetID
                                                                                        JOIN assetmodel am ON a.assetModel=am.assetModelID
                                                                                        JOIN ref_assetcategory rac ON am.assetCategory=rac.assetCategoryID
                                                                                        JOIN ref_assetstatus ras ON au.assetStatus=ras.id 
                                                                                        JOIN assetassignment aa ON a.assetID=aa.assetID 
                                                                                        JOIN building b ON aa.BuildingID = b.buildingID
                                                                                        WHERE t.serviceType='28' AND au.assetStatus!='17'
                                                                                        GROUP BY rac.name;";
																						$resultGetAllMainData=mysqli_query($dbc,$queryGetAllMainData);
																				}
                                                                                
                                                                                elseif(empty($_POST['startDate']) && empty($_POST['endDate'])){
																						//$startDate=date("Y-m-d");
																						//$endDate=date("Y-m-d");
																						
																						$queryGetAllMainData="SELECT b.BuildingID,rac.assetCategoryID,b.name AS `building`, rac.name AS `ac`,
																						COUNT(IF(au.assetStatus = 2, a.assetmodel, null)) + COUNT(IF(au.assetStatus = 18, a.assetmodel, null)) + COUNT(IF(au.assetStatus = 4 OR au.assetStatus = 5 or au.assetStatus =  9, a.assetmodel, null)) AS `start`,
                                                                                        COUNT(IF(au.assetStatus = 4 OR au.assetStatus = 5 or au.assetStatus =  9, a.assetmodel, null)) AS `broken`,
                                                                                        COUNT(IF(au.assetStatus = 18, a.assetmodel, null)) AS `missing`,
                                                                                        COUNT(IF(au.assetStatus = 2, a.assetmodel, null)) AS `end`
                                                                                        FROM ticket t
                                                                                        JOIN assetaudit au ON t.ticketID = au.ticketID
                                                                                        JOIN asset a ON au.assetID=a.assetID
                                                                                        JOIN assetmodel am ON a.assetModel=am.assetModelID
                                                                                        JOIN ref_assetcategory rac ON am.assetCategory=rac.assetCategoryID
                                                                                        JOIN ref_assetstatus ras ON au.assetStatus=ras.id 
                                                                                        JOIN assetassignment aa ON a.assetID=aa.assetID 
                                                                                        JOIN building b ON aa.BuildingID = b.buildingID
                                                                                        WHERE t.serviceType='28' AND au.assetStatus!='17'
                                                                                        GROUP BY rac.name;";
																						$resultGetAllMainData=mysqli_query($dbc,$queryGetAllMainData);
																				}
                                                                                
                                                                                elseif(!empty($_POST['startDate']) && empty($_POST['endDate'])){
																						$startDate=$_POST['startDate'];
																						$endDate=date("Y-m-d");
																						
																						$queryGetAllMainData="SELECT b.BuildingID,rac.assetCategoryID,b.name AS `building`, rac.name AS `ac`,
																						COUNT(IF(au.assetStatus = 2 AND au.date >= '{$startDate}' AND au.date <= '{$endDate}', a.assetmodel, null)) + COUNT(IF(au.assetStatus = 18, a.assetmodel, null)) + COUNT(IF(au.assetStatus = 4 OR au.assetStatus = 5 or au.assetStatus =  9, a.assetmodel, null)) AS `start`,
                                                                                        COUNT(IF(au.assetStatus = 4 OR au.assetStatus = 5 or au.assetStatus =  9, a.assetmodel, null)) AS `broken`,
                                                                                        COUNT(IF(au.assetStatus = 18, a.assetmodel, null)) AS `missing`,
                                                                                        COUNT(IF(au.assetStatus = 2 AND au.date >= '{$startDate}' AND au.date <= '{$endDate}', a.assetmodel, null)) AS `end`
                                                                                        FROM ticket t
                                                                                        JOIN assetaudit au ON t.ticketID = au.ticketID
                                                                                        JOIN asset a ON au.assetID=a.assetID
                                                                                        JOIN assetmodel am ON a.assetModel=am.assetModelID
                                                                                        JOIN ref_assetcategory rac ON am.assetCategory=rac.assetCategoryID
                                                                                        JOIN ref_assetstatus ras ON au.assetStatus=ras.id 
                                                                                        JOIN assetassignment aa ON a.assetID=aa.assetID 
                                                                                        JOIN building b ON aa.BuildingID = b.buildingID
                                                                                        WHERE t.serviceType='28' AND au.assetStatus!='17'
                                                                                        GROUP BY rac.name;";
																						$resultGetAllMainData=mysqli_query($dbc,$queryGetAllMainData);
																				}
																				
																				elseif(empty($_POST['startDate']) && !empty($_POST['endDate'])){
																						//$startDate=$_POST['startDate'];
																						$endDate=date("Y-m-d");
																						
																						$queryGetAllMainData="SELECT b.BuildingID,rac.assetCategoryID,b.name AS `building`, rac.name AS `ac`,
																						COUNT(IF(au.assetStatus = 2 AND au.date <= '{$endDate}', a.assetmodel, null)) + COUNT(IF(au.assetStatus = 18, a.assetmodel, null)) + COUNT(IF(au.assetStatus = 4 OR au.assetStatus = 5 or au.assetStatus =  9, a.assetmodel, null)) AS `start`,
                                                                                        COUNT(IF(au.assetStatus = 4 OR au.assetStatus = 5 or au.assetStatus =  9, a.assetmodel, null)) AS `broken`,
                                                                                        COUNT(IF(au.assetStatus = 18, a.assetmodel, null)) AS `missing`,
                                                                                        COUNT(IF(au.assetStatus = 2 AND au.date <= '{$endDate}', a.assetmodel, null)) AS `end`
                                                                                        FROM ticket t
                                                                                        JOIN assetaudit au ON t.ticketID = au.ticketID
                                                                                        JOIN asset a ON au.assetID=a.assetID
                                                                                        JOIN assetmodel am ON a.assetModel=am.assetModelID
                                                                                        JOIN ref_assetcategory rac ON am.assetCategory=rac.assetCategoryID
                                                                                        JOIN ref_assetstatus ras ON au.assetStatus=ras.id 
                                                                                        JOIN assetassignment aa ON a.assetID=aa.assetID 
                                                                                        JOIN building b ON aa.BuildingID = b.buildingID
                                                                                        WHERE t.serviceType='28' AND au.assetStatus!='17'
                                                                                        GROUP BY rac.name;";
																						$resultGetAllMainData=mysqli_query($dbc,$queryGetAllMainData);
																				}
																				
                                                                               $count = 1; while($rowGetAllMainData=mysqli_fetch_array($resultGetAllMainData,MYSQLI_ASSOC)){
                                                                                    
                                                                                    echo "<tr>
																						<td style='display: none'>{$rowGetAllMainData['BuildingID']}</td>
																						<td style='display: none'>{$rowGetAllMainData['assetCategoryID']}</td>
                                                                                        <td>{$count}</td>
																						<td>{$rowGetAllMainData['building']}</font></td>
																						<td>{$rowGetAllMainData['ac']}</td>
																						<td>{$rowGetAllMainData['start']}</td>
																						<td>{$rowGetAllMainData['broken']}</td>
																						<td>{$rowGetAllMainData['missing']}</td>
                                                                                        <td>{$rowGetAllMainData['end']}</td>
																					   </tr>";
                                                                                   $count++;
																				}
																			}
																		?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </section>
                                                </div>
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

    <script>
        function myFunction() {
            window.print();
        }

        function checkDate() {
            var startDate = document.getElementById("startDate").value;
            var endDate = document.getElementById("endDate");
            endDate.setAttribute("min", startDate);
        }

        function getAllMainData() {
            /*var getYear = document.getElementById("year").value;
            var getMonth = document.getElementById("month").value;
            var getRoomType = document.getElementById("roomtype").value;
            var getBuilding = document.getElementById("building").value;*/

            /*var startDate = document.getElementById("startDate").value;
			var endDate = document.getElementById("endDate").value;
			
			var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("maintenance").innerHTML = this.responseText;
					location.reload();
                }
            };
			
			if(startDate){
				if(endDate){
					xmlhttp.open("GET", "getMaintenanceData.php?startDate=" + startDate + "&endDate=" + endDate, true);
					xmlhttp.send();
				}
				else{
					xmlhttp.open("GET", "getMaintenanceData.php?startDate=" + startDate + "&endDate=", true);
					xmlhttp.send();
				}
			}
			else if(endDate){
				xmlhttp.open("GET", "getMaintenanceData.php?startDate=" +  + "&endDate=" + endDate, true);
				xmlhttp.send();
			}
			else{
				xmlhttp.open("GET", "getMaintenanceData.php?startDate=" +  + "&endDate=" + , true);
				xmlhttp.send();
			}
			*/
            /*if(getYear){
            	if(getMonth){
            		if(getRoomType){
            			if(getBuilding){
            				//YEAR,MONTH,ROOMTYPE,BUILDING
            				xmlhttp.open("GET", "getMaintenanceData.php?year=" + getYear + "&month=" + getMonth + "&roomtype=" + getRoomType + "&building=" + getBuilding, true);
            				xmlhttp.send();
            			}
            			else{
            				//YEAR,MONTH,ROOMTYPE
            				xmlhttp.open("GET", "getMaintenanceData.php?year=" + getYear + "&month=" + getMonth + "&roomtype=" + getRoomType, true);
            				xmlhttp.send();
            			}
            		}
            		else if(getBuilding){
            			//YEAR,MONTH,BUILDING
            			xmlhttp.open("GET", "getMaintenanceData.php?year=" + getYear + "&month=" + getMonth + "&building=" + getBuilding, true);
            			xmlhttp.send();
            		}
            		else{
            			//YEAR,MONTH
            			xmlhttp.open("GET", "getMaintenanceData.php?year=" + getYear + "&month=" + getMonth, true);
            			xmlhttp.send();
            		}
            	}
            	else if(getRoomType){
            		if(getBuilding){
            			//YEAR,ROOMTYPE,BUILDING
            			xmlhttp.open("GET", "getMaintenanceData.php?year=" + getYear + "&roomtype=" + getRoomType + "&building=" + getBuilding, true);
            			xmlhttp.send();
            		}
            		else{
            			//YEAR,ROOMTYPE
            			xmlhttp.open("GET", "getMaintenanceData.php?year=" + getYear + "&roomtype=" + getRoomType, true);
            			xmlhttp.send();
            		}
            	}
            	else if(getBuilding){
            		//YEAR,BUILDING
            		xmlhttp.open("GET", "getMaintenanceData.php?year=" + getYear + "&building=" + getBuilding, true);
            		xmlhttp.send();
            		
            	}
            	else{
            		//YEAR
            		xmlhttp.open("GET", "getMaintenanceData.php?year=" + getYear, true);
            		xmlhttp.send();
            	}
            }
            else if(getMonth){
            	if(getRoomType){
            		if(getBuilding){
            			//MONTH,ROOMTYPE,BUILDING
            			xmlhttp.open("GET", "getMaintenanceData.php?month=" + getMonth + "&roomtype=" + getRoomType + "&building=" + getBuilding, true);
            			xmlhttp.send();
            			
            		}
            		else{
            			//MONTH,ROOMTYPE
            			xmlhttp.open("GET", "getMaintenanceData.php?month=" + getMonth + "&roomtype=" + getRoomType, true);
            			xmlhttp.send();
            		}
            	}
            	else if(getBuilding){
            		//MONTH,BUILDING
            		xmlhttp.open("GET", "getMaintenanceData.php?month=" + getMonth + "&building=" + getBuilding, true);
            		xmlhttp.send();
            	}
            	else{
            		//MONTH
            		xmlhttp.open("GET", "getMaintenanceData.php?month=" + getMonth, true);
            		xmlhttp.send();
            	}
            }
            else if(getRoomType){
            	if(getBuilding){
            		//ROOMTYPE,BUILDING
            		xmlhttp.open("GET", "getMaintenanceData.php?roomtype=" + getRoomType + "&building=" + getBuilding, true);
            		xmlhttp.send();
            	}
            	else{
            		//ROOMTYPE
            		console.log(""+getRoomType);
            		xmlhttp.open("GET", "getMaintenanceData.php?roomtype=" + getRoomType, true);
            		xmlhttp.send();
            	}
            }
            else if(getBuilding){
            	//BUILDING
            	xmlhttp.open("GET", "getMaintenanceData.php?building=" + getBuilding, true);
            	xmlhttp.send();
			
            }
            else{
            	//DEFAULT
            	xmlhttp.open("GET", "getMaintenanceData.php", true);
            	xmlhttp.send();
            }*/

        }

        function addRowHandlers() {
            var table = document.getElementById("prevMaint");
            var rows = table.getElementsByTagName("tr");
            for (i = 1; i < rows.length; i++) {
                var currentRow = table.rows[i];
                var createClickHandler = function(row) {
                    return function() {
                        var cell = row.getElementsByTagName("td")[0];
                        var bid = cell.textContent;
						var cell1 = row.getElementsByTagName("td")[1];
                        var acid = cell1.textContent;

                        window.location.href = "it_preventive_maintenance_report_detailed.php?bid=" + bid + "&&acid=" + acid;

                    };
                };
                currentRow.onclick = createClickHandler(currentRow);
            }
        }
        window.onload = addRowHandlers();

        function printContent(el) {
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
        }
    </script>

    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>
    <script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
    <script src="js/dynamic_table_init.js"></script>

    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>



</body>

</html>