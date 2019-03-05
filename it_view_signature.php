<!DOCTYPE html>
<html lang="en">
<?php
	session_start();
	require_once("db/mysql_connect.php");
	
	$requestID=$_GET['requestID'];
	$_SESSION['assetCatID']=null;
	$_SESSION['recommAsset']=array();
	
	//Get Request Data
	$queryReq="SELECT *,rs.description as `statusDesc` FROM thesis.request r join floorandroom far on r.FloorAndRoomID=far.FloorAndRoomID
                        join ref_status rs on r.status=rs.statusID	
						where r.requestID='{$requestID}'";
	$resultReq=mysqli_query($dbc,$queryReq);
	$rowReq=mysqli_fetch_array($resultReq,MYSQLI_ASSOC);
	
	//Get images from the database
	$imageURL = 'uploads/'.$rowReq["signature"];
	
	if(isset($_POST['send'])){
		if(!empty($_POST['recommAsset'])){
			$_SESSION['recommAsset']=$_POST['recommAsset'];
		}
	}
	
	if(isset($_POST['approve'])){
		$query="UPDATE `thesis`.`request` SET `status`='2', `step`='2'  WHERE `requestID`='{$requestID}'";
		$result=mysqli_query($dbc,$query);
		
		header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/it_view_incomplete_request.php?requestID={$requestID}");
	}
	
	if(isset($_POST['disapprove'])){
		
		$query="UPDATE `thesis`.`request` SET `status`='6', `step`='23', `itReasonDissaproval`='{$_POST['reasOfDisapprov']}' WHERE `requestID`='{$requestID}'";
		$result=mysqli_query($dbc,$query);

		$_SESSION['submitMessage']="Form submitted!";
		//header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/it_view_signature.php?requestID={$requestID}");
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
															
															Status: <?php 
																	if($rowReq['statusDesc']=="Disapproved"){
																		echo "<span class='label label-danger'>{$rowReq['statusDesc']}</span>"; 
																	}
																	else{
																		echo "<span class='label label-warning'>{$rowReq['statusDesc']}</span>"; 
																	}
															
																	?>
														</h2>
														<br>

                                                        <h4>Uploaded Proof of Signature</h4>
                                                        <div class="form-group ">
															
															<div class="col-lg-6">
																<img src="<?php echo $imageURL; ?>" alt="" />
															</div>
														</div>
                                                        <br>
                                                    </section>
                                                <section>
                                                    
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
													
													 <div class="form-group ">
                                                        <label for="building" class="control-label col-lg-3">Asset Description</label>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <textarea class="form-control" rows="5" id="" name= "assetDescription" style="resize: none" readonly><?php if(!$rowReq['assetDescription']==null){
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
                                                    <h4>Comment if the receiver uploaded an invalid image or image lacks signatures</h4>
                                                    <textarea class="form-control" rows="5" id="reasOfDisapprov" name="reasOfDisapprov" style="resize: none"></textarea>
                                                    <br>
                                                </section>
                                                    
                                                    
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-xs-4">
                                                            </div>
                                                            <div class="col-xs-4">

                                                                <button type="submit" class="btn btn-success" id="approve" name="approve"><i class="fa fa-check"></i> Approve</button>
                                                                &nbsp;&nbsp;
                                                                <button type="submit" class="btn btn-danger" id="disapprove" name="disapprove"><i class="fa fa-ban"></i> Deny</button>
                                                                <!-- <button type="button" class="btn btn-danger" id="disapprove" data-toggle="modal" data-target="#myModal"><i class="fa fa-ban"></i> Disapprove</button> -->


                                                            </div>
                                                            <div class="col-xs-4">
                                                            </div>
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
	<!--common script init for all pages-->
    <script src="js/scripts.js"></script>
</body>

</html>