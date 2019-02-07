<!DOCTYPE html>
<!--Notes
1. Check the PK of supplier_supplierID on canvasitemdetails table 

 -->
<?php
	$canvasID=$_GET['canvasID'];
	
	
	require_once('db/mysql_connect.php');
	if (isset($_POST['submit'])){
		$canvasItemID=$_POST['cavasItemID'];
		$supplier=$_POST['supplier'];
		$unitPrice=$_POST['unitPrice'];
		$count = sizeof($canvasItemID);
		for ($i=0; $i < $count; $i++) { 
			$querya="INSERT INTO `thesis`.`canvasitemdetails` (`cavasItemID`, `supplier_supplierID`, `price`, `status`) VALUES ('{$canvasItemID[$i]}', '{$supplier[$i]}', '{$unitPrice[$i]}', '1')";
			$resulta=mysqli_query($dbc,$querya);
		}
		
		$queryReqID="SELECT requestID FROM thesis.canvas where canvasID='{$canvasID}'";
		$resultReqID=mysqli_query($dbc,$queryReqID);
		$rowReqID=mysqli_fetch_array($resultReqID,MYSQLI_ASSOC);
		
		$queryd="UPDATE `thesis`.`request` SET `step`='4' WHERE `requestID`='{$rowReqID['requestID']}'";
		$resultd=mysqli_query($dbc,$queryd);
		
		$message = "Form submitted!";
		$_SESSION['submitMessage'] = $message;
		
		//$queryb="UPDATE `thesis`.`canvas` SET `status`='6' WHERE `canvasID`='{$canvasID}'";
		//$resultb=mysqli_query($dbc,$queryb);
		
		//$queryc="SELECT requestID FROM thesis.canvas where canvasID='{$canvasID}'";
		//$resultc=mysqli_query($dbc,$queryc);
		//$rowc=mysqli_fetch_array($resultc,MYSQLI_ASSOC);
		
		//$queryd="UPDATE `thesis`.`request` SET `status`='6' WHERE `requestID`='{$rowc['requestID']}'";
		//$resultd=mysqli_query($dbc,$queryd);
	}
	
	if(isset($_POST['save'])){
		$companyName=$_POST['companyName'];
		$contactPerson=$_POST['contactPerson'];
		$number=$_POST['number'];
		$email=$_POST['email'];
		$address=$_POST['address'];

		$queryo="INSERT INTO `thesis`.`supplier` (`name`, `contactNo`, `email`, `contactPerson`, `address`) VALUES ('{$companyName}', '{$number}', '{$email}', '{$contactPerson}', '{$address}')";
		$resulto=mysqli_query($dbc,$queryo);
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

    <link rel="stylesheet" href="css/bootstrap-switch.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-timepicker/compiled/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datetimepicker/css/datetimepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery-multi-select/css/multi-select.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery-tags-input/jquery.tagsinput.css" />
    <link href="js/advanced-datatable/css/demo_page.css" rel="stylesheet" />
    <link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/data-tables/DT_bootstrap.css" />

    <link rel="stylesheet" type="text/css" href="js/select2/select2.css" />

    <!-- Custom styles for this template -->
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
        <?php include 'procurement_navbar.php' ?>

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

                        <div class="row">
                            <div class="col-sm-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        Start Canvas
                                    </header>
                                    <div class="panel-body">
                                        <section id="unseen">
											<!-- <form method="post"> -->
												<div style="float:right; padding-right:10px; padding-top:8px">
													<button type="button" class="btn btn-info" data-toggle="modal" data-target="#supplierModal">New Supplier</button>
													<br>
													<br>
													<br>
												</div>
												<form method="post">
												<!-- Modal -->
												<div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
																<h5 class="modal-title" id="exampleModalLongTitle">Add New Supplier</h5>
															
															</div>
															<div class="modal-body">
																<form class="cmxform form-horizontal " id="signupForm" method="post">
																	<div class="form-group ">
																		<label for="companyName">Company Name</label>
																		<div>
																			<input class="form-control" id="companyName" name="companyName" type="text" required />
																		</div>
																	</div>

																	<div class="form-group ">
																		<label for="contactPerson">Contact Person</label>
																		<div>
																			<input class="form-control" id="contactPerson" name="contactPerson" type="text" required />
																		</div>
																	</div>

																	<div class="form-group ">
																		<label for="lastname">Contact Number</label>
																		<div>
																			<input class="form-control" id="number" name="number" type="text" required />
																		</div>
																	</div>

																	<div class="form-group ">
																		<label for="email">Email (DLSU)</label>
																		<div>
																			<input class="form-control " id="email" name="email" pattern=".+dlsu.edu.ph" type="email" required />
																		</div>
																	</div>

																	<div class="form-group">
																		<label>Address</label>
																		<div name="address" id="address">
																			<textarea style="resize: none" class="form-control" rows="3" name="address" required></textarea>
																		</div>
																	</div>
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3"><br>Associate Product to Supplier</label>
                                                                        <div class="col-md-9">
                                                                            <br>
                                                                            ** Place Product on Right To Associate
                                                                            <select name="country" class="multi-select" multiple="" id="my_multi_select3">
                                                                                <option>Lenovo BHT 940</option>
                                                                                <option>ROG GTX-1940</option>
                                                                                <option>Logitech Mouse</option>
                                                                                <option>Samsung Galaxy S7 Edge</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
																</form>
															</div>
															<div class="modal-footer">
																<button type="submit" name="save" class="btn btn-primary">Save </button>
																<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
															</div>
														</div>
													</div>
												</div>
												<!-- Modal -->
												</form>
											<form method="post">
                                            <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                <thead>
                                                    <tr>
                                                        <th>Quantity</th>
                                                        <th>Item</th>
                                                        <th>Specification</th>
                                                        <th>Supplier</th>
                                                        <th>Unit Price in Php</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
												<tbody>
													<?php
														
														
														$query="SELECT ci.cavasItemID,CONCAT(rb.name, ' ',rac.name) as `itemName`,ci.quantity,am.itemSpecification,ci.description,am.description as `assetModel` FROM thesis.canvasitem ci 
															join assetmodel am on ci.assetModel=am.assetModelID
															join ref_brand rb on am.brand=rb.brandID
															join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID 
															where ci.canvasID='{$canvasID}'";
														$result=mysqli_query($dbc,$query);
														while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
															
																echo "<tr>
																	<input type='hidden' name='cavasItemID[]' value='{$row['cavasItemID']}'>
																	<td style='width:50px;'>{$row['quantity']}</td>
																	<td>{$row['assetModel']}</td>
																	<td>{$row['itemSpecification']}</td>
																	<td>
																		<select class='form-control' id='exampleFormControlSelect1' name='supplier[]' required>
																		<option selected disabled>Select Supplier</option>";
		;
																		$query1="SELECT * FROM thesis.supplier";
																		$result1=mysqli_query($dbc,$query1);
																		while($row1=mysqli_fetch_array($result1,MYSQLI_ASSOC)){
																			echo "<option value='{$row1['supplierID']}'>{$row1['name']}</option>";
																		}
																	echo "</select>
																	</td>
																	<td><input type='number' class='form-control' min='0.00' name='unitPrice[]' required></td>
																	<td><button type='button' class='btn btn-primary' onclick='addTest({$row['cavasItemID']})'> Add </button></td>
																</tr>";
															
															
														}
													
													
													
													
													
													?>
												</tbody>
                                                <!-- <tbody>
                                                    <tr>
                                                        <td style="width:50px;">5</td>
                                                        <td>MAC Laptop</td>
                                                        <td>IPAD</td>
                                                        <td>
                                                            <select class="form-control" id="exampleFormControlSelect1" required>
                                                                <option>Select Supplier</option>
                                                                <option>ABC Corp.</option>
                                                                <option>Philippine Sports Commission</option>
                                                                <option>CDR-King</option>
                                                                <option>Huawei</option>
                                                                <option>Samsung</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="number" class="form-control" min="0.00" required></td>
                                                        <td><button class="btn btn-primary" onclick="addTest(4)"> Add </button></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:50px;">5</td>
                                                        <td>Windows</td>
                                                        <td>Windows 10</td>
                                                        <td>
                                                            <select class="form-control" id="exampleFormControlSelect1" required>
                                                                <option>Select Supplier</option>
                                                                <option>ABC Corp.</option>
                                                                <option>Philippine Sports Commission</option>
                                                                <option>CDR-King</option>
                                                                <option>Huawei</option>
                                                                <option>Samsung</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="number" class="form-control" min="0.00" required></td>
                                                        <td><button class="btn btn-primary" onclick="addTest(3)"> Add </button></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:50px;">5</td>
                                                        <td>Desktop</td>
                                                        <td>MAC PC</td>
                                                        <td>
                                                            <select class="form-control" id="exampleFormControlSelect1" required>
                                                                <option>Select Supplier</option>
                                                                <option>ABC Corp.</option>
                                                                <option>Philippine Sports Commission</option>
                                                                <option>CDR-King</option>
                                                                <option>Huawei</option>
                                                                <option>Samsung</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="number" class="form-control" min="0.00" required></td>
                                                        <td><button class="btn btn-primary" onclick="addTest(2)"> Add </button></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:50px;">5</td>
                                                        <td>Projector</td>
                                                        <td>Epson 101</td>
                                                        <td>
                                                            <select class="form-control" id="exampleFormControlSelect1" required>
                                                                <option>Select Supplier</option>
                                                                <option>ABC Corp.</option>
                                                                <option>Philippine Sports Commission</option>
                                                                <option>CDR-King</option>
                                                                <option>Huawei</option>
                                                                <option>Samsung</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="number" class="form-control" min="0.00" required></td>
                                                        <td><button class="btn btn-primary" onclick="addTest(1)"> Add </button></td>
                                                    </tr>
                                                </tbody> -->
                                            </table>

                                            <div>
                                                <button type="submit" class="btn btn-success" name="submit" data-dismiss="modal">Send</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                            </div>
											</form>
                                        </section>
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
<script src="js/jquery-1.8.3.min.js"></script>
<script src="bs3/js/bootstrap.min.js"></script>
<script src="js/jquery-ui-1.9.2.custom.min.js"></script>
<script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<script src="js/jquery.nicescroll.js"></script>
<script src="js/jquery.nicescroll.js"></script>

<script src="js/bootstrap-switch.js"></script>

<script type="text/javascript" src="js/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="js/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script type="text/javascript" src="js/jquery-multi-select/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="js/jquery-multi-select/js/jquery.quicksearch.js"></script>
<script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
<script type="text/javascript" src="js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>

<script src="js/jquery-tags-input/jquery.tagsinput.js"></script>

<script src="js/select2/select2.js"></script>
<script src="js/select-init.js"></script>


<!--common script init for all pages-->
<script src="js/scripts.js"></script>

<script src="js/toggle-init.js"></script>

<script src="js/advanced-form.js"></script>
<script src="js/dynamic_table_init.js"></script>

    
    <script type="text/javascript">
		$(document).ready(function() {
		/* btn click event */
		$('#addmore').click(function(){
        /* append selectbox where you want */
        $("#target").append('<select><option value="">select</option></select>')
			});
	});
	</script>

	<script>
        

        function addTest(cavasItemID) {
            var row_index = 0;
			var canvasItemID=cavasItemID;
            var isRenderd = false;

            $("td").click(function() {
                row_index = $(this).parent().index();

            });

            var delayInMilliseconds = 300; //1 second

            setTimeout(function() {

                appendTableRow(row_index,canvasItemID);
            }, delayInMilliseconds);



        }

        var appendTableRow = function(rowCount,canvasItemID) {
            var cnt = 0;
            var tr = "<tr>" +
				"<input type='hidden' name='cavasItemID[]' value='"+ canvasItemID +"'>"+
                "<td style='width:50px;'></td>" +
                "<td></td>" +
                "<td></td>" +
                "<td>" +
                "<select class='form-control' id='exampleFormControlSelect1' name='supplier[]' required>" +
                "<option value=''>Select Supplier</option>" +
                "<?php 
						$query2="SELECT * FROM thesis.supplier";
						$result2=mysqli_query($dbc,$query2);
						while($row2=mysqli_fetch_array($result2,MYSQLI_ASSOC)){
							echo "<option value='{$row2['supplierID']}'>{$row2['name']}</option>";
						} ?>" +
                "</select>" +
                "</td>" +
                "<td><input type='number' class='form-control' min='0.00' name='unitPrice[]' required></td>" +
                "</tr>";
            $('#tableTest tbody tr').eq(rowCount).after(tr);
        }
    </script>


</body>

</html>