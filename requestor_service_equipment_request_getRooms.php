<?php
require_once("db/mysql_connect.php");
$buildingID = $_POST['buildingID'];

if($buildingID!='')
{
	echo "<option value=''>Select a Room</option>";
$query="SELECT * FROM thesis.floorandroom where BuildingID ='{$buildingID}';";
$result=mysqli_query($dbc,$query);

	while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
		echo "<option value='{$row['FloorAndRoomID']}'>{$row['floorRoom']}</option>";
	}
}

?>