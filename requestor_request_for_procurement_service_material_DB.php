<?php
    session_start();
    require_once("db/mysql_connect.php");

    $employeeID = 1;
    $userID = $_SESSION['userID'];

    $department = $_POST['department'];
    $unitHead = $_POST['unitHead'];
    $contactPerson = $_POST['contactPerson'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $buildingID = $_POST['buildingID'];
    $FloorAndRoomID = $_POST['FloorAndRoomID'];
    $recipient = $_POST['recipient'];
    $dateNeeded = $_POST['dateNeeded'];
    $comment = $_POST['comment'];

    $quantityArray = $_POST['quantityArray'];
    $categoryArray = $_POST['categoryArray'];
    $descriptionArray = $_POST['descriptionArray'];

    date_default_timezone_set("Asia/Singapore");

    $value = date("Y/m/d");
    $time = date("h:i:sa");
    $date = date('Y-m-d H:i:s', strtotime($value." ".$time));

    $count = sizeof($quantityArray);

    $id = 0;

    echo $department." ".$unitHead." ".$contactPerson." ".$email." ".$number." ".$buildingID." ".$FloorAndRoomID." ".$recipient." ".$dateNeeded." ".$comment." ".$date;

    //insertion to request table
    $sql0 = "INSERT INTO `thesis`.`request` (`description`, `DepartmentID`, `unitHead`, `recipient`, `employeeID`, `date`, `FloorAndRoomID`, `BuildingID`, `dateNeeded`, `UserID`, `status`) VALUES ('{$comment}', '{$department}', '{$unitHead}', '{$recipient}', '{$employeeID}', '{$date}', '{$FloorAndRoomID}', '{$buildingID}', '{$dateNeeded}', '{$userID}', '1');";//status is set to 1 for pending status

    //$result0 = mysqli_query($dbc, $sql0);

    $sql2 = "SELECT * FROM `thesis`.`request` order by requestID DESC LIMIT 1;";
    $result2 = mysqli_query($dbc, $sql2);

    echo "after!!";

    //get the id of the recently inserted item to request table
    $sql1 = "SELECT * FROM `thesis`.`request` order by requestID DESC LIMIT 1;";
    $result1 = mysqli_query($dbc, $sql1);
    echo "ahh i need help here";

    while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)){
        $id = $row['requestID'];
        echo " this is id: ".$id;
    }
   
   //insertion to requestdetails table using the id taken earlier
   for ($i=1; $i < $count; $i++) { 

    echo " items: ".$quantityArray[$i]. " ". $categoryArray[$i]. " ".$descriptionArray[$i];

        $sql = "INSERT INTO `thesis`.`requestdetails` (`requestID`, `quantity`, `assetCategory`, `description`) 
                VALUES ('{$id}', '{$quantityArray[$i]}', '{$categoryArray[$i]}', '{$descriptionArray[$i]}');";
        $result = mysqli_query($dbc, $sql);       

   }
   echo "omylord";
    $message = "Form submitted!";
    $_SESSION['submitMessage'] = $message

    
?>