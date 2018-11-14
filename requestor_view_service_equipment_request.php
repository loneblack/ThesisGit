<!DOCTYPE html>
<html lang="en">
<?php
session_start();
  require_once("db/mysql_connect.php");
  $_SESSION['count'] = 0;
  $_SESSION['previousPage'] = "requestor_service_equipment_request.php";
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
                                        Service Equipment Request
                                    </header>
                                    <div class="panel-body">
                                        <div class="form" method="post">
                                            <?php
                                                    if (isset($_SESSION['submitMessage'])){

                                                        echo "<div class='alert alert-success'>
                                                                {$_SESSION['submitMessage']}
                                                              </div>";

                                                        unset($_SESSION['submitMessage']);
                                                    }
                                                ?>
                                            <form class="cmxform form-horizontal " id="signupForm" method="post" action="requestor_service_equipment_request_DB.php">
                                                <div class="form-group ">
                                                    <h5 class="control-label col-lg-3">Office/Department/School Organization</h5>
                                                </div>
                                                <div class="form-group " style="display: none">
                                                    <h5 class="control-label col-lg-3">School Organization Name</h5>
                                                </div>
                                                <div class="form-group ">
                                                    <h5 class="control-label col-lg-3">Date & Time Needed</h5>
                                                </div>
                                                <div class="form-group ">
                                                    <h5 class="control-label col-lg-3">End Date & Time</h5>
                                                </div>
                                                <div class="form-group ">
                                                    <h5 class="control-label col-lg-3">Purpose</h5>
                                                </div>
                                                <div class="form-group ">
                                                    <h5 class="control-label col-lg-3">Building</h5>
                                                </div>
                                                <div class="form-group">
                                                    <h5 class="control-label col-lg-3">Floor & Room</h5>
                                                </div>
                                                <hr>
                                                <div class="container-fluid">
                                                    <h4>Equipment to be borrowed</h4>

                                                    <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                        <thead>
                                                            <tr>
                                                                <th>Equipment</th>
                                                                <th>Quantity</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <select name = "category0" class="form-control"  onChange="getMax(this.value)" disabled >
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
                                                                    <select name='quantity0' id='quantity0' class='form-control m-bot15' disabled required>              
                                                                        <option value=''>0</option>
                                                                    </select>
                                                                </td>
                                                               
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <hr>
                                                <div class="container-fluid">
                                                    <h4>Endorsement (if applicable)</h4>
                                                    <h5>Kindly fill up both fields if there is a representative.</h5>
                                                    <div class="form-group ">
                                                        <h5 class="control-label col-lg-3">Representative</h5>
                                                    </div>
                                                    <div class="form-group ">
                                                        <h5 class="control-label col-lg-3">ID Number</h5>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-lg-offset-3 col-lg-6">
                                                            <button class="btn btn-default"  onclick="window.history.back();" type="button">Cancel</button>
                                                        </div>
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
                "<td><select class='form-control' name='category"+count+"' id='category"+count+"' onChange='getMax(this.value)' ><option>Select Category</option>"+

                '<?php

                    $sql = "SELECT * FROM thesis.ref_assetcategory;";

                    $result = mysqli_query($dbc, $sql);

                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                    {
                            
                        echo "<option value ={$row['assetCategoryID']}>";
                        echo "{$row['name']}</option>";

                    }

                    $_SESSION['count']++;


                ?>'+


                +"</select></td>" +
                "<td><select name='quantity"+count+"' id='quantity"+count+"' class='form-control m-bot15'></select></td>" +
                "<td><button class='btn btn-danger' onclick='removeRow(this)'> Remove </button></td>" +
                "</tr>";
            $('#tableTest tbody tr').eq(rowCount).after(tr);
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