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
                                                            <select name="department" class="form-control m-bot15">
                                                                <option>Select department</option>
                                                                <option>IT</option>
                                                                <option>Philosophy</option>
                                                                <option>Yes</option>
                                                                <option>test</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="unitHead" class="control-label col-lg-3">Unit Head/Fund Owner</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" rows="5" name="details" style="resize:none" type="text">
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
                                                    <h4>Delivery Information</h4>
                                                    <div class="form-group ">
                                                        <label for="building" class="control-label col-lg-3">Building</label>
                                                        <div class="col-lg-6">
                                                            <select name="building" class="form-control m-bot15">
                                                                <option>Select department</option>
                                                                <option>Angelo King International Center</option>
                                                                <option>Br. Andrew B. Gonzalez FSC Hall (AGH)</option>
                                                                <option>Br. Celba John FSC Hall (JH)</option>
                                                                <option>Br. Gabriel Connon FSC Hall (CH)</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="floorRoom" class="control-label col-lg-3">Floor & Room Number</label>
                                                        <div class="col-lg-6">
                                                            <input class=" form-control" id="floorRoom" name="floorRoom" type="number" min="101" />
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
                                                    <h4>Funding Source</h4>
                                                    <div class="form-group ">
                                                        <label for="accountNum" class="control-label col-lg-3">Account Number</label>
                                                        <div class="col-lg-6">
                                                            <input class=" form-control" id="accountNum" name="accountNum" type="number" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="accountName" class="control-label col-lg-3">Account Name</label>
                                                        <div class="col-lg-6">
                                                            <input class=" form-control" id="accountName" name="accountName" type="text" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="chargeAY" class="control-label col-lg-3">Charged to</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" id="chargeAY" name="chargeAY" type="text" placeholder="Design tentative" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="budget" class="control-label col-lg-3">Budget Encumbrance Amount (For Accounting Use Only)</label>
                                                        <div class="col-lg-6">
                                                            <input class=" form-control" id="budget" name="budget" type="number" min="0.00" step="0.01" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="certified" class="control-label col-lg-3">Certified By</label>
                                                        <div class="col-lg-6">
                                                            <input class=" form-control" id="certified" name="certified" type="text" />
                                                        </div>
                                                    </div>
                                                </section>

                                                <section>
                                                    <h4>Requested Services/Materials</h4>
                                                    <table class="table" align="center" id="tblCustomers" cellpadding="0" cellspacing="0" border="1">
                                                        <thead>
                                                            <tr>
                                                                <th>Description</th>
                                                                <th>Quantity</th>
                                                                <th>Amount</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td><input style="border:0; border-bottom:1px solid gray" type="text" id="txtName" placeholder="Item name" /></td>
                                                                <td><input style="border:0; border-bottom:1px solid gray" type="number" id="txtCountry" min="1" step="1" placeholder="Quantity" /></td>
                                                                <td><input style="border:0; border-bottom:1px solid gray" type="number" id="amount" min="0.01" step="0.01" placeholder="Amount" /></td>
                                                                <td><input type="button" onclick="Add()" value="Add" /></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                    <br>
                                                </section>

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
            var txtName = document.getElementById("txtName");
            var txtCountry = document.getElementById("txtCountry");
            var amount = document.getElementById("amount");
            AddRow(txtName.value, txtCountry.value, amount.value);
            txtName.value = "";
            txtCountry.value = "";
            amount.value = "";
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

        function AddRow(name, country, amount) {
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

            //Add Country cell.
            cell = row.insertCell(-1);
            cell.innerHTML = amount;

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