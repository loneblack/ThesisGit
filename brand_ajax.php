<?php
	require_once('db/mysql_connect.php');
	$category=$_REQUEST["category"];
	$query9="SELECT * FROM thesis.assetmodel am join ref_brand rb on am.brand=rb.brandID where am.assetCategory='{$category}'";
	$result9=mysqli_query($dbc,$query9);
	echo "<option selected disabled>Select Brand</option>";
	while($row9=mysqli_fetch_array($result9,MYSQLI_ASSOC)){
		echo "<option value='{$row9['brandID']}'>{$row9['name']}</option>";
	}				


?>