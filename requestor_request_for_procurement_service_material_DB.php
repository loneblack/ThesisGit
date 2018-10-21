<?php
    session_start();
    require_once("db/mysql_connect.php");

    $department = $_POST['department'];
    $unitHead = $_POST['unitHead'];
    $contactPerson = $_POST['contactPerson'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $BuildingID = $_POST['BuildingID'];
    $FloorAndRoomID = $_POST['FloorAndRoomID'];
    $recipient = $_POST['recipient'];
    $dateNeeded = $_POST['dateNeeded'];
   

    $header =  $_SESSION['previousPage'];

    $sql = "INSERT INTO `thesis`.`service` (`details`, `dateNeed`, `endDate`, `UserID`, `serviceType`, `others`, `status`)
                                    VALUES ('{$details}', '{$dateNeeded}', '{$endDate}', '1', '{$serviceType}', '{$others}', '10');";//status is set to 10 for pending status
    $result0 = mysqli_query($dbc, $sql);

    $message = "Form submitted!";
    $_SESSION['submitMessage'] = $message;

    header('Location: '.$header);
?>