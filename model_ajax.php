<?php
	require_once('mysql_connect.php');
	$category=$_REQUEST["category"];
	$brand=$_REQUEST["brand"];
	$query9="SELECT * FROM thesis.assetmodel where assetCategory='{$category}' and brand='{$brand}'";
	$result9=mysqli_query($dbc,$query9);
	echo "<option selected disabled>Select Model</option>";
	while($row9=mysqli_fetch_array($result9,MYSQLI_ASSOC)){
		echo "<option value='{$row9['assetModelID']}'>{$row9['description']}</option>";
	}				


?>