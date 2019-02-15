<!DOCTYPE html>
<html lang="en">
<?php
session_start();
  require_once("db/mysql_connect.php");
  $_SESSION['count'] = 0;
  $_SESSION['previousPage'] = "requestor_service_equipment_request.php";
  $userID = $_SESSION['userID'];
  $departments = array();

  $sql = "SELECT userType FROM thesis.user where UserID = 9";
  $result = mysqli_query($dbc, $sql);

	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$userTypeID = $row['userType'];
	}

$sql = "SELECT * FROM thesis.department_list where employeeID = '{$userID}'";
$result = mysqli_query($dbc, $sql);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        array_push($departments, $row['DepartmentID']);
    }
echo print_r($departments);
?>

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="images/favicon.png">

    <title>DLSU IT Asset Management</title>

    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />

    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
</head>

<body>

    <section id="container">
        <!--header start-->
        <header class="header fixed-top clearfix">
            <!--logo start-->
            <div class="brand">

                <a href="#" class="logo">
                    <img src="images/dlsulogo.png" alt="" width="200px" height="40px">
                </a>
            </div>

            <div class="nav notify-row" id="top_menu">

            </div>

        </header>
        <!--header end-->
        <?php include 'requestor_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        Borrow An Asset
                                    </header>
                                    <div class="panel-body">
                                        <div class="form" method="post">
                                            <?php
                                                if (isset($_SESSION['submitMessage'])){

                                                    echo "<div style='text-align:center' class='alert alert-success'>
                                                            <strong><h3>{$_SESSION['submitMessage']}</h3></strong>
                                                          </div>";

                                                    unset($_SESSION['submitMessage']);
                                                }
                                            ?>
                                             <h4>Instructions: Place the item that you would like to borrow on the equipment then select the quantity that you would like to borrow. To add multiple items, press the add button on the right hand side of the table.</h4>
                                            
                                            <form class="cmxform form-horizontal " id="signupForm" method="post" action="requestor_service_equipment_request_DB.php">

                                                <div class="form-group ">
                                                    <label for="dateNeeded" class="control-label col-lg-3">Date & time needed</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" id="dateNeeded" name="dateNeeded" type="date" value="<?php echo date('Y-m-d'); ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="endDate" class="control-label col-lg-3">Asset Return date & time</label>
                                                    <div class="col-lg-6">
                                                        <input class=" form-control" id="endDate" name="endDate" type="date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>" />
                                                    </div>
                                                </div>
                                                
                                                <!--
                                                <div class="form-group ">
                                                    <label for="purpose" class="control-label col-lg-3">Purpose</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" id="purpose" name="purpose" type="text" />
                                                    </div>
                                                </div> 
                                                -->


                                                    <div class="form-group">
                                                        <label for="floorRoom" class="control-label col-lg-3">Floor & Room</label>
                                                        <div class="col-lg-6">
                                                            <select name="FloorAndRoomID" id="FloorAndRoomID" class="form-control m-bot15">
                                                                <option value=''>Select floor & room</option>
                                                                <?php
                                                                for($i = 0; $i < sizeof($departments); $i++)
                                                                { 
                                                                
                                                                   $sql = "     SELECT * FROM thesis.floorandroom f 
                                                                                JOIN departmentownsroom d ON f.FloorAndRoomID = d.FloorAndRoomID 
                                                                                WHERE d.DepartmentID = '{$departments[$i]}';";
                                                                   

                                                                   $result = mysqli_query($dbc, $sql);

                                                                   while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                                   {
                                                                           
                                                                       echo "<option value ={$row['FloorAndRoomID']}>";
                                                                       echo "{$row['floorRoom']}</option>";

                                                                   }
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                <hr>
                                                <?php

                                                echo sizeof($departments)."ASDASDASD";
                                                echo $sql;

                                                ?>
                                            <br><br>
                                                <div class="container-fluid">
                                                    
                                                    <h4>Equipment to be borrowed</h4>
                                                    <h5>**Note: Quantity dropdown is based on how many assets that are currently available.</h5>

                                                    <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                        <thead>
                                                            <tr>
                                                                <th>Equipment</th>
                                                                <th>Quantity</th>
                                                                <th>Purpose/ Proposed Specs</th>
                                                                <th>Add/ Remove</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <select name = "category0" class="form-control"  onChange="getMax(this.value)" >
                                                                        <option>Select Category</option>
                                                                         <?php

                                                                            $sql = "SELECT * FROM thesis.ref_assetcategory;";

                                                                            $result = mysqli_query($dbc, $sql);

                                                                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                                            {
                                                                                    
                                                                                echo "<option value ={$row['assetCategoryID']}>";
                                                                                echo "{$row['name']}</option>";

                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select name='quantity0' id='quantity0' class='form-control m-bot15' required>              
                                                                        <option value=''>0</option>
                                                                    </select>
                                                                </td>
                                                                <td><input class="form-control" type="text" id="purpose"></td>
                                                                <td><button type = "button" class="btn btn-success" onclick="addTest(4)"> Add </button></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                        <div class="col-lg-offset-0 col-lg-8">
                                                            <button class="btn btn-primary" type="submit">Save</button>
                                                            <button class="btn btn-default"  onclick="window.history.back();" type="button">Cancel</button>
                                                        </div>
                                            </form>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>

   
    <!-- WAG GALAWIN PLS LANG -->

    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>
    <script type="text/javascript">
        var count = 0; 
        function removeRow(o) {
            var p = o.parentNode.parentNode;
            p.parentNode.removeChild(p);
        }
        function addTest(cavasItemID) {
            var row_index = 0;
            var canvasItemID = cavasItemID;
            var isRenderd = false;

            $("td").click(function() {
                row_index = $(this).parent().index();

            });

            var delayInMilliseconds = 0; //1 second

            setTimeout(function() {

                appendTableRow(row_index, canvasItemID);
            }, delayInMilliseconds);


        }
        var appendTableRow = function(rowCount, canvasItemID) {
            var cnt = 0;
            count++;
            var tr = "<tr>" +
                "<td><select class='form-control' name='category"+count+"' id='category"+count+"' onChange='getMax(this.value)' >"+

                "<option>Select Category</option>"+

                '<?php

                    $sql = "SELECT * FROM thesis.ref_assetcategory;";

                    $result = mysqli_query($dbc, $sql);

                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                    {
                            
                        echo "<option value ={$row['assetCategoryID']}>";
                        echo "{$row['name']}</option>";

                    }

                    $_SESSION['count']++;


                ?>'


                +"</select></td>" +
                "<td><select name='quantity"+count+"' id='quantity"+count+"' class='form-control m-bot15'></select></td>" +
                "<td><input type='text' name='purpose"+count+"' id='purpose"+count+"' class='form-control m-bot15'></select></td>" +
                "<td><button class='btn btn-danger' onclick='removeRow(this)'> Remove </button></td>" +
                "</tr>";
            $('#tableTest tbody tr').eq(rowCount).after(tr);
        }
         function checkvalue(val){
            if(val==="1"){
                document.getElementById('office').style.display='block';
                document.getElementById('department').style.display='none';
                document.getElementById('org').style.display='none';}
            if(val==="2"){
                document.getElementById('office').style.display='none';
                document.getElementById('department').style.display='block';
                document.getElementById('org').style.display='none';}
            if(val==="3"){
                document.getElementById('office').style.display='none';
                document.getElementById('department').style.display='none';
                document.getElementById('org').style.display='block';}
            if(val==="0"){
                document.getElementById('office').style.display='none';
                document.getElementById('department').style.display='none';
                document.getElementById('org').style.display='none';}
        }

           function getRooms(val){
            $.ajax({
            type:"POST",
            url:"requestor_getRooms.php",
            data: 'buildingID='+val,
            success: function(data){
                $("#FloorAndRoomID").html(data);

                }
            });
        }
        function getMax(val){
            $.ajax({
            type:"POST",
            url:"requestor_getMax.php",
            data: 'categoryID='+val,
            success: function(data){

                $("#quantity"+count).html(data);

                }
            });
        }
        
    </script>

</body>

</html>