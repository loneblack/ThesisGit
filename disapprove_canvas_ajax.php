<?php
	require_once('db/mysql_connect.php');
	$canvasCode=$_REQUEST["canvasCode"];
	$canvasItemID=array();
	$supplierID=array;
	for($i=0;$i<sizeof($canvasCode);$i++){
		$dat[]=explode(" ", $canvasCode[$i]);
		$canvasCode=$dat[0];
		$supplierID=$dat[1];
		$dat=array();
	}
	$comments=$_REQUEST["comments"];
	
	$mi = new MultipleIterator();
	$mi->attachIterator(new ArrayIterator($canvasItemID));
	$mi->attachIterator(new ArrayIterator($supplierID));
	$mi->attachIterator(new ArrayIterator($comments));
	
	foreach ( $mi as $value ) {
		
		list($canvasItemID, $supplierID, $comments) = $value;
		echo "<script>alert('cavascode:{$canvasItemID} sppcode:{$supplierID}');</script>";
		
		$query1="UPDATE `thesis`.`canvasitemdetails` SET `status`='6' WHERE `cavasItemID`='{$canvasItemID}' and `supplier_supplierID`='{$supplierID}'";
		$result1=mysqli_query($dbc,$query1);
	}
	
?>