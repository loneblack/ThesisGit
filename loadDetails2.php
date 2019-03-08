<?php
require_once("db/mysql_connect.php");
$assetID = $_POST['assetID'];

$query="SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', itemSpecification, m.description as'modelDescription'
        FROM asset a 
            JOIN assetModel m
        ON assetModel = assetModelID
            JOIN ref_brand br
        ON brand = brandID
            JOIN ref_assetcategory c
        ON assetCategory = assetCategoryID
            WHERE a.assetID = '{$assetID}';";
$result=mysqli_query($dbc,$query);

$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
echo 
	"<input class='form-control' value='{$row['modelDescription']}' disabled>";
	


?>