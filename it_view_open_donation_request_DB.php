<?php
	session_start();
	require_once("db/mysql_connect.php");
	
	if(isset($_POST['approve'])){
		$header =  $_SESSION['previousPage3'];
		$assetsForDon=$_POST['assetsForDon'];
		
		//Update status
		$queryApp="UPDATE `thesis`.`donation` SET `statusID`='2',`stepsID`='9' WHERE `donationID`='{$_SESSION['donationID']}'";
		$resultApp=mysqli_query($dbc,$queryApp);
		
		//Get donation data
		$queryDonDat="SELECT * FROM thesis.donation where `donationID`='{$_SESSION['donationID']}' limit 1";
		$resultDonDat=mysqli_query($dbc,$queryDonDat);
		$rowDonDat=mysqli_fetch_array($resultDonDat, MYSQLI_ASSOC);
			
		foreach($assetsForDon as $asset){
			//INSERT TO DONATIONDETAILS_ITEM
			$queryDonDetIt="INSERT INTO `thesis`.`donationdetails_item` (`id`, `assetID`) VALUES ('{$_SESSION['donationID']}', '{$asset}');";
			$resultDonDetIt=mysqli_query($dbc,$queryDonDetIt);
		}
		
		$message = "Form submitted!";
		$_SESSION['submitMessage'] = $message; 
		header('Location: '.$header);	
	}
	if(isset($_POST['disapprove'])){
		$header =  $_SESSION['previousPage3'];
		//Update status
		$queryDisapp="UPDATE `thesis`.`donation` SET `reason`='{$_POST['reason']}', `statusID`='5' WHERE `donationID`='{$_SESSION['donationID']}'";
		$resultDisapp=mysqli_query($dbc,$queryDisapp);
		
		$message = "Form submitted!";
		$_SESSION['submitMessage'] = $message; 
		header('Location: '.$header);
	}
?>