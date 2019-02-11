<!DOCTYPE html>
<html lang="en">
<?php
	session_start();
	require_once("db/mysql_connect.php");
	$_SESSION['count'] = 0;
	$requestID=$_GET['requestID'];
	
	//Get Request Data
	$queryReq="SELECT * FROM thesis.request r join floorandroom far on r.FloorAndRoomID=far.FloorAndRoomID where r.requestID='{$requestID}'";
	$resultReq=mysqli_query($dbc,$queryReq);
	$rowReq=mysqli_fetch_array($resultReq,MYSQLI_ASSOC);
	
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
                                            <form class="cmxform form-horizontal " id="signupForm" method="post" action="">
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

                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-eye"></i> View Inventory</button>


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

                                                </section>


                                                <section>
                                                    <h4>Requested Services/Materials</h4>
                                                    <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
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
																			<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModal'><i class='fa fa-eye'></i> View Inventory</button>
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
                                                    <h4>Reason for Disapproval</h4>
													<textarea class="form-control" rows="5" id="comment" name="reasOfDisapprov" style="resize: none"></textarea>
												</section>
												<br>
												
                                                <section>
                                                    <input type="checkbox" name="check" disabled> Check the checkbox if you would like the IT Team to choose the closest specifications to your request in case the suppliers would not have assets that are the same as your specifications. Leave it unchecked if you yourself would like to choose the specifications that are the closest to your specifications.
                                                    <br><br><br>
                                                </section>







                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <form method="post">
                                                                <button type="submit" class="btn btn-success" name="approve"><i class="fa fa-check"></i> Approve</button>
                                                                &nbsp;&nbsp;

                                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal"><i class="fa fa-ban"></i> Disapprove</button>

                                                            </form>
                                                        </div>
                                                        <div class="col-xs-4">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Modal -->
                                                <div class="modal fade" id="myModal" role="dialog">
                                                    <div class="modal-dialog">

                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">Search Inventory for Specifications that are exactly or close to request</h4>
                                                            </div>


                                                            <div class="modal-body">
                                                                <form class="form-inline">
                                                                <input type="hidden" id="assetCatID" name="assetCatID">
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
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><input type="checkbox"></td>
                                                                                <td>PC-0001</td>
                                                                                <td>Samsung</td>
                                                                                <td>S7 Edge</td>
                                                                                <td>CPU 1050</td>
                                                                                <td>Phone</td>
                                                                                <td>On Hand</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><input type="checkbox"></td>
                                                                                <td>PC-0001</td>
                                                                                <td>Samsung</td>
                                                                                <td>S7 Edge</td>
                                                                                <td>CPU 1050</td>
                                                                                <td>Phone</td>
                                                                                <td>On Hand</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><input type="checkbox"></td>
                                                                                <td>PC-0001</td>
                                                                                <td>Samsung</td>
                                                                                <td>S7 Edge</td>
                                                                                <td>CPU 1050</td>
                                                                                <td>Phone</td>
                                                                                <td>On Hand</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><input type="checkbox"></td>
                                                                                <td>PC-0001</td>
                                                                                <td>Samsung</td>
                                                                                <td>S7 Edge</td>
                                                                                <td>CPU 1050</td>
                                                                                <td>Phone</td>
                                                                                <td>On Hand</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><input type="checkbox"></td>
                                                                                <td>PC-0001</td>
                                                                                <td>Samsung</td>
                                                                                <td>S7 Edge</td>
                                                                                <td>CPU 1050</td>
                                                                                <td>Phone</td>
                                                                                <td>On Hand</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><input type="checkbox"></td>
                                                                                <td>PC-0001</td>
                                                                                <td>Samsung</td>
                                                                                <td>S7 Edge</td>
                                                                                <td>CPU 1050</td>
                                                                                <td>Phone</td>
                                                                                <td>On Hand</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><input type="checkbox"></td>
                                                                                <td>PC-0001</td>
                                                                                <td>Samsung</td>
                                                                                <td>S7 Edge</td>
                                                                                <td>CPU 1050</td>
                                                                                <td>Phone</td>
                                                                                <td>On Hand</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><input type="checkbox"></td>
                                                                                <td>PC-0001</td>
                                                                                <td>Samsung</td>
                                                                                <td>S7 Edge</td>
                                                                                <td>CPU 1050</td>
                                                                                <td>Phone</td>
                                                                                <td>On Hand</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><input type="checkbox"></td>
                                                                                <td>PC-0001</td>
                                                                                <td>Samsung</td>
                                                                                <td>S7 Edge</td>
                                                                                <td>CPU 1050</td>
                                                                                <td>Phone</td>
                                                                                <td>On Hand</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><input type="checkbox"></td>
                                                                                <td>PC-0001</td>
                                                                                <td>Samsung</td>
                                                                                <td>S7 Edge</td>
                                                                                <td>CPU 1050</td>
                                                                                <td>Phone</td>
                                                                                <td>On Hand</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><input type="checkbox"></td>
                                                                                <td>PC-0001</td>
                                                                                <td>Samsung</td>
                                                                                <td>S7 Edge</td>
                                                                                <td>CPU 1050</td>
                                                                                <td>Phone</td>
                                                                                <td>On Hand</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><input type="checkbox"></td>
                                                                                <td>PC-0001</td>
                                                                                <td>Samsung</td>
                                                                                <td>S7 Edge</td>
                                                                                <td>CPU 1050</td>
                                                                                <td>Phone</td>
                                                                                <td>On Hand</td>
                                                                            </tr>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                </form>
                                                            </div>
                                                            <br><br>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-primary" type="submit" onclick="getData('tblRequest');">Send</button>
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- Modal End-->

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
		
		
		
        $.ajax({
            type: "POST",
            url: "count.php",
            data: 'count=' + count,
            success: function(data) {
                $("#count").html(data);

            }
        });

        }

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
    </script>

</body>

</html>