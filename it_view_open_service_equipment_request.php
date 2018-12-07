<!DOCTYPE html>
<html lang="en">
<?php
session_start();

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

$query2 =  "SELECT * FROM thesis.borrow_details d
            JOIN ref_assetcategory c ON d.assetCategoryID = c.assetCategoryID
            WHERE borrowID = {$id};";
$result2 = mysqli_query($dbc, $query2);

while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
    array_push($category, $row2['name']);
    array_push($quantity, $row2['quantity']);
	array_push($assetCat, $row2['assetCategoryID']);
}
    if(isset($_POST['approveBtn'])){

		$propCode=$_POST['propCode'];
		$a=sizeOf($propCode);
		
		
		//Update status,steps
        $query="UPDATE `thesis`.`request_borrow` SET `statusID` = '2', `steps`='13' WHERE (`borrowID` = '{$id}');";
        $result=mysqli_query($dbc,$query);
	   
        //insert to assset testing
        $queryTest="INSERT INTO `thesis`.`assettesting` (`statusID`, `PersonRequestedID`, `remarks`, `serviceType`, `borrowID`)
                            VALUES ('1', '{$personresponsibleID}', 'Borrow', '25', '{$id}');";
        $resultTest=mysqli_query($dbc,$queryTest);

        $selectQuery = "SELECT * FROM thesis.assettesting ORDER BY testingID DESC LIMIT 1;";
        $resultQuery = mysqli_query($dbc,$selectQuery);
        while ($row = mysqli_fetch_array($resultQuery, MYSQLI_ASSOC)){
            $testingID = $row['testingID'];
        }
		
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

		
		
		$message = "Form submitted!";
		$_SESSION['submitMessage'] = $message; 
		
		
		
        header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/it_view_open_service_equipment_request.php?id=".$_SESSION['id']);
    }
    elseif(isset($_POST['denyBtn'])){
        $query="UPDATE `thesis`.`request_borrow` SET `statusID` = '2', `steps`='20' WHERE (`borrowID` = '{$id}');";
        $result=mysqli_query($dbc,$query);
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
											<a href="it_requests.php"><button type="button" class="btn btn-link"><strong>< Back</strong></button></a>
                                            <h4 style="float: right;">Status: <?php 
                                            if($description=='Pending'){
                                                echo "<span class='label label-warning'>{$description}</span>";
                                            }
                                            elseif($description=='Disapproved'){
                                                echo "<span class='label label-danger'>{$description}</span>";
                                            }
                                            else{
                                                echo "<span class='label label-success'>Approved</span>";
                                            } ?></h4>
                                            <form class="cmxform form-horizontal " id="signupForm" method="post" action="">
                                                <div class="form-group ">
                                                    <label for="serviceType" class="control-label col-lg-3">Office/Department/School Organization</label>
                                                    <div class="col-lg-6">
														<textarea class="form-control" style="resize:none" disabled><?php echo $office.$department.$organization;?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="number" class="control-label col-lg-3">Contact No.</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" rows="5" name="details" style="resize:none" type="text" required disabled value=<?php echo "'".$contactNo."'";?>>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="dateNeeded" class="control-label col-lg-3">Date & time needed</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" id="dateNeeded" name="dateNeeded" disabled value=<?php echo "'".$startDate."'";?>/>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="endDate" class="control-label col-lg-3">End date & time</label>
                                                    <div class="col-lg-6">
                                                        <input class=" form-control" id="endDate" name="endDate" disabled value=<?php echo "'".$endDate."'";?>/>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="purpose" class="control-label col-lg-3">Purpose</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" id="purpose" name="purpose" type="text" disabled value=<?php echo "'".$purpose."'";?>/>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="building" class="control-label col-lg-3">Building</label>
                                                    <div class="col-lg-6">
                                                        <select name="building" class="form-control m-bot15" disabled >
                                                            <option><?php echo $building;?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="floorRoom" class="control-label col-lg-3">Floor & Room</label>
                                                    <div class="col-lg-6">
                                                        <select name="FloorAndRoomID" id="FloorAndRoomID" class="form-control m-bot15" disabled>
                                                            <option value=''><?php echo $floorRoom;?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr>

                                                <h4>Endorsement (if applicable)</h4>
                                                    <div class="form-group ">
                                                        <label for="representative" class="control-label col-lg-3">Representative</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" id="representative" name="representative" type="text" disabled value=<?php echo "'".$personrepresentative."'";?>/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="idNum" class="control-label col-lg-3">ID Number</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" id="idNum" name="idNum" type="text" disabled value=<?php echo "'".$personrepresentativeID."'";?>/>
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
                                                                <th>Brand</th>
																<th>Model</th>
																<th>Property Code</th>
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
                                                                
                                                                <td>
																	<select class='form-control donreq' id='brand".$count."' required onchange='getModel({$count},{$assetCat[$i]})'>
																	<option value=''>Select Brand</option>";
																	
																	//GET BRAND
																	$queryBrand = "SELECT * FROM thesis.ref_brand";
																	$resultBrand = mysqli_query($dbc, $queryBrand);
																	while($rowBrand=mysqli_fetch_array($resultBrand, MYSQLI_ASSOC)){
																		echo "<option value='{$rowBrand['brandID']}'>{$rowBrand['name']}</option>";
																	}
																	
																	echo "</select>
																		</td>
																		<td>
																		<select class='form-control donreq' id='model".$count."' required onchange='getPropCode({$count})'>
																			<option value=''>Select Model</option>";
																	
																	echo "</select>
																		</td>
																		<td>
																		<select class='form-control donreq' id='propCode".$count."' name='propCode[]' required>
																			<option value=''>Select Property Code</option>";
																			
																	echo "</select>
																		</td>
																	</tr>";
																	$count++;

																	for ($j=1; $j < $quantity[$i] ; $j++) { 
																		
																	echo "
																		<input type='hidden' name='assetCatBor1[]' value='{$assetCat[$i]}'>
																		<td></td>
																		<td></td>
																		<td>
																		<select class='form-control donreq' id='brand".$count."' required onchange='getModel({$count},{$assetCat[$i]})'>
																		<option value=''>Select Brand</option>";
																		
																		//GET BRAND
																		$queryBrand = "SELECT * FROM thesis.ref_brand";
																		$resultBrand = mysqli_query($dbc, $queryBrand);
																		while($rowBrand=mysqli_fetch_array($resultBrand, MYSQLI_ASSOC)){
																			echo "<option value='{$rowBrand['brandID']}'>{$rowBrand['name']}</option>";
																		}
																		
																		echo "</select>
																			</td>
																			<td>
																			<select class='form-control donreq' id='model".$count."' required onchange='getPropCode({$count})'>
																				<option value=''>Select Model</option>";
																		
																		echo "</select>
																			</td>
																			<td>
																			<select class='form-control donreq' id='propCode".$count."' name='propCode1[]' required>
																				<option value=''>Select Property Code</option>";
																				
																		echo "</select>
																			</td>
																		</tr>";
																		$count++;
																	}
                                                            }
                                                        ?>
                                                        </tbody>
                                                    </table>



                                                </div>
                                                <hr>
                                                <div class="container-fluid">
                                                    
													<hr>
                                                    <div class="form-group">
														<button id="approveBtn" name="approveBtn" class="btn btn-success" <?php if($description != 'Pending') echo "disabled"; ?> type="submit">Approve</button>
														&nbsp;
														<button id="denyBtn" name="denyBtn" class="btn btn-danger"<?php if($description != 'Pending') echo "disabled"; ?> type="submit">Deny</button>
                                                    </div>
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

   
    <!-- WAG GALAWIN PLS LANG -->

    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>
    <script type="text/javascript">
        function removeRow(o) {
            var p = o.parentNode.parentNode;
            p.parentNode.removeChild(p);
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
		
		function getModel(count,assetCat){
			
			var code1 = "brand" + count;
			var code3 = "model" + count;
			var brand=document.getElementById(code1).value;
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById(code3).innerHTML = this.responseText;
			}
			};
			xmlhttp.open("GET", "model_ajax.php?category=" + assetCat + "&brand=" + brand, true);
			xmlhttp.send();
							
		}
		
		function getPropCode(count){
			
			var code3 = "model" + count;
			var code4 = "propCode" + count;
			var model=document.getElementById(code3).value;
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