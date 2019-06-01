<?php
	session_start();
	require_once("db/mysql_connect.php");
	
	if(isset($_POST['approve'])){
		//Update notifications
		$queryUpdNotif="UPDATE `thesis`.`notifications` SET `isRead` = true WHERE `donationID` = '{$_SESSION['donationID']}' and `steps_id`='1'";
		$resultUpdNotif=mysqli_query($dbc,$queryUpdNotif);
		
		$header =  $_SESSION['previousPage3'];
		$assetsForDon=$_POST['assetsForDon'];
		
		//Update status
		$queryApp="UPDATE `thesis`.`donation` SET `statusID`='2',`stepsID`='9' WHERE `donationID`='{$_SESSION['donationID']}'";
		$resultApp=mysqli_query($dbc,$queryApp);
		
		//Get donation data
		$queryDonDat="SELECT * FROM thesis.donation where `donationID`='{$_SESSION['donationID']}' limit 1";
		$resultDonDat=mysqli_query($dbc,$queryDonDat);
		$rowDonDat=mysqli_fetch_array($resultDonDat, MYSQLI_ASSOC);
		
		//INSERT TO NOTIFICATIONS TABLE
		$sqlNotif = "INSERT INTO `thesis`.`notifications` (`steps_id`, `isRead`, `donationID`) VALUES ('9', false, '{$_SESSION['donationID']}');";
		$resultNotif = mysqli_query($dbc, $sqlNotif);
			
		foreach($assetsForDon as $asset){
			//INSERT TO DONATIONDETAILS_ITEM
			$queryDonDetIt="INSERT INTO `thesis`.`donationdetails_item` (`id`, `assetID`) VALUES ('{$_SESSION['donationID']}', '{$asset}');";
			$resultDonDetIt=mysqli_query($dbc,$queryDonDetIt);
			
			//INSERT TO ASSET AUDIT
			$queryAssAud="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `assetStatus`) VALUES ('{$_SESSION['userID']}', now(), '{$asset}', '16');";
			$resultAssAud=mysqli_query($dbc,$queryAssAud);
		}
		
		$message = "Form submitted!";
		$_SESSION['submitMessage'] = $message; 
		header('Location: '.$header);	
	}
	if(isset($_POST['disapprove'])){
		//Update notifications
		$queryUpdNotif="UPDATE `thesis`.`notifications` SET `isRead` = true WHERE `donationID` = '{$_SESSION['donationID']}' and `steps_id`='1'";
		$resultUpdNotif=mysqli_query($dbc,$queryUpdNotif);
		
		$header =  $_SESSION['previousPage3'];
		//Update status
		$queryDisapp="UPDATE `thesis`.`donation` SET `reason`='{$_POST['reason']}', `statusID`='6', `stepsID`='20' WHERE `donationID`='{$_SESSION['donationID']}'";
		$resultDisapp=mysqli_query($dbc,$queryDisapp);
		
		//INSERT TO NOTIFICATIONS TABLE
		$sqlNotif = "INSERT INTO `thesis`.`notifications` (`steps_id`, `isRead`, `donationID`) VALUES ('20', false, '{$_SESSION['donationID']}');";
		$resultNotif = mysqli_query($dbc, $sqlNotif);
		
		$message = "Form submitted!";
		$_SESSION['submitMessage'] = $message; 
		header('Location: '.$header);
	}
?>