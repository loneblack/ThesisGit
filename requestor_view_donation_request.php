<!DOCTYPE html>
<html lang="en">

<?php

require_once("db/mysql_connect.php");

$id = $_GET['id'];

$query = "SELECT *, of.Name AS 'office', o.name AS 'organization', de.name AS 'department' FROM thesis.donation d
		 LEFT JOIN organization o
		 ON d.organizationID = o.id
         LEFT JOIN offices of 
         ON d.officeID = of.officeID
         LEFT JOIN department de
         ON d.DepartmentID = de.DepartmentID
         JOIN employee e on d.user_UserID = e.UserID
		 WHERE donationid = {$id};";
		 
$result = mysqli_query($dbc, $query);
//echo $query;
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
    $organizationID = $row['organizationID'];
	$departmentID = $row['DepartmentID'];
	$officeID = $row['officeID'];
	$contactNumber = $row['contactNumber'];
	$dateNeeded = $row['dateNeed'];
	$dateCreated = $row['dateCreated'];
	$purpose = $row['purpose'];
	$office = $row['office'];
	$department = $row['department'];
	$organization = $row['organization'];
	$contactNo = $row['contactNo'];
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
                                        Donation Request
                                    </header>
                                    <div class="panel-body">
                                        <div class="form" method="post">
                                            <form class="cmxform form-horizontal " id="signupForm" method="get" action="">
                                                <div class="form-group ">
                                                    <label for="organization" class="control-label col-lg-3">Office/Department/School Organization</label>
														<?php 
															echo "<label for='organization' class='control-label col-lg-7'>".$office."".$department."".$organization."</label>";
														?>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="number" class="control-label col-lg-3">Contact No.</label>
														<?php 
															echo "<label  for='organization' class='control-label col-lg-7'>".$contactNo."</label>";
														?>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="dateNeeded" class="control-label col-lg-3">Date & time needed</label>
													<?php 
															echo "<label  for='organization' class='control-label col-lg-7'>".$dateNeeded."</label>";
													?>
                                                </div>
												<div class="form-group ">
                                                    <label for="purpose" class="control-label col-lg-3">Purpose</label>
													<?php 
															echo "<label for='organization' class='control-label col-lg-7'>".$purpose."</label>";
													?>
													
                                                </div>
												
                                                <hr>
												<div class="container-fluid">
													<h4>Requested Equipment</h4>
													
													<table style="width:670px" class="table table-bordered table-striped table-condensed table-hover" id="tblCustomers" align="center" cellpadding="0" cellspacing="0" border="1">
														<thead>
															<tr>
																<th style="width:500px">Equipment</th>
																<th style="width:150px">Quantity</th>
															</tr>
														</thead>
														<tbody>
															<?php
																$query2 = "SELECT * FROM thesis.donationdetails dd JOIN ref_assetcategory ac ON dd.assetCategoryID = ac.assetCategoryID WHERE donationID = {$id};";
																$result2 = mysqli_query($dbc, $query2);
																while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
																	$name = $row2['name'];
																	$quantity = $row2['quantity'];
																	
																	echo "
																		<tr>
																			<td>
																				<label style='text-align:center'>".$name."</label>
																			</td>
																			<td>
																				<label style='text-align:center'>".$quantity."</label>
																			</td>
																		</tr>
																		";
																		
																}
															?>
														</tbody>
														<tfoot>
														</tfoot>
													</table>
												</div>
												<hr>
                                                <div class="container-fluid">
    												
                                                    <div class="form-group">
                                                        <div>
                                                            <a href="requestor_dashboard.php"><button class="btn btn-default" type="button">Back</button></a>
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
        window.onload = function () {
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