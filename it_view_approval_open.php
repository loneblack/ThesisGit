<!DOCTYPE html>
<html lang="en">
<?php
	session_start();
	require_once("db/mysql_connect.php");
	
	$requestID=$_GET['requestID'];
	$_SESSION['assetCatID']=null;
	$_SESSION['recommAsset']=array();
	
	//Get Request Data
	$queryReq="SELECT * FROM thesis.request r join floorandroom far on r.FloorAndRoomID=far.FloorAndRoomID where r.requestID='{$requestID}'";
	$resultReq=mysqli_query($dbc,$queryReq);
	$rowReq=mysqli_fetch_array($resultReq,MYSQLI_ASSOC);
	
	if(isset($_POST['send'])){
		if(!empty($_POST['recommAsset'])){
			$_SESSION['recommAsset']=$_POST['recommAsset'];
		}
	}
	
	if(isset($_POST['approve'])){
		
		//Update notifications
		$queryUpdNotif="UPDATE `thesis`.`notifications` SET `isRead` = true WHERE `requestID` = '{$requestID}' and `steps_id`='22'";
		$resultUpdNotif=mysqli_query($dbc,$queryUpdNotif);
		
		if(isset($_POST['requestDetailsID'])){
			//UPDATE REQUEST DETAILS DATA 
			$requestDetailsID = $_POST['requestDetailsID'];
			$category = $_POST['category'];
			
			$mi = new MultipleIterator();
			$mi->attachIterator(new ArrayIterator($requestDetailsID));
			$mi->attachIterator(new ArrayIterator($category));
			
			foreach($mi as $value){
				list($requestDetailsID, $category) = $value;
				$sql = "UPDATE `thesis`.`requestdetails` SET `assetCategory` = '{$category}' WHERE (`requestdetailsID` = '{$requestDetailsID}');";
				$result = mysqli_query($dbc, $sql);   
			}
		}
		$query="UPDATE `thesis`.`request` SET `step`='23' WHERE `requestID`='{$requestID}'";
		$result=mysqli_query($dbc,$query);
		
		//INSERT TO NOTIFICATIONS TABLE
		$sqlNotif = "INSERT INTO `thesis`.`notifications` (`requestID`, `steps_id`, `isRead`) VALUES ('{$requestID}', '23', false);";
		$resultNotif = mysqli_query($dbc, $sqlNotif);
		
		$_SESSION['submitMessage']="Form submitted!";
		
	}
	
	if(isset($_POST['disapprove'])){
		//Proceed To Borrow
		//Update notifications
		$queryUpdNotif="UPDATE `thesis`.`notifications` SET `isRead` = true WHERE `requestID` = '{$requestID}' and `steps_id`='22'";
		$resultUpdNotif=mysqli_query($dbc,$queryUpdNotif);
		
		$query="UPDATE `thesis`.`request` SET `status`='6', `step`='28', `reasonForDisaprroval`='{$_POST['reasOfDisapprov']}' WHERE `requestID`='{$requestID}'";
		$result=mysqli_query($dbc,$query);
		
		//Insert recommended asset
		foreach($_POST['recommAss'] as $recommAsset){
			$queryRecomm="INSERT INTO `thesis`.`recommended_assets` (`requestID`, `assetID`) VALUES ('{$requestID}', '{$recommAsset}')";
			$resultRecomm=mysqli_query($dbc,$queryRecomm);
		}
		
		//INSERT TO NOTIFICATIONS TABLE
		$sqlNotif = "INSERT INTO `thesis`.`notifications` (`requestID`, `steps_id`, `isRead`) VALUES ('{$requestID}', '28', false);";
		$resultNotif = mysqli_query($dbc, $sqlNotif);
		
		$_SESSION['submitMessage']="Form submitted!";
	}
	
	if(isset($_POST['disapprovenatalaga'])){
		//DISAPPROVED NA TALAGA
		//Update notifications
		$queryUpdNotif="UPDATE `thesis`.`notifications` SET `isRead` = true WHERE `requestID` = '{$requestID}' and `steps_id`='33'";
		$resultUpdNotif=mysqli_query($dbc,$queryUpdNotif);
		
		$query="UPDATE `thesis`.`request` SET `status`='6', `step`='33', `reasonForDisaprroval`='{$_POST['reasOfDisapprov']}' WHERE `requestID`='{$requestID}'";
		$result=mysqli_query($dbc,$query);
		
		//INSERT TO NOTIFICATIONS TABLE
		$sqlNotif = "INSERT INTO `thesis`.`notifications` (`requestID`, `steps_id`, `isRead`) VALUES ('{$requestID}', '33', false);";
		$resultNotif = mysqli_query($dbc, $sqlNotif);
		
		$_SESSION['submitMessage']="Form submitted!";
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
                                        Request To Purchase An Asset
                                    </header>
                                    <div class="panel-body">
                                        <div class="form" method="post">
                                            <form class="cmxform form-horizontal " id="signupForm" method="post" action="<?php echo $_SERVER['PHP_SELF']." ?requestID=".$requestID; ?>">
                                                <?php
                                                    if (isset($_SESSION['submitMessage'])){

                                                        echo "<div style='text-align:center' class='alert alert-success'>
                                                                <strong><h3>{$_SESSION['submitMessage']}</h3></strong>
                                                              </div>";

                                                        unset($_SESSION['submitMessage']);
                                                    }
                                                ?>

                                                <section>
                                                    <h2>
                                                        Status: <span class='label label-warning'>Pending</span>
                                                    </h2>
                                                    <br>

                                                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-eye"></i> View Inventory</button> -->


                                                    <h4>Request Details</h4>
                                                    <div class="form-group ">
                                                        <label for="dateNeeded" class="control-label col-lg-3">Room</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" value="<?php echo $rowReq['floorRoom']; ?>" readonly />
                                                        </div>
                                                    </div>

                                                    <div class="form-group ">
                                                        <label for="dateNeeded" class="control-label col-lg-3">Date needed</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" value="<?php echo $rowReq['dateNeeded']; ?>" readonly />
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="building" class="control-label col-lg-3">Reason of Request</label>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <textarea class="form-control" rows="5" id="comment" name="comment" style="resize: none" readonly><?php echo $rowReq['description']; ?></textarea>
                                                            </div>
                                                        </div>

                                                    </div>
													
													 <!-- <div class="form-group ">
                                                        <label for="building" class="control-label col-lg-3">Purpose</label>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <textarea class="form-control" rows="5" id="" name= "assetDescription" style="resize: none" readonly><?php if(!$rowReq['assetDescription']==null){
																	echo $rowReq['assetDescription'];
																} ?></textarea>
                                                            </div>
                                                        </div>
                                                     </div> -->

                                                </section>


                                                <section>
                                                    <h4>Requested Services/Materials</h4>
                                                    
                                                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#reqAss">View Requestor's Assets</button> <br><br>

                                                    
                                                    <table class="table table-bordered table-striped table-condensed table-hover" >
                                                        <thead>
                                                            <tr>
                                                                <th>Category</th>
                                                                <th>Quantity</th>
                                                                <th>Specifications</th>
                                                                <th>Asset Description</th>
                                                                <th>Inventory</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
																//Get Request Details data
																$queryReqDet="SELECT *,rac.name as `assetCatName` FROM thesis.requestdetails rd
																				left join ref_assetcategory rac on rd.assetCategory=rac.assetCategoryID where rd.requestID='{$requestID}'";
																$resultReqDet=mysqli_query($dbc,$queryReqDet);
																while($rowReqDet=mysqli_fetch_array($resultReqDet,MYSQLI_ASSOC)){
																	echo "<tr>
																	<td>
																		<div class='col-lg-12'>
																			<input class='form-control' type='text' value='";
																			if(isset($rowReqDet['assetCatName'])){
																				echo $rowReqDet['assetCatName'];
																			}
																			else{
																				echo "Please Specify";
																			}
																			echo "' id='purpose0' disabled>
																		</div>
																	</td>
																	<td>
																		<div class='col-lg-12'>
																			<input class='form-control' type='text' value='{$rowReqDet['quantity']}' id='purpose0' disabled>
																		</div>
																	</td>

																	<td style='padding-top:5px; padding-bottom:5px'>
																		<div class='col-lg-12'>
																			<input class='form-control' type='text' value='{$rowReqDet['description']}' id='purpose0' disabled>
																		</div>
																	</td>
																	<td>
																		<div class='col-lg-12'>
																			<input class='form-control' type='text' value='{$rowReqDet['purpose']}' id='purpose0' disabled>
																		</div>
																	</td>
																	<td>
																		<div class='col-lg-12'>
																			<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModal' onclick='setAssetCatID(\"{$rowReqDet['assetCategory']}\")'><i class='fa fa-eye'></i> View Inventory</button>
																		</div>
																	</td>
																</tr>";
																}
															?>

                                                        </tbody>
                                                    </table>


                                                    <br>
                                                </section>
                                                

                                                    <section>

                                                        <h4>Fill up unknown requested asset category based from its described asset description.</h4>
                                                        <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                            <thead>
                                                                <tr>
                                                                    <th>Quantity</th>
                                                                    <th>Category</th>
                                                                    <th>Specifications</th>
                                                                    <th>Asset Description</th>
																	<th>Inventory</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
																<?php
																	//GET ALL REQUEST DETAILS OF A REQUEST THAT HAVE EMPTY ASSET CATEGORIES
																	$queryReqDet2="SELECT *,rac.name as `assetCatName` FROM thesis.requestdetails rd
																					left join ref_assetcategory rac on rd.assetCategory=rac.assetCategoryID where rd.requestID='{$requestID}' and assetCategory is null";
																	$resultReqDet2=mysqli_query($dbc,$queryReqDet2);
																	while($rowReqDet2=mysqli_fetch_array($resultReqDet2,MYSQLI_ASSOC)){
																		echo "<tr>
																				<input type='hidden' name='requestDetailsID[]' value='{$rowReqDet2['requestdetailsID']}'>
																				<td>
																					<div class='col-lg-12'>
																						<input class='form-control' type='number' name='quantity[]' id='quantity0' min='1' step='1' placeholder='Quantity' value='{$rowReqDet2['quantity']}' readonly />
																					</div>
																				</td>
																				<td>
																				<div class='col-lg-12'>
																					<select class='form-control' name='category[]' id='category_".$rowReqDet2['requestdetailsID']."'>
																					<option>Select</option>";
																					
																					$sql = "SELECT * FROM thesis.ref_assetcategory;";
																					$result = mysqli_query($dbc, $sql);
																					while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
																					{	
																						echo "<option value ={$row['assetCategoryID']}>";
																						echo "{$row['name']}</option>";
																					}
																			   
																				echo "</select>
																			</div>
																		</td>
																		<td>
																			<div class='col-lg-12'>
																				<input class='form-control' type='text' name='description[]' id='description0' placeholder='Item specifications' value='{$rowReqDet2['description']}' readonly />
																			</div>
																		</td>
																		<td>
																			<div class='col-lg-12'>
																				<input class='form-control' type='text' name='purpose[]' id='purpose0' placeholder='Asset Description' value='{$rowReqDet2['purpose']}' readonly >
																			</div>
																		</td>
																		<td>
																		<div class='col-lg-12'>
																			<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModal' onclick='setAssetCatID2(\"{$rowReqDet2['requestdetailsID']}\")'><i class='fa fa-eye'></i> View Inventory</button>
																		</div>
																	</td>
																	</tr>";
																	}
																?>
                                                            </tbody>
                                                        </table>


                                                        <br>

                                                    </section>

                                                    <section>
                                                        <h4>Place A Comment/ Instruction if User Should Proceed to Borrow</h4>
                                                        <textarea class="form-control" rows="5" id="reasOfDisapprov" name="reasOfDisapprov" style="resize: none"></textarea>
                                                        <br>
                                                    </section>

                                                    <section>
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
                                                    </section>







                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-xs-4">
                                                            </div>
                                                            <div class="col-xs-6">

                                                                <button type="submit" class="btn btn-success" id="approve" name="approve"><i class="fa fa-check"></i> Approve</button>
                                                                &nbsp;&nbsp;
                                                                <button type="submit" class="btn btn-warning" id="disapprove" name="disapprove"><i class="fa fa-envelope"></i> Proceed To Borrow</button>
                                                                <button type="submit" class="btn btn-danger" id="disapprovenatalaga" name="disapprovenatalaga"><i class="fa fa-ban"></i> Disapprove</button>


                                                            </div>
                                                            <div class="col-xs-4">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!-- Modal -->
                                                <div class="modal fade" id="myModal" role="dialog">
                                                    <div class="modal-dialog">

                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">Search Inventory for Specifications that are exactly or close to request</h4>
                                                            </div>

                                                            <form class="form-inline" method="post" action="<?php echo $_SERVER['PHP_SELF']." ?requestID=".$requestID; ?>">
                                                                <div class="modal-body">
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
                                            
                                            
                                            
                                                <div id="reqAss" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">

                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">Requestor's Assets</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                
                                                                <div class="adv-table">
                                                                    <table class="display table table-bordered table-striped" id="dynamic-table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Property Code</th>
                                                                                <th>Brand</th>
                                                                                <th>Model</th>
                                                                                <th>Status</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $query="
                                                                                SELECT a.propertyCode, rb.name AS 'brand', am.description AS 'model', b.name, f.floorRoom, aa.startdate, aa.enddate, rs.description FROM thesis.assetassignment aa
                                                                                JOIN building b ON aa.BuildingID = b.buildingID
                                                                                JOIN floorandroom f ON aa.FloorAndRoomID = f.FloorAndRoomID
                                                                                JOIN employee e ON aa.personresponsibleID = e.employeeID
                                                                                JOIN asset a ON aa.assetID = a.assetID
                                                                                JOIN ref_assetstatus rs ON a.assetStatus = rs.id
                                                                                JOIN assetmodel am ON a.assetModel = am.assetModelID
                                                                                JOIN ref_brand rb ON am.brand = rb.brandID
                                                                                WHERE (personresponsibleID = {$rowReq['UserID']});";
                                                                            $result=mysqli_query($dbc,$query);
                                                                            while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                                                                                echo "<tr>
                                                                                    <td>{$row['propertyCode']}</td>
                                                                                    <td>{$row['brand']}</td>
                                                                                    <td>{$row['model']}</td>
                                                                                    <td>{$row['description']}</td>
                                                                                </tr>";
                                                                            }



                                                                        ?>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                
                                                                
                                                            </div>
                                                            <div class="modal-footer">
                                                               
                                                            </div>
                                                        </div> 

                                                    </div>
                                                </div>
											
                                            
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
    <script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
    <script src="js/dynamic_table_init.js"></script>

    <script type="text/javascript">
        var count = 1;
        // Shorthand for $( document ).ready()
        $(function() {

        });
		
		
		function addTest() {

            var row_index = 0;
            var isRenderd = false;

			$("td").click(function() {
                row_index = $(this).parent().index();

            });
			
            var delayInMilliseconds = 300; //1 second

            setTimeout(function() {

                appendTableRow(row_index);
            }, delayInMilliseconds);



        }
		
		
        var appendTableRow = function(rowCount) {

            var tr = 
                            "<tr>" +
                                    "<td>" +
                                       " <div class='col-lg-12'>" +
                                            "<input class='form-control' type='number' id='quantity' name = 'quantity[]' min='1'" + "step='1' placeholder='Quantity' />" +
                                        "</div>" +
                                    "</td>" +
                                    "<td>" +
                                        "<div class='col-lg-12'>" +
                                            "<select class='form-control' id='category' name = 'category[]'>" +
                                                "<option>Select</option>" +

                                                '<?php

                                                    $sql = "SELECT * FROM thesis.ref_assetcategory;";

                                                    $result = mysqli_query($dbc, $sql);

                                                    

                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                        
                                                        echo "<option value ={$row['assetCategoryID']}>";
                                                        echo "{$row['name']}</option>";

                                                    }
                                                ?>'

                                            +"</select>" +
                                        "</div>" +
                                    "</td>" +
                                    "<td style='padding-top:5px; padding-bottom:5px'>" +
                                        "<div class='col-lg-12'>" +
                    "<input class='form-control' type='text' id='description' name ='description[]' placeholder='Item description' />" +
                                        "</div>" +
                                    "</td>" +

"<td style='padding-top:5px; padding-bottom:5px'>" +
                                        "<div class='col-lg-12'>" +
                    "<input class='form-control' type='text' id='purpose' name ='purpose[]' placeholder='Purpose' />" +
                                        "</div>" +

                                    "<td>" +
        "<button id='remove' class='btn btn-danger' type='button' onClick='removeRow(this)'>Remove</button>" +
                                    "</td>" +
                                    "<td>" +
                                    "</td>" +
                                    "</tr>"
				
				
				
				
            $('#tableTest tbody tr').eq(rowCount).after(tr);

            count++;

             $.ajax({
            type:"POST",
            url:"count.php",
            data: 'count='+count,
            success: function(data){
                $("#count").html(data);

                }
            });
			
        }

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
		
		function setAssetCatID2(requestdetailsID) {
			var selectID = "category_" + requestdetailsID;
			var assetCatID = document.getElementById(selectID).value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
					
                    document.getElementById("assetList").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "setAssetCatIDForIt_view_approval_ajax.php?category=" + assetCatID, true);
            xmlhttp.send();
        }
		
        $.ajax({
            type: "POST",
            url: "count.php",
            data: 'count=' + count,
            success: function(data) {
                $("#count").html(data);

            }
        });
		
		

        function getRooms(val) {
            $.ajax({
                type: "POST",
                url: "requestor_getRooms.php",
                data: 'buildingID=' + val,
                success: function(data) {
                    $("#FloorAndRoomID").html(data);

                }
            });
        }

        $('#disapprove').click(function() {
            document.getElementById("reasOfDisapprov").required = true;


        });
		 $('#disapprovenatalaga').click(function() {
            document.getElementById("reasOfDisapprov").required = true;


        });
        $('#approve').click(function() {
            document.getElementById("reasOfDisapprov").required = false;

        });
    </script>
	
	<!--common script init for all pages-->
    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>
    <script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
    <script src="js/dynamic_table_init.js"></script>
	
    <script src="js/scripts.js"></script>
	
</body>

</html>