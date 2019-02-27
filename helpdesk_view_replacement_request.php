<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	$replacementID=$_GET['id'];
	
	//GET Replacement Request Data
	$queryGetRepData="SELECT * FROM thesis.replacement r join asset a on r.lostAssetID=a.assetID
							join assetmodel am on a.assetModel=am.assetModelID
							where r.replacementID='{$replacementID}'";
    $resultGetRepData=mysqli_query($dbc,$queryGetRepData);
	$rowGetRepData=mysqli_fetch_array($resultGetRepData,MYSQLI_ASSOC);
	
	if(isset($_POST['submit'])){
		$message=null;
		
		$category=$_POST['category'];
		$status=$_POST['status'];
		$priority=$_POST['priority'];
		$assigned=$_POST['assigned'];
		$dueDate=$_POST['dueDate'];
		
		//INSERT ASSET TESTING
		$queryAssTest="INSERT INTO `thesis`.`assettesting` (`statusID`, `PersonRequestedID`, `serviceType`, `remarks`, `replacementID`) VALUES ('1', '{$rowGetRepData['userID']}', '25', 'Replacement', '{$replacementID}');";
		$resultAssTest=mysqli_query($dbc,$queryAssTest);
			
		//GET LATEST ASSET TEST
		$queryLatAssTest="SELECT * FROM `thesis`.`assettesting` order by testingID desc limit 1";
		$resultLatAssTest=mysqli_query($dbc,$queryLatAssTest);
		$rowLatAssTest=mysqli_fetch_array($resultLatAssTest,MYSQLI_ASSOC);	
		
		//UPDATE ASSET STATUS
		$queryUpdAssStat="UPDATE `thesis`.`asset` SET `assetStatus`='8' WHERE `assetID`='{$rowGetRepData['replacementAssetID']}'";
		$resultUpdAssStat=mysqli_query($dbc,$queryUpdAssStat);
		
		//Insert to assettesting_details table
		$queryAssTest="INSERT INTO `thesis`.`assettesting_details` (`assettesting_testingID`, `asset_assetID`) VALUES ('{$rowLatAssTest['testingID']}', '{$rowGetRepData['replacementAssetID']}')";
		$resultAssTest=mysqli_query($dbc,$queryAssTest);
		
		//Create ticket
		$queryCreTick="INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `testingID`, `serviceType`) VALUES ('{$status}', '{$assigned}', '{$_SESSION['userID']}', now(), now(), '{$dueDate}', '{$priority}', '{$rowLatAssTest['testingID']}', '{$category}')";
		$resultCreTick=mysqli_query($dbc,$queryCreTick);
				
		//Get Latest ticket
		$queryLatTick="SELECT * FROM `thesis`.`ticket` order by ticketID desc limit 1";
		$resultLatTick=mysqli_query($dbc,$queryLatTick);
		$rowLatTick=mysqli_fetch_array($resultLatTick,MYSQLI_ASSOC);
				
		//Select Asset testingID
		$queryGetAssTestDet="SELECT * FROM thesis.assettesting_details where assettesting_testingID='{$rowLatAssTest['testingID']}'";
		$resultGetAssTestDet=mysqli_query($dbc,$queryGetAssTestDet);
		while($rowGetAssTestDet=mysqli_fetch_array($resultGetAssTestDet,MYSQLI_ASSOC)){
			$queryInsTickAss="INSERT INTO `thesis`.`ticketedasset` (`ticketID`, `assetID`) VALUES ('{$rowLatTick['ticketID']}', '{$rowGetAssTestDet['asset_assetID']}');";
			$resultInsTickAss=mysqli_query($dbc,$queryInsTickAss);
		}
		
		$message = "Form submitted!";
		$_SESSION['submitMessage'] = $message;
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
        <?php include 'helpdesk_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->
				<?php
                    if (isset($_SESSION['submitMessage'])){

                        echo "<div class='alert alert-success'>
                                {$_SESSION['submitMessage']}
							  </div>";
                        unset($_SESSION['submitMessage']);
                    }
				?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">

                            <section class="panel">
                                <header class="panel-heading">
                                    Replacement Request
                                </header>
                                <div style="padding-top:10px; padding-left:10px; float:left">
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Send For Testing</button>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="myModal" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Send For Testing</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form">
                                                    <form class="cmxform form-horizontal" id="signupForm" method="post">
                                                        <div class="form-group ">
                                                            <div class="form-group ">
                                                                <label for="category" class="control-label col-lg-3">Category</label>
                                                                <div class="col-lg-6">
                                                                    <select class="form-control m-bot15" name="category" value="<?php if (isset($_POST['category']) && !$flag) echo $_POST['category']; ?>" required readonly>
																		<?php
																			
																			$querya="SELECT * FROM thesis.ref_servicetype";
																			$resulta=mysqli_query($dbc,$querya);
																			while($rowa=mysqli_fetch_array($resulta,MYSQLI_ASSOC)){
																				if($rowa['id']=='25'){
																					echo "<option value='{$rowa['id']}' selected>{$rowa['serviceType']}</option>";
																				}
																				else{
																					echo "<option value='{$rowa['id']}'>{$rowa['serviceType']}</option>";
																				}
																			}
																		
																		?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <label for="status" class="control-label col-lg-3">Status</label>
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-bot15" name="status" value="<?php if (isset($_POST['status']) && !$flag) echo $_POST['status']; ?>" required readonly>
																	<?php
																			
																		$queryb="SELECT * FROM thesis.ref_ticketstatus";
																		$resultb=mysqli_query($dbc,$queryb);
																		while($rowb=mysqli_fetch_array($resultb,MYSQLI_ASSOC)){
																			if($rowb['ticketID']=='2'){
																				echo "<option value='{$rowb['ticketID']}' selected>{$rowb['status']}</option>";
																			}
																			else{
																				echo "<option value='{$rowb['ticketID']}'>{$rowb['status']}</option>";
																			}
																		}
																		
																	?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="priority" class="control-label col-lg-3">Priority</label>
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-bot15" name="priority" value="<?php if (isset($_POST['priority']) && !$flag) echo $_POST['priority']; ?>" required readonly>
                                                                    <option value='Low'>Low</option>
                                                                    <option value='Medium'>Medium</option>
                                                                    <option value='High'>High</option>
                                                                    <option value='Urgent' selected>Urgent</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group ">
                                                            <label for="assign" class="control-label col-lg-3">Assigned</label>
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-bot15" name="assigned" value="<?php if (isset($_POST['assigned']) && !$flag) echo $_POST['assigned']; ?>" required>
																	<?php
																		$query3="SELECT u.UserID,CONCAT(Convert(AES_DECRYPT(lastName,'Fusion')USING utf8),', ',Convert(AES_DECRYPT(firstName,'Fusion')USING utf8)) as `fullname` FROM thesis.user u join thesis.ref_usertype rut on u.userType=rut.id where rut.description='Engineer'";
																		$result3=mysqli_query($dbc,$query3);
																		
																		while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC)){
																			echo "<option value='{$row3['UserID']}'>{$row3['fullname']}</option>";
																		}										
																	
																	?>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">Due Date</label>
                                                            <div class="col-lg-6">
                                                                <!-- class="form-control form-control-inline input-medium default-date-picker" -->
                                                                <input class="form-control m-bot15" size="10" name="dueDate" type="date" value="<?php echo $rowGetRepData['dateNeeded']; ?>" max="<?php echo $rowGetRepData['dateNeeded']; ?>" required />
                                                            </div>
                                                        </div>
																
                                                        <button type="submit" class="btn btn-success" name="submit">Update</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--                                MODAL END-->

                                <div class="panel-body">
									<form method="post" action="<?php echo $_SERVER['PHP_SELF']." ?id=".$replacementID; ?>">
                                    <section id="unseen">
										<br>
										<br>
                                        <h4>Items Missing</h4>
                                        <div class="adv-table">
                                            <table class="table table-bordered table-striped table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Property Code</th>
                                                        <th>Brand</th>
                                                        <th>Model</th>
                                                        <th>Specifications</th>
                                                        <th>Location</th>
                                                        <th>Comments</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
													<?php
														//GET ITEMS MISSING 
														$queryGetItMis="SELECT am.assetCategory,a.propertyCode,rb.name as `brandName`,rac.name as `assetCatName`,am.itemSpecification,am.description as `modelName`,b.name as `buildingName`,far.floorRoom,r.remarks FROM thesis.replacement r join asset a on r.lostAssetID=a.assetID
																		   join assetmodel am on a.assetModel=am.assetModelID
																		   join ref_brand rb on am.brand=rb.brandID
																		   join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																		   join floorandroom far on r.FloorAndRoomID=far.FloorAndRoomID
																		   join building b on r.BuildingID=b.BuildingID
																		   where r.replacementID='{$replacementID}'";
                                                        $resultGetItMis=mysqli_query($dbc,$queryGetItMis);
                                                        while($rowGetItMis=mysqli_fetch_array($resultGetItMis,MYSQLI_ASSOC)){
															echo "<tr>
																	  <td>{$rowGetItMis['propertyCode']}</td>
																	  <td>{$rowGetItMis['brandName']}</td>
																	  <td>{$rowGetItMis['modelName']}</td>
																	  <td>{$rowGetItMis['itemSpecification']}</td>
																	  <td>".$rowGetItMis['buildingName']." ".$rowGetItMis['floorRoom']."</td>
																	  <td>{$rowGetItMis['remarks']}</td>
																  </tr>";
														}
													?>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <h4>Items Replacing Missing Items</h4>
                                        <div class="adv-table">
                                            <table class="table table-bordered table-striped table-condensed table-hover " id="">
                                                <thead>
                                                    <tr>
														<th></th>
                                                        <th>Property Code</th>
                                                        <th>Brand</th>
                                                        <th>Model</th>
                                                        <th>Specifications</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
													<?php
														
														
														
														//GET ASSETS BASED ON THE ASSET CATEGORY OF THE LOST ASSET
														$queryGetAllAss="SELECT *,rb.name as `brandName`,am.description as `modelName`,rac.name as `assetCatName`,am.itemSpecification as `modelSpec`,ras.description as `assetStat` FROM thesis.asset a left join assetmodel am on a.assetModel=am.assetModelID
																			left join ref_brand rb on am.brand=rb.brandID
																			left join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																			left join ref_assetstatus ras on a.assetStatus=ras.id 
																			where am.assetCategory='{$rowGetRepData['assetCategory']}' and a.assetStatus='1'";
                                                        $resultGetAllAss=mysqli_query($dbc,$queryGetAllAss);
                                                        while($rowGetAllAss=mysqli_fetch_array($resultGetAllAss,MYSQLI_ASSOC)){
															if($rowGetAllAss['assetID']==$rowGetRepData['replacementAssetID']){
																echo "<tr>
																		<td><input type='radio' name='replacedAsset' checked readonly value='{$rowGetAllAss['assetID']}'></td>
																		<td>{$rowGetAllAss['propertyCode']}</td>
																		<td>{$rowGetAllAss['brandName']}</td>
																		<td>{$rowGetAllAss['modelName']}</td>
																		<td>{$rowGetAllAss['itemSpecification']}</td>
																	</tr>";
															}
														}	
													?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-success">Submit</button>
                                        <button class="btn btn-danger">Back</button>
                                    </section>
									</form>
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

    <script>
        function checkvalue(val) {
            if (val === "25")
                document.getElementById('others').style.display = 'block';
            else
                document.getElementById('others').style.display = 'none';
        }
    </script>

    <!-- WAG GALAWIN PLS LANG -->

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