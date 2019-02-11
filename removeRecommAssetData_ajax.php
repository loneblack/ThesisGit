<?php
	require_once('db/mysql_connect.php');
	session_start();
	$remRecommAsset=$_REQUEST["assetID"];
	$key = array_search($remRecommAsset, $_SESSION['recommAsset']);
	unset($_SESSION['recommAsset'][$key]);
?>