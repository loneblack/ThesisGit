<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require_once("db/mysql_connect.php");
$_SESSION['previousPage'] = "requestor_request_for_procurement_service_material.php";
$_SESSION['count'] = 0;
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
                                        Request For Procurement of Services and Materials
                                    </header>
                                    <div class="panel-body">
                                        <div class="form" method="post">
                                            <form class="cmxform form-horizontal " id="signupForm" method="post" action="requestor_request_for_procurement_service_material_DB.php">
                                                <?php
                                                    if (isset($_SESSION['submitMessage'])){

                                                        echo "<div class='alert alert-success'>
                                                                {$_SESSION['submitMessage']}
                                                              </div>";

                                                        unset($_SESSION['submitMessage']);
                                                    }
                                                ?>
                                                <section>
                                                    <h4>Contact Information</h4>

                                                    <div class="form-group ">
                                                        <label for="department" class="control-label col-lg-3">Department</label>
                                                        <div class="col-lg-6">
                                                            <select name="department" id="department" class="form-control m-bot15" required>
                                                                <option value=''>Select department</option>
                                                                <?php

                                                                    
                                                                    $sql = "SELECT * FROM thesis.department;";

                                                                    $result = mysqli_query($dbc, $sql);

                                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                                    {
                                                                        
                                                                        echo "<option value ={$row['DepartmentID']}>";
                                                                        echo "{$row['name']}</option>";

                                                                    }
                                                               ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="unitHead" class="control-label col-lg-3">Unit Head/Fund Owner</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" rows="5" id="unitHead" name="unitHead" style="resize:none" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="contactPerson" class="control-label col-lg-3">Contact Person</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" id="contactPerson" name="contactPerson" type="text" />
                                                        </div>
                                                    </div>
                                                </section>
                                                <hr>
                                                <section>
                                                    <h4>User Location Information</h4>
                                                    <div class="form-group ">
                                                        <label for="building" class="control-label col-lg-3">Building</label>
                                                        <div class="col-lg-6">
                                                            <select name="buildingID" id="buildingID" class="form-control m-bot15" onChange="getRooms(this.value)" required>
                                                                <option value="">Select building</option>
                                                                <?php

                                                                    $sql = "SELECT * FROM thesis.building;";

                                                                    $result = mysqli_query($dbc, $sql);

                                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                                    {
                                                                        
                                                                        echo "<option value ={$row['BuildingID']}>";
                                                                        echo "{$row['name']}</option>";

                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="floorRoom" class="control-label col-lg-3">Floor & Room</label>
                                                        <div class="col-lg-6">
                                                            <select name="FloorAndRoomID" id="FloorAndRoomID" class="form-control m-bot15" required>
                                                                <option value=''>Select floor & room</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="recipient" class="control-label col-lg-3">Recipient</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" id="recipient" name="recipient" type="text" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="dateNeeded" class="control-label col-lg-3">Date needed</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" id="dateNeeded" name="dateNeeded" type="datetime-local" />
                                                        </div>
                                                    </div>
                                                </section>
                                                <hr>

                                                <section>
                                                    <h4>Request Details</h4>
                                                    <div class="form-group ">
                                                        <label for="building" class="control-label col-lg-3">Reason of Request</label>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <textarea class="form-control" rows="5" id="comment" name= "comment" style="resize: none" required></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>

                                                <hr>

                                                <section>
                                                    <h4>Requested Services/Materials</h4>
                                                    <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                        <thead>
                                                            <tr>
                                                                <th>Quantity</th>
                                                                <th>Category</th>
                                                                <th>Description</th>
                                                                <th>Remove</th>
                                                                <th>Add</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="col-lg-12">
                                                                        <input style="display: none" type="number" id="count" value=<?php echo $_SESSION['count'];?>/>
                                                                        <input class="form-control" type="number"  name="quantity0" id="quantity0" min="1" step="1" placeholder="Quantity" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="col-lg-12">
                                                                        <select class="form-control" name="category0" id="category0">
                                                                            <option>Select</option>
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
                                                                    </div>
                                                                </td>

                                                                <td style="padding-top:5px; padding-bottom:5px">
                                                                    <div class="col-lg-12">
                                                                        <input class="form-control" type="text" name="description0" id="description0" placeholder="Item description" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                </td>
                                                                <td>
                                                                <button type='button' class='btn btn-primary' onclick='addTest();'> Add </button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>


                                                    <br>
                                                </section>

                                                <div class="form-group">
                                                    <div class="col-lg-offset-3 col-lg-6">
                                                        <button class="btn btn-primary" type="submit" onclick="getData('tblRequest');">Save</button>
                                                        <button class="btn btn-default" type="button">Cancel</button>
                                                    </div>
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
        var count = 1;
		// Shorthand for $( document ).ready()
        $(function() {

        });


        function removeRow(o) {
            var p = o.parentNode.parentNode;
            p.parentNode.removeChild(p);
        }

        function addTest() {


           
            var row_index = 0;
            var isRenderd = false;

            $("td").click(function() {
                row_index = $(this).parent().index();

            });

            var delayInMilliseconds = 300; //1 second

            setTimeout(function() {

                appendTableRow(row_index);
            }, delayInMilliseconds);



        }
		
		
        var appendTableRow = function(rowCount) {

             $("#count").val(count);

            var tr = 
                
                            "<tr>" +
                                    "<td>" +
                                       " <div class='col-lg-12'>" +
                                            "<input class='form-control' type='number' id='quantity"+count+"' name = 'quantity"+count+"' min='1'" + "step='1' placeholder='Quantity' />" +
                                        "</div>" +
                                    "</td>" +
                                    "<td>" +
                                        "<div class='col-lg-12'>" +
                                            "<select class='form-control' id='category"+count+"' name = 'category"+count+"'>" +
                                                "<option>Select</option>" +

                                                '<?php

                                                    $sql = "SELECT * FROM thesis.ref_assetcategory;";

                                                    $result = mysqli_query($dbc, $sql);

                                                    $_SESSION['count'] += 1;

                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                        
                                                        echo "<option value ={$row['assetCategoryID']}>";
                                                        echo "{$row['name']}</option>";

                                                    }
                                                ?>'

                                            +"</select>" +
                                        "</div>" +
                                    "</td>" +
                                    "<td style='padding-top:5px; padding-bottom:5px'>" +
                                        "<div class='col-lg-12'>" +
                    "<input class='form-control' type='text' id='description"+count+"' name ='description"+count+"' placeholder='Item description' />" +
                                        "</div>" +
                                    "</td>" +
                                    "<td>" +
        "<button id='remove' class='btn btn-danger' type='button' onClick='removeRow(this)'>Remove</button>" +
                                    "</td>" +
                                    "<td>" +
                                    "</td>" +
                                    "</tr>"
				
				
				
				
            $('#tableTest tbody tr').eq(rowCount).after(tr);

            count++;

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
	</script>

</body>

</html>