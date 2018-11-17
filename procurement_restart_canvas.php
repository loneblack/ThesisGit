<!DOCTYPE html>
<?php
	require_once('db/mysql_connect.php');
	$canvasID=$_GET['canvasID'];
	
	if (isset($_POST['submit'])){
		
		$supplierArray=$_POST['supplier'];
		$unitPriceArray=$_POST['unitPrice'];
		$canvasItemIDArray=$_POST['canvasItemIDArr'];
		$canvasItemIDArray2=$_POST['canvasItemIDArr'];
		$supplierIDArray=$_POST['supplierIDArr'];
		
		
		$count = sizeof($supplierArray);
		
		//$countq = sizeof($supplierArray);
		//$countw = sizeof($unitPriceArray);
		//$counte = sizeof($canvasItemIDArray);
		
		
		
		$mi = new MultipleIterator();
		$mi->attachIterator(new ArrayIterator($supplierArray));
		$mi->attachIterator(new ArrayIterator($unitPriceArray));
		$mi->attachIterator(new ArrayIterator($canvasItemIDArray));
		
		//for ($i=0; $i < $count; $i++) { 
			
		//}
		
		foreach ( $mi as $value ) {
			list($supplierArray, $unitPriceArray, $canvasItemIDArray) = $value;
			$querya="INSERT INTO `thesis`.`canvasitemdetails` (`cavasItemID`, `supplier_supplierID`, `price`, `status`) VALUES ('{$canvasItemIDArray}', '{$supplierArray}', '{$unitPriceArray}', '1')";
			$resulta=mysqli_query($dbc,$querya);
		}
		
		$result = array_unique($canvasItemIDArray2);
		$count2 = sizeof($result);
			
		foreach($result as $canvasItem)	{
			$queryb="DELETE FROM `thesis`.`canvasitemdetails` WHERE `cavasItemID`='{$canvasItem}' and status='6'";
			$resultb=mysqli_query($dbc,$queryb);
		}
		
		$queryReqID="SELECT requestID FROM thesis.canvas where canvasID='{$canvasID}'";
		$resultReqID=mysqli_query($dbc,$queryReqID);
		$rowReqID=mysqli_fetch_array($resultReqID,MYSQLI_ASSOC);
		
		$queryd="UPDATE `thesis`.`request` SET `step`='4' WHERE `requestID`='{$rowReqID['requestID']}'";
		$resultd=mysqli_query($dbc,$queryd);
		
		$message = "Form submitted!";
		$_SESSION['submitMessage'] = $message;
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
                                        Restart Canvas
                                    </header>
                                    <div class="panel-body">
                                        <section id="unseen">
											<form method="post">
                                            <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Quantity</th>
                                                        <th>Item</th>
                                                        <th>Specification</th>
                                                        <th>Supplier</th>
                                                        <th>Unit Price in Php</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
												<?php
														$query="SELECT ci.cavasItemID,CONCAT(rb.name, ' ',rac.name) as `itemName`,ci.quantity,am.itemSpecification,ci.description,s.name as `supplierName`,rs.description as `itemStatus`,cid.price,(ci.quantity*cid.price) as `totalPrice`,cid.supplier_supplierID as `supplierID` FROM thesis.canvasitemdetails cid
															join supplier s on cid.supplier_supplierID=s.supplierID
                                                            join ref_status rs on cid.status=rs.statusID
                                                            join canvasitem ci on cid.cavasItemID=ci.cavasItemID
															join assetmodel am on ci.assetModel=am.assetModelID
															join ref_brand rb on am.brand=rb.brandID
															join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID 
															where ci.canvasID='{$canvasID}'";
														$result=mysqli_query($dbc,$query);
														$count=0;
														$stringRow="canvasItemRow";
														$idRow="";
														while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
															$idRow=$stringRow."".$count;
															if($row['itemStatus']=='Approved'){
																echo "<tr class='canvasItemRows'>
																		<td><input type='checkbox' checked disabled></td>
																		<td style='width:50px;'>{$row['quantity']}</td>
																		<td>{$row['itemName']}</td>
																		<td>{$row['itemSpecification']}</td>
																		<td>
																		<select class='form-control' disabled>
																			<option selected value='{$row['supplierID']}'>{$row['supplierName']}</option>
																		</select>
																		</td>
																		<td><input type='number' class='form-control' min='0.00' value='{$row['price']}' disabled></td>
																		<td><button type='button' class='btn btn-primary' onclick='addTest({$row['cavasItemID']},{$row['supplierID']})' disabled> Add </button></td>
																	</tr>";
															}
															else{
																echo "<tr class='canvasItemRows'>
																		<td><input type='checkbox' disabled></td>
																		<td style='width:50px;'>{$row['quantity']}</td>
																		<td>{$row['itemName']}</td>
																		<td>{$row['itemSpecification']}</td>
																		<td>
																		<select class='form-control' disabled>
																			<option selected value='{$row['supplierID']}'>{$row['supplierName']}</option>
																		</select>
																		</td>
																		<td><input type='number' class='form-control' min='0.00' value='{$row['price']}' disabled></td>
																		<td><button type='button' class='btn btn-primary' onclick='addTest({$row['cavasItemID']},{$row['supplierID']})'> Add </button></td>
																		</tr>
																		";
															}
															$count++;
														}
													
													
													
													
													
													
													
													?>
												
												
                                                <!--<tbody>
                                                    <tr>
                                                        <td><input type="checkbox" checked disabled></td>
                                                        <td style="width:50px;">5</td>
                                                        <td>MAC Laptop</td>
                                                        <td>IPAD</td>
                                                        <td>
                                                            <select class="form-control" id="exampleFormControlSelect1" disabled>
                                                                <option>ABC Corp.</option>
                                                                <option>Philippine Sports Commission</option>
                                                                <option>CDR-King</option>
                                                                <option>Huawei</option>
                                                                <option>Samsung</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="number" class="form-control" min="0.00" value="1000" disabled></td>
                                                        <td><button class="btn btn-primary" onclick="addTest(4)" disabled> Add </button></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="checkbox"></td>
                                                        <td style="width:50px;">5</td>
                                                        <td>Windows</td>
                                                        <td>Windows 10</td>
                                                        <td>
                                                            <select class="form-control" id="exampleFormControlSelect1" disabled>
                                                                <option>ABC Corp.</option>
                                                                <option>Philippine Sports Commission</option>
                                                                <option>CDR-King</option>
                                                                <option>Huawei</option>
                                                                <option>Samsung</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="number" class="form-control" min="0.00" value="1000" disabled></td><td><button class="btn btn-primary" onclick="addTest(3)"> Add </button></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="checkbox"></td>
                                                        <td style="width:50px;">5</td>
                                                        <td>Desktop</td>
                                                        <td>MAC PC</td>
                                                        <td>
                                                            <select class="form-control" id="exampleFormControlSelect1" disabled>
                                                                <option>ABC Corp.</option>
                                                                <option>Philippine Sports Commission</option>
                                                                <option>CDR-King</option>
                                                                <option>Huawei</option>
                                                                <option>Samsung</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="number" class="form-control" min="0.00" value="1000" disabled></td><td><button class="btn btn-primary" onclick="addTest(2)"> Add </button></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="checkbox"></td>
                                                        <td style="width:50px;">5</td>
                                                        <td>Projector</td>
                                                        <td>Epson 101</td>
                                                        <td>
                                                            <select class="form-control" id="exampleFormControlSelect1" disabled>
                                                                <option>ABC Corp.</option>
                                                                <option>Philippine Sports Commission</option>
                                                                <option>CDR-King</option>
                                                                <option>Huawei</option>
                                                                <option>Samsung</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="number" class="form-control" min="0.00" value="1000" disabled></td><td><button class="btn btn-primary" onclick="addTest(1)"> Add </button></td>
                                                    </tr>
                                                </tbody> -->
                                            </table>

                                            <div>
                                                <button type="submit" name="submit" class="btn btn-success" data-dismiss="modal">Send</button>
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
        function addTest(cavasItemID,suppID) {
			//var rowID=""+ idRow;
			var canvasItemID=cavasItemID;
			var supplierID=suppID;
            var row_index = 0;
            var isRenderd = false;
            $("td").click(function() {
                row_index = $(this).parent().index();
            });
            var delayInMilliseconds = 300; //1 second
            setTimeout(function() {
                appendTableRow(row_index,canvasItemID,supplierID);
            }, delayInMilliseconds);
        }
		
		function getDisabledSupplier(rowCount,rowClass,canvasItemID){
			//var rowID=""+idRow;
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				//document.getElementById("exampleFormControlSelect2").innerHTML = this.responseText;
				document.getElementsByClassName(rowClass)[0].innerHTML = this.responseText;
			}
			};
			xmlhttp.open("GET", "disabled_supplier_ajax.php?canvasItemID=" + canvasItemID, true);
			xmlhttp.send();
		}
		
        var appendTableRow = function(rowCount,canvasItemID,supplierID) {
			var rowClass = "newCanvasRow"+rowCount;
            var cnt = 0;
            var tr = "<tr>" +
				"<input type='hidden' name='canvasItemIDArr[]' value='"+ canvasItemID +"'>" +
				"<input type='hidden' name='supplierIDArr[]' value='"+ supplierID +"'>" +
                "<td style='width:50px;'></td>" +
                "<td></td>" +
				"<td></td>" +
                "<td></td>" +
                "<td>" +
                "<select class='form-control "+ rowClass +"'  name='supplier[]' required>" +
                "</select>" +
                "</td>" +
                "<td><input type='number' class='form-control' min='0.00' name='unitPrice[]' required></td>" +
                "</tr>";
            $('#tableTest tbody tr').eq(rowCount).after(tr);
			getDisabledSupplier(rowCount,rowClass,canvasItemID);
        }
    </script>


</body>

</html>