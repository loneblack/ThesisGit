<!DOCTYPE html>
<?php
session_start();
require_once('db/mysql_connect.php');
$_SESSION['requestID']=$_GET['requestID'];

$query="SELECT * FROM thesis.canvas 
				 where requestID='{$_SESSION['requestID']}'";
$result=mysqli_query($dbc,$query);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

if(isset($_POST['submit'])){
	
	//$x=sizeof($_POST['comments']);
	
	//$queryv="SELECT * FROM thesis.canvasitemdetails cid join canvasitem ci on cid.cavasItemID=ci.cavasItemID					   
		//										where ci.canvasID='{$row['canvasID']}' and cid.status!='5' 
			//									group by ci.assetCategory";
	//$resultv=mysqli_query($dbc,$queryv);
	//while($rowv=mysqli_fetch_array($resultv,MYSQLI_ASSOC)){
		//$code="canvas".$rowv['assetCategory'];
		//if(isset($_POST[code])){
			//$dat=explode("_", $_POST[code]);
			//$canCode=$dat[0];
			//$suppID=$dat[1];
			//$dat=array();
			//$query1="UPDATE `thesis`.`canvasitemdetails` SET `status`='5' WHERE `cavasItemID`='{$canCode}' and `supplier_supplierID`='{$suppID}'";
			//$result1=mysqli_query($dbc,$query1);
		//}
		
		
	//}
	
	
	if(!empty($_POST['canvas'])){
	// Loop to store and display values of individual checked checkbox.
		$canvas=$_POST['canvas'];
		foreach($canvas as $value){
			
			$dat=explode("_", $value);
			$canCode=$dat[0];
			$suppID=$dat[1];
			$dat=array();
			
			//for($i=0;$i<sizeof($canvasItemID);$i++){
				//for($j=0;$j<sizeof($supplierID);$j++){
					//$canvID=$canvasItemID[$i]."".$supplierID[$j];
					//if($value==$canvID){
			$query1="UPDATE `thesis`.`canvasitemdetails` SET `status`='5' WHERE `cavasItemID`='{$canCode}' and `supplier_supplierID`='{$suppID}'";
			$result1=mysqli_query($dbc,$query1);
					//}
				//}
			//}
		}
	}
	
	if(!empty($_POST['disapprovedCavasItem'])){
		foreach(array_combine($_POST['disapprovedCavasItem'],$_POST['comments']) as $disappCanvas => $comments){
			$dat=explode("_", $disappCanvas);
			$canCode=$dat[0];
			$suppID=$dat[1];
			$dat=array();
			
			$query2="UPDATE `thesis`.`canvasitemdetails` SET `status`='6',`comment`='{$comments}' WHERE `cavasItemID`='{$canCode}' and `supplier_supplierID`='{$suppID}'";
			$result2=mysqli_query($dbc,$query2);
		}
	}
	
	
	
		
		
		//$x=sizeof($_POST['comments']);
		//echo "<script>alert('{$x}');</script>";
		//foreach(array_combine($_POST['comments'], $_POST['canvasItemID']) as $comments => $canvasItemID){
			//$query2="UPDATE `thesis`.`canvasitemdetails` SET `status`='6',`comment`='{$comments}' WHERE `cavasItemID`='{$canvasItemID}' and `supplier_supplierID`='{$supplierID}'";
			//$result2=mysqli_query($dbc,$query2);
		//}
	
	
		
	
	
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
                                                <h2>Canvas Completed</h2>
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
                                        <h5>*** Please Check the Checkbox for Procurement to Buy</h5>
										<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?requestID={$_SESSION['requestID']}"; ?>">
                                        <table class="table table-invoice" id="mytable">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th class="text-center" style="width:84px">Quantity</th>
                                                    <th class="text-center">Category</th>
                                                    <th class="text-center">Brand</th>
                                                    <th class="text-center">Model</th>
                                                    <th>Supplier</th>
													<th class="text-center">Specification</th>
                                                    <th>Price</th>
                                                    <th>Comments</th>
                                                </tr>
                                            </thead>
                                            <tbody>
												<?php
												$query1="SELECT ci.cavasItemID as `canvasItemID`,ci.quantity as `canvasQty`,rac.name as `categoryName`,rb.name as `brandName`,am.description as 'modelDesc',am.itemSpecification as `itemSpec`,cid.price as `itemPrice`,s.name as `supplier`,cid.supplier_supplierID as `supplierID` FROM thesis.canvasitemdetails cid join canvasitem ci on cid.cavasItemID=ci.cavasItemID
																				   join supplier s on cid.supplier_supplierID=s.supplierID
																				   join assetmodel am on ci.assetModel=am.assetModelID
																				   join ref_brand rb on am.brand=rb.brandID
																				   join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
												where ci.canvasID='{$row['canvasID']}' and cid.status!='5' 
												order by ci.assetCategory";
												$result1=mysqli_query($dbc,$query1);
												$count=0;
												while($row1=mysqli_fetch_array($result1,MYSQLI_ASSOC)){
													$idCanvas=$row1['canvasItemID']."_".$row1['supplierID'];
													$idDisapp="Disapp_".$idCanvas;
													//<td><input type='radio' class='myCheck' name='canvas{$row1['categoryName']}[]' value='{$idCanvas}'>
													echo "<tr>
														<td><input type='checkbox' class='myCheck' name='canvas[]' value='{$idCanvas}'>
														<td class='text-center'>{$row1['canvasQty']}</td>
														<td class='text-center'>{$row1['categoryName']}</td>
														<td class='text-center'>{$row1['brandName']}</td>
														<td class='text-center'>{$row1['modelDesc']}</td>
														<td>{$row1['supplier']}</td>
														<td class='text-center'>{$row1['itemSpec']}</td>
														<td>{$row1['itemPrice']}</td>
														<td>
                                                        <div class='form-group'>
                                                            <div class='col-lg-12'>
                                                                <input type='text' class='form-control comm' id='{$idCanvas}' name='comments[]' required>
																<input type='hidden' id='{$idDisapp}' class='disappCavas' name='disapprovedCavasItem[]' value='{$idCanvas}'>
                                                            </div>
                                                        </div>
														</td>
													
													</tr>";	
													//<input type='hidden' name='canvasItemID[]' value='{$row1['canvasItemID']}'>
													//<input type='hidden' name='supplierID[]' value='{$row1['supplierID']}'>
													$count++;
												}
												?>
                                                <tr>
                                                    <td><input type="checkbox"></td>
                                                    <td class="text-center">3</td>
                                                    <td class="text-center">Laptop</td>
                                                    <td class="text-center">Acer</td>
                                                    <td class="text-center">Aspire E14</td>
                                                    <td>CDR-King</td>
                                                    <td class="text-center">4 GB RAM, 1 TB Hard Drive, Some Processor, Some graphics card</td>
                                                    <td>P 1,300.00</td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="col-lg-12">
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox"></td>
                                                    <td class="text-center">3</td>
                                                    <td class="text-center">Laptop</td>
                                                    <td class="text-center">Acer</td>
                                                    <td class="text-center">Aspire E14</td>
                                                    <td>CDR-King</td>
                                                    <td class="text-center">4 GB RAM, 1 TB Hard Drive, Some Processor, Some graphics card</td>
                                                    <td>P 1,300.00</td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="col-lg-12">
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox"></td>
                                                    <td class="text-center">3</td>
                                                    <td class="text-center">Laptop</td>
                                                    <td class="text-center">Acer</td>
                                                    <td class="text-center">Aspire E14</td>
                                                    <td>CDR-King</td>
                                                    <td class="text-center">4 GB RAM, 1 TB Hard Drive, Some Processor, Some graphics card</td>
                                                    <td>P 1,300.00</td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="col-lg-12">
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
										<button type="submit" class="btn btn-success" name="submit" >Submit</button>
										<a href="it_requests.php"><button class="btn btn-danger">Back</button></a>
										</form>
                                        
                                       
                                    </section>
                                </div>
                            </section>
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
    <script>
		var code = new Array();
		var comment = new Array();
        $(":input").bind('keyup change click', function(e) {

            if ($(this).val() < 0) {
                $(this).val('')
            }

        });
		//$("input:checkbox:not(:checked)").map(function(){
			//var disapp = "Disapp_" + this.value;
			//document.getElementById(this.value).required = true;
			//document.getElementById(this.value).disabled = false;
			//document.getElementById(disapp).disabled=false;
		//})
		$('.myCheck').change(function(){
			var disapp = "Disapp_" + this.value;
			if($(this).is(':checked')) {
			// Checkbox is checked..
			
				document.getElementById(this.value).required = false;
				document.getElementById(this.value).disabled = true;
				document.getElementById(disapp).disabled=true;
			} else {
				// Checkbox is not checked..
				
				document.getElementById(this.value).required = true;
				document.getElementById(this.value).disabled = false;
				document.getElementById(disapp).disabled=false;
				
			}
		});
	
		
		
    </script>
</body>

</html>