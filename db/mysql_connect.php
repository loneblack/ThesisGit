<?php 
$dbc = MYSQLI_CONNECT("localhost", "root", "12345", "thesis");

    if (!$dbc) {
      die("Connection failed: " . mysqli_connect_error());
      echo "Could not connect.";
    }

    if($dbc){
      //echo "Connection successful ";
    }
?>