<?php
	require_once('db/mysql_connect.php');
	$model=$_REQUEST["model"];
	
	$queryProp="SELECT * FROM thesis.asset where assetModel='{$model}' and assetStatus='1'";
	$resultProp=mysqli_query($dbc,$queryProp);
	echo "<option selected disabled>Select Property Code</option>";
	while($rowProp=mysqli_fetch_array($resultProp,MYSQLI_ASSOC)){
		echo "<option value='{$rowProp['assetID']}'>{$rowProp['propertyCode']}</option>";
	}				


?>