<?php
	require_once('db/mysql_connect.php');
	$categoryID=$_REQUEST["category"];
	
	
	$query9="SELECT * FROM thesis.ref_assetcategory where assetCategoryID='{$categoryID}'";
	$result9=mysqli_query($dbc,$query9);
	$row9=mysqli_fetch_array($result9,MYSQLI_ASSOC);
	
	echo "<option value='{$row9['assetCategoryID']}' selected>{$row9['name']}</option>";
	
?>