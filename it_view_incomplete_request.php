<!DOCTYPE html>

<!-- Notes
1. canvasItemID in canvasitem table needs to be in auto-increment for it to work 
-->

<?php
session_start();
require_once('db/mysql_connect.php');
$_SESSION['requestID']=$_GET['requestID'];

$query="SELECT * FROM thesis.canvas 
				 where requestID='{$_SESSION['requestID']}'";
$result=mysqli_query($dbc,$query);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

if(isset($_POST['submit'])){
	
	$quantityArray=$_POST['qty'];
	$categoryArray=$_POST['category'];
	$brandArray=$_POST['brand'];
	$modelArray=$_POST['model'];
	//$specsArray=$_POST['specs'];
	
	$count = sizeof($modelArray);
	
	//auto increment for canvasItemID
	for ($i=0; $i < $count; $i++) { 
		$querya="INSERT INTO `thesis`.`canvasitem` (`canvasID`, `quantity`, `assetCategory`, `assetModel`) VALUES ('{$row['canvasID']}', '{$quantityArray[$i]}', '{$categoryArray[$i]}', '{$modelArray[$i]}')";
		$resulta=mysqli_query($dbc,$querya);
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
                    Welcome IT Officer!
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
                        <div class="col-sm-12">
                            <section class="panel">
                                <header class="panel-heading">
                                    Request
                                </header>
                                <div class="panel-body">
                                    <section id="unseen">
                                        <div class="row invoice-to">
                                            <div class="col-md-4 col-sm-4 pull-left">
                                                <h4>Status:</h4>
                                                <h2>Incomplete</h2>
                                            </div>
                                            <div class="col-md-4 col-sm-5 pull-right">
                                                <div class="row">
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
										<form method="post">
                                        <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                            <thead>
                                                <tr>
                                                    <th>Quantity</th>
                                                    <th>Category</th>
                                                    <th>Brand</th>
                                                    <th>Model</th>
                                                    <th>Specification</th>
                                                    <th>Remove</th>
                                                    <th>Add</th>
                                                </tr>
                                            </thead>
                                            <tbody>
												<?php
												
												$query1="SELECT ci.cavasItemID as `canvasItemID`,ci.quantity as `canvasQty`,rac.name as `categoryName`,rb.name as `brandName`,am.description as 'modelDesc',am.itemSpecification as `itemSpec` FROM thesis.canvasitem ci 
																				   join assetmodel am on ci.assetModel=am.assetModelID
																				   join ref_brand rb on am.brand=rb.brandID
																				   join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
												where ci.canvasID='{$row['canvasID']}'";
												$result1=mysqli_query($dbc,$query1);
												
												while($row1=mysqli_fetch_array($result1,MYSQLI_ASSOC)){
													
													echo "<tr>
														<td style='width:50px;'>{$row1['canvasQty']}</td>
														<td>{$row1['categoryName']}</td>
														<td>{$row1['brandName']}</td>
														<td>{$row1['modelDesc']}</td>
														<td>{$row1['itemSpec']}</td>
														<td></td>
														<td><button type='button' class='btn btn-primary' onclick='addTest({$row1['canvasItemID']})'> Add </button></td>
														
													</tr>";	
												}
											?>
                                                <!-- <tr>
                                                    <td style="width:50px;">5</td>
                                                    <td>Laptop</td>
                                                    <td>Apple</td>
                                                    <td>MAC 122121</td>
                                                    <td>4Gb RAM and 1020 GForce 1</td>
                                                    <td></td>
                                                    <td><button class="btn btn-primary" onclick="addTest(4)"> Add </button></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:50px;">5</td>
                                                    <td>Laptop</td>
                                                    <td>Apple</td>
                                                    <td>MAC 122121</td>
                                                    <td>4Gb RAM and 1020 GForce 1</td>
                                                    <td></td>
                                                    <td><button class="btn btn-primary" onclick="addTest(3)"> Add </button></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:50px;">5</td>
                                                    <td>Laptop</td>
                                                    <td>Apple</td>
                                                    <td>MAC 122121</td>
                                                    <td>4Gb RAM and 1020 GForce 1</td>
                                                    <td></td>
                                                    <td><button class="btn btn-primary" onclick="addTest(2)"> Add </button></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:50px;">5</td>
                                                    <td>Laptop</td>
                                                    <td>Apple</td>
                                                    <td>MAC 122121</td>
                                                    <td>4Gb RAM and 1020 GForce 1</td>
                                                    <td></td>
                                                    <td><button class="btn btn-primary" onclick="addTest(1)"> Add </button></td>
                                                </tr> -->
                                            </tbody>
                                        </table>
										<div style="padding-top:10px">
											<button type="submit" class="btn btn-success" name="submit">Submit</button>
                                            <a href="it_requests.php"><button type="button" class="btn btn-danger glyphicon glyphicon-chevron-left"> Back</button></a>
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
                            cell.innerHTML = "<td class='text-center'><button class='btn btn-warning' onclick='removeRow(this)'>Remove</button></td>";
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
						function getBrand(){
							var category=document.getElementById("exampleFormControlSelect1").value;
							var xmlhttp = new XMLHttpRequest();
							xmlhttp.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
									document.getElementById("exampleFormControlSelect2").innerHTML = this.responseText;
								}
							};
							xmlhttp.open("GET", "brand_ajax.php?category=" + category, true);
							xmlhttp.send();
							
						}
						function getModel(){
							var category=document.getElementById("exampleFormControlSelect1").value;
							var brand=document.getElementById("exampleFormControlSelect2").value;
							var xmlhttp = new XMLHttpRequest();
							xmlhttp.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
									document.getElementById("exampleFormControlSelect3").innerHTML = this.responseText;
								}
							};
							xmlhttp.open("GET", "model_ajax.php?category=" + category + "&brand=" + brand, true);
							xmlhttp.send();
							
						}
						function getSpecs(){
							var model=document.getElementById("exampleFormControlSelect3").value;
							var xmlhttp = new XMLHttpRequest();
							xmlhttp.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
									document.getElementById("specs").value = this.responseText;
								}
							};
							xmlhttp.open("GET", "specs_ajax.php?modelID=" + model, true);
							xmlhttp.send();
						}
						
                        var appendTableRow = function(rowCount) {
                            var cnt = 0;
                            var tr = "<tr>" +
                                "<td><input type='number' class='form-control' min='0.00' name='qty[]' required></td>" +
                                "<td>" +
                                "<select class='form-control' id='exampleFormControlSelect1' required name='category[]' onchange='getBrand()'>" +
								"<option>Select Category</option>" +
								"<?php
									$query9="SELECT * FROM thesis.ref_assetcategory";
									$result9=mysqli_query($dbc,$query9);
									while($row9=mysqli_fetch_array($result9,MYSQLI_ASSOC)){
										echo "<option value='{$row9['assetCategoryID']}'>{$row9['name']}</option>";
									}
									
								?>"
								+
                                "</select>" +
                                "<td>" +
                                "<select class='form-control' id='exampleFormControlSelect2' required name='brand[]' onchange='getModel()'>" +
                                "<option selected disabled>Select Brand</option>" +
                                "</select>" +
                                "<td>" +
                                "<select class='form-control' id='exampleFormControlSelect3' name='model[]' required onchange='getSpecs()'>" +
                                "<option selected disabled>Select Model</option>" +
                                "</select>" +
                                "</td>" +
                                "<td>" +
                                "<div class='form-group'>" +
                                "<dive class='col-lg-10'>" +
                                "<input type='text' class='form-control' id='specs' placeholder='Specification' name='specs[]' disabled>" +
                                "</div>" +
                                "</div>" +
                                "</td>" +
                                "<td class='text-center'>" +
                                "<button id='remove' class='btn btn-warning' onClick='removeRow(this)'>Remove</button> "
                                "</td>" +
                                "</tr>";
								
								
								
								
                            $('#tableTest tbody tr').eq(rowCount).after(tr);
							
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