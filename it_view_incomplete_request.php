<!DOCTYPE html>

<!-- Notes
1. canvasItemID in canvasitem table needs to be in auto-increment for it to work 
-->

<?php
session_start();
require_once('db/mysql_connect.php');
$requestID=$_GET['requestID'];
$_SESSION['requestID']=$requestID;
$_SESSION['previousPage2']="it_view_incomplete_request.php?requestID=".$requestID;

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
				<?php
                    if (isset($_SESSION['submitMessage'])){

                        echo "<div class='alert alert-success'>
                                {$_SESSION['submitMessage']}
							  </div>";
                        unset($_SESSION['submitMessage']);
                    }
				?>
                <div class="row">
                    <div class="row">
                        <div class="col-sm-12">
                            <section class="panel">
                                <header class="panel-heading">
                                    Request
                                </header>
                                <div class="panel-body">
                                    <section id="unseen">
                                        <div class="row invoice-to">
                                            <div class="col-md-4 col-sm-4 pull-left">
                                                <a href="it_add_brand.php" target="_blank"><button class="btn btn-primary" type="button">Add Brand</button></a>
                                                <a href="it_add_product.php" target="_blank"><button class="btn btn-info" type="button">Add Product</button></a>
                                                <!--<h4>Status:</h4>
                                                <h2>Incomplete</h2>-->
                                            </div>
                                            <div class="col-md-4 col-sm-5 pull-right">
                                                <div class="row">
                                                    <br><br>
                                                    <div class="col-md-4 col-sm-5 inv-label">Request #</div>
                                                    <div class="col-md-8 col-sm-7">221</div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-5 inv-label">Date Needed </div>
                                                    <div class="col-md-8 col-sm-7">21 December 2018</div>
                                                </div>
                                                <br>


                                            </div>
                                        </div>
										
										<h4><b>Items Requested</b></h4>
                                        <table class="table table-bordered table-striped table-condensed table-hover" id="table">
                                            <thead>
                                                <tr>
                                                    <th>Quantity</th>
                                                    <th>Category</th>
                                                    <th>Specifications</th>
                                                    <th>Asset Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               
												<?php
												
												//$query1="SELECT ci.cavasItemID as `canvasItemID`,ci.quantity as `canvasQty`,rac.name as `categoryName`,rb.name as `brandName`,am.description as 'modelDesc',am.itemSpecification as `itemSpec` FROM thesis.canvasitem ci 
													//							   join assetmodel am on ci.assetModel=am.assetModelID
														//						   join ref_brand rb on am.brand=rb.brandID
															//					   join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
												//where ci.canvasID='{$row['canvasID']}'";
												
												$query1="SELECT * FROM thesis.requestdetails rd join ref_assetcategory rac on rd.assetCategory=rac.assetCategoryID where rd.requestID='{$requestID}'";
												$result1=mysqli_query($dbc,$query1);
												
												while($row1=mysqli_fetch_array($result1,MYSQLI_ASSOC)){
													
													echo "<tr>
															<td style='width:50px;'>{$row1['quantity']}</td>
															<td>{$row1['name']}</td>
															<td>{$row1['description']}</td>
															<td>{$row1['purpose']}</td>
														</tr>";	
												}
											?>
                                            </tbody>
                                        </table>
										
										<h4><b>Items To Be Purchased</b></h4>
										<form method="post" id="formSend" action="it_view_incomplete_request_DB.php">
                                        <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                            <thead>
                                                <tr>
                                                    <th>Quantity</th>
                                                    <th>Category</th>
                                                    <th>Brand</th>
                                                    <th>Model</th>
                                                    <th>Specification</th>
                                                    <th>Remove Row</th>
                                                    <th>Add New Brand</th>
                                                </tr>
                                            </thead>
                                            <tbody>
												<?php
												
												//$query1="SELECT ci.cavasItemID as `canvasItemID`,ci.quantity as `canvasQty`,rac.name as `categoryName`,rb.name as `brandName`,am.description as 'modelDesc',am.itemSpecification as `itemSpec` FROM thesis.canvasitem ci 
													//							   join assetmodel am on ci.assetModel=am.assetModelID
														//						   join ref_brand rb on am.brand=rb.brandID
															//					   join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
												//where ci.canvasID='{$row['canvasID']}'";
												
												$query1="SELECT * FROM thesis.requestdetails rd join ref_assetcategory rac on rd.assetCategory=rac.assetCategoryID where rd.requestID='{$requestID}'";
												$result1=mysqli_query($dbc,$query1);
												
												while($row1=mysqli_fetch_array($result1,MYSQLI_ASSOC)){
													
													$reqCode=$row1['requestID']."_".$row1['assetCategory']."_".$row1['quantity'];
													echo "<tr>
														<input type='hidden' name='assetCatID[]' class='assetCatIDs' value='{$row1['assetCategory']}'>
														<input type='hidden' name='assetCatQtys[]' class='assetCatQtys' value='{$row1['quantity']}'>
														<td style='width:50px;'>{$row1['quantity']}</td>
														<td>{$row1['name']}</td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
														<td><button type='button' class='btn btn-primary' onclick='addTest(\"{$reqCode}\")'> Add New Brand</button></td>
													</tr>";	
												}
											?>
                                            </tbody>
                                        </table>
										<div style="padding-top:10px">
											<button type="button" class="btn btn-success" onclick="formSubmit()" name="btnSubmit">Submit</button>
                                            <button type="button" class="btn btn-danger" onclick="window.history.back();"> Back</button>
                                        </div>
										
										</form>
										
                                        


                                    </section>

                                </div>
                            </section>
                        </div>
                    </div>
                    <!-- page end-->
                    <!--main content end-->




                    <script>
                        //Delete buttons
                        function removeRow(o) {
                            var p = o.parentNode.parentNode;
                            p.parentNode.removeChild(p);
                        }
                        //Add new button
                        function AddRow() {
                            //Get the reference of the Table's TBODY element.
                            var tBody = document.getElementById("mytable").getElementsByTagName("TBODY")[0];
                            //Add Row.
                            row = tBody.insertRow();
                            //Add Quantity.
                            var cell = row.insertCell();
                            cell.innerHTML = "<td><input type='number' min='1' class='form-control'></td>";
                            //Add Item name
                            cell = row.insertCell();
                            cell.innerHTML = "<td><select class='form-control'><option>Select Item</option><option>Laptop</option></td>";
                            //Add Specification.
                            cell = row.insertCell();
                            cell.innerHTML = "<td><select class='form-control'><option>Select Item</option><option>Acer</option></td>";
                            //Add toCheck.
                            cell = row.insertCell();
                            cell.innerHTML = "<td><select class='form-control'><option>Select Item</option><option>Aspire E14</option></td>";
                            //Add button.
                            cell = row.insertCell();
                            cell.innerHTML = "<td class='text-center'><input class='form-control' type='text'></td>";
                            //Add button.
                            cell = row.insertCell();
                            cell.innerHTML = "<td class='text-center'><button class='btn btn-warning' onclick='removeRow(this)'>Remove Row</button></td>";
                        }
                    </script>

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
						// Shorthand for $( document ).ready()
                        $(function() {
                        });
						var clicks = 0;
                        function addTest(reqCode,maxQty) {
							clicks++;
                            var row_index = 0;
							var codeStr=""+reqCode;
                            var isRenderd = false;
							var codeArr = codeStr.split("_");
							var requestID = parseInt(codeArr[0]);
							var assetCategory = parseInt(codeArr[1]);
							var qty = parseInt(codeArr[2]);
							
                            $("td").click(function() {
                                row_index = $(this).parent().index();
                            });
                            var delayInMilliseconds = 300; //1 second
                            setTimeout(function() {
								if(checkAllQty(assetCategory,qty)){
									 appendTableRow(row_index,requestID,assetCategory,qty,reqCode,clicks);
								}
                            }, delayInMilliseconds);
                        }
						
						function checkAllQty(assetCategory,maxQty) {
							var sumQty=0;
							var x = document.getElementsByClassName("assetCatQty"+assetCategory);
							for(var i=0;i<x.length;i++){
								var inVal=parseInt(x[i].value);
								sumQty+=inVal;
							}
							
							if(sumQty<maxQty){
								return true;
								
							}
							return false;
						}
						
						function getCategory(assetCategory,clicks){
							var xmlhttp = new XMLHttpRequest();
							var code = "exampleFormControlSelect1" + clicks;
							xmlhttp.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
									document.getElementById(code).innerHTML = this.responseText;
								}
							};
							xmlhttp.open("GET", "asset_category_ajax.php?category=" + assetCategory, true);
							xmlhttp.send();
							getBrand(assetCategory,clicks);
						}
						
						function getBrand(assetCategory,clicks){
							var code = "exampleFormControlSelect2" + clicks;
							var xmlhttp = new XMLHttpRequest();
							xmlhttp.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
									document.getElementById(code).innerHTML = this.responseText;
								}
							};
							xmlhttp.open("GET", "brand_ajax.php?category=" + assetCategory, true);
							xmlhttp.send();
							
						}
						function getModel(clicks){
							var code1 = "exampleFormControlSelect1" + clicks;
							var code2 = "exampleFormControlSelect2" + clicks;
							var code3 = "exampleFormControlSelect3" + clicks;
							var category=document.getElementById(code1).value;
							var brand=document.getElementById(code2).value;
							var xmlhttp = new XMLHttpRequest();
							xmlhttp.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
									document.getElementById(code3).innerHTML = this.responseText;
								}
							};
							xmlhttp.open("GET", "model_ajax.php?category=" + category + "&brand=" + brand, true);
							xmlhttp.send();
							
						}
						function getSpecs(clicks){
							var code3 = "exampleFormControlSelect3" + clicks;
							var model=document.getElementById(code3).value;
							var xmlhttp = new XMLHttpRequest();
							xmlhttp.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
									document.getElementById("specs"+clicks).value = this.responseText;
								}
							};
							xmlhttp.open("GET", "specs_ajax.php?modelID=" + model, true);
							xmlhttp.send();
						}
						
						//var appendTableRow = function(rowCount) {
                        var appendTableRow = function(rowCount,requestID,assetCategory,qty,reqCode,clicks) {
                            var cnt = 0;
                            var tr = "<tr>" +
                                "<td><input type='number' class='form-control assetCatQty"+ assetCategory +"' min='1' name='qty[]' max='" + qty + "' value='"+ qty +"' required></td>" +
                                "<td>" +
								"<select class='form-control' id='exampleFormControlSelect1" + clicks + "' name='category[]' readonly>" +
                                "</select>" +
								"</td>"+
								
                                "<td>" +
                                "<select class='form-control' id='exampleFormControlSelect2" + clicks + "' required name='brand[]' onchange='getModel(\"" + clicks + "\")'>" +
                                "<option selected disabled>Select Brand</option>" +
                                "</select>" +
								"</td>" +
                                "<td>" +
                                "<select class='form-control' id='exampleFormControlSelect3" + clicks + "' name='model[]' required onchange='getSpecs(\"" + clicks + "\")'>" +
                                "<option selected disabled>Select Model</option>" +
                                "</select>" +
                                "</td>" +
                                "<td>" +
                                "<div class='form-group'>" +
                                "<dive class='col-lg-10'>" +
                                "<input type='text' class='form-control' id='specs" + clicks + "' placeholder='Specification' name='specs[]' required readonly>" +
                                "</div>" +
                                "</div>" +
                                "</td>" +
								
                                "<td class='text-center'>" +
                                "<button id='remove' class='btn btn-warning' onClick='removeRow(this)'>Remove</button> " +
                                "</td>" +
								"<td class='text-center'>" +
								"</td>" +
                                "</tr>";
                            $('#tableTest tbody tr').eq(rowCount).after(tr);
							getCategory(assetCategory,clicks);
                        }
						
						function formSubmit(){
							var assetCatIDs  = document.getElementsByClassName("assetCatIDs");
							var assetCatQtys  = document.getElementsByClassName("assetCatQtys");
							var isQtyCorrect = true;
							var message="";
							
							for(var i=0;i<assetCatIDs.length;i++){
								var x = document.getElementsByClassName("assetCatQty"+assetCatIDs[i].value);
								var sumQty=0;
								
								for(var j=0;j<x.length;j++){
									var inVal=parseInt(x[j].value);
									
									sumQty+=inVal;
								}
								
								if(sumQty!=assetCatQtys[i].value){
									isQtyCorrect=false;
									message+="Quantities entered reach the maximum quantity";
								}
							}
							
							if(isQtyCorrect==true){
								document.getElementById("formSend").submit();
							}
							else{
								alert(message);
							}
							
						}
						
					</script>
                    <!-- <script type="text/javascript">
                        // Shorthand for $( document ).ready()
                        $(function() {
                        });
                        function addTest() {
                            var row_index = 0;
                            var isRenderd = false;
                            $("td").click(function() {
                                row_index = $(this).parent().index();
                            });
                            var delayInMilliseconds = 0; //1 second
                            setTimeout(function() {
                                appendTableRow(row_index);
                            }, delayInMilliseconds);
                        }
                        var appendTableRow = function(rowCount) {
                            var cnt = 0
                            var tr = "<tr>" +
                                "<td><input type='number' class='form-control' min='0.00' required></td>" +
                                "<td>" +
                                "<select class='form-control' id='exampleFormControlSelect1' required>" +
                                " <option>Select Category</option>" +
                                "<option>Laptop</option>" +
                                "<option>Adapter</option>" +
                                "<option>Flashdrive</option>" +
                                "</select>" +
                                "<td>" +
                                "<select class='form-control' id='exampleFormControlSelect1' required>" +
                                " <option>Select Brand</option>" +
                                "<option>Samsung</option>" +
                                "<option>Huawei</option>" +
                                "<option>Xiami</option>" +
                                "</select>" +
                                "<td>" +
                                "<select class='form-control' id='exampleFormControlSelect1' required>" +
                                " <option>Select Model</option>" +
                                "<option>GT232</option>" +
                                "<option>S9</option>" +
                                "<option>Nova 2</option>" +
                                "</select>" +
                                "</td>" +
                                "<td>" +
                                "<div class='form-group'>" +
                                "<dive class='col-lg-10'>" +
                                "<input type='text' class='form-control' id='specs'' placeholder='Specification''>" +
                                "</div>" +
                                "</div>" +
                                "</td>" +
                                "<td class='text-center'>" +
                                "<button id='remove' class='btn btn-warning' onClick='removeRow(this)'>Remove</button> "
                                "</td>" +
                                "</tr>";
                            $('#tableTest tbody tr').eq(rowCount).after(tr);
                        }
                    </script>-->
</body>

</html>