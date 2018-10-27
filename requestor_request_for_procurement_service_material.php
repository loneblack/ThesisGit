<!DOCTYPE html>
<html lang="en">
<?php
require_once("db/mysql_connect.php");
$_SESSION['previousPage'] = "requestor_request_for_procurement_service_material.php";
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
                    Welcome Requestor!
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
                                            <form class="cmxform form-horizontal " id="signupForm" method="get" action="">
                                                <section>
                                                    <h4>Contact Information</h4>

                                                    <div class="form-group ">
                                                        <label for="department" class="control-label col-lg-3">Department</label>
                                                        <div class="col-lg-6">
                                                            <select name="department" id="department"class="form-control m-bot15" required>
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
                                                            <input class="form-control" rows="5" id="unitHead" style="resize:none" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="contactPerson" class="control-label col-lg-3">Contact Person</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" id="contactPerson" name="contactPerson" type="text" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="Email" class="control-label col-lg-3">Email (DLSU)</label>
                                                        <div class="col-lg-6">
                                                            <input name="email" id="email" class="form-control" type="email" pattern=".+dlsu.edu.ph" size="30" required />
                                                        </div>
                                                    </div>

                                                    <div class="form-group ">
                                                        <label for="number" class="control-label col-lg-3">Contact Number</label>
                                                        <div class="col-lg-6">
                                                            <input class=" form-control" id="number" name="number" type="text" />
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
                                                            <input class="form-control" id="dateNeeded" name="dateNeeded" type="date" />
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
                                                              <textarea class="form-control" rows="5" id="comment"  style="resize: none" required></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>

                                                <hr>

                                                <section>
                                                    <h4>Requested Services/Materials</h4>
                                                    <table class="table-bordered" align="center" id="tblRequest" border="1">
                                                        <thead>
                                                            <tr>
                                                                <th>Quantity</th>
                                                                <th style="width:47%">Category dropdown</th>
                                                                <th>Description</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="col-lg-12">
                                                                        <input class="form-control" type="number" id="quantity" min="1" step="1" placeholder="Quantity" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="col-lg-12">
                                                                        <select class="form-control" id="category">
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
                                                                        <input class="form-control" type="text" id="description" placeholder="Item description" />
                                                                    </div>
                                                                </td>
                                                                <td style="text-align:center"><input class="btn btn-primary" type="button" onclick="Add()" value="Add" /></td>
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

    <!--Function for table-->
    <script type="text/javascript">

        function Add() {
            var description = document.getElementById("description");
            var quantity = document.getElementById("quantity");
            var categoryValue = document.getElementById("category");
            var categoryText = categoryValue.options[categoryValue.selectedIndex].text;
            AddRow(description.value, quantity.value, categoryValue.value, categoryText);
            description.value = "";
            quantity.value = "";
            categoryValue.value = "";
            categoryText = "";

        };

        function Remove(button) {
            //Determine the reference of the Row using the Button.
            var row = button.parentNode.parentNode;
            var name = row.getElementsByTagName("TD")[0].innerHTML;
            if (confirm("Remove " + name)) {

                //Get the reference of the Table.
                var table = document.getElementById("tblRequest");

                //Delete the Table row using it's Index.
                table.deleteRow(row.rowIndex);
            }
        };

        function AddRow(description, quantity, categoryValue, categoryText) {
            //Get the reference of the Table's TBODY element.
            var tBody = document.getElementById("tblRequest").getElementsByTagName("TBODY")[0];

            //Add Row.
            row = tBody.insertRow(-1);
            
            
            var cell = row.insertCell(-1);
            cell.innerHTML = "<td>" + quantity + "</td>";
            
           
            cell = row.insertCell(-1);
            cell.innerHTML = "<td>" + categoryText + "</td>";

            cell = row.insertCell(-1);
            cell.innerHTML = "<td>" + categoryValue + "</td>";
            cell.setAttribute("style", "display: none")

            
            cell = row.insertCell(-1);
            cell.innerHTML = "<td>" + description + "</td>";

            //Add Button cell.
            cell = row.insertCell(-1);
            var btnRemove = document.createElement("INPUT");
            btnRemove.type = "button";
            btnRemove.value = "Remove";
            btnRemove.setAttribute("onclick", "Remove(this);");
            btnRemove.setAttribute("class", "btn btn-primary");
            cell.appendChild(btnRemove);
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

        function getData(tableID) {

            var department = document.getElementById('department').value
            var unitHead = document.getElementById('unitHead').value
            var contactPerson = document.getElementById('contactPerson').value
            var email = document.getElementById('email').value
            var number = document.getElementById('number').value
            var buildingID = document.getElementById('buildingID').value
            var FloorAndRoomID = document.getElementById('FloorAndRoomID').value
            var dateNeeded = document.getElementById('dateNeeded').value
            var recipient = document.getElementById('recipient').value
            var comment = document.getElementById('comment').value

            var quantityArray = []; 
            var categoryArray = []; 
            var descriptionArray = []; 
             var table = $("table tbody");

    table.find('tr').each(function (i) {
        var $tds = $(this).find('td'),
            quantity = $tds.eq(0).text(),
            category = $tds.eq(2).text(),
            description = $tds.eq(3).text();

            quantityArray.push(quantity);
            categoryArray.push(category);
            descriptionArray.push(description);
        });

         $.ajax({
            type:"POST",
            url:"requestor_request_for_procurement_service_material_DB.php",
            data: {quantityArray: quantityArray, categoryArray: categoryArray, descriptionArray: descriptionArray, department: department, unitHead: unitHead, contactPerson: contactPerson, email: email, number: number, buildingID: buildingID, FloorAndRoomID: FloorAndRoomID, dateNeeded: dateNeeded, recipient: recipient, comment: comment},
            success: function(data){
                alert(data);
                window.location="requestor_request_for_procurement_service_material.php";
            

                }
            });
         }
    </script>

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

</body>

</html>