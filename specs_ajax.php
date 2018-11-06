<?php
	require_once('db/mysql_connect.php');
	$modelID=$_REQUEST["modelID"];
	
	$query9="SELECT itemSpecification FROM thesis.assetmodel where assetModelID='{$modelID}'";
	$result9=mysqli_query($dbc,$query9);
	$row9=mysqli_fetch_array($result9,MYSQLI_ASSOC);
	echo $row9['itemSpecification'];
	
?>