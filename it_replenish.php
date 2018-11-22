<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	$forReplenish=$_SESSION['forReplenish'];
	
	if(isset($_POST['submit'])){
		//CREATE REQUEST
		$queryReq="INSERT INTO `thesis`.`request` (`date`, `UserID`, `status`, `step`) VALUES (now(), '{$_SESSION['userID']}', '2', '3')";
		$resultReq=mysqli_query($dbc,$queryReq);
		
		//GET LATEST REQUEST
		$queryLatReq="SELECT * FROM thesis.request order by requestID desc limit 1";
		$resultLatReq=mysqli_query($dbc,$queryLatReq);
		$rowLatReq=mysqli_fetch_array($resultLatReq, MYSQLI_ASSOC);
		
		//CREATE CANVAS
		$queryCan="INSERT INTO `thesis`.`canvas` (`requestID`, `status`) VALUES ('{$rowLatReq['requestID']}', '1')";
		$resultCan=mysqli_query($dbc,$queryCan);
		
		//GET LATEST CANVAS
		$queryLatCan="SELECT * FROM thesis.canvas order by canvasID desc limit 1";
		$resultLatCan=mysqli_query($dbc,$queryLatCan);
		$rowLatCan=mysqli_fetch_array($resultLatCan, MYSQLI_ASSOC);
		
		//INSERT to CANVASITEM
		$assetCat=$_POST['assetCat'];
		$quantity=$_POST['quantity'];
		$model=$_POST['model'];
		
		$mi = new MultipleIterator();
		$mi->attachIterator(new ArrayIterator($assetCat));
		$mi->attachIterator(new ArrayIterator($quantity));
		$mi->attachIterator(new ArrayIterator($model));
		
		foreach ( $mi as $value ) {
			list($assetCat, $quantity, $model) = $value;
			$queryCanItem="INSERT INTO `thesis`.`canvasitem` (`canvasID`, `quantity`, `assetCategory`, `assetModel`) VALUES ('{$rowLatCan['canvasID']}', '{$quantity}', '{$assetCat}', '{$model}')";
			$resultCanItem=mysqli_query($dbc,$queryCanItem);
		}
		
		//GET SUM OF QTY ORDERED
		$queryLatQty="SELECT assetCategory, SUM(quantity) as `totalQty` FROM thesis.canvasitem where canvasID='{$rowLatCan['canvasID']}' group by assetCategory";
		$resultLatQty=mysqli_query($dbc,$queryLatQty);
		while($rowLatQty=mysqli_fetch_array($resultLatQty, MYSQLI_ASSOC)){
			//INSERT TO REQUESTDETAILS
			$queryReqDet="INSERT INTO `thesis`.`requestdetails` (`requestID`, `quantity`, `assetCategory`) VALUES ('{$rowLatReq['requestID']}', '{$rowLatQty['totalQty']}', '{$rowLatQty['assetCategory']}')";
			$resultReqDet=mysqli_query($dbc,$queryReqDet);
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
                    <div class="col-sm-12">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="panel">
                                        <header class="panel-heading">
                                            Stock List

                                        </header>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <section class="panel">
                                                        <div class="panel-body">
                                                        <form method="post">
                                                                <div class="adv-table">
                                                                    <table class="table table-bordered table table-hover" id="tableTest">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="text-align:center"><input type="checkbox" disabled></th>
                                                                                <th>Asset Category</th>
                                                                                <th>Floor</th>
                                                                                <th>Ceiling</th>
                                                                                <th>Total Quantity</th>
                                                                                <th>To Buy</th>
                                                                                <th>Brand</th>
                                                                                <th>Model</th>
                                                                                <th>Add</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
																			<?php
																				//GET FOR REPLENISH DATA
																				$count=0;
																				foreach($forReplenish as $forRep){
																					$code="0".$count;
																					$queryForRep = "SELECT i.assetCategoryID,rac.name as `assetCat`,i.floorLevel,i.ceilingLevel, count(IF(a.assetStatus = 1, a.assetID, null)) as `stockOnHand`,count(IF(a.assetStatus = 2, a.assetID, null)) as `borrowed`, count(IF(a.assetStatus = 2 or a.assetStatus = 1, a.assetID, null)) as `totalQty` FROM thesis.inventory i join ref_assetcategory rac on i.assetCategoryID=rac.assetCategoryID
																							 join assetmodel am on i.assetCategoryID=am.assetCategory
																							 join asset a on am.assetModelID=a.assetModel
																							 where i.assetCategoryID='{$forRep}'
																							 group by i.assetCategoryID";
																					$resultForRep = mysqli_query($dbc, $queryForRep);
																					$rowForRep = mysqli_fetch_array($resultForRep, MYSQLI_ASSOC);
																					echo "<tr>
																						<td style='text-align:center'><input type='checkbox' checked disabled></td>
																						<input type='hidden' name='assetCat[]' id='assetCatID".$code."' value='{$forRep}'>
																						<td>{$rowForRep['assetCat']}</td>
																						<td>{$rowForRep['floorLevel']}</td>
																						<td>{$rowForRep['ceilingLevel']}</td>
																						<td>{$rowForRep['totalQty']}</td>
																						<td><input type='number' class='form-control' name='quantity[]'></td>
																						<td>
																							<select class='form-control' name='brand[]' id='exampleFormControlSelect2".$code."' required onchange='getModel(\"{$code}\")'>
																							<option value=''>Select Brand</option>";
																							
																							//GET BRAND CODE														
																							$queryGetBrand = "SELECT * FROM thesis.assetmodel am join ref_brand rb on am.brand=rb.brandID where am.assetCategory='{$forRep}' group by am.brand";
																							$resultGetBrand = mysqli_query($dbc, $queryGetBrand);
																							while($rowGetBrand = mysqli_fetch_array($resultGetBrand, MYSQLI_ASSOC)){
																								echo "<option value='{$rowGetBrand['brandID']}'>{$rowGetBrand['name']}</option>";
																							}
																								
																						echo "</select>
																						</td>
																						<td>
																							<select class='form-control' name='model[]' required id='exampleFormControlSelect3".$code."'>
																								<option>Select Model</option>
																							</select>
																						</td>
																						<td><button type='button' class='btn btn-primary' onclick='Add({$forRep})'> Add </button></td>
																					</tr>";
																					$count++;
																				}
																				
																			
																			
																			
																			
																			
																			
																			?>
                                                                            <!-- <tr>
                                                                                <td style="text-align:center"><input type="checkbox" checked disabled></td>
                                                                                <td>Computer</td>
                                                                                <td>5</td>
                                                                                <td>50</td>
                                                                                <td>43</td>
                                                                                <td><input type=number class="form-control"></td>
                                                                                <td>
                                                                                    <select class="form-control">
                                                                                        <option>Select Brand</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select class="form-control">
                                                                                        <option>Select Model</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td><button type="button" class="btn btn-primary" onclick="Add(1)"> Add </button></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align:center"><input type="checkbox" checked disabled></td>
                                                                                <td>Laptop</td>
                                                                                <td>6</td>
                                                                                <td>
                                                                                    10
                                                                                </td>
                                                                                <td>
                                                                                    <font color="orange">8</font>
                                                                                </td>
                                                                                <td><input type=number class="form-control"></td>
                                                                                <td>
                                                                                    <select class="form-control">
                                                                                        <option>Select Brand</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select class="form-control">
                                                                                        <option>Select Model</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td><button type="button" class="btn btn-primary" onclick="Add(2)"> Add </button></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align:center"><input type="checkbox" checked disabled></td>
                                                                                <td>VGA</td>
                                                                                <td>6</td>
                                                                                <td>24</td>
                                                                                <td>
                                                                                    <font color="red">5</font>
                                                                                </td>
                                                                                <td><input type=number class="form-control"></td>
                                                                                <td>
                                                                                    <select class="form-control">
                                                                                        <option>Select Brand</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select class="form-control">
                                                                                        <option>Select Model</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td><button type="button" class="btn btn-primary" onclick="Add(3)"> Add </button></td>
                                                                            </tr> -->
                                                                        </tbody>
                                                                    </table>

                                                                </div>
                                                           
                                                        </div>
                                                        <button type="submit" name="submit" class="btn btn-success">Submit</button>
                                                        <a href="it_inventory.php"><button type="button" class="btn btn-danger">Back</button></a>
														</form>
                                                    </section>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
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
    <script type="text/javascript">
        var clicks=0;
        
		function removeRow(o) {
            var p = o.parentNode.parentNode;
            p.parentNode.removeChild(p);
        }
		
		function Add(forRep) {
			clicks++;
            var row_index = 0;
			var isRenderd = false;
			$("td").click(function() {
                row_index = $(this).parent().index();
            });
            var delayInMilliseconds = 300; //1 second
			setTimeout(function() {
                appendTableRow(row_index,clicks,forRep);
            }, delayInMilliseconds);
           
		}
		
		function getBrand(clicks){
			var code = "exampleFormControlSelect2" + clicks;
			var code1 = "assetCatID" + clicks;
			var category=document.getElementById(code1).value;
			var cat=parseInt(category);
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById(code).innerHTML = this.responseText;
				}
			};
			xmlhttp.open("GET", "brand_ajax.php?category=" + cat, true);
			xmlhttp.send();
							
		}
		
		function getModel(clicks){
			var code1 = "assetCatID" + clicks;
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
		
		var appendTableRow = function(rowCount,clicks,forRep) {
			
            var cnt = 0;
            var tr = "<tr>" +
					 "<input type='hidden' name='assetCat[]' id='assetCatID" + clicks + "' value='" + forRep + "'>" +
                     "<td></td>" +
                     "<td></td>" +
                     "<td></td>" +
                     "<td></td>" +
                     "<td></td>" +
                     "<td><input type='number' class='form-control' name='quantity[]'></td>" +
                     "<td><select class='form-control' id='exampleFormControlSelect2" + clicks + "' required name='brand[]' onchange='getModel(\"" + clicks + "\")'>" +
                     "<option selected disabled>Select Brand</option>" +
                     "</select></td>" +
                     "<td><select class='form-control' id='exampleFormControlSelect3" + clicks + "' name='model[]' required>" +
                     "<option selected disabled>Select Model</option>" +
                     "</select></td>" +
                     "<td><button id='remove' class='btn btn-danger' type='button' + onClick='removeRow(this)'>Remove</button></td>" +
                     "</tr>";
            $('#tableTest tbody tr').eq(rowCount).after(tr);
			getBrand(clicks);
							
        }

    </script>

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



</body>

</html>