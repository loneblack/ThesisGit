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
                    <div class="col-sm-12">

                        <div class="row">
                            <div class="col-sm-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        Hardware/Software Request Form
                                    </header>
                                    <div class="panel-body">
                                        <h4>Requested Services/Materials</h4>
											<table class="table table-bordered table-striped table-condensed table-hover" align="center" id="tblCustomers" cellpadding="0" cellspacing="0" border="1">
												<thead>
													<tr>
														<th>Hardware/Software</th>
														<th style="width:105px">Quantity</th>
														<th style="width:125px">Estimated Cost</th>
														<th>Budget Source</th>
														<th>Recommended Supplier</th>
														<th></th>
													</tr>
												</thead>
												<tbody>
												</tbody>
												<tfoot>
													<tr>
														<td><input class="form-control"  type="text" id="items" /></td>
														<td><input class="form-control"  type="number" id="txtCountry" min="1" step="1" /></td>
														<td><input class="form-control"  type="number" id="txtName" min="0.01" step="0.01"/></td>
														<td><input class="form-control"  type="text" id="amount"  /></td>
														<td>
															<select class="form-control" name="supplier" id="supplier">
																<option>Select Supplier</option>
																<option value="23">23</option>
																<option value="supplier">Supplier</option>
															</select>
														</td>
														<td style="width:20px;text-align:center"><input type="button" class="btn btn-primary" onclick="Add()" value="Add" /></td>
													</tr>
												</tfoot>
											</table>
											
											<h4>Additional Details</h4>
											<table class="table table-bordered table-striped table-condensed table-hover" align="center" id="additionalDetails" cellpadding="0" cellspacing="0" border="1">
												<thead>
													<tr>
														<th>Course</th>
														<th>Offerings Per Year</th>
														<th>Students Per Section</th>
														<th>Section Per Term</th>
														<th>Section Per Year</th>
														<th></th>
													</tr>
												</thead>
												<tbody>
												</tbody>
												<tfoot>
													<tr>
														<td style="width:225px"><input class="form-control"  type="text" id="course"/></td>
														<td><input class="form-control"  type="number" id="offeringYear" min="1"/></td>
														<td><input class="form-control"  type="number" min="1" id="students"/></td>
														<td><input class="form-control"  type="number" min="1" id="sectionTerm" /></td>
														<td><input class="form-control"  type="number" min="1" id="sectionYear" /></td>
														<td style="width:20px;text-align:center"><input type="button" class="btn btn-primary" onclick="Add1()" value="Add" /></td>
													</tr>
												</tfoot>
											</table>
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


    <!--Function for table-->
    <script type="text/javascript">
        window.onload = function() {
            //Build an array containing Customer records.
            var customers = new Array();

            //Add the data rows.
            for (var i = 0; i < customers.length; i++) {
                AddRow(customers[i][0], customers[i][1], customers[i][2]);
            }
        };

        function Add() {
			var items = document.getElementById("items");
            var txtName = document.getElementById("txtName");
            var txtCountry = document.getElementById("txtCountry");
            var amount = document.getElementById("amount");
			var supplier = document.getElementById("supplier");
			
            AddRow(items.value, txtCountry.value, txtName.value, amount.value, supplier.value);
			
			items.value="";
            txtName.value = "";
            txtCountry.value = "";
            amount.value = "";
			supplier.value="";
        };

        function Remove(button) {
            //Determine the reference of the Row using the Button.
            var row = button.parentNode.parentNode;
            var name = row.getElementsByTagName("TD")[0].innerHTML;
            if (confirm("Remove " + name)) {

                //Get the reference of the Table.
                var table = document.getElementById("tblCustomers");

                //Delete the Table row using it's Index.
                table.deleteRow(row.rowIndex);
            }
        };

        function AddRow(items, name, country, amount, supplier) {
            //Get the reference of the Table's TBODY element.
            var tBody = document.getElementById("tblCustomers").getElementsByTagName("TBODY")[0];

            //Add Row.
            row = tBody.insertRow(-1);
			
			//Add items cell.
			var cell = row.insertCell(-1);
			cell.innerHTML = items;

            //Add Name cell.
            cell = row.insertCell(-1);
            cell.innerHTML = name;

            //Add Country cell.
            cell = row.insertCell(-1);
            cell.innerHTML = country;

            //Add Country cell.
            cell = row.insertCell(-1);
            cell.innerHTML = amount;
			
			//Add Supplier cell.
            cell = row.insertCell(-1);
            cell.innerHTML = supplier;

            //Add Button cell.
            cell = row.insertCell(-1);
            var btnRemove = document.createElement("INPUT");
            btnRemove.type = "button";
            btnRemove.value = "Remove";
            btnRemove.setAttribute("onclick", "Remove(this);");
			btnRemove.setAttribute("class", "btn btn-primary");
            cell.appendChild(btnRemove);
        }
    </script>
    
<!--Function for table 2-->
    <script type="text/javascript">
        window.onload = function() {
            //Build an array containing Customer records.
            var customers = new Array();

            //Add the data rows.
            for (var i = 0; i < customers.length; i++) {
                AddRow(customers[i][0], customers[i][1], customers[i][2]);
            }
        };

        function Add1() {
            var course = document.getElementById("course");
            var offeringYear = document.getElementById("offeringYear");
            var students = document.getElementById("students");
			var sectionTerm = document.getElementById("sectionTerm");
			var sectionYear = document.getElementById("sectionYear");
			//course, offeringYear, students, sectionTerm, sectionYear
			
            AddRow1(course.value, offeringYear.value, students.value, sectionTerm.value, sectionYear.value);
            course.value = "";
            offeringYear.value = "";
            students.value = "";
			sectionTerm.value="";
			sectionYear.value="";
        };

        function Remove1(button) {
            //Determine the reference of the Row using the Button.
            var row = button.parentNode.parentNode;
            var name = row.getElementsByTagName("TD")[0].innerHTML;
            if (confirm("Remove " + course)) {

                //Get the reference of the Table.
                var table = document.getElementById("additionalDetails");

                //Delete the Table row using it's Index.
                table.deleteRow(row.rowIndex);
            }
        };

        function AddRow1(course, offeringYear, students, sectionTerm, sectionYear) {
            //Get the reference of the Table's TBODY element.
            var tBody = document.getElementById("additionalDetails").getElementsByTagName("TBODY")[0];

            //Add Row.
            row = tBody.insertRow(-1);

            //Add Name cell.
            var cell = row.insertCell(-1);
            cell.innerHTML = course;

            //Add Country cell.
            cell = row.insertCell(-1);
            cell.innerHTML = offeringYear;

            //Add Country cell.
            cell = row.insertCell(-1);
            cell.innerHTML = students;
			
			//Add Section Per Term cell.
            cell = row.insertCell(-1);
            cell.innerHTML = sectionTerm;
			
			//Add Section Per Year cell.
            cell = row.insertCell(-1);
            cell.innerHTML = sectionYear;

            //Add Button cell.
            cell = row.insertCell(-1);
            var btnRemove1 = document.createElement("INPUT");
            btnRemove1.type = "button";
            btnRemove1.value = "Remove";
            btnRemove1.setAttribute("onclick", "Remove1(this);");
			btnRemove1.setAttribute("class", "btn btn-primary");
            cell.appendChild(btnRemove1);
        }
    </script>
</body>

</html>