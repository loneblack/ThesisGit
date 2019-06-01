<!DOCTYPE html>
<?php
	session_start();
	require_once("db/mysql_connect.php");
	$id = $_GET['id'];
	
	//GET TICKET DATA
	
	$queryTickDat ="SELECT *,CONCAT(Convert(AES_DECRYPT(lastName,'Fusion')USING utf8),' ',Convert(AES_DECRYPT(firstName,'Fusion')USING utf8)) as `fullname` FROM thesis.ticket t join user u on t.assigneeUserID=u.UserID where t.ticketID='{$id}'";
	$resultTickDat = mysqli_query($dbc, $queryTickDat);
	$rowTickDat=mysqli_fetch_array($resultTickDat,MYSQLI_ASSOC);
	
	//Update notifications
	$queryUpdNotif="UPDATE `thesis`.`notifications` SET `isRead` = true WHERE (`ticketID` = '{$id}');";
	$resultUpdNotif=mysqli_query($dbc,$queryUpdNotif);
	
	//UPDATE TICKET STATUS TO ONGOING
	$queryUpdOngStat="UPDATE `thesis`.`ticket` SET `status` = '3' WHERE (`ticketID` = '{$id}');";
	$resultUpdOngStat=mysqli_query($dbc,$queryUpdOngStat);
	
	if(isset($_POST['submit'])){
		if(isset($_POST['asset'])&&isset($_POST['remarks'])&&isset($_POST['assetStat'])){
			$asset=$_POST['asset'];
			$remarks=$_POST['remarks'];
			$assetStat=$_POST['assetStat'];
			
            //Check if there's an asset needed for repair
            if(in_array('9', $assetStat)){
                //insertion to service table
	            $queryGenRepairReq = "INSERT INTO `thesis`.`service` (`details`, `dateReceived`, `UserID`, `serviceType`, `status`, `steps`)
	                    VALUES ('Repair needed on the following assets', now(), '{$_SESSION['userID']}', '27', '1', '14');";
                $resultGenRepairReq=mysqli_query($dbc,$queryGenRepairReq);
            }
            
			$mi = new MultipleIterator();
			$mi->attachIterator(new ArrayIterator($asset));
			$mi->attachIterator(new ArrayIterator($remarks));
			$mi->attachIterator(new ArrayIterator($assetStat));
			
			foreach ( $mi as $value ) {
				list($asset, $remarks, $assetStat) = $value;
				//UPDATE ASSET STATUS
				$queryStat="UPDATE `thesis`.`asset` SET `assetStatus`='{$assetStat}' WHERE `assetID`='{$asset}'";
				$resultStat=mysqli_query($dbc,$queryStat);
				
				//INSERT TO ASSET AUDIT
				$queryAssAud="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `ticketID`, `assetStatus`) VALUES ('{$_SESSION['userID']}', now(), '{$asset}', '{$id}', '{$assetStat}');";
				$resultAssAud=mysqli_query($dbc,$queryAssAud);
					
                if($assetStat=='9'){
                     //Get Latest Repair Request
					$queryGetLatRep="SELECT * FROM thesis.service where serviceType='27' order by id desc limit 1";
					$resultGetLatRep=mysqli_query($dbc,$queryGetLatRep);
					$rowGetLatRep=mysqli_fetch_array($resultGetLatRep,MYSQLI_ASSOC);
					 
					//insert asset to service details
					$query = "INSERT INTO `thesis`.`servicedetails` (`serviceID`, `asset`) VALUES ('{$rowGetLatRep['id']}', '{$asset}');";
					$resulted = mysqli_query($dbc, $query);
                }
				elseif($assetStat=='18'){
					//GET FLOORANDROOMID AND BUILDINGID
					$queryGetAssLoc="SELECT * FROM thesis.assetassignment where assetID='{$asset}' and personresponsibleID is null";
					$resultGetAssLoc=mysqli_query($dbc,$queryGetAssLoc);
					$rowGetAssLoc=mysqli_fetch_array($resultGetAssLoc,MYSQLI_ASSOC);
					
					//SET DATE NEEDED
					$date = new DateTime(date("Y-m-d"));
					date_modify($date,"+1 day");
					$finDate = date_format($date,"Y-m-d");
					
					//INSERT INTO REPLACEMENT TABLE
					$queryInsRep = "INSERT INTO `thesis`.`replacement` (`lostAssetID`, `BuildingID`, `FloorAndRoomID`, `dateTiimeLost`, `userID`, `statusID`, `dateNeeded`, `stepID`, `remarks`) VALUES ('{$asset}', '{$rowGetAssLoc['BuildingID']}', '{$rowGetAssLoc['FloorAndRoomID']}', now(), '{$_SESSION['userID']}', '1', '{$finDate}', '26', '{$remarks}');";
					$resultInsRep = mysqli_query($dbc, $queryInsRep);
					
					//GET LATEST REPLACEMENT TABLE
					$queryGetLatRepl = "SELECT * FROM thesis.replacement order by replacementID desc limit 1;";
					$resultGetLatRepl = mysqli_query($dbc, $queryGetLatRepl);
					$rowGetLatRepl=mysqli_fetch_array($resultGetLatRepl,MYSQLI_ASSOC);
					
					//INSERT TO NOTIFICATIONS TABLE
					$sqlNotif = "INSERT INTO `thesis`.`notifications` (`steps_id`, `isRead`, `replacementID`) VALUES ('26', false, '{$rowGetLatRepl['replacementID']}');";
					$resultNotif = mysqli_query($dbc, $sqlNotif);
				}
				
				//UPDATE TINYINT OF ASSETS THAT ARE DONE AT TESTING
				$queryTickAssChk="UPDATE `thesis`.`ticketedasset` SET `checked`=true WHERE `ticketID`='{$id}' and `assetID`='{$asset}'";
				$resultTickAssChk=mysqli_query($dbc,$queryTickAssChk);
			}
			
			//UPDATE SERVICE STATUS (STILL NEEDS TO BE FIXED)
			//$queryComp="UPDATE `thesis`.`service` SET `status`='3' WHERE `id`='{$id}'";
			//$resultComp=mysqli_query($dbc,$queryComp);
			
			//CHECK IF ALL THE ASSETS ARE CHECKED 
			$queryCheckTickAss="SELECT count(assetID) as `numTickAsset`,count(IF(checked = 1, assetID, null)) as `numCheckedAsset` FROM thesis.ticketedasset where ticketID='{$id}'";
			$resultCheckTickAss=mysqli_query($dbc,$queryCheckTickAss);
			$rowCheckTickAss=mysqli_fetch_array($resultCheckTickAss,MYSQLI_ASSOC);
			
			if($rowCheckTickAss['numTickAsset']==$rowCheckTickAss['numCheckedAsset']){
				//UPDATE TICKET
				$queryTickUp="UPDATE `thesis`.`ticket` SET `status`='7', `dateClosed`=now() WHERE `ticketID`='{$id}'";
				$resultTickUp=mysqli_query($dbc,$queryTickUp);
			}
			
			$message = "Form submitted";
			$_SESSION['submitMessage'] = $message;
		}
	}

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
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datepicker/css/datepicker.css" />

    <link rel="stylesheet" type="text/css" href="js/select2/select2.css" />

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
        <?php include 'engineer_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->
				<?php 
                    if(isset($_POST['submit'])){
                        echo   "<div style='text-align:center' class='alert alert-success'>
									<strong><h3>{$message}</h3></strong>
                                </div>";

                        unset($_SESSION['submitMessage']);
					}
                ?>
                <div class="row">
                    <div class="col-sm-12">
						<form class="cmxform form-horizontal " id="signupForm" method="post" action="">
                        <div class="col-sm-8">
                            <section class="panel">
                                <header style="padding-bottom:20px" class="panel-heading wht-bg">
                                    <h4 class="gen-case" style="float:right"> <a class="btn btn-success">Open</a></h4>
                                    <h4>Service Request</h4>
                                </header>
                                <div class="panel-body ">

                                    <div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <img src="images/chat-avatar2.jpg" alt="">
                                                <strong>IT Office</strong>
                                                to
                                                <strong>me</strong>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="date"><?php echo $rowTickDat['dateCreated']; ?></p><br><br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="view-mail">
                                        <p><?php echo $rowTickDat['details']; ?></p>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="col-sm-4">

                            <section class="panel">
                                <div class="panel-body">
                                    <ul class="nav nav-pills nav-stacked labels-info ">
                                        <li>
                                            <h4>Properties</h4>
                                        </li>
                                    </ul>
                                    <div class="form" style="float:right">
                                        
                                            <div class="form-group ">
                                                <div class="form-group ">
                                                    <label for="category" class="control-label col-lg-3">Category</label>
                                                    <div class="col-lg-6">
                                                        <select class="form-control m-bot15" disabled>
                                                            <option>Request</option>
                                                            <option>Repair</option>
                                                            <option selected="selected">Maintenance</option>
                                                            <option>Replacement</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="priority" class="control-label col-lg-3">Priority</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15" disabled>
                                                        <option>Low</option>
                                                        <option>Medium</option>
                                                        <option selected="selected"><?php echo $rowTickDat['priority']; ?></option>
                                                        <option>Urgent</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="assign" class="control-label col-lg-3">Assigned</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15" disabled>
                                                        <option selected="selected"><?php echo $rowTickDat['fullname']; ?></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="assign" class="control-label col-lg-3">Status</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15">
                                                        <option selected="selected">Opened</option>
                                                        <option>Closed</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-3">Due Date</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control form-control-inline input-medium default-date-picker" size="10" type="text" value="<?php echo $rowTickDat['dueDate']; ?>" disabled />
                                                </div>
                                            </div>

                                        
                                    </div>

                                </div>
                            </section>
                        </div>
                        
                        <section class="panel">
                                <header style="padding-bottom:20px" class="panel-heading wht-bg">
                                    <h4>Assets</h4>
                                </header>
                                <div class="panel-body ">

                                    <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                        <thead>
                                            <tr>
												<th><input type='checkbox' name='select-all' id='select-all' onChange='selectAll(this);'></th>
                                                <th>Category</th>
                                                <th>Property Code</th>
                                                <th>Location</th>
                                                <th>Remarks</th>
                                                <th>Asset Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
												//GET ASSET DATA
												$queryAssDat="SELECT ta.assetID,rac.name as `categoryName`,a.propertyCode,far.floorRoom FROM thesis.ticketedasset ta join asset a on ta.assetID=a.assetID
															  join assetmodel am on a.assetModel=am.assetModelID
															  join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
															  join assetassignment aa on a.assetID=aa.assetID
															  join floorandroom far on aa.FloorAndRoomID=far.FloorAndRoomID
															  where ta.ticketID='{$id}' and ta.checked='0'and rac.name != 'User Guide Poster';";
												$resultAssDat=mysqli_query($dbc,$queryAssDat);
												while($rowAssDat=mysqli_fetch_array($resultAssDat,MYSQLI_ASSOC)){
													echo "<tr>
														<td><input type='checkbox' name='asset[]' value='{$rowAssDat['assetID']}' class='maintCheck' onChange='change(\"{$rowAssDat['assetID']}\",this);'></td>
														<td>{$rowAssDat['categoryName']}</td>
														<td>{$rowAssDat['propertyCode']}</td>
														<td>{$rowAssDat['floorRoom']}</td>
														<td><input type='text' class='form-control' placeholder='Remarks' name='remarks[]' id='remarks_".$rowAssDat['assetID']."'></td>
														<td>
														<select class='form-control' name='assetStat[]' disabled id='assetStat_".$rowAssDat['assetID']."'>";
															
														//GET ASSET Status
														
														$queryAssStat="SELECT * FROM thesis.ref_assetstatus where id='2' or id='9' or id='18'";
														$resultAssStat=mysqli_query($dbc,$queryAssStat);
														while($rowAssStat=mysqli_fetch_array($resultAssStat,MYSQLI_ASSOC)){
															echo "<option value='{$rowAssStat['id']}'>{$rowAssStat['description']}</option>";
														}
															
														echo "</select>
														</td>
													</tr>";
												}
											
											?>
                                            
                                        </tbody>
                                    </table>



                                </div>
                            </section>

                        
                        
                        <div class="col-sm-12">
                            <a href=""><button class="btn btn-success" type="submit" name="submit">Submit</button></a>
                            <button class="btn btn-danger" onclick="window.history.back()">Back</button>
                        </div>
                        
                        </form>
                        

                    </div>
                </div>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>

    <!-- WAG GALAWIN PLS LANG -->
	
	<script>
	function change(x, y) {
        var remarks = "remarks_" + x;
        var assetStat = "assetStat_" + x;

        //Is Checked
            if (y.checked == true) {
                //comments
                document.getElementById(remarks).required = true;
                document.getElementById(assetStat).disabled = false;
                

            }
            //Unchecked
            if (y.checked == false) {
                //comments
                document.getElementById(remarks).required = false;
                document.getElementById(assetStat).disabled = true;

        }
    }
	function selectAll(y) {
		//Is Checked
        if (y.checked == true) {
			for(var i=0;i<document.getElementsByClassName("maintCheck").length;i++){
				document.getElementsByClassName("maintCheck")[i].checked=true;
			}
        }
        //Unchecked
        if (y.checked == false) {
			for(var i=0;i<document.getElementsByClassName("maintCheck").length;i++){
				document.getElementsByClassName("maintCheck")[i].checked=false;
			}
        }
    }
	</script>
	
    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script src="js/jquery-ui-1.9.2.custom.min.js"></script>

    <script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>


    <script src="js/scripts.js"></script>
    <script src="js/advanced-form.js"></script>

</body>

</html>