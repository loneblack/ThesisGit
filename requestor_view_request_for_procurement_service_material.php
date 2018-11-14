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
                                                        <h4 class="control-label col-lg-3">Department</h4>
                                                    </div>
                                                    <div class="form-group ">
                                                        <h4 class="control-label col-lg-3">Unit Head/Fund Owner</h4>
                                                    </div>
                                                    <div class="form-group ">
                                                        <h4 class="control-label col-lg-3">Contact Person</h4>
                                                    </div>
                                                    <div class="form-group ">
                                                        <h4 class="control-label col-lg-3">Email (DLSU)</h4>
                                                    </div>

                                                    <div class="form-group ">
                                                        <h4 class="control-label col-lg-3">Contact Number</h4>
                                                    </div>
                                                </section>
                                                <hr>
                                                <section>
                                                    <h4>User Location Information</h4>
                                                    <div class="form-group ">
                                                        <h4 class="control-label col-lg-3">Building</h4>
                                                    </div>
                                                    <div class="form-group">
                                                        <h4 class="control-label col-lg-3">floor & Room</h4>
                                                    </div>
                                                    <div class="form-group ">
                                                        <h4 class="control-label col-lg-3">Recipient</h4>
                                                    </div>
                                                    <div class="form-group ">
                                                       <h4 class="control-label col-lg-3">Date Needed</h4>
                                                    </div>
                                                </section>
                                                <hr>

                                                <section>
                                                    <h4>Request Details</h4>
                                                    <div class="form-group ">
                                                        <h4 class="control-label col-lg-3">Reason Of Request</h4>
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
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="col-lg-12">
                                                                        <input style="display: none" type="number" id="count" value=<?php echo $_SESSION['count'];?>/>
                                                                        <input class="form-control" type="number"  name="quantity0" id="quantity0" min="1" step="1" placeholder="Quantity" disabled />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="col-lg-12">
                                                                        <select class="form-control" name="category0" id="category0" disabled>
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
                                                                        <input class="form-control" type="text" name="description0" id="description0" placeholder="Item description" disabled/>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>


                                                    <br>
                                                </section>

                                                <div class="form-group">
                                                    <div class="col-lg-offset-3 col-lg-6">
                                                        <a href="requestor_dashboard.php"><button class="btn btn-default" type="button">Back</button></a>
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