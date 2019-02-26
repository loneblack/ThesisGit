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
		//Add data to request details
		
		$quantity = $_POST['quantity'];
		$category = $_POST['category'];
		$description = $_POST['description'];
		$purpose = $_POST['purpose'];
		
		$mi = new MultipleIterator();
		$mi->attachIterator(new ArrayIterator($quantity));
		$mi->attachIterator(new ArrayIterator($category));
		$mi->attachIterator(new ArrayIterator($description));
		$mi->attachIterator(new ArrayIterator($purpose));
		
		//insertion to requestdetails table using the id taken earlier
		
		foreach($mi as $value){
			list($quantity, $category, $description, $purpose) = $value;
			
			$sql = "INSERT INTO `thesis`.`requestdetails` (`requestID`, `quantity`, `assetCategory`, `description`, `purpose`) VALUES ('{$requestID}', '{$quantity}', '{$category}', '{$description}', '{$purpose}')";
			$result = mysqli_query($dbc, $sql);   
		}

		$query="UPDATE `thesis`.`request` SET `step`='23' WHERE `requestID`='{$requestID}'";
		$result=mysqli_query($dbc,$query);
		$_SESSION['submitMessage']="Form submitted!";
	}
	
	if(isset($_POST['disapprove'])){
		$query="UPDATE `thesis`.`request` SET `status`='6', `reasonForDisaprroval`='{$_POST['reasOfDisapprov']}' WHERE `requestID`='{$requestID}'";
		$result=mysqli_query($dbc,$query);
		
		//Insert recommended asset
		foreach($_POST['recommAss'] as $recommAsset){
			$queryRecomm="INSERT INTO `thesis`.`recommended_assets` (`requestID`, `assetID`) VALUES ('{$requestID}', '{$recommAsset}')";
			$resultRecomm=mysqli_query($dbc,$queryRecomm);
		}
		
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
                                                            <input class="form-control" value="<?php echo $rowReq['floorRoom']; ?>" disabled />
                                                        </div>
                                                    </div>

                                                    <div class="form-group ">
                                                        <label for="dateNeeded" class="control-label col-lg-3">Date needed</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" value="<?php echo $rowReq['dateNeeded']; ?>" disabled />
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="building" class="control-label col-lg-3">Reason of Request</label>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <textarea class="form-control" rows="5" id="comment" name="comment" style="resize: none" disabled><?php echo $rowReq['description']; ?></textarea>
                                                            </div>
                                                        </div>

                                                    </div>
													
													 <div class="form-group ">
                                                        <label for="building" class="control-label col-lg-3">Asset Description</label>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <textarea class="form-control" rows="5" id="" name= "assetDescription" style="resize: none" disabled><?php if(!$rowReq['assetDescription']==null){
																	echo $rowReq['assetDescription'];
																} ?></textarea>
                                                            </div>
                                                        </div>
                                                     </div>

                                                </section>


                                                <section>
                                                    <h4>Requested Services/Materials</h4>
                                                    <table class="table table-bordered table-striped table-condensed table-hover" >
                                                        <thead>
                                                            <tr>
                                                                <th>Category</th>
                                                                <th>Quantity</th>
                                                                <th>Specifications</th>
                                                                <th>Purpose</th>
                                                                <th>Inventory</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
																//Get Request Details data
																$queryReqDet="SELECT *,rac.name as `assetCatName` FROM thesis.requestdetails rd
																				join ref_assetcategory rac on rd.assetCategory=rac.assetCategoryID where rd.requestID='{$requestID}'";
																$resultReqDet=mysqli_query($dbc,$queryReqDet);
																while($rowReqDet=mysqli_fetch_array($resultReqDet,MYSQLI_ASSOC)){
																	echo "<tr>
																	<td>
																		<div class='col-lg-12'>
																			<input class='form-control' type='text' name='category[]' value='{$rowReqDet['assetCatName']}' id='purpose0' disabled>
																		</div>
																	</td>
																	<td>
																		<div class='col-lg-12'>
																			<input class='form-control' type='text' name='qty[]' value='{$rowReqDet['quantity']}' id='purpose0' disabled>
																		</div>
																	</td>

																	<td style='padding-top:5px; padding-bottom:5px'>
																		<div class='col-lg-12'>
																			<input class='form-control' type='text' name='specs[]' value='{$rowReqDet['description']}' id='purpose0' disabled>
																		</div>
																	</td>
																	<td>
																		<div class='col-lg-12'>
																			<input class='form-control' type='text' name='purpose[]' value='{$rowReqDet['purpose']}' id='purpose0' disabled>
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
                                                    <input type="checkbox" name="check" disabled <?php if($rowReq['specs']==1){ echo "checked" ; } ?>> Check the checkbox if you would like the IT Team to choose the closest specifications to your request in case the suppliers would not have assets that are the same as your specifications. Leave it unchecked if you yourself would like to choose the specifications that are the closest to your specifications.
                                                    <br><br><br>
                                                </section>
                                                

                                                    <section>

                                                        <h4>Fill up requested assets based from its described asset description.</h4>
                                                        <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                            <thead>
                                                                <tr>
                                                                    <th>Quantity</th>
                                                                    <th>Category</th>
                                                                    <th>Specifications</th>
                                                                    <th>Purpose</th>
                                                                    <th>Remove</th>
                                                                    <th>Add</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <div class="col-lg-12">
                                                                            <input class="form-control" type="number" name="quantity[]" id="quantity0" min="1" step="1" placeholder="Quantity" <?php if($rowReq['assetDescription']==null){
																				echo "disabled";
																			} ?> />
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="col-lg-12">
                                                                            <select class="form-control" name="category[]" id="category0" <?php if($rowReq['assetDescription']==null){
																					echo "disabled";
																				} ?>>
                                                                                <option>Select</option>
                                                                                <?php
 
                                                                                $sql = "SELECT * FROM thesis.ref_assetcategory;";

                                                                                $result = mysqli_query($dbc, $sql);

                                                                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                                                {
                                                                                    
                                                                                    echo "<option value ={$row['assetCategoryID']}>";
                                                                                    echo "{$row['name']}</option>";

                                                                                }
                                                                           ?>
                                                                            </select>
                                                                        </div>
                                                                    </td>

                                                                    <td>
                                                                        <div class="col-lg-12">
                                                                            <input class="form-control" type="text" name="description[]" id="description0" placeholder="Item specifications" <?php if($rowReq['assetDescription']==null){
																					echo "disabled";
																				} ?> />
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="col-lg-12">
                                                                            <input class="form-control" type="text" name="purpose[]" id="purpose0" placeholder="Purpose" <?php if($rowReq['assetDescription']==null){
																					echo "disabled";
																				} ?>>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                    </td>
                                                                    <td>
                                                                        <button type='button' class='btn btn-primary' onclick='addTest();' <?php if($rowReq['assetDescription']==null){
																					echo "disabled";
																				} ?>> Add </button>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>


                                                        <br>

                                                    </section>

                                                    <section>
                                                        <h4>Reason for Disapproval</h4>
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
                                                            <div class="col-xs-4">

                                                                <button type="submit" class="btn btn-success" id="approve" name="approve"><i class="fa fa-check"></i> Approve</button>
                                                                &nbsp;&nbsp;
                                                                <button type="submit" class="btn btn-danger" id="disapprove" name="disapprove"><i class="fa fa-ban"></i> Disapprove</button>
                                                                <!-- <button type="button" class="btn btn-danger" id="disapprove" data-toggle="modal" data-target="#myModal"><i class="fa fa-ban"></i> Disapprove</button> -->


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


                                                                    <div class="adv-table" id="ctable">
                                                                        <table class="display table table-bordered table-striped" id="dynamic-table">
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
        $('#approve').click(function() {
            document.getElementById("reasOfDisapprov").required = false;

        });
    </script>

</body>

</html>