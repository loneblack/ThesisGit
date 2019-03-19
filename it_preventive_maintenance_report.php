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
														<form>
                                                            <div class="form-group">
																<div class="row">
																	<div class="col-lg-6">
																		<label class="col-sm-6 control-label col-lg-6" for="inputSuccess">Select Roomtype</label>
																		<select class="form-control input-sm m-bot15" id="roomtype" onChange='getAllMainData();'>
																			<option value='0'>Select Roomtype</option>
																			<?php
																				//GET Roomtype
																				$queryRmType="SELECT * FROM thesis.ref_roomtype";
																				$resultRmType=mysqli_query($dbc,$queryRmType);
																				while($rowRmType=mysqli_fetch_array($resultRmType,MYSQLI_ASSOC)){
																					if($rowRmType['id']==$_SESSION['roomType']){
																						echo "<option selected value='{$rowRmType['id']}'>{$rowRmType['roomtype']}</option>";
																					}
																					else{
																						echo "<option value='{$rowRmType['id']}'>{$rowRmType['roomtype']}</option>";
																					}
																				}
																			
																			
																			
																			?>
																		</select>
																	</div>
																	<div class="col-lg-6">
																		<label class="col-sm-6 control-label col-lg-6" for="inputSuccess">Select Building</label>
																		<select class="form-control input-sm m-bot15" id="building" onChange='getAllMainData();'>
																		<option value="">Select Building</option>
																		<?php
																				//GET Building
																				$queryBuilding="SELECT * FROM thesis.building";
																				$resultBuilding=mysqli_query($dbc,$queryBuilding);
																				while($rowBuilding=mysqli_fetch_array($resultBuilding,MYSQLI_ASSOC)){
																					if($rowBuilding['BuildingID']==$_SESSION['bldg']){
																						echo "<option selected value='{$rowBuilding['BuildingID']}'>{$rowBuilding['name']}</option>";
																					}
																					else{
																						echo "<option value='{$rowBuilding['BuildingID']}'>{$rowBuilding['name']}</option>";
																					}
																					
																				}
																			
																			
																			
																		?>	
																		</select>
																	</div>
																</div>
																<div class="row">
																	<div class="col-lg-6">
																		<label class="col-sm-6 control-label col-lg-6" for="inputSuccess">Select Year</label>
																		<select class="form-control input-sm m-bot15" id="year" onChange='getAllMainData();'>
																			<option value='0'>Select Year</option>
																			<?php
																				//GET ALL EXISTING YEAR OF A GIVEN MAINTENANCE
																				$queryYear="SELECT distinct year(au.date) as `year` FROM thesis.ticket t join assetaudit au on t.ticketID=au.ticketID 
																																	  where t.serviceType='28'";
																				$resultYear=mysqli_query($dbc,$queryYear);
																				while($rowYear=mysqli_fetch_array($resultYear,MYSQLI_ASSOC)){
																					if($rowYear['year']==$_SESSION['yr']){
																						echo "<option selected value='{$rowYear['year']}'>{$rowYear['year']}</option>";
																					}
																					else{
																						echo "<option value='{$rowYear['year']}'>{$rowYear['year']}</option>";
																					}
																					
																				}
																			
																			
																			
																			?>
																			
																		</select>
																	</div>
																	<div class="col-lg-6">
																		<label class="col-sm-6 control-label col-lg-6" for="inputSuccess">Select Month</label>
																		<select class="form-control input-sm m-bot15" id="month" onChange='getAllMainData();'>
																			<option value='0'>Select Month</option>
																			<option value='1'>January</option>
																			<option value='2'>February</option>
																			<option value='3'>March</option>
																			<option value='4'>April</option>
																			<option value='5'>May</option>
																			<option value='6'>June</option>
																			<option value='7'>July</option>
																			<option value='8'>August</option>
																			<option value='9'>September</option>
																			<option value='10'>October</option>
																			<option value='11'>November</option>
																			<option value='12'>December</option>
																		</select>
																	</div>
																</div>
                                                            </div>
                                                        </form>
													
                                                        <div class="panel-body">
                                                            <center><h3>Information Technology Services Office</h3></center>
                                                            <center><h3>Preventive Maintenance Report <?php echo $_SESSION['rmType']; ?></h3></center>
                                                            <center><h5><?php 
																		date_default_timezone_set('Asia/Manila');
																		$timestamp = time();
																		echo "\n"; 
																		echo(date("F d, Y h:i:s A", $timestamp)); 
																		?> </h5></center>
                                                            <!--<center><h5>Checked By: Marvin Lao</h5></center>-->
                                                           <!-- <h5><b>W-Working/ Maintained   N-Not Working/Defective  R-Repaired/Replaced  N-None/NA  M-Missing</b></h5> -->
                                                            <div class="adv-table" id="adv-table">
                                                                <table class='display table table-bordered table-striped' id='dynamic-table'>
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Room #</th>
                                                                            <th>Property Code</th>
                                                                            <th>Asset Category</th>
                                                                            <th>Asset Status</th>
                                                                            <th>Date Checked</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id='maintenance'>
																		<?php
																		//GET ALL DATA
																		$mi = new MultipleIterator();
																		
																		
																		$mi->attachIterator(new ArrayIterator($_SESSION['room']));
																		$mi->attachIterator(new ArrayIterator($_SESSION['propertyCode']));
																		$mi->attachIterator(new ArrayIterator($_SESSION['assetCat']));
																		$mi->attachIterator(new ArrayIterator($_SESSION['assetStat']));
																		$mi->attachIterator(new ArrayIterator($_SESSION['dateChecked']));
																		
																		foreach($mi as $value){
																			list($room, $propertyCode, $assetCat, $assetStat, $dateChecked) = $value;
																			echo "<tr>
																					<td>{$room}</td>
																					<td>{$propertyCode}</td>
																					<td>{$assetCat}</td>
																					<td>{$assetStat}</td>
																					<td>{$dateChecked}</td>
																			</tr>";	
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
		function getAllMainData(){
			var getYear = document.getElementById("year").value;
			var getMonth = document.getElementById("month").value;
			var getRoomType = document.getElementById("roomtype").value;
			var getBuilding = document.getElementById("building").value;
			
			var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("maintenance").innerHTML = this.responseText;
					location.reload();
                }
            };
			
			
			if(getYear){
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
			}

		}
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