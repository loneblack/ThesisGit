<?php
    session_start();
    require_once("db/mysql_connect.php");

    $header =  $_SESSION['previousPage'];

    $employeeID = 1;
    $userID = $_SESSION['userID'];
    $buildingID = "";
    $FloorAndRoomID = ""; 

    //get the location from userID
    $sql = "SELECT * FROM `thesis`.`employee` WHERE UserID = '{$userID}';";
    $result = mysqli_query($dbc, $sql);

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $FloorAndRoomID = $row['FloorAndRoomID'];
    }

    // TO DO
    //get the buildingId from the floor and room ID
    $sql = "SELECT * FROM `thesis`.`floorandroom` WHERE FloorAndRoomID = '{$FloorAndRoomID}';";
    $result = mysqli_query($dbc, $sql);

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $buildingID = $row['BuildingID'];
    }
    

    $dateNeeded = $_POST['dateNeeded'];
    $comment = $_POST['comment'];


    date_default_timezone_set("Asia/Singapore");

    $value = date("Y/m/d");
    $time = date("h:i:sa");
    $date = date('Y-m-d H:i:s', strtotime($value." ".$time));

    $count = $_SESSION['count'];

    $id = 0;    
        $sql0 = "INSERT INTO `thesis`.`request` (`description`, `employeeID`, `date`, `FloorAndRoomID`, `BuildingID`, `dateNeeded`, `UserID`, `status`, `step`) VALUES ('{$comment}', '{$employeeID}', '{$date}', '{$FloorAndRoomID}', '{$buildingID}', '{$dateNeeded}', '{$userID}', '1', '1');";//status is set to 1 for pending status
        $result0 = mysqli_query($dbc, $sql0);
        echo $sql0;

    $sql2 = "SELECT * FROM `thesis`.`request` order by requestID DESC LIMIT 1;";
    $result2 = mysqli_query($dbc, $sql2);

    //get the id of the recently inserted item to request table
    $sql1 = "SELECT * FROM `thesis`.`request` order by requestID DESC LIMIT 1;";
    $result1 = mysqli_query($dbc, $sql1);

    while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)){
        $id = $row['requestID'];
    }
   
   //insertion to requestdetails table using the id taken earlier
   for ($i=0; $i < $count; $i++) { 

    $quantity = $_POST['quantity'.$i];
    $category = $_POST['category'.$i];
    $description = $_POST['description'.$i];


        $sql = "INSERT INTO `thesis`.`requestdetails` (`requestID`, `quantity`, `assetCategory`, `description`) 
                VALUES ('{$id}', '{$quantity}', '{$category}', '{$description}');";
        $result = mysqli_query($dbc, $sql);       

   }
    $message = "Form submitted!";
    $_SESSION['submitMessage'] = $message;
    

  unset($_SESSION['count']);  

  header('Location: '.$header);
?>