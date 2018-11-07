<?php 
	require_once('db/mysql_connect.php');
	$canvasItemID=$_REQUEST["canvasItemID"];
	
	$query2="SELECT s.name FROM thesis.supplier s join canvasitemdetails cid on s.supplierID=cid.supplier_supplierID where cid.cavasItemID='{$canvasItemID}' and cid.status='10'";
	$result2=mysqli_query($dbc,$query2);
	$approvedSuppliers=array();
	
	echo "<option selected disabled>Select Supplier</option>";
	while($row2=mysqli_fetch_array($result2,MYSQLI_ASSOC)){
		array_push($approvedSuppliers,$row2['name']);
	}
	
	$query3="SELECT * FROM thesis.supplier";
	$result3=mysqli_query($dbc,$query3);
	
	while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC)){
		if(in_array($row3['name'], $approvedSuppliers)){
			echo "<option value='{$row3['supplierID']}' disabled>{$row3['name']}</option>";
		}
		else{
			echo "<option value='{$row3['supplierID']}'>{$row3['name']}</option>";
		}
	} 
						
?>