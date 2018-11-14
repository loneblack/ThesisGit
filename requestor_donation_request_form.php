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
                                        Donation Request
                                    </header>
                                    <div class="panel-body">
                                        <div class="form" method="post">
                                            <form class="cmxform form-horizontal " id="signupForm" method="get" action="">
                                                <div class="form-group ">
                                                    <label class="control-label col-lg-3">Affiliation</label>
                                                    <div class="col-lg-6">
                                                        <select class="form-control" id="ddl1" onchange="checkvalue(this.value)">
                                                            <option value="0">Select Affiliation</option>
                                                            <option value="1">Office</option>
                                                            <option value="2">Department</option>
                                                            <option value="3">School Organization</option>
                                                        </select>
                                                    </div>
                                                </div>



                                                <div class="form-group" id="office" style="display:none">
                                                    <label class="control-label col-lg-3"></label>
                                                    <div class="col-lg-6">
                                                        <select class="form-control" id="office">
                                                            <option>Select Office</option>
                                                            <?php

                                                                            $sql = "SELECT * FROM thesis.offices;";

                                                                            $result = mysqli_query($dbc, $sql);

                                                                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                                            {
                                                                                    
                                                                                echo "<option value ={$row['officeID']}>";
                                                                                echo "{$row['Name']}</option>";

                                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group" id="department" style="display:none">
                                                    <label class="control-label col-lg-3"></label>
                                                    <div class="col-lg-6">
                                                        <select class="form-control" id="office">
                                                            <option>Select Department</option>
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
                                                
                                                <div class="form-group" id="org" style="display:none">
                                                    <label class="control-label col-lg-3"></label>
                                                    <div class="col-lg-6">
                                                        <select class="form-control" id="office">
                                                            <option>Org Itu</option>
                                                        </select>
                                                    </div>
                                                </div>






                                                <div class="form-group ">
                                                    <label for="number" class="control-label col-lg-3">Contact No.</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" rows="5" name="details" style="resize:none" type="text" required>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="dateNeeded" class="control-label col-lg-3">Date & time needed</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" id="dateNeeded" name="dateNeeded" type="datetime-local" />
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="purpose" class="control-label col-lg-3">Purpose</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" id="purpose" name="purpose" type="text" />
                                                    </div>
                                                </div>

                                                <hr>
                                                <div class="container-fluid">
                                                    <h4>Requested Equipment</h4>

                                                    <table style="width:670px" class="table table-bordered table-striped table-condensed table-hover" id="tblCustomers" align="center" cellpadding="0" cellspacing="0" border="1">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:500px">Equipment</th>
                                                                <th style="width:150px">Quantity</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td>
                                                                    <select class="form-control" id="txtName">
                                                                        <option>Select</option>
                                                                    </select>
                                                                </td>
                                                                <td><input class="form-control" type="number" min="1" id="txtCountry" /></td>
                                                                <td style="text-align:center"><input class="btn btn-primary" type="button" onclick="Add()" value="Add" /></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <hr>
                                                <div class="container-fluid">

                                                    <div class="form-group">
                                                        <div class="col-lg-offset-3 col-lg-6">
                                                            <button class="btn btn-primary" type="submit">Save</button>
                                                            <button class="btn btn-default" type="button">Cancel</button>
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

    <!--Script for table -->
    <script type="text/javascript">
        window.onload = function() {
            //Build an array containing Customer records.
            var customers = new Array();


            //Add the data rows.
            for (var i = 0; i < customers.length; i++) {
                AddRow(customers[i][0], customers[i][1]);
            }
        };

        function Add() {
            var txtName = document.getElementById("txtName");
            var txtCountry = document.getElementById("txtCountry");
            AddRow(txtName.value, txtCountry.value);
            txtName.value = "";
            txtCountry.value = "";
        };

        function Remove(button) {
            //Determine the reference of the Row using the Button.
            var row = button.parentNode.parentNode;
            var name = row.getElementsByTagName("TD")[0].innerHTML;
            if (confirm("Remove: " + name)) {

                //Get the reference of the Table.
                var table = document.getElementById("tblCustomers");

                //Delete the Table row using it's Index.
                table.deleteRow(row.rowIndex);
            }
        };

        function AddRow(name, country) {
            //Get the reference of the Table's TBODY element.
            var tBody = document.getElementById("tblCustomers").getElementsByTagName("TBODY")[0];

            //Add Row.
            row = tBody.insertRow(-1);

            //Add Name cell.
            var cell = row.insertCell(-1);
            cell.innerHTML = name;

            //Add Country cell.
            cell = row.insertCell(-1);
            cell.innerHTML = country;

            //Add Button cell.
            cell = row.insertCell(-1);
            var btnRemove = document.createElement("INPUT");
            btnRemove.type = "button";
            btnRemove.value = "Remove";
            btnRemove.setAttribute("onclick", "Remove(this);");
            btnRemove.setAttribute("class", "btn btn-primary");
            btnRemove.setAttribute("style", "text-align:center");

            cell.appendChild(btnRemove);
        }

        function getRooms(val) {
            $.ajax({
                type: "POST",
                url: "requestor_getRooms.php",
                data: 'buildingID=' + val,
                success: function(data) {
                    $("#FloorAndRoomID").html(data);

                }
            });
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