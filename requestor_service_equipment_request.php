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
                                             <h5>Instructions: Place the item that you would like to borrow on the equipment then select the quantity that you would like to borrow. To add multiple items, press the add button on the right hand side of the table. Kindly fill up the date and time needed, floor and room, and reason for borrowing. If the asset would be borrowed for a long time use, kindly leave the asset return date as blank</h5>
                                            <hr>
                                            
                                            <form class="cmxform form-horizontal " id="signupForm" method="post" action="requestor_service_equipment_request_DB.php">

                                                <div class="form-group">
                                                    <label for="dateNeeded" class="control-label col-lg-3">Date & time needed</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" id="dateNeeded" name="dateNeeded" type="date" value="<?php 
															
																																				$date0 = new DateTime(date("Y-m-d"));
																																				date_modify($date0,"+1 day");
																																				echo date_format($date0,"Y-m-d");
																																			
																																			?>" min="<?php 
																																						
																																						$date = new DateTime(date("Y-m-d"));
																																						date_modify($date,"+1 day");
																																						echo date_format($date,"Y-m-d");
																																						
																																					?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="endDate" class="control-label col-lg-3">Asset Return date & time</label>
                                                    <div class="col-lg-6">
                                                        <input class=" form-control" id="endDate" name="endDate" type="date" min="<?php 
																																						
																																						$date = new DateTime(date("Y-m-d"));
																																						date_modify($date,"+1 day");
																																						echo date_format($date,"Y-m-d");
																																						
																																					?>" />
                                                    </div>
                                                </div>

                                                    <div class="form-group">
                                                        <label for="floorRoom" class="control-label col-lg-3">Floor & Room</label>
                                                        <div class="col-lg-6">
                                                            <select name="FloorAndRoomID" id="FloorAndRoomID" class="form-control m-bot15" required="">
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

                                                    <div class="form-group">
                                                    <label for="details" class="control-label col-lg-3">Reason for borrowing</label>
                                                    <div class="col-lg-6">
                                                        <textarea class="form-control" rows="5" name="purpose" id = "purpose" style="resize:none" required></textarea>
                                                    </div>
                                                </div>
                                                <hr>

                                            <br><br>
                                                <div class="container-fluid">
                                                    
                                                    <h4>Equipment to be borrowed</h4>
                                                    <h5>**Note: Quantity dropdown is based on how many assets that are currently available. If item is not available in the list, click <b><a href="http://localhost/ThesisGit/requestor_request_for_procurement_service_material.php">here</a></b> to request for purchase.</h5>

                                                    <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                        <thead>
                                                            <tr>
                                                                <th>Asset to Be Borrowed</th>
                                                                <th>Quantity Available</th>
                                                                <th>Item Description/ Proposed Specs</th>
                                                                <th>Add/ Remove</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <select name = "category0" class="form-control"  onChange="getMax(this.value)" required="">
                                                                        <option value=''>Select Category</option>
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
                                                                    <input style="display: none" type="number" id="count" value="<?php echo $_SESSION['count'];?>" />
                                                                    <select name='quantity0' id='quantity0' class='form-control m-bot15' required>              
                                                                        <option value=''>0</option>
                                                                    </select>
                                                                </td>
                                                                <td><input class="form-control" type="text" name="purpose0" id="purpose0"></td>
                                                                <td><button type = "button" class="btn btn-success" onclick="addTest()"> Add </button></td>
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

             $("#count").val(count);

            count++;
            var tr = "<tr>" +
                "<td><select class='form-control' name='category"+count+"' id='category"+count+"' onChange='getMax(this.value)' >"+

                "<option value=''>Select Category</option>"+

                "<?php

                    $sql = 'SELECT * FROM thesis.ref_assetcategory;';

                    $result = mysqli_query($dbc, $sql);

                     $_SESSION['count'] += 1;

                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                    {
                            
                        echo "<option value ={$row['assetCategoryID']}>";
                        echo "{$row['name']}</option>";

                    }


                ?>" 


                +"</select></td>" +
                "<td><select name='quantity"+count+"' id='quantity"+count+"' class='form-control m-bot15'></select></td>" +
                "<td><input type='text' name='purpose"+count+"' id='purpose"+count+"' class='form-control m-bot15'></select></td>" +
                "<td><button class='btn btn-danger' onclick='removeRow(this)'> Remove </button></td>" +
                "</tr>";

            $('#tableTest tbody tr').eq(rowCount).after(tr);

            $.ajax({
            type:"POST",
            url:"count.php",
            data: 'count='+count,
            success: function(data){
                $("#count").html(data);

                }
            });
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