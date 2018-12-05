<?php


    session_start();
    require_once("db/mysql_connect.php");

    $header =  $_SESSION['previousPage'];
    
    $userID = $_SESSION['userID'];


    $sql = "SELECT * FROM `thesis`.`employee` WHERE UserID = {$userID};";//get the employeeID using userID
    $result = mysqli_query($dbc, $sql);

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $employeeID = $row['employeeID'];
        
    }

    $dateNeeded = $_POST['dateNeeded'];
    $endDate = $_POST['endDate'];
    $purpose = $_POST['purpose'];
    $buildingID = $_POST['buildingID'];
    $FloorAndRoomID = $_POST['FloorAndRoomID'];
    $representative = $_POST['representative'];
    $idNum = $_POST['idNum']; 

    $affiliation = $_POST['affiliation']; 
    $department = $_POST['department']; 
    $organization = $_POST['organization']; 
    $office = $_POST['office']; 



    date_default_timezone_set("Asia/Singapore");

    $value = date("Y/m/d");
    $time = date("h:i:sa");
    $date = date('Y-m-d H:i:s', strtotime($value." ".$time));

    $count = $_SESSION['count'];

    $id = 0;    

    //insertion to request table
    if($affiliation == '1'){

        $sql1 = "INSERT INTO `thesis`.`request_borrow` (`officeID`, `BuildingID`, `FloorAndRoomID`, `startDate`, `endDate`, `personresponsibleID`, `personrepresentativeID`, `personrepresentative`, `dateCreated`, `purpose`, `statusID`, `steps`) VALUES ('{$office}', '{$buildingID}', '{$FloorAndRoomID }', '{$dateNeeded}', '{$endDate}', '{$employeeID}', '{$idNum}', '{$representative}', '{$date}', '{$purpose}', '1', '12');";//status is set to 1 for pending status
        $result1 = mysqli_query($dbc, $sql1);
    }

    if($affiliation == '2'){

        $sql2 = "INSERT INTO `thesis`.`request_borrow` ( `DepartmentID`, `BuildingID`, `FloorAndRoomID`, `startDate`, `endDate`, `personresponsibleID`, `personrepresentativeID`, `personrepresentative`, `dateCreated`, `purpose`, `statusID`, `steps`) VALUES ('{$department}', '{$buildingID}', '{$FloorAndRoomID }', '{$dateNeeded}', '{$endDate}', '{$employeeID}', '{$idNum}', '{$representative}', '{$date}', '{$purpose}', '1', '12');";//status is set to 1 for pending status
        $result2 = mysqli_query($dbc, $sql2);
    }
    if($affiliation == '3'){

        $sql3 = "INSERT INTO `thesis`.`request_borrow` (`organizationID`, `BuildingID`, `FloorAndRoomID`, `startDate`, `endDate`, `personresponsibleID`, `personrepresentativeID`, `personrepresentative`, `dateCreated`, `purpose`, `statusID`, `steps`) VALUES ('{$organization}', '{$buildingID}', '{$FloorAndRoomID }', '{$dateNeeded}', '{$endDate}', '{$employeeID}', '{$idNum}', '{$representative}', '{$date}', '{$purpose}', '1', '12');";//status is set to 1 for pending status

        $result3 = mysqli_query($dbc, $sql3);
    }
   
    
    $sql4 = "SELECT * FROM `thesis`.`request_borrow` order by borrowID DESC LIMIT 1;";
    $result4 = mysqli_query($dbc, $sql4);

    //get the id of the recently inserted item to request table
    $sql5 = "SELECT * FROM `thesis`.`request_borrow` order by borrowID DESC LIMIT 1;";
    $result5 = mysqli_query($dbc, $sql5);

    while ($row = mysqli_fetch_array($result5, MYSQLI_ASSOC)){
        $id = $row['borrowID'];
    }
   
   //insertion to requestdetails table using the id taken earlier
   for ($i=0; $i <= $count; $i++) { 

    $quantity = $_POST['quantity'.$i];
    $category = $_POST['category'.$i];


        $sql6 = "INSERT INTO `thesis`.`borrow_details` (`borrowID`, `quantity`, `assetCategoryID`) 
                VALUES ('{$id}', '{$quantity}', '{$category}');";
        $result6 = mysqli_query($dbc, $sql6); 

   }
    $message = "Form submitted!";
    $_SESSION['submitMessage'] = $message;
    

  unset($_SESSION['count']);  

  header('Location: '.$header);

?>