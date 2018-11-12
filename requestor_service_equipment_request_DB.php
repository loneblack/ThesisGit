<?php

    session_start();
    require_once("db/mysql_connect.php");

    $header =  $_SESSION['previousPage'];

    $employeeID = 1;
    $userID = $_SESSION['userID'];

    $depschoolorg = $_POST['depschoolorg'];
    $orgName = $_POST['orgName'];
    $dateNeeded = $_POST['dateNeeded'];
    $endDate = $_POST['endDate'];
    $purpose = $_POST['purpose'];
    $buildingID = $_POST['buildingID'];
    $FloorAndRoomID = $_POST['FloorAndRoomID'];
    $representative = $_POST['representative'];
    $idNum = $_POST['idNum'];  


    date_default_timezone_set("Asia/Singapore");

    $value = date("Y/m/d");
    $time = date("h:i:sa");
    $date = date('Y-m-d H:i:s', strtotime($value." ".$time));

    $count = $_SESSION['count'];

    $id = 0;    

    //insertion to request table
    $sql0 = "INSERT INTO `thesis`.`request_borrow` (`DepartmentID`, `BuildingID`, `FloorAndRoomID`, `startDate`, `endDate`, `personresponsibleID`, `personrepresentativeID`, `personrepresentative`, `dateCreated`, `purpose`, `statusID`) VALUES ('1', '3', '1', '2018-11-12 10:08:07', '2018-11-12 10:08:07', '1', '114232323', 'johannes ssss', '2018-11-12 10:08:07', 'purpose', '1');";//status is set to 1 for pending status
    //$result0 = mysqli_query($dbc, $sql0);


    if (!mysqli_query($dbc,$sql0))
      {
      echo("Error description: " . mysqli_error($dbc));
      }

    
    $sql2 = "SELECT * FROM `thesis`.`request_borrow` order by borrowID DESC LIMIT 1;";
    $result2 = mysqli_query($dbc, $sql2);

    //get the id of the recently inserted item to request table
    $sql1 = "SELECT * FROM `thesis`.`request_borrow` order by borrowID DESC LIMIT 1;";
    $result1 = mysqli_query($dbc, $sql1);

    while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)){
        $id = $row['borrowID'];
    }
   
   //insertion to requestdetails table using the id taken earlier
   for ($i=0; $i < $count; $i++) { 

    $quantity = $_POST['quantity'.$i];
    $category = $_POST['category'.$i];



        $sql = "INSERT INTO `thesis`.`requestdetails` (`requestID`, `quantity`, `assetCategory`, `description`) 
                VALUES ('{$id}', '{$quantity}', '{$category}', '{$description}');";
        $result = mysqli_query($dbc, $sql);       

   }
    $message = "Form submitted!";
    $_SESSION['submitMessage'] = $message;
    

  unset($_SESSION['count']);  

  header('Location: '.$header);

?>