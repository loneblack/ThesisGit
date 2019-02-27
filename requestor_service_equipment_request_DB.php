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

    $sql0 = "SELECT * FROM `thesis`.`department_list` WHERE employeeID = {$employeeID};";//get the employeeID using userID
    $result0 = mysqli_query($dbc, $sql0);

    while ($row = mysqli_fetch_array($result0, MYSQLI_ASSOC)){
        $DepartmentID = $row['DepartmentID'];
        
    }

    $purpose = $_POST['purpose'];
    $dateNeeded = $_POST['dateNeeded'];
    $endDate = $_POST['endDate'];   

    $FloorAndRoomID = $_POST['FloorAndRoomID'];

    date_default_timezone_set("Asia/Singapore");

    $value = date("Y/m/d");
    $time = date("h:i:sa");
    $date = date('Y-m-d H:i:s', strtotime($value." ".$time));

    $count = $_SESSION['count'];

    echo $count;

    $id = 0;    


    $sql1 = "SELECT * FROM `thesis`.`floorandroom` WHERE FloorAndRoomID = '{$FloorAndRoomID}';";
    $result1 = mysqli_query($dbc, $sql1);

    while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)){
        $buildingID = $row['BuildingID'];
    }

    //insertion to request table
    $sql2 = "INSERT INTO `thesis`.`request_borrow` ( `DepartmentID`, `BuildingID`, `FloorAndRoomID`, `startDate`, `endDate`, `personresponsibleID`, `dateCreated`,`purpose`, `statusID`, `steps`) VALUES ('{$DepartmentID}', '{$buildingID}', '{$FloorAndRoomID }', '{$dateNeeded}', '{$endDate}', '{$employeeID}', '{$date}', '{$purpose}', '1', '12');";//status is set to 1 for pending status
    $result2 = mysqli_query($dbc, $sql2);

    if($endDate == ""){
        $sql2 = "INSERT INTO `thesis`.`request_borrow` ( `DepartmentID`, `BuildingID`, `FloorAndRoomID`, `startDate`, `endDate`, `personresponsibleID`, `dateCreated`,`purpose`, `statusID`, `steps`) VALUES ('{$DepartmentID}', '{$buildingID}', '{$FloorAndRoomID }', '{$dateNeeded}', NULL, '{$employeeID}', '{$date}', '{$purpose}', '1', '12');";//status is set to 1 for pending status
        $result2 = mysqli_query($dbc, $sql2);
    }
    echo $sql2;

    //get the id of the recently inserted item to request table
    $sql5 = "SELECT * FROM `thesis`.`request_borrow` order by borrowID DESC LIMIT 1;";
    $result5 = mysqli_query($dbc, $sql5);

    while ($row = mysqli_fetch_array($result5, MYSQLI_ASSOC)){
        $id = $row['borrowID'];
    }
   
   //insertion to requestdetails table using the id taken earlier
   for ($i=0; $i < $count; $i++) { 

    $quantity = $_POST['quantity'.$i];
    $category = $_POST['category'.$i];
    $purpose = $_POST['purpose'.$i];


        $sql6 = "INSERT INTO `thesis`.`borrow_details` (`borrowID`, `quantity`, `assetCategoryID`, `purpose`) 
                VALUES ('{$id}', '{$quantity}', '{$category}', '{$purpose}');";
        $result6 = mysqli_query($dbc, $sql6); 

   }
    $message = "Form submitted!";
    $_SESSION['submitMessage'] = $message;
    

  unset($_SESSION['count']);  

  header('Location: '.$header);

?>