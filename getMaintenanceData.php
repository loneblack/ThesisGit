<?php
	require_once('db/mysql_connect.php');
	session_start();
	
	unset($_SESSION['room']);
	unset($_SESSION['propertyCode']);
	unset($_SESSION['assetCat']);
	unset($_SESSION['assetStat']);
	unset($_SESSION['dateChecked']);
	
	$_SESSION['room'] = array();
	$_SESSION['propertyCode'] = array();
	$_SESSION['assetCat'] = array();
	$_SESSION['assetStat'] = array();
	$_SESSION['dateChecked'] = array();
	
	/*if($_REQUEST["month"]=='0'){
		$month=null;
		$_SESSION['mnt']='0';
	}
	else{
		$month=$_REQUEST["month"];
		$_SESSION['mnt']=$month;
	}
	
	if($_REQUEST["year"]=='0'){
		$year=null;
		$_SESSION['yr']='0';
	}
	else{
		$year=$_REQUEST["year"];
		$_SESSION['yr']=$year;
	}
	
	if($_REQUEST["roomtype"]=='0'){
		$roomtype=null;
		$_SESSION['roomType']='0';
	}
	else{
		$roomtype=$_REQUEST["roomtype"];
		$_SESSION['roomType']=$roomtype;
	}
	
	if($_REQUEST["building"]=='0'){
		$building=null;
		$_SESSION['bldg']='0';
	}
	else{
		$building=$_REQUEST["building"];
		$_SESSION['bldg']=$building;
	}
	*/
	
	$_SESSION['startDate']=$_REQUEST["startDate"];
	$_SESSION['endDate']=$_REQUEST["endDate"];
	
	//GET ALL DATE FROM START DATE TO END DATE
	$queryGetAllMainData="SELECT far.floorRoom,a.propertyCode,rac.name as `assetCat`,ras.description as `assetStat`,au.date FROM thesis.ticket t join assetaudit au on t.ticketID=au.ticketID 
																																																							  join asset a on au.assetID=a.assetID
																																																							  join assetmodel am on a.assetModel=am.assetModelID
																																																							  join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																																																							  join ref_assetstatus ras on au.assetStatus=ras.id 
																																																							  join assetassignment aa on a.assetID=aa.assetID 
																																																							  join floorandroom far on aa.FloorAndRoomID=far.FloorAndRoomID
																																																where t.serviceType='28' and au.assetStatus!='17' and au.date BETWEEN '{$_SESSION['startDate']}' AND '{$_SESSION['endDate']}'";
	$resultGetAllMainData=mysqli_query($dbc,$queryGetAllMainData);
	
	
	/*if(isset($year)){
		
		if(isset($month)){
			
			if(isset($roomtype)){
				
				if(isset($building)){
					
					//YEAR,MONTH,ROOMTYPE,BUILDING
					$queryGetAllMainData="SELECT far.floorRoom,a.propertyCode,rac.name as `assetCat`,ras.description as `assetStat`,au.date FROM thesis.ticket t join assetaudit au on t.ticketID=au.ticketID 
																																																							  join asset a on au.assetID=a.assetID
																																																							  join assetmodel am on a.assetModel=am.assetModelID
																																																							  join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																																																							  join ref_assetstatus ras on au.assetStatus=ras.id 
																																																							  join assetassignment aa on a.assetID=aa.assetID 
																																																							  join floorandroom far on aa.FloorAndRoomID=far.FloorAndRoomID
																																																where t.serviceType='28' and au.assetStatus!='17' and far.roomtype='{$roomtype}' and aa.BuildingID='{$building}' and month(au.date)='{$month}' and year(au.date)='{$year}'";
					$resultGetAllMainData=mysqli_query($dbc,$queryGetAllMainData);
				}
				else{
					//YEAR,MONTH,ROOMTYPE
					$queryGetAllMainData="SELECT far.floorRoom,a.propertyCode,rac.name as `assetCat`,ras.description as `assetStat`,au.date FROM thesis.ticket t join assetaudit au on t.ticketID=au.ticketID 
																																																							  join asset a on au.assetID=a.assetID
																																																							  join assetmodel am on a.assetModel=am.assetModelID
																																																							  join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																																																							  join ref_assetstatus ras on au.assetStatus=ras.id 
																																																							  join assetassignment aa on a.assetID=aa.assetID 
																																																							  join floorandroom far on aa.FloorAndRoomID=far.FloorAndRoomID
																																																where t.serviceType='28' and au.assetStatus!='17' and far.roomtype='{$roomtype}' and month(au.date)='{$month}' and year(au.date)='{$year}'";
					$resultGetAllMainData=mysqli_query($dbc,$queryGetAllMainData);
				}
			}
			elseif(isset($building)){
				
				//YEAR,MONTH,BUILDING
				$queryGetAllMainData="SELECT far.floorRoom,a.propertyCode,rac.name as `assetCat`,ras.description as `assetStat`,au.date FROM thesis.ticket t join assetaudit au on t.ticketID=au.ticketID 
																																																							  join asset a on au.assetID=a.assetID
																																																							  join assetmodel am on a.assetModel=am.assetModelID
																																																							  join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																																																							  join ref_assetstatus ras on au.assetStatus=ras.id 
																																																							  join assetassignment aa on a.assetID=aa.assetID 
																																																							  join floorandroom far on aa.FloorAndRoomID=far.FloorAndRoomID
																																																where t.serviceType='28' and au.assetStatus!='17' and aa.BuildingID='{$building}' and month(au.date)='{$month}' and year(au.date)='{$year}'";
				$resultGetAllMainData=mysqli_query($dbc,$queryGetAllMainData);
			}
			else{
				//YEAR,MONTH
				$queryGetAllMainData="SELECT far.floorRoom,a.propertyCode,rac.name as `assetCat`,ras.description as `assetStat`,au.date FROM thesis.ticket t join assetaudit au on t.ticketID=au.ticketID 
																																																							  join asset a on au.assetID=a.assetID
																																																							  join assetmodel am on a.assetModel=am.assetModelID
																																																							  join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																																																							  join ref_assetstatus ras on au.assetStatus=ras.id 
																																																							  join assetassignment aa on a.assetID=aa.assetID 
																																																							  join floorandroom far on aa.FloorAndRoomID=far.FloorAndRoomID
																																																where t.serviceType='28' and au.assetStatus!='17' and month(au.date)='{$month}' and year(au.date)='{$year}'";
				$resultGetAllMainData=mysqli_query($dbc,$queryGetAllMainData);
			}
		}
		elseif(isset($roomtype)){
			
			if(isset($building)){
				
				//YEAR,ROOMTYPE,BUILDING
				$queryGetAllMainData="SELECT far.floorRoom,a.propertyCode,rac.name as `assetCat`,ras.description as `assetStat`,au.date FROM thesis.ticket t join assetaudit au on t.ticketID=au.ticketID 
																																																							  join asset a on au.assetID=a.assetID
																																																							  join assetmodel am on a.assetModel=am.assetModelID
																																																							  join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																																																							  join ref_assetstatus ras on au.assetStatus=ras.id 
																																																							  join assetassignment aa on a.assetID=aa.assetID 
																																																							  join floorandroom far on aa.FloorAndRoomID=far.FloorAndRoomID
																																																where t.serviceType='28' and au.assetStatus!='17' and far.roomtype='{$roomtype}' and aa.BuildingID='{$building}' and year(au.date)='{$year}'";
				$resultGetAllMainData=mysqli_query($dbc,$queryGetAllMainData);
			}
			else{
				//YEAR,ROOMTYPE
				$queryGetAllMainData="SELECT far.floorRoom,a.propertyCode,rac.name as `assetCat`,ras.description as `assetStat`,au.date FROM thesis.ticket t join assetaudit au on t.ticketID=au.ticketID 
																																																							  join asset a on au.assetID=a.assetID
																																																							  join assetmodel am on a.assetModel=am.assetModelID
																																																							  join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																																																							  join ref_assetstatus ras on au.assetStatus=ras.id 
																																																							  join assetassignment aa on a.assetID=aa.assetID 
																																																							  join floorandroom far on aa.FloorAndRoomID=far.FloorAndRoomID
																																																where t.serviceType='28' and au.assetStatus!='17' and far.roomtype='{$roomtype}' and year(au.date)='{$year}'";
				$resultGetAllMainData=mysqli_query($dbc,$queryGetAllMainData);
			}
		}
		elseif(isset($building)){
			
			//YEAR,BUILDING
			$queryGetAllMainData="SELECT far.floorRoom,a.propertyCode,rac.name as `assetCat`,ras.description as `assetStat`,au.date FROM thesis.ticket t join assetaudit au on t.ticketID=au.ticketID 
																																																							  join asset a on au.assetID=a.assetID
																																																							  join assetmodel am on a.assetModel=am.assetModelID
																																																							  join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																																																							  join ref_assetstatus ras on au.assetStatus=ras.id 
																																																							  join assetassignment aa on a.assetID=aa.assetID 
																																																							  join floorandroom far on aa.FloorAndRoomID=far.FloorAndRoomID
																																																where t.serviceType='28' and au.assetStatus!='17' and aa.BuildingID='{$building}' and year(au.date)='{$year}'";
			$resultGetAllMainData=mysqli_query($dbc,$queryGetAllMainData);
		}
		else{
			//YEAR
			$queryGetAllMainData="SELECT far.floorRoom,a.propertyCode,rac.name as `assetCat`,ras.description as `assetStat`,au.date FROM thesis.ticket t join assetaudit au on t.ticketID=au.ticketID 
																																																							  join asset a on au.assetID=a.assetID
																																																							  join assetmodel am on a.assetModel=am.assetModelID
																																																							  join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																																																							  join ref_assetstatus ras on au.assetStatus=ras.id 
																																																							  join assetassignment aa on a.assetID=aa.assetID 
																																																							  join floorandroom far on aa.FloorAndRoomID=far.FloorAndRoomID
																																																where t.serviceType='28' and au.assetStatus!='17' and year(au.date)='{$year}'";
			$resultGetAllMainData=mysqli_query($dbc,$queryGetAllMainData);
		}
	}
	elseif(isset($month)){
		
		if(isset($roomtype)){
			
			if(isset($building)){
				
				//MONTH,ROOMTYPE,BUILDING
				$queryGetAllMainData="SELECT far.floorRoom,a.propertyCode,rac.name as `assetCat`,ras.description as `assetStat`,au.date FROM thesis.ticket t join assetaudit au on t.ticketID=au.ticketID 
																																																							  join asset a on au.assetID=a.assetID
																																																							  join assetmodel am on a.assetModel=am.assetModelID
																																																							  join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																																																							  join ref_assetstatus ras on au.assetStatus=ras.id 
																																																							  join assetassignment aa on a.assetID=aa.assetID 
																																																							  join floorandroom far on aa.FloorAndRoomID=far.FloorAndRoomID
																																																where t.serviceType='28' and au.assetStatus!='17' and far.roomtype='{$roomtype}' and aa.BuildingID='{$building}' and month(au.date)='{$month}'";
				$resultGetAllMainData=mysqli_query($dbc,$queryGetAllMainData);
			}
			else{
				//MONTH,ROOMTYPE
				$queryGetAllMainData="SELECT far.floorRoom,a.propertyCode,rac.name as `assetCat`,ras.description as `assetStat`,au.date FROM thesis.ticket t join assetaudit au on t.ticketID=au.ticketID 
																																																							  join asset a on au.assetID=a.assetID
																																																							  join assetmodel am on a.assetModel=am.assetModelID
																																																							  join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																																																							  join ref_assetstatus ras on au.assetStatus=ras.id 
																																																							  join assetassignment aa on a.assetID=aa.assetID 
																																																							  join floorandroom far on aa.FloorAndRoomID=far.FloorAndRoomID
																																																where t.serviceType='28' and au.assetStatus!='17' and far.roomtype='{$roomtype}' and month(au.date)='{$month}'";
				$resultGetAllMainData=mysqli_query($dbc,$queryGetAllMainData);
			}
		}
		else if(isset($building)){
			
			//MONTH,BUILDING
			$queryGetAllMainData="SELECT far.floorRoom,a.propertyCode,rac.name as `assetCat`,ras.description as `assetStat`,au.date FROM thesis.ticket t join assetaudit au on t.ticketID=au.ticketID 
																																																							  join asset a on au.assetID=a.assetID
																																																							  join assetmodel am on a.assetModel=am.assetModelID
																																																							  join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																																																							  join ref_assetstatus ras on au.assetStatus=ras.id 
																																																							  join assetassignment aa on a.assetID=aa.assetID 
																																																							  join floorandroom far on aa.FloorAndRoomID=far.FloorAndRoomID
																																																where t.serviceType='28' and au.assetStatus!='17' and aa.BuildingID='{$building}' and month(au.date)='{$month}'";
			$resultGetAllMainData=mysqli_query($dbc,$queryGetAllMainData);
		}
		else{
			//MONTH
			$queryGetAllMainData="SELECT far.floorRoom,a.propertyCode,rac.name as `assetCat`,ras.description as `assetStat`,au.date FROM thesis.ticket t join assetaudit au on t.ticketID=au.ticketID 
																																																							  join asset a on au.assetID=a.assetID
																																																							  join assetmodel am on a.assetModel=am.assetModelID
																																																							  join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																																																							  join ref_assetstatus ras on au.assetStatus=ras.id 
																																																							  join assetassignment aa on a.assetID=aa.assetID 
																																																							  join floorandroom far on aa.FloorAndRoomID=far.FloorAndRoomID
																																																where t.serviceType='28' and au.assetStatus!='17' and month(au.date)='{$month}'";
			$resultGetAllMainData=mysqli_query($dbc,$queryGetAllMainData);
		}
	}
	elseif(isset($roomtype)){
		
		if(isset($building)){
			
			//ROOMTYPE,BUILDING
			$queryGetAllMainData="SELECT far.floorRoom,a.propertyCode,rac.name as `assetCat`,ras.description as `assetStat`,au.date FROM thesis.ticket t join assetaudit au on t.ticketID=au.ticketID 
																																																							  join asset a on au.assetID=a.assetID
																																																							  join assetmodel am on a.assetModel=am.assetModelID
																																																							  join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																																																							  join ref_assetstatus ras on au.assetStatus=ras.id 
																																																							  join assetassignment aa on a.assetID=aa.assetID 
																																																							  join floorandroom far on aa.FloorAndRoomID=far.FloorAndRoomID
																																																where t.serviceType='28' and au.assetStatus!='17' and far.roomtype='{$roomtype}' and aa.BuildingID='{$building}'";
			$resultGetAllMainData=mysqli_query($dbc,$queryGetAllMainData);
		}
		else{
			//ROOMTYPE
			$queryGetAllMainData="SELECT far.floorRoom,a.propertyCode,rac.name as `assetCat`,ras.description as `assetStat`,au.date FROM thesis.ticket t join assetaudit au on t.ticketID=au.ticketID 
																																																							  join asset a on au.assetID=a.assetID
																																																							  join assetmodel am on a.assetModel=am.assetModelID
																																																							  join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																																																							  join ref_assetstatus ras on au.assetStatus=ras.id 
																																																							  join assetassignment aa on a.assetID=aa.assetID 
																																																							  join floorandroom far on aa.FloorAndRoomID=far.FloorAndRoomID
																																																where t.serviceType='28' and au.assetStatus!='17' and far.roomtype='{$roomtype}'";
			$resultGetAllMainData=mysqli_query($dbc,$queryGetAllMainData);
		}
	}
	elseif(isset($building)){
		
		//BUILDING
		$queryGetAllMainData="SELECT far.floorRoom,a.propertyCode,rac.name as `assetCat`,ras.description as `assetStat`,au.date FROM thesis.ticket t join assetaudit au on t.ticketID=au.ticketID 
																																																							  join asset a on au.assetID=a.assetID
																																																							  join assetmodel am on a.assetModel=am.assetModelID
																																																							  join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																																																							  join ref_assetstatus ras on au.assetStatus=ras.id 
																																																							  join assetassignment aa on a.assetID=aa.assetID 
																																																							  join floorandroom far on aa.FloorAndRoomID=far.FloorAndRoomID
																																																where t.serviceType='28' and au.assetStatus!='17' and aa.BuildingID='{$building}'";
		$resultGetAllMainData=mysqli_query($dbc,$queryGetAllMainData);
	}
	else{
		//DEFAULT
		$queryGetAllMainData="SELECT far.floorRoom,a.propertyCode,rac.name as `assetCat`,ras.description as `assetStat`,au.date FROM thesis.ticket t join assetaudit au on t.ticketID=au.ticketID 
																																																							  join asset a on au.assetID=a.assetID
																																																							  join assetmodel am on a.assetModel=am.assetModelID
																																																							  join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																																																							  join ref_assetstatus ras on au.assetStatus=ras.id 
																																																							  join assetassignment aa on a.assetID=aa.assetID 
																																																							  join floorandroom far on aa.FloorAndRoomID=far.FloorAndRoomID
																																																where t.serviceType='28' and au.assetStatus!='17'";
		$resultGetAllMainData=mysqli_query($dbc,$queryGetAllMainData);
	}*/
	
	while($rowGetAllMainData=mysqli_fetch_array($resultGetAllMainData,MYSQLI_ASSOC)){
		array_push($_SESSION['room'],$rowGetAllMainData['floorRoom']);	
		array_push($_SESSION['propertyCode'],$rowGetAllMainData['propertyCode']);	
		array_push($_SESSION['assetCat'],$rowGetAllMainData['assetCat']);	
		array_push($_SESSION['assetStat'],$rowGetAllMainData['assetStat']);	
		array_push($_SESSION['dateChecked'],$rowGetAllMainData['date']);	
	}
	
?>


    