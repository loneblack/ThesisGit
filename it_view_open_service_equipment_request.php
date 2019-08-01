<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$_SESSION['recommAsset']=array();
$id = $_GET['id'];//get the id of the selected service request
$_SESSION['id'] = $_GET['id'];

require_once("db/mysql_connect.php");

$query =  "SELECT *, o.Name AS 'office', d.name AS 'department', org.name AS 'organization', b.name AS 'building'
              FROM thesis.request_borrow r 
              LEFT JOIN department d ON r.DepartmentID = d.DepartmentID 
              LEFT JOIN offices o ON r.officeID = o.officeID
              LEFT JOIN organization org ON r.organizationID = org.id
              JOIN employee e ON personresponsibleID = e.UserID
              JOIN building b ON r.BuildingID = b.Buildingid
              JOIN floorandroom f ON r.FloorAndRoomID = f.FloorAndRoomID
              JOIN ref_status s ON r.statusID = s.statusID
              JOIN ref_steps t ON r.steps = t.id
              WHERE borrowID = {$id};";
$result = mysqli_query($dbc, $query);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    
        $office = $row['office'];      
        $department = $row['department'];      
        $organization = $row['organization'];      
        $contactNo = $row['contactNo'];         
        $startDate = $row['startDate'];         
        $endDate = $row['endDate'];         
        $purpose = $row['purpose'];         
        $building = $row['building'];        
        $floorRoom = $row['floorRoom'];         
        $personresponsibleID = $row['personresponsibleID'];           
        $personrepresentativeID = $row['personrepresentativeID'];      
        $personrepresentative = $row['personrepresentative'];        
        $description = $row['description'];      

    }
$category = array();
$quantity = array();
$assetCat = array();
$remarks = array();

$query2 =  "SELECT * FROM thesis.borrow_details d
            JOIN ref_assetcategory c ON d.assetCategoryID = c.assetCategoryID
            WHERE borrowID = {$id};";
$result2 = mysqli_query($dbc, $query2);

while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
    array_push($category, $row2['name']);
    array_push($quantity, $row2['quantity']);
	array_push($assetCat, $row2['assetCategoryID']);
	array_push($remarks, $row2['purpose']);
}	

	if(isset($_POST['send'])){
		if(!empty($_POST['recommAsset'])){
			$_SESSION['recommAsset']=$_POST['recommAsset'];
		}
	}

    if(isset($_POST['approveBtn'])){
		//Update notifications
		$queryUpdNotif="UPDATE `thesis`.`notifications` SET `isRead` = true WHERE `borrowID` = '{$id}' and `steps_id`='12'";
		$resultUpdNotif=mysqli_query($dbc,$queryUpdNotif);
		
		$propCode=$_POST['propCode'];
		$a=sizeOf($propCode);
		
		//Update status,steps
        $query="UPDATE `thesis`.`request_borrow` SET `statusID` = '2', `steps`='9' WHERE (`borrowID` = '{$id}');";
        $result=mysqli_query($dbc,$query);
	   
		//INSERT TO NOTIFICATIONS TABLE
		$sqlNotif = "INSERT INTO `thesis`.`notifications` (`borrowID`, `steps_id`, `isRead`) VALUES ('{$id}', '9', false);";
		$resultNotif = mysqli_query($dbc, $sqlNotif);
	   
        //insert to assset testing
        $queryTest="INSERT INTO `thesis`.`assettesting` (`statusID`, `PersonRequestedID`, `remarks`, `serviceType`, `borrowID`)
                            VALUES ('1', '{$personresponsibleID}', 'Borrow', '25', '{$id}');";
        $resultTest=mysqli_query($dbc,$queryTest);

        $selectQuery = "SELECT * FROM thesis.assettesting ORDER BY testingID DESC LIMIT 1;";
        $resultQuery = mysqli_query($dbc,$selectQuery);
        while ($row = mysqli_fetch_array($resultQuery, MYSQLI_ASSOC)){
            $testingID = $row['testingID'];
        }
		
		//Insert recommended asset
		foreach($_POST['recommAss'] as $recommAsset){
			
			//GET ASSET INFO
			$queryGetAssInf="SELECT * FROM thesis.asset a join assetmodel am on a.assetModel=am.assetModelID where a.assetID='{$recommAsset}'";
			$resultGetAssInf=mysqli_query($dbc,$queryGetAssInf);
			$rowGetAssInf = mysqli_fetch_array($resultGetAssInf, MYSQLI_ASSOC);
			
			//GET BORROWDETTAILSID
			$queryBorDat="SELECT * FROM thesis.borrow_details bd where bd.borrowID='{$id}' and bd.assetCategoryID='{$rowGetAssInf['assetCategory']}'";
			$resultBorDat=mysqli_query($dbc,$queryBorDat);
			$rowBorDat=mysqli_fetch_array($resultBorDat,MYSQLI_ASSOC);
			
			//INSERT TO BORROWDETAILSITEM
			$queryInsBor="INSERT INTO `thesis`.`borrow_details_item` (`borrow_detailsID`, `assetID`) VALUES ('{$rowBorDat['borrow_detailscol']}', '{$recommAsset}');";
			$resultInsBor=mysqli_query($dbc,$queryInsBor);
			
			//INSERT TO asset testing details
            $queryDetails = "INSERT INTO assettesting_details (`assettesting_testingID`, `asset_assetID`) VALUES ('{$testingID}', '{$recommAsset}');";
            $resultDetails = mysqli_query($dbc,$queryDetails);

            //update asset status
            $QAssetStatus = "UPDATE `thesis`.`asset` SET `assetStatus` = '8' WHERE (`assetID` = '{$recommAsset}');";
            $RAssetStatus = mysqli_query($dbc,$QAssetStatus);
			
			//INSERT TO ASSET AUDIT
			$queryAssAud="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `assetStatus`) VALUES ('{$_SESSION['userID']}', now(), '{$recommAsset}', '8');";
			$resultAssAud=mysqli_query($dbc,$queryAssAud);
		}
		
		/* Backup Code
		foreach($propCode as $asset){
			//INSERT TO asset testing details
            $queryDetails = "INSERT INTO assettesting_details (`assettesting_testingID`, `asset_assetID`) VALUES ('{$testingID}', '{$asset}');";
            $resultDetails = mysqli_query($dbc,$queryDetails);

            //update asset status
            $QAssetStatus = "UPDATE `thesis`.`asset` SET `assetStatus` = '8' WHERE (`assetID` = '{$asset}');";
            $RAssetStatus = mysqli_query($dbc,$QAssetStatus);

			
		}
		if(!empty($_POST['assetCatBor1'])&&!empty($_POST['propCode1'])){
			$assetCatBor1=$_POST['assetCatBor1'];
			$propCode1=$_POST['propCode1'];
			foreach($propCode1 as $asset1){
				//INSERT TO asset testing details
				$queryAssAss="INSERT INTO `thesis`.`assettesting_details` (`assettesting_testingID`, `asset_assetID`) VALUES ('{$testingID}', '{$asset1}')";
				$resultAssAss=mysqli_query($dbc,$queryAssAss);

                //update asset status
                $QAssetStatus = "UPDATE `thesis`.`asset` SET `assetStatus` = '8' WHERE (`assetID` = '{$asset1}');";
                $RAssetStatus = mysqli_query($dbc,$QAssetStatus);
			}
		}
		*/
		
		$message = "Form submitted!";
		$_SESSION['submitMessage'] = $message; 
		
        header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/it_view_open_service_equipment_request.php?id=".$_SESSION['id']);
    }
    elseif(isset($_POST['denyBtn'])){
		//Update notifications
		$queryUpdNotif="UPDATE `thesis`.`notifications` SET `isRead` = true WHERE `borrowID` = '{$id}' and `steps_id`='12'";
		$resultUpdNotif=mysqli_query($dbc,$queryUpdNotif);
		
        $query="UPDATE `thesis`.`request_borrow` SET `statusID` = '6', `steps`='20', `reasForDisapprov`='{$_POST['reasOfDisapprov']}' WHERE (`borrowID` = '{$id}');";
        $result=mysqli_query($dbc,$query);
		
		//INSERT TO NOTIFICATIONS TABLE
		$sqlNotif = "INSERT INTO `thesis`.`notifications` (`borrowID`, `steps_id`, `isRead`) VALUES ('{$id}', '20', false);";
		$resultNotif = mysqli_query($dbc, $sqlNotif);
		
		$message = "Form submitted!";
		$_SESSION['submitMessage'] = $message; 
        header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/it_view_open_service_equipment_request.php?id=".$_SESSION['id']);
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
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        Service Equipment Request
                                    </header>
                                    <?php
                                        if (isset($_SESSION['submitMessage'])){

                                            echo "<div style='text-align:center' class='alert alert-success'><h5><strong>
                                                    {$_SESSION['submitMessage']}
                                                  </strong></h5></div>";

                                            unset($_SESSION['submitMessage']);
                                        }
                                    ?>
                                    <div class="panel-body">
                                        <div class="form" method="post">
                                            <a href="it_requests.php"><button type="button" class="btn btn-danger"><strong>
                                                         Back</strong> </button> </a> <h4 style="float: right;">Status:
                                                            <?php 
                                            if($description=='Pending'){
                                                echo "<span class='label label-warning'>{$description}</span>";
                                            }
                                            elseif($description=='Disapproved'){
                                                echo "<span class='label label-danger'>{$description}</span>";
                                            }
                                            else{
                                                echo "<span class='label label-success'>Approved</span>";
                                            } ?>
                                                            </h4>
                                                            <form class="cmxform form-horizontal " id="signupForm" method="post">
                                                                <div class="form-group ">
                                                                    <label for="serviceType" class="control-label col-lg-3">Office/Department/School Organization</label>
                                                                    <div class="col-lg-6">
                                                                        <textarea class="form-control" style="resize:none" disabled><?php echo $office.$department.$organization;?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <label for="number" class="control-label col-lg-3">Contact No.</label>
                                                                    <div class="col-lg-6">
                                                                        <input class="form-control" rows="5" name="details" style="resize:none" type="text" required disabled value=<?php echo "'" .$contactNo."'";?>>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <label for="dateNeeded" class="control-label col-lg-3">Date & time needed</label>
                                                                    <div class="col-lg-6">
                                                                        <input class="form-control" id="dateNeeded" name="dateNeeded" disabled value=<?php echo "'" .$startDate."'";?>/>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <label for="endDate" class="control-label col-lg-3">End date & time</label>
                                                                    <div class="col-lg-6">
                                                                        <input class=" form-control" id="endDate" name="endDate" disabled value=<?php echo "'" .$endDate."'";?>/>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <label for="purpose" class="control-label col-lg-3">Purpose</label>
                                                                    <div class="col-lg-6">
                                                                        <input class="form-control" id="purpose" name="purpose" type="text" disabled value=<?php echo "'" .$purpose."'";?>/>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <label for="building" class="control-label col-lg-3">Building</label>
                                                                    <div class="col-lg-6">
                                                                        <select name="building" class="form-control m-bot15" disabled>
                                                                            <option>
                                                                                <?php echo $building;?>
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="floorRoom" class="control-label col-lg-3">Floor and Room</label>
                                                                    <div class="col-lg-6">
                                                                        <select name="FloorAndRoomID" id="FloorAndRoomID" class="form-control m-bot15" disabled>
                                                                            <option value=''>
                                                                                <?php echo $floorRoom;?>
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <hr>

                                                                <div class="container-fluid">
                                                                    <h4>Equipment to Lend</h4>

                                                                    <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Equipment</th>
																				<th>Quantity</th>
																				<th>Item Description/ Proposed Specs</th>
																				<th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
																			$count=0;
																			for ($i=0; $i < count($category); $i++){ 
																			echo
																			"<tr>
																				<input type='hidden' name='assetCatBor[]' value='{$assetCat[$i]}'>
																				<td>
																					<select class='form-control' disabled>
																						<option>{$category[$i]}</option>
																					</select>
																				</td>
																				<td><input type='number' value ='{$quantity[$i]}' class='form-control' disabled></td>
																				<td><input class='form-control' type='text' id='purpose' value='{$remarks[$i]}' disabled></td>
																				<td>
																					<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModal' onclick='setAssetCatID(\"{$assetCat[$i]}\")'><i class='fa fa-eye'></i> View Inventory</button>
																				</td>
																				</tr>";

																			}
																		?>
                                                                        </tbody>
                                                                    </table>



                                                                </div>
				
																<div class="container-fluid">
																<h4>Recommended Assets</h4>
																<table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
																	<thead>
																		<tr>
																			<th>Property Code</th>
																			<th>Brand</th>
																			<th>Model</th>
																			<th>Specifications</th>
																			<th>Asset Category</th>
																			<th>Status</th>
																			<th></th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																			if(isset($_SESSION['recommAsset'])){
																				foreach($_SESSION['recommAsset'] as $recommAsset){
																					$queryRecommAss="SELECT *,rb.name as `brandName`,am.description as `modelName`,rac.name as `assetCatName`,am.itemSpecification as `modelSpec`,ras.description as `assetStat` FROM thesis.asset a left join assetmodel am on a.assetModel=am.assetModelID
																													 left join ref_brand rb on am.brand=rb.brandID
																													 left join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																													 left join ref_assetstatus ras on a.assetStatus=ras.id where a.assetID='{$recommAsset}'";
																					$resultRecommAss=mysqli_query($dbc,$queryRecommAss);
																					while($rowRecommAss=mysqli_fetch_array($resultRecommAss,MYSQLI_ASSOC)){
																						echo "<tr>
																								<input type='hidden' name='recommAss[]' value='{$recommAsset}'>
																								<td>{$rowRecommAss['propertyCode']}</td>
																								<td>{$rowRecommAss['brandName']}</td>
																								<td>{$rowRecommAss['modelName']}</td>
																								<td>{$rowRecommAss['modelSpec']}</td>
																								<td>{$rowRecommAss['assetCatName']}</td>
																								<td>{$rowRecommAss['assetStat']}</td>
																								<td><button id='remove' class='btn btn-warning' onClick='removeRow(this,\"{$recommAsset}\")'>Remove</button></td>
																							</tr>";
																					}
																					
																					
																				}
																				
																			}
																			
																		?>

																		</tbody>
																	</table>
																	<br>
																</div>
																
                                                                <hr>
                                                                
																<div class="container-fluid">
																	<h4>Reason for Disapproval</h4>
                                                                    <textarea class="form-control" rows="5" id="reasOfDisapprov" name="reasOfDisapprov" style="resize: none"></textarea>
                                                                </div>
																
                                                                <hr>
                                                                    <div class="container-fluid">
                                                                        <button id="approveBtn" name="approveBtn" class="btn btn-success" <?php if($description !='Pending' ) echo "disabled" ; ?> type="submit">Approve</button>
                                                                        &nbsp;
                                                                        <button id="denyBtn" name="denyBtn" class="btn btn-danger" <?php if($description !='Pending' ) echo "disabled" ; ?> type="submit">Deny</button>
                                                                    </div>
                                                                
                                                            </form>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>

	<!-- Modal -->
																<div class="modal fade" id="myModal" role="dialog">
																	<div class="modal-dialog">

																		<!-- Modal content-->
																		<div class="modal-content">
																			<div class="modal-header">
																				<button type="button" class="close" data-dismiss="modal">&times;</button>
																				<h4 class="modal-title">Search Inventory for Specifications that are exactly or close to request</h4>
																			</div>

																			<form class="form-inline" method="post" action="<?php echo $_SERVER['PHP_SELF']."?id=".$id; ?>">
																				<div class="modal-body">

																					<div class="adv-table" id="ctable">
																						<table class="display table table-bordered table-striped">
																							<thead>
																								<tr>
																									<th></th>
																									<th>Property Code</th>
																									<th>Brand</th>
																									<th>Model</th>
																									<th>Specifications</th>
																									<th>Asset Category</th>
																									<th>Status</th>
																								</tr>
																							</thead>
																							<tbody id='assetList'>

																							</tbody>
																						</table>
																					</div>

																				</div>
																				<br><br>
																				<div class="modal-footer">
																					<button class="btn btn-primary" type="submit" name="send">Send</button>
																					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																				</div>

																			</form>

																		</div>

																	</div>
																</div>
																<!-- Modal End-->
	
    <!-- WAG GALAWIN PLS LANG -->

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
    <script type="text/javascript">
        
		function removeRow(o, recommAsset) {
            var p = o.parentNode.parentNode;
            p.parentNode.removeChild(p);

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    this.responseText;
                }
            };
            xmlhttp.open("GET", "removeRecommAssetData_ajax.php?assetID=" + recommAsset, true);
            xmlhttp.send();
        }
		
		function setAssetCatID(assetCatID) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("assetList").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "setAssetCatIDForIt_view_approval_ajax.php?category=" + assetCatID, true);
            xmlhttp.send();
        }

        function addTest(cavasItemID) {
            var row_index = 0;
            var canvasItemID = cavasItemID;
            var isRenderd = false;

            $("td").click(function() {
                row_index = $(this).parent().index();

            });

            var delayInMilliseconds = 0; //1 second

            setTimeout(function() {

                appendTableRow(row_index, canvasItemID);
            }, delayInMilliseconds);


        }

        function getModel(count, assetCat) {

            var code1 = "brand" + count;
            var code3 = "model" + count;
            var brand = document.getElementById(code1).value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById(code3).innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "model_ajax.php?category=" + assetCat + "&brand=" + brand, true);
            xmlhttp.send();

        }

        function getPropCode(count) {

            var code3 = "model" + count;
            var code4 = "propCode" + count;
            var model = document.getElementById(code3).value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById(code4).innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "propcode_ajax2.php?model=" + model, true);
            xmlhttp.send();

        }

        var appendTableRow = function(rowCount, canvasItemID) {
            var cnt = 0;
            var tr = "<tr>" +
                "<td><select class='form-control'><option>Select Category</option></select></td>" +
                "<td><input type='number' min='0' max='99999' step='1' class='form-control'></td>" +
                "<td><button class='btn btn-danger' onclick='removeRow(this)'> Remove </button></td>" +
                "</tr>";
            $('#tableTest tbody tr').eq(rowCount).after(tr);
        }
    </script>

</body>

</html>