<!DOCTYPE html>
<?php
	require_once('db/mysql_connect.php');
	session_start();
	$bid = $_GET['bid'];
	$acid = $_GET['acid'];
	$startDate=$_GET['sDate'];
	$endDate=$_GET['eDate'];
	$case=$_GET['caseNo'];
	
	//GET BUILDING NAME
	$queryBldgName="SELECT * FROM thesis.building where BuildingID='{$bid}'";
	$resultBldgName=mysqli_query($dbc,$queryBldgName);
	$rowBldgName=mysqli_fetch_array($resultBldgName,MYSQLI_ASSOC);
	
	
	//GET CATEGORY NAME
	$queryCatName="SELECT * FROM thesis.ref_assetcategory where assetCategoryID='{$acid}'";
	$resultCatName=mysqli_query($dbc,$queryCatName);
	$rowCatName=mysqli_fetch_array($resultCatName,MYSQLI_ASSOC);
	
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
                                                                
                                                            </div>
                                                        </form>
                                                        <div id="report">
                                                            <div class="panel-body">
                                                                <center>
                                                                    <h3>Information Technology Services Office</h3>
                                                                </center>
                                                                <center>
                                                                    <h3>Detailed Preventive Maintenance Report</h3>
                                                                </center>
                                                                <center>
                                                                    <h5>
                                                                        <br>
                                                                        <?php 
																		date_default_timezone_set('Asia/Manila');
																		$timestamp = time();
																		echo "\n"; 
																		echo(date("F d, Y h:i:s A", $timestamp)); 
																		?>
                                                                    </h5>
                                                                </center>

                                                                <div class="adv-table" id="adv-table">
                                                                    <br>
                                                                    <h4>Building: <?php echo $rowBldgName['name']; ?></h4>
																	<h4>Asset Category: <?php echo $rowCatName['name']; ?></h4>
                                                                    <br>
																	<br>
																	
																	
																	<?php
																		//Get all Floor and Room of a given Building
																		$queryGetFlRoom="SELECT * FROM thesis.floorandroom where BuildingID='{$bid}'";
																		$resultGetFlRoom=mysqli_query($dbc,$queryGetFlRoom);
																		while($rowGetFlRoom=mysqli_fetch_array($resultGetFlRoom,MYSQLI_ASSOC)){
																			//GET ALL DETAILS OF A GIVEN ROOM
																			echo "<h5><b>Room: ".$rowGetFlRoom['floorRoom']."</b></h5>
																					<br>
																					<table class='display table table-bordered table-striped' id=''>
																						<thead>
																							<tr>
																								<th>Date</th>
																								<th>Property Code</th>
																								<th>Model</th>
																								<th>Status</th>
																								<th>Comment</th>
																							</tr>
																						</thead>
																						<tbody id='maintenance'>";
																							//GET Asset of a given room
																								$queryGetAllMainData=null;
																								if($case==1){
																									$queryGetAllMainData="Select au.date,a.propertyCode,ras.description as `assetStat`,au.remarks,am.description as `modelName`
																														From assetaudit au 
																														left join asset a on au.assetID=a.assetID 
																														left join assetmodel am on a.assetModel=am.assetModelID 
																														left join ref_assetstatus ras on au.assetStatus=ras.id 
																														left join ticket t on au.ticketID=t.ticketID  
																														left JOIN assetassignment aa ON au.assetID=aa.assetID 
																														left JOIN building b ON aa.BuildingID = b.BuildingID 
																														left join floorandroom far on b.BuildingID= far.BuildingID
																														where aa.FloorAndRoomID='{$rowGetFlRoom['FloorAndRoomID']}' and t.serviceType='28' AND au.assetStatus!='17' AND au.date <= '{$endDate}' AND au.date>= '{$startDate}' and am.assetCategory='{$acid}'   
																														group by au.date,a.propertyCode
																														";
																								}
																								
																								elseif($case==3){
																									$queryGetAllMainData="Select au.date,a.propertyCode,ras.description as `assetStat`,au.remarks,am.description as `modelName`
																														From assetaudit au 
																														left join asset a on au.assetID=a.assetID 
																														left join assetmodel am on a.assetModel=am.assetModelID 
																														left join ref_assetstatus ras on au.assetStatus=ras.id 
																														left join ticket t on au.ticketID=t.ticketID  
																														left JOIN assetassignment aa ON au.assetID=aa.assetID 
																														left JOIN building b ON aa.BuildingID = b.BuildingID 
																														left join floorandroom far on b.BuildingID= far.BuildingID
																														where aa.FloorAndRoomID='{$rowGetFlRoom['FloorAndRoomID']}' and t.serviceType='28' AND au.assetStatus!='17' AND au.date <= now() AND au.date>= '{$startDate}' and am.assetCategory='{$acid}'   
																														group by au.date,a.propertyCode
																														";
																								}
																								
																								elseif($case==4){
																									$queryGetAllMainData="Select au.date,a.propertyCode,ras.description as `assetStat`,au.remarks,am.description as `modelName`
																														From assetaudit au 
																														left join asset a on au.assetID=a.assetID 
																														left join assetmodel am on a.assetModel=am.assetModelID 
																														left join ref_assetstatus ras on au.assetStatus=ras.id 
																														left join ticket t on au.ticketID=t.ticketID  
																														left JOIN assetassignment aa ON au.assetID=aa.assetID 
																														left JOIN building b ON aa.BuildingID = b.BuildingID 
																														left join floorandroom far on b.BuildingID= far.BuildingID
																														where aa.FloorAndRoomID='{$rowGetFlRoom['FloorAndRoomID']}' and t.serviceType='28' AND au.assetStatus!='17' AND au.date <= '{$endDate}' and am.assetCategory='{$acid}'    
																														group by au.date,a.propertyCode
																														";
																								}
																								
																								else{
																									$queryGetAllMainData="Select au.date,a.propertyCode,ras.description as `assetStat`,au.remarks,am.description as `modelName`
																														From assetaudit au 
																														left join asset a on au.assetID=a.assetID 
																														left join assetmodel am on a.assetModel=am.assetModelID 
																														left join ref_assetstatus ras on au.assetStatus=ras.id 
																														left join ticket t on au.ticketID=t.ticketID  
																														left JOIN assetassignment aa ON au.assetID=aa.assetID 
																														left JOIN building b ON aa.BuildingID = b.BuildingID 
																														left join floorandroom far on b.BuildingID= far.BuildingID
																														where aa.FloorAndRoomID='{$rowGetFlRoom['FloorAndRoomID']}' and t.serviceType='28' AND au.assetStatus!='17' and am.assetCategory='{$acid}'    
																														group by au.date,a.propertyCode
																														";
																								}
																								
																								$resultGetAllMainData=mysqli_query($dbc,$queryGetAllMainData);
																								
																								while($rowGetAllMainData=mysqli_fetch_array($resultGetAllMainData,MYSQLI_ASSOC)){
																									echo "<tr>
																										
																										<td>{$rowGetAllMainData['date']}</td>
																										<td>{$rowGetAllMainData['propertyCode']}</td>
																										
																										<td>{$rowGetAllMainData['modelName']}</td>
																										<td>{$rowGetAllMainData['assetStat']}</td>
																										<td>{$rowGetAllMainData['remarks']}</td>
																										
																									   </tr>";
																								   
																								}
																							
																							
																			echo "</tbody>
																					</table>
																					<br>
																					<br>";
																			
																		}
																	?>

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
        /*

        function addRowHandlers() {
            var table = document.getElementById("dynamic-table");
            var rows = table.getElementsByTagName("tr");
            for (i = 1; i < rows.length; i++) {
                var currentRow = table.rows[i];
                var createClickHandler = function(row) {
                    return function() {
                        var cell = row.getElementsByTagName("td")[0];
                        var idx = cell.textContent;

                        window.location.href = "it_inventory_specific.php?=";

                    };
                };
                currentRow.onclick = createClickHandler(currentRow);
            }
        }
        window.onload = addRowHandlers();
        */

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