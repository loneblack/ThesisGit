<?php
session_start();
require_once('db/mysql_connect.php');

$header = "it_mark_su.php";

$assets = $_POST['mark'];

foreach ($assets as $asset) {
    $sql = "UPDATE `thesis`.`asset` SET `isServiceUnit` = '1' WHERE (`assetID` = '{$asset}');";
    $result = mysqli_query($dbc,$sql);

    echo $sql;
}
$message = "From Submitted!";

$_SESSION['submitMessage'] = $message;

header("Location: ".$header);
?>