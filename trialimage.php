<?php
$CurDate = date("Y-m-d"); //Current date.
$NextDate = date("Y-m-d", strtotime("+2 week")); //Next date = +2 week from start date
while ($CurDate > $NextDate ) { 
    $NextDate = date("Y-m-d", strtotime("+2 week", strtotime($NextDate)));
}
$_SESSION['dueDate']=date("Y-m-d", strtotime($NextDate));

echo $_SESSION['dueDate'];

?>