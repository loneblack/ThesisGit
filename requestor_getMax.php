<?php
require_once("db/mysql_connect.php");
$categoryID = $_POST['categoryID'];


if($categoryID!='')
{
		echo "<option value=''>0</option>";
	
$query="SELECT COUNT(*) AS 'count' FROM thesis.asset JOIN assetmodel ON assetModel = assetModelID WHERE assetCategory = {$categoryID} AND assetStatus =1;";
$result=mysqli_query($dbc,$query);

echo $query;
		
	$count = 0;

	while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

		$count = $row['count'];
	}
	for ($i=1; $i <= $count; $i++) { 
		echo "<option value='{$i}'>{$i}</option>";
	}
}

?>