<?php
session_start();

$serviceType = $_POST['serviceType'];
$others = $_POST['others'];
$details = $_POST['details'];
$dateNeeded = $_POST['dateNeeded'];
$endDate = $_POST['endDate'];

echo $serviceType." ".$others." ".$details." ".$dateNeeded." ".$endDate;

?>