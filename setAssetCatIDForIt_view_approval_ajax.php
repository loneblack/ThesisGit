<?php
	require_once('db/mysql_connect.php');
	session_start();
	$_SESSION['assetCatID']=$_REQUEST["category"];
	$queryAssList="SELECT *,rb.name as `brandName`,am.description as `modelName`,rac.name as `assetCatName`,am.itemSpecification as `modelSpec`,ras.description as `assetStat` FROM thesis.asset a left join assetmodel am on a.assetModel=am.assetModelID
												left join ref_brand rb on am.brand=rb.brandID
												left join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
												left join ref_assetstatus ras on a.assetStatus=ras.id 
												where am.assetCategory='{$_SESSION['assetCatID']}' and a.assetStatus='1'";
	$resultAssList=mysqli_query($dbc,$queryAssList);
	while($rowAssList=mysqli_fetch_array($resultAssList,MYSQLI_ASSOC)){
		echo "<tr>
			<td><input type='checkbox'></td>
			<td>{$rowAssList['propertyCode']}</td>
			<td>{$rowAssList['brandName']}</td>
			<td>{$rowAssList['modelName']}</td>
			<td>{$rowAssList['modelSpec']}</td>
			<td>{$rowAssList['assetCatName']}</td>
			<td>{$rowAssList['assetStat']}</td>
		</tr>";
	}

?>