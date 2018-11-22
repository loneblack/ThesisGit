<!DOCTYPE html>
<html lang="en">
<?php
session_start();

$id = $_GET['id'];//get the id of the selected service request

require_once("db/mysql_connect.php");

$query =  "SELECT *, details, dateNeed, endDate, dateReceived, s.serviceType AS 'serviceTypeID', t.serviceType, statusID, description AS 'status', others, steps
            FROM thesis.service s
                JOIN ref_servicetype t
            ON s.serviceType = t.id
                JOIN ref_status a
            ON s.status = a.statusID
                JOIN employee e 
            ON s.UserID = e.UserID
                WHERE s.id = {$id}";
$result = mysqli_query($dbc, $query);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    
        $name = $row['name'];      
        $dateReceived = $row['dateReceived'];
        $summary = $row['summary'];
        $details = $row['details'];
        $dateNeed = $row['dateNeed'];
        $endDate = $row['endDate'];
        $serviceTypeID = $row['serviceTypeID'];
        $serviceType = $row['serviceType'];
        $statusID = $row['statusID'];
        $description = $row['description'];
        $others = $row['others'];
        $steps = $row['steps'];

    }
$assets = array();

$query2 =  "SELECT * FROM thesis.servicedetails WHERE serviceID = {$id};";
$result2 = mysqli_query($dbc, $query2);

while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
    array_push($assets, $row['asset']);
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
        <?php include 'it_navbar.php' ?>

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
											<a href="it_requests.php"><button type="button" class="btn btn-link"><strong>< Back</strong></button></a>
                                            <form class="cmxform form-horizontal " id="signupForm" method="get" action="">
                                                <div class="form-group ">
                                                    <label for="serviceType" class="control-label col-lg-3">Office/Department/School Organization</label>
                                                    <div class="col-lg-6">
														<textarea class="form-control" style="resize:none" disabled></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="number" class="control-label col-lg-3">Contact No.</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" rows="5" name="details" style="resize:none" type="text" required disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="dateNeeded" class="control-label col-lg-3">Date & time needed</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" id="dateNeeded" name="dateNeeded" type="datetime-local" disabled />
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="endDate" class="control-label col-lg-3">End date & time</label>
                                                    <div class="col-lg-6">
                                                        <input class=" form-control" id="endDate" name="endDate" type="datetime-local" disabled />
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="purpose" class="control-label col-lg-3">Purpose</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" id="purpose" name="purpose" type="text" disabled />
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="building" class="control-label col-lg-3">Building</label>
                                                    <div class="col-lg-6">
                                                        <select name="building" class="form-control m-bot15" onChange="getRooms(this.value)" disabled>
                                                            <option>Select building</option>
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
                                                        <select name="FloorAndRoomID" id="FloorAndRoomID" class="form-control m-bot15" disabled>
                                                            <option value=''>Select floor & room</option>
                                                        </select>
                                                    </div>
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
                                                                    <select class="form-control" disabled>
                                                                        <option>Select Category</option>
                                                                        <option>Computer</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="number" min="0" max="999999" step="1" class="form-control" disabled></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <hr>
                                                <div class="container-fluid">
                                                    <h4>Endorsement (if applicable)</h4>
                                                    <div class="form-group ">
                                                        <label for="representative" class="control-label col-lg-3">Representative</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" id="representative" name="representative" type="text" disabled />
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="idNum" class="control-label col-lg-3">ID Number</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" id="idNum" name="idNum" type="text" disabled />
                                                        </div>
                                                    </div>
													<hr>
                                                    <div class="form-group">
														<button id="approveBtn" name="approveBtn" class="btn btn-success" type="submit">Approve</button>
														&nbsp;
														<button id="denyBtn" name="denyBtn" class="btn btn-danger" type="submit">Deny</button>
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
            var tr = "<tr>" +
                "<td><select class='form-control'><option>Select Category</option></select></td>" +
                "<td><input type='number' min='0' max='99999' step='1' class='form-control'></td>" +
                "<td><button class='btn btn-danger' onclick='removeRow(this)'> Remove </button></td>" +
                "</tr>";
            $('#tableTest tbody tr').eq(rowCount).after(tr);
        }
    </script>

</body>

</html>