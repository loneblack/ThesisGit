<?php
	require_once("db/mysql_connect.php");
				$queryCount="SELECT Count(assetID) as `assetPosition` FROM thesis.asset a 
                            join assetmodel am on a.assetModel=am.assetModelID where am.assetCategory='40';";
				$resultCount=mysqli_query($dbc,$queryCount);
				$rowCount=mysqli_fetch_array($resultCount,MYSQLI_ASSOC);
				
				//$propertyCode="0".$row1['assetCategory']."-".sprintf('%06d', $rowCount['assetPosition']);
				$propertyCode=sprintf('%03d', 40)."-".sprintf('%06d', $rowCount['assetPosition']);

echo $propertyCode;

?>