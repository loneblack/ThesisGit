<!DOCTYPE html>
<html lang="en">

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
                                        Service Equipment Request 
                                    </header>
                                    <div class="panel-body">
                                        <div class="form" method="post">
                                            <form class="cmxform form-horizontal " id="signupForm" method="get" action="">
                                                <div class="form-group ">
                                                    <label for="serviceType" class="control-label col-lg-3">Office/Department/School Organization</label>
                                                    <div class="col-lg-6">
                                                        <select name="serviceType" class="form-control m-bot15">
                                                            <option>Select</option>
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="number" class="control-label col-lg-3">Contact No.</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" rows="5" name="details" style="resize:none" type="text" required></input>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="dateNeeded" class="control-label col-lg-3">Date & time needed</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" id="dateNeeded" name="dateNeeded" type="datetime-local" />
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="endDate" class="control-label col-lg-3">End date & time</label>
                                                    <div class="col-lg-6">
                                                        <input class=" form-control" id="endDate" name="endDate" type="datetime-local" />
                                                    </div>
                                                </div>
												<div class="form-group ">
                                                    <label for="purpose" class="control-label col-lg-3">Purpose</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" id="purpose" name="purpose" type="text" />
                                                    </div>
                                                </div>
												<div class="form-group ">
                                                    <label for="building" class="control-label col-lg-3">Building</label>
                                                    <div class="col-lg-6">
                                                        <select name="building" class="form-control m-bot15">
                                                            <option>Select building</option>
                                                            
                                                        </select>
                                                    </div>
                                                </div>
												<div class="form-group">
													<label for="floorRoom" class="control-label col-lg-3">Floor & Room</label>
													<div class="col-lg-6">
														<select name="floorRoom" class="form-control m-bot15">
															<option>Select floor & room</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label for="tblCustomers" class="control-label col-lg-3">Equipment to be borrowed</label>
													
													<table id="tblCustomers" cellpadding="0" cellspacing="0" border="1">
														<thead>
															<tr>
																<th>Equipment</th>
																<th>Quantity</th>
																<th></th>
															</tr>
														</thead>
														<tbody>
														</tbody>
														<tfoot>
															<tr>
																<td><input type="text" id="txtName"/></td>
																<td><input type="number" min="1" id="txtCountry" /></td>
																<td><input type="button" onclick="Add()" value="Add" /></td>
															</tr>
														</tfoot>
													</table>
												</div>
												<hr>
												<h4>Endorsement (if applicable)</h4>
												<div class="form-group ">
                                                    <label for="representative" class="control-label col-lg-3">Representative</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" id="representative" name="representative" type="text" />
                                                    </div>
                                                </div>
												<div class="form-group ">
                                                    <label for="idNum" class="control-label col-lg-3">ID Number</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" id="idNum" name="idNum" type="text" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-offset-3 col-lg-6">
                                                        <button class="btn btn-primary" type="submit">Save</button>
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
            cell.appendChild(btnRemove);
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